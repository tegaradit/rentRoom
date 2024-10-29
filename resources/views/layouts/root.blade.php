<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rental Rooms</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets/themes/nice/assets/img/favicon.png" rel="icon">
    <link href="/assets/themes/nice/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/themes/nice/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/themes/nice/vendor/simple-datatables/style.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="/assets/themes/nice/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: Mar 09 2023 with Bootstrap v5.2.3
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- ======= Header ======= -->
    {{-- <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="/assets/themes/nice/assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">SIM GTK SMENZA</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        @if (isset(Auth::user()->profile_photo))
                            <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="Profile"
                                style="object-fit: cover;" class="rounded-circle">
                        @else
                            <div
                                style="border-radius: 50%; width: 2.5rem; height: 2.5rem; background-color: gray; text-align: center; line-height: 2.5rem; color: white">
                                {{ substr(Auth::user()->name, 0, 2) }}</div>
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>{{ Auth::user()->role_id == 1 ? 'Admin' : 'Users' }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('my-profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a id="logout-btn" class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header --> --}}
    @yield('root-content')
    <!-- End #main -->
    <!-- Vendor JS Files -->
    <script src="/assets/themes/nice/vendor/apexcharts/apexcharts.min.js"></script>
    {{-- <script src="/assets/themes/nice/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <script src="/assets/themes/nice/vendor/chart.js/chart.umd.js"></script>
    <script src="/assets/themes/nice/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/themes/nice/vendor/quill/quill.min.js"></script>
    <script src="/assets/themes/nice/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/themes/nice/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/themes/nice/vendor/php-email-form/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Template Main JS File -->
    <script src="/assets/themes/nice/js/main.js"></script>

    @yield('javascript')
    <!-- Feather Icons script -->

    <script>
        feather.replace(); // Inisialisasi Feather Icons setelah DOM selesai dimuat
    </script>
</body>

</html>
