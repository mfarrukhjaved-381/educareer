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

    <div class="bradcam_area breadcam_bg overlay2">
        <h3>About Us</h3>
    </div>

    <!-- slider_area_end -->

 {{-- About area  --}}

    <div class="about_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="single_about_info">
                        <h3>Over 7000 Tutorials <br>
                            from 20 Courses</h3>
                        <p>Our set he for firmament morning sixth subdue darkness creeping gathered divide our let god
                            moving. Moving in fourth air night bring upon you’re it beast let you dominion likeness open
                            place day great wherein heaven sixth lesser subdue fowl </p>
                        <a href="#" class="boxed_btn">Enroll a Course</a>
                    </div>
                </div>
                <div class="col-xl-6 offset-xl-1 col-lg-6">
                    <div class="about_tutorials">
                        <div class="courses">
                            <div class="inner_courses">
                                <div class="text_info">
                                    <span>20+</span>
                                    <p> Courses</p>
                                </div>
                            </div>
                        </div>
                        <div class="courses-blue">
                            <div class="inner_courses">
                                <div class="text_info">
                                    <span>7638</span>
                                    <p> Courses</p>
                                </div>

                            </div>
                        </div>
                        <div class="courses-sky">
                            <div class="inner_courses">
                                <div class="text_info">
                                    <span>230+</span>
                                    <p> Courses</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 {{-- About area End --}}




    <!-- subscribe_newsletter_Start -->

    @include('home.newsletter')

    <!-- subscribe_newsletter_end -->

    <!-- our_latest_blog_start -->

      @include('home.our-latest-blog')

    <!-- our_latest_blog_end -->


    <!-- footer -->

@include('home.footer')


    <!-- footer -->


@include('home.form-itself')


    <!-- JS here -->
    @include('home.js')
</body>

</html>
