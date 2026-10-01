<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Classroom;
use App\Models\GuardianCommunication;
use App\Models\GuardianCommunicationRecipient;
use App\Mail\GuardianCommunicationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GuardianCommunicationController extends Controller
{
    public function index()
    {
        $communications = GuardianCommunication::latest()->paginate(10);

        return view(
            'guardian-communications.index',
            compact('communications')
        );
    }

    public function create()
    {
        $guardians = Guardian::orderBy('first_name')->get();

        $classrooms = Classroom::orderBy('name')->get();

        return view(
            'guardian-communications.create',
            compact('guardians', 'classrooms')
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'type' => 'required',
        'recipient_type' => 'required',

        'classroom_id' => 'nullable|exists:classrooms,id',
        'guardian_id' => 'nullable|exists:guardians,id',
    ]);

    // Save Communication
    $communication = GuardianCommunication::create([
        'title' => $request->title,
        'subject' => $request->subject,
        'message' => $request->message,
        'type' => $request->type,
        'recipient_type' => $request->recipient_type,
        'classroom_id' => $request->classroom_id,
        'created_by' => Auth::id(),
        'sent_at' => now(),
    ]);

    /*
    |--------------------------------------------------------------------------
    | Determine Recipients
    |--------------------------------------------------------------------------
    */

    if ($request->recipient_type == 'all') {

        $guardians = Guardian::whereNotNull('email')->get();

    } elseif ($request->recipient_type == 'class') {

        $guardians = Guardian::whereHas('students', function ($query) use ($request) {

            $query->where('classroom_id', $request->classroom_id);

        })->whereNotNull('email')->get();

    } elseif ($request->recipient_type == 'individual') {

        $guardians = Guardian::where('id', $request->guardian_id)
            ->whereNotNull('email')
            ->get();

    } else {

        $guardians = collect();
    }

    /*
    |--------------------------------------------------------------------------
    | Send Emails
    |--------------------------------------------------------------------------
    */

    foreach ($guardians as $guardian) {

        try {

            Mail::to($guardian->email)
                ->send(new GuardianCommunicationMail($communication));

            GuardianCommunicationRecipient::create([

                'guardian_communication_id' => $communication->id,

                'guardian_id' => $guardian->id,

                'email' => $guardian->email,

                'status' => 'Sent',

                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {

            GuardianCommunicationRecipient::create([

                'guardian_communication_id' => $communication->id,

                'guardian_id' => $guardian->id,

                'email' => $guardian->email,

                'status' => 'Failed',
            ]);

        }

    }

    return redirect()
        ->route('guardian-communications.index')
        ->with('success', 'Communication sent successfully.');
}

    public function show(GuardianCommunication $guardianCommunication)
    {
        return view(
            'guardian-communications.show',
            compact('guardianCommunication')
        );
    }

    public function edit(GuardianCommunication $guardianCommunication)
    {
        $guardians = Guardian::all();

        $classrooms = Classroom::all();

        return view(
            'guardian-communications.edit',
            compact(
                'guardianCommunication',
                'guardians',
                'classrooms'
            )
        );
    }

    public function update(Request $request, GuardianCommunication $guardianCommunication)
    {

    }

    public function destroy(GuardianCommunication $guardianCommunication)
    {
        $guardianCommunication->delete();

        return redirect()
            ->route('guardian-communications.index')
            ->with('success', 'Communication deleted successfully.');
    }

    public function send(GuardianCommunication $guardianCommunication)
{
    /*
    |--------------------------------------------------------------------------
    | Determine Recipients
    |--------------------------------------------------------------------------
    */

    if ($guardianCommunication->recipient_type == 'all') {

        $guardians = Guardian::whereNotNull('email')->get();

    } elseif ($guardianCommunication->recipient_type == 'class') {

        $guardians = Guardian::whereHas('students', function ($query) use ($guardianCommunication) {

            $query->where('classroom_id', $guardianCommunication->classroom_id);

        })->whereNotNull('email')->get();

    } elseif ($guardianCommunication->recipient_type == 'individual') {

        $recipient = $guardianCommunication->recipients()->first();

        if (!$recipient) {

            return back()->with('error', 'No guardian found for this communication.');
        }

        $guardians = Guardian::where('id', $recipient->guardian_id)
            ->whereNotNull('email')
            ->get();

    } else {

        return back()->with('error', 'Invalid recipient type.');
    }

    /*
    |--------------------------------------------------------------------------
    | Send Emails
    |--------------------------------------------------------------------------
    */

    foreach ($guardians as $guardian) {

        try {

            Mail::to($guardian->email)
                ->send(new GuardianCommunicationMail($guardianCommunication));

            GuardianCommunicationRecipient::updateOrCreate(

                [
                    'guardian_communication_id' => $guardianCommunication->id,
                    'guardian_id' => $guardian->id,
                ],

                [
                    'email' => $guardian->email,
                    'status' => 'Sent',
                    'sent_at' => now(),
                ]

            );

        } catch (\Exception $e) {

            GuardianCommunicationRecipient::updateOrCreate(

                [
                    'guardian_communication_id' => $guardianCommunication->id,
                    'guardian_id' => $guardian->id,
                ],

                [
                    'email' => $guardian->email,
                    'status' => 'Failed',
                ]

            );
        }
    }

    $guardianCommunication->update([
        'sent_at' => now(),
    ]);

    return redirect()
        ->route('guardian-communications.index')
        ->with('success', 'Communication sent successfully.');
}
}