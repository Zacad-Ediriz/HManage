<?php

// app/Http/Controllers/AttendanceController.php
namespace App\Http\Controllers;


use App\Models\Attendance;
use App\Models\Emplooyee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::orderBy('date', 'desc')->get();
        $employees = Emplooyee::all(); // Fetch all employees
        return view('attendance.index', compact('attendances', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:emplooyees,id', // Validate employee ID
            'date' => 'required|date',
            'time' => 'required',
            'check' => 'required|in:In,Out',
        ]);

        $employee = Emplooyee::findOrFail($request->employee_id); // Fetch employee name

        Attendance::create([
            'employee_name' => $employee->name,
            'date' => $request->date,
            'time' => $request->time,
            'check' => $request->check,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully!');
    }
}

