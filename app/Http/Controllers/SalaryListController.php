<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryList;
use App\Models\Account;
use App\Models\SalaryGenerate;

class SalaryListController extends Controller
{
    public function GG()
    {
        $salaries = SalaryGenerate::with(['employee'])->get();
        $accounts = Account::all();
        return view('salary.index', compact('salaries', 'accounts'));
    }

    public function paySalary($id, Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:account,id',
        ]);

        $salary = SalaryGenerate::findOrFail($id);
        $account = Account::findOrFail($request->account_id);

        if ($account->account_balance >= $salary->net_salary) {
            // Step 1: Deduct balance from account
            $account->account_balance -= $salary->net_salary;
            $account->save();

            // Step 2: Record the payment in SalaryList
            SalaryList::create([
                'employee_name' => $salary->employee->name,
                'NameSalary'=>$salary->NameSalary,
                'net_salary' => $salary->net_salary,
                'Status' => 1, // Paid
                'account_id' => $account->id,
            ]);

            // Step 3: Update the status in SalaryGenerate
            $salary->status = 1; // Mark as Paid
            $salary->save();

            return redirect()->back()->with('success', 'Salary paid successfully!');
        }

        return redirect()->back()->with('error', 'Insufficient balance in the selected account!');
    }
    // public function paySalary(Request $request, $id)
    // {
    //     $request->validate([
    //         'account_id' => 'required|exists:account,id',
    //     ]);
    
    //     $salary = SalaryList::findOrFail($id);
    //     $account = Account::findOrFail($request->account_id);
    
    //     if ($account->account_balance >= $salary->net_salary) {
    //         DB::transaction(function () use ($salary, $account) {
    //             $account->account_balance -= $salary->net_salary;
    //             $account->save();
    
    //             $salary->Status = '1'; // Mark as paid
    //             $salary->save();
    //         });
    
    //         return response()->json(['success' => 'Salary paid successfully!']);
    //     }
    
    //     return response()->json(['error' => 'Insufficient account balance!'], 400);
    // }
    
    

    
 
 

    
    
    
}
