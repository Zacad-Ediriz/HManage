@extends('layout.index')

@section('home')
    <h1 class="my-4">Payment Form</h1>

    <!-- Button to open modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Create New
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Paybill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('paymentform.store') }}" method="POST">
                        @csrf

                        <!-- Vendor Selection -->
                        <div class="mb-3">
                            <label for="vendor" class="form-label">Patient</label>
                            <select name="patient" id="vendor" class="form-select" required>
                                <option value="">Select a patient</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" data-balance="{{ $vendor->balance }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" value="{{ old('amount') }}" readonly>
                        </div>

                        <!-- Amount Paid -->
                        <div class="mb-3">
                            <label for="amount_paid" class="form-label">Amount Paid</label>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control" oninput="updateBalance()" required>
                        </div>

                        <!-- Balance -->
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="text" name="balance" id="balance" class="form-control" value="0.00" readonly>
                        </div>

                        <!-- Paybill Method -->
                        <div class="mb-3">
                            <label for="paybills_method" class="form-label">Paybills Method</label>
                            <select name="paybills_method_id" id="paybills_method" class="form-select" required>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- Table of Paybills -->
    <div class="table-responsive">
        <table class="table table-striped" id="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paybills as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->mypatient->name }}</td>

                        <td>${{ number_format($row->amount, 2) }}</td>
                        <td>${{ number_format($row->amount_paid, 2) }}</td>
                        <td>${{ number_format($row->balance, 2) }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $row['id'] }})" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="#" onclick="deletefn({{ $row['id'] }})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
      $(document).ready(function() {
            $("#table").DataTable();
        });
        const amountInput = document.getElementById('amount');
        const amountPaidInput = document.getElementById('amount_paid');
        const balanceInput = document.getElementById('balance');
        const vendorSelect = document.getElementById('vendor');

        vendorSelect.addEventListener('change', () => {
            const selectedVendor = vendorSelect.options[vendorSelect.selectedIndex];
            amountInput.value = selectedVendor.dataset.balance || 0;
            updateBalance();
        });

        function updateBalance() {
            const amount = parseFloat(amountInput.value || 0);
            const amountPaid = parseFloat(amountPaidInput.value || 0);
            balanceInput.value = (amount - amountPaid).toFixed(2);
        }

        @if (\Session::has('message'))
            swal("Paybills!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
