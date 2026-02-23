<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_id' => 'required|string|unique:employees,national_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'email' => 'nullable|email',
        ]);

        $employee = Employee::create($validated);

        User::create([
            'name' => $employee->first_name . ' ' . $employee->last_name,
            'email' => $employee->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful');
    }
}
