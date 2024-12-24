<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Account;
use App\Models\Product;
use App\Models\Service;
use App\Models\Purchase;
use App\Models\Pay_bills;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;

class PayBillsController extends Controller
{
    // public function index()
    // {
    //     $paybills = Pay_bills::all();
    //     $data['vendor'] = Vendor::get();
    // //    $data['purchase'] = Purchase::where('payment_status', 'pending')
    // //        ->orWhere('payment_status', 'partial')->with('mypi')
    // //        ->get();
    //     $data['acount'] = Account::get();
    //     return view('paybills.index', compact('paybills'), $data);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     return view('paybills.index');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {

    //     $validatedData = $request->validate([
    //         'vendor_id' => 'required',
    //         'amount' => 'required',
    //         'amount_paid' => 'required',
    //         'balance' => 'required',
    //         'payment_method' => 'required',
    //     ]);

    //     DB::beginTransaction();
    //     $purchase = Vendor::all();
    //     $validatedData['purchase'] = $purchase->purchase;


    //     $account = Account::where('id', $request->payment_method)->first();
    //     $myBalance = $account->account_balance;

    //     $account->update([
    //         "account_balance" => $myBalance - $request->amount_paid,
    //     ]);

    //     $vendor = Vendor::where('id', $purchase->vendor)->first();
    //     $vendor->update([
    //         "balance" => $request->balance,
    //     ]);

    //     $amount = $purchase->balance;
    //     $amount_paid = $request->amount_paid;
    //     if ($amount_paid >= $amount) {
    //         $payment_status = 'paid';
    //     } elseif ($amount_paid > 0) {
    //         $payment_status = 'partial';
    //     } else {
    //         $payment_status = 'pending';
    //     }

    //     $purchase->update([
    //         "balance" => $request->balance,
    //         "payment_status" => $payment_status,
    //         "amount_paid" => $amount_paid,
    //     ]);
    //     Pay_bills::create($validatedData);

    //     DB::commit();

    //     return redirect('paybills')->with('message', 'pay_bills added successfully');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     return Pay_bills::where('id', $id)->get();
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     return Pay_bills::where('id', $id)->get();
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     Pay_bills::find($id)->update([
    //         "name" => $request->name,
    //         "phone" => $request->phone,
    //         "sex" => $request->sex,
    //         "address" => $request->address,
    //         "balance" => $request->balance,
    //         "remarks" => $request->remarks,



    //     ]);
    //     return redirect('pay_bills')->with('message', 'data updated');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     Pay_bills::find($id)->delete();
    //     return redirect('pay_bills')->with('message', 'data deleted');
    // }


    // public function getvendorBalance(Request $request)
    // {

    //     $amount = Purchase::where('id', $request->vendor_id)->first();
    //     return response()->json($amount);
    // }

    public function index(Request $request)
    {
        $paybills = Pay_bills::with('mypi')->get();
        $data['vendor'] = Vendor::get();
        $vendors = Vendor::all(['id', 'name', 'balance']);
        $accounts = Account::all(['id', 'account_name']);
      
       
        return view('paybills.index', compact('vendors', 'accounts','paybills','data'));
    }

    // Handle form submission
    
    public function store(Request $request)
    {
        $request->validate([
            'vendor' => 'required|exists:vendors,id',
            'amount_paid' => 'required|numeric|min:0',
            'paybills_method_id' => 'required|exists:account,id',
        ]);

        $vendor = Vendor::find($request->vendor);
        if ($vendor !== null) {
            $balance = $vendor->balance - $request->amount_paid;
        } else {
            // Handle the case when $vendor is null, for example:
            echo "Vendor not found or is null";
        }
        

        Pay_bills::create([
            'vendor' => $request->vendor,
            'amount' => $vendor->balance,
            'amount_paid' => $request->amount_paid,
            'balance' => $balance,
            'paybills_method_id' => $request->paybills_method_id,
        ]);

        $vendor->update(['balance' => $balance]);
        $account = Account::where('id', $request->paybills_method_id)->first();
        $myBalance = $account->account_balance;

        $account->update([
            "account_balance" => $myBalance - $request->amount_paid,
        ]);

        return redirect()->route('paybills.index')->with('success', 'Paybill created successfully.');
    }












}
