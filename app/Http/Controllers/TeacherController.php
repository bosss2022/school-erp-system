<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth;


class TeacherController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::when($search, function ($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('teachers.index', compact('teachers', 'search'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:teachers,email|unique:users,email',
        'phone'      => 'nullable|string|max:20',
        'gender'     => 'nullable|string|max:10',
        'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('teachers', 'public');
    }

    // ✅ Create user first
    $user = User::create([
        'name' => $data['first_name'] . ' ' . $data['last_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['phone']), // 🔒 phone number password
        'role' => 'teacher',
    ]);

    // ✅ Create linked teacher record
    $data['user_id'] = $user->id;
    $teacher = Teacher::create($data);

    return redirect()->route('teachers.index')
        ->with('success', "Teacher '{$teacher->first_name} {$teacher->last_name}' created successfully with linked user account.");
}


    public function show(Teacher $teacher)
    {
        $teacher->load(['subjects.classroom']); // eager load related data
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'nullable|string|max:10',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' =>'nullable',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

public function dashboard()
{
    $teacher = auth()->user();
    return view('teachers.dashboard', compact('teacher'));
}

}
