<?php

namespace App\Http\Controllers;

use App\Models\Emplooyee;
use App\Models\SalaryStructure;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmplooyeeController extends Controller
{
    // Method to show all employees
    public function index()
    {
        // Retrieve all employees (or paginate if necessary)
        $employees = Emplooyee::all(); // Or you can use paginate() if needed

        // Return the view with the list of employees
        return view('employees.index', compact('employees'));
    }

    // Method to show the employee creation form
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
     

        return view('employees.create', compact('departments', 'positions'));
    }


    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'phone_number' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'nid' => 'nullable|string|max:50',
        'blood_group' => 'nullable|string',
        'department_id' => 'required|exists:departments,id',
        'position_id' => 'required|exists:positions,id',
        'joining_date' => 'required|date',
        'gender' => 'required|string',
        'guarantor_name' => 'nullable|string|max:255',
        'guarantor_email' => 'nullable|email|max:255',
        'guarantor_relation' => 'nullable|string|max:255',
        'emergency_contact' => 'nullable|string|max:20',
        'emergency_address' => 'nullable|string|max:255',
        'basic_salary' => 'required|numeric|min:0',
        'gross_salary' => 'required|numeric|min:0',
    ]);

    // Format the date of birth
    $data = $request->all();
    $data['date_of_birth'] = \Carbon\Carbon::parse($request->date_of_birth)->format('Y-m-d');
    $data['joining_date'] = \Carbon\Carbon::parse($request->joining_date)->format('Y-m-d');

    // Calculate gross salary (add custom logic here if needed)
    $data['gross_salary'] = $request->input('basic_salary'); // Currently just copying basic_salary

    // Create the employee record
    $employee = Emplooyee::create($data);

    // Redirect to the index page with a success message
    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
}

}
   
