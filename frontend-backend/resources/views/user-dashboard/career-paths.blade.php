@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">Career Path Suggestions</h3>
            <h6 class="op-7 mb-3">Explore career paths based on your skills</h6>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($careerPaths) && count($careerPaths) > 0)
            <div class="row">
                @foreach($careerPaths as $path)
                    <div class="col-md-6 mb-4">
                        <div class="card p-3 shadow-sm" style="border-radius: 1rem;">
                            <h5 class="fw-bold">{{ $path['Career Path'] ?? 'Career Title Not Available' }}</h5>
                            <div class="text-sm text-gray-600">
                                            Next Roles: {{ implode(', ', $path['Next Roles'] ?? []) }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                        Matching Skills: {{ implode(', ', $path['Matching Skills'] ?? []) }}
                                    </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No career paths available at the moment. Please upload your CV and try again.</p>
        @endif
    </div>
</div>


    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4">Back to Dashboard</a>
</div>
@endsection