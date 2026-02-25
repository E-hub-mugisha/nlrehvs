<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Mail\EmploymentHistoryAddedMail;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        // Track who added the record
        $data['employer_id'] = $employer->id;


        // Save employment history and assign to variable
        $history = EmploymentHistory::create($data);

        AuditHelper::log(
            'CREATE',
            'EmploymentHistory',
            $history->id,
            'Employment history added by employer'
        );

        // Send email to the employee
        $employee = $history->employee; // Relationship in EmploymentHistory model
        Mail::to($employee->user->email)->send(
            new EmploymentHistoryAddedMail($employee->national_id, $history->company_name)
        );

        return back()->with('success', 'Employment history added successfully.');
    }
}
