@extends('layout.index')
@section('title', $title)

@section('content')

    @include($view . '.modal')

    <div class="main-body">
        <div class="page-wrapper">
            <div class="row">


                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-header">
                            <h5>{{ $title }} {{ __('list') }}</h5>
                            {{-- @can($access . '-create') --}}
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                                <i class="fas fa-plus"></i>
                                {{ __('messages.role') }}</a>
                            {{-- @endcan --}}
                        </div>

                        <div class="card-body">
                            <!-- [ Data table ] start -->
                            <div class="table-responsive">
                                <table id="table" class="display table nowrap table-striped table-hover"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- [ Data table ] end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- End Content-->

@endsection


@section('page_js')
    <script>
        $("#table").DataTable({
            ajax: {
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                url: '{{ route($route . '.data') }}',
                dataSrc: ""
            },
        });


        $("#form").on("submit", async function(e) {
            e.preventDefault()
            data = objectifyForm($(this).serializeArray())
            res = await client($(this), '{{ route($route . '.create') }}', 'post', data)
            if (res.status == 200) {
                $("#table").DataTable().ajax.reload()
                Swal.fire({
                    text: res.data,
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
                $("#modal").modal("toggle")
            }
        })
    </script>
@endsection
