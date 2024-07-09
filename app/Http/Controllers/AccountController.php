<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = Account::all();
        return view('account.index', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_number' => 'required',
            'account_name' => 'required',
            'account_balance' => 'required',
        ]);

        Account::create($validatedData);

        return redirect('account')->with('message', 'Account added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Account::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        return Account::where('id', $id)->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validatedData = $request->validate([
            'account_number' => 'required',
            'account_name' => 'required',
            'account_balance' => 'required',
        ]);

        $account->update($validatedData);

   

        return redirect('account')->with('message', 'Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        account::find($id)->delete();
        return redirect('account')->with('message', 'Account deleted successfully');
    }
}

