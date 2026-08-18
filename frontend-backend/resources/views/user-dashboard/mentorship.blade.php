@extends('user-dashboard.app')

@section('content')
<div class="container py-5">
    <div class="page-inner">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">🤝 Find a Mentor</h2>
            <p class="text-muted">Connect with top professionals who can guide your career journey.</p>
        </div>

        <!-- Industry Filters -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-4">
            @foreach(['IT', 'Marketing', 'Finance', 'Design', 'Engineering', 'Healthcare'] as $industry)
                <button class="btn btn-outline-primary btn-sm">{{ $industry }}</button>
            @endforeach
        </div>

        <!-- Mentor Cards -->
        <div class="row">
            @for($i = 1; $i <= 6; $i++)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://img.freepik.com/premium-psd/contact-icon-illustration-isolated_23-2151903357.jpg?semt=ais_hybrid&w=740" class="rounded-circle me-3" width="60" height="60" alt="Mentor {{ $i }}">
                        <div>
                            <h6 class="mb-0">Mentor {{ $i }}</h6>
                            <small class="text-muted">Senior {{ ['Developer', 'Marketer', 'Engineer'][$i % 3] }} @ TechCorp</small>
                        </div>
                    </div>
                    <p><strong>Expertise:</strong> {{ ['AI, Python', 'SEO, Branding', 'Cloud, DevOps'][$i % 3] }}</p>
                    <p><strong>Location:</strong> Lahore, PK</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary btn-sm">📅 Book Session</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">💬 Message</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Become a Mentor CTA -->
        <div class="text-center my-5">
            <h5>Are you an experienced professional?</h5>
            <p>Join EduCareer as a mentor and guide the next generation.</p>
            <a href="#" class="btn btn-success">Become a Mentor</a>
        </div>

        <!-- Mentor Request Form -->
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Can't find a mentor?</h5>
            <p>Let us know your field, and we'll connect you with the right person.</p>
            <form>
                <div class="mb-3">
                    <label for="field" class="form-label">Your Field of Interest</label>
                    <input type="text" class="form-control" id="field" placeholder="e.g. Data Science, HR, Law">
                </div>
                <div class="mb-3">
                    <label for="goal" class="form-label">What do you want to learn?</label>
                    <textarea class="form-control" id="goal" rows="3" placeholder="Your goals or questions..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Request a Mentor</button>
            </form>
        </div>
    </div>
</div>
@endsection
