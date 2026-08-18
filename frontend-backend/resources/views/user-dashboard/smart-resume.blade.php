@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">Smart Resume</h3>
            <h6 class="op-7 mb-3">Get AI-powered tips to optimize your resume for better jobs</h6>
        </div>

        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @else
        <div class="card p-4 shadow-sm mb-4">
            <h5 class="fw-bold mb-3">📄 Your Resume Summary</h5>
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Skills:</strong> {{ implode(', ', $skills) }}</p>
        </div>

        <div class="card p-4 shadow-sm mb-4">
            <h5 class="fw-bold mb-3">📈 Resume Score: <span class="text-primary">{{ $score }}/100</span></h5>
            <p class="text-muted">Based on your current education, experience, and skillset.</p>
        </div>

        <div class="card p-4 shadow-sm mb-4">
            <h5 class="fw-bold mb-3">💡 AI Suggestions to Improve</h5>
            <ul class="list-group list-group-flush">
                @forelse($tips as $tip)
                    <li class="list-group-item">{{ $tip }}</li>
                @empty
                    <li class="list-group-item">Great job! Your resume looks strong.</li>
                @endforelse
            </ul>
        </div>

        <div class="card p-4 shadow-sm text-center">
            <h5 class="fw-bold mb-3">🚀 Want to generate an optimized Smart Resume?</h5>
            <p class="mb-3">Let us auto-generate a professionally structured, job-optimized resume for you.</p>
            <a href="{{ route('smartResumeBuilder') }}" class="btn btn-primary">Unlock Paid Smart Resume Builder</a>
        </div>
        @endif
    </div>
</div>
@endsection
