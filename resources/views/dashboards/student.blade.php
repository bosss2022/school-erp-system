@extends('layouts.app')

@section('content')

@php

$totalFee = $student->payments->sum('total_fee');

$totalPaid = $student->payments->sum('amount_paid');

$balance = max($totalFee - $totalPaid,0);

$percentage = $totalFee > 0 ? round(($totalPaid/$totalFee)*100) : 0;


/*
|--------------------------------------------------------------------------
| Fee Breakdown
|--------------------------------------------------------------------------
*/

$feeBreakdown = [

    'Tuition' => 50,

    'Library' => 10,

    'Sports' => 15,

    'Maintenance' => 10,

    'Exams' => 10,

    'Other' => 5,

];

$breakdownAmount=[];

foreach($feeBreakdown as $name=>$percent){

    $breakdownAmount[$name]=($percent/100)*$totalFee;

}


/*
|--------------------------------------------------------------------------
| Academic Performance Graph
|--------------------------------------------------------------------------
*/

$performanceLabels=[];

$performanceScores=[];

foreach($student->marks->sortBy('created_at') as $mark){

    $performanceLabels[]=
        ($mark->exam->academicYear->name ?? 'Year')
        .' - '.
        ($mark->exam->term ?? '')
        .' - '.
        ($mark->exam->name ?? '');

    $performanceScores[]=$mark->marks;

}

@endphp

<div class="container py-4">

<div class="row g-4">

    <!-- Student Profile -->

    <div class="col-lg-4">

        <div class="card shadow border-0 rounded-4 h-100">

            <div class="card-body text-center">

                <img
                    src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/default-avatar.png') }}"
                    class="rounded-circle shadow mb-3"
                    style="width:120px;height:120px;object-fit:cover;">

                <h4 class="fw-bold text-success">

                    {{ $student->first_name }}

                    {{ $student->last_name }}

                </h4>

                <span class="badge bg-success">

                    {{ ucfirst($student->gender) }}

                </span>

                <hr>

                <p>

                    <strong>Admission No:</strong>

                    {{ $student->admission_no }}

                </p>

                <p>

                    <strong>Class:</strong>

                    {{ $student->classroom->name ?? '-' }}

                </p>

                <p>

                    <strong>Email:</strong>

                    {{ $student->email }}

                </p>

                <p>

                    <strong>Birth Certiicate:</strong>

                    {{ $student->phone }}

                </p>

                <p>

                    <strong>Address:</strong>

                    {{ $student->address }}

                </p>

            </div>

        </div>

    </div>


    <!-- Guardian -->

    <div class="col-lg-4">

        <div class="card shadow border-0 rounded-4 h-100">

            <div class="card-header bg-success text-white">

                Guardian Information

            </div>

            <div class="card-body">

                @if($student->guardian)

                    <p>

                        <strong>Name:</strong>

                        {{ $student->guardian->first_name }}

                    </p>

                    <p>

                        <strong>Phone:</strong>

                        {{ $student->guardian->phone }}

                    </p>

                    <p>

                        <strong>Relationship:</strong>

                        {{ $student->guardian->relation }}

                    </p>

                @else

                    <div class="text-center text-muted">

                        No guardian information.

                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- Fee Summary -->

    <div class="col-lg-4">

        <div class="card shadow border-0 rounded-4 h-100">

            <div class="card-header bg-success text-white">

                Fee Summary

            </div>

            <div class="card-body">

                <h6>

                    Total Fee

                </h6>

                <h3 class="text-success">

                    KSh {{ number_format($totalFee,2) }}

                </h3>

                <hr>

                <h6>

                    Amount Paid

                </h6>

                <h4>

                    KSh {{ number_format($totalPaid,2) }}

                </h4>

                <hr>

                <h6>

                    Balance

                </h6>

                <h4 class="text-danger">

                    KSh {{ number_format($balance,2) }}

                </h4>

                <div class="progress mt-3">

                    <div
                        class="progress-bar bg-success"
                        style="width:{{ $percentage }}%">

                    </div>

                </div>

                <div class="small text-muted mt-2">

                    {{ $percentage }}% Paid

                </div>

            </div>

        </div>

    </div>


    <!-- Fee Breakdown -->

    <div class="col-lg-6">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-success text-white">

                Fee Breakdown

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Category</th>

                        <th>%</th>

                        <th>Amount</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($feeBreakdown as $category=>$percent)

                    <tr>

                        <td>{{ $category }}</td>

                        <td>{{ $percent }}%</td>

                        <td>

                            {{ number_format($breakdownAmount[$category],2) }}

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

               <div class="d-flex justify-content-center">
    <canvas id="feeChart" width="220" height="220"></canvas>
</div>

            </div>

        </div>

    </div>

        <!-- Academic Performance -->
    <div class="col-lg-6">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-success text-white">

                Academic Performance

            </div>

            <div class="card-body">

                @if(count($performanceScores))

                    <canvas id="performanceChart" height="120"></canvas>

                @else

                    <div class="text-center text-muted py-5">

                        No examination records available.

                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- Recent Marks -->

    <div class="col-12">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-success text-white">

                Recent Examination Results

            </div>

            <div class="card-body table-responsive">

                @if($student->marks->count())

                <table class="table table-striped table-hover align-middle">

                    <thead class="table-success">

                        <tr>

                            <th>Academic Year</th>

                            <th>Term</th>

                            <th>Exam</th>

                            <th>Subject</th>

                            <th>Marks</th>

                            <th>Grade</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($student->marks->sortByDesc('created_at') as $mark)

                    @php

                        $grade = match(true){

                            $mark->marks >=80 => 'A',

                            $mark->marks >=70 => 'B',

                            $mark->marks >=60 => 'C',

                            $mark->marks >=50 => 'D',

                            default=>'E'

                        };

                    @endphp

                    <tr>

                        <td>

                            {{ $mark->exam->academicYear->name ?? '-' }}

                        </td>

                        <td>

                            {{ $mark->exam->term }}

                        </td>

                        <td>

                            {{ $mark->exam->name }}

                        </td>

                        <td>

                            {{ $mark->subject->name }}

                        </td>

                        <td>

                            <strong>{{ $mark->marks }}</strong>

                        </td>

                        <td>

                            @switch($grade)

                                @case('A')

                                    <span class="badge bg-success">A</span>

                                @break

                                @case('B')

                                    <span class="badge bg-primary">B</span>

                                @break

                                @case('C')

                                    <span class="badge bg-warning text-dark">C</span>

                                @break

                                @case('D')

                                    <span class="badge bg-secondary">D</span>

                                @break

                                @default

                                    <span class="badge bg-danger">E</span>

                            @endswitch

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

                @else

                <div class="text-center text-muted py-5">

                    No examination records available.

                </div>

                @endif

            </div>

        </div>

    </div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/*
|--------------------------------------------------------------------------
| Fee Pie Chart
|--------------------------------------------------------------------------
*/

new Chart(document.getElementById('feeChart'),{

    type:'pie',

    data:{

        labels:@json(array_keys($feeBreakdown)),

        datasets:[{

            data:@json(array_values($feeBreakdown)),

            backgroundColor:[

                 '#81C784', // Light Green
    '#64B5F6', // Light Blue
    '#FFD54F', // Yellow
    '#E57373', // Light Red
    '#BA68C8', // Lavender
    '#4DB6AC' 

            ]

        }]

    },

    options:{

        responsive:true,
            maintainAspectRatio: false,
        radius: '100%',      // Reduce overall size (try 60%-80%)

        plugins:{

            legend:{

                position:'bottom'

            }

        }

    }

});


/*
|--------------------------------------------------------------------------
| Academic Performance Line Graph
|--------------------------------------------------------------------------
*/

@if(count($performanceScores))

new Chart(document.getElementById('performanceChart'),{

    type:'line',

    data:{

        labels:@json($performanceLabels),

        datasets:[{

            label:'Marks',

            data:@json($performanceScores),

            borderColor:'#16a34a',

            backgroundColor:'rgba(34,197,94,.15)',

            borderWidth:3,

            fill:true,

            tension:.35,

            pointRadius:5,

            pointHoverRadius:7

        }]

    },

    options:{

        responsive:true,

        scales:{

            y:{

                beginAtZero:true,

                max:100

            }

        },

        plugins:{

            legend:{

                display:false

            }

        }

    }

});

@endif

</script>

@endsection