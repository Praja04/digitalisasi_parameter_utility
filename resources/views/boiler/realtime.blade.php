<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boiler</title>
    <link rel="stylesheet" href="../src/boiler/css/homepage.css">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assetswebbased/css/boiler/tes.css') }}">
    <script src="{{ asset('assetswebbased/js/boiler/date.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/level_feed_water.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/lh.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/rh.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/lhguil.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/rhguil.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/lhstoker.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/rhstoker.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/lhfd.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/rhfd.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/pvsteam.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/pvsteam1.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/idfan.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/pump1.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/pump2.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/batubara_fk.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/bbsteam.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/steam_fk.js') }}"></script>

    <script src="{{ asset('assetswebbased/js/boiler/O2.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/boiler/CO2.js') }}"></script>
    <script>
        var BASE_URL = "{{ url('sensor') }}";
    </script>
</head>
<!-- Sweet Alert css-->
<link href="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

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
                <li><a href="{{ url('boiler/datatren') }}"><i class="fas fa-tv"></i>Back to Data Trend</a></li>
                <li><a id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Boiler</h2>
        </div>
        <div class="data">
            <div class="data">
                <div class="info">
                    <img src="{{ asset('assetswebbased/img/boiler/tampilan.png') }}" alt="Boiler Display">
                </div>
                <div class="date">
                    <span id="day"></span> <span id="month"></span> <span id="year"></span> |
                    <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
                </div>
                <p id="pvsteam" class="pvs"></p>
                <p id="pvsteam1" class="pvs1"></p>
                <p id="lhguil" class="lhg"></p>
                <p id="lhstoker" class="lhs"></p>
                <p id="temp1" class="lh"></p>
                <p id="lhfd" class="lhf"></p>
                <p id="value" class="water"></p>
                <p id="rhguil" class="rhg"></p>
                <p id="temp2" class="rh"></p>
                <p id="rhstoker" class="rhs"></p>
                <p id="rhfd" class="rhf"></p>
                <p id="idfan" class="idf"></p>
                <p id="pump1" class="pump1"></p>
                <p id="pump2" class="pump2"></p>
                <p id="batubara_fk" class="batubara_fk"></p>
                <p id="steam_fk" class="steam_fk"></p>
                <p id="batubara" class="batubara"></p>
                <p id="steam" class="steam"></p>
                <p id="bbsteam" class="bbsteam"></p>
                <p id="o2" class="o2"></p>
                <p id="co2" class="co2"></p>
            </div>
            <button id="openModal" class="input">Insert</button>
            <!-- Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data</h2>
                    <form id="dataForm" method="post">
                        <input type="hidden" name="token" value="">

                        <label for="batubara">Masukkan Batubara (FK):</label>
                        <input type="number" id="batubara" name="batubara" value="" step="any" required>

                        <label for="steam">Masukkan Steam (FK):</label>
                        <input type="number" id="steam" name="steam" value="" step="any" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <!-- Sweet alert init js-->
        <script src="{{ asset('material/assets/js/pages/sweetalerts.init.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.body.style.zoom = "90%";
            });
            // Ambil tahun saat ini
            document.getElementById("date").textContent = new Date().getFullYear();

            // Ambil elemen modal dan tombol
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("openModal");
            var span = document.getElementsByClassName("close")[0];

            // Ketika tombol diklik, buka modal
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // Ketika tombol close diklik, tutup modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Ketika user mengklik di luar modal, tutup modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Submit form via AJAX
            document.getElementById('dataForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman form secara langsung

                var formData = new FormData(this); // Ambil data dari form

                // Ganti koma dengan titik pada input batubara dan steam
                var batubaraInput = formData.get('batubara').replace(',', '.');
                var steamInput = formData.get('steam').replace(',', '.');

                formData.set('batubara', batubaraInput); // Set nilai baru
                formData.set('steam', steamInput); // Set nilai baru

                var xhr = new XMLHttpRequest(); // Membuat instance XMLHttpRequest
                xhr.open('POST', '../../function/boiler/insert_data.php', true); // Menyiapkan request

                // Menangani respon dari server
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Tambahkan ini untuk melihat respons server

                        try {
                            var response = JSON.parse(xhr.responseText); // Parse response JSON
                            if (response.success) {
                                document.getElementById('batubara').value = response.data.batubara;
                                document.getElementById('steam').value = response.data.steam;
                                modal.style.display = 'none';
                            } else {
                                alert('Error saving data: ' + response.message);
                            }
                        } catch (e) {
                            console.error('Error parsing JSON: ', e);
                            alert('Error: Invalid response from server');
                        }
                    } else {
                        alert('Error saving data: ' + xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    alert('Request failed');
                };

                xhr.send(formData); // Mengirimkan data form
            });

            function convertToFloat(input) {
                // Ganti koma dengan titik
                input.value = input.value.replace(',', '.');
            }

            let alertShownWater = false; // Variabel untuk melacak apakah alert sudah ditampilkan untuk water level
            let alertShownPvsteam = false; // Variabel untuk melacak apakah alert sudah ditampilkan untuk pvsteam

            // Fungsi untuk memeriksa level feed water
            function checkWaterLevel() {
                const waterLevelElement = document.getElementById("value");
                const waterLevel = parseFloat(waterLevelElement.innerText);

                // Format nilai level feed water menjadi 1 digit desimal
                const formattedWaterLevel = waterLevel.toFixed(1);

                if (!isNaN(waterLevel)) {
                    if (waterLevel > 60 && !alertShownWater) {
                        alertShownWater = true;
                        toastr.warning("Level feed water telah melebihi " + formattedWaterLevel + "% !", "Peringatan", {
                            timeOut: 0, // Membuat toastr tetap muncul
                            extendedTimeOut: 0, // Membuat toastr tetap muncul
                            closeButton: true // Menambahkan tombol close pada toastr
                        });
                    } else if (waterLevel <= 60 && alertShownWater) {
                        alertShownWater = false;
                        toastr.clear(); // Menghilangkan toastr ketika kondisi kembali normal
                    }
                }
            }

            // Fungsi untuk memeriksa level pvsteam
            function checkPvsteamLevel() {
                const pvsteamElement = document.getElementById("pvsteam");
                const pvsteamLevel = parseFloat(pvsteamElement.innerText);

                // Format nilai pvsteam menjadi 1 digit desimal
                const formattedPvsteamLevel = pvsteamLevel.toFixed(1);

                if (!isNaN(pvsteamLevel)) {
                    if (pvsteamLevel > 6 && !alertShownPvsteam) {
                        alertShownPvsteam = true;
                        toastr.warning("Level pvsteam telah melebihi " + formattedPvsteamLevel + " bar !", "Peringatan", {
                            timeOut: 0, // Membuat toastr tetap muncul
                            extendedTimeOut: 0, // Membuat toastr tetap muncul
                            closeButton: true // Menambahkan tombol close pada toastr
                        });
                    } else if (pvsteamLevel <= 6 && alertShownPvsteam) {
                        alertShownPvsteam = false;
                        toastr.clear(); // Menghilangkan toastr ketika kondisi kembali normal
                    }
                }
            }

            // Fungsi untuk terus memantau nilai setiap beberapa detik
            function monitorWaterLevel() {
                setInterval(checkWaterLevel, 1000); // Cek setiap 1 detik
            }

            function monitorPvsteamLevel() {
                setInterval(checkPvsteamLevel, 1000); // Cek setiap 1 detik
            }

            // Jalankan pemantauan saat halaman selesai dimuat
            document.addEventListener("DOMContentLoaded", function() {
                monitorWaterLevel();
                monitorPvsteamLevel();
            });

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