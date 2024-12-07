@extends('layout.index')

@section('home')
<div class="container mt-5">
    <h1 class="text-center">Employee List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Basic Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $key => $employee)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->department->name ?? 'N/A' }}</td>
                    <td>{{ $employee->position->name ?? 'N/A' }}</td>
                    <td>{{ number_format($employee->basic_salary, 2) }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
