@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">My Employment History</h4>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($histories->isEmpty())
        <div class="alert alert-info">
            No employment history records found.
        </div>
    @else
        <div class="card">
            <div class="card-body">
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
                        @foreach($histories as $index => $history)
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
            </div>
        </div>
    @endif

</div>
@endsection