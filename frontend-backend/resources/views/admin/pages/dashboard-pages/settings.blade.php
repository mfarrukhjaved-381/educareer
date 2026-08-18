@extends('admin.master-layout.master')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Settings</h2>

    <div class="alert alert-info">
        Manage your admin panel settings here.
    </div>

    <form action="{{ route('admin.settings') }}" method="POST">
        @csrf
        {{-- Example setting: site name --}}
        <div class="mb-3">
            <label for="site_name" class="form-label">Site Name</label>
            <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings->site_name ?? '') }}">
        </div>

        {{-- Add more settings fields here --}}

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
