<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Account;
use App\Models\Pay_bills;
use App\Models\Expenses;
use App\Models\SalaryList;
use App\Models\Payment_form;
use App\Models\Emplooyee;
use App\Models\Purchase;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        $validatedData = $request->validate([
            'Name' => 'required',
            'Sex' => 'required',
            'Address' => 'required',
            'Doctore_phone' => 'required',
        ]);

        Doctor::create($validatedData);
        DB::commit();

        return redirect('doctor')->with('message', 'Doctor added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Doctor::where('id', $id)->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Department' => 'required|string|max:255',
            'Specialist' => 'required|string|max:255',
            'Doctore_Experience' => 'required|integer|min:0',
            'Birth_date' => 'required|date',
            'Sex' => 'required|string|max:1',
            'Blood_group' => 'required|string|max:3',
            'Address' => 'required|string|max:255',
            'Doctore_phone' => 'required|string|max:15',
        ]);

        $doctor->update($validatedData);

        return redirect('doctor')->with('message', 'Doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Doctor::find($id)->delete();
        return redirect('doctor')->with('message', 'Doctor deleted successfully');
    }




    public function dashbourds()
    {
        $data['Doctors'] = Doctor::count();
        $data['patient'] = Patient::count();
        $data['Appointment'] = Appointment::count();
        $data['product'] = Product::count();
        $data['balance'] = Emplooyee::count();
        $data['balances']= Expenses::count('amount');
    
        // Current Month
        $currentFromDate = Carbon::now()->startOfMonth()->toDateString();
        $currentToDate = Carbon::now()->endOfMonth()->toDateString();
    
        $currentRevenues = Invoice::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
            + Payment_form::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
            + Appointment::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('net_fee');
    
        $currentExpenses = Pay_bills::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
            + Purchase::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
            + SalaryList::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('net_salary')
            + Expenses::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount');
    
        $currentBalance = $currentRevenues - $currentExpenses;
    
        // Previous Month
        $previousFromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $previousToDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
    
        $previousRevenues = Invoice::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
            + Payment_form::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
            + Appointment::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('net_fee');
    
        $previousExpenses = Pay_bills::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
            + Purchase::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
            + SalaryList::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('net_salary')
            + Expenses::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount');
    
        $previousBalance = $previousRevenues - $previousExpenses;
    
        // Current Month Expenses
        $currentCostOfGoodSold2 = Pay_bills::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid');
        $currentCostOfGoodSold1 = Purchase::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid');
        $currentEmployeeSalary = SalaryList::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('net_salary');
        $currentManufacturerPayments = Expenses::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount');
    
        $currentCostOfGoodSold = $currentCostOfGoodSold2 + $currentCostOfGoodSold1;
        $currentTotalExpenses = $currentManufacturerPayments + $currentCostOfGoodSold + $currentEmployeeSalary;
    
        // Previous Month Expenses
        $previousCostOfGoodSold2 = Pay_bills::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid');
        $previousCostOfGoodSold1 = Purchase::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid');
        $previousEmployeeSalary = SalaryList::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('net_salary');
        $previousManufacturerPayments = Expenses::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount');
    
        $previousCostOfGoodSold = $previousCostOfGoodSold2 + $previousCostOfGoodSold1;
        $previousTotalExpenses = $previousManufacturerPayments + $previousCostOfGoodSold + $previousEmployeeSalary;
    
        // Calculate Percentage Change
        $expenseChangePercentage = $previousTotalExpenses != 0 
            ? (($currentTotalExpenses - $previousTotalExpenses) / $previousTotalExpenses) * 100 
            : 0;
            
            
            $currentFromDate = Carbon::now()->startOfMonth()->toDateString();
            $currentToDate = Carbon::now()->endOfMonth()->toDateString();
        
            $currentEarnings = Invoice::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
                + Payment_form::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('amount_paid')
                + Appointment::whereBetween('created_at', [$currentFromDate, $currentToDate])->sum('net_fee');
        
            // Previous Month
            $previousFromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $previousToDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        
            $previousEarnings = Invoice::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
                + Payment_form::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('amount_paid')
                + Appointment::whereBetween('created_at', [$previousFromDate, $previousToDate])->sum('net_fee');
        
            // Calculate Percentage Change
            $earningsChangePercentage = $previousEarnings != 0 
                ? (($currentEarnings - $previousEarnings) / $previousEarnings) * 100 
                : 0;
                $invoices = Invoice::with('mypi', 'myacount')->get();
                $payments = Payment_form::with('mypatient')->get(); // Replace with actual payment relationships
                $data1 = [
                    'invoices' => $invoices,
                    'payments' => $payments,
                ];
  

             $patients = Patient::all(); // Fetch all patients
             $projects = Emplooyee::all();
 
             $bestSellingProducts = Product::select('name', 'sale_price', 'stock')
             ->orderBy('sale_price', 'desc') // Example: Order by highest sale price
             ->limit(5) // Fetch top 5
             ->get();
             $bestSellingPatients = Patient::orderBy('balance', 'desc') // Sort by balance
             ->take(5) // Fetch top 5 patients (adjust as needed)
             ->get();
            


     
             $accounts = Account::select()->take(5)->get();

        // Pass data to the view
        return view('dashbourd', array_merge(
            $data, 
            $data1, 
            ['patients' => $patients], 
            ['projects' => $projects],
            ['bestSellingProducts' => $bestSellingProducts],
            ['bestSellingPatients' => $bestSellingPatients],
            ['accounts' => $accounts],// Wrap patients in an associative array
            [
                'currentBalance' => $currentBalance,
                'previousBalance' => $previousBalance,
                'currentExpenses' => $currentTotalExpenses,
                'previousExpenses' => $previousTotalExpenses,
                'expenseChangePercentage' => $expenseChangePercentage,
                'currentEarnings' => $currentEarnings,
                'previousEarnings' => $previousEarnings,
                'earningsChangePercentage' => $earningsChangePercentage,
            ]
        ));
        
    }
    
  

    
  

        
    
    public function userdashboard()
    {
        $data['Doctors'] = Doctor::count();
        $data['patient'] = Patient::count();
        $data['Appointment'] = Appointment::count();
        $data['product'] = Product::count();
        return view('userdashbourd', $data);

    }









    public function userindex()
    {
        $user = User::all();
        return view('user', compact('user'));
    }



    public function usercreate()
    {
        return view('user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userstore(Request $request)
    {

        DB::beginTransaction();
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'password' => 'required',
        ]);


        User::create($validatedData);
        DB::commit();

        return redirect('userss')->with('message', 'users added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function usershow(Doctor $doctor)
    {
        return view('user');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function useredit(string $id)
    {
        return User::where('id', $id)->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function userupdate(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'password' => 'required',
        ]);

        $user->update($validatedData);

        return redirect('userss')->with('message', 'userss updated successfully');
    }
    public function userdestroy(string $id)
    {
        User::find($id)->delete();
        return redirect('userss')->with('message', 'userss deleted successfully');
    }





}
