@extends('layoutuser.index')

@section('home')
    <h1>Dashboard</h1>
    <div class="d-flex flex-column flex-column-fluid">
        <div class="row">

            <div class="col-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Patients</h4>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h1>{{ $patient }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Appointments</h4>
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <h1>{{ $Appointment }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Doctors</h4>
                            <i class="fas fa-user-md fa-2x"></i>
                        </div>
                        <h1>{{ $Doctors }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Total Product</h4>
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                        <h1>{{ $product }}</h1>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
