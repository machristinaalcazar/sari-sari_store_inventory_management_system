@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center py-1">
    <div class="card shadow border-0 w-100" style="max-width: 480px; border-radius: 12px; overflow: hidden;">
        <!-- Header -->
        <div class="card-header text-center bg-success text-white py-2">
            <h5 class="mb-0 fw-bold">Create New Account</h5>
        </div>

        <div class="card-body px-4 py-3">
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
                    <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
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
                        <option value="staff" selected>Staff / Helper</option>
                        <option value="admin">Owner / Administrator</option>
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