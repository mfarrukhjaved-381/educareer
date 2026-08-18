@extends('admin.master-layout.master')

@section('title', 'Edit Career Path')

@section('content')
<div class="container mt-4">
    <h3>Edit Career Path</h3>

    <form action="{{ route('admin.careerPaths.update', $careerPath->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Career Path Title</label>
            <input type="text" name="title" class="form-control" value="{{ $careerPath->title }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $careerPath->description }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label for="skills">Skills (comma-separated)</label>
            <input type="text" name="skills" class="form-control" value="{{ $careerPath->skills }}">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update Career Path</button>
        <a href="{{ route('admin.careerPaths') }}" class="btn btn-secondary mt-4">Cancel</a>
    </form>
</div>
@endsection
