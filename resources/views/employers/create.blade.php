@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Register Employer</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('employers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Business Registration Number</label>
            <input type="text" name="business_registration_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tax ID</label>
            <input type="text" name="tax_id" class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Upload Documents (PDF, JPG, PNG)</label>
            <input type="file" name="documents" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit for Approval</button>
    </form>
</div>
@endsection