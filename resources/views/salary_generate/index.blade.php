@extends('layout.index')

@section('home')
<div class="container">
    <h2>Salary Generate List</h2>
    <a href="{{ route('salary_generate.create') }}" class="btn btn-primary">Generate New</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>SL</th>
                <th>Employee Name</th>
                <th>Basic Salary</th>
                <th>Gross Salary</th>
                <th>Additions</th>
                <th>Deductions</th>
                <th>Net Salary</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $key => $salary)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $salary->employee->name }}</td>
                    <td>{{ $salary->basic_salary }}</td>
                    <td>{{ $salary->gross_salary }}</td>
                    <td>{{ $salary->additions }}</td>
                    <td>{{ $salary->deductions }}</td>
                    <td>{{ $salary->net_salary }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
