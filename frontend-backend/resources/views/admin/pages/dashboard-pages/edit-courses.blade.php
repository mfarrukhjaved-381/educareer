@extends('admin.master-layout.master')

@section('title', 'Edit Course')

@section('content')
<div class="container py-4">
    <h2>Edit Course</h2>

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

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $course->title) }}">
        </div>

        <div class="mb-3">
            <label for="instructor" class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" required value="{{ old('instructor', $course->instructor) }}">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $course->category) }}">
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration (in hours)</label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Course Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="{{ route('admin.courses') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
