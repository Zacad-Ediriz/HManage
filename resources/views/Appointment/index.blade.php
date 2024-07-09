@extends('layout.index')
@section('home')

    <h1>Appointments</h1>

    <!-- Button trigger modal -->
    <div class="row justify-content-end">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AppointmentModal">
                <i class="fa fa-plus"></i>
                Create new
            </button>
        </div>
    </div>

    <div class="modal fade" id="AppointmentModal" tabindex="-1" aria-labelledby="AppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AppointmentModalLabel">Create new Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12 mx-auto" id="AppointmentForm" action="/Appointment" method="post">
                        @csrf



                        <div class="form-group mb-3">
                            <label class="form-label">doctor</label>
                            <select name="doctor" class="form-control inputmodalselect2" required>
                                <option>Choose the Doctor</option>
                                @foreach ($doctor as $row)
                                    <option value="{{ $row?->id }}">{{ $row?->Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">patient</label>
                            <select name="patient" class="form-control inputmodalselect2" required>
                                <option>Choose the patient</option>
                                @foreach ($patient as $row)
                                    <option value="{{ $row?->id }}">{{ $row?->mypatient?->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">Appointment Start</label>
                            <input type="datetime-local" name="appointment_start" id="appointment_start"
                                class="form-control" required>
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">appointment_end</label>
                            <input type="datetime-local" name="appointment_end" id="appointment_end" class="form-control"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Reason</label>
                            <input type="text" name="reason" id="reason" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div class="table-responsive">
        <table class="table display" id="AppointmentTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Appointment Start</th>
                    <th>Appointment end</th>
                    <th>Actions</th>
                    <th>reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Appointment as $Appointment)
                    <tr>
                        <td>{{ $Appointment->id }}</td>
                        <td>{{ $Appointment->doctor }}</td>
                        <td>{{ $Appointment->patient }}</td>
                        <td>{{ $Appointment->appointment_start }}</td>
                        <td>{{ $Appointment->appointment_end }}</td>
                        <td>{{ $Appointment->reason }}</td>
                        <td>
                            <a href="#" onclick="updatefn({{ $Appointment->id }})" class="btn btn-success"><i
                                    class="fa fa-edit"></i> </a>
                            <a href="#" onclick="deletefn({{ $Appointment->id }})" class="btn btn-danger"><i
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
            url = "{{ route('AppointmentEdit', ':id') }}"
            url = url.replace(':id', id)
            $.get(url)
                .done((data) => {

                    data.forEach((el) => {
                        $("#Name").val(el.Name)
                        $("#Address").val(el.Address)
                        $("#Phone").val(el.Phone)
                    })


                    updateUrl = "{{ route('AppointmentUpdate', ':id') }}"
                    updateUrl = updateUrl.replace(':id', id)
                    $("#AppointmentForm").attr("action", updateUrl)
                    $('#AppointmentModal').modal('toggle')
                })

                .fail((error) => {
                    console.error();
                })
        }

        $("#AppointmentModal").on("hidden.bs.modal", function() {
            $("#Name").val("")
            $("#Address").val("")
            $("#Phone").val("")
            $("#AppointmentForm").attr("action", "{{ route('Appointment') }}")
        })



        const deletefn = (id) => {

            url = "{{ route('AppointmentDelete', ':id') }}"
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
            swal("Appointment!", "{{ \session::get('message') }}", "success");
        @endif


        $(document).ready(function() {
            $("#doctor").on("change", async function() {
                let doctorId = $(this).val();
                if (doctorId) {
                    let res = await $.post("{{ route('getdoctorTime') }}", {
                        doctor: doctorId,
                        _token: "{{ csrf_token() }}"
                    });
                    if (res) {
                        updateAvailableTimes(res.days, res.start_time, res.end_time);
                    }
                }
            });

            function updateAvailableTimes(days, startTime, endTime) {
                $("#appointment_start").val('');
                $("#appointment_end").val('');
            }
        });
    </script>
@endsection
