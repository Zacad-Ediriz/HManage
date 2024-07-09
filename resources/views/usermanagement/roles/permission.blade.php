@extends('layout.index')


@section('page-toolbar')
    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
        <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Give permission</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">User management</li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">Roles</li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">permission</li>
        </ul>
    </div>
@endsection



@section('content')

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    Permissions for {{ $role }}
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter Options</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <form action="">
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Module:</label>
                                    <select class="form-select form-select-solid fw-bold" name="module"
                                        data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-user-table-filter="role" data-hide-search="false">
                                        <option value=""> -- Select --</option>
                                        @foreach ($modules as $item)
                                            <option value="{{ $item?->id }}"
                                                @if ($module == $item?->id) selected @endif>{{ $item?->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{-- <button type="reset"
                                        class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                        data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button> --}}
                                    <button type="submit" class="btn btn-primary fw-semibold px-6"
                                        data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-body py-4">
            {{-- <form action="{{ route('roles.givePermission', $id) }}" method="post">
                @csrf --}}
            <div class="">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <tbody class="text-gray-600 fw-semibold">
                        @if (count($permissions))
                            @foreach ($permissions as $key => $value)
                                <td class="text-gray-800" style="width: 250px !important;">{{ $key }}</td>
                                @foreach ($value as $k => $v)
                                    <tr>
                                    <tr>
                                        <td class="text-gray-800" style="width: 250px !important;">{{ $k }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach ($v as $permission)
                                                    <div class="col-4 mb-10">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-9">
                                                            <input class="form-check-input" onchange="saveper(this)"
                                                                type="checkbox" value="{{ $permission->name }}"
                                                                name="permission[]" id="permission_{{ $permission?->id }}"
                                                                {{ in_array($id, $permission->roles?->pluck('id')->toArray()) == 10 ? 'checked' : '' }}>
                                                            <span class="form-check-label"
                                                                for="permission_{{ $permission?->id }}"
                                                                style="color: black;
                                                            font-size: 14px;">{{ $permission?->title }}</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td class="text-gray-800 text-center fs-2 fst-italic" style="width: 250px !important;">No
                                    data available</td>

                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-outline ki-plus fs-2"></i>Save</button>

                </div> --}}
            {{-- </form> --}}
        </div>
    </div>
@endsection


@section('page_js')
    <script>
        $(function() {




        })

        const saveper = (element) => {
            element = $(element)
            if (element.is(':checked')) {
                $.post('{{ route($route . '.givePermission', $id) }}', {
                        _token: "{{ csrf_token() }}",
                        id: element.val(),
                        permission: 1
                    })
                    .done((data) => {
                        if (!data.success) {
                            console.error(data.err)
                            swal.fire("Permission", data.msg, "error");
                            return
                        }
                        iziToast.success({
                            title: 'Permission',
                            message: data.msg,
                            position: "topRight"
                        });
                    })
                    .fail((error) => {
                        swal.fire("Permission", "Something went wrong!!!", "success");
                        console.error(error)
                    })
            } else {
                $.post('{{ route($route . '.givePermission', $id) }}', {
                        _token: "{{ csrf_token() }}",
                        id: element.val(),
                        permission: 0
                    })
                    .done((data) => {
                        if (!data.success) {
                            console.error(data.err)
                            swal.fire("Permission", data.msg, "error");
                            return
                        }
                        iziToast.success({
                            title: 'Permission',
                            message: data.msg,
                            position: "topRight"
                        });
                    })
                    .fail((error) => {
                        swal.fire("Permission", "Something went wrong!!!", "success");
                        console.error(error)
                    })
            }
        }
    </script>
@endsection
