@extends('layout.index')

@section('home')
<div class="container mt-5">
    <h1 class="text-center">Employee List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
    <div class="card shadow-sm">
    <div class="card-body p-0">
    <!-- Table -->
    <table  class="table table-striped table-hover mb-0" id="table">
        <thead class="bg-primary text-white">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Basic Salary</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->department->name ?? 'N/A' }}</td>
                    <td>{{ $employee->position->name ?? 'N/A' }}</td>
                    <td>{{ number_format($employee->basic_salary, 2) }}</td>
                    
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
