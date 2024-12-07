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

    <!-- Appointments Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Doctor</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Consultant Fee</th>
                        <th scope="col">Net Fee</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)   
                    <tr>
                    
                    <td>{{ $appointment?->doctor }}</td>

<!-- Check if the patient is loaded and if the name exists -->
                    
                    <td>{{ $appointment?->patient }}</td>
                        <td>{{ $appointment->consultant_fee }}</td>
                        <td>{{ $appointment->net_fee }}</td>
                
                        <td>
                            <span class="badge 
                                {{ $appointment->payment_status ? 'bg-success' : 'bg-danger' }}">
                                {{ $appointment->payment_status ? 'Paid' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
