@extends('layout.index')
@section('home')
    <h1>service</h1>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa fa-plus"></i>
        Create new
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="serviceForm" action="/service" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">description</label>
                            <input type="text" name="description" id="description" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">price</label>
                            <input type="text" name="price" id="price" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>




                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <br><br>
    <div class=" ">
        <table class="table display " id="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>description</th>
                    <th>price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($service as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->description }}</td>
                        <td>{{ $row->price }}</td>
                        <td><a href="#" onclick="updatefn({{ $row['id'] }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                        <a href="#" onclick="deletefn({{ $row['id'] }})" class="btn btn-danger btn-trush"> <i
                                    class="fa fa-trash"> </i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection




@section('scripts')
    <script>
        $("document").ready(function() {

            $("#table").DataTable();
        })
        const updatefn = (id) => {
            url = "{{ route('serviceEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#description").val(el.description)
                        $("#price").val(el.price)
                    })


                    updateUrl = "{{ route('serviceUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#serviceForm").attr("action", updateUrl)
                    $('#exampleModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#exampleModal").on("hidden.bs.modal", function() {
            $("#name").val("")
            $("#description").val("")
            $("#price").val("")
            $("#serviceForm").attr("action", "{{ route('service') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('serviceDelete', ':id') }}"
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



            swal("service!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
