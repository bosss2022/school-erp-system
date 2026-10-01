<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    // Display all subjects (with search + pagination)
    public function index(Request $request)
{
    if (!auth()->check()) {
        abort(403, 'You are not logged in.');
    }

    $user = auth()->user();
    $search = $request->input('search');
    $subjectsQuery = Subject::with(['teacher', 'classroom']);

    if ($user->role === 'teacher') {
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            abort(403, 'Teacher profile not found.');
        }
        $subjectsQuery->where('teacher_id', $teacher->id);
    } elseif ($user->role === 'student') {
        $student = Student::where('user_id', $user->id)->first();
        if (!$student || !$student->classroom_id) {
            abort(403, 'Student classroom not found.');
        }
        $subjectsQuery->where('classroom_id', $student->classroom_id);
    }

    if ($search) {
        $subjectsQuery->where('name', 'like', "%{$search}%");
    }

    $subjects = $subjectsQuery->latest()->paginate(10)->withQueryString();

    return view('subjects.index', compact('subjects', 'search'));
}

    // Show form to create a subject
    public function create()
    {
        $teachers = Teacher::all();
        $classrooms = Classroom::all();

        return view('subjects.create', compact('teachers','classrooms'));
    }

    // Store new subject
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'classroom_id' => 'nullable|exists:classrooms,id',

            ]);
            // Prevent duplicate subject in same classroom
    $exists = Subject::where('name', $data['name'])
        ->where('classroom_id', $data['classroom_id'])
        ->exists();
          

    if ($exists) {
        return redirect()
             ->route('subjects.index')
            ->with('error', 'Subject already exists for this classroom.');
    }

      

        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
    }

    // Show subject details
    public function show(Subject $subject)
    {
        $subject->load(['teacher', 'classroom']);
        return view('subjects.show', compact('subject'));
    }

    // Show edit form
    public function edit(Subject $subject)
    {
        $teachers = Teacher::all();
        $classrooms = Classroom::all();

        return view('subjects.edit', compact('subject', 'teachers', 'classrooms'));
    }

    // Update subject
    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    // Delete subject
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }




}
