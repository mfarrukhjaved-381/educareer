<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid p-0">
                <div class="row align-items-center no-gutters">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo-img">
                            <a href="{{url('/')}}">
                                <h2>EduCareer</h2>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="main-menu  d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                                    <li><a class="{{ request()->is('courses') ? 'active' : '' }}" href="{{ url('/courses') }}">Courses</a></li>
                                    <li><a class="{{ request()->is('coursers-details', 'element') ? 'active' : '' }}" href="#">pages <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="{{ url('/coursers-details') }}">Course Details</a></li>
                                            <li><a href="{{ url('/element') }}">Elements</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ request()->is('about-area') ? 'active' : '' }}" href="{{ url('/about-area') }}">About</a></li>
                                    <li><a class="{{ request()->is('blog', 'single-blog') ? 'active' : '' }}" href="#">Blog <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="/blog">Blog</a></li>
                                            <li><a href="/single-blog">Single Blog</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ request()->is('contact_page') ? 'active' : '' }}" href="{{ url('/contact_page') }}">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                        <div class="log_chat_area d-flex align-items-center">
                            <a href="#test-form" class="login popup-with-form">
                                <i class="flaticon-user"></i>
                                <span>log in</span>
                            </a>
                          
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('#navigation a');
        const currentUrl = window.location.href;

        navLinks.forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add('active');
            }
        });
    });
</script>
