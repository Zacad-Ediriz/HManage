@extends('layout.index')
@section('home')
<div class="container">
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="schedule_name" class="form-label">Schedule Name</label>
            <input type="text" name="schedule_name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Choose the Doctor</label>
            <select name="doctor_id" class="form-control inputmodalselect2" required>
                <option value="">Choose the Doctor</option>
                @foreach ($doctors as $row)
                    <option value="{{ $row?->id }}">{{ $row?->Name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group mb-3">
            <label class="form-label" for="day">Days</label>
            <select name="day" id="day" class="form-control inputmodalselect2" required>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fees" class="form-label">Consultant Fees</label>
            <input type="number" name="fees" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="number_of_visits" class="form-label"># of Visits</label>
            <input type="number" name="number_of_visits" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
