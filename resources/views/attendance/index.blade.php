<!-- resources/views/attendance/index.blade.php -->
@extends('layout.index')
@section('home')

<div class="container my-5">
    <div class="row">
        <!-- Attendance Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create New Attendance</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <!-- Select Employee -->
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Select Employee</label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="">-- Select Employee --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Time -->
                        <div class="mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="time" name="time" id="time" class="form-control" required>
                        </div>

                        <!-- Check (In/Out) -->
                        <div class="mb-3">
                            <label class="form-label">Check</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="check" id="check_in" value="In" required>
                                <label class="form-check-label" for="check_in">In</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="check" id="check_out" value="Out" required>
                                <label class="form-check-label" for="check_out">Out</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Attendance Records</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Date</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Time</th>
                                <th scope="col">Check</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $key => $attendance)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M') }}</td>
                                    <td>{{ $attendance->employee_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->time)->format('h:i A') }}</td>
                                    <td>{{ $attendance->check }}</td>
                                    <td>
                                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
