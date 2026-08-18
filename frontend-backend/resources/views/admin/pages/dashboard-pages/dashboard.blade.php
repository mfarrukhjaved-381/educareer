@extends('admin.master-layout.master')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Admin Dashboard</h6>
        </div>

        <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">

            <!-- Total Users -->
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Users</p>
                                <h6 class="mb-0">{{ number_format($totalUsers) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>

            <!-- Total Courses -->
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Courses</p>
                                <h6 class="mb-0">{{ number_format($totalCourses) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>

                    </div>
                </div><!-- card end -->
            </div>
        </div>

        <div class="row gy-4 mt-1">
            <div class="col-xxl-9 col-xl-12">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <h4 class="mb-4">User Overview</h4>
                        <div class="table-responsive scroll-sm">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>CV Uploaded</th>
                                        <th>Subscription</th>
                                        <th>Registered At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->cv_uploaded)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $user->subscription_status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($user->subscription_status) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
