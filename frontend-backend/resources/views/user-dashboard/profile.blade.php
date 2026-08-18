@extends('user-dashboard.app')

@section('content')
    <div class="container py-4">
        <div class="page-inner">
            {{-- Welcome Message --}}
            <div class="pt-4 pb-2 text-center">
                <h2 class="fw-bold">Welcome, {{ auth()->user()?->name ?? 'Guest' }}!</h2>
                <p class="text-muted">We're glad to have you here. Manage your profile below.</p>
            </div>

            {{-- Profile Completion Progress --}}
            <div class="mb-4" style="max-width: 700px; margin: 0 auto;">
                <label class="form-label fw-semibold">Profile Completion</label>
                <div class="progress" style="height: 24px;">
                    <div class="progress-bar {{ $completion >= 100 ? 'bg-success' : 'bg-info' }}" role="progressbar"
                        style="width: {{ $completion }}%;" aria-valuenow="{{ $completion }}" aria-valuemin="0"
                        aria-valuemax="100">
                        {{ $completion }}%
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Profile Form --}}
            <form method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data" class="scroll-to-form">
                @csrf
                @method('POST')

                {{-- Editable Profile Card --}}
                <div class="card p-4 shadow-sm mt-4 mb-4" style="border-radius: 1rem; max-width: 700px; margin: 0 auto;">
                    <h4 class="fw-bold mb-4">Your Profile Information</h4>

                    {{-- Profile Picture --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control"
                            title="Upload your profile picture" data-bs-toggle="tooltip">
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip" title="Your full name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $userProfile->name }}">
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your email address">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $userProfile->email }}">
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your professional role or title">Role</label>
                        <input type="text" class="form-control" name="role" value="{{ $userProfile->role }}">
                    </div>

                    {{-- Location --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your current city or location">Location</label>
                        <input type="text" class="form-control" name="location" value="{{ $userProfile->location }}">
                    </div>

                    {{-- Summary --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="A short description of yourself">Summary</label>
                        <textarea class="form-control" name="summary" rows="5">{{ $userProfile->summary }}</textarea>
                    </div>

                    {{-- Skills --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your skills (comma separated)">Skills <small class="text-muted">(Comma
                                separated)</small></label>
                        <input type="text" class="form-control" name="skills"
                            value="{{ is_array($userProfile->skills) ? implode(', ', $userProfile->skills) : $userProfile->skills }}">

                    </div>

                    {{-- Education --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your educational background">Education</label>
                        <textarea class="form-control" name="education" rows="3">{{ $userProfile->education }}</textarea>
                    </div>

                    {{-- Experience --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your work experience">Experience</label>
                        <textarea class="form-control" name="experience" rows="3">{{ $userProfile->experience }}</textarea>
                    </div>

                    {{-- Interests --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Your interests or hobbies (comma separated)">Interests <small class="text-muted">(Comma
                                separated)</small></label>
                                <input type="text" class="form-control" name="interests"
                                value="{{ is_array($userProfile->interests) ? implode(', ', $userProfile->interests) : $userProfile->interests }}">
                         
                    </div>

                    {{-- Projects --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Any projects you've worked on">Projects</label>
                        <textarea class="form-control" name="projects" rows="3">{{ $userProfile->projects }}</textarea>
                    </div>

                    {{-- Certifications & Courses --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" data-bs-toggle="tooltip"
                            title="Certifications and courses you've completed">Certifications & Courses</label>
                        <textarea class="form-control" name="certifications" rows="3">{{ $userProfile->certifications }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 profile-btn-save">Save Changes</button>
                </div>
            </form>

            {{-- update password of the Account --}}
            <hr class="my-5">
            <div class="card p-4 shadow-sm mt-5" style="border-radius: 1rem; max-width: 700px; margin: 0 auto;">
                <h5 class="fw-bold mb-3">Update Password</h5>

                <form action="{{ route('settings.update.password') }}" method="POST">
                    @csrf
                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control"
                            required>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-danger">Update Password</button>
                </form>
            </div>

            {{-- Delete Account --}}
            <hr class="my-5">
            <div class="card p-4 shadow-sm mt-5" style="border-radius: 1rem; max-width: 700px; margin: 0 auto;">
                <h5 class="fw-bold text-danger">Delete Account</h5>
                <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently
                    deleted. Please enter your password to confirm you want to permanently delete your account.</p>

                <form method="POST" action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" required
                            placeholder="Enter your password to confirm">
                        @error('userDeletion.password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger w-100 profile-btn-delete">Delete Account</button>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript for Tooltips --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
                tooltipTriggerEl))
        })
    </script>

    {{-- Smooth Scroll for Profile Update Form --}}
    <script>
        document.querySelector('.scroll-to-form').addEventListener('submit', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endsection
