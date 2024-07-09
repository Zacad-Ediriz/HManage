<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\patient;
use App\Models\product;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        $validatedData = $request->validate([
            'Name' => 'required',
            'Sex' => 'required',
            'Address' => 'required',
            'Doctore_phone' => 'required',
        ]);

        Doctor::create($validatedData);
        DB::commit();

        return redirect('doctor')->with('message', 'Doctor added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Doctor::where('id', $id)->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Department' => 'required|string|max:255',
            'Specialist' => 'required|string|max:255',
            'Doctore_Experience' => 'required|integer|min:0',
            'Birth_date' => 'required|date',
            'Sex' => 'required|string|max:1',
            'Blood_group' => 'required|string|max:3',
            'Address' => 'required|string|max:255',
            'Doctore_phone' => 'required|string|max:15',
        ]);

        $doctor->update($validatedData);

        return redirect('doctor')->with('message', 'Doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Doctor::find($id)->delete();
        return redirect('doctor')->with('message', 'Doctor deleted successfully');
    }




    public function dashbourds()
    {
        $data['Doctors'] = doctor::count();
        $data['patient'] = patient::count();
        $data['Appointment'] = Appointment::count();
        $data['product'] = product::count();
        return view('dashbourd', $data);
    }
}
