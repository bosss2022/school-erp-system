<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    // =========================
    // DISPLAY ATTENDANCE LIST
    // =========================
    public function index(Request $request)
    {
        $query = Attendance::with([
            'student',
            'classroom',
            'recorder'
        ]);

        // Filter by classroom
        if ($request->classroom_id) {

            $query->where('classroom_id', $request->classroom_id);
        }

        // Filter by date
        if ($request->date) {

            $query->whereDate('date', $request->date);
        }

        $attendances = $query
            ->latest()
            ->paginate(20);

        $classrooms = Classroom::all();

        return view('attendances.index', compact(
            'attendances',
            'classrooms'
        ));
    }


    // =========================
    // SHOW CREATE FORM
    // =========================
    public function create()
    {
        $classrooms = Classroom::all();

        return view('attendances.create', compact(
            'classrooms'
        ));
    }


    // =========================
    // LOAD STUDENTS BY CLASSROOM
    // =========================
    public function loadStudents(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
        ]);

        $classroom = Classroom::findOrFail(
            $request->classroom_id
        );

        $students = Student::where(
            'classroom_id',
            $request->classroom_id
        )->get();

        return view('attendances.mark', compact(
            'students',
            'classroom'
        ))->with('date', $request->date);
    }


    // =========================
    // STORE ATTENDANCE
    // =========================
    public function store(Request $request)
{
    $request->validate([

        'classroom_id' => 'required|exists:classrooms,id',

        'date' => 'required|date',

        'attendance' => 'required|array',
    ]);


    foreach ($request->attendance as $studentId => $attendanceData) {

        Attendance::updateOrCreate(

            [
                'student_id' => $studentId,

                'date' => $request->date,
            ],

            [
                'classroom_id' => $request->classroom_id,

                'status' => $attendanceData['status'],

                'remarks' => $attendanceData['remarks'] ?? null,

                'recorded_by' => Auth::id(),
            ]
        );
    }


    return redirect()
        ->route('attendances.index')
        ->with('success', 'Attendance recorded successfully.');
}
    // =========================
    // SHOW SINGLE RECORD
    // =========================
    public function show(Attendance $attendance)
    {
        $attendance->load([
            'student',
            'classroom',
            'recorder'
        ]);

        return view('attendances.show', compact(
            'attendance'
        ));
    }


    // =========================
    // EDIT ATTENDANCE
    // =========================
    public function edit(Attendance $attendance)
    {
        $attendance->load('student');

        return view('attendances.edit', compact(
            'attendance'
        ));
    }


    // =========================
    // UPDATE ATTENDANCE
    // =========================
    public function update(Request $request,
                           Attendance $attendance)
    {
        $data = $request->validate([

            'status' => 'required|in:
                present,
                absent,
                late,
                permission',

            'remarks' => 'nullable|string',
        ]);

        $attendance->update($data);

        return redirect()
            ->route('attendances.index')
            ->with('success',
                'Attendance updated successfully.');
    }


    // =========================
    // DELETE ATTENDANCE
    // =========================
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success',
                'Attendance deleted successfully.');
    }

  public function myAttendance()
{
    $user = auth()->user();

    // Find logged-in student
    $student = Student::where('user_id', $user->id)->first();

    if (!$student) {

        abort(403, 'Student profile not found.');
    }

    // Get attendance records
    $attendances = Attendance::where('student_id', $student->id)
        ->latest()
        ->paginate(20);

    return view('attendances.my', compact(
        'student',
        'attendances'
    ));
}
    
}