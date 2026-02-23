@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>
            Employment History – 
            <span class="text-muted">{{ $employee->national_id }}</span>
        </h4>

        @if(in_array(auth()->user()->role, ['admin','employer']))
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
                + Add Employment History
            </button>
        @endif
    </div>

    {{-- Employment History Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Exit Reason</th>
                        <th>Employer Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->company_name }}</td>
                            <td>{{ $history->start_date }}</td>
                            <td>{{ $history->end_date ?? 'Present' }}</td>
                            <td>{{ $history->exit_reason }}</td>
                            <td>{{ $history->employer_feedback ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No employment history recorded
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

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

{{-- Only show if employee owns the record --}}
@if(auth()->user()->role === 'employee' && auth()->user()->employee->id === $employee->id)
    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#disputeModal">
        Raise Dispute
    </button>

    <!-- Dispute Modal -->
    <div class="modal fade" id="disputeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('disputes.store', $history->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Dispute Employment History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <textarea name="reason" class="form-control" rows="4" placeholder="Explain why you dispute this record" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Submit Dispute</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection