@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center my-4" style="min-height: 75vh;">
    <div class="card shadow-lg border-0 w-100" style="max-width: 420px; border-radius: 16px; overflow: hidden;">
        <div class="card-header text-center bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold">Sari-Sari Store IMS</h4>
        </div>
        <div class="card-body p-4">

            <!-- Flash Feedback Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Logo Section -->
            <div class="text-center mb-3">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Sari-Sari Store Logo" 
                     class="img-fluid" 
                     style="max-height: 110px; object-fit: contain;">
            </div>

            <!-- Standard Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password Field with Show/Hide Toggle -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group">
                        <input id="login_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('login_password', 'toggleLoginIcon')">
                            <i class="bi bi-eye-slash" id="toggleLoginIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm" style="border-radius: 8px;">
                        Login
                    </button>
                </div>
            </form>

            <div class="text-center my-3">
                <span class="text-muted small">OR</span>
            </div>

            <!-- Google Authentication Button -->
            <div class="d-grid gap-2">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2 py-2" style="border-radius: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                    Login with Google
                </a>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Register here</a></small>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript for Show/Hide Password Toggle -->
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