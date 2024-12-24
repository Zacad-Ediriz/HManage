<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendor = Vendor::all();
        return view('vendor.index',compact('vendor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.index');
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

        Vendor::create($validatedData);

        return redirect('vendor')->with('message', 'vendor added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Vendor::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Vendor::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Vendor::find($id)->update([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "sex"=>$request->sex,
            "address"=>$request->address,
            "balance"=>$request->balance,
            "remarks"=>$request->remarks,

      

            ]);
            return redirect('vendor')->with('message','data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Vendor::find($id)->delete();
        return redirect('vendor')->with('message','data deleted');
    }
}
