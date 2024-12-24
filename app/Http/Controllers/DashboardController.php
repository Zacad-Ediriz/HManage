<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Emplooyee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Define date range, assuming filtering is optional
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth();

        // Total Revenue
        $totalRevenue = Invoice::whereBetween('created_at', [$startDate, $endDate])
            ->sum('net_total'); // Sum of net_total from invoices

        // Sales Overview (e.g., number of sales per day, week, or month)
        $salesOverview = Invoice::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(net_total) as total_sales')
            ->groupBy('date')
            ->get();

        // New Employees
        $newEmployees = Employee::whereBetween('created_at', [$startDate, $endDate])
            ->count(); // Count of employees hired in the selected period

        // Earnings (e.g., total earnings from all employees)
        $earnings = Employee::whereBetween('created_at', [$startDate, $endDate])
            ->sum('basic_salary'); // Sum of basic salaries of employees

        // Pass the variables to the view
        return view('dashboard.index', compact('totalRevenue', 'salesOverview', 'newEmployees', 'earnings', 'startDate', 'endDate'));
    }
}
