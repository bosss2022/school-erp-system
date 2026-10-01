<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Student;

class StudentReportController extends Controller
{
    public function index(Request $request)
    {
        // Get currently logged-in student's record
        $student = Student::where('email', auth()->user()->email)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No student record found for your account.');
        }

        // Load student's marks with subjects and exams
        $student->load(['marks.subject', 'marks.exam']);

        // Group marks by exam for easy display
        $exams = $student->marks->groupBy('exam.name');

        // Calculate totals and averages per exam
        $reports = [];
        foreach ($exams as $examName => $marks) {
            $totalMarks = $marks->sum('marks');
            $subjectCount = $marks->count();
            $average = $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0;

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

            $reports[] = [
                'exam' => $examName,
                'marks' => $marks,
                'total' => $totalMarks,
                'average' => $average,
                'grade' => $grade,
            ];
        }

        return view('students.report', compact('student', 'reports'));
    }
}
