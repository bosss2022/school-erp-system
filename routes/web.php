<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\TeacherSalaryController;
use App\Http\Controllers\GuardianController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SubjectReportController;
use App\Models\Teacher;
use App\Models\Student;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RevisionMaterialController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\GuardianCommunicationController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\FeeStructureDocumentController;


Route::get('/', function () {
   return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])
        ->name('teachers.dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassroomController::class);
     Route::resource('teachers', TeacherController::class);
   Route::resource('subjects', SubjectController::class);
     Route::resource('exams', ExamController::class);
     
      Route::resource('results', ResultController::class);
        Route::resource('guardians',GuardianController::class);
        Route::resource('finances', FinanceController::class);
       Route::resource('student-payments', StudentPaymentController::class); 
       Route::resource('teacher-salaries', TeacherSalaryController::class);  
        Route::resource('users', UserController::class);
        Route::resource('attendances', AttendanceController::class);
        Route::resource('revision-materials',RevisionMaterialController::class);
        Route::resource('meetings',MeetingController::class);
        Route::resource('fee-structures', FeeStructureController::class);
        Route::resource('academic-years',AcademicYearController::class);
        Route::resource('fee-structure-documents',FeeStructureDocumentController::class);


      

      


      

Route::post('/attendances/load-students', [AttendanceController::class, 'loadStudents'])
    ->name('attendances.loadStudents');

    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])
    ->name('attendances.my');
    
 Route::get('/timetables/auto-generate', [TimetableController::class, 'autoGenerate'])
        ->name('timetables.auto-generate');

Route::get('/timetables/download-pdf', [App\Http\Controllers\TimetableController::class, 'downloadPdf'])
    ->name('timetables.download-pdf');

  Route::resource('timetables', TimetableController::class);

 


 Route::get('/students/report', [StudentReportController::class, 'index'])->name('students.report');
 
});
Route::get('/student-payments/{id}/download', [StudentPaymentController::class, 'download'])
    ->name('student-payments.download')
    ->middleware('auth');
 Route::get('teacher-salaries/{id}/download', [TeacherSalaryController::class, 'downloadPDF'])
    ->name('teacher-salaries.download');


   
Route::get('/exam-reports', [ExamController::class, 'showReport'])->name('exams.report');
Route::get('/exams/{exam}/report/pdf', [ExamController::class, 'downloadReportPdf'])
    ->name('exams.report.pdf');


 Route::get('/timetables/auto-generate', [TimetableController::class, 'autoGenerate'])
        ->name('timetables.auto-generate');

// Subject Report
Route::get('/subject-reports', [SubjectReportController::class, 'index'])
    ->name('subject.reports');

Route::get('/subject-reports/pdf', [SubjectReportController::class, 'downloadPdf'])
    ->name('subject.reports.pdf');

// AJAX Routes
Route::get('/reports/academic-year/{id}/terms', [SubjectReportController::class, 'getTerms'])
    ->name('reports.terms');

Route::get('/reports/exams', [SubjectReportController::class, 'getExams'])
    ->name('reports.exams');

Route::get('/subjects-by-classroom/{id}', [SubjectReportController::class, 'getSubjectsByClassroom'])
    ->name('reports.subjects');

Route::get('/marks/classroom/{id}/students', [MarkController::class, 'getStudentsByClassroom'])->name('marks.students');
    Route::get('/report-cards', [ReportCardController::class, 'index'])->name('report-card.index');
    Route::get('/report-cards/{id}', [ReportCardController::class, 'show'])->name('report-card.show');
    Route::get('/report-cards/{id}/download', [ReportCardController::class, 'download'])->name('report-card.download');

    Route::get('/my-results', [ReportCardController::class, 'results'])
    ->name('report-card.results');

 Route::get('/results/cards/results', [ReportCardController::class, 'results'])
        ->name('results.years');

    
  
   Route::get(
    '/report-card/{student}/year/{academicYear}',
    [ReportCardController::class, 'yearResults']
)->name('report-card.year');
 
        Route::get(
    '/results/cards/year-results/{year}',
    [ReportCardController::class, 'yearResults']
)->name('results.year');

Route::get(
    '/report-card/{student}/year/{academicYear}/download',
    [ReportCardController::class, 'downloadYearResults']
)->name('report-card.year.download');

Route::get('/subjects-by-classroom/{classroom_id}', [App\Http\Controllers\MarkController::class, 'getSubjectsByClassroom']);
Route::get('/subjects-by-classroom/{classroom_id}', [App\Http\Controllers\SubjectReportController::class, 'getSubjectsByClassroom']);

Route::get(
    '/marks/academic-year/{id}/terms',
    [MarkController::class, 'getTerms']
)->name('marks.terms');

Route::get(
    '/marks/exams',
    [MarkController::class, 'getExams']
)->name('marks.exams');

Route::get(
    '/subjects-by-classroom/{id}',
    [MarkController::class, 'getSubjectsByClassroom']
)->name('marks.subjects');

Route::get(
    '/marks/classroom/{id}/students',
    [MarkController::class, 'getStudentsByClassroom']
)->name('marks.students');

Route::resource('marks', MarkController::class);
 
Route::get('/exam/{exam}/term', [ExamController::class, 'getExamTerm']);
Route::get('/reports/exam/{examId}/terms', [SubjectReportController::class, 'getTermsByExam']);

Route::get( '/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

Route::get('/promotions', [PromotionController::class, 'index'])
    ->name('promotions.index');

Route::get('/promotions/students/{classroomId}', [PromotionController::class, 'getStudents'])
    ->name('promotions.students');

Route::post('/promotions/promote', [PromotionController::class, 'promote'])
    ->name('promotions.promote');

Route::get('/promotions/history', [PromotionController::class, 'history'])
    ->name('promotions.history');

    Route::post('/meetings/{meeting}/attendance',[MeetingController::class, 'attendance'])
    ->name('meetings.attendance');


Route::resource('guardian-communications', GuardianCommunicationController::class);

Route::post(
    'guardian-communications/{guardianCommunication}/send',
    [GuardianCommunicationController::class,'send']
)->name('guardian-communications.send');


Route::get(
    '/fee-structure/load',
    [StudentPaymentController::class,'loadFeeStructure']
)->name('fee-structure.load');


Route::get('/users/download/pdf',
    [UserController::class, 'downloadPdf'])
    ->name('users.download');



Route::get(
    '/fee-structure-documents/{document}/download',
    [FeeStructureDocumentController::class,'download']
)->name('fee-structure-documents.download');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


 Route::get('/download-fee-structure', [FeeStructureDocumentController::class, 'downloadLatest'])
    ->name('fee-structure.public');
    
require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
