@extends('admin.master-layout.master')


@section('title', 'Add Career Path')

@section('content')
<div class="container mt-4">
    <h3>Add New Career Path</h3>
    
    <form action="{{ route('admin.careerPaths.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="title">Career Path Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group mt-3">
            <label for="skills">Skills (comma-separated)</label>
            <input type="text" name="skills" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-4">Add Career Path</button>
        <a href="{{ route('admin.careerPaths') }}" class="btn btn-secondary mt-4">Back</a>
    </form>
</div>
@endsection
