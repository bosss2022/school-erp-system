<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Leader Report Card</title>

   <style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#333;
    line-height:1.6;
    margin:25px;
}

/* ================= HEADER ================= */

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h1{
    margin:0;
    font-size:28px;
    color:#198754;
    font-weight:bold;
}

.header h3{
    margin:8px 0;
    color:#000;
    font-size:18px;
}

.header p{
    margin:2px 0;
    font-size:12px;
}

/* ================= HORIZONTAL LINE ================= */

hr{
    border:none;
    border-top:2px solid #198754;
    margin:15px 0 20px;
}

/* ================= STUDENT INFO ================= */

.info{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
    border:1px solid #198754;
}

.info td{
    border:1px solid #ddd;
    padding:10px;
    vertical-align:top;
}

.info strong{
    color:#198754;
    display:block;
    margin-bottom:5px;
}

/* ================= RESULTS TABLE ================= */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#198754;
    color:#fff;
    padding:8px;
    border:1px solid #ccc;
    font-size:12px;
}

table td{
    border:1px solid #ccc;
    padding:8px;
    font-size:11px;
}

/* Alternate row colors */

tbody tr:nth-child(even){
    background:#f8f9fa;
}

/* ================= SUMMARY ================= */

.summary{
    margin-top:25px;
}

.summary th{
    background:#198754;
    color:#fff;
    text-align:left;
    width:25%;
}

.summary td{
    background:#ffffff;
    text-align:center;
    font-weight:bold;
}

/* ================= REMARKS ================= */

.remarks{
    margin-top:25px;
    border-left:6px solid #198754;
    background:#f5fdf7;
    padding:15px;
}

.remarks h3{
    margin-top:0;
    margin-bottom:8px;
    color:#198754;
}

.remarks p{
    margin:0;
}

/* ================= SIGNATURES ================= */

.signature-table{
    width:100%;
    margin-top:60px;
}

.signature-table td{
    border:none;
    width:33%;
    text-align:center;
    vertical-align:bottom;
}

.signature-line{
    width:80%;
    margin:40px auto 8px;
    border-top:1px solid #000;
}

/* ================= FOOTER ================= */

.footer{
    margin-top:20px;
    text-align:center;
    font-size:10px;
    color:#666;
}

/* ================= BADGES ================= */

.grade-box{
    display:inline-block;
    padding:3px 8px;
    background:#198754;
    color:#fff;
    font-weight:bold;
    border-radius:3px;
}

.position-box{
    display:inline-block;
    padding:3px 8px;
    background:#0d6efd;
    color:#fff;
    font-weight:bold;
    border-radius:3px;
}

/* ================= PAGE ================= */

@page{
    margin:25px;
}

</style>

</head>

<body>

<!-- ================= SCHOOL HEADER ================= -->

<div class="header">

    <table style="width:100%; border:none;">

        <tr>

            <td style="width:18%; border:none; text-align:left;">

                {{-- School Logo --}}
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ public_path('images/logo.png') }}"
                         width="80">
                @endif

            </td>

            <td style="border:none; text-align:center;">

                <h1 style="margin:0;color:#198754;font-size:28px;">
                    MASU SCHOOL OF GRACE
                </h1>

                <p style="margin:3px;">
                  P.O.Box 250-00519, Mlolongo


                </p>

                <p style="margin:3px;">
                    Phone: +254 714473525 or +254 732680652.
                </p>

                <p style="margin:3px;">
                    Email: Masuschool189@gmail.com
                </p>

                <h3 style="margin-top:10px;">
                    LEADER REPORT CARD
                </h3>

            </td>

            <td style="width:18%; border:none; text-align:right;">

                @if($student->photo)

                    <img src="{{ public_path('storage/'.$student->photo) }}"
                         width="80"
                         height="90">

                @endif

            </td>

        </tr>

    </table>

</div>

<hr>

<!-- ================= STUDENT DETAILS ================= -->

<table class="info">

<tr>

<td>

<strong>Admission No</strong><br>

{{ $student->admission_no }}

</td>

<td>

<strong>Leader Name</strong><br>

{{ $student->first_name }}

{{ $student->last_name }}

</td>

<td>

<strong>Class</strong><br>

{{ $student->classroom->name }}

</td>

</tr>

<tr>

<td>

<strong>Guardian</strong><br>

@if($student->guardian)

{{ $student->guardian->first_name }}

{{ $student->guardian->last_name }}

@endif

</td>

<td>

<strong>Academic Year</strong><br>

{{ date('Y') }}

</td>

<td>

<strong>Date Printed</strong><br>

{{ now()->format('d M Y') }}

</td>

</tr>

</table>





<!-- ================= RESULTS ================= -->

<table>

<thead>

<tr>

<th>#</th>

<th>Subject</th>

<th>Exam</th>

<th>Marks</th>

<th>Grade</th>

<th>Remark</th>

</tr>

</thead>

<tbody>

@foreach($subjects as $subject)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $subject['subject'] }}</td>

<td>{{ $subject['exam'] }}</td>

<td align="center">

{{ $subject['marks'] }}

</td>

<td align="center">

{{ $subject['grade'] }}

</td>

<td>

{{ $subject['remark'] }}

</td>

</tr>

@endforeach

</tbody>

</table>


<!-- ================= SUMMARY ================= -->

<table style="margin-top:25px;">

<tr>

<th>Total Marks</th>

<td>{{ $totalMarks }}</td>

<th>Average</th>

<td>{{ number_format($average,2) }}</td>

</tr>

<tr>

<th>Overall Grade</th>

<td>{{ $overallGrade }}</td>

<th>Position</th>

<td>{{ $position }}</td>

</tr>

</table>



<!-- ================= REMARKS ================= -->

<div class="remarks">

<h3 style="margin-top:0;color:#198754;">

Teacher's Remark

</h3>

<p>

{{ $overallRemark }}

</p>

</div>

<br>

<div class="remarks">

<h3 style="margin-top:0;color:#198754;">

Head Teacher's Remark

</h3>

<p>

Excellent progress. Keep working hard and maintain discipline.

</p>

</div><!-- ================= SIGNATURES ================= -->

<table style="width:100%; margin-top:70px; border:none;">

<tr>

    <!-- Director -->
    <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">

        <img src="{{ public_path('storage/images/directorsign.png') }}"
             style="height:65px;">

        <hr style="width:80%;">

        <strong>School Director</strong>

    </td>

    <!-- Head Teacher -->
    <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">

        <img src="{{ public_path('storage/images/headteachersign.png') }}"
             style="height:65px;">

        <hr style="width:80%;">

        <strong>Head Teacher</strong>

    </td>

    <!-- School Stamp -->
    <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">

        <img src="{{ public_path('storage/images/schoolstamp.png') }}"
             style="width:90px;height:90px;">

        <br>

        <strong>Official School Stamp</strong>

    </td>

</tr>

</table>

</body>

</html>