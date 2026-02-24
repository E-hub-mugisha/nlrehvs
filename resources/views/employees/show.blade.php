@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-3">
        ← Back to Employees
    </a>
    @if(in_array(auth()->user()->role, ['admin','employer']))
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
        + Add Employment History
    </button>
    @endif
    <!-- Employee Details -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Employee Details
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $employee->user->name }}</p>
                    <p><strong>Email:</strong> {{ $employee->user->email }}</p>
                    <p><strong>National ID:</strong> {{ $employee->national_id }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Job Role:</strong> {{ $employee->job_role ?? 'N/A' }}</p>
                    <p><strong>Skills:</strong> {{ $employee->skills ?? 'N/A' }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $employee->employment_status === 'employed' ? 'success' : 'secondary' }}">
                            {{ ucfirst($employee->employment_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Employment History -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            Employment History
        </div>
        <div class="card-body">

            @if($employee->employmentHistories->isEmpty())
            <div class="alert alert-info">
                No employment history records found.
            </div>
            @else
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Exit Reason</th>
                        <th>Employer Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee->employmentHistories as $index => $history)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $history->company_name }}</td>
                        <td>{{ $history->start_date }}</td>
                        <td>{{ $history->end_date ?? 'Present' }}</td>
                        <td>{{ $history->exit_reason }}</td>
                        <td>{{ $history->employer_feedback ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </div>
    </div>

</div>

{{-- ADD HISTORY MODAL --}}
<div class="modal fade" id="addHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('employment-histories.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Employment History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exit Reason</label>
                            <select name="exit_reason" class="form-select" required>
                                <option value="">-- Select Reason --</option>
                                <option value="Contract Ended">Contract Ended</option>
                                <option value="Resigned">Resigned</option>
                                <option value="Termination">Termination</option>
                                <option value="Misconduct">Misconduct</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employer Comment</label>
                            <textarea name="employer_feedback" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save History
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection