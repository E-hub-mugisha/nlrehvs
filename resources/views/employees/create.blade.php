@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    Register Employee
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf

                        {{-- National ID --}}
                        <div class="mb-3">
                            <label class="form-label">National ID</label>
                            <input type="text"
                                   name="national_id"
                                   value="{{ old('national_id', session('national_id')) }}"
                                   class="form-control @error('national_id') is-invalid @enderror"
                                   required
                                   readonly>
                            @error('national_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Skills --}}
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text"
                                   name="skills"
                                   value="{{ old('skills') }}"
                                   class="form-control"
                                   placeholder="e.g. Customer Service, Data Entry">
                        </div>

                        {{-- Job Role --}}
                        <div class="mb-3">
                            <label class="form-label">Job Role</label>
                            <input type="text"
                                   name="job_role"
                                   value="{{ old('job_role') }}"
                                   class="form-control"
                                   placeholder="e.g. Call Center Agent">
                        </div>

                        {{-- Employment Status --}}
                        <div class="mb-3">
                            <label class="form-label">Employment Status</label>
                            <select name="employment_status" class="form-select">
                                <option value="unemployed" selected>Unemployed</option>
                                <option value="employed">Employed</option>
                                <option value="suspended">Suspended</option>
                                <option value="terminated">Terminated</option>
                            </select>
                        </div>

                        {{-- Hidden user_id --}}
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('employee.search') }}" class="btn btn-secondary me-2">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save Employee
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection