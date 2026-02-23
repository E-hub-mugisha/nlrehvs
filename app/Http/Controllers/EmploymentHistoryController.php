<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploymentHistoryController extends Controller
{
    public function index(Employee $employee)
    {
        $histories = $employee->employmentHistories;
        return view('employment_history.index', compact('employee', 'histories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'exit_reason' => 'required|string',
            'employer_feedback' => 'nullable|string',
        ]);

        // Track who added the record
        $data['employer_id'] = Auth::id();

        EmploymentHistory::create($data);

        return back()->with('success', 'Employment history added successfully.');
    }
}
