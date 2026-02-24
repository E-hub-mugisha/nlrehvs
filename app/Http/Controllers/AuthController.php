<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function choose()
    {
        return view('auth.register_choose');
    }

    public function employeeForm()
    {
        return view('auth.employee_form');
    }

    public function employerForm()
    {
        return view('auth.employer_form');
    }

    public function storeEmployeeSingle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'national_id' => 'required|unique:employees,national_id',
            'skills' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employee',
            'password' => bcrypt($request->password),
        ]);

        $user->employee()->create([
            'national_id' => $request->national_id,
            'skills' => $request->skills,
            'employment_status' => 'unemployed',
        ]);

        return response()->json(['success' => true]);
    }

    public function storeCombined(Request $request)
    {
        $role = $request->role;
        if (!$role) return response()->json(['errors' => ['Please select a role.']]);

        $rules = [];
        if ($role == 'employee') {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'national_id' => 'required|unique:employees,national_id',
                'skills' => 'nullable|string',
                'password' => 'required|string|min:6|confirmed',
            ];
        } elseif ($role == 'employer') {
            $rules = [
                'company_name' => 'required|string|max:255',
                'registration_number' => 'required|unique:employers,registration_number',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all()]);

        if ($role == 'employee') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'employee',
                'password' => bcrypt($request->password),
            ]);
            $user->employee()->create([
                'national_id' => $request->national_id,
                'skills' => $request->skills,
                'employment_status' => 'unemployed',
            ]);
        } elseif ($role == 'employer') {
            $user = User::create([
                'name' => $request->company_name,
                'email' => $request->email,
                'role' => 'employer',
                'password' => bcrypt($request->password),
            ]);
            $user->employer()->create([
                'registration_number' => $request->registration_number,
                'status' => 'pending', // employer approval workflow
            ]);
        }

        return response()->json(['success' => true]);
    }
}
