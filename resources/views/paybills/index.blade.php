@extends('layout.index')
@section('home')
    <h1>paybills</h1>


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
                    <h5 class="modal-title" id="exampleModalLabel">Create new paybills</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="paybills" action="/paybills" method="post">
                        @csrf



                        <div class=" form-group mb-3">
                            <label class=" form-label"> Vendor </label>
                            <select class="form-control inputmodalselect2" name="vendor_id" id="vendor_id">
                                <option>Choose a vendor</option>
                                @foreach ($purchase as $row)
                                    {
                                    <option value="{{ $row?->id }}">{{ $row?->mypi->name }}</option>
                                    }
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" required readonly
                                id="exampleInput1" aria-describedby="Help">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Amount paid</label>
                            <input type="text" name="amount_paid" id="amount_paid" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">balance</label>
                            <input type="text" name="balance" id="balance" class="form-control" required readonly
                                id="exampleInput1" aria-describedby="Help">
                        </div>



                        <div class=" form-group mb-3">
                            <label class=" form-label"> paybills Method</label>
                            <select class="form-control inputmodalselect2" name="payment_method" id="payment_method">
                                <option>Choose a paybills method</option>
                                @foreach ($acount as $row)
                                    {
                                    <option value="{{ $row?->id }}">{{ $row?->account_name }}</option>
                                    }
                                @endforeach
                            </select>

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
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Amount Paid</th>
                    <th>balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paybills as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->vendor_id }}</td>
                        <td>${{ $row->amount }}</td>
                        <td>${{ $row->amount_paid }}</td>
                        <td>${{ $row->balance }}</td>
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




        $("document").ready(function() {
            $("#vendor_id").on("change", async function() {
                let res = await $.post("{{ route('getvendorBalance') }}", {
                    vendor_id: $(this).val(),
                    _token: "{{ csrf_token() }}"
                })
                $("#amount").val(res.balance);
            })
        });




        $(document).ready(function() {
            $("#amount_paid").on("keyup", async function() {
                updateBalance();
            });

            function updateBalance() {
                let total = parseFloat($("#amount").val()) || 0;
                let amountPaid = parseFloat($("#amount_paid").val()) || 0;
                let balance = total - amountPaid;
                $("#balance").val(balance.toFixed(2)); // Ensure balance is formatted properly
            }
            updateBalance();
        });











        const updatefn = (id) => {
            url = "{{ route('paybillsEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#purchase_price").val(el.purchase_price)
                        $("#sale_price").val(el.sale_price)
                        $("#stock").val(el.stock)
                    })


                    updateUrl = "{{ route('paybillsUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#paybills").attr("action", updateUrl)
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

            $("#paybills").attr("action", "{{ route('paybills') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('paybillsDelete', ':id') }}"
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



            swal("paybills!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
