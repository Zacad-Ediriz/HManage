@extends('layout.index')

@section('home')
<div class="container-fluid">
    <div class="row">
        <!-- Left Panel (Appointment Form) -->
        <div class="col-md-6 bg-light p-4 border">
            <h3 class="mb-4">Make Appointment</h3>
            <form action="{{ route('appointment.store') }}" method="POST">
                @csrf

                <!-- Date -->
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input 
                        type="date" 
                        id="date" 
                        name="appointment_time" 
                        class="form-control" 
                        value="{{ now()->format('Y-m-d') }}" 
                        readonly 
                        required>
                </div>


             

                <div class="form-group">
                <label for="doctor">Doctor:</label>
                <select id="doctor" name="doctor" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" data-schedules="{{ $doctor->schedules }}">
                            {{ $doctor->Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Doctor Schedules -->
            <div id="schedule-container" class="form-group mt-3" style="display: none;">
                <label for="schedule">Schedule:</label>
                <select id="schedule" name="schedule" class="form-control">
                    <option value="">-- Select Schedule --</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->schedule_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mt-3">
                <label for="serial">Serial:</label>
                <input 
                    type="number" 
                    id="serial" 
                    name="serial" 
                    class="form-control" 
                    value="1" 
                    style="color: green;" 
                    readonly>
                <small id="serial-warning" class="text-danger" style="display: none;">Serial exceeds the number of visits!</small>
            </div>

            
            <!-- Consultant Fee -->
            <div class="form-group">
                <label for="consultant_fee">Consultant Fee:</label>
                <input type="number" id="consultant_fee" name="consultant_fee" class="form-control" value="0" readonly>
            </div>
            
            <!-- Patient Selection -->
            <div class="form-group">
                <label for="patient">Patient:</label>
                <div class="d-flex">
                    <select id="patient-select" name="patient" class="form-control">
                        <option value="">-- Select Existing Patient --</option>
                        @foreach($zz as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="add-new-patient-btn" class="btn btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#addPatientModal">+</button>
                </div>
            </div>



                <!-- Discount -->
                <div class="form-group">
                    <label for="discount">Discount:</label>
                    <input type="number" id="discount" name="discount" class="form-control" value="0">
                </div>

                <!-- Net Fee -->
                <div class="form-group">
                    <label for="net_fee">Net Fee:</label>
                    <input type="number" id="net_fee" name="net_fee" class="form-control" value="0" readonly>
                </div>

                <!-- Payment Status -->
                <div class="form-group">
                    <div>
                        
                        
                        <input type="checkbox" id="payment_status" name="payment_status" value="1" onchange="toggleAccountSelection()">
                        <label for="payment_status">Received Fees</label>
                    </div>
                </div>
                <div id="account-selection" class="form-group" style="display: none;">
                    <label for="account_number">Select Account:</label>
                    <select id="account_number" name="account_number" class="form-control">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_name }} (Balance: {{ $account->account_balance }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Remark -->
                <div class="form-group">
                    <label for="remark">Remark:</label>
                    <textarea id="remark" name="remark" class="form-control" placeholder="Short Note..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success btn-block">Make Appointment</button>
            </form>
        </div>

        <!-- Right Panel (Calendar and Appointments) -->
      <!-- Calendar and Appointments -->
            <div class="col-md-6 p-4 border">
                <h3 class="mb-4">Appointments on <span id="selected-date">Select a Date</span></h3>
                <div id="appointment-list">
                    <p>No appointments yet.</p>
                </div>
                <div id="calendar" class="mt-4"></div>
            </div>
            
            <!-- Modal for Appointment Details -->
            <div class="modal" id="appointmentModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="appointment-details">
                            <!-- Appointment details dynamically injected -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


    <!-- Second Row (Payment Section) -->
    <div class="row mt-5">
        <div class="col-md-12 bg-light p-4 border">
            <h3 class="mb-4">Payment Section</h3>
            <form action="{{ route('appointment.storePayment') }}" method="POST">
    @csrf

    <!-- Select Patient -->
                    <div class="form-group">
                    <label for="patient-select">Patient <span class="text-danger">*</span>:</label>
                    <select id="patient-select" name="patient" class="form-control" required>
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            @foreach ($patient->appointments as $appointment)
                                <option 
                                    value="{{ $patient->id }}" 
                                    data-net-fee="{{ $appointment->net_fee }}">
                                    {{ $patient->name }} (Net Fee: {{ $appointment->net_fee }})
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="net_fees">Net Fees <span class="text-danger">*</span>:</label>
                    <input type="number" id="net_fees" name="amount" class="form-control" value=
                                  "{{ $appointment->net_fee }}" readonly>
                </div>
            
                <!-- Payment Method -->
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <select class="form-control" name="account_number" id="payment_method">
                        <option>Choose a payment method</option>
                        @foreach ($accounts as $row)
                            <option value="{{ $row->id }}">{{ $row->account_name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Submit Payment -->
                <button type="submit" class="btn btn-primary btn-block">Make Payment</button>
            </form>

        </div>
    </div>
</div>

<!-- Modal for Adding New Patient -->


<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form class="col-md-12 mx-auto" id="patientForm" action="/patient" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>

                        <div class=" form-group mb-3">
                            <label class=" form-label"> sex</label>
                            <select class="form-control" name="sex" id="sex">
                                <option>Choose a sex</option>
                                <option value="male">male</option>
                                <option value="femail">femail</option>
                            </select>

                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">balance</label>
                            <input type="text" name="balance" id="balance" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">remarks</label>
                            <input type="text" name="remarks" id="remarks" class="form-control" required
                                id="exampleInput1" aria-describedby="Help">
                        </div>




                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    // Initialize Calendar
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const appointmentListEl = document.getElementById('appointment-list');
        const selectedDateEl = document.getElementById('selected-date');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            dateClick: function (info) {
                const selectedDate = info.dateStr;
                selectedDateEl.textContent = selectedDate;
                fetch(`/api/appointments?date=${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        appointmentListEl.innerHTML = '';
                        if (data.appointments.length > 0) {
                            data.appointments.forEach(appt => {
                                appointmentListEl.innerHTML += `
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <h5 class="card-title">#${appt.serial} - ${appt.patient}</h5>
                                            <p>Doctor: ${appt.doctor}<br>Schedule: ${appt.schedule}<br>Time: ${appt.time}</p>
                                        </div>
                                    </div>`;
                            });
                        } else {
                            appointmentListEl.innerHTML = '<p>No appointments yet.</p>';
                        }
                    });
            },
        });

        calendar.render();
    });


    
  
    // document.addEventListener('DOMContentLoaded', function() {
    //     const patientSelect = document.getElementById('patient-select');
    //     const netFeesInput = document.getElementById('net_fees');

    //     patientSelect.addEventListener('change', function() {
    //         const selectedOption = patientSelect.options[patientSelect.selectedIndex];
    //         const netFee = selectedOption ? selectedOption.getAttribute('data-net-fee') : 0;

    //         // Update the net fee input field
    //         netFeesInput.value = netFee;
    //     });
    // });
    
    function toggleAccountSelection() {
        const paymentStatusCheckbox = document.getElementById('payment_status');
        const accountSelection = document.getElementById('account-selection');

        if (paymentStatusCheckbox.checked) {
            accountSelection.style.display = 'block'; // Show the account selection field
        } else {
            accountSelection.style.display = 'none'; // Hide the account selection field
        }
    }
    
    document.addEventListener("DOMContentLoaded", function () {
    const doctorSelect = document.getElementById("doctor");
    const scheduleContainer = document.getElementById("schedule-container");
    const scheduleSelect = document.getElementById("schedule");
    const consultantFeeInput = document.getElementById("consultant_fee");

    doctorSelect.addEventListener("change", function () {
        const selectedDoctor = doctorSelect.options[doctorSelect.selectedIndex];
        const schedules = JSON.parse(selectedDoctor.getAttribute("data-schedules") || "[]");

        // Populate the schedule dropdown
        scheduleSelect.innerHTML = '<option value="">-- Select Schedule --</option>';
        schedules.forEach(schedule => {
            const option = document.createElement("option");
            option.value = schedule.id;
            option.textContent = `${schedule.schedule_name} - ${schedule.schedule_name}`;
            option.dataset.fee = schedule.fees;
            scheduleSelect.appendChild(option);
        });

        // Show or hide the schedule container
        scheduleContainer.style.display = schedules.length > 0 ? "block" : "none";

        // Reset fee input
        consultantFeeInput.value = 0;
    });

    scheduleSelect.addEventListener("change", function () {
        const selectedSchedule = scheduleSelect.options[scheduleSelect.selectedIndex];
        consultantFeeInput.value = selectedSchedule.dataset.fee || 0;
    });
});

document.getElementById('discount').addEventListener('input', function () {
        const consultantFee = parseFloat(document.getElementById('consultant_fee').value) || 0;
        const discount = parseFloat(this.value) || 0;
        const netFee = consultantFee - discount;

        document.getElementById('net_fee').value = netFee < 0 ? 0 : netFee; // Ensures the net fee is not negative
    });


    

</script>
@endsection
