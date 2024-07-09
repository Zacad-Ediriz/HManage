@extends('layout.index')
@section('home')
    <h1>product</h1>


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
                    <h5 class="modal-title" id="exampleModalLabel">Create new product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="productForm" action="/product" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">name</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Purchase Price</label>
                            <input type="text" name="purchase_price" id="purchase_price" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="text" name="sale_price" id="sale_price" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Stock</label>
                            <input type="text" name="stock" id="stock" class="form-control" required
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
                    <th>Purchase Price</th>
                    <th>Sale Price</th>
                    <th>Stock</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>${{ $row->purchase_price }}</td>
                        <td>${{ $row->sale_price }}</td>
                        <td>{{ $row->stock }} qty</td>
                        <td>${{ $row->stock * $row->sale_price }}</td>
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
        $("document").ready(function() {

            $("#table").DataTable();
        })
        const updatefn = (id) => {
            url = "{{ route('productEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#purchase_price").val(el.purchase_price)
                        $("#sale_price").val(el.sale_price)
                        $("#stock").val(el.stock)
                    })


                    updateUrl = "{{ route('productUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#productForm").attr("action", updateUrl)
                    $('#exampleModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#exampleModal").on("hidden.bs.modal", function() {
            $("#name").val("")
            $("#purchase_price").val("")
            $("#sale_price").val("")
            $("#stock").val("")

            $("#productForm").attr("action", "{{ route('product') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('productDelete', ':id') }}"
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



            swal("product!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
