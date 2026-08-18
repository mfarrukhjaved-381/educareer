@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">📚 Recommended Books</h3>
            <h6 class="op-7 mb-3">Curated books to upgrade your skills and career growth.</h6>
        </div>

        <div class="row">
            @foreach($books as $book)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 p-3 shadow-sm">
                        <h5 class="fw-bold">{{ $book['title'] }}</h5>
                        <p class="mb-1"><strong>Author:</strong> {{ $book['author'] }}</p>
                        <p class="mb-1"><strong>Level:</strong> {{ $book['level'] }}</p>
                        <p class="mb-2"><strong>Industry:</strong> {{ $book['industry'] }}</p>
                        <p class="text-muted">{{ $book['description'] }}</p>
                        <p class="text-primary small">Skills: {{ $book['skills'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
