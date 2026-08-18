@extends('user-dashboard.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold">🔐 Secure Payment</h3>
    </div>
    <form method="POST" action="{{ route('subscription.process') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Card Number</label>
            <input type="text" name="card" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Expiry</label>
                <input type="text" name="expiry" class="form-control" placeholder="MM/YY" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">CVV</label>
                <input type="text" name="cvv" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Pay PKR 999</button>
    </form>
</div>
@endsection
