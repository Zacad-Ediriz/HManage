@extends('layout.index')
@section('home')

    <h1>Doctor Schedules</h1>

    <!-- Button trigger modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorScheduleModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="doctorScheduleModal" tabindex="-1" aria-labelledby="doctorScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorScheduleModalLabel">Create new Doctor Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="doctorScheduleForm" action="/mydoctorSchedule" method="post">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label">days</label>
                            <select name="doctor" class="form-control inputmodalselect2" required>
                                <option>Choose the Doctor</option>
                                @foreach ($doctors as $row)
                                    <option value="{{ $row?->id }}">{{ $row?->Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="days">Days</label>
                            <select name="days[]" id="days" class="form-control inputmodalselect2"
                                multiple="multiple">
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div class="table-responsive">
        <table class="table display" id="doctorScheduleTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Days</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctorSchedules as $doctorSchedule)
                    <tr>
                        <td>{{ $doctorSchedule->id }}</td>
                        <td>{{ $doctorSchedule->mydoct?->Name }}</td>
                        <td>{{ $doctorSchedule->days }}</td>
                        <td>{{ $doctorSchedule->start_time }}</td>
                        <td>{{ $doctorSchedule->end_time }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $doctorSchedule->id }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                            <a href="#" onclick="deletefn({{ $doctorSchedule->id }})" class="btn btn-danger"><i
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
            url = "{{ route('doctorScheduleEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#doctor").val(el.doctor)
                        $("#days").val(el.days)
                        $("#start_time").val(el.start_time)
                        $("#end_time").val(el.end_time)
                    })


                    updateUrl = "{{ route('doctorScheduleUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#doctorScheduleForm").attr("action", updateUrl)
                    $('#doctorScheduleModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#doctorScheduleModal").on("hidden.bs.modal", function() {
            $("#doctor").val("")
            $("#days").val("")
            $("#start_time").val("")
            $("#end_time").val("")
            $("#doctorScheduleForm").attr("action", "{{ route('doctorSchedule') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('doctorScheduleDelete', ':id') }}"
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
            swal("Doctor Schedul!", "{{ \session::get('message') }}", "success");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.inputmodalselect2').select2({
                placeholder: "Choose days",
                allowClear: true
            });
        });
    </script>
@endsection
