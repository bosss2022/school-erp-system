<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>School Timetable</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .class-header { background: #ddd; padding: 6px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>School Timetable</h2>

    @foreach($timetables as $classroomId => $classTimetables)
        @php $classroom = $classTimetables->first()->classroom; @endphp
        <div class="class-header">Class: {{ $classroom->name }}</div>

     <table class="table table-bordered table-hover text-center align-middle">

               <thead class="table-secondary">
                    <tr>
                        <th style="width:120px;">Day</th>

                        @foreach($timeSlots as $slot)
                            <th>{{ $slot }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>

                    @foreach($days as $day)

                        <tr>

                            <td class="fw-bold bg-light">
                                {{ $day }}
                            </td>

                            @foreach($timeSlots as $slot)

                                <td>

                                    @if(isset($grouped[$classroomId][$day][$slot]))

                                        @php
                                            $entry = $grouped[$classroomId][$day][$slot];
                                        @endphp

                                        @if($entry->is_break)

                                            <span class="badge bg-warning text-dark p-2">
                                                {{ $entry->label }}
                                            </span>

                                        @else

                                            <div class="fw-bold text-primary">
                                                {{ $entry->subject->name ?? 'Break' }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $entry->teacher
                                                    ? $entry->teacher->first_name . ' ' . $entry->teacher->last_name
                                                    : '-' }}
                                            </small>

                                        @endif

                                    @else
                                       -
                                    @endif

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>
    @endforeach
</body>
</html>
