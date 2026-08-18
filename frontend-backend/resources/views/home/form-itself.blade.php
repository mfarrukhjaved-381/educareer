{{-- @include('home.css') --}}

<!-- Login Form -->
<form id="test-form" class="white-popup-block mfp-hide" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="popup_box">
        <div class="popup_inner">
            <div class="logo text-center">
                <a href="#">
                    <h2>EduCareer</h2>
                </a>
            </div>
            <h3>Sign in</h3>
            <div class="row">
                <!-- Email Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Password</label>
                    <input type="password" name="password" required placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Remember Me Checkbox -->
                <div class="col-xl-12">
                    <label for="remember_me" style="color: white;">
                        <input id="remember_me" type="checkbox" name="remember" style="width: 15px; height: 15px;">
                        <span class="ms-2 remember-me-text">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <!-- Submit Button -->
                <div class="col-xl-12">
                    <button type="submit" class="boxed_btn_orange">Sign in</button>
                </div>

                <!-- Divider -->
                <div class="col-xl-12" style="margin: 15px 0; text-align: center; position: relative;">
                    <div style="height: 1px; background-color: #ccc; width: 100%; position: absolute; top: 50%;"></div>
                    <span
                        style="background: #fff; padding: 0 10px; position: relative; z-index: 1; color: #ccc;">or</span>
                </div>

                <!-- Google Login Button -->
                <div class="col-xl-12">
                    <a href="{{ url('auth/google') }}" class="google-login-btn"
                        style="display: flex; align-items: center; justify-content: center; padding: 10px; background: #fff; border-radius: 4px; text-decoration: none; color: #757575; font-weight: 500; border: 1px solid #ddd; transition: all 0.3s ease;">
                        <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google logo"
                            style="width: 20px; height: 20px; margin-right: 10px;">
                        Sign in with Google
                    </a>
                </div>

                <!-- Forgot Password Link -->


                <div class="col-xl-12" style="text-align: center; position: relative;">
                    @if (Route::has('password.request'))
                        <p class="doen_have_acc">

                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>

                        </p>
                    @endif
                </div>
              
                <!-- Sign Up Link -->
                <div class="col-xl-12" style=" text-align: center; position: relative;">
                    <p class="doen_have_acc">Don't have an account? <a class="dont-hav-acc" href="#test-form2"><b>Sign
                                Up</b></a></p>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Registration Form -->
<form id="test-form2" class="white-popup-block mfp-hide" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="popup_box">
        <div class="popup_inner">
            <div class="logo text-center">
                <a href="#">
                    <h2>EduCareer</h2>
                </a>
            </div>
            <h3>Registration</h3>

            <div class="col-xl-12">
                <a href="{{ url('auth/google') }}" class="google-login-btn"
                    style="display: flex; align-items: center; justify-content: center; padding: 10px; background: #fff; border-radius: 4px; text-decoration: none; color: #757575; font-weight: 500; border: 1px solid #ddd; transition: all 0.3s ease;">
                    <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google logo"
                        style="width: 20px; height: 20px; margin-right: 10px;">
                    Sign in with Google
                </a>
            </div>
            <hr>
            <div class="row">
                <!-- Name Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Enter your name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="Enter email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Password</label>
                    <input type="password" name="password" required placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Confirm Password Input -->
                <div class="col-xl-12 col-md-12">
                    <label style="color: white">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm password">
                </div>
                <!-- Submit Button -->
                <div class="col-xl-12">
                    <button type="submit" class="boxed_btn_orange">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Required JavaScript -->
{{-- <script>
$(document).ready(function() {
    // Initialize Magnific Popup
    $('.dont-hav-acc').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
        modal: true
    });

    // Close popup when clicking outside
    $(document).on('click', '.mfp-close, .mfp-overlay', function() {
        $.magnificPopup.close();
    });

    // Form submission handling
    $('form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                if(response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#'+key).after('<span class="text-danger">'+value[0]+'</span>');
                    });
                }
            }
        });
    });

    // Google login button click
    $('.google-login-btn').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});
</script> --}}
