@extends('layout.index')
@section('home')

    <h1>Doctors</h1>

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
                    <h5 class="modal-title" id="doctorModalLabel">Create new Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="doctorForm" action="/doctor" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="Name" class="form-control" required>
                        </div>





                        <div class="form-group mb-3">
                            <label class="form-label">Sex</label>
                            <select name="Sex" class="form-control" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>



                        <div class="form-group mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="Address" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="Doctore_phone" class="form-control" required>
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
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->Name }}</td>
                        <td>{{ $doctor->Sex }}</td>
                        <td>{{ $doctor->Address }}</td>
                        <td>{{ $doctor->Doctore_phone }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $doctor->id }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                            <a href="#" onclick="deletefn({{ $doctor->id }})" class="btn btn-danger"><i
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
            url = "{{ route('DoctorEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#Name").val(el.Name)
                        $("#Address").val(el.Address)
                        $("#Phone").val(el.Phone)
                    })


                    updateUrl = "{{ route('DoctorUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#DoctorForm").attr("action", updateUrl)
                    $('#doctorModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#doctorModal").on("hidden.bs.modal", function() {
            $("#Name").val("")
            $("#Address").val("")
            $("#Phone").val("")
            $("#DoctorForm").attr("action", "{{ route('Doctor') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('DoctorDelete', ':id') }}"
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



            swal("Doctor!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
