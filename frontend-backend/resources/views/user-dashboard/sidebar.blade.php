<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <h5 style="color: white">EduCareer</h5>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li class="nav-item {{ request()->routeIs('recommended-jobs') ? 'active' : '' }}">
                    <a href="{{ route('recommended-jobs') }}">
                        <i class="fas fa-store"></i>
                        <p>Recommended Jobs</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('recommended-courses') ? 'active' : '' }}">
                    <a href="{{ route('recommended-courses') }}">
                        <i class="fas fa-laptop-code"></i>
                        <p>Recommended Courses</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('recommended-books') ? 'active' : '' }}">
                    <a href="{{ route('recommended-books') }}">
                        <i class="fas fa-book"></i>
                        <p>Recommended Books</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('upskill') ? 'active' : '' }}">
                    <a href="{{ route('upskill') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <p>UpSkill</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('career-paths') ? 'active' : '' }}">
                    <a href="{{ route('career-paths') }}">
                        <i class="fas fa-chart-pie"></i>
                        <p>Career paths</p>
                    </a>
                </li>



                <li class="nav-item {{ request()->routeIs('smart-resume') ? 'active' : '' }}">
                    <a href="{{ route('smart-resume') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Smart Resume</p>
                    </a>
                </li>



                <li class="nav-item {{ request()->routeIs('mentorship') ? 'active' : '' }}">
                    <a href="{{ route('mentorship') }}">
                        <i class="fas fa-store"></i>
                        <p>Mentorship</p>
                    </a>
                </li>



                <li class="nav-item {{ request()->routeIs('surveys') ? 'active' : '' }}">
                    <a href="{{ route('surveys') }}">
                        <i class="fas fa-chart-pie"></i>
                        <p>Surveys</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <a href="{{ route('settings') }}">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
                

                <li class="nav-item {{ request()->routeIs('upgrade') ? 'active' : '' }}">
                    <a href="{{ route('upgrade') }}">
                        <i class="fas fa-level-up-alt"></i>
                        <p>Upgrade</p>
                    </a>
                </li>


                <hr class="nav-divider">

                <!-- User Info & Logout -->
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link user-info">
                        <div class="d-flex align-items-center">
                            <div class="user-icon mr-2">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="user-details">
                                <span class="user-name">{{ Auth::user()->name }}</span>

                            </div>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
