@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center my-4" style="min-height: 75vh;">
    <div class="card shadow-lg border-0 w-100" style="max-width: 420px; border-radius: 16px; overflow: hidden;">
        <div class="card-header text-center bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold">Sari-Sari Store IMS</h4>
        </div>
        <div class="card-body p-4">
            <!-- Logo Section -->
            <div class="text-center mb-3">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Sari-Sari Store Logo" 
                     class="img-fluid" 
                     style="max-height: 110px; object-fit: contain;">
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="{{ old('email') }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group">
                        <input type="password" id="login_password" name="password" class="form-control" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('login_password', 'toggleLoginIcon')">
                            <i class="bi bi-eye-slash" id="toggleLoginIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2 shadow-sm" style="border-radius: 8px;">Login</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Register here</a></small>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endsection