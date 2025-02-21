<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard | Velzon - Admin & Dashboard Template')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Premium Multipurpose Admin & Dashboard Template" />
    <meta name="author" content="Themesbrand" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('material/assets/images/favicon.ico') }}" />

    <!-- jsvectormap css -->
    <link rel="stylesheet" href="{{ asset('material/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" />

    <!-- Swiper slider css -->
    <link rel="stylesheet" href="{{ asset('material/assets/libs/swiper/swiper-bundle.min.css') }}" />

    <!-- Layout config Js -->
    <script src="{{ asset('material/assets/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('material/assets/css/bootstrap.min.css') }}" />

    <!-- Icons Css -->
    <link rel="stylesheet" href="{{ asset('material/assets/css/icons.min.css') }}" />

    <!-- App Css -->
    <link rel="stylesheet" href="{{ asset('material/assets/css/app.min.css') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('material/assets/css/custom.min.css') }}" />

    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('material/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        #topnav-hamburger-icon {
            display: none;
        }

        @media (max-width: 992px) {
            #topnav-hamburger-icon {
                display: flex;
            }

            #sidebar {
                position: fixed;
                left: 0;
                top: 0;
                width: 250px;
                height: 100%;
                background: #222;
                z-index: 1000;
                margin-top: 50px;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            #sidebar.active {
                transform: translateX(0);
                margin-top: 50px;
            }

            #page-topbar {
                width: 100%;
                transition: margin-left 0.3s ease-in-out;
                left: 0;
            }

            /* When sidebar is active, shift topbar and content */
            body.sidebar-active #page-topbar {
                margin-left: 0px;
                /* Move the topbar to the right */
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles') {{-- Untuk stylesheet tambahan di halaman lain --}}
</head>

<body>
    <div id="layout-wrapper">
        <!-- Topbar -->
        @include('component.topbar')

        <!-- sidebar -->
        <div id="sidebar">
            @include('component.sidebar')
        </div>
        <!-- end sidebar -->
        <div class="main-content">
            <!-- content -->
            @yield('content')
            <!-- end content -->

            <!-- footer -->
            @include('component.footer')
            <!-- end footer -->
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/plugins.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('material/assets/js/app.js') }}"></script>
    <script src="{{ asset('material/assets/js/highcharts.js') }}"></script>
    <!-- ApexCharts -->
    <script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector Map -->
    <script src="{{ asset('material/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- Swiper slider js -->
    <script src="{{ asset('material/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('material/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#topnav-hamburger-icon").click(function() {
                $("#sidebar").toggleClass("active");
            });

            // Klik di luar sidebar untuk menutupnya
            $(document).click(function(event) {
                if (!$(event.target).closest("#sidebar, #topnav-hamburger-icon").length) {
                    $("#sidebar").removeClass("active");
                }
            });
            // Logout button handler
            $('#logoutButton').click(function() {
                $.ajax({
                    url: "{{ route('logout') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = "{{ url('/') }}"; // Redirect ke halaman utama atau login
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat logout');
                    }
                });
            });
        });
    </script>

    <!-- App js -->
    <script src="{{ asset('material/assets/js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    @stack('scripts') {{-- Untuk script tambahan di halaman lain --}}
</body>

</html>