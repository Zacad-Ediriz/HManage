<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::all();
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

        Service::create($validatedData);

        return redirect('service')->with('message', 'service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Service::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Service::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Service::find($id)->update([
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
        Service::find($id)->delete();
        return redirect('service')->with('message','data deleted');
    }
}
