@extends('admin.master-layout.master')

@section('content')
<div class="container py-4">
    <h2>Welcome, {{ $user->name }}!</h2>

    <div class="card mt-4">
        <div class="card-body">
            <h5>Profile Details</h5>

            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            {{-- Add more user details here --}}

            {{-- Optionally add a form to update profile info --}}
        </div>
    </div>
</div>
@endsection
