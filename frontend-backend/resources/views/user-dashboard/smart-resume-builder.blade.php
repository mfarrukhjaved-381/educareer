@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">Smart Resume Builder</h3>
            <h6 class="op-7 mb-3">Craft a job-optimized, AI-enhanced resume in minutes</h6>
        </div>

        <form method="GET" action="{{ route('upgrade') }}">
            @csrf

            <div class="card p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">👤 Personal Details</h5>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input name="name" type="text" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">💼 Experience</h5>
                <textarea name="experience" rows="4" class="form-control" placeholder="Describe your most relevant work experiences...">{{ old('experience') }}</textarea>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">🎓 Education</h5>
                <textarea name="education" rows="3" class="form-control" placeholder="Your degrees, institutions, and graduation years...">{{ old('education') }}</textarea>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">🧠 Skills</h5>
                <textarea name="skills" rows="2" class="form-control" placeholder="List your top skills, separated by commas">{{ old('skills') }}</textarea>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">📝 Summary</h5>
                <textarea name="summary" rows="3" class="form-control" placeholder="Write a professional summary about yourself">{{ old('summary') }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-4 py-2">🔒 Generate My Premium Resume</button>
                <p class="text-muted mt-2">* This is a paid feature. Resume PDF will be emailed/downloadable after payment.</p>
            </div>
        </form>
    </div>
</div>
@endsection
