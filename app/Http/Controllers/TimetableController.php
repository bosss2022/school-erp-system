<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TimetableController extends Controller
{
public function index()
{
    $timetables = Timetable::with(['classroom', 'subject', 'teacher'])->get();

    $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    $timetables = $timetables
        ->sortBy(function ($item) use ($dayOrder) {
            return array_search($item->day, $dayOrder);
        })
        ->groupBy('classroom_id');

    $days = $dayOrder;

    $timeSlots = [];

    $grouped = [];

    foreach ($timetables as $classroomId => $classTimetables) {

        foreach ($classTimetables as $item) {

            $slot =
                \Carbon\Carbon::parse($item->start_time)->format('h:i A')
                . ' - ' .
                \Carbon\Carbon::parse($item->end_time)->format('h:i A');

            if (!in_array($slot, $timeSlots)) {
                $timeSlots[] = $slot;
            }

            $grouped[$classroomId][$item->day][$slot] = $item;
        }
    }

    return view('timetables.index', compact(
        'timetables',
        'days',
        'timeSlots',
        'grouped'
    ));
}


    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('timetables.create', compact('classrooms', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Timetable::create($validated);

        return redirect()->route('timetables.index')->with('success', 'Timetable entry added.');
    }


    public function show($id)
{
    $timetable =Timetable::with(['classroom', 'subject', 'teacher'])->findOrFail($id);
    return view('timetables.show', compact('timetable'));
}


 public function autoGenerate()
{
    // Clear old timetables
    Timetable::truncate();

    $classrooms = Classroom::all();
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    // Define the full-day schedule including breaks
    $periods = [
        ['start' => '08:00:00', 'end' => '09:00:00'],
        ['start' => '09:00:00', 'end' => '10:00:00'],
        ['start' => '10:00:00', 'end' => '11:00:00', 'break' => true, 'label' => 'Morning Break'],
        ['start' => '11:00:00', 'end' => '12:00:00'],
        ['start' => '12:00:00', 'end' => '13:00:00'],
        ['start' => '13:00:00', 'end' => '14:00:00', 'break' => true, 'label' => 'Lunch Break'],
        ['start' => '14:00:00', 'end' => '15:00:00'],
        ['start' => '15:00:00', 'end' => '16:00:00'],
    ];

    $inserted = 0;

    foreach ($classrooms as $classroom) {
        // Get subjects assigned to this classroom
        $subjects = Subject::where('classroom_id', $classroom->id)->get();

        if ($subjects->isEmpty()) {
            continue; // skip classrooms without subjects
        }

        foreach ($days as $day) {
            foreach ($periods as $period) {
                // Insert breaks as placeholders
                if (!empty($period['break'])) {
                    Timetable::create([
                        'classroom_id' => $classroom->id,
                        'day' => $day,
                        'subject_id' => null,
                        'teacher_id' => null,
                        'start_time' => $period['start'],
                        'end_time' => $period['end'],
                        'is_break' => true,
                        'label' => $period['label'],
                    ]);
                    $inserted++;
                    continue;
                }

                // Pick a subject assigned to this classroom
                $subject = $subjects->random();

                // Only pick a teacher if they’re assigned to this subject
                $teacher = Teacher::where('id', $subject->teacher_id)->first();

                if (!$teacher) {
                    continue; // skip if subject has no teacher assigned
                }

                Timetable::create([
                    'classroom_id' => $classroom->id,
                    'day' => $day,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'start_time' => $period['start'],
                    'end_time' => $period['end'],
                    'is_break' => false,
                    'label' => null,
                ]);
                $inserted++;
            }
        }
    }

    return redirect()->route('timetables.index')
        ->with('success', "Inserted {$inserted} timetable rows (only assigned teachers, subjects & classrooms).");
}

  
 public function downloadPdf()
{
    $timetables = Timetable::with(['classroom', 'subject', 'teacher'])->get();

    $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    $timetables = $timetables
        ->sortBy(function ($item) use ($dayOrder) {
            return array_search($item->day, $dayOrder);
        })
        ->groupBy('classroom_id');

    $days = $dayOrder;

    $timeSlots = [];

    $grouped = [];

    foreach ($timetables as $classroomId => $classTimetables) {

        foreach ($classTimetables as $item) {

            $slot =
                \Carbon\Carbon::parse($item->start_time)->format('h:i A')
                . ' - ' .
                \Carbon\Carbon::parse($item->end_time)->format('h:i A');

            if (!in_array($slot, $timeSlots)) {
                $timeSlots[] = $slot;
            }

            $grouped[$classroomId][$item->day][$slot] = $item;
        }
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('timetables.pdf', compact(
        'timetables',
        'days',
        'timeSlots',
        'grouped'
    ))->setPaper('a4', 'landscape'); // IMPORTANT for timetable

    return $pdf->download('School_Timetable.pdf');
}




}
