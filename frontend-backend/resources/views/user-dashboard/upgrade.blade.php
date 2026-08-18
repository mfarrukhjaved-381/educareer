@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner text-center">
        <h3 class="fw-bold mb-4">🚀 Upgrade Your EduCareer Experience</h3>
        <p class="mb-5 text-muted">Choose a plan that fits your career goals.</p>

        <div class="row justify-content-center">
            <!-- Free Plan -->
            <div class="col-md-5">
                <div class="card p-4 shadow-sm mb-4">
                    <h4 class="fw-bold">Free Plan</h4>
                    <p class="text-muted">You're already on this plan</p>
                    <ul class="list-group list-group-flush text-start mt-3">
                        <li class="list-group-item">✅ Basic Resume Analysis</li>
                        <li class="list-group-item">✅ Limited Job & Course Suggestions</li>
                        <li class="list-group-item">✅ Career Path Insights</li>
                        <li class="list-group-item">❌ Smart Resume Builder</li>
                        <li class="list-group-item">❌ Mentorship Access</li>
                        <li class="list-group-item">❌ Premium Job Matching</li>
                    </ul>
                    <button class="btn btn-outline-secondary mt-4" disabled>Current Plan</button>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-md-5">
                <div class="card p-4 shadow border-primary mb-4">
                    <h4 class="fw-bold text-primary">Premium Plan</h4>
                    <p class="text-muted">Only PKR 999/month</p>
                    <ul class="list-group list-group-flush text-start mt-3">
                        <li class="list-group-item">✅ Everything in Free</li>
                        <li class="list-group-item">✅ AI Smart Resume Builder</li>
                        <li class="list-group-item">✅ 1-on-1 Mentorship</li>
                        <li class="list-group-item">✅ Unlimited Job & Course Access</li>
                        <li class="list-group-item">✅ Access to Industry Experts</li>
                        <li class="list-group-item">✅ Interview Preparation Tools</li>
                    </ul>
                    <a href="{{ route('subscription.payment') }}" class="btn btn-primary mt-4">Upgrade Now</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
