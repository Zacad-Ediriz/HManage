@extends('layout.index')

@section('home')

<div class="container">
    <h1 class="mb-4">Salary Generate List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee Name</th>
            <th>Salary Name</th>
            <th>Net Salary</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salaries as $index => $salary)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>{{ $salary->NameSalary }}</td>
                <td>{{ number_format($salary->net_salary, 2) }}</td>
                <td>
                    @if ($salary->status == 0)
                        <span class="badge bg-warning">Pending</span>
                    @elseif ($salary->status == 1)
                        <span class="badge bg-success">Paid</span>
                    @endif
                </td>
                <td>
                    @if ($salary->status == 0)
                        <!-- Pay Now Modal -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $salary->id }}">Pay Now</button>

                        <!-- Modal -->
                        <div class="modal fade" id="payModal{{ $salary->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('salary.pay', $salary->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pay Salary for {{ $salary->employee->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="account_id">Select Account</label>
                                            <select name="account_id" id="account_id" class="form-select" required>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->account_name }} (Balance: {{ number_format($account->account_balance, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Pay Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Paid</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
