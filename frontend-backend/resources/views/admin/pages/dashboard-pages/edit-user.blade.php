@extends('admin.master-layout.master')

@section('content')
<div class="container">
    <h2>Edit User: {{ $user->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password (leave blank to keep current):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>User Type:</label>
            <select name="usertype" class="form-control" required>
                <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Theme:</label>
            <select name="theme" class="form-control" required>
                <option value="light" {{ $user->theme == 'light' ? 'selected' : '' }}>Light</option>
                <option value="dark" {{ $user->theme == 'dark' ? 'selected' : '' }}>Dark</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Email Verified?</label>
            <select name="email_verified_at" class="form-control">
                <option value="" {{ $user->email_verified_at == null ? 'selected' : '' }}>No</option>
                <option value="{{ now() }}" {{ $user->email_verified_at != null ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label>CV Uploaded?</label>
            <select name="cv_uploaded" class="form-control" required>
                <option value="0" {{ $user->cv_uploaded == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ $user->cv_uploaded == 1 ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Subscription Status:</label>
            <select name="subscription_status" class="form-control" required>
                <option value="inactive" {{ $user->subscription_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="active" {{ $user->subscription_status == 'active' ? 'selected' : '' }}>Active</option>
            </select>
        </div>

        <button class="btn btn-primary">Update User</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
