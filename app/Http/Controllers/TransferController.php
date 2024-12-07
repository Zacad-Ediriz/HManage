<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    // Display the transfer form
    public function showTransferForm()
    {
        // Retrieve all accounts from the database to populate the form
        $accounts = Account::all();

        // Return the transfer form view with the accounts data
        return view('transfer.form', compact('accounts'));
    }

    // Handle the transfer operation
    public function performTransfer(Request $request)
    {
        // Validate the request
        $request->validate([
            'from_account_id' => 'required|exists:account,id|different:to_account_id',
            'to_account_id' => 'required|exists:account,id',
            'amount' => 'required|numeric|min:0.01',
            'Description'=> 'required|string|max:255'
        ]);

        // Find the accounts involved
        $fromAccount = Account::findOrFail($request->from_account_id);
        $toAccount = Account::findOrFail($request->to_account_id);

        // Check if the source account has enough balance
        if ($fromAccount->account_balance < $request->amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance in the source account.']);
        }

        // Perform the transfer
        $fromAccount->account_balance -= $request->amount;
        $toAccount->account_balance += $request->amount;

        // Save the updated account balances
        $fromAccount->save();
        $toAccount->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Transfer completed successfully.');
    }
}
