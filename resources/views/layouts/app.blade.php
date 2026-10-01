<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'School System') }}</title>
    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    @stack('scripts')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
            background: #f8f9fa;
        }
        .sidebar {
            width: 240px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .sidebar-header {
            text-align: center;
            padding: 1rem;
            background: #212529;
            font-weight: 600;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .main-content {
            margin-left: 240px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .navbar-custom {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }
        .content { padding: 20px; }
        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar {
    width: 240px;
    background-color: #343a40;
    color: white;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100%;
    overflow-y: auto; /* ✅ allows scrolling when links exceed screen height */
    scrollbar-width: thin; /* (optional) slim scrollbar for Firefox */
}

/* (optional) style scrollbar for Chrome */
.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    background-color: #6c757d;
    border-radius: 3px;
}
.sidebar::-webkit-scrollbar-thumb:hover {
    background-color: #adb5bd;
}

    </style>
</head>
<body>
    {{-- Sidebar --}}
  <div class="sidebar">
    <div class="sidebar-header">
        <i class="fa-solid fa-school me-2"></i>Masu School Of Grace
    </div>


     <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge me-2"></i>Dashboard
        </a>


    {{-- ADMIN LINKS --}}
    @if(auth()->user() && auth()->user()->role === 'admin')
       

{{-- ================= SIDEBAR MENU ================= --}}


{{-- ================= ACADEMICS ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#academicsMenu">

        <span>
            <i class="fa-solid fa-graduation-cap me-2"></i>
            Academics
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('students.*')
        || request()->routeIs('teachers.*')
        || request()->routeIs('guardians.*')
        || request()->routeIs('subjects.*')
        || request()->routeIs('classrooms.*')
        || request()->routeIs('timetables.*')
        ? 'show' : '' }}"
         id="academicsMenu">

        <a href="{{ route('students.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-graduate me-2"></i> Leaders
        </a>

        <a href="{{ route('teachers.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-chalkboard-user me-2"></i> Teachers
        </a>

        <a href="{{ route('guardians.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('guardians.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-shield me-2"></i> Guardians
        </a>

        <a href="{{ route('subjects.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book me-2"></i> Subjects
        </a>

        <a href="{{ route('classrooms.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('classrooms.*') ? 'active' : '' }}">
            <i class="fa-solid fa-school me-2"></i> Classrooms
        </a>

        <a href="{{ route('timetables.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('timetables.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days me-2"></i> Timetable
        </a>
          
        <li>
    <a href="{{ route('academic-years.index') }}"
       class="nav-link ps-5 {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">

        <i class="fa-solid fa-calendar-days me-2"></i>

        Academic Years

    </a>
</li>
    </div>

    

</div>


{{-- ================= STUDENT MANAGEMENT ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#studentManagementMenu">

        <span>
            <i class="fa-solid fa-users me-2"></i>
            Leaders Management
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('attendances.*')
        || request()->routeIs('revision-materials.*')
        || request()->routeIs('promotions.*')
        ? 'show' : '' }}"
         id="studentManagementMenu">

        <a href="{{ route('attendances.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-check me-2"></i> Attendance
        </a>

        <a href="{{ route('revision-materials.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('revision-materials.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines me-2"></i> Revision Materials
        </a>

        <a href="{{ route('promotions.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('promotions.*') ? 'active' : '' }}">
            <i class="fa-solid fa-arrow-up-right-dots me-2"></i> Promotions
        </a>

    </div>

</div>


{{-- ================= EXAMINATION ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#examMenu">

        <span>
            <i class="fa-solid fa-file-pen me-2"></i>
            Examination
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('exams.*')
        || request()->routeIs('marks.*')
        || request()->routeIs('subject.reports')
        ? 'show' : '' }}"
         id="examMenu">

        <a href="{{ route('exams.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('exams.*') ? 'active' : '' }}">
            Manage Exams
        </a>

        <a href="{{ route('marks.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('marks.*') ? 'active' : '' }}">
            Manage Marks
        </a>

        <a href="{{ route('exams.report') }}"
           class="nav-link ps-5">
            Overall Report
        </a>

        <a href="{{ route('subject.reports') }}"
           class="nav-link ps-5">
            Subject Report
        </a>

    </div>

</div>


{{-- ================= FINANCE ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#financeMenu">

        <span>
            <i class="fa-solid fa-money-bill-wave me-2"></i>
            Finance
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('finances.*')
        || request()->routeIs('student-payments.*')
        || request()->routeIs('teacher-salaries.*')
        ? 'show' : '' }}"
         id="financeMenu">

          <a href="{{ route('fee-structures.index') }}"
                   class="nav-link ps-5">
                    Fee Structures
                </a>

          <a href="{{ route('fee-structure-documents.index') }}" 
          class="nav-link ps-5">
        Fee Structure Documents
    </a>

        <a href="{{ route('student-payments.index') }}"
           class="nav-link ps-5">
            Student Finances
        </a>

        <a href="{{ route('teacher-salaries.index') }}"
           class="nav-link ps-5">
            Teacher Finances
        </a>


        <a href="{{ route('finances.index') }}"
           class="nav-link ps-5">
            Overall Finances
        </a>

    </div>

</div>


{{-- ================= COMMUNICATION ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#communicationMenu">

        <span>
            <i class="fa-solid fa-comments me-2"></i>
            Communication
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('meetings.*') ? 'show' : '' }}"
         id="communicationMenu">

        <a href="{{ route('meetings.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('meetings.*') ? 'active' : '' }}">
            Guardian Meetings
        </a>



        <a href="{{ route('guardian-communications.index') }}"
class="nav-link {{ request()->routeIs('guardian-communications.*') ? 'active' : '' }}">

<i class="fa-solid fa-envelope-circle-check me-2"></i>

Guardian Communication

</a>
    </div>

</div>


{{-- ================= ADMINISTRATION ================= --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#adminMenu">

        <span>
            <i class="fa-solid fa-gear me-2"></i>
            Administration
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse
        {{ request()->routeIs('users.*')
        || request()->routeIs('activity-logs.*')
        ? 'show' : '' }}"
         id="adminMenu">

        <a href="{{ route('users.index') }}"
           class="nav-link ps-5">
            Manage Users
        </a>

        <a href="{{ route('activity-logs.index') }}"
           class="nav-link ps-5">
            Activity Logs
        </a>
       
       

    </div>

</div>

    @endif

    {{-- TEACHER LINKS --}}
    @if(auth()->user() && auth()->user()->role === 'teacher')
        
        <a href="{{ route('classrooms.index') }}" class="{{ request()->routeIs('classrooms.*') ? 'active' : '' }}">
            <i class="fa-solid fa-door-open me-2"></i>My Classrooms
        </a>

        <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book me-2"></i>My Subjects
        </a>   

                   <a href="{{ route('timetables.index') }}" class="{{ request()->routeIs('timetables.*') ? 'active' : '' }}">
    <i class="fa-solid fa-calendar-days me-2"></i>Timetable
</a>

           <a href="{{ route('revision-materials.index') }}" class="{{ request()->routeIs('revision-materials.*') ? 'active' : '' }}">
    <i class="fa-solid fa-file-lines me-2"></i>Revision Materials
</a>  


          <a href="{{ route('marks.index') }}" class="{{ request()->routeIs('marks.*') ? 'active' : '' }}"><i class="fa-solid fa-file-alt me-2"></i>Manage Marks</a>
       
                <div class="dropdown">
    <a class="d-flex align-items-center justify-content-between text-white px-3 py-2 dropdown-toggle"
       data-bs-toggle="collapse" href="#examReportMenu" role="button"
       aria-expanded="false" aria-controls="examReportMenu">
        <span><i class="fa-solid fa-file-lines me-2"></i>Exam Reports</span>
        <i class="fa-solid fa-chevron-down small"></i>
    </a>

    <div class="collapse" id="examReportMenu">
        <a href="{{ route('exams.report') }}" class="d-block text-white ps-4 py-1">Overall Report</a>
      <a href="{{ route('subject.reports') }}" class="d-block text-white ps-4 py-1">Subject Report</a>
     
    </div>
</div>
       <a href="{{ route('teacher-salaries.index') }}" class="nav-link">
             <i class="fa-regular fa-money-bill-1 me-2"></i>My Salary
            </a>

    @endif

    {{-- STUDENT LINKS --}}
    @if(auth()->user() && auth()->user()->role === 'student')


        <a href="{{ route('guardians.index') }}" class="{{ request()->routeIs('guardians.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-shield me-2"></i>My Guardian
        </a>

      
        <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book me-2"></i>My Subjects
        </a>
          
              <a href="{{ route('revision-materials.index') }}" class="{{ request()->routeIs('revision-materials.*') ? 'active' : '' }}">
    <i class="fa-solid fa-file-lines me-2"></i>Revision Materials
</a>

                      <a href="{{ route('attendances.my') }}" class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
    <i class="fa-solid fa-user-check me-2"></i>Attendance
</a>     
         <a href="{{ route('student-payments.index') }}" class="nav-link">
                <i class="fa-regular fa-money-bill-1 me-2"></i>My Payments
            </a>

             {{-- RESULTS --}}
<div class="dropdown-sidebar">

    <a class="nav-link d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       href="#resultsMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('results.*') || request()->routeIs('report-card.*') ? 'true' : 'false' }}">

        <span>
            <i class="fa-solid fa-chart-line me-2"></i>
            Results
        </span>

        <i class="fa-solid fa-chevron-down small"></i>

    </a>

    <div class="collapse {{ request()->routeIs('results.*') || request()->routeIs('report-card.*') ? 'show' : '' }}"
         id="resultsMenu">

       <a href="{{ route('results.years') }}"
           class="nav-link ps-5 {{ request()->routeIs('results.years') ? 'active' : '' }}">

            <i class="fa-solid fa-calendar me-2"></i>

            Academic Years

        </a>


        <a href="{{ route('report-card.index') }}"
           class="nav-link ps-5 {{ request()->routeIs('report-card.index') ? 'active' : '' }}">

            <i class="fa-solid fa-file-lines me-2"></i>

            Report Cards

        </a>

    </div>

</div>

 

    @endif

    {{-- LOGOUT --}}
    @auth
    <div class="mt-auto">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="text-danger">
            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
    @endauth
</div>


    {{-- Main Content --}}
    <div class="main-content">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand fw-semibold">@yield('page-title', 'Dashboard')</span>

                <div class="ms-auto d-flex align-items-center">
                    <span class="me-2">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'G') }}&background=0d6efd&color=fff"
                         class="avatar" alt="Avatar">
                </div>
            </div>
        </nav>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
