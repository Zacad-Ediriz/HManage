<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\expensescategory;

class expensescategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expensescategory = expensescategory::get();
        return view('expensescategory.index', compact('expensescategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expensescategory.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        expensescategory::create($validatedData);

        return redirect('expensescategory')->with('message', 'expenses category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return expensescategory::where('id', $id)->get();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return expensescategory::where('id', $id)->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        expensescategory::find($id)->update([
            "name" => $request->name,
            "description" => $request->description,


        ]);
        return redirect('expensescategory')->with('message', 'data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        expensescategory::find($id)->delete();
        return redirect('expensescategory')->with('message', 'data deleted');
    }
}
