@extends('admin.master-layout.master')

@section('title', 'Add New Course')

@section('content')
<div class="container py-4">
    <h2>Add New Course</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="instructor" class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" required value="{{ old('instructor') }}">
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">Course Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">Course URL</label>
            <input type="text" name="url" class="form-control" required value="{{ old('url') }}">
        </div>


        <button type="submit" class="btn btn-success">Create Course</button>
        <a href="{{ route('admin.courses') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
