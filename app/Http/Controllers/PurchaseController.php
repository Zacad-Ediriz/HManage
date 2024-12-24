<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Purchase_details;
use App\Models\Vendor;
use App\Models\Account;
use App\Models\Service;
use App\Models\Product;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchase = Purchase::with('mypi')->get();
        $data['vendor'] = Vendor::get();
        $data['acount'] = Account::get();
        $data['product'] = Product::get();
        return view('purchase.index', compact('purchase'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        DB::beginTransaction();

        $validatedData = $request->validate([
            'vendor' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'net_total' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'payment_method' => 'required',

        ]);



        $amount = $request->net_total;
        $amount_paid = $request->amount_paid;
        $balance = $amount - $amount_paid;

        if ($amount_paid >= $amount) {
            $payment_status = 'paid';
        } elseif ($amount_paid > 0) {
            $payment_status = 'partial';
        } else {
            $payment_status = 'pending';
        }
        $validatedData["payment_status"] = $payment_status;

        $myinvoice = Purchase::create($validatedData);



        for ($i = 0; $i < count($request->item); $i++) {
            Purchase_details::create([
                'purchase_id' => $myinvoice->id,
                'type' => "product",
                'product' => $request->item[$i],
                'qty' => $request->qty[$i],
                'price' => $request->price[$i],
            ]);
            $product = Product::where('id', $request->item[$i])->first();
            $qtyproduct = $product->stock + $request->qty[$i];
            $product->update([
                "stock" => $qtyproduct,
            ]);
        }
        ;







        $account = Account::where('id', $request->payment_method)->first();
        $myBalance = $account->account_balance;

        $account->update([
            "account_balance" => $myBalance - $request->amount_paid,
        ]);




        $vendor = Vendor::where('id', $request->vendor)->first();
        $vendor->update([
            "balance" => $request->balance,
        ]);



        DB::commit();
        return redirect('purchase')->with('message', 'purchase added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Purchase::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Purchase::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Purchase::find($id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "address" => $request->address,
            "balance" => $request->balance,
            "remarks" => $request->remarks,



        ]);
        return redirect('purchase')->with('message', 'data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Purchase::find($id)->delete();
        return redirect('purchase')->with('message', 'data deleted');
    }

    public function getpurchaseItem(Request $request)
    {
        $type = $request->input('type');
        if ($type === 'product') {
            $items = Product::all();
        } else {
            $items = [];
        }

        return response()->json($items);
    }
    public function getvendorsBalance(Request $request)
    {
        $amount = Vendor::where('id', $request->vendor)->first();
        return response()->json($amount);
    }















}
