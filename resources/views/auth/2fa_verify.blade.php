@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3">Two-Factor Authentication</h5>
                    <form method="POST" action="{{ route('2fa.verify.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label>OTP from Authenticator App</label>
                            <input type="text" name="one_time_password" class="form-control" required>
                            @error('one_time_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection