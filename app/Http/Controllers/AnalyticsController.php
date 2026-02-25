<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentHistory;
use App\Models\Dispute;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Core counts
        $totalEmployees = Employee::count();
        $totalEmployers = Employer::where('status', 'approved')->count();
        $totalHistories = EmploymentHistory::count();
        $totalDisputes = Dispute::count();

        // Employment status
        $employed = Employee::where('employment_status', 'employed')->count();
        $unemployed = Employee::where('employment_status', 'unemployed')->count();

        // Monthly hiring trends
        $monthlyHires = EmploymentHistory::select(
            DB::raw('MONTH(start_date) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Monthly exits
        $monthlyExits = EmploymentHistory::whereNotNull('end_date')
            ->select(
                DB::raw('MONTH(end_date) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $hireMonths = $monthlyHires->pluck('month');
        $hireTotals = $monthlyHires->pluck('total');

        $exitMonths = $monthlyExits->pluck('month');
        $exitTotals = $monthlyExits->pluck('total');

        return view('analytics.index', compact(
            'totalEmployees',
            'totalEmployers',
            'totalHistories',
            'totalDisputes',
            'employed',
            'unemployed',
            'monthlyHires',
            'monthlyExits',
            'hireMonths',
            'hireTotals',
            'exitMonths',
            'exitTotals'
        ));
    }
}
