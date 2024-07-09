<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\doctorSchedule;


class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $doctorSchedules = doctorSchedule::with('mydoct')->get();
        $doctors = Doctor::all();
        return view('doctor.doctorSchedule', compact('doctorSchedules', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctorSchedule.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([

            'doctor' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($request->days) {

            $data["days"] = implode(",", $request->days);
        }

        doctorSchedule::create($data);
        return redirect('mydoctorSchedule')->with('message', 'Doctor Schedule added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(doctorSchedule $doctorSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return DoctorSchedule::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'doctor' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($request->days) {

            $data["days"] = implode(",", $request->days);
        }

        doctorSchedule::find($request->id)->update($data);
        return redirect('mydoctorSchedule')->with('message', 'Doctor Schedule update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DoctorSchedule::find($id)->delete();

        return redirect()->route('doctorSchedule')->with('success', 'Schedule deleted successfully.');

    }
}
