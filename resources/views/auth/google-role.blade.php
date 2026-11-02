@extends('layouts.app')

@section('title', 'Select Role')

@section('content')
<div class="d-flex justify-content-center align-items-center py-2" style="min-height: 75vh;">
    <div class="card shadow border-0 w-100" style="max-width: 480px; border-radius: 12px; overflow: hidden;">
        <!-- Header -->
        <div class="card-header text-center bg-success text-white py-2">
            <h5 class="mb-0 fw-bold">Select Your Account Role</h5>
        </div>

        <div class="card-body px-4 py-3">
            <p class="text-muted small text-center mb-3">
                You are signing in with Google for the first time. Please select your system role to finish setting up your account.
            </p>

            <!-- Flash Feedback Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.google.role.store') }}">
                @csrf

                <!-- Role Selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small mb-1">Choose Role</label>
                    <select name="role" class="form-select form-select-sm @error('role') is-invalid @enderror" required>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff / Helper</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Owner / Administrator</option>
                    </select>
                    @error('role') <span class="text-danger small" style="font-size: 11px;">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success w-100 fw-bold btn-sm py-2 shadow-sm" style="border-radius: 6px;">Confirm & Proceed to Dashboard</button>
            </form>
        </div>
    </div>
</div>
@endsection