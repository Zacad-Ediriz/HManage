@extends('layout.index')
@section('home')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-center">Patient Balance Report</h1>

        <!-- Buttons -->
        <div>
            <button class="btn btn-primary" id="printBtn"><i class="fa fa-print"></i> Print</button>
            
        </div>
    </div>

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Patient Name</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $key => $patient)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>${{ number_format($patient->balance, 2) }}</td>
                </tr>
            @endforeach
            <tr class="table-info">
                <td colspan="2"><strong>Total Balance</strong></td>
                <td><strong>${{ number_format($totalBalance, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Print Functionality -->
<script>
    document.getElementById('printBtn').addEventListener('click', function () {
        window.print();
    });
</script>
@endsection
