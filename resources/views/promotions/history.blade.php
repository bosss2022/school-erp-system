
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-header bg-dark text-white py-3 rounded-top-4">

            <h4 class="mb-0">

                <i class="fa-solid fa-clock-rotate-left me-2"></i>

                Promotion History

            </h4>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>Student</th>

                            <th>From Class</th>

                            <th>To Class</th>

                            <th>Academic Year</th>

                            <th>Date</th>

                            <th>Promoted By</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($promotions as $promotion)

                            <tr>

                                <td class="fw-semibold">

                                    {{ $promotion->student->first_name }}
                                    {{ $promotion->student->last_name }}

                                </td>


                                <td>

                                    <span class="badge bg-secondary">

                                        {{ $promotion->fromClassroom->name }}

                                    </span>

                                </td>


                                <td>

                                    <span class="badge bg-success">

                                        {{ $promotion->toClassroom->name }}

                                    </span>

                                </td>


                                <td>

                                    {{ $promotion->academic_year }}

                                </td>


                                <td>

                                    {{ \Carbon\Carbon::parse($promotion->promotion_date)->format('d M Y') }}

                                </td>


                                <td>

                                    {{ $promotion->promoter->name ?? 'N/A' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5 text-muted">

                                    No promotion history found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $promotions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
