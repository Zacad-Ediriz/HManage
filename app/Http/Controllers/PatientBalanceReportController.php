<?php

namespace App\Http\Controllers;

use App\Models\patient;
use Illuminate\Http\Request;

class PatientBalanceReportController extends Controller
{
     /**
     * @Route("/patient-balance", name="patient-balance")
     */
    public function index()
    {
        // Fetch all patients with their balances
        $patients = patient::select('id', 'name', 'balance')->get();

        // Calculate the total balance for display (optional)
        $totalBalance = $patients->sum('balance');

        // Return to the view with the patients and total balance
        return view('patient.patient', compact('patients', 'totalBalance'));
    }
    public function export()
    {
        return Excel::download(new PatientBalanceExport, 'patient_balance_report.xlsx');
    }
}


