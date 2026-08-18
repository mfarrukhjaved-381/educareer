@extends('admin.master-layout.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Users Management</h4>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">+ Add New User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Theme</th>
                <th>User Type</th>
                <th>Email Verified</th>
                <th>CV Uploaded</th>
                <th>Subscription Status</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->theme) }}</td>
                <td>{{ ucfirst($user->usertype) }}</td>
                <td>
                    @if($user->email_verified_at)
                        <span class="badge bg-success">Verified</span><br>
                        <small>{{ $user->email_verified_at->format('d M Y') }}</small>
                    @else
                        <span class="badge bg-danger">Not Verified</span>
                    @endif
                </td>
                <td>
                    @if($user->cv_uploaded)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $user->subscription_status === 'active' ? 'bg-success' : 'bg-warning' }}">
                        {{ ucfirst($user->subscription_status) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
