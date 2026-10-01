<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Guardian;
use App\Helpers\ActivityLogger;


class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 1️⃣ Check if user exists in users table
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Redirect by role
            if ($user->role === 'teacher') {
                $teacher = Teacher::where('email', $user->email)->first();
                return view('dashboards.teacher', ['teacher' => $teacher]);
            }

            if ($user->role === 'student') {
                $student = Student::where('email', $user->email)->first();
                return view('dashboards.student', ['student' => $student]);
            }

            if ($user->role === 'admin') {
                return view('dashboards.admin');
            }
        }

        // 2️⃣ If not in users, check teachers table
        $teacher = Teacher::where('email', $request->email)->first();
        if ($teacher && Hash::check($request->password, $teacher->password)) {
            // Sync teacher with user account
            $user = User::firstOrCreate(
                ['email' => $teacher->email],
                [
                    'name' => $teacher->first_name . ' ' . $teacher->last_name,
                    'password' => Hash::make($teacher->password),
                    'role' => 'teacher',
                ]
            );

            Auth::login($user);
        $teacherData = Teacher::select('id', 'first_name', 'last_name', 'email', 'photo', 'phone', 'gender')
        ->with([
            'subjects:id,name,teacher_id',
            'classrooms:id,name,teacher_id'
        ])
        ->find($teacher->id);

// Pass only clean data to the view
return view('dashboards.teacher', [
    'teacher' => $teacherData
]);
        }

        // 3️⃣ If not a teacher, check students table
        $student = Student::where('email', $request->email)->first();
        if ($student && Hash::check($request->password, $student->password)) {
            // Sync student with user account
            $user = User::firstOrCreate(
                ['email' => $student->email],
                [
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'password' => Hash::make($student->password),
                    'role' => 'student',
                ]
            );

            Auth::login($user);

                   ActivityLogger::log(
    'Login',
    'User logged into the system'
);
   
            return view('dashboards.student', ['student' => $student]);


        }

        // ❌ If login fails
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
       
 
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {  
        ActivityLogger::log(
    'Logout',
    'User logged out'
);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

           
    
        return redirect()->route('login');

   }
}
