<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{public function index(Request $request)
{
    $search = $request->input('search');

    $users = \App\Models\User::when($search, function ($query, $search) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('role', 'like', "%{$search}%");
    })->orderBy('created_at', 'desc')->paginate(10);

    return view('users.index', compact('users', 'search'));
}

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }


    public function downloadPdf()
{
    $users = User::orderBy('role')
                ->orderBy('name')
                ->get();

    foreach ($users as $user) {

        $user->default_password = 'N/A';

        if ($user->role == 'student') {

            $student = Student::where('user_id', $user->id)->first();

            if ($student) {
                $user->default_password = $student->admission_no;
            }

        }

        if ($user->role == 'teacher') {

            $teacher = Teacher::where('user_id', $user->id)->first();

            if ($teacher) {
                $user->default_password = $teacher->phone;
            }

        }

        if ($user->role == 'admin') {

            $user->default_password = '******';

            // Or your preferred default admin password
            // $user->default_password = 'admin123';
        }
    }

    $pdf = Pdf::loadView('users.pdf', compact('users'));

    return $pdf->download('System_Users.pdf');
}
}
