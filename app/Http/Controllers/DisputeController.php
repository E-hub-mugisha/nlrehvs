<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Dispute;
use App\Models\EmploymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputeController extends Controller
{
    // Employee raises dispute
    public function store(Request $request, EmploymentHistory $history)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        // Ensure employee owns this history
        $employee = Auth::user()->employee;
        if ($employee->id !== $history->employee_id) {
            return back()->with('error', 'You cannot dispute this record.');
        }

        Dispute::create([
            'employment_history_id' => $history->id,
            'employee_id' => $employee->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Dispute submitted successfully.');
    }

    // Admin views disputes
    public function index()
    {
        $disputes = Dispute::with(['employmentHistory', 'employee'])->orderBy('status')->get();
        return view('disputes.index', compact('disputes'));
    }

    // Admin resolves dispute
    public function resolve(Dispute $dispute)
    {
        $dispute->update([
            'status' => 'resolved',
            'admin_comment' => 'Dispute resolved successfully.',
        ]);
        AuditHelper::log(
            'RESOLVE',
            'Dispute',
            $dispute->id,
            'Dispute resolved by admin'
        );
        return back()->with('success', 'Dispute resolved.');
    }

    // Admin rejects dispute
    public function reject(Dispute $dispute)
    {
        $dispute->update([
            'status' => 'rejected',
            'admin_comment' => 'Dispute rejected after review.',
        ]);

        return back()->with('success', 'Dispute rejected.');
    }
    public function myDisputes()
    {
        $employee = auth()->user()->employee;

        $disputes = $employee->disputes;

        return view('employee.disputes.index', compact('disputes'));
    }
}
