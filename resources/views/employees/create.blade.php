@extends('layout.index')
@section('home')

<div class="container my-5">
    <h2 class="mb-4 text-center text-primary">Employee Information Form</h2>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Employee Information -->
            <div class="col-md-8">
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Employee Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nid" class="form-label">NID</label>
                                <input type="text" name="nid" class="form-control" value="{{ old('nid') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="blood_group" class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-select">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="department_id" class="form-label">Department</label>
                                <select name="department_id" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="position_id" class="form-label">Position</label>
                                <select name="position_id" class="form-control">
                                    <option value="">Select Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="joining_date" class="form-label">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guarantor and Emergency Information -->
            <div class="col-md-4">
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Guarantor Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="guarantor_name" class="form-label">Guarantor Name</label>
                            <input type="text" name="guarantor_name" class="form-control" value="{{ old('guarantor_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="guarantor_email" class="form-label">Guarantor Email</label>
                            <input type="email" name="guarantor_email" class="form-control" value="{{ old('guarantor_email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="guarantor_relation" class="form-label">Relation</label>
                            <input type="text" name="guarantor_relation" class="form-control" value="{{ old('guarantor_relation') }}">
                        </div>
                    </div>
                </div>
                <div class="card shadow-lg">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Emergency Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact') }}">
                        </div>
                        <div class="mb-3">
                            <label for="emergency_address" class="form-label">Emergency Address</label>
                            <input type="text" name="emergency_address" class="form-control" value="{{ old('emergency_address') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Salary Structure -->
        <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Employee Salary Structure</h3>
                </div>
                <div class="card-body">
                    <!-- Basic Salary -->
                    <div class="form-group mb-4">
                        <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" value="{{ $salaryStructure->basic_salary ?? 0 }}" required>
                    </div>

                    <!-- Gross Salary -->
                    <div class="form-group mb-4">
                        <label for="gross_salary" class="form-label">Gross Salary <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="gross_salary" id="gross_salary" class="form-control" value="{{ $salaryStructure->gross_salary ?? 0 }}" readonly>
                    </div>

                   

                    <!-- Submit Button -->
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Save Salary Structure</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

       
    </form>
</div>
@endsection
@section('scripts')


<script>
    const basicSalaryInput = document.getElementById('basic_salary');
    const grossSalaryInput = document.getElementById('gross_salary');

    const updateGrossSalary = () => {
        const basicSalary = parseFloat(basicSalaryInput.value || 0);

        const additions = Array.from(document.querySelectorAll('[name^="additions"]'))
            .reduce((sum, input) => sum + parseFloat(input.value || 0), 0);

        const deductions = Array.from(document.querySelectorAll('[name^="deductions"]'))
            .reduce((sum, input) => sum + parseFloat(input.value || 0), 0);

        grossSalaryInput.value = (basicSalary + additions - deductions).toFixed(2);
    };

    // Attach event listeners to all relevant inputs
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', updateGrossSalary);
    });
</script>

@endsection