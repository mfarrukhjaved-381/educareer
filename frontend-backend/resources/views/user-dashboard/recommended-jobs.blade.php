@extends('user-dashboard.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center fw-bold">Recommended Jobs</h2>

        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif

        @if (isset($recommendedJobs) && count($recommendedJobs) > 0)
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($recommendedJobs as $job)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary fw-semibold">
                                    {{ $job['title'] ?? 'Job Title Not Available' }}</h5>
                                <p class="card-subtitle mb-2 text-muted">
                                    <i class="bi bi-building"></i> {{ $job['company'] ?? 'Unknown Company' }}
                                </p>
                                <p class="mb-1"><strong>Location:</strong> {{ $job['location'] ?? 'Remote' }}</p>
                                <p class="text-truncate" style="max-width: 100%;">
                                    {{ $job['description'] ?? 'No description provided.' }}</p>

                                @if (isset($job['Matching Skills']) && count($job['Matching Skills']) > 0)
                                    <div class="mb-2">
                                        <strong>Matching Skills:</strong>
                                        @foreach ($job['matching_skills'] as $skill)
                                            <span class="badge bg-secondary me-1">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <a href="{{ $job['url'] ?? '#' }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">View Job</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-5">
                <p class="lead">No recommended jobs available at the moment.</p>
                <p>Please upload your CV and try again.</p>
            </div>
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
@endsection
