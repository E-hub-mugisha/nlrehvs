@extends('layouts.auth')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">Register</h4>

            <!-- Alert box for errors/success -->
            <div id="alert" class="mb-3"></div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label class="form-label">I am registering as:</label>
                <select id="roleSelect" class="form-select">
                    <option value="">Select Role</option>
                    <option value="employee">Employee</option>
                    <option value="employer">Employer</option>
                </select>
            </div>

            <form id="registerForm">
                @csrf

                <!-- Employee Fields -->
                <div class="role-fields employee-fields d-none">
                    <h5>Employee Information</h5>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>National ID</label>
                        <input type="text" name="national_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Skills</label>
                        <input type="text" name="skills" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <!-- Employer Fields -->
                <div class="role-fields employer-fields d-none">
                    <h5>Employer Information</h5>
                    <div class="mb-3">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Registration Number</label>
                        <input type="text" name="registration_number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="button" id="submitForm" class="btn btn-success mt-3">Register</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const employeeFields = document.querySelector('.employee-fields');
    const employerFields = document.querySelector('.employer-fields');
    const form = document.getElementById('registerForm');
    const alertBox = document.getElementById('alert');

    roleSelect.addEventListener('change', function() {
        if(this.value === 'employee'){
            employeeFields.classList.remove('d-none');
            employerFields.classList.add('d-none');
        } else if(this.value === 'employer'){
            employerFields.classList.remove('d-none');
            employeeFields.classList.add('d-none');
        } else {
            employeeFields.classList.add('d-none');
            employerFields.classList.add('d-none');
        }
    });

    document.getElementById('submitForm').addEventListener('click', function() {
        const formData = new FormData(form);
        formData.append('role', roleSelect.value);

        fetch("{{ route('register.combined.store') }}", {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.errors){
                alertBox.innerHTML = `<div class="alert alert-danger">${data.errors.join('<br>')}</div>`;
            } else {
                alertBox.innerHTML = `<div class="alert alert-success">Registration successful!</div>`;
                form.querySelectorAll('input, select').forEach(i => i.disabled = true);
            }
        });
    });
});
</script>
@endsection