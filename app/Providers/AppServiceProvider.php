<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Teacher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot()
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'student') {
                $student = Student::where('email', $user->email)->first();
                $view->with('student', $student);
            }

            if ($user->role === 'teacher') {
                $teacher = Teacher::where('email', $user->email)->first();
                $view->with('teacher', $teacher);
            }
        }
    });

     
  
}

}
