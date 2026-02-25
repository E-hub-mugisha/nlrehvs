@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title mb-3">Setup Two-Factor Authentication</h5>

                    @if(Auth::user()->two_factor_enabled)
                        <div class="alert alert-success">2FA is already enabled.</div>
                        <form method="POST" action="{{ route('2fa.disable') }}">
                            @csrf
                            <button class="btn btn-danger">Disable 2FA</button>
                        </form>
                    @else
                        <p>Scan the QR code in your authenticator app:</p>
                        <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ $qrCodeUrl }}" alt="QR Code">
                        <form method="POST" action="{{ route('2fa.enable') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="secret" value="{{ $secret }}">
                            <div class="mb-3">
                                <label>Enter OTP from app</label>
                                <input type="text" name="one_time_password" class="form-control" required>
                                @error('one_time_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-primary">Enable 2FA</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection