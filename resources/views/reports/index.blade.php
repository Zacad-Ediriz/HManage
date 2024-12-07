<!-- resources/views/reports/profit_and_loss.blade.php -->
@extends('layout.index')

@section('home')
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="text-primary">Hospital Management System (HMS)</h2>
        <h4 class="text-info">Income Statement</h4>
        <p class="lead">From {{ date('d M Y', strtotime($fromDate)) }} To {{ date('d M Y', strtotime($toDate)) }}</p>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('reports') }}" class="mb-4 row g-3 justify-content-center">
        <div class="col-auto">
            <label for="from_date" class="form-label">Date From</label>
            <input type="date" id="from_date" name="from_date" value="{{ $fromDate }}" class="form-control">
        </div>
        <div class="col-auto">
            <label for="to_date" class="form-label">Date To</label>
            <input type="date" id="to_date" name="to_date" value="{{ $toDate }}" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mt-4">Filter</button>
        </div>
        <div class="col-auto">
            <button type="button" onclick="window.print()" class="btn btn-success mt-4">Print</button>
        </div>
    </form>

    <!-- Revenue and Expenses Table -->
    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">Revenues & Gains</th>
                        <th class="text-end">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sales Revenues</td>
                        <td></td>
                        <td class="text-end">${{ number_format($salesRevenues, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Getable Dues</td>
                        <td></td>
                        <td class="text-end">${{ number_format($getableDues, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-end">Total Revenues</th>
                        <th class="text-end">${{ number_format($totalRevenues, 2) }}</th>
                    </tr>
                </tbody>
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">Expenses & Losses</th>
                        <th class="text-end">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Manufacturer Payment (Cash)</td>
                        <td></td>
                        <td class="text-end">${{ number_format($manufacturerPayments, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Others</td>
                        <td></td>
                        <td class="text-end">${{ number_format($otherExpenses, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-end">Total Expenses</th>
                        <th class="text-end">${{ number_format($totalExpenses, 2) }}</th>
                    </tr>
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <th colspan="2" class="text-end">Balance</th>
                        <th class="text-end">${{ number_format($balance, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection
