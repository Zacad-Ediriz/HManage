<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Patient;
class SalesReportController extends Controller
{
    // public function index(Request $request)
    // {
    //     $fromDate = $request->input('from_date', '2020-11-18');
    //     $toDate = $request->input('to_date', now()->format('Y-m-d'));
    //     $patient = $request->input('patient', null);

    //     // Query invoices
    //     $query = Invoice::query();

    //     if ($fromDate && $toDate) {
    //         $query->whereBetween('created_at', [$fromDate, $toDate]);
    //     }

    //     if ($patient) {
    //         $query->where('patient_name', 'LIKE', "%{$patient}%");
    //     }

    //     $invoices = $query->get(); // Always get objects
       
    //     // Map data for the view
    //     $salesReports = $invoices->map(function ($invoice) {
    //         return [
    //             'id' => $invoice->id,
    //             'date' => $invoice->created_at->format('M d, Y'),
    //             'invoice' => $invoice->invoice_number,
    //             'patient' => $invoice->patient_name,
    //             'sub_total' => $invoice->sub_total,
    //             'discount' => $invoice->discount,
    //             'grand_total' => $invoice->grand_total,
    //             'net_amount' => $invoice->net_amount,
    //             'dues' => $invoice->dues,
    //         ];
    //     });
       
    //     return view('sales_report.index', compact('salesReports', 'fromDate', 'toDate', 'patient'));
    // }
    
    
    
    //     public function index(Request $request)
    // {
    //     $fromDate = $request->input('from_date', now()->startOfMonth()->toDateString());
    //     $toDate = $request->input('to_date', now()->toDateString());
    //     $patient = $request->input('patient', null);
    //     $query = Invoice::query();
    //     // Calculate Revenues
    //     if ($fromDate && $toDate) {
    //                 $query->whereBetween('created_at', [$fromDate, $toDate]);
    //             }
        
    //             if ($patient) {
    //                 $query->where('patient_name', 'LIKE', "%{$patient}%");
    //             }
        
    //     $ss = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('id');
    //    // $dd  = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('invoice_number');
    //     $ff = patient::whereBetween('created_at', [$fromDate, $toDate])->sum('name');
    //     //$gg = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('sub_total');
    //     $salesRevenues = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('discount');
    //   //  $getableDues  = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('grand_total');
    //     $manufacturerPayments = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('net_total');
    //    // $otherExpenses = Invoice::whereBetween('created_at', [$fromDate, $toDate])->sum('due');
        
        
    
    //     return view('sales_report.index', compact(
    //         'fromDate',
    //         'toDate',
    //         'ss','ff',
    //         'salesRevenues',
    //         'manufacturerPayments',
           
           
            
    //     ));
    // }
    
    
    
 
    public function index(Request $request)
    {
        // Fetch data based on filters
        $startDate = $request->input('start_date', '2020-11-18');
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $customer = $request->input('customer', null);

        $query = Invoice::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($customer) {
            $query->where('patient', $customer);
        }
    
        $invoices = $query->get();

        // Totals
        $totals = [
            'subtotal' => $invoices->sum('total'),
            'discount' => $invoices->sum('discount'),
            'net_total' => $invoices->sum('net_total'),
            'amount_paid' => $invoices->sum('amount_paid'),
            'balance' => $invoices->sum('balance'),
        ];

        return view('sales_report.index', compact('invoices', 'totals', 'startDate', 'endDate', 'customer'));
    }
}



