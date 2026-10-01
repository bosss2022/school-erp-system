<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        $classes = Classroom::all();

        return view('results.index', compact('exams', 'classes'));
    }

   public function show(Request $request)
{
    $request->validate([
        'exam_id' => 'required|exists:exams,id',
        'classroom_id' => 'required|exists:classrooms,id',
    ]);

    $exam = Exam::findOrFail($request->exam_id);

    $classroom = Classroom::with(['students.marks' => function ($query) use ($exam) {
        $query->where('exam_id', $exam->id);
    }, 'students.marks.subject'])->findOrFail($request->classroom_id);

    // Calculate total, average and overall grade
    foreach ($classroom->students as $student) {
        $totalMarks = $student->marks->sum('marks');
        $subjectCount = $student->marks->count();
        $average = $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0;

        // Determine grade
        if ($average >= 80) {
            $grade = 'A';
        } elseif ($average >= 70) {
            $grade = 'B';
        } elseif ($average >= 60) {
            $grade = 'C';
        } elseif ($average >= 50) {
            $grade = 'D';
        } else {
            $grade = 'E';
        }

        // Attach computed values to each student
        $student->total_marks = $totalMarks;
        $student->average = $average;
        $student->overall_grade = $grade;
    }

    return view('results.show', compact('exam', 'classroom'));
}

}
