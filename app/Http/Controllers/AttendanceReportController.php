<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Emplooyee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
    
        // Get all employees
        $employees = Emplooyee::all();
    
        // Calculate attendance report
        $attendanceReport = $employees->map(function ($employee) use ($month, $year) {
            // Get all attendance entries for the employee in the selected month/year
            $attendances = Attendance::where('employee_name', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();
    
            // Calculate total days worked
            $daysWorked = $attendances->groupBy('date')->count();
    
            // Calculate total hours worked
            $totalHours = 0;
            foreach ($attendances->groupBy('date') as $date => $records) {
                if (count($records) == 2) {
                    // Calculate hours only if there is both "In" and "Out"
                    $in = $records->where('check', 'In')->first();
                    $out = $records->where('check', 'Out')->first();
    
                    if ($in && $out) {
                        $start = \Carbon\Carbon::parse($in->time);
                        $end = \Carbon\Carbon::parse($out->time);
                        $totalHours += $end->diffInHours($start);
                    }
                }
            }
    
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'daysWorked' => $daysWorked,
                'totalDaysInMonth' => \Carbon\Carbon::create($year, $month)->daysInMonth,
                'totalHours' => $totalHours,
            ];
        });
    
        return view('attendance-report.index', compact('attendanceReport', 'month', 'year'));
    }
    

    public function export(Request $request)
    {
        // Handle export logic here (CSV, Excel, etc.)
        // Use a package like Maatwebsite/Laravel-Excel for Excel export
    }
}
