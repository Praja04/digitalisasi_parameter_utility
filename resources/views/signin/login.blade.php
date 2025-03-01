<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In | BAS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('material/assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <link href="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('material/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('material/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alerts js -->
    <script src="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('material/assets/js/pages/sweetalerts.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">

                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="loginForm">

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" required placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>



                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>


                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->

    <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('material/assets/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ asset('material/assets/js/pages/particles.app.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('material/assets/js/pages/password-addon.init.js') }}"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('login') }}",
                    method: "POST",
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // alert(response.message);
                            window.location.href = "{{ url('menu') }}"; // Redirect ke halaman layout
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            var response = JSON.parse(xhr.responseText);
                            alert(response.message);
                        } else {
                            alert('Terjadi kesalahan pada server.');
                        }
                    }
                });
            });
        });
    </script> -->

    <script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Menampilkan animasi loading
                }
            });

            $.ajax({
                url: "{{ route('login') }}",
                method: "POST",
                data: {
                    username: $('#username').val(),
                    password: $('#password').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close(); // Tutup loading

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ url('menu') }}"; // Redirect ke halaman setelah login
                        });
                    } else if (response.message === 'Anda sudah login.') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Anda sudah login!',
                            text: 'Mengalihkan ke halaman utama...',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ url('menu') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close(); // Tutup loading saat error

                    if (xhr.status === 401) {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized!',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                }
            });
        });

        // Cek jika user sudah login saat halaman dimuat
        $.ajax({
            url: "{{ route('login') }}",
            method: "GET",
            success: function(response) {
                if (response.success === false && response.message === 'Anda sudah login.') {
                    window.location.href = "{{ url('menu') }}";
                }
            }
        });
    });
</script>

</body>

</html>