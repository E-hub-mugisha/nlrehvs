@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">National Labor Analytics Dashboard</h4>
<div class="mb-3">
    <a href="{{ route('reports.pdf') }}" class="btn btn-danger me-2">
        📄 Download PDF Report
    </a>

    <a href="{{ route('reports.excel') }}" class="btn btn-success">
        📊 Download Excel Report
    </a>
</div>
    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow">
                <div class="card-body">
                    <h6>Total Employees</h6>
                    <h3>{{ $totalEmployees }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success shadow">
                <div class="card-body">
                    <h6>Approved Employers</h6>
                    <h3>{{ $totalEmployers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning shadow">
                <div class="card-body">
                    <h6>Employment Records</h6>
                    <h3>{{ $totalHistories }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-danger shadow">
                <div class="card-body">
                    <h6>Disputes</h6>
                    <h3>{{ $totalDisputes }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Employment Status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Employment Status</h6>
                    <p>Employed: <strong>{{ $employed }}</strong></p>
                    <p>Unemployed: <strong>{{ $unemployed }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Tables -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Monthly Hiring Trends</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Hires</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyHires as $row)
                            <tr>
                                <td>{{ $row->month }}</td>
                                <td>{{ $row->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Monthly Exit Trends</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Exits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyExits as $row)
                            <tr>
                                <td>{{ $row->month }}</td>
                                <td>{{ $row->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h6 class="mb-3">Monthly Hiring Trends</h6>
                        <canvas id="hiringChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h6 class="mb-3">Monthly Exit Trends</h6>
                        <canvas id="exitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Hiring Bar Chart
    const hiringCtx = document.getElementById('hiringChart').getContext('2d');
    new Chart(hiringCtx, {
        type: 'bar',
        data: {
            labels: @json($hireMonths),
            datasets: [{
                label: 'New Hires',
                data: @json($hireTotals),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });

    // Exit Line Chart
    const exitCtx = document.getElementById('exitChart').getContext('2d');
    new Chart(exitCtx, {
        type: 'line',
        data: {
            labels: @json($exitMonths),
            datasets: [{
                label: 'Employee Exits',
                data: @json($exitTotals),
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
</script>

@endsection