@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">All Registered Employees</h4>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
        + Add Employee
    </button>
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>National ID</th>
                        <th>Job Role</th>
                        <th>Skills</th>
                        <th>Status</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->user->name }}</td>
                        <td>{{ $employee->user->email }}</td>
                        <td>{{ $employee->national_id }}</td>
                        <td>{{ $employee->job_role ?? 'N/A' }}</td>
                        <td>{{ $employee->skills ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $employee->employment_status === 'employed' ? 'success' : 'secondary' }}">
                                {{ ucfirst($employee->employment_status) }}
                            </span>
                        </td>
                        <td>{{ $employee->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}"
                                class="btn btn-sm btn-primary">
                                View
                            </a>
                            <button
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteEmployeeModal"
                                data-id="{{ $employee->id }}"
                                data-name="{{ $employee->user->name }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            No employees found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@forelse($employees as $index => $employee)
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="deleteEmployeeForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>
                        Are you sure you want to delete
                        <strong id="employeeName"></strong>?
                    </p>
                    <p class="text-danger">
                        This action cannot be undone.
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="modal fade" id="createEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('employees.storeEmployee') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Create Employee</h5>
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

                        <!-- Employee Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">National ID</label>
                            <input type="text" name="national_id" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Role</label>
                            <input type="text" name="job_role" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employment Status</label>
                            <select name="employment_status" class="form-select" required>
                                <option value="employed">Employed</option>
                                <option value="unemployed">Unemployed</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text" name="skills" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Create Employee</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('deleteEmployeeModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const employeeId = button.getAttribute('data-id');
    const employeeName = button.getAttribute('data-name');

    document.getElementById('employeeName').textContent = employeeName;
    document.getElementById('deleteEmployeeForm').action = `employees/${employeeId}`;
});
</script>

@endsection