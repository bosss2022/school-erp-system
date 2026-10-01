@extends('layouts.app')

@section('content')
@php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Finance;

// Fetch data
$studentCount = Student::count();
$teacherCount = Teacher::count();
$classroomCount = Classroom::count();
$subjectCount = Subject::count();
$examCount = Exam::count();
$financeTotal = Finance::where('type', 'income')->sum('amount');

// Finance breakdown (you can adjust column names to match your table)
$incomeTotal = Finance::where('type', 'income')->sum('amount');
$expenseTotal = Finance::where('type', 'expense')->sum('amount');

// For charts
$studentsPerClass = Classroom::withCount('students')->get();
@endphp

<div class="container">
    <h3 class="mb-4">Admin Dashboard</h3>
    <p>Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> 👋</p>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center text-white bg-primary shadow-sm">
                <div class="card-body p-2">
                    <h6>Leaders</h6>
                    <h3>{{ $studentCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-white bg-success shadow-sm">
                <div class="card-body p-2">
                    <h6>Teachers</h6>
                    <h3>{{ $teacherCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-white bg-info shadow-sm">
                <div class="card-body p-2">
                    <h6>Classes</h6>
                    <h3>{{ $classroomCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-white bg-warning shadow-sm">
                <div class="card-body p-2">
                    <h6>Subjects</h6>
                    <h3>{{ $subjectCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-white bg-danger shadow-sm">
                <div class="card-body p-2">
                    <h6>Exams</h6>
                    <h3>{{ $examCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center text-white bg-dark shadow-sm">
                <div class="card-body p-2">
                    <h6>Total Finances</h6>
                    <h5>Ksh {{ number_format($financeTotal, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>


    {{-- Charts Section --}}
    <div class="row">
        {{-- Students per Class --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Students per Class</strong></div>
                <div class="card-body">
                    <canvas id="studentsBarChart" height="160"></canvas>
                </div>
            </div>
        </div>

        {{-- School Composition --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>School Composition</strong></div>
                <div class="card-body text-center">
                    <canvas id="compositionPieChart" width="220" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Finance Chart --}}
    <div class="row">
        <div class="col-md-6 mx-auto mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light"><strong>Income vs Expenses</strong></div>
                <div class="card-body text-center">
                    <canvas id="financePieChart" width="220" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Bar Chart (Students per Class) ---
    const classNames = @json($studentsPerClass->pluck('name'));
    const studentCounts = @json($studentsPerClass->pluck('students_count'));

    new Chart(document.getElementById('studentsBarChart'), {
        type: 'bar',
        data: {
            labels: classNames,
            datasets: [{
                label: 'Students',
                data: studentCounts,
                backgroundColor: 'rgba(54,162,235,0.7)',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // --- Pie Chart (School Composition) ---
    new Chart(document.getElementById('compositionPieChart'), {
        type: 'pie',
        data: {
            labels: ['Students', 'Teachers', 'Subjects', 'Exams'],
            datasets: [{
                data: [{{ $studentCount }}, {{ $teacherCount }}, {{ $subjectCount }}, {{ $examCount }}],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    // --- Pie Chart (Income vs Expenses) ---
    new Chart(document.getElementById('financePieChart'), {
        type: 'pie',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                data: [{{ $incomeTotal }}, {{ $expenseTotal }}],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection
