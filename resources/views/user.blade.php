@extends('layout.index')
@section('home')

    <h1>Users</h1>

    <!-- Button trigger modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorModalLabel">Create new user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="doctorForm" action="/userss" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">email</label>
                            <input type="text" name="email" id="email" class="form-control" required>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-control" required>
                                <option>Choose the type</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">password</label>
                            <input type="text" name="password" id="password" class="form-control" required>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div class="table-responsive">
        <table class="table display" id="doctorTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>email</th>
                    <th>type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->type }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $row->id }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                            <a href="#" onclick="deletefn({{ $row->id }})" class="btn btn-danger"><i
                                    class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')

@section('scripts')

    <script>
        $("document").ready(function() {

            $("#table").DataTable();
        })




        const updatefn = (id) => {
            url = "{{ route('userssEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#email").val(el.email)
                        $("#type").val(el.type)
                    })


                    updateUrl = "{{ route('userssUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#DoctorForm").attr("action", updateUrl)
                    $('#doctorModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#doctorModal").on("hidden.bs.modal", function() {
            $("#name").val("")
            $("#email").val("")
            $("#type").val("")
            $("#DoctorForm").attr("action", "{{ route('userss') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('userssDelete', ':id') }}"
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



            swal("User!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
