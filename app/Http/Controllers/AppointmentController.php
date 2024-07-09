<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\patient;
use App\Models\Appointment;
use App\Models\payment_form;
use Illuminate\Http\Request;
use App\Models\doctorSchedule;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $data['Appointment'] = Appointment::get();
        $data['patient'] = payment_form::where('appointment_status', 0)->with('mypatient')->get();
        $data['doctor'] = Doctor::get();
        return view('Appointment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('paymentform.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        $validatedData = $request->validate([
            'doctor' => 'required',
            'patient' => 'required',
            'appointment_start' => 'required',
            'appointment_end' => 'required',
            'reason' => 'required',
        ]);
        $patient = payment_form::where('id', $request->patient)->first();
        $patient->update([
            "appointment_status" => 1,
        ]);
        Appointment::create($validatedData);

        DB::commit();
        return redirect('Appointment')->with('message', 'Appointment added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }



    public function getDoctorTime(Request $request)
    {
        $doctorId = $request->input('doctor');
        $schedule = doctorSchedule::where('doctor', $doctorId)->first();
        return response()->json([
            'days' => explode(',', $schedule->days),
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time,
        ]);
    }

}
