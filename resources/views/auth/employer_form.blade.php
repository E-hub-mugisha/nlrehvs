@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">Employee Registration</h4>

            <form id="employeeForm" method="POST" action="{{ route('register.employee.store') }}">
                @csrf

                <!-- Step 1 -->
                <div class="step step-1">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" id="nextStep1">Next</button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step step-2 d-none">
                    <div class="mb-3">
                        <label for="national_id" class="form-label">National ID</label>
                        <input type="text" class="form-control" id="national_id" name="national_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <input type="text" class="form-control" id="skills" name="skills">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="prevStep2">Previous</button>
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const nextStep1 = document.getElementById('nextStep1');
    const prevStep2 = document.getElementById('prevStep2');
    const step1 = document.querySelector('.step-1');
    const step2 = document.querySelector('.step-2');

    nextStep1.addEventListener('click', () => {
        step1.classList.add('d-none');
        step2.classList.remove('d-none');
    });

    prevStep2.addEventListener('click', () => {
        step2.classList.add('d-none');
        step1.classList.remove('d-none');
    });
</script>
@endsection