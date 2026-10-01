<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mark;
use App\Models\Exam;
use App\Models\AcademicYear;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportCardController extends Controller
{
    /**
     * Display report card index.
     */
    public function index()
    {
        $user = Auth::user();

        // Student can only view their own report card
        if ($user->role == 'student') {

            $student = Student::where('user_id', $user->id)->firstOrFail();

            return redirect()->route('report-card.show', $student->id);
        }

        $students = Student::with('classroom')
            ->orderBy('first_name')
            ->paginate(20);

        return view('reports.cards.index', compact('students'));
    }

    /**
     * Display report card.
     */
    public function show($student_id)
    {
        $student = Student::with([
            'classroom',
            'guardian'
        ])->findOrFail($student_id);

        $marks = Mark::with([
                'subject',
                'exam'
            ])
            ->where('student_id', $student_id)
            ->orderBy('subject_id')
            ->get();

        $subjects = [];

        foreach ($marks as $mark) {

            $subjects[] = [

                'subject' => $mark->subject->name,

                'exam' => $mark->exam->name,

                'marks' => $mark->marks,

                'grade' => $this->grade($mark->marks),

                'remark' => $this->remark($mark->marks),

            ];
        }

        $totalMarks = $marks->sum('marks');

        $average = $marks->count()
            ? round($marks->avg('marks'), 2)
            : 0;

        $overallGrade = $this->grade($average);

        $overallRemark = $this->remark($average);

        $position = $this->calculatePosition($student);

        return view(
            'reports.cards.show',
            compact(
                'student',
                'marks',
                'subjects',
                'totalMarks',
                'average',
                'overallGrade',
                'overallRemark',
                'position'
            )
        );
    }

    /**
     * Download PDF Report Card.
     */
    public function download($student_id)
    {
        $student = Student::with([
            'classroom',
            'guardian'
        ])->findOrFail($student_id);

        $marks = Mark::with([
                'subject',
                'exam'
            ])
            ->where('student_id', $student_id)
            ->orderBy('subject_id')
            ->get();

        $subjects = [];

        foreach ($marks as $mark) {

            $subjects[] = [

                'subject' => $mark->subject->name,

                'exam' => $mark->exam->name,

                'marks' => $mark->marks,

                'grade' => $this->grade($mark->marks),

                'remark' => $this->remark($mark->marks),

            ];
        }

        $totalMarks = $marks->sum('marks');

        $average = $marks->count()
            ? round($marks->avg('marks'), 2)
            : 0;

        $overallGrade = $this->grade($average);

        $overallRemark = $this->remark($average);

        $position = $this->calculatePosition($student);

        $pdf = Pdf::loadView(
            'reports.cards.pdf',
            compact(
                'student',
                'marks',
                'subjects',
                'totalMarks',
                'average',
                'overallGrade',
                'overallRemark',
                'position'
            )
        )->setPaper('A4', 'portrait');

        return $pdf->download(
            'ReportCard_' .
            $student->first_name .
            '_' .
            $student->last_name .
            '.pdf'
        );
    }

    /**
     * Calculate Grade.
     */
    private function grade($marks)
    {
        if ($marks >= 80) return 'A';

        if ($marks >= 70) return 'B';

        if ($marks >= 60) return 'C';

        if ($marks >= 50) return 'D';

        return 'E';
    }

    /**
     * Subject Remark.
     */
    private function remark($marks)
    {
        if ($marks >= 80) return 'Excellent';

        if ($marks >= 70) return 'Very Good';

        if ($marks >= 60) return 'Good';

        if ($marks >= 50) return 'Fair';

        return 'Needs Improvement';
    }

    /**
     * Calculate Student Position in Class.
     */
    private function calculatePosition($student)
    {
        $students = Student::where(
            'classroom_id',
            $student->classroom_id
        )->get();

        $averages = [];

        foreach ($students as $classStudent) {

            $avg = Mark::where(
                    'student_id',
                    $classStudent->id
                )
                ->avg('marks');

            $averages[$classStudent->id] = $avg ?? 0;
        }

        arsort($averages);

        $position = array_search(
            $student->id,
            array_keys($averages)
        );

        return ($position + 1) . ' / ' . count($students);
    }


public function results()
{
    $user = Auth::user();

    if ($user->role != 'student') {
        abort(403);
    }

    $student = Student::where('user_id', $user->id)
        ->firstOrFail();


    $academicYears = AcademicYear::whereIn(
        'id',
        Mark::where('student_id', $student->id)
            ->join(
                'exams',
                'marks.exam_id',
                '=',
                'exams.id'
            )
            ->select('exams.academic_year_id')
            ->distinct()
    )
    ->orderByDesc('start_date')
    ->get();


    return view(
        'reports.cards.results',
        compact(
            'student',
            'academicYears'
        )
    );
}


public function yearResults(Student $student, AcademicYear $academicYear)
{
    $marks = Mark::with([
        'subject',
        'exam'
    ])
    ->where('student_id', $student->id)
    ->whereHas('exam', function ($query) use ($academicYear) {
        $query->where('academic_year_id', $academicYear->id);
    })
    ->orderBy('subject_id')
    ->get();

    if ($marks->isEmpty()) {
        return back()->with('warning', 'No results found for this academic year.');
    }

    $results = $marks->groupBy(function ($mark) {
        return $mark->exam->term;
    });

    return view('reports.cards.year-results', [
        'student'       => $student,
        'academicYear'  => $academicYear,
        'results'       => $results,
    ]);
}

  public function downloadYearResults(Student $student, AcademicYear $academicYear)
{
    $marks = Mark::with([
        'subject',
        'exam'
    ])
    ->where('student_id', $student->id)
    ->whereHas('exam', function ($query) use ($academicYear) {
        $query->where('academic_year_id', $academicYear->id);
    })
    ->orderBy('subject_id')
    ->get();

    $results = $marks->groupBy(function ($mark) {
        return $mark->exam->term;
    });

    $totalMarks = $marks->sum('marks');

    $average = $marks->count()
        ? round($marks->avg('marks'), 2)
        : 0;

    $overallGrade = $this->grade($average);

    $overallRemark = $this->remark($average);

    $position = $this->calculatePosition($student);

    $pdf = Pdf::loadView(
        'reports.cards.year-results-pdf',
        compact(
            'student',
            'academicYear',
            'results',
            'totalMarks',
            'average',
            'overallGrade',
            'overallRemark',
            'position'
        )
    )->setPaper('A4', 'portrait');

    return $pdf->download(
        'ReportCard_' .
        $student->admission_number .
        '_' .
        $academicYear->name .
        '.pdf'
    );
}



}