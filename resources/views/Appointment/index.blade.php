@extends('layout.index')
@section('home')

<div class="container my-5">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark">Appointments</h1>
        <a href="{{ route('appointment.create') }}" class="btn btn-primary">
            + New Appointment
        </a>
    </div>

    <!-- Search Filters -->
    <div class="mb-3">
        <form id="filterForm" method="GET" action="{{ route('appointment.index') }}" class="d-flex flex-wrap gap-2">
            <select class="form-select" name="date_filter" id="dateFilter" style="width: 200px;">
                <option value="">Select Date Range</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last_week">Last Week</option>
                <option value="this_month">This Month</option>
                <option value="last_month">Last Month</option>
            </select>
            <input type="text" class="form-control" name="name" placeholder="Search by Patient Name" style="width: 250px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0" id="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Doctor</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Consultant Fee</th>
                        <th scope="col">Net Fee</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->mypi?->Name ?? 'No Doctor Name' }}</td>
                        <td>{{ $appointment->pp?->name ?? 'No Name Available' }}</td>
                        <td>{{ $appointment->consultant_fee }}</td>
                        <td>{{ $appointment->net_fee }}</td>
                        <td>
                            <span class="badge {{ $appointment->payment_status ? 'bg-success' : 'bg-danger' }}">
                                {{ $appointment->payment_status ? 'Paid' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('appointment.show', $appointment->id) }}" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $("#table").DataTable();
});
</script>
@endsection
