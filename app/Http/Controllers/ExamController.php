<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    // -------------------
    // 1️⃣ Existing methods
    // -------------------
   public function index(Request $request)
{
    $search = $request->input('search');

    $exams = Exam::with('academicYear')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('term', 'like', "%{$search}%")
                  ->orWhereHas('academicYear', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        })
        ->latest()
        ->paginate(10);

    return view('exams.index', compact('exams', 'search'));
}
   public function create()
{
    $academicYears = AcademicYear::orderByDesc('start_date')->get();

    return view(
        'exams.create',
        compact('academicYears')
    );
}

     


public function store(Request $request)
{
    $request->validate([
        'academic_year_id' => 'required|exists:academic_years,id',

        'name' => [
            'required',
            Rule::unique('exams')
                ->where(function ($query) use ($request) {
                    return $query
                        ->where('academic_year_id', $request->academic_year_id)
                        ->where('term', $request->term);
                }),
        ],

        'term' => 'required|string|max:50',

        'exam_date' => 'required|date',

    ], [
        'name.unique' => 'This exam already exists for the selected Academic Year and Term.',
    ]);

    Exam::create([
        'academic_year_id' => $request->academic_year_id,
        'name'             => $request->name,
        'term'             => $request->term,
        'exam_date'        => $request->exam_date,
    ]);

    return redirect()
        ->route('exams.index')
        ->with('success', 'Exam created successfully.');
}

    public function show(Exam $exam)
    {
        return view('exams.show', compact('exam'));
    }

   public function edit(Exam $exam)
{
    $academicYears = AcademicYear::orderByDesc('start_date')->get();

    return view(
        'exams.edit',
        compact(
            'exam',
            'academicYears'
        )
    );
}

    public function update(Request $request, Exam $exam)
{
 $request->validate([
    'academic_year_id' => 'required|exists:academic_years,id',

    'name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('exams')
            ->ignore($exam->id)
            ->where(function ($query) use ($request) {
                return $query
                    ->where('academic_year_id', $request->academic_year_id)
                    ->where('term', $request->term);
            }),
    ],

    'term' => 'required|string|max:50',

    'exam_date' => 'required|date',
], [
    'name.unique' => 'This exam already exists for the selected Academic Year and Term.',
]);

    $exam->update($data);

    return redirect()
        ->route('exams.index')
        ->with(
            'success',
            'Exam updated successfully.'
        );
}

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    // -------------------
    // 2️⃣ New report methods
    // -------------------

    /**
     * Show report for a specific exam, filtered by classroom.
     */
 

public function showReport(Request $request)
{
    $academicYears = AcademicYear::orderByDesc('name')->get();

    $classrooms = Classroom::orderBy('name')->get();

    $exam = null;
    $students = collect();

    $academicYearId = $request->academic_year_id;
    $examId = $request->exam_id;
    $classroomId = $request->classroom_id;

    $classroomName = null;

    if ($examId) {

        $exam = Exam::with('academicYear')->findOrFail($examId);

        $marksQuery = Mark::with([
            'student.classroom',
            'subject',
            'exam'
        ])->where('exam_id', $examId);

        if ($classroomId) {

            $marksQuery->whereHas('student', function ($q) use ($classroomId) {

                $q->where('classroom_id', $classroomId);

            });

            $classroomName = Classroom::find($classroomId)?->name;
        }

        $students = $marksQuery
            ->get()
            ->groupBy('student_id');
    }

    return view('exams.report', compact(
        'academicYears',
        'classrooms',
        'exam',
        'students',
        'academicYearId',
        'examId',
        'classroomId',
        'classroomName'
    ));

}


    /**
     * Download exam report as PDF.
     */
  public function downloadReportPdf(Exam $exam, Request $request)
{
    $classroomId = $request->get('classroom_id');
    $term = $request->get('term');

    // Base query
    $marksQuery = Mark::with(['student.classroom', 'subject', 'exam'])
        ->where('exam_id', $exam->id);

    if ($classroomId) {
        $marksQuery->whereHas('student', function ($q) use ($classroomId) {
            $q->where('classroom_id', $classroomId);
        });
    }

    if ($term) {
        $marksQuery->whereHas('exam', function ($q) use ($term) {
            $q->where('term', $term);
        });
    }

    $marks = $marksQuery->get();

    if ($marks->isEmpty()) {
        \Log::info('No marks found for exam ' . $exam->id, [
            'classroom_id' => $classroomId,
            'term' => $term,
        ]);
    }

    $students = $marks->groupBy('student_id');

    // Get class name
    $classroomName = 'All Classes';
    if ($classroomId) {
        $classroom = Classroom::find($classroomId);
        $classroomName = $classroom ? $classroom->name : 'Unknown Class';
    }

    // Term name fallback
    $termName = $term ?? $exam->term ?? 'N/A';

    $pdf = Pdf::loadView('exams.report_pdf', [
        'exam' => $exam,
        'students' => $students,
        'classroomName' => $classroomName,
        'term' => $termName,
    ]);

    return $pdf->download('Exam_Report_' . $exam->academicYear->name  . '.pdf');
}
}  