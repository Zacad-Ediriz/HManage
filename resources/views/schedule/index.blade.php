@extends('layout.index')
@section('home')
<div class="container">
    <a href="{{ route('schedule.create') }}" class="btn btn-primary mb-3">Add New Schedule</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Schedule Name</th>
                <th>Doctor</th>
                <th>Day</th>
                <th>Time Slot</th>
                <th>Fees</th>
                <th># of Visits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $schedule->schedule_name }}</td>
                <td>{{ $schedule->doctor->Name }}</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                <td>${{ $schedule->fees }}</td>
                <td>{{ $schedule->number_of_visits }}</td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
