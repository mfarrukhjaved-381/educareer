@include('user-dashboard.css')
</head>
<body>
  <div class="wrapper">
    @include('user-dashboard.sidebar')
    <div class="container">
      <h1>CV Analysis Results</h1>

      @if(isset($data['skills']) && count($data['skills']) > 0)
        <h2><a href="{{ route('upskill') }}">Extracted Skills</a></h2>
        <ul>
          @foreach($data['skills'] as $skill)
            <li>{{ $skill }}</li>
          @endforeach
        </ul>
      @else
        <p>No skills extracted.</p>
      @endif

      @if(isset($data['jobs']) && count($data['jobs']) > 0)
        <h2><a href="{{ route('recommended-jobs') }}">Recommended Jobs</a></h2>
        <ul>
          @foreach($data['jobs'] as $job)
            <li>{{ $job['Job Title'] }} - {{ $job['Company Name'] }} ({{ $job['Location'] ?? 'N/A' }})</li>
          @endforeach
        </ul>
      @else
        <p>No jobs recommended.</p>
      @endif

      @if(isset($data['courses']) && count($data['courses']) > 0)
        <h2><a href="{{ route('recommended-courses') }}">Recommended Courses</a></h2>
        <ul>
          @foreach($data['courses'] as $course)
            <li>{{ $course['Course Name'] }} ({{ $course['Platform'] }})</li>
          @endforeach
        </ul>
      @else
        <p>No courses recommended.</p>
      @endif

      @if(isset($data['career_paths']) && count($data['career_paths']) > 0)
        <h2><a href="{{ route('career-paths') }}">Career Path Suggestions</a></h2>
        <ul>
          @foreach($data['career_paths'] as $career)
            <li>{{ $career['Career Path'] }} - Relevance: {{ $career['Relevance Score'] }}</li>
          @endforeach
        </ul>
      @else
        <p>No career paths suggested.</p>
      @endif

      <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
  </div>
  @include('user-dashboard.js')
</body>
</html>