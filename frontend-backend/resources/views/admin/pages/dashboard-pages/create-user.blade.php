@extends('admin.master-layout.master')

@section('content')
<div class="container">
    <h2>Add New User</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>User Type:</label>
            <select name="usertype" class="form-control" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Theme:</label>
            <select name="theme" class="form-control" required>
                <option value="light">Light</option>
                <option value="dark">Dark</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Email Verified?</label>
            <select name="email_verified_at" class="form-control">
                <option value="">No</option>
                <option value="{{ now() }}">Yes (Now)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>CV Uploaded?</label>
            <select name="cv_uploaded" class="form-control" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Subscription Status:</label>
            <select name="subscription_status" class="form-control" required>
                <option value="inactive">Inactive</option>
                <option value="active">Active</option>
            </select>
        </div>

        <button class="btn btn-success">Create User</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
