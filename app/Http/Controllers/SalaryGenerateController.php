<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Emplooyee;
use App\Models\SalaryGenerate;
use App\Models\Account;
use Illuminate\Support\Facades\DB;


class SalaryGenerateController extends Controller
{
    /**
     * Display the salary generation page.
     */
    public function index()
    {
    
        $employees = SalaryGenerate::with(['employee'])->get();
        
        
        

        // Pass the appointments to the view
        return view('salary_generate.index', compact('employees'));
    }

    /**
     * Store the generated salaries.
     */
    public function create()
    {
        // Fetch all employees to display in the table
        $employees = Emplooyee::all();

        // Return the view with employees
        return view('salary_generate.form', compact('employees'));
    }

    // Handle the form submission
 
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NameSalary' => 'required|string|max:255',
            'Status' => 'required|string|max:255',
            'employees.*.employee_id' => 'required|integer',
            'employees.*.basic_salary' => 'required|numeric',
            'employees.*.gross_salary' => 'required|numeric',
            'employees.*.additions' => 'nullable|numeric',
            'employees.*.deductions' => 'nullable|numeric',
            'employees.*.net_salary' => 'required|numeric',
            'employees.*.remarks' => 'nullable|string|max:500',
        ]);
    
        // Loop through each employee and create salary records
        foreach ($validated['employees'] as $employeeData) {
            SalaryGenerate::create([
                'employee_id' => $employeeData['employee_id'],
                'NameSalary' => $validated['NameSalary'],
                'basic_salary' => $employeeData['basic_salary'],
                'gross_salary' => $employeeData['gross_salary'],
                'additions' => $employeeData['additions'] ?? 0,
                'deductions' => $employeeData['deductions'] ?? 0,
                'net_salary' => $employeeData['net_salary'],
                'remarks' => $employeeData['remarks'] ?? null,
            ]);
        }
    
        return redirect()->back()->with('success', 'Salaries saved successfully.');
    }
    
    
    
    
    
}
