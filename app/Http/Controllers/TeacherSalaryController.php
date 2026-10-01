<?php

namespace App\Http\Controllers;

use App\Models\TeacherSalary;
use App\Models\Finance;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Add this on top
use Illuminate\Support\Facades\Auth;

class TeacherSalaryController extends Controller
{
   public function index(Request $request)
{
    $user = auth()->user();

    if ($user->role === 'teacher') {
        $teacher = Teacher::where('user_id', $user->id)->first();

        if (!$teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $query = TeacherSalary::with('teacher')->where('teacher_id', $teacher->id);
    } else {
        $query = TeacherSalary::with('teacher');
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('teacher', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->orWhere('month', 'like', "%{$search}%")
          ->orWhere('year', 'like', "%{$search}%");
    }

    $salaries = $query->latest()->paginate(10);
    $totalSalaries = $query->sum('amount');

    return view('finances.teachers.index', compact('salaries', 'totalSalaries'));
}



    public function create()
    {
        $teachers = Teacher::orderBy('first_name')->get();
        return view('finances.teachers.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'year' => 'required|numeric|min:2000',
        ]);

        $data['payment_date'] = now();
        $data['recorded_by'] = Auth::id();

        $salary = TeacherSalary::create($data);

        // 🔹 Get teacher info for better Finance description
        $teacher = Teacher::find($data['teacher_id']);

        Finance::create([
            'type' => 'expense',
            'category' => 'Teacher Salary',
            'amount' => $data['amount'],
            'description' => 'Salary payment for ' . $teacher->first_name . ' ' . $teacher->last_name . '',
                            
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->route('teacher-salaries.index')->with('success', 'Salary recorded successfully.');
    }
      


    public function edit($id)
{
    $salary = TeacherSalary::findOrFail($id);

    $teachers = Teacher::orderBy('first_name')->get();

    return view(
        'finances.teachers.edit',
        compact(
            'salary',
            'teachers'
        )
    );
} 


public function update(Request $request, $id)
{
    $request->validate([
        'teacher_id'   => 'required|exists:teachers,id',
        'amount'       => 'required|numeric|min:0',
        'month'        => 'required|string',
        'year'         => 'required|integer',
        'payment_date' => 'required|date',
    ]);

    $salary = TeacherSalary::findOrFail($id);

    $salary->update([
        'teacher_id'   => $request->teacher_id,
        'amount'       => $request->amount,
        'month'        => $request->month,
        'year'         => $request->year,
        'payment_date' => $request->payment_date,
    ]);

    return redirect()
        ->route('teacher-salaries.index')
        ->with('success', 'Salary updated successfully.');
}
    
  
public function destroy($id)
{
    $salary = TeacherSalary::findOrFail($id);

    $salary->delete();

    return redirect()
        ->route('teacher-salaries.index')
        ->with('success', 'Salary deleted successfully.');
}

public function downloadPDF($id)
{
    $salary = TeacherSalary::with('teacher')->findOrFail($id);

    // Restrict teachers to their own record
    if (auth()->user()->role === 'teacher') {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        if ($salary->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }
    }

    $pdf = Pdf::loadView('finances.teachers.salary_pdf', compact('salary'));
    return $pdf->download('salary-slip-' . $salary->teacher->first_name . '-' . $salary->month . '-' . $salary->year . '.pdf');
}


}
