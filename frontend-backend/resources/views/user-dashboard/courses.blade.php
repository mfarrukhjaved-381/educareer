@extends('user-dashboard.app')

@section('content')
    <div class="container py-4">
        <div class="page-inner">
            <div class="pt-4 pb-2">
                <h2 class="mb-4">Available Courses</h2>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @forelse($courses as $course)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Instructor: {{ $course->instructor }}</h6>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($course->description, 100) }}
                                </p>
                                <a href="{{ $course->url }}" class="btn btn-primary" target="_blank">Watch</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No courses available yet.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
