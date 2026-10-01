<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\AcademicYear;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::with(['exam', 'student', 'subject'])
            ->latest()
            ->paginate(10);

        return view('marks.index', compact('marks'));
    }

    public function create()
{
    $academicYears = AcademicYear::orderByDesc('start_date')->get();

    $classrooms = Classroom::orderBy('name')->get();

    return view(
        'marks.create',
        compact(
            'academicYears',
            'classrooms'
        )
    );
}

    public function getStudentsByClassroom($classroom_id)
    {
        $students = Student::where('classroom_id', $classroom_id)
            ->select('id', 'first_name', 'last_name', 'admission_no')
            ->get();

        return response()->json($students);
    }


    public function getSubjectsByClassroom($classroom_id)
{
    $subjects = Subject::where('classroom_id', $classroom_id)
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    return response()->json($subjects);
}



    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'marks' => 'required|array',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.score' => 'required|integer|min:0|max:100',
        ]);

        foreach ($request->marks as $markData) {
            $marks = $markData['score'];
            $grade = null;

            if ($marks >= 80) $grade = 'A';
            elseif ($marks >= 70) $grade = 'B';
            elseif ($marks >= 60) $grade = 'C';
            elseif ($marks >= 50) $grade = 'D';
            else $grade = 'E';

            Mark::updateOrCreate(
                [
                    'exam_id' => $request->exam_id,
                    'student_id' => $markData['student_id'],
                    'subject_id' => $request->subject_id,
                ],
                [
                    'marks' => $marks,
                    'grade' => $grade,
                ]
            );
        }

        return redirect()->route('marks.index')->with('success', 'Marks recorded successfully.');
    }

    public function show(Mark $mark)
    {
        return view('marks.show', compact('mark'));
    }


public function edit(Mark $mark)
{
    $mark->load([
        'student.classroom',
        'subject',
        'exam.academicYear'
    ]);

    $academicYears = AcademicYear::orderByDesc('start_date')->get();

    $classrooms = Classroom::orderBy('name')->get();

    return view(
        'marks.edit',
        compact(
            'mark',
            'academicYears',
            'classrooms'
        )
    );
}
    public function update(Request $request, Mark $mark)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'nullable|integer|min:0|max:100',
        ]);

        $marks = $data['marks'];
        $grade = null;

        if ($marks >= 80) $grade = 'A';
        elseif ($marks >= 70) $grade = 'B';
        elseif ($marks >= 60) $grade = 'C';
        elseif ($marks >= 50) $grade = 'D';
        else $grade = 'E';

        $data['grade'] = $grade;

        $mark->update($data);

        return redirect()->route('marks.index')->with('success', 'Mark updated successfully.');
    }

    public function destroy(Mark $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Mark deleted successfully.');
    }


    public function getTerms($academicYearId)
{
    $terms = Exam::where('academic_year_id', $academicYearId)
        ->select('term')
        ->distinct()
        ->orderBy('term')
        ->pluck('term');

    return response()->json($terms);
}

  public function getExams(Request $request)
{
    $request->validate([
        'academic_year_id' => 'required|exists:academic_years,id',
        'term' => 'required'
    ]);

    $exams = Exam::where('academic_year_id', $request->academic_year_id)
        ->where('term', $request->term)
        ->orderBy('exam_date')
        ->get([
            'id',
            'name',
            'exam_date'
        ]);

    return response()->json($exams);
}

}
