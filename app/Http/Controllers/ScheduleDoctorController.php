<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDoctor;
use App\Models\Doctor; // Assuming doctors are users
use Illuminate\Http\Request;

class ScheduleDoctorController extends Controller
{
    public function index()
    {
        // Get schedules along with associated doctors
        $schedules = ScheduleDoctor::with('doctor')->get();
        $doctors = Doctor::all();
        return view('schedule.index', compact('schedules', 'doctors'));
        
       
       
    }
    
    public function create()
    {
        // Retrieve all doctors to populate the dropdown
        $doctors = Doctor::all();
        return view('schedule.create', compact('doctors'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'schedule_name' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctor,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'fees' => 'required|numeric',
            'number_of_visits' => 'required|integer',
        ]);
    
        ScheduleDoctor::create($request->all());
    
        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully.');
    }
    
}

