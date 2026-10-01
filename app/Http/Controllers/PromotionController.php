<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all();

        return view('promotions.index', compact('classrooms'));
    }


   public function getStudents(Request $request, $classroomId)
{
    $classroom = Classroom::findOrFail($classroomId);

    $currentYear = $request->academic_year ?? date('Y');

    $students = Student::where('classroom_id', $classroomId)
        ->where('academic_year', $currentYear)
        ->get();

    // Load all classes except the current one
    $classrooms = Classroom::where('id', '!=', $classroomId)
        ->orderBy('name')
        ->get();

    return view(
        'promotions.students',
        compact(
            'students',
            'classroom',
            'classrooms',
            'currentYear'
        )
    );
}


    public function promote(Request $request)
    {
        $request->validate([

            'student_ids' => 'required|array',

            'from_classroom_id' => 'required',

            'to_classroom_id' => 'required',

             'current_year' => 'required',

             'new_year' => 'required',
        ]);


     foreach ($request->student_ids as $studentId) {

    $student = Student::findOrFail($studentId);

    Promotion::create([

        'student_id' => $student->id,

        'from_classroom_id' => $request->from_classroom_id,

        'to_classroom_id' => $request->to_classroom_id,

        'academic_year' => $request->new_year,

        'promotion_date' => now(),

        'promoted_by' => Auth::id(),
    ]);

    $student->update([

        'classroom_id' => $request->to_classroom_id,

        'academic_year' => $request->new_year,
    ]);
}

        return redirect()
            ->route('promotions.index')
            ->with('success', 'Students promoted successfully.');
    }


    public function history()
    {
        $promotions = Promotion::with([

            'student',

            'fromClassroom',

            'toClassroom',

            'promoter'

        ])->latest()->paginate(20);

        return view('promotions.history', compact('promotions'));
    }
}