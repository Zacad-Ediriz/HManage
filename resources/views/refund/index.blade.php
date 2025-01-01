@extends('layout.index')
@section('home')
    <h1>Refund</h1>


    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="invoiceForm" action="/refund" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-12">
                                <div class=" form-group mb-3">
                                    <label class=" form-label"> patient</label>
                                    <select class="form-control inputmodalselect2" name="patient" id="patient">
                                        <option>Choose a Patient</option>
                                        @foreach ($patient as $row)
                                            {
                                            <option value="{{ $row?->id }}">{{ $row?->name }}</option>
                                            }
                                        @endforeach
                                    </select>

                                </div>

                            </div>


                            <hr>
                            <div class="row" id="myloop">


                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Type</label>
                                        <select id="type" name="type[]" class="form-control" required>
                                            <option value="">Choose a type</option>
                                            <option value="Service">Service</option>
                                            <option value="Product">Product</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Item</label>
                                        <select id="item" name="item[]" class="form-control" required>
                                            <option value="">Choose an item</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">qty</label>
                                        <input type="text" name="qty[]" id="qty" class="form-control" required
                                            id="exampleInput1" aria-describedby="Help">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">price</label>
                                        <input type="text" name="price[]" id="price" class="form-control" required
                                            readonly id="exampleInput1" aria-describedby="Help">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Item Total</label>
                                        <input type="text" name="itemTotal[]" id="itemTotal" class="form-control"
                                            readonly required id="exampleInput1" aria-describedby="Help">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <button onclick="addRow()" class="btn btn-primary  mb-3">Add Row</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">total</label>
                                    <input type="text" name="total" id="total" class="form-control" required
                                        readonly id="exampleInput1" aria-describedby="Help">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">discount</label>
                                    <input type="text" name="discount" id="discount" class="form-control" required
                                        id="exampleInput1" aria-describedby="Help">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">previose_balance</label>
                                    <input type="text" name="previose_balance" id="previose_balance"
                                        class="form-control" required readonly id="exampleInput1"
                                        aria-describedby="Help">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">net_total</label>
                                    <input type="text" name="net_total" id="net_total" class="form-control" required
                                        readonly id="exampleInput1" aria-describedby="Help">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Amount Paid</label>
                                    <input type="text" name="amount_paid" id="amount_paid" class="form-control"
                                        required id="exampleInput1" aria-describedby="Help">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Balance</label>
                                    <input type="text" name="balance" id="balance" class="form-control" required
                                        readonly id="exampleInput1" aria-describedby="Help">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Payment Method</label>
                                    <select class="form-control" name="payment_method" id="payment_method">
                                        <option>Choose a payment_method</option>
                                        @foreach ($acount as $row)
                                            {

                                            <option value="{{ $row?->id }}">{{ $row?->account_name }}</option>
                                            }
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
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
                    <th>Patient</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Net Total</th>
                    <th>Amount Paid</th>
                    <th>balance</th>
                    <th>Account</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($invoice as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row?->mypi?->name }}</td>
                        <td>$ {{ $row->total }}</td>
                        <td>$ {{ $row->discount }}</td>
                        <td>$ {{ $row->net_total }}</td>
                        <td>$ {{ $row->amount_paid }}</td>
                        <td>$ {{ $row->balance }}</td>
                        <td>{{ $row->myacount?->account_name }}</td>
                        <td>
                            {{-- <a href="#" onclick="updatefn({{ $row['id'] }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a> --}}
                            <a href="#" onclick="deletefn({{ $row['id'] }})" class="btn btn-danger btn-trush">
                                <i class="fa fa-trash"> </i></a>
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
            url = "{{ route('invoiceEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#name").val(el.name)
                        $("#phone").val(el.phone)
                        $("#sex").val(el.sex)
                        $("#address").val(el.address)
                        $("#balance").val(el.balance)
                        $("#remarks").val(el.remarks)
                    })


                    updateUrl = "{{ route('invoiceUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#invoiceForm").attr("action", updateUrl)
                    $('#exampleModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#exampleModal").on("hidden.bs.modal", function() {
            $("#name").val("")
            $("#phone").val("")
            $("#sex").val("")
            $("#address").val("")
            $("#balance").val("")
            $("#remarks").val("")
            $("#invoiceForm").attr("action", "{{ route('invoice') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('invoiceDelete', ':id') }}"
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



        function addRow() {
            let newRow = `
            <div class="row item-row">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Type</label>
                        <select name="type[]" class="form-control" required>
                            <option value="">Choose a type</option>
                            <option value="Service">Service</option>
                            <option value="Product">Product</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Item</label>
                        <select name="item[]" class="form-control" required>
                            <option value="">Choose an item</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mb-3">
                        <label class="form-label">qty</label>
                        <input type="text" name="qty[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mb-3">
                        <label class="form-label">price</label>
                        <input type="text" name="price[]" class="form-control" required readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group mb-3">
                        <label class="form-label">Item Total</label>
                        <input type="text" name="itemTotal[]" class="form-control" readonly required>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                </div>
            </div>
            <hr>
        `;
            updateTotal();
            $("#myloop").append(newRow);
        }

        function updateTotal() {
            let total = 0;
            $("input[name='itemTotal[]']").each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $("#total").val(total.toFixed(2));
        }

        // Add event listener to add row button
        $("#addRowButton").click(function() {
            addRow();
            updateTotal(); // Update total after adding a new row
        });
        // Event delegation for dynamically added remove buttons
        $(document).on("click", ".remove-row", function() {
            let itemTotal = parseFloat($(this).closest('.item-row').find("input[name='itemTotal[]']").val()) || 0;
            let total = parseFloat($("#total").val()) || 0;
            total -= itemTotal; // Subtract the itemTotal of the removed row from the total
            $("#total").val(total.toFixed(2)); // Update the total input
            $(this).closest('.item-row').remove();
        });


        $("document").ready(function() {
            $("#qty").on("change", async function() {
                updateTotal();
            })
        });



        $(document).ready(function() {
            $(document).on("change", "select[name='type[]']", async function() {
                let selectedType = $(this).val();
                if (selectedType === "Service" || selectedType === "Product") {
                    try {
                        let res = await $.post("{{ route('getInvoiceItem') }}", {
                            type: selectedType.toLowerCase(),
                            _token: "{{ csrf_token() }}"
                        });
                        $(this).closest('.row').find("select[name='item[]']").empty().append(
                            '<option value="">Choose an item</option>');
                        res.forEach(function(data) {
                            $(this).closest('.row').find("select[name='item[]']").append(
                                `<option value="${data.id}">${data.name}</option>`);
                        }.bind(this));

                        if (selectedType === "Service") {
                            $(this).closest('.row').find("input[name='qty[]']").closest('.form-group')
                                .show();
                        } else {
                            $(this).closest('.row').find("input[name='qty[]']").closest('.form-group')
                                .show();
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            });


            $(document).on("change", "select[name='item[]']", async function() {
                let selectedItem = $(this).val();
                let selectedType = $(this).closest('.row').find("select[name='type[]']").val();
                let route = selectedType === "Service" ? "{{ route('getSerivicePrice') }}" :
                    "{{ route('getitemprice') }}";

                try {
                    let res = await $.post(route, {
                        item: selectedItem,
                        _token: "{{ csrf_token() }}"
                    });
                    let price = selectedType === "Service" ? res.price : res.sale_price;
                    $(this).closest('.row').find("input[name='price[]']").val(price);
                    $(this).closest('.row').find("input[name='itemTotal[]']").val(price);
                } catch (error) {
                    console.error(error);
                }
            });

            $(document).on("input", "input[name='qty[]']", function() {
                let row = $(this).closest('.row');
                calculateItemTotal(row);
            });

            function calculateItemTotal(row) {
                let qty = parseFloat(row.find("input[name='qty[]']").val()) || 0;
                let price = parseFloat(row.find("input[name='price[]']").val()) || 0;
                let itemTotal = qty * price;
                row.find("input[name='itemTotal[]']").val(itemTotal.toFixed(2));
            }

        });




        $("document").ready(function() {
            $("#patient").on("change", async function() {
                let res = await $.post("{{ route('getpateintBalance') }}", {
                    patient: $(this).val(),
                    _token: "{{ csrf_token() }}"
                })
                $("#previose_balance").val(res.balance);
            })
        });

        $(document).ready(function() {
            $("#discount, #amount_paid").on("keyup", async function() {
                calculateNetTotal();
                updateBalance();
            });

            // Function to calculate net total
            function calculateNetTotal() {
                let total = parseFloat($("#total").val()) || 0;
                let previousBalance = parseFloat($("#previose_balance").val()) || 0;
                let discount = parseFloat($("#discount").val()) || 0;
                let netTotal = total + previousBalance - discount;
                $("#net_total").val(netTotal.toFixed(2)); // Ensure net total is formatted properly
            }

            // Function to update balance
            function updateBalance() {
                let total = parseFloat($("#net_total").val()) || 0;
                let amountPaid = parseFloat($("#amount_paid").val()) || 0;
                let balance = total - amountPaid;
                $("#balance").val(balance.toFixed(2)); // Ensure balance is formatted properly
            }
            calculateNetTotal();
            updateBalance();
        });







        @if (\Session::has('message'))



            swal("invoice!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
@endsection
