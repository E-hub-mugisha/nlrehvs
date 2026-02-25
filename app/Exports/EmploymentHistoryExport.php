<?php

namespace App\Exports;

use App\Models\EmploymentHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmploymentHistoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return EmploymentHistory::with('employee')
            ->get()
            ->map(function ($history) {
                return [
                    'National ID' => $history->employee->national_id,
                    'Company' => $history->company_name,
                    'Start Date' => $history->start_date,
                    'End Date' => $history->end_date,
                    'Exit Reason' => $history->exit_reason,
                    'Feedback' => $history->employer_feedback,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'National ID',
            'Company',
            'Start Date',
            'End Date',
            'Exit Reason',
            'Employer Feedback',
        ];
    }
}