@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">Create System User</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Assigned Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin / Owner</option>
                            <option value="staff">Staff / Helper</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection