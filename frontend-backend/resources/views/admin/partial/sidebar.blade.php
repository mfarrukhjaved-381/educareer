<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <h6>EduCareer Admin</h6>
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('admin.users') }}">
                    <iconify-icon icon="mdi:account-group-outline" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
            </li>

            <!-- Courses -->
            <li>
                <a href="{{ route('admin.courses') }}">
                    <iconify-icon icon="mdi:book-outline" class="menu-icon"></iconify-icon>
                    <span>Courses</span>
                </a>
            </li>

            <!-- Career Paths -->
            <li>
                <a href="{{ route('admin.careerPaths') }}">
                    <iconify-icon icon="mdi:map-marker-path" class="menu-icon"></iconify-icon>
                    <span>Career Paths</span>
                </a>
            </li>

            <!-- User Progress -->
            <li>
                <a href="{{ route('admin.userProgress') }}">
                    <iconify-icon icon="mdi:chart-line" class="menu-icon"></iconify-icon>
                    <span>User Progress</span>
                </a>
            </li>

            <!-- Settings -->
            <li>
                <a href="{{ route('admin.settings') }}">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('admin.profile') }}">
                    <iconify-icon icon="solar:user-linear" class="menu-icon"></iconify-icon>
                    <span>Profile</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <iconify-icon icon="lucide:power" class="menu-icon"></iconify-icon>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</aside>
