<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Vendor;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        // Fetch data based on filters
        $startDate = $request->input('start_date', '2020-11-18');
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $customer = $request->input('vendor', null);

        $query = Purchase::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($customer) {
            $query->where('vendor', $customer);
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

        return view('sales_report.purchase', compact('invoices', 'totals', 'startDate', 'endDate', 'customer'));
    }
    //
}
