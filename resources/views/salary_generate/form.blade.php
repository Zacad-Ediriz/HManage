@extends('layout.index')

@section('home')

<div class="container">
    <h1 class="text-center">Salary Generate</h1>

    <!-- Modal Trigger -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salaryModal">
        Generate Salary
    </button>

    <!-- Modal Dialog -->
    <div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="salaryModalLabel">Salary Generate Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('salary_generate.store') }}" method="POST">
                        @csrf
                        
                        <!-- Salary Name -->
                        <div class="mb-3">
                            <label for="NameSalary" class="form-label">Salary Name:</label>
                            <input type="text" id="NameSalary" name="NameSalary" class="form-control" placeholder="Enter Salary Name" required>
                        </div>
                        
                        <input type="hidden" name="Status" value="Pending">


                        <!-- Salary Table -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Basic</th>
                                    <th>Gross</th>
                                    <th>Add</th>
                                    <th>Deduct</th>
                                    <th>This Month</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $employee->name }}
                                        <!-- Store employee ID -->
                                        <input type="hidden" name="employees[{{ $loop->index }}][employee_id]" value="{{ $employee->id }}">
                                    </td>
                                    <td>
                                        <!-- Basic salary (readonly) -->
                                        <input type="number" class="form-control" 
                                               name="employees[{{ $loop->index }}][basic_salary]" 
                                               value="{{ $employee->basic_salary }}" readonly>
                                    </td>
                                    <td>
                                        <!-- Gross salary (readonly) -->
                                        <input type="number" class="form-control" 
                                               name="employees[{{ $loop->index }}][gross_salary]" 
                                               id="gross_salary_{{ $employee->id }}" 
                                               value="{{ $employee->gross_salary }}" readonly>
                                    </td>
                                    <td>
                                        <!-- Additions (editable) -->
                                        <input type="number" class="form-control" 
                                               name="employees[{{ $loop->index }}][additions]" 
                                               value="0" 
                                               oninput="calculateSalary({{ $loop->index }})">
                                    </td>
                                    <td>
                                        <!-- Deductions (editable) -->
                                        <input type="number" class="form-control" 
                                               name="employees[{{ $loop->index }}][deductions]" 
                                               value="0" 
                                               oninput="calculateSalary({{ $loop->index }})">
                                    </td>
                                    <td>
                                        <!-- Net salary (calculated, readonly) -->
                                        <input type="number" class="form-control" 
                                               name="employees[{{ $loop->index }}][net_salary]" 
                                               id="this_month_{{ $employee->id }}" 
                                               value="{{ $employee->gross_salary }}" readonly>
                                    </td>
                                    <td>
                                        <!-- Remarks -->
                                        <input type="text" class="form-control" 
                                               name="employees[{{ $loop->index }}][remarks]">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        </table>

                        <!-- Save Salary Button -->
                        <button type="submit" class="btn btn-success">Save Salary</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




@section('scripts')
<script>
    // Function to calculate salary for a specific employee
    function calculateSalary(loopIndex) {
    // Get the gross salary field
    const grossSalary = parseFloat(document.querySelector(`[name="employees[${loopIndex}][gross_salary]"]`).value) || 0;

    // Get the additions and deductions fields
    const additions = parseFloat(document.querySelector(`[name="employees[${loopIndex}][additions]"]`).value) || 0;
    const deductions = parseFloat(document.querySelector(`[name="employees[${loopIndex}][deductions]"]`).value) || 0;

    // Calculate the net salary for this month
    const thisMonthSalary = (grossSalary + additions) - (deductions);

    // Update the "thisMonth" field
    document.querySelector(`[name="employees[${loopIndex}][net_salary]"]`).value = thisMonthSalary.toFixed(2);
}

</script>




@endsection
