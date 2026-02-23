<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
   public function create()
    {
        return view('employers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:employers',
        ]);


        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        Employer::create($data);

        return redirect()->route('employers.create')->with('success', 'Employer registration submitted. Await admin approval.');
    }

    // Admin dashboard
    public function index()
    {
        $employers = Employer::orderBy('status')->get();
        return view('admin.employers.index', compact('employers'));
    }

    // Approve employer
    public function approve(Employer $employer)
    {
        $employer->update(['status' => 'approved']);
        return back()->with('success', 'Employer approved.');
    }

    // Reject employer
    public function reject(Employer $employer)
    {
        $employer->update(['status' => 'rejected']);
        return back()->with('success', 'Employer rejected.');
    }
}
