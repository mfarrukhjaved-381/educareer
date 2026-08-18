<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

@include('admin.partial.head')

  <body>

@include('admin.partial.sidebar')



<main class="dashboard-main">

    @include('admin.partial.navbar')


    @yield('content')


@include('admin.partial.footer')
</main>



 @include('admin.partial.js')
</body>
</html>