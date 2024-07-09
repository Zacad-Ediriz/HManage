<?php

namespace App\Http\Controllers;

use App\Models\emplooyee;
use Illuminate\Http\Request;

class EmplooyeeController extends Controller
{
    public function index()
    {
        $emplooyee = emplooyee::all();
        return view('emplooyee.index',compact('emplooyee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emplooyee.index');
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
        ]);

        emplooyee::create($validatedData);

        return redirect('emplooyee')->with('message', 'emplooyee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return emplooyee::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return emplooyee::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        emplooyee::find($id)->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "sex"=>$request->sex,
            "address"=>$request->address,


            ]);
            return redirect('emplooyee')->with('message','data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        emplooyee::find($id)->delete();
        return redirect('emplooyee')->with('message','data deleted');
    }
}
