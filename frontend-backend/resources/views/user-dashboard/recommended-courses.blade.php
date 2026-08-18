@extends('user-dashboard.app')

@section('content')

    <div class="container py-4">
        <div class="page-inner">
            <div class="pt-4 pb-2">
                <h3 class="fw-bold mb-1">Recommended Courses</h3>
                <h6 class="op-7 mb-3">Enhance your skills with these courses</h6>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (isset($matchedCourses) && count($matchedCourses) > 0)
                <div class="row">
                    @foreach ($matchedCourses as $course)
                        <div class="col-md-6 mb-4">
                            <div class="card p-3 shadow-sm" style="border-radius: 1rem;">
                                <h5 class="fw-bold">{{ $course['name'] ?? 'Course Title Not Available' }}</h5>
                                <p class="mb-1"><strong>Provider:</strong> {{ $course['provider'] ?? 'Unknown Provider' }}
                                </p>
                                <p class="mb-1"><strong>Rating:</strong> {{ $course['rating'] ?? 'N/A' }}</p>
                                <p class="mb-2">
                                    <strong>Matched Skills:</strong>
                                    @if (isset($course['matched_skills']) && count($course['matched_skills']) > 0)
                                        @foreach ($course['matched_skills'] as $skill)
                                            <span class="badge bg-success me-1">{{ $skill }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">No matched skills</span>
                                    @endif
                                </p>
                                @if (isset($course['course_link']))
                                    <a href="{{ $course['course_link'] }}" target="_blank"
                                        class="btn btn-success btn-sm">View Course</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No recommended courses available at the moment. Please upload your CV and try again.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('user.dashboard.courses') }}" class="btn btn-primary">Go to EduCareer Courses</a>
            </div>
        </div>
    </div>
@endsection
