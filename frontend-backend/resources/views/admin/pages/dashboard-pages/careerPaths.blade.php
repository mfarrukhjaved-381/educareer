@extends('admin.master-layout.master')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Career Paths</h2>

        <div class="alert alert-info">
            This is the admin panel for managing career paths. You can add, edit, or delete career paths that will be shown
            to users.
        </div>

        <a href="{{ route('admin.careerPaths.create') }}" class="btn btn-primary mb-3">+ Add New Career Path</a>

        {{-- Table placeholder --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Career Title</th>
                            <th>Description</th>
                            <th>Skills Required</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($careerPaths as $path)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $path->title }}</td>
                            <td>{{ Str::limit($path->description, 100) }}</td>
                            <td>{{ $path->skills }}</td>
                            <td>
                                <a href="{{ route('admin.careerPaths.edit', $path->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                                <form action="{{ route('admin.careerPaths.delete', $path->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this career path?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No career paths found.</td>
                        </tr>
                    @endforelse
                    
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
