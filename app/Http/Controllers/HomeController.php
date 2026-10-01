<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Http\Controllers\TeacherController;
Use App\Http\Controllers\StudentController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return view('dashboards.admin');
    } elseif ($role === 'teacher') {
        return view ('dashboards.teacher');
    } else {
        return view ('dashboards.student');
    }
}
}
