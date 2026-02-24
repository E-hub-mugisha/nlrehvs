@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Employer Verification Dashboard</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createEmployerModal">
        + Add Employer
    </button>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Company</th>
                <th>Registration #</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employers as $employer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employer->company_name }}</td>
                <td>{{ $employer->registration_number }}</td>
                <td>{{ ucfirst($employer->status) }}</td>

                <td>
                    @if($employer->status == 'pending')
                    <form action="{{ route('admin.employers.approve', $employer->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>
                    <form action="{{ route('admin.employers.reject', $employer->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                    @else
                    <span class="text-muted">No actions</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="createEmployerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('employers.storeEmployer') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Create Employer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <!-- User Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Company Name</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Business Registration Number</label>
                            <input type="text" name="registration_number" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="approved">Approved</option>
                                <option value="pending">pending</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Create Employer</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection