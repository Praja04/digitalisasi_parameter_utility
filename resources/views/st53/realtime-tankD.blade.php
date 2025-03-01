<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST53</title>
    <!-- <link rel="stylesheet" href="../../src/css/homepage.css"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/css/st53/TankD.css') }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/img/wings.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/b99e6756e.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assetswebbased/js/st53/dataD.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/st53/date.js') }}"></script>

    <script>
        var BASE_URL = "{{ url('st53') }}";
    </script>
    <link href="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('material/assets/js/pages/sweetalerts.init.js') }}"></script>
</head>

<style>
    @media (max-width: 750px) {
        .slide img {
            width: 80%;
            margin-left: 5px;
            border-radius: 100%;
        }

        ul li {
            list-style: none;
            border-radius: 100px;
            padding: 10px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20%;
        }

        ul li a {
            font-size: 0;
            display: flex;
            justify-content: center;
            /* Mengatur posisi horizontal ke tengah */
            align-items: center;
            /* Mengatur posisi vertikal ke tengah */
            height: 100%;
            /* Pastikan elemen <a> menyesuaikan tinggi container */
        }

        ul li a i {
            font-size: 20px;
            /* Menjaga ukuran ikon */
        }

    }

    @media (min-width: 751px) and (max-width: 1130px) {
        .slide img {
            width: 80%;
            margin-left: 15px;
            border-radius: 100%;
        }

        ul li {
            list-style: none;
            border-radius: 100px;
            padding: 10px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20%;
        }

        ul li a {
            font-size: 10px;
            display: flex;
            justify-content: center;
            /* Mengatur posisi horizontal ke tengah */
            align-items: center;
            /* Mengatur posisi vertikal ke tengah */
            height: 100%;
            /* Pastikan elemen <a> menyesuaikan tinggi container */
        }

        ul li a i {
            font-size: 18px;
            /* Menjaga ukuran ikon */
        }

    }
</style>

<body>
    <label>
        <div class="slide">
            <img src="{{ asset('assetswebbased/img/kecap.png') }}" alt="logo">
            <p>PT Bumi Alam Segar</p>
            <ul>
                <li><a href="{{ url('st53/datatren') }}"><i class="fas fa-tv"></i>Back to Data Trend</a></li>
                <li><a href="{{ url('st53/realtime-tankA') }}"><i class="fas fa-tv"></i>Tank A</a></li>
                <li><a href="{{ url('st53/realtime-tankB') }}"><i class="fas fa-tv"></i>Tank B</a></li>
                <li><a href="{{ url('st53/realtime-tankC') }}"><i class="fas fa-tv"></i>Tank C</a></li>
                <li><a href="{{ url('st53/realtime-tankD') }}"><i class="fas fa-tv"></i>Tank D</a></li>
                <li><a id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>ST53</h2>

        </div>
        <div class="data">
            <div class="info">
                <img src="{{ asset('assetswebbased/img/st53/tampilanD.png') }}" alt="logo">
            </div>
            <div class="date">
                <span id="weekday"></span>,
                <span id="month"></span> <span id="day"></span>, <span id="year"></span>
                <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
            </div>

            <p id="D1" class="D1"></p>
            <p id="D2" class="D2"></p>
            <p id="D3" class="D3"></p>
            <p id="D4" class="D4"></p>
            <p id="D5" class="D5"></p>

        </div>

        <script>
            // Ambil tahun saat ini
            document.getElementById("date").textContent = new Date().getFullYear();
            $('#logoutButton').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will be logged out from your session!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout!',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan SweetAlert loading
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Please wait while we process your request.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading(); // Menampilkan animasi loading
                            }
                        });

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
                                // Tutup loading dan tampilkan pesan sukses
                                Swal.fire({
                                    title: 'Logged Out!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "{{ url('/') }}"; // Redirect ke halaman utama atau login
                                });
                            },
                            error: function(xhr) {
                                // Tutup loading dan tampilkan pesan error
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was an issue logging out.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        </script>
</body>

</html>