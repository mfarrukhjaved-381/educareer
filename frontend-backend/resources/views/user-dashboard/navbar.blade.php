<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">


        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            
            


            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                    aria-expanded="false">

                    <span class="profile-username">
                        <span class="op-7">Welcome</span>
                        <span class="fw-bold">{{ auth()->user()?->name ?? 'Guest' }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">

                                <div class="u-text text-center">
                                    <h5>{{ auth()->user()?->name ?? 'Guest' }}</h5>

                                    <a href="{{ url('/profile') }}" class="btn btn-secondary">
                                        {{ auth()->user()?->name ?? 'Guest' }}'s Profile</a>
                                </div>
                            </div>
                        </li>
                        <li>




                    
                            <div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn-danger btn-sm">Logout</button>
                                </form>
                            </div>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
