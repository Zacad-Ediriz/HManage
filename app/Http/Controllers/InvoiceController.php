<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_detail;
use App\Models\Patient;
use App\Models\Account;
use App\Models\Service;
use App\Models\Product;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoice = Invoice::with('mypi', 'myacount')->get();
        $data['patient'] = Patient::get();   
        $data['acount'] = Account::get();
        return view('invoice.index', compact('invoice'), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoice.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        DB::beginTransaction();

        $validatedData = $request->validate([
            'patient' => 'required',
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
        $validatedData["payment_status"] =  $payment_status;

        $validatedData["appointment_status"] = "0";
        $myinvoice = Invoice::create($validatedData);

        for ($i = 0; $i < count($request->type); $i++) {
            Invoice_detail::create([
                'invoice_id' => $myinvoice->id,
                'type' => $request->type[$i],
                'product' => $request->item[$i],
                'qty' => $request->qty[$i],
                'price' => $request->price[$i],
            ]);
            $product = Product::where('id', $request->item[$i])->first();
            $qtyproduct = $product->stock - $request->qty[$i];
            $product->update([
                "stock" => $qtyproduct,
            ]);
        }
        ;

        $account = Account::where('id', $request->payment_method)->first();
        $myBalance = $account->account_balance;

        $account->update([
            "account_balance" => $myBalance + $request->amount_paid,
        ]);

        $patient = Patient::where('id', $request->patient)->first();
        $patient->update([
            "balance" => $request->balance,
        ]);




        DB::commit();
        return redirect('invoice')->with('message', 'invoice added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Invoice::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Invoice::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Invoice::find($id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "address" => $request->address,
            "balance" => $request->balance,
            "remarks" => $request->remarks,



        ]);
        return redirect('invoice')->with('message', 'data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Invoice::find($id)->delete();
        Invoice_detail::where('invoice_id', $id)->delete();
        return redirect('invoice')->with('message', 'data deleted');
    }

    public function getInvoiceItem(Request $request)
    {
        $type = $request->input('type');
        if ($type === 'service') {
            $items = Service::all();
        } elseif ($type === 'product') {
            $items = Product::all();
        } else {
            $items = [];
        }

        return response()->json($items);
    }
    public function getpateintBalance(Request $request)
    {
        $amount = Patient::where('id', $request->patient)->first();
        return response()->json($amount);
    }

    public function getitemprice(Request $request)
    {
        $amount = Product::where('id', $request->item)->first();
        return response()->json($amount);
    }
    public function getSerivicePrice(Request $request)
    {
        $amount = Service::where('id', $request->item)->first();
        return response()->json($amount);
    }















}
