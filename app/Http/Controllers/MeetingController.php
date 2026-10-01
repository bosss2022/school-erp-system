<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\MeetingGuardian;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingInvitationMail;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $meetings = Meeting::latest()
        ->paginate(10);

    return view(
        'meetings.index',
        compact('meetings')
    );
}
    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $classrooms = Classroom::all();

    $guardians = Guardian::all();

    return view(
        'meetings.create',
        compact(
            'classrooms',
            'guardians'
        )
    );
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $meeting = Meeting::create([

        'title' => $request->title,

        'meeting_date' => $request->meeting_date,

        'meeting_time' => $request->meeting_time,

        'venue' => $request->venue,

        'agenda' => $request->agenda,

        'target_type' => $request->target_type,

        'classroom_id' => $request->classroom_id,

        'created_by' => auth()->id(),
    ]);

    // ALL GUARDIANS

    if ($request->target_type == 'all') {

        $guardians = Guardian::all();
    }

    // CLASS GUARDIANS

    elseif ($request->target_type == 'class') {

        $guardians = Guardian::whereHas(
            'students',
            function ($q) use ($request) {

                $q->where(
                    'classroom_id',
                    $request->classroom_id
                );
            }
        )->get();
    }

    // INDIVIDUAL

    else {

        $guardians = Guardian::whereIn(
            'id',
            $request->guardian_ids
        )->get();
    }

    foreach ($guardians as $guardian) {

    MeetingGuardian::create([

        'meeting_id' => $meeting->id,
        'guardian_id' => $guardian->id
    ]);

    if ($guardian->email) {

        Mail::to($guardian->email)
            ->send(
                new MeetingInvitationMail(
                    $meeting,
                    $guardian
                )
            );
    }
}

    return redirect()
        ->route('meetings.index')
        ->with(
            'success',
            'Meeting scheduled successfully.'
        );
}

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
{
    $meeting->load('guardians');

    return view('meetings.show', compact('meeting'));
}
    /**
     * Show the form for editing the specified resource.
     */
  public function edit(Meeting $meeting)
{
    $classrooms = Classroom::all();
    $guardians = Guardian::all();

    return view(
        'meetings.edit',
        compact(
            'meeting',
            'classrooms',
            'guardians'
        )
    );
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meeting $meeting)
{
    $request->validate([
        'title' => 'required',
        'meeting_date' => 'required|date',
        'meeting_time' => 'required',
        'venue' => 'required',
        'target_type' => 'required',
    ]);

    $meeting->update([
        'title' => $request->title,
        'meeting_date' => $request->meeting_date,
        'meeting_time' => $request->meeting_time,
        'venue' => $request->venue,
        'agenda' => $request->agenda,
        'target_type' => $request->target_type,
        'classroom_id' => $request->classroom_id,
    ]);

    return redirect()
        ->route('meetings.index')
        ->with(
            'success',
            'Meeting updated successfully.'
        );
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
{
    // Delete related guardian records first
    $meeting->guardians()->detach();

    // Delete the meeting
    $meeting->delete();

    return redirect()
        ->route('meetings.index')
        ->with(
            'success',
            'Meeting deleted successfully.'
        );
}
}
