@extends('layout.index')

@section('home')
    <h1>Expenses</h1>

    <!-- Button trigger modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="mymodal" action="/expenses" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">category</label>
                            <select class="form-control" name="category" id="category">
                                <option>Choose a Account</option>
                                @foreach ($category as $row)
                                    {

                                    <option value="{{ $row?->id }}">{{ $row?->name }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" required>
                        </div>



                        <div class="form-group mb-3">
                            <label class="form-label">Account Name</label>
                            <select class="form-control" name="account" id="account">
                                <option>Choose a Account</option>
                                @foreach ($account as $row)
                                    {

                                    <option value="{{ $row?->id }}">{{ $row?->account_name }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control" required>
                        </div>



                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="table-responsive">
        <table class="table display" id="expensesTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>category</th>
                    <th>Name</th>
                    <th>amount</th>
                    <th>Account Number</th>
                    <th>description</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->category }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ $row->account }}</td>
                        <td>{{ $row->description }}</td>

                        <td><a href="#" onclick="updatefn({{ $row['id'] }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                            <a href="#" onclick="deletefn({{ $row['id'] }})" class="btn btn-danger btn-trush"> <i
                                    class="fa fa-trash"> </i></a>
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
            $('#expensesTable').DataTable();
        });

        const updatefn = (id) => {
            url = "{{ route('expensesEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#description").val(el.description)
                    })


                    updateUrl = "{{ route('expensesUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#expensesForm").attr("action", updateUrl)
                    $('#exampleModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#exampleModal").on("hidden.bs.modal", function() {
            $("#name").val("")
            $("#description").val("")
            $("#expensesForm").attr("action", "{{ route('expenses') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('expensesDelete', ':id') }}"
            url = url.replace(':id', id)
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        location.replace(url)
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });

        }





        @if (\Session::has('message'))



            swal("account!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
