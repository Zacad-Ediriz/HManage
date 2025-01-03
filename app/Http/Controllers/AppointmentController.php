<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;

use App\Models\Appointment;
use App\Models\Payment_formm;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\ScheduleDoctor;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // public function index()
    // {
    //     $appointments = Appointment::with('doctor')->get();
    //     //$appointments = patient::all();
    //    // $accounts = Doctor::all();
    //     //$data['doctor'] = Doctor::get();
    //     return view('appointment.index', compact('appointments'));
    // }
    
 
    
    public function index(Request $request)
    {
        $query = Appointment::query();
    
        // Filter by date range
        if ($request->has('date_filter') && $request->date_filter) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
            }
        }
    
        // Filter by patient name
        if ($request->has('name') && $request->name) {
            $query->whereHas('pp', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
    
       
        // Return JSON response for AJAX
        if ($request->ajax()) {
            $appointments = $query->with(['mypi', 'pp'])->get();
            return response()->json(['appointments' => $appointments]);
        }
    
        // For non-AJAX requests
        $appointments = $query->with(['mypi', 'pp'])->get();
        return view('appointment.index', compact('appointments'));
    }
    
    
    
// public function create()
// {
//     $doctors = Doctor::with('schedules')->get();
//     //$patients = Patient::all(); // Load all patients
   
//     $patient = Patient::with('appointments')->get();

//         // Fetch available payment methods
     
    
//     $payment_method = Account::get(); // Rename for clarity

//     return view('appointment.create', compact('doctors', 'patients', 'payment_method'));
// }

public function create(Request $request)
{
    $doctors = Doctor::with('schedules')->get(); // Fetch doctors with schedules
   $zz = Patient::all(); // Load all patients
   $patients = Patient::whereHas('appointments', function ($query) {
        $query->where('payment_status', 0);
    })
    ->with(['appointments' => function ($query) {
        $query->where('payment_status', 0); // Include only unpaid appointments
    }])
    ->get();
    
    
    // $doctorSchedule = ScheduleDoctor::where('doctor_id', $request->doctors)  // Get schedule by doctor ID
    //                                  // Filter by appointment date if needed
    //                                 ->first();
    
    $schedules = ScheduleDoctor::all(['id', 'schedule_name']); // Adjust to your column names if different

    // return view('your-view-name', compact('schedules'));
    // Fetch available payment methods
    $accounts = Account::all();
    
   
    
    return view('appointment.create', compact('patients', 'accounts','zz','doctors','schedules'));
}


    
public function store(Request $request)
{
    $validated = $request->validate([
        'appointment_time' => 'required|date',
        'serial' => 'required|integer',
        'doctor' => 'required|exists:doctor,id',
        'schedule' => 'required',
        'patient' => 'required|exists:patients,id',
        'consultant_fee' => 'required|numeric',
        'discount' => 'nullable|numeric',
        'net_fee' => 'required|numeric',
        'payment_status' => 'boolean',
        'remark' => 'nullable|string',
        
        'account_number' => $request->payment_status ? 'required|exists:account,id' : 'nullable', // Ensure the account exists
    ]);

    // Create the appointment
    $appointment = Appointment::create([
        'appointment_time' => $validated['appointment_time'],
        'serial' => $validated['serial'],
        'doctor' => $validated['doctor'],
        'schedule' => $validated['schedule'],
        'patient' => $validated['patient'],
        'consultant_fee' => $validated['consultant_fee'],
        'discount' => $validated['discount'] ?? 0,
        'net_fee' => $validated['net_fee'],
        'payment_status' => $validated['payment_status'] ?? 0,
        'remark' => $validated['remark'],
    ]);

    // If payment is received, update the account balance
    if (!empty($validated['payment_status']) && $validated['payment_status'] == 1) {
        $account = Account::findOrFail($validated['account_number']);

        // Update the account balance
        $account->account_balance += $validated['net_fee']; // Add the net fee to the account balance
        $account->save();

        // Record the payment in the payment_formm model
        Payment_formm::create([
            'account_number' => $validated['account_number'],
            'patient' => $validated['patient'],
            'amount' => $validated['net_fee'], // Log the net fee as the payment amount
        ]);
    }

    return redirect()->route('appointment.index')->with('success', 'Appointment Created and Payment Updated!');
}
public function show($id)
{
    $appointment = Appointment::with(['mypi', 'pp'])->find($id);

    if (!$appointment) {
        abort(404, 'Appointment not found');
    }

    

    return view('appointment.show', compact('appointment'));
}





public function storePayment(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'patient' => 'required|exists:patients,id',
        'amount' => 'required|numeric|min:0',
        'account_number' => 'required|exists:account,id',
    ]);

    // Fetch the relevant account based on account_number
    $account = Account::findOrFail($validated['account_number']);

    // Update the account balance and set the previous balance
    $account->account_balance;
    $account->account_balance += $validated['amount']; // Add the payment to the account balance
    $account->save();

    // Save the payment record in the payment_formm model
    $payment = Payment_formm::create([
        'patient' => $validated['patient'],
        'amount' => $validated['amount'],
        'account_number' => $validated['account_number'],
    ]);

    // Update the payment_status of the associated appointment (assuming the patient has one appointment)
    $appointment = Appointment::where('patient', $validated['patient'])->where('payment_status', 0)->first();

    if ($appointment) {
        $appointment->payment_status = 1;  // Mark payment status as 1 (paid)
        $appointment->save();
    }

    // Redirect with a success message
    return redirect()->route('appointment.index')->with('success', 'Payment Created!');
}


    public function getCalendarEvents()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();
    
        return response()->json($appointments->map(function ($appointment) {
            return [
                'title' => $appointment.patient->name . ' with ' . $appointment.doctor->name,
                'start' => $appointment->appointment_time->format('Y-m-d\TH:i:s'),
            ];
        }));
    }
    
    public function getAppointments(Request $request)
    {
        $date = $request->query('date');
        $appointments = Appointment::whereDate('appointment_time', $date)->get();

        return response()->json([
            'appointments' => $appointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'serial' => $appointment->serial,
                    'doctor' => $appointment->doctor,
                    'schedule' => $appointment->schedule,
                    'patient' => $appointment->patient,
                    'payment_status' => $appointment->payment_status,
                    'time' => $appointment->appointment_time->format('H:i'),
                ];
            }),
        ]);
    }

    public function getAppointmentDetails($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        return response()->json($appointment);
    }

    





    

    
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {


    //     $data['Appointment'] = Appointment::get();
    //     $data['patient'] = patient::get();
    //     $data['doctor'] = Doctor::get();
    //     return view('Appointment.index', $data);
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
    //         'doctor' => 'required',
    //         'patient' => 'required',
    //         'appointment_start' => 'required',
    //         'appointment_end' => 'required',
    //         'amount' => 'required',
    //         'reason' => 'required',
    //     ]);
            
        
    //     $mypatient = patient::where('id', $request->patient)->first();
    //     $total = $mypatient->balance ;
    //     $mytotal =  $total+$request->amount;
    //     $mypatient->update([
    //         "balance" => $mytotal,
    //     ]);
        
    //     Appointment::create($validatedData);

    //     DB::commit();
    //     return redirect('Appointment')->with('message', 'Appointment added successfully');
    // }

    /**
     * Display the specified resource.
     */
    // public function show(Appointment $appointment)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }



    // public function getDoctorTime(Request $request)
    // {
    //     $doctorId = $request->input('doctor');
    //     $schedule = doctorSchedule::where('doctor', $doctorId)->first();
    //     return response()->json([
    //         'days' => explode(',', $schedule->days),
    //         'start_time' => $schedule->start_time,
    //         'end_time' => $schedule->end_time,
    //     ]);
    // }

}
