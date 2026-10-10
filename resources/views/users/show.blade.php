@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">User Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
