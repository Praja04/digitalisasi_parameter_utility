<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Relationship Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

    <!-- Layout config Js -->
    <script src="{{ asset('material/assets/js/layout.js') }}"></script>

    <!-- jQuery should be included before DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables script -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->

    <link rel="shortcut icon" href="{{ asset('material/assets/images/favicon.ico') }}" />
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

    <!-- JavaScript libraries -->
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('material/assets/js/pages/dashboard-crm.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('material/assets/js/app.js') }}"></script>
    <script src="{{ asset('material/assets/js/highcharts.js') }}"></script>

    <!-- Script for handling logout and DataTable -->
    <script>
        $(document).ready(function() {
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

            $("#topnav-hamburger-icon").click(function() {
                $("#sidebar").toggleClass("active");
            });

            // Klik di luar sidebar untuk menutupnya
            $(document).click(function(event) {
                if (!$(event.target).closest("#sidebar, #topnav-hamburger-icon").length) {
                    $("#sidebar").removeClass("active");
                }
            });
        });
    </script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
</body>

</html>