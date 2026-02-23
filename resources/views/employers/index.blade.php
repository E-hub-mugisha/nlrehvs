@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Employer Verification Dashboard</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
@endsection