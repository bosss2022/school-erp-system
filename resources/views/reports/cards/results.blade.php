@extends('layouts.app')

@section('title','My Results')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h3 class="mb-0">

                <i class="fa-solid fa-graduation-cap me-2"></i>

                My Academic Results

            </h3>

        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-8">

                    <h4>

                        {{ $student->first_name }}

                        {{ $student->last_name }}

                    </h4>

                    <p>

                        Admission Number:

                        <strong>

                            {{ $student->admission_no }}

                        </strong>

                    </p>

                    <p>

                        Current Class:

                        <strong>

                            {{ $student->classroom->name }}

                        </strong>

                    </p>

                </div>

                <div class="col-md-4 text-end">

                    @if($student->photo)

                        <img src="{{ asset('storage/'.$student->photo) }}"
                             width="120"
                             class="img-thumbnail">

                    @endif

                </div>

            </div>

            <table class="table table-bordered table-hover">

                <thead class="table-success">

                <tr>

                    <th width="10%">#</th>

                    <th>Academic Year</th>

                    <th width="20%">Action</th>

                </tr>

                </thead>

                <tbody>

          @forelse($academicYears as $year)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $year->name }}</td>

    <td>

     <a href="{{ route('report-card.year', [
    'student' => $student->id,
    'academicYear' => $year->id,
]) }}"
class="btn btn-success btn-sm">

    <i class="fa fa-eye"></i>
    View Results

</a>

    </td>

</tr>

@empty

<tr>

    <td colspan="3" class="text-center">

        No Results Available

    </td>

</tr>

@endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection