@include('user-dashboard.css')
<!-- Add responsive meta tag for better mobile experience -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    /* Fix header alignment */
    .main-header {
        position: relative;
        width: 100%;
        z-index: 100;
    }

    .card-header {
        position: relative;
        z-index: 1;
    }

    /* Improved card styling */
    .card {
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Upload option styling */
    .option-title {
        display: flex !important;
        align-items: center;
        font-weight: 500;
    }

    .option-icon {
        font-size: 1.5rem;
        margin-right: 12px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .linkedin-icon {
        background-color: #0077b5;
        color: white;
    }

    .resume-icon {
        background-color: #28a745;
        color: white;
    }

    /* Better button styling */
    .btn-light:hover {
        background-color: #f0f0f0;
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    /* Content spacing adjustment */
    .content {
        padding-top: 30px !important;
        padding-bottom: 30px !important;
        min-height: calc(100vh - 150px);
    }

    /* Alert styling */
    .alert {
        border-radius: 6px;
    }

    /* Fix structure to ensure the footer displays properly */
    body {
        min-height: 100vh;
        position: relative;
    }

    .wrapper {
        min-height: calc(100vh - 60px);
        /* Adjust based on your footer height */
    }

    /* Override any footer styles that might be causing issues */
    .footer-wrapper {
        position: relative;
        z-index: 99;
        width: 100%;
    }
</style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="wrapper flex-grow-1">
        @include('user-dashboard.sidebar')

        <div class="main-panel">
            <!-- Fixed header with proper z-index -->
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo"></a>
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

            <div class="content py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="card-title mb-0">Please upload Your CV/Resume to complete your profile
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-4">Select one of the options below to build your profile.</p>

                                    <form action="{{ route('cv.upload') }}" method="POST" enctype="multipart/form-data" id="resume-form">
                                      @csrf

          
                                      <div class="form-group">
                                          <label for="resume-upload" class="option-title d-block mb-2">
                                              <div class="option-icon resume-icon"><i class="fas fa-file-alt"></i>
                                              </div>
                                              <span>Upload your Resume</span>
                                          </label>
                                          <div class="btn-file-upload">
                                              <input type="file" id="resume-upload" name="cv_resume" class="form-control-file"
                                                  accept=".pdf,.doc,.docx,.txt" onchange="showFileName(this, 'resume')">
                                              <button type="button" class="btn btn-primary btn-block text-left">
                                                  <i class="fas fa-file-upload mr-2"></i> Upload Resume
                                              </button>
                                          </div>
                                          <small class="form-text text-muted">Note: Upload resume up to 2 MB.</small>
                                          <div id="file-selected-resume" class="file-selected d-none">
                                              <span id="file-name-resume"></span>
                                              <button type="submit" class="btn btn-success">
                                                  <i class="fas fa-check mr-1"></i> Confirm Upload
                                              </button>
                                          </div>
                                      </div>
          
          
                                      @if ($errors->any())
                                      <div class="alert alert-danger mt-3">
                                          <ul class="mb-0">
                                              @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                              @endforeach
                                          </ul>
                                      </div>
                                      @endif
          
                                      @if (session('success'))
                                      <div class="alert alert-success mt-3">
                                          <div class="d-flex align-items-center">
                                              <i class="fas fa-check-circle mr-2"></i>
                                              <span>{{ session('success') }}</span>
                                          </div>
                                      </div>
                                      @endif
                                  </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="footer-wrapper">

                @include('user-dashboard.footer')

            </div>



            @include('user-dashboard.js')
            <script>
              function showFileName(input, type) {
                  const fileSelected = document.getElementById('file-selected-' + type);
                  const fileName = document.getElementById('file-name-' + type);
          
                  if (input.files && input.files[0]) {
                      fileSelected.classList.remove('d-none');
                      fileName.textContent = input.files[0].name;
                  } else {
                      fileSelected.classList.add('d-none');
                      fileName.textContent = '';
                  }
              }
          </script>

</body>
