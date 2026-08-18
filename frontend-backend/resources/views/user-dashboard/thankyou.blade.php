@extends('user-dashboard.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="fw-bold text-success">🎉 Thank You for Upgrading!</h2>
    <p class="lead mt-3">You've successfully subscribed to the <strong>Premium Plan</strong>.</p>
    <p>All premium features are now unlocked.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4">Go to Dashboard</a>
</div>
@endsection
