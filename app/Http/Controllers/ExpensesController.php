<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\expensescategory;
use Illuminate\Support\Facades\DB;
use App\Models\Expenses; // Import the Expenses model
//use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all expenses with related account information
        $expenses = Expenses::with('account')->get();
        $data['account'] = Account::get();
        $data['category'] = expensescategory::get();

        // Return the view with the expenses data
        return view('expenses.index', compact('expenses'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new expense
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Assuming your Account model is in the App\Models namespace

    public function store(Request $request)
    {
        // Validate the request data
        DB::beginTransaction();
        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'account' => 'required',

        ]);

        $account = Account::where('id', $validatedData['account'])->first();

        $netbalance = $account->account_balance - $request->amount;

        $account->update(['inputbalance' => $netbalance]);

        // Create a new Expenses instance and save it
        Expenses::create([
            'category' => $validatedData['category'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'amount' => $validatedData['amount'],
            'account' => $validatedData['account'],
        ]);
        DB::commit();
        // Redirect back with a success message
        return redirect()->back()->with('message', 'Expense added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        // Return the view to display a specific expense
        return view('pages.expenses.show', compact('expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenses $expenses)
    {
        // Return the view for editing a specific expense
        return view('pages.expenses.edit', compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenses $expenses)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'ExpensesDescr' => 'required',
            'AccountNumber' => 'required',
            'Balance' => 'required',

        ]);

        // Update the expense with the validated data
        $expenses->update($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        // Delete the expense
        $expenses->delete();

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Expense deleted successfully');
    }
}
