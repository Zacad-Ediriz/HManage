<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Service;
use App\Models\Payment_form;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;

class PaymentFormController extends Controller
{
    // public function index()
    // {
    //     $payment = payment_form::all();
    //     $data['invoice'] = Invoice::with('mypi')->where('payment_status', 'pending')
    //         ->orWhere('payment_status', 'partial')
    //         ->get();

    //     $data['patient'] = Patient::get();
    //     $data['payment_method'] = Account::get();
    //     return view('paymentform.index', compact('payment'), $data);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */

    // public function create()
    // {
    //     return view('paymentform.index');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {

    //     DB::beginTransaction();
    //     $validatedData = $request->validate([
    //         'invoice' => 'required',
    //         'amount' => 'required',
    //         'amount_paid' => 'required',
    //         'balance' => 'required',
    //         'payment_method' => 'required',
    //     ]);

    //     $invoice = Invoice::where('id', $request->invoice)->first();
    //     $validatedData['patient'] = $invoice->patient;
    //     $validatedData['appointment_status'] = 0;

    //     $account = Account::where('id', $request->payment_method)->first();
    //     $myBalance = $account->account_balance;

    //     $account->update([
    //         "account_balance" => $myBalance + $request->amount_paid,
    //     ]);

    //     $patient = Patient::where('id', $invoice->patient)->first();
    //     $patient->update([
    //         "balance" => $request->balance,
    //     ]);

    //     $amount = $invoice->balance;
    //     $amount_paid = $request->amount_paid;
    //     if ($amount_paid >= $amount) {
    //         $payment_status = 'paid';
    //     } elseif ($amount_paid > 0) {
    //         $payment_status = 'partial';
    //     } else {
    //         $payment_status = 'pending';
    //     }

    //     $invoice->update([
    //         "balance" => $request->balance,
    //         "payment_status" => $payment_status,
    //         "amount_paid" => $amount_paid,
    //     ]);
    //     Payment_form::create($validatedData);

    //     DB::commit();
    //     return redirect('paymentform')->with('message', 'payment_form added successfully');

    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     return Payment_form::where('id', $id)->get();
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     return Payment_form::where('id', $id)->get();
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     Payment_form::find($id)->update([
    //         "name" => $request->name,
    //         "phone" => $request->phone,
    //         "sex" => $request->sex,
    //         "address" => $request->address,
    //         "balance" => $request->balance,
    //         "remarks" => $request->remarks,



    //     ]);
    //     return redirect('payment_form')->with('message', 'data updated');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     Payment_form::find($id)->delete();
    //     return redirect('payment_form')->with('message', 'data deleted');
    // }


    // public function getInvoiceBalance(Request $request)
    // {
    //     $amount = Invoice::where('id', $request->invoice)->first();
    //     return response()->json($amount);
    // }

    public function index(Request $request)
    {
        $paybills = Payment_form::with('mypatient')->get();
        $vendors = Patient::all(['id', 'name', 'balance']);
        $accounts = Account::all(['id', 'account_name']);
    
        return view('paymentform.index', compact('vendors', 'accounts', 'paybills'));
    }
    
    // Handle form submission
    public function store(Request $request)
    {
        \Log::info('Request received', $request->all());
    
        $request->validate([
            'patient' => 'required|exists:patients,id',
            'amount_paid' => 'required|numeric|min:0',
            'paybills_method_id' => 'required|exists:account,id',
        ]);
    
        $vendor = Patient::find($request->patient);
        if (!$vendor) {
            \Log::error('Patient not found', ['patient_id' => $request->patient]);
            return redirect()->back()->withErrors(['error' => 'Patient not found.']);
        }
    
        $balance = $vendor->balance - $request->amount_paid;
    
        $payment = Payment_form::create([
            'patient' => $request->patient,
            'amount' => $vendor->balance,
            'amount_paid' => $request->amount_paid,
            'balance' => $balance,
            'paybills_method_id' => $request->paybills_method_id,
        ]);
    
        if (!$payment) {
            \Log::error('Payment form not saved');
            return redirect()->back()->withErrors(['error' => 'Payment form not saved.']);
        }
    
        $vendor->update(['balance' => $balance]);
        Account::find($request->paybills_method_id)->increment('account_balance', $request->amount_paid);
    
        \Log::info('Payment saved successfully');
        return redirect()->route('paymentform.index')->with('success', 'Payment form saved successfully.');
    }
    

    













}
