
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>leader Payment Receipt</title>
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
    padding-bottom:10px;
    margin-bottom:20px;
}

.header h1{
    margin:0;
    color:#198754;
    font-size:28px;
}

.header h3{
    margin:5px 0;
    color:#444;
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

.receipt{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.receipt th{
    background:#198754;
    color:#fff;
    border:1px solid #ddd;
    padding:10px;
}

.receipt td{
    border:1px solid #ddd;
    padding:10px;
}

.total{
    background:#f8f9fa;
    font-weight:bold;
}

.balance{
    color:#dc3545;
    font-weight:bold;
}

.paid{
    color:#198754;
    font-weight:bold;
}

.footer{
    margin-top:50px;
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
    padding:10px;
}

</style>
</head>
<body>
    <div class="header">

    <h1>MASU SCHOOL OF GRACE</h1>

    <p>250-00519, Mlolongo</p>

    <p>Phone:+254 714473525 or +254 732680652.</p>

    <p>Email: Masuschool189@gmail.com</p>

    <h3>OFFICIAL SCHOOL FEE RECEIPT</h3>

</div>

    <<table class="info">

<tr>

<td>

<strong>Receipt No</strong><br>

RCPT-{{ str_pad($payment->id,6,'0',STR_PAD_LEFT) }}

</td>

<td>

<strong>Date</strong><br>

{{ $payment->payment_date->format('d M Y') }}

</td>

</tr>

<tr>

<td>

<strong>Student Name</strong><br>

{{ $payment->student->first_name }}

{{ $payment->student->last_name }}

</td>

<td>

<strong>Admission No</strong><br>

{{ $payment->student->admission_no }}

</td>

</tr>

<tr>

<td>

<strong>Academic Year</strong><br>

{{ $payment->academicYear->name ?? 'N/A' }} 

</td>

<td>

<strong>Term</strong><br>

{{ $payment->term }}

</td>

</tr>

</table>



   <table class="receipt">

<thead>

<tr>

<th>Description</th>

<th>Amount (Ksh)</th>

</tr>

</thead>

<tbody>

<tr>

<td>Total School Fees</td>

<td>

{{ number_format($payment->total_fee,2) }}

</td>

</tr>

<tr>

<td>Amount Paid</td>

<td class="paid">

{{ number_format($payment->amount_paid,2) }}

</td>

</tr>

<tr>

<td>Outstanding Balance</td>

<td class="balance">

{{ number_format($payment->balance,2) }}

</td>

</tr>

</tbody>

</table>


<div class="note">

<strong>Payment Status:</strong>

@if($payment->balance <= 0)

<span style="color:#198754;font-weight:bold;">

FULLY PAID

</span>

@else

<span style="color:#dc3545;font-weight:bold;">

BALANCE: Ksh {{ number_format($payment->balance,2) }}

</span>

@endif

</div>

    <div class="footer">

<div class="signature">

<hr>

School Accountant

</div>

<div class="signature" style="float:right;">

<hr>

Official School Stamp

</div>

<br><br><br>

<div style="text-align:center;font-size:11px;color:#666;">

This is a computer-generated receipt and does not require a physical signature.

<br>

Generated on {{ now()->format('d M Y H:i') }}

</div>

</div>
</body>
</html>