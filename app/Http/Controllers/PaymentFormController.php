<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\invoice;
use App\Models\patient;
use App\Models\product;
use App\Models\service;
use App\Models\payment_form;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;

class PaymentFormController extends Controller
{
    public function index()
    {
        $payment = payment_form::all();
        $data['invoice'] = Invoice::with('mypi')->where('payment_status', 'pending')
            ->orWhere('payment_status', 'partial')
            ->get();

        $data['patient'] = patient::get();
        $data['payment_method'] = Account::get();
        return view('paymentform.index', compact('payment'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('paymentform.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        $validatedData = $request->validate([
            'invoice' => 'required',
            'amount' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'payment_method' => 'required',
        ]);

        $invoice = invoice::where('id', $request->invoice)->first();
        $validatedData['patient'] = $invoice->patient;
        $validatedData['appointment_status'] = 0;

        $account = Account::where('id', $request->payment_method)->first();
        $myBalance = $account->account_balance;

        $account->update([
            "account_balance" => $myBalance + $request->amount_paid,
        ]);

        $patient = Patient::where('id', $invoice->patient)->first();
        $patient->update([
            "balance" => $request->balance,
        ]);

        $amount = $invoice->balance;
        $amount_paid = $request->amount_paid;
        if ($amount_paid >= $amount) {
            $payment_status = 'paid';
        } elseif ($amount_paid > 0) {
            $payment_status = 'partial';
        } else {
            $payment_status = 'pending';
        }

        $invoice->update([
            "balance" => $request->balance,
            "payment_status" => $payment_status,
            "amount_paid" => $amount_paid,
        ]);
        payment_form::create($validatedData);

        DB::commit();
        return redirect('paymentform')->with('message', 'payment_form added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return payment_form::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return payment_form::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        payment_form::find($id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "address" => $request->address,
            "balance" => $request->balance,
            "remarks" => $request->remarks,



        ]);
        return redirect('payment_form')->with('message', 'data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        payment_form::find($id)->delete();
        return redirect('payment_form')->with('message', 'data deleted');
    }


    public function getInvoiceBalance(Request $request)
    {
        $amount = invoice::where('id', $request->invoice)->first();
        return response()->json($amount);
    }















}
