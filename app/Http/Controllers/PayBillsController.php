<?php

namespace App\Http\Controllers;

use App\Models\vendor;
use App\Models\Account;
use App\Models\product;
use App\Models\service;
use App\Models\purchase;
use App\Models\pay_bills;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;

class PayBillsController extends Controller
{
    public function index()
    {
        $paybills = pay_bills::all();
        $data['vendor'] = vendor::get();
        $data['purchase'] = purchase::where('payment_status', 'pending')
            ->orWhere('payment_status', 'partial')
            ->get();
        $data['acount'] = Account::get();
        return view('paybills.index', compact('paybills'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paybills.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'vendor_id' => 'required',
            'amount' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            // 'payment_method' => 'required',
        ]);

        DB::beginTransaction();
        $purchase = purchase::where('id', $request->vendor_id)->first();
        $validatedData['purchase'] = $purchase->purchase;


        $account = Account::where('id', $request->payment_method)->first();
        $myBalance = $account->account_balance;

        $account->update([
            "account_balance" => $myBalance - $request->amount_paid,
        ]);

        $vendor = vendor::where('id', $purchase->vendor)->first();
        $vendor->update([
            "balance" => $request->balance,
        ]);

        $amount = $purchase->balance;
        $amount_paid = $request->amount_paid;
        if ($amount_paid >= $amount) {
            $payment_status = 'paid';
        } elseif ($amount_paid > 0) {
            $payment_status = 'partial';
        } else {
            $payment_status = 'pending';
        }

        $purchase->update([
            "balance" => $request->balance,
            "payment_status" => $payment_status,
            "amount_paid" => $amount_paid,
        ]);
        pay_bills::create($validatedData);

        DB::commit();

        return redirect('paybills')->with('message', 'pay_bills added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return pay_bills::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return pay_bills::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        pay_bills::find($id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "address" => $request->address,
            "balance" => $request->balance,
            "remarks" => $request->remarks,



        ]);
        return redirect('pay_bills')->with('message', 'data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pay_bills::find($id)->delete();
        return redirect('pay_bills')->with('message', 'data deleted');
    }


    public function getvendorBalance(Request $request)
    {

        $amount = purchase::where('id', $request->vendor_id)->first();
        return response()->json($amount);
    }















}
