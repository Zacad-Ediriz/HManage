<?php

namespace App\Http\Controllers;

use App\Models\service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $service = service::all();
        return view('service.index',compact('service'));
    }

    public function create()
    {
        return view('service.index');
    }

    public function store(Request $request)
    {
     
      $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        service::create($validatedData);

        return redirect('service')->with('message', 'service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return service::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return service::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        service::find($id)->update([
            "name"=>$request->name,
            "price"=>$request->price,
            "description"=>$request->description,
            ]);
            return redirect('service')->with('message','data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        service::find($id)->delete();
        return redirect('service')->with('message','data deleted');
    }
}
