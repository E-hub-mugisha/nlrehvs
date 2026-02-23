<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeSearchController extends Controller
{
    public function index()
    {
        return view('employees.search');
    }

    public function search(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string'
        ]);

        $employee = Employee::where('national_id', $request->national_id)->first();

        if ($employee) {
            // Employee exists → go to history
            return redirect()->route('employees.history', $employee->id);
        }

        // Employee not found → go to registration
        return redirect()->route('employees.create')
            ->with('national_id', $request->national_id);
    }
}
