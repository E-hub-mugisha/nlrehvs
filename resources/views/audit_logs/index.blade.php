@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">System Audit Logs</h4>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->role }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $log->action }}</span>
                            </td>
                            <td>{{ $log->model }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->ip_address }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection