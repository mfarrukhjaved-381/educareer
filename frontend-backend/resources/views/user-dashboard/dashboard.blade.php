@include('user-dashboard.css')

<style>
    :root {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --secondary: #6366f1;
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --light: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --border-radius: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f8fafc;
        color: var(--gray-700);
        line-height: 1.5;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* Main Content */
    .main-panel {
        flex: 1;
        margin-left: 260px;
        transition: var(--transition);
    }

    .main-header {
        background-color: white;
        border-bottom: 1px solid var(--gray-200);

        top: 0;
        z-index: 40;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .welcome-section {
        margin-bottom: 2rem;
        margin-top: 2rem;
        margin-left: 2rem;
    }

    .welcome-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .welcome-section p {
        color: var(--gray-500);
    }

    .grid {
        display: grid;
        gap: 1.5rem;
    }

    .grid-cols-1 {
        grid-template-columns: 1fr;
    }

    @media (min-width: 768px) {
        .md\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .lg\:grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .stats-card {
        padding: 1rem;
        margin-left: 1rem;
        position: relative;
        overflow: hidden;
    }

    .stats-card-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .stats-card-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .stats-card-label {
        font-size: 0.875rem;
        color: var(--gray-500);
        font-weight: 500;
    }

    .bg-primary {
        background-color: var(--primary);
    }

    .bg-success {
        background-color: var(--success);
    }

    .bg-warning {
        background-color: var(--warning);
    }

    .bg-secondary {
        background-color: var(--secondary);
    }

    .progress-container {
        width: 100%;
        height: 8px;
        background-color: var(--gray-200);
        border-radius: 999px;
        margin-top: 1rem;
    }

    .progress-bar {
        height: 100%;
        border-radius: 999px;
        background-color: var(--primary);
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .upgrade-card {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .upgrade-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .upgrade-card p {
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    .upgrade-card-bg {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0.1;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        border-radius: 8px;
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
    }

    .btn-white {
        background-color: white;
        color: var(--primary);
    }

    .btn-white:hover {
        background-color: var(--gray-100);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .content-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .content-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .content-card-header h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .content-list {
        list-style: none;
        padding: 0;
    }

    .content-list-item {
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: var(--transition);
    }

    .content-list-item:hover {
        background-color: var(--gray-50);
    }

    .content-list-item:last-child {
        margin-bottom: 0;
    }

    .content-list-item-title {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .content-list-item-subtitle {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .alert-warning {
        background-color: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #92400e;
    }

    .alert-success {
        background-color: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #166534;
    }

    .alert-icon {
        font-size: 1.25rem;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .alert-text {
        font-size: 0.875rem;
    }

    .alert-link {
        color: inherit;
        text-decoration: underline;
        font-weight: 500;
    }

    .alert-link:hover {
        text-decoration: none;
    }

    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
        margin-left: 1rem;
        margin-top: 2rem;
    }

    .quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.25rem 1rem;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        text-decoration: none;
        color: var(--gray-700);
        transition: var(--transition);
        text-align: center;
    }

    .quick-link:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        color: var(--primary);
    }

    .quick-link i {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
    }

    .quick-link span {
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Footer */
    .footer {
        padding: 1.5rem;
        border-top: 1px solid var(--gray-200);
        background-color: white;
        font-size: 0.875rem;
        color: var(--gray-500);
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .main-panel {
            margin-left: 0;
        }
    }

    /* Icons */
    .icon {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 1;
    }
</style>
</head>

<body class="bg-gray-100 text-gray-800" data-theme="{{ auth()->user()->theme ?? 'light' }}">
    <div class="wrapper">
        @include('user-dashboard.sidebar')

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('dashboard') }}" class="logo">EduCareer</a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                        </div>
                        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                    </div>
                </div>
                @include('user-dashboard.navbar')
            </div>

            <div class="container">
                <section class="welcome-section">
                    <h3>Welcome back, {{ auth()->user()?->name ?? 'Guest' }} 👋</h3>
                    <p>Track your progress and explore personalized recommendations</p>
                </section>

                <!-- Stats Cards with Hover Effects -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Jobs Recommended -->
                    <div
                        class="card stats-card transform transition duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">
                        <div class="stats-card-icon bg-primary">
                            <span class="icon">🔍</span>
                        </div>
                        <div class="stats-card-label">Jobs Recommended</div>
                        <div id="jobs-count" class="stats-card-value">{{ count($cvResults['jobs'] ?? []) }}</div>
                    </div>

                    <!-- Courses Suggested -->
                    <div
                        class="card stats-card transform transition duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">
                        <div class="stats-card-icon bg-success">
                            <span class="icon">📚</span>
                        </div>
                        <div class="stats-card-label">Courses Suggested</div>
                        <div id="courses-count" class="stats-card-value">{{ count($cvResults['courses'] ?? []) }}</div>
                    </div>

                    <!-- Career Paths -->
                    <div
                        class="card stats-card transform transition duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">
                        <div class="stats-card-icon bg-warning">
                            <span class="icon">🧭</span>
                        </div>
                        <div class="stats-card-label">Career Paths</div>
                        <div id="paths-count" class="stats-card-value">{{ count($cvResults['career_paths'] ?? []) }}
                        </div>
                    </div>

                    {{-- Profile Completion Card --}}
                    <div class="card shadow-sm mb-4 p-4"
                        style="max-width: 700px; margin: 0 auto; transition: transform 0.3s ease-in-out;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-semibold">Profile Strength</h5>
                            <span class="fw-bold text-primary">{{ $completion }}%</span>
                        </div>

                        <div class="progress" style="height: 8px; background-color: #e9ecef;">
                            <div class="progress-bar {{ $completion >= 100 ? 'bg-success' : 'bg-info' }}"
                                role="progressbar" style="width: {{ $completion }}%;"
                                aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.9rem;">
                            <span> Your profile is: </span>
                            <span>{{ $completion }}/100</span>
                        </div>
                    </div>

                </div>


                <!-- Quick Links -->
                <section class="quick-links">
                    <a href="{{ route('cv') }}" class="quick-link">
                        <span class="icon">📄</span>
                        <span>Upload your CV</span>
                    </a>
                    <a href="{{ route('uploadUserData') }}" class="quick-link"><span class="icon">📄</span>
                        <span>Manually upload data</span>
                    </a>
                    <a href="{{ route('recommended-courses') }}" class="quick-link">
                        <span class="icon">📚</span>
                        <span>View Courses</span>
                    </a>
                    <a href="{{ route('upskill') }}" class="quick-link">
                        <span class="icon">🧠</span>
                        <span>Upskill yourself</span>
                    </a>
                    <a href="{{ route('career-paths') }}" class="quick-link">
                        <span class="icon">📈</span>
                        <span>Career Paths</span>
                    </a>
                    <a href="{{ route('recommended-jobs') }}" class="quick-link">
                        <span class="icon">💼</span>
                        <span>Online Job</span>
                    </a>
                    <a href="{{ route('mentorship') }}" class="quick-link">
                        <span class="icon">🧑‍🏫</span>
                        <span>Mentorship</span>
                    </a>

                </section>

                <!-- Upgrade Call-To-Action -->
                <div
                    class="upgrade-card my-10 p-6 relative rounded-lg shadow-md bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                    <h4 class="text-xl font-semibold">🚀 Unlock full potential of EduCareer</h4>
                    <p class="mt-1 text-sm">Access smart resume, live mentorship, and deeper career
                        insights.</p>
                    <a href="{{ route('upgrade') }}" class="btn btn-white mt-4">Upgrade Now</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        <div class="alert-icon">✅</div>
                        <div class="alert-content">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- CV Warning or Recommendations -->
                @if (!Auth::user()->cv_uploaded)
                    <div class="alert alert-warning">
                        <div class="alert-icon">⚠️</div>
                        <div class="alert-content">
                            <div class="alert-title">CV not uploaded</div>
                            <div class="alert-text">Please <a href="{{ route('cv') }}" class="alert-link">upload your
                                    CV</a> to unlock personalized recommendations.</div>
                        </div>
                    </div>
                @else
                    <!-- Jobs Section -->
                    <a href="{{ route('recommended-jobs') }}"
                        class="block transform transition duration-300 hover:scale-105">
                        <div class="card content-card hover:shadow-lg">
                            <div class="content-card-header">
                                <h4><span class="icon">🔍</span> Recommended Jobs</h4>
                                <span class="btn btn-primary btn-sm">View All</span>
                            </div>
                            @if (!empty($cvResults['jobs']))
                                <ul class="content-list">
                                    @foreach (array_slice($cvResults['jobs'], 0, 3) as $job)
                                        {{-- <pre>{{ print_r($cvResults['jobs'][0] ?? 'No job found', true) }}</pre> --}}
                                        <li class="content-list-item hover:bg-gray-50 transition rounded px-2 py-2">
                                            <div class="content-list-item-title">
                                                <h4>Job Title: {{ $job['title'] ?? 'Unknown Job' }}</h4>
                                                Company Name: {{ $job['company'] ?? 'Unknown Company' }} –

                                            </div>
                                            <div class="content-list-item-subtitle text-sm text-gray-600">
                                                Location: {{ $job['location'] ?? 'Remote' }}
                                            </div>
                                            @if (isset($job['url']))
                                                <a href="{{ $job['url'] }}" class="btn btn-primary btn-sm mt-2"
                                                    target="_blank">
                                                    View Job
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 px-4 py-2">No job recommendations found.</p>
                            @endif
                        </div>
                    </a>

                    <!-- Courses Section -->
                    <a href="{{ route('recommended-courses') }}"
                        class="block transform transition duration-300 hover:scale-105">
                        <div class="card content-card hover:shadow-lg">
                            <div class="content-card-header">
                                <h4><span class="icon">📚</span> Recommended Courses</h4>
                                <span class="btn btn-primary btn-sm">View All</span>
                            </div>
                            @if (!empty($cvResults['courses']))
                                <ul class="content-list">
                                    @foreach (array_slice($cvResults['courses'], 0, 3) as $course)
                                        <li class="content-list-item hover:bg-gray-50 transition rounded px-2 py-2">
                                            <div class="content-list-item-title">
                                                Course Name: {{ $course['name'] ?? 'Unnamed Course' }}
                                            </div>
                                            <div class="content-list-item-subtitle text-sm text-gray-600">
                                                Provider: {{ $course['provider'] ?? 'Unknown Platform' }}
                                            </div>
                                            <div class="content-list-item-rating text-sm text-yellow-500">
                                                Rating: {{ $course['rating'] ?? 'No Rating' }}
                                            </div>
                                            @if (isset($course['course_link']))
                                                <a href="{{ $course['course_link'] }}"
                                                    class="btn btn-primary btn-sm mt-2" target="_blank">
                                                    View Course
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 px-4 py-2">No course suggestions found.</p>
                            @endif
                        </div>
                    </a>

                    <!-- Career Paths Section -->
                    <a href="{{ route('career-paths') }}"
                        class="block transform transition duration-300 hover:scale-105">
                        <div class="card content-card hover:shadow-lg">
                            <div class="content-card-header">
                                <h4><span class="icon">🧭</span> Suggested Career Paths</h4>
                                <span class="btn btn-primary btn-sm">View All</span>
                            </div>
                            @if (!empty($cvResults['career_paths']))
                                <ul class="content-list">
                                    @foreach (array_slice($cvResults['career_paths'], 0, 3) as $path)
                                        <li class="content-list-item hover:bg-gray-50 transition rounded px-2 py-2">
                                            <div class="content-list-item-title">
                                                {{ $path['Career Path'] ?? 'Unnamed Path' }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                Next Roles: {{ implode(', ', $path['Next Roles'] ?? []) }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 px-4 py-2">No career paths available yet.</p>
                            @endif
                        </div>
                    </a>

                @endif
            </div>

            @include('user-dashboard.footer')
        </div>
    </div>


</body>
@include('user-dashboard.js')
