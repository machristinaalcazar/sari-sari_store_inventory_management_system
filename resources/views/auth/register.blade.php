@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center py-2" style="min-height: 75vh;">
    <div class="card shadow border-0 w-100" style="max-width: 480px; border-radius: 12px; overflow: hidden;">
        <!-- Header -->
        <div class="card-header text-center bg-success text-white py-2">
            <h5 class="mb-0 fw-bold">Register - Sari-Sari Store Inventory</h5>
        </div>

        <div class="card-body px-4 py-3">

            <!-- Flash Feedback Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Compact Logo -->
            <div class="text-center mb-2">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Sari-Sari Store Logo" 
                     class="img-fluid" 
                     style="max-height: 65px; object-fit: contain;">
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div class="mb-2">
                    <label class="form-label fw-semibold text-secondary small mb-1">Full Name</label>
                    <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                    @error('name') <span class="text-danger small" style="font-size: 11px;">{{ $message }}</span> @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-2">
                    <label class="form-label fw-semibold text-secondary small mb-1">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger small" style="font-size: 11px;">{{ $message }}</span> @enderror
                </div>

                <!-- Role Selection -->
                <div class="mb-2">
                    <label class="form-label fw-semibold text-secondary small mb-1">Role</label>
                    <select name="role" class="form-select form-select-sm @error('role') is-invalid @enderror" required>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff / Helper</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Owner / Administrator</option>
                    </select>
                    @error('role') <span class="text-danger small" style="font-size: 11px;">{{ $message }}</span> @enderror
                </div>

                <!-- Password Input with Show/Hide Toggle -->
                <div class="mb-2">
                    <label class="form-label fw-semibold text-secondary small mb-1">Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon')">
                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-danger small" style="font-size: 11px;">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password Input with Show/Hide Toggle -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Confirm Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')">
                            <i class="bi bi-eye-slash" id="toggleConfirmIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success w-100 fw-bold btn-sm py-2 shadow-sm" style="border-radius: 6px;">Register Account</button>
            </form>

            <div class="text-center my-2">
                <span class="text-muted small">OR</span>
            </div>

            <!-- Google Authentication Button -->
            <div class="d-grid gap-2">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center gap-2 py-2" style="border-radius: 6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                    Sign up with Google
                </a>
            </div>

            <div class="text-center mt-2">
                <small class="text-muted" style="font-size: 12px;">Already have an account? <a href="{{ route('login') }}" class="fw-bold text-success text-decoration-none">Login here</a></small>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Show/Hide Password Feature -->
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