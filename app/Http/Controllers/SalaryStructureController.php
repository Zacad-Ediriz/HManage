<?php

namespace App\Http\Controllers;

use App\Models\SalaryStructure;
use Illuminate\Http\Request;

class SalaryStructureController extends Controller
{
    // Display the list of salary structures
    public function index()
    {
        $salaryStructures = SalaryStructure::all();
        return view('salary_structures.index', compact('salaryStructures'));
    }

    // Store a new salary structure
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Add,Deduct',
        ]);

        SalaryStructure::create($request->all());
        return redirect()->route('salary_structures.index')->with('success', 'Salary structure created successfully.');
    }

    // Fetch data for editing
    public function edit(SalaryStructure $salaryStructure)
    {
        return response()->json($salaryStructure);
    }

    // Update a salary structure
    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Add,Deduct',
        ]);

        $salaryStructure->update($request->all());
        return redirect()->route('salary_structures.index')->with('success', 'Salary structure updated successfully.');
    }

    // Delete a salary structure
    public function destroy(SalaryStructure $salaryStructure)
    {
        $salaryStructure->delete();
        return redirect()->route('salary_structures.index')->with('success', 'Salary structure deleted successfully.');
    }
}
