<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('employees.create', [
            'national_id' => session('national_id')
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'national_id' => 'required|unique:employees,national_id',
            'skills' => 'nullable|string',
            'job_role' => 'nullable|string',
            'employment_status' => 'required|string',
        ]);

        Employee::create($validated);

        return redirect()->route('employee.search')
            ->with('success', 'Employee registered successfully.');
    }
}
