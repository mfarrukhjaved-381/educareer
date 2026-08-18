@extends('user-dashboard.app')

@section('content')
    <div class="container py-4">
        <div class="page-inner">
            <div class="pt-4 pb-2">
                <h3 class="fw-bold mb-1">Upskill</h3>
                <h6 class="op-7 mb-4">Learn new skills and stay ahead in your career</h6>
            </div>

            @if (session('error'))
                <div class="alert alert-warning">{{ session('error') }}</div>
            @else
                <!-- Target Career Role Form -->
                <form method="GET" action="{{ route('upskill') }}" class="mb-4">
                    <div class="card shadow-sm p-3">
                        <label for="career_goal" class="form-label fw-bold mb-2">🎯 Select Your Career Goal</label>
                        <select name="career_goal" id="career_goal" class="form-select mb-3" onchange="this.form.submit()">
                            <option value="">-- Choose a role --</option>
                            @foreach ($careerPaths as $path)
                                <option value="{{ $path['role'] }}" {{ $selectedRole == $path['role'] ? 'selected' : '' }}>
                                    {{ $path['role'] }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">This will help us identify skills you need to learn.</small>
                    </div>
                </form>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm p-3 mb-4">
                            <h5 class="fw-bold mb-2">✅ Your Current Skills</h5>
                            <ul class="list-group list-group-flush">
                                @forelse($userSkills as $skill)
                                    <li class="list-group-item">{{ ucfirst($skill) }}</li>
                                @empty
                                    <li class="list-group-item">No skills found from your resume.</li>
                                @endforelse
                                <a href="{{ route('skill-gap.report', ['role' => $selectedRole]) }}"
                                    class="btn btn-outline-info w-100 mt-3">
                                    📊 View Detailed Skill Gap Report
                                 </a>
                            </ul>
                        </div>
                    </div>

                     
                    @if ($selectedRole)
                        <div class="col-md-6">
                            <div class="card shadow-sm p-3 mb-4">
                                <h5 class="fw-bold mb-2">📈 Skills Needed for "{{ $selectedRole }}"</h5>
                                <ul class="list-group list-group-flush">
                                    @forelse($missingSkills as $skill)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ ucfirst($skill) }}
                                            <a href="/recommended-courses" class="btn btn-sm btn-outline-primary">Find
                                                Course</a>
                                        </li>
                                    @empty
                                        <li class="list-group-item">You're already well-prepared for this role!</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

@endsection
