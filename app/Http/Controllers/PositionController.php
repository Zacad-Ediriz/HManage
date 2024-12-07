<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // Show all positions
    public function index()
    {
        $positions = Position::all();
        return view('positions.index', compact('positions'));
    }

    // Store a new position
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Position::create($request->all());
        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    // Edit a position
    public function edit(Position $position)
    {
        return response()->json($position);
    }

    // Update a position
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $position->update($request->all());
        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    // Delete a position
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }
}
