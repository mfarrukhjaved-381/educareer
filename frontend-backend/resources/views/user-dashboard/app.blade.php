@include('user-dashboard.css')
</head>

<body data-theme="{{ auth()->user()->theme ?? 'light' }}">

    <div class="wrapper">
        @include('user-dashboard.sidebar')
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">

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
                </div>
                @include('user-dashboard.navbar')
            </div>

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>


            <div>
                @include('user-dashboard.footer')
            </div>

            @include('user-dashboard.js')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

            <script>
                $(document).ready(function() {
                toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right", // Adjust position as needed
                "preventDuplicates": false,
                "timeOut": "4000", // Duration in milliseconds
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };

                document.addEventListener('DOMContentLoaded', function () {
                    let theme = '{{ auth()->user()->theme }}';
                    if (theme === 'dark') {
                    document.body.classList.add('dark-theme');
                    } else {
                    document.body.classList.remove('dark-theme');
                    }
                    });

                @if (session('success'))
                    toastr.success('{{ session('success') }}');
                @endif

                @if (session('error'))
                    toastr.error('{{ session('error') }}');
                @endif
                });

                


                </script>
</body>

</html>
