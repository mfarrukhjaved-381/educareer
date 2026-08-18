@extends('admin.master-layout.master')

@section('title', 'Manage Courses')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Courses</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Add New Course</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Instructor</th>
                <th>Category</th>
                <th>Duration (hours)</th>
                <th>Created At</th>
                <th style="width: 160px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->instructor }}</td>
                <td>{{ $course->category ?? 'N/A' }}</td>
                <td>{{ $course->duration ?? 'N/A' }}</td>
                <td>{{ $course->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No courses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $courses->links() }}
    </div>
</div>
@endsection
