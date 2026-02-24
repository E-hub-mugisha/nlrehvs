<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->latest()->get();

        return view('employees.index', compact('employees'));
    }
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

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'national_id' => 'required|string|unique:employees,national_id',
            'employment_status' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'), // or random password
            'role' => 'employee',
        ]);

        Employee::create([
            'user_id' => $user->id,
            'national_id' => $request->national_id,
            'job_role' => $request->job_role,
            'skills' => $request->skills,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()->back()->with('success', 'Employee created successfully');
    }

    public function myHistory()
    {
        $user = auth()->user();

        // Ensure employee profile exists
        if (!$user->employee) {
            return redirect()->route('dashboard')
                ->with('error', 'Your employee profile is not yet registered.');
        }

        $histories = $user->employee->employmentHistories;

        return view('employees.history', compact('histories'));
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'employmentHistories']);

        return view('employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        $employee->delete(); // cascades histories
        $employee->user()->delete();

        return back()->with('success', 'Employee deleted successfully');
    }
}
