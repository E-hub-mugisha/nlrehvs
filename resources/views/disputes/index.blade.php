@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Employee Disputes</h4>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Company</th>
                <th>Job Role</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Admin Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disputes as $dispute)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dispute->employee->national_id }}</td>
                <td>{{ $dispute->employmentHistory->company_name }}</td>
                <td>{{ $dispute->employmentHistory->job_role }}</td>
                <td>{{ $dispute->reason }}</td>
                <td>{{ ucfirst($dispute->status) }}</td>
                <td>{{ $dispute->admin_comment ?? '-' }}</td>
                <td>
                    @if($dispute->status === 'pending')
                        <form action="{{ route('admin.disputes.resolve', $dispute->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Resolve</button>
                        </form>
                        <form action="{{ route('admin.disputes.reject', $dispute->id) }}" method="POST" class="d-inline">
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