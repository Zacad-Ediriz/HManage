
@extends('layout.index')
@section('home')

<div class="container">
    <h1>Sales Report</h1>
    <form method="GET" action="{{ route('sales_report.index') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="start_date">Date From</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date">Date To</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="customer">Customer</label>
                <input type="text" id="customer" name="customer" value="{{ $customer }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Net Total</th>
                <th>Amount Paid</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $index => $invoice)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->patient }}</td>
                <td>${{ number_format($invoice->total, 2) }}</td>
                <td>${{ number_format($invoice->discount, 2) }}</td>
                <td>${{ number_format($invoice->net_total, 2) }}</td>
                <td>${{ number_format($invoice->amount_paid, 2) }}</td>
                <td>${{ number_format($invoice->balance, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4">Totals</th>
                <th>${{ number_format($totals['subtotal'], 2) }}</th>
                <th>${{ number_format($totals['discount'], 2) }}</th>
                <th>${{ number_format($totals['net_total'], 2) }}</th>
                <th>${{ number_format($totals['amount_paid'], 2) }}</th>
                <th>${{ number_format($totals['balance'], 2) }}</th>
            </tr>
        </tbody>
    </table>
</div>
@endsection
