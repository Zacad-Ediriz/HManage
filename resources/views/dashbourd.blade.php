@extends('layout.index')

@section('home')
    <h1>Dashboard</h1>
    <div class="d-flex flex-column flex-column-fluid">
        <div class="row">

            <div class="col-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Patients</h4>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h1>{{ $patient }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Appointments</h4>
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <h1>{{ $Appointment }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Doctors</h4>
                            <i class="fas fa-user-md fa-2x"></i>
                        </div>
                        <h1>{{ $Doctors }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Product</h4>
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                        <h1>{{ $product }}</h1>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Total Revenue</h3>
                                    <div id="bar-charts"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Sales Overview</h3>
                                    <div id="line-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">New Employees</span> </div>
                                    <div> <span class="text-success">+10%</span> </div>
                                </div>
                                <h3 class="mb-3">{{ $balance }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Overall Employees 218</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Earnings</span>
                                    </div>
                                    <div>
                                        <span class="{{ $earningsChangePercentage >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $earningsChangePercentage >= 0 ? '+' : '' }}{{ number_format($earningsChangePercentage, 2) }}%
                                        </span>
                                    </div>
                                </div>
                                <h3 class="mb-3">${{ number_format($currentEarnings, 2) }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, abs($earningsChangePercentage)) }}%;" 
                                         aria-valuenow="{{ abs($earningsChangePercentage) }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0">Previous Month <span class="text-muted">${{ number_format($previousEarnings, 2) }}</span></p>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Expenses</span>
                                    </div>
                                    <div>
                                        <span class="{{ $expenseChangePercentage < 0 ? 'text-success' : 'text-danger' }}">
                                            {{ round($expenseChangePercentage, 2) }}%
                                        </span>
                                    </div>
                                </div>
                                <h3 class="mb-3">${{ number_format($currentExpenses, 2) }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ abs($expenseChangePercentage) }}%;" 
                                         aria-valuenow="{{ abs($expenseChangePercentage) }}" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0">Previous Month 
                                    <span class="text-muted">${{ number_format($previousExpenses, 2) }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                                <div>
                                    @php
                                        $percentageChange = $previousBalance != 0 
                                            ? (($currentBalance - $previousBalance) / $previousBalance) * 100 
                                            : 0;
                                    @endphp
                                    <span class="{{ $percentageChange < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ round($percentageChange, 2) }}%
                                    </span>
                                </div>
                            </div>
                            <h3 class="mb-3">${{ number_format($currentBalance, 2) }}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ abs($percentageChange) }}%;" 
                                     aria-valuenow="{{ abs($percentageChange) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month 
                                <span class="text-muted">${{ number_format($previousBalance, 2) }}</span>
                            </p>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
          
            <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
            <div class="card flex-fill dash-statistics shadow">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary font-weight-bold">
                        Best Selling Products
                    </h5>
                    <div class="table-responsive">
                        <table class="table custom-table table-striped">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th class="text-success">Product Name</th>
                                    <th class="text-info">Sale Price</th>
                                    <th class="text-danger">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bestSellingProducts as $product)
                                <tr class="text-center">
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            {{ $product->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-white p-2">
                                            ${{ number_format($product->sale_price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} 
                                            text-white p-2">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center text-primary font-weight-bold">Best Selling Patients</h4>
                        <div class="table-responsive">
                            <table class="table custom-table table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th class="text-success">Name</th>
                                        <th class="text-info">Phone</th>
                                        <th class="text-danger">Balance</th>
                                        <th class="text-primary">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestSellingPatients as $patient)
                                    <tr class="text-center">
                                        <td>
                                            <span class="font-weight-bold text-success">{{ $patient->name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-info">{{ $patient->phone }}</span>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                {{ $patient->balance > 0 ? 'bg-danger' : 'bg-success' }} 
                                                text-white p-2">
                                                ${{ number_format($patient->balance, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-primary">{{ $patient->remarks }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center text-primary font-weight-bold">Accounts and Balances</h4>
                        <div class="table-responsive">
                            <table class="table custom-table table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th class="text-success">Account Name</th>
                                        <th class="text-info">Account Number</th>
                                        <th class="text-danger">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                    <tr class="text-center">
                                        <td>
                                            <span class="font-weight-bold text-success">{{ $account->account_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-info">{{ $account->account_number }}</span>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                {{ $account->account_balance > 0 ? 'bg-success' : 'bg-danger' }} 
                                                text-white p-2">
                                                ${{ number_format($account->account_balance, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Statistics Widget -->
            <div class="row">
    <!-- Invoices Section -->
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Invoices</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Client</th>
                                <th>Due Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td><a href="invoice-view.html">#INV-{{ $invoice->id }}</a></td>
                                    <td>
                                        <h2><a href="#">{{ $invoice->mypi->name ?? 'Unknown Client' }}</a></h2>
                                    </td>
                                    <td>{{ $invoice->created_at ?? 'N/A' }}</td>
                                    <td>${{ number_format($invoice->total, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $invoice->payment_status === 'Paid' ? 'bg-inverse-success' : ($invoice->payment_status === 'Partially Paid' ? 'bg-inverse-warning' : 'bg-inverse-danger') }}">
                                            {{ ucfirst($invoice->payment_status) }}
                                        </span>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('invoice') }}">View all invoices</a>
            </div>
        </div>
    </div>

    <!-- Payments Section -->
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Payments</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Client</th>
                                <th>Payment Type</th>
                                <th>Paid Date</th>
                                <th>Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td><a href="invoice-view.html">#INV-{{ $payment->id }}</a></td>
                                    <td>
                                        <h2><a href="#">{{ $payment->mypatient->name ?? 'Unknown Client' }}</a></h2>
                                    </td>
                                    <td>{{ $payment->payment_type ?? 'Cash' }}</td>
                                    <td>{{ $payment->created_at ?? 'N/A'}}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('paymentform.index') }}">View all payments</a>
            </div>
        </div>
    </div>
</div>

            <div class="row">
            <div class="col-md-6 d-flex">
    <div class="card card-table flex-fill">
        <div class="card-header">
            <h3 class="card-title mb-0">Clients</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Sex</th>
                            <th>Address</th>
                            <th>Balance</th>
                            <th>Remarks</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="assets/img/profiles/avatar-placeholder.jpg"></a>
                                        <a href="#">{{ $patient->name }}</a>
                                    </h2>
                                </td>
                                <td>{{ $patient->phone ?? 'N/A' }}</td>
                                <td>{{ ucfirst($patient->sex) }}</td>
                                <td>{{ $patient->address ?? 'N/A' }}</td>
                                <td>${{ number_format($patient->balance, 2) }}</td>
                                <td>{{ $patient->remarks ?? 'N/A' }}</td>
                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('patient') }}">View all clients</a>
        </div>
    </div>
</div>

<div class="col-md-6 d-flex">
    <div class="card card-table flex-fill">
        <div class="card-header">
            <h3 class="card-title mb-0"> Emplooyee </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Emplooyee</th>
                            <th>Email</th>
                            <th class="text-right">PhoneNumber</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <td>
                                <h2>
                                    <a href="{{ url('project-view/' . $project->id) }}">{{ $project->name }}</a>
                                </h2>
                                <small class="block text-ellipsis">
                                    <span>{{ $project->name }}</span> 
                                    <span class="text-muted">open tasks, </span>
                                    <span>{{ $project->completed_tasks }}</span> 
                                    <span class="text-muted">tasks completed</span>
                                </small>
                            </td>
                            <td>
                                <h2>
                                    <a href="{{ url('project-view/' . $project->id) }}">{{ $project->email }}</a>
                                </h2>
                               
                            </td>
                            <td>
                            <h2>
                                    <a href="{{ url('project-view/' . $project->id) }}">{{ $project->phone_number }}</a>
                                </h2>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('employees.index') }}">View all Employee</a>
        </div>
    </div>
</div>

            </div>
        </div>
        <!-- /Page Content -->
    </div>
@endsection
