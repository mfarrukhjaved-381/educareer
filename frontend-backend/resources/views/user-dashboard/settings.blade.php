@extends('user-dashboard.app')

@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="pt-4 pb-2">
            <h3 class="fw-bold mb-1">Settings</h3>
            <h6 class="op-7 mb-3">Customize your dashboard preferences</h6>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4 shadow-sm">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <!-- Theme Setting -->
                <div class="mb-4">
                    <label for="theme" class="form-label">Choose Theme</label>
                    <select id="theme" name="theme" class="form-select">
                        @php $theme = auth()->user()->theme ?? 'light'; @endphp
                        <option value="light" {{ $theme == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ $theme == 'dark' ? 'selected' : '' }}>Dark</option>
                        
                    </select>
                </div>

                <!-- Notification Preferences -->
                <div class="mb-4">
                    <label for="email_notifications" class="form-label">Email Notifications</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="email_notifications" name="email_notifications" value="1" {{ auth()->user()->email_notifications ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_notifications">Receive email alerts for new job recommendations and updates.</label>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
