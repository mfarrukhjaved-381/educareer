<!doctype html>
<html class="no-js" lang="zxx">

<head>
    @include('home.css')
</head>



<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->


    @include('home.header')

    <!-- header-end -->

    <!-- slider_area_start -->

      @include('home.slider')

    <!-- slider_area_end -->



    <!-- popular_courses_start -->

    @include('home.popular-courses')

       <!-- popular_courses_end-->

    {{-- Testimnial start   --}}

    {{-- @include('home.testimonial') --}}


    {{-- Testimnial start end  --}}

    <!-- our_courses_start -->

    {{-- @include('home.courses') --}}

    {{-- <!-- our_courses_end --> --}}


    <!-- subscribe_newsletter_Start -->

    @include('home.newsletter')

    <!-- subscribe_newsletter_end -->



    <!-- footer -->
@include('home.footer')
    <!-- footer -->


@include('home.form-itself')


    <!-- JS here -->
    @include('home.js')
</body>

</html>
