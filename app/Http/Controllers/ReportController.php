<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentHistory;
use App\Models\Dispute;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmploymentHistoryExport;

class ReportController extends Controller
{
    // PDF Summary Report
    public function laborSummaryPDF()
    {
        $data = [
            'employees' => Employee::count(),
            'employers' => Employer::where('status', 'approved')->count(),
            'histories' => EmploymentHistory::count(),
            'disputes' => Dispute::count(),
        ];

        $pdf = Pdf::loadView('reports.labor_summary', $data);
        return $pdf->download('labor_summary_report.pdf');
    }

    // Excel Export
    public function employmentHistoryExcel()
    {
        return Excel::download(
            new EmploymentHistoryExport,
            'employment_history.xlsx'
        );
    }
}