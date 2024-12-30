@extends('layout.index')
@section('home')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Appointment #{{ $appointment->serial }}</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Patient:</strong> {{ $appointment->pp->name }}</li>
                    <li class="list-group-item"><strong>Doctor:</strong> {{ $appointment->mypi->Name }}</li>
                    <li class="list-group-item"><strong>Appointment Time:</strong> {{ $appointment->appointment_time }}</li>
                    <li class="list-group-item"><strong>Net Fee:</strong> ${{ $appointment->net_fee }}</li>
                    <li class="list-group-item">
                        <strong>Payment Status:</strong> 
                        @if($appointment->payment_status == 1)
                            Paid
                        @else
                            Pending
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Remarks:</strong> {{ $appointment->remark }}</li>
                </ul>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-danger" onclick="window.print()">Print</button>
                <button class="btn btn-secondary" onclick="window.history.back()">Close</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
