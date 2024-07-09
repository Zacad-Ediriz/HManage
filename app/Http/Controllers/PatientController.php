<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patient = patient::all();
        return view('patient.index',compact('patient'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $validatedData = $request->validate([
            'name' => 'required',
            'sex' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'balance' => 'required',
            'remarks' => 'required',

        ]);

        patient::create($validatedData);

        return redirect('patient')->with('message', 'patient added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return patient::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return patient::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        patient::find($id)->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "sex"=>$request->sex,
            "address"=>$request->address,
            "balance"=>$request->balance,
            "remarks"=>$request->remarks,

      

            ]);
            return redirect('patient')->with('message','data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        patient::find($id)->delete();
        return redirect('patient')->with('message','data deleted');
    }
}
