<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SubjectReportController extends Controller
{
    /**
     * Subject Report
     */
    public function index(Request $request)
    {
        $academicYearId = $request->academic_year_id;
        $classroomId = $request->classroom_id;
        $subjectId = $request->subject_id;
        $examId = $request->exam_id;
        $term = $request->term;

        $academicYears = AcademicYear::latest()->get();

        $classrooms = Classroom::orderBy('name')->get();

        // Loaded by AJAX
        $subjects = collect();
        $exams = collect();

        $marks = collect();

        if (
            $academicYearId &&
            $subjectId &&
            $examId
        ) {

            $query = Mark::with([
                'student.classroom',
                'subject',
                'exam'
            ]);

            $query->where('subject_id', $subjectId);

            $query->whereHas('exam', function ($q) use (
                $academicYearId,
                $term,
                $examId
            ) {

                $q->where('academic_year_id', $academicYearId);

                if ($term) {

                    $q->where('term', $term);

                }

                $q->where('id', $examId);

            });

            if ($classroomId) {

                $query->whereHas('student', function ($q) use ($classroomId) {

                    $q->where('classroom_id', $classroomId);

                });

            }

            $marks = $query->get();

        }

        $averageMark = $marks->avg('marks');
        $highestMark = $marks->max('marks');
        $lowestMark = $marks->min('marks');
        $totalStudents = $marks->count();

        return view('reports.subject', compact(

            'academicYears',
            'classrooms',
            'subjects',
            'exams',
            'marks',

            'academicYearId',
            'classroomId',
            'subjectId',
            'examId',
            'term',

            'averageMark',
            'highestMark',
            'lowestMark',
            'totalStudents'

        ));
    }


    /**
     * Academic Year -> Terms
     */
    public function getTerms($academicYearId)
    {
        $terms = Exam::where('academic_year_id', $academicYearId)
            ->pluck('term')
            ->unique()
            ->values();

        return response()->json($terms);
    }


    /**
     * Academic Year + Term -> Exams
     */
    public function getExams(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'term' => 'required'
        ]);

        $exams = Exam::where(
                'academic_year_id',
                $request->academic_year_id
            )
            ->where(
                'term',
                $request->term
            )
            ->orderBy('exam_date')
            ->get([
                'id',
                'name',
                'exam_date'
            ]);

        return response()->json($exams);
    }


    /**
     * Classroom -> Subjects
     */
    public function getSubjectsByClassroom($classroomId)
    {
        $subjects = Subject::where(
                'classroom_id',
                $classroomId
            )
            ->orderBy('name')
            ->get([
                'id',
                'name'
            ]);

        return response()->json($subjects);
    }


    /**
     * Download PDF
     */
    public function downloadPdf(Request $request)
    {
        $academicYearId = $request->academic_year_id;
        $classroomId = $request->classroom_id;
        $subjectId = $request->subject_id;
        $examId = $request->exam_id;
        $term = $request->term;

        if (
            !$academicYearId ||
            !$subjectId ||
            !$examId
        ) {

            return back()->with(
                'error',
                'Please select Academic Year, Exam and Subject.'
            );

        }

        $subject = Subject::findOrFail($subjectId);

        $exam = Exam::findOrFail($examId);

        $classroom = $classroomId
            ? Classroom::find($classroomId)
            : null;

        $query = Mark::with([
            'student.classroom',
            'subject',
            'exam'
        ]);

        $query->where(
            'subject_id',
            $subjectId
        );

        $query->whereHas('exam', function ($q) use (

            $academicYearId,
            $term,
            $examId

        ) {

            $q->where(
                'academic_year_id',
                $academicYearId
            );

            if ($term) {

                $q->where(
                    'term',
                    $term
                );

            }

            $q->where(
                'id',
                $examId
            );

        });

        if ($classroomId) {

            $query->whereHas('student', function ($q) use ($classroomId) {

                $q->where(
                    'classroom_id',
                    $classroomId
                );

            });

        }

        $marks = $query->get();

        $averageMark = $marks->avg('marks');
        $highestMark = $marks->max('marks');
        $lowestMark = $marks->min('marks');
        $totalStudents = $marks->count();

        $pdf = Pdf::loadView('reports.subject_pdf', [

            'marks' => $marks,

            'subject' => $subject,

            'exam' => $exam,

            'classroom' => $classroom,

            'averageMark' => $averageMark,

            'highestMark' => $highestMark,

            'lowestMark' => $lowestMark,

            'totalStudents' => $totalStudents

        ]);

        return $pdf->download(

            'Subject_Report_' .
            $subject->name .
            '_' .
            $exam->name .
            '.pdf'

        );
    }
}