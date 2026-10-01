<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth;

class GuardianController extends Controller
{
    

public function index(Request $request)
{
    $user = auth()->user();
    $search = $request->input('search');

    if ($user->role === 'admin') {
        // Admin: view all guardians with optional search
        $guardians = Guardian::with('students')
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
    } 
    elseif ($user->role === 'student') {
        // Student: view their assigned guardian only
        $student = Student::where('user_id', $user->id)
            ->with('guardian.students')
            ->first();

        if ($student && $student->guardian) {
            $guardians = collect([$student->guardian]);
        } else {
            $guardians = collect(); // no guardian assigned
        }
    } 
    else {
        abort(403, 'Unauthorized action.');
    }

    return view('guardians.index', compact('guardians', 'search'));
}


    public function create()
    {
        $students = Student::whereNull('guardian_id')
            ->get()
            ->mapWithKeys(function ($student) {
                return [
                    $student->id => "{$student->first_name} {$student->last_name} ({$student->admission_no})"
                ];
            });

        return view('guardians.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:guardians,email',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
             'relation'   => 'nullable|string|max:100',
            'student_id' => 'nullable|exists:students,id',
        ]);

        // ✅ Create guardian
        $guardian = Guardian::create($data);

        // ✅ Link guardian to student (if any selected)
        if (!empty($data['student_id'])) {
            $student = Student::find($data['student_id']);
            $student->guardian_id = $guardian->id;
            $student->save();
        }

        return redirect()->route('guardians.index')
            ->with('success', 'Guardian added successfully and linked to student.');
    }

    public function show(Guardian $guardian)
    {
        $guardian->load('students');
        return view('guardians.show', compact('guardian'));
    }

 public function edit($id)
{
    $guardian = Guardian::findOrFail($id);

    // Get only students who are unassigned OR currently assigned to this guardian
    $students = Student::whereNull('guardian_id')
        ->orWhere('guardian_id', $guardian->id)
        ->get()
        ->mapWithKeys(function ($student) {
            return [
                $student->id => "{$student->first_name} {$student->last_name} ({$student->admission_no})"
            ];
        });

    return view('guardians.edit', compact('guardian', 'students'));
}


   public function update(Request $request, Guardian $guardian)
{
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:guardians,email,' . $guardian->id,
        'phone'      => 'nullable|string|max:20',
        'address'    => 'nullable|string|max:255',
        'relation'   => 'nullable|string|max:100',
        'student_id' => 'nullable|exists:students,id',
    ]);

    $guardian->update($data);

    if (!empty($data['student_id'])) {
        // Assign the selected student to this guardian
        Student::where('id', $data['student_id'])
            ->update(['guardian_id' => $guardian->id]);
    }

    return redirect()->route('guardians.index')->with('success', 'Guardian updated successfully.');
}


    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect()->route('guardians.index')
            ->with('success', 'Guardian deleted successfully.');
    }
}
