<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['classroom', 'guardian']);

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%");
            });
        }

        // 🚻 Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $students = $query->latest()->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        return view('students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admission_no' => 'required|unique:students',
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'gender'       => 'nullable|string|max:10',
            'email'        => 'nullable|email|unique:students|unique:users',
            'phone'        => 'nullable|string|max:20',
            'dob'          => 'nullable|date',
            'address'      => 'nullable|string|max:255',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'guardian_id'  => 'nullable|exists:guardians,id',
        ]);

        // 📸 Upload photo if provided
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        // 👤 Create user
     $user = User::create([
    'name' => trim($data['first_name'] . ' ' . ($data['last_name'] ?? '')),
    'email' => $data['email'],
    'password' => Hash::make($data['admission_no']), // use admission number as password
    'role' => 'student',
]);

        // 🧩 Link user to student
        $data['user_id'] = $user->id;
        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Student and linked user account created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['guardian', 'classroom']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::all();
        return view('students.edit', compact('student', 'classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
         
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:students,email,' . $student->id,
            'phone'        => 'nullable|string|max:20',
            'dob'          => 'nullable|date',
            'address'      => 'nullable|string|max:255',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'guardian_id'  => 'nullable|exists:guardians,id',
            'user_id' =>'nullable',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
                \Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        if ($student->photo && \Storage::disk('public')->exists($student->photo)) {
            \Storage::disk('public')->delete($student->photo);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    // 🎓 Optional: Student dashboard
    public function dashboard()
    {
        $student = auth()->user();
        return view('students.dashboard', compact('student'));
    }
}
