@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">Employee Registration</h4>

            <!-- Alert box for errors/success -->
            <div id="alert" class="mb-3"></div>

            <form id="employeeForm">
                @csrf

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <!-- National ID -->
                <div class="mb-3">
                    <label for="national_id" class="form-label">National ID</label>
                    <input type="text" name="national_id" id="national_id" class="form-control">
                </div>

                <!-- Skills -->
                <div class="mb-3">
                    <label for="skills" class="form-label">Skills</label>
                    <input type="text" name="skills" id="skills" class="form-control">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="button" id="submitForm" class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('employeeForm');
        const alertBox = document.getElementById('alert');

        document.getElementById('submitForm').addEventListener('click', function() {
            const formData = new FormData(form);

            fetch("{{ route('register.employee.step3') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.errors) {
                        alertBox.innerHTML = `<div class="alert alert-danger">${data.errors.join('<br>')}</div>`;
                    } else {
                        alertBox.innerHTML = `<div class="alert alert-success">Registration successful!</div>`;
                        form.querySelectorAll('input').forEach(i => i.disabled = true);
                    }
                });
        });
    });
</script>
@endsection