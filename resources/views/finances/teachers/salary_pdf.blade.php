<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Salary Slip</title>
    <style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#333;
    margin:25px;
}

.header{
    text-align:center;
    border-bottom:3px solid #198754;
    padding-bottom:12px;
    margin-bottom:20px;
}

.header h1{
    margin:0;
    color:#198754;
    font-size:28px;
}

.header h3{
    margin:6px 0;
}

.header p{
    margin:2px;
}

.info{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.info td{
    border:1px solid #ddd;
    padding:10px;
}

.info strong{
    color:#198754;
}

.salary{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.salary th{
    background:#198754;
    color:#fff;
    border:1px solid #ddd;
    padding:10px;
}

.salary td{
    border:1px solid #ddd;
    padding:10px;
}

.total{
    background:#f8f9fa;
    font-weight:bold;
}

.footer{
    margin-top:60px;
}

.signature{
    width:45%;
    display:inline-block;
    text-align:center;
}

.signature hr{
    border:none;
    border-top:1px solid #000;
}

.note{
    margin-top:25px;
    background:#f8f9fa;
    border-left:5px solid #198754;
    padding:12px;
}

</style>
</head>
<body>
   <div class="header">

    <h1>MASU SCHOOL OF GRACE</h1>

    <p>P.O.Box: 250-00519, Mlolongo</p>

    <p>Phone: +254 714473525 or +254 732680652.</p>

    <p>Email: Masuschool189@gmail.com</p>

    <h3>Teacher Salary Slip</h3>

</div>

<table class="info">

<tr>

<td>

<strong>Employee Name</strong><br>

{{ $salary->teacher->first_name }}

{{ $salary->teacher->last_name }}

</td>

<td>

<strong>Email</strong><br>

{{ $salary->teacher->email }}

</td>

</tr>

<tr>

<td>

<strong>Salary Month</strong><br>

{{ $salary->month }}

</td>

<td>

<strong>Salary Year</strong><br>

{{ $salary->year }}

</td>

</tr>

<tr>

<td>

<strong>Payment Date</strong><br>

{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}

</td>

<td>

<strong>Slip Number</strong><br>

SAL-{{ str_pad($salary->id,6,'0',STR_PAD_LEFT) }}

</td>

</tr>

</table>

<table class="salary">

<thead>

<tr>

<th>Description</th>

<th>Amount (KES)</th>

</tr>

</thead>

<tbody>

<tr>

<td>Basic Salary</td>

<td>

{{ number_format($salary->amount,2) }}

</td>

</tr>

<tr class="total">

<td>

Net Salary

</td>

<td>

KES {{ number_format($salary->amount,2) }}

</td>

</tr>

</tbody>

</table>

<div class="note">

<strong>Payment Status</strong>

<p>

This salary has been processed and paid for

<strong>{{ $salary->month }} {{ $salary->year }}</strong>.

</p>

</div>
<div class="footer">

<div class="signature">

<hr>

School Accountant

</div>

<div class="signature" style="float:right;">

<hr>

Head Teacher

</div>

<br><br><br>

<div style="text-align:center;font-size:11px;color:#666;">

This is a computer-generated salary slip.

<br>

Generated on {{ now()->format('d M Y H:i') }}

</div>

</div>
</body>
</html>
