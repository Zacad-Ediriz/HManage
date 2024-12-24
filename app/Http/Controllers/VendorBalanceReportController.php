<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorBalanceReportController extends Controller
{
    //
        /**
     * @Route("/patient-balance", name="patient-balance")
     */
    public function index()
    {
        // Fetch all patients with their balances
        $patients = Vendor::select('id', 'name', 'balance')->get();

        // Calculate the total balance for display (optional)
        $totalBalance = $patients->sum('balance');

        // Return to the view with the patients and total balance
        return view('vendor.vendor', compact('patients', 'totalBalance'));
    }
    public function export()
    {
        return Excel::download(new PatientBalanceExport, 'patient_balance_report.xlsx');
    }
}










