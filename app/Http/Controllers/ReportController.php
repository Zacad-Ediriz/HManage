<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Expenses;
use App\Models\Pay_bills;
use App\Models\SalaryList;
use App\Models\Payment_formm;
use App\Models\Payment_form;
use App\Models\Purchase;
use App\Models\Appointment;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //

    public function profitAndLoss(Request $request)
{
    $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
    $toDate = $request->input('to_date', now()->toDateString());

    // Calculate Revenues
    $z = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('amount_paid');
    $getableDues  = Appointment::whereBetween('created_at', [$fromDate, $toDate])->sum('net_fee');
    $zz = Payment_form::whereBetween('created_at', [$fromDate, $toDate])->sum('amount_paid');
    
    $salesRevenues= $z +  $zz;
    
    
    
    $totalRevenues = $salesRevenues + $getableDues ;

    // Calculate Expenses
    $CostOfGoodSold2=Pay_bills::whereBetween('created_at', [$fromDate, $toDate])->sum('amount_paid');
    $CostOfGoodSold1=Purchase::whereBetween('created_at', [$fromDate, $toDate])->sum('amount_paid');
    
    $EmployeeSalary = SalaryList::whereBetween('created_at', [$fromDate, $toDate])->sum('net_salary');
    $manufacturerPayments = Expenses::whereBetween('created_at', [$fromDate, $toDate])->sum('amount');
    
    $CostOfGoodSold = $CostOfGoodSold2 + $CostOfGoodSold1;
    
    $totalExpenses = $manufacturerPayments + $CostOfGoodSold + $EmployeeSalary;

    // Calculate Balance
    $balance = $totalRevenues - $totalExpenses;

    return view('reports.index', compact(
        'fromDate',
        'toDate',
        'salesRevenues',
        'getableDues',
        'totalRevenues',
        'manufacturerPayments',
        
        'totalExpenses',
        'balance' ,'CostOfGoodSold', 'EmployeeSalary'
    ));
}

}


