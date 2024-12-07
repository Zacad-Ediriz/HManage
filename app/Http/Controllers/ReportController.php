<?php

namespace App\Http\Controllers;
use App\Models\invoice;
use App\Models\Expenses;
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
    $salesRevenues = invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('total');
    $getableDues  = Appointment::whereBetween('created_at', [$fromDate, $toDate])->sum('net_fee');
    
    
    $totalRevenues = $salesRevenues + $getableDues;

    // Calculate Expenses
    $manufacturerPayments = Expenses::whereBetween('created_at', [$fromDate, $toDate])->sum('amount');
    $otherExpenses = invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('discount');
    
    $totalExpenses = $manufacturerPayments + $otherExpenses;

    // Calculate Balance
    $balance = $totalRevenues - $totalExpenses;

    return view('reports.index', compact(
        'fromDate',
        'toDate',
        'salesRevenues',
        'getableDues',
        'totalRevenues',
        'manufacturerPayments',
        'otherExpenses',
        'totalExpenses',
        'balance'
    ));
}

}


