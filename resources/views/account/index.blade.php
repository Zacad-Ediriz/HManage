@extends('layout.index')

@section('home')
    <h1>Accounts</h1>

    <!-- Button trigger modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accountModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Create new Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="accountForm" action="/account" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account_number" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Account Name</label>
                            <input type="text" name="account_name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Account Balance</label>
                            <input type="number" name="account_balance" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <br><br>
    <div class=" ">
        <table class="table display " id="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($account as $row) <!-- Assuming your collection is $accounts -->
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->account_name }}</td>
                        <td>{{ $row->account_number }}</td>
                        <td>{{ $row->account_balance }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $row->id }})" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="#" onclick="deletefn({{ $row->id }})" class="btn btn-danger btn-trush"><i class="fa fa-trash"></i></a>
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

        const updatefn = (id) => {
            let url = "{{ route('accountEdit', ':id') }}";
            url = url.replace(':id', id);
            $.get(url)
                .done((data) => {
                    data.forEach((el) => {
                        $("#account_name").val(el.account_name);
                        $("#account_number").val(el.account_number);
                        $("#account_balance").val(el.account_balance);
                    });

                    let updateUrl = "{{ route('accountUpdate', ':id') }}";
                    updateUrl = updateUrl.replace(':id', id);
                    $("#accountForm").attr("action", updateUrl);
                    $('#accountModal').modal('toggle');
                })
                .fail((error) => {
                    console.error(error);
                });
        };

        $("#accountModal").on("hidden.bs.modal", function() {
            $("#account_name").val("");
            $("#account_number").val("");
            $("#account_balance").val("");
            $("#accountForm").attr("action", "{{ route('account') }}");
        });

        const deletefn = (id) => {
            let url = "{{ route('accountDelete', ':id') }}";
            url = url.replace(':id', id);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this account!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    location.replace(url);
                } else {
                    swal("Your account is safe!");
                }
            });
        };

        @if (\Session::has('message'))
            swal("Account!", "{{ \Session::get('message') }}", "success");
        @endif
    </script>
@endsection
