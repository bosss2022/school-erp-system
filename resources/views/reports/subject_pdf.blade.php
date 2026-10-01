
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>
        {{ $subject->name ?? 'Subject' }} Report
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 25px;
        }

        /* ================= HEADER ================= */

        .header {
            text-align: center;
            border-bottom: 3px solid #198754;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #198754;
            font-size: 26px;
        }

        .header h3 {
            margin: 6px 0;
            color: #444;
            font-size: 16px;
        }

        .header p {
            margin: 3px;
            font-size: 11px;
        }


        /* ================= REPORT INFORMATION ================= */

        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info td {
            width: 50%;
            border: 1px solid #ddd;
            padding: 9px;
        }

        .info strong {
            color: #198754;
        }


        /* ================= REPORT TABLE ================= */

        .report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .report th {
            background: #198754;
            color: #fff;
            border: 1px solid #198754;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }

        .report td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }

        .report tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .student-name {
            text-align: left !important;
            font-weight: bold;
        }

        .marks {
            font-weight: bold;
        }

        .grade {
            font-weight: bold;
            color: #198754;
        }


        /* ================= SUMMARY ================= */

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary td {
            border: 1px solid #ddd;
            padding: 9px;
        }

        .summary-title {
            background: #198754;
            color: #fff;
            font-weight: bold;
        }


        /* ================= STATUS ================= */

        .no-data {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f8f9fa;
        }


        /* ================= SIGNATURES ================= */

        .signatures {
            width: 100%;
            margin-top: 45px;
        }

        .signature {
            width: 40%;
            text-align: center;
        }

        .signature hr {
            border: none;
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }


        /* ================= FOOTER ================= */

        .footer {
            margin-top: 35px;
            border-top: 2px solid #198754;
            padding-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

    </style>
</head>

<body>


{{-- ================= SCHOOL HEADER ================= --}}

<div class="header">

    <h1>MASU SCHOOL OF GRACE</h1>

    <p>250-00519, Mlolongo</p>

    <p>
        Phone: +254 714473525 or +254 732680652
    </p>

    <p>
        Email: Masuschool189@gmail.com
    </p>

    <h3>OFFICIAL SUBJECT REPORT</h3>

</div>


{{-- ================= REPORT INFORMATION ================= --}}

<table class="info">

    <tr>

        <td>

            <strong>Subject</strong><br>

            {{ $subject->name ?? 'Subject' }}

        </td>

        <td>

            <strong>Examination</strong><br>

            {{ $exam->name ?? 'All Exams' }}

        </td>

    </tr>

    <tr>

        <td>

            <strong>Term</strong><br>

            {{ $term ?? 'All Terms' }}

        </td>

        <td>

            <strong>Class</strong><br>

            {{ $classroom->name ?? 'All Classes' }}

        </td>

    </tr>

</table>


{{-- ================= MARKS ================= --}}

@if($marks->isEmpty())

    <div class="no-data">

        No student marks found.

    </div>

@else

    <table class="report">

        <thead>

            <tr>

                <th>#</th>

                <th>Student</th>

                <th>Admission No.</th>

                <th>Class</th>

                <th>Exam</th>

                <th>Term</th>

                <th>Marks</th>

                <th>Grade</th>

            </tr>

        </thead>


        <tbody>

            @foreach($marks as $mark)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="student-name">

                        {{ $mark->student->first_name }}
                        {{ $mark->student->last_name }}

                    </td>

                    <td>

                        {{ $mark->student->admission_no }}

                    </td>

                    <td>

                        {{ $mark->student->classroom->name ?? 'N/A' }}

                    </td>

                    <td>

                        {{ $mark->exam->name }}

                    </td>

                    <td>

                        {{ $mark->exam->term ?? 'N/A' }}

                    </td>

                    <td class="marks">

                        {{ $mark->marks }}

                    </td>

                    <td class="grade">

                        {{ $mark->grade }}

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    {{-- ================= SUMMARY ================= --}}

    <table class="summary">

        <tr>

            <td class="summary-title">

                Subject Summary

            </td>

            <td>

                Average:

                <strong>
                    {{ number_format($averageMark, 2) }}
                </strong>

            </td>

            <td>

                Highest:

                <strong>
                    {{ $highestMark ?? '-' }}
                </strong>

            </td>

            <td>

                Lowest:

                <strong>
                    {{ $lowestMark ?? '-' }}
                </strong>

            </td>

            <td>

                Students:

                <strong>
                    {{ $totalStudents }}
                </strong>

            </td>

        </tr>

    </table>


    {{-- ================= SIGNATURES ================= --}}

    <table class="signatures">

        <tr>

            <td class="signature">

                <hr>

                Subject Teacher

            </td>

            <td style="width:20%;"></td>

            <td class="signature">

                <hr>

                School Administrator

            </td>

        </tr>

    </table>

@endif


{{-- ================= FOOTER ================= --}}

<div class="footer">

    This is a computer-generated subject examination report.

    <br>

    Generated on {{ now()->format('d M Y H:i') }}

    <br><br>

    <strong>MASU SCHOOL OF GRACE</strong>

</div>


</body>
</html>

