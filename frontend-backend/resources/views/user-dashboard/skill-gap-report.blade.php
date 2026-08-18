@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">📊 Skill Gap Report</h3>
            <h6 class="op-7 mb-4">See how your skills align with your career goal</h6>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3">🎯 Career Goal: {{ $selectedRole }}</h5>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-success mb-2">✅ Skills You Already Have</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @forelse($userSkills as $skill)
                            <li class="list-group-item">{{ ucfirst($skill) }}</li>
                        @empty
                            <li class="list-group-item">No skills found from your CV.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold text-danger mb-2">📈 Missing Skills (Gap)</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @forelse($missingSkills as $skill)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ ucfirst($skill) }}
                                <a href="/recommended-courses?skill={{ urlencode($skill) }}" class="btn btn-sm btn-outline-primary">Find Course</a>
                            </li>
                        @empty
                            <li class="list-group-item">You already match all required skills for this role!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('upskill') }}" class="btn btn-outline-secondary">
                ← Back to Upskill
            </a>
            <a href="#" class="btn btn-success" onclick="window.print();">
                🖨️ Download Report as PDF
            </a>
        </div>
    </div>
</div>
@endsection
