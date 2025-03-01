<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasteurisasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/css/pasteurisasi/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/img/wings.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assetswebbased/js/pasteurisasi/dataMixing.js') }}"></script>
    <script src="{{ asset('assetswebbased/js/pasteurisasi/date.js') }}"></script>
    <script>
        var BASE_URL = "{{ url('pasteurisasi1') }}";
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
                <li><a href="{{ url('pasteurisasi1/datatren') }}"><i class="fas fa-tv"></i>Back to Data Trend</a></li>
                <li><a href="{{ url('pasteurisasi1/realtime-pasteurizer') }}"><i class="fas fa-tv"></i>Pasteurizer</a></li>
                <li><a href="{{ url('pasteurisasi1/realtime-mixing') }}"><i class="fas fa-tv"></i>Mixing</a></li>
                <li><a href="{{ url('pasteurisasi1/realtime-vacuum') }}"><i class="fas fa-tv"></i>Vacum</a></li>
                <li><a id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">
        <div class="header">
            <h2>Mixing</h2>

        </div>
        <div class="data">
            <div class="info">
                <img src="{{ asset('assetswebbased/img/pasteurisasi/mixing.png') }}" alt="logo">
            </div>
            <div class="date">
                <span id="weekday"></span>,
                <span id="month"></span> <span id="day"></span>, <span id="year"></span>
                <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span>
            </div>
            <p id="pressuremixing" class="pressuremixing"></p>
            <p id="pumpmixing" class="pumpmixing"></p>
            <p id="mode" class="mode"></p>
        </div>
    </div>
    <!-- Tombol untuk membuka modal -->
    <button id="openModal" class="input">Insert</button>

    <!-- Tabel Output Data -->
    <table id="dataTable">
        <thead>
            <tr>
                <th>Mode</th>
                <th>Varian</th>
                <th>Batch</th>
                <th>Storage</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisi oleh JavaScript -->
        </tbody>
    </table>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Data</h2>
            <form id="dataForm" method="post">


                <label for="mode">Mode :</label>
                <select id="mode" name="mode" required>
                    <option value="REPRO">REPRO</option>
                    <option value="PRODUK">PRODUK</option>
                    <option value="CIP">CIP</option>
                    <option value="SIP">SIP</option>
                    <option value="FLUSHING">FLUSHING</option>
                    <option value="STK">STK</option>
                    <option value="SWITCH STK">SWITCH STK</option>
                </select>

                <label for="varian">Varian :</label>
                <select id="varian" name="varian" required>
                    <option value="BB">BB</option>
                    <option value="JB">JB</option>
                    <option value="SS1">SS1</option>
                    <option value="SS2">SS2</option>
                    <option value="MSD">MSD</option>
                    <option value="NR2">NR2</option>
                </select>

                <label for="batch">Batch:</label>
                <input type="text" id="batch" name="batch" required>

                <label for="storage">Storage :</label>
                <select id="storage" name="storage" required>
                    <optgroup label="A">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                    </optgroup>

                    <optgroup label="B">
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="B4">B4</option>
                        <option value="B5">B5</option>
                    </optgroup>

                    <optgroup label="C">
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                        <option value="C4">C4</option>
                        <option value="C5">C5</option>
                    </optgroup>

                    <optgroup label="D">
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </optgroup>
                </select>

                <button type="submit" class="submit">Simpan</button>
            </form>
        </div>
    </div>
    <script>
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
            e.preventDefault(); // Mencegah pengiriman form

            console.log('Form submission intercepted'); // Debugging log

            var formData = new FormData(this); // Ambil data dari form

            var xhr = new XMLHttpRequest(); // Membuat instance XMLHttpRequest
            xhr.open('POST', '../../function/pasteurisasi/insert_data.php', true); // Menyiapkan request

            // Menangani respon dari server
            xhr.onload = function() {
                console.log('XHR onload called'); // Debugging log
                if (xhr.status === 200) {
                    console.log('Response:', xhr.responseText); // Debugging log
                    if (xhr.responseText.includes('Data processed successfully')) {
                        loadLatestData(); // Memuat data terbaru
                        modal.style.display = 'none'; // Menutup modal
                        document.getElementById('dataForm').reset(); // Reset form fields
                    } else {
                        alert('Error saving data: ' + xhr.responseText);
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

        // Function to load the latest data from the database using AJAX
        function loadLatestData() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ url('pasteurisasi1/data-realtime') }}", true); // Assume fetch_data.php returns the latest data
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Pastikan data tersedia sebelum ditampilkan
                    if (response) {
                        var table = document.getElementById('dataTable');
                        table.innerHTML = `
                    <tr>
                        <th>Mode</th>
                        <th>Varian</th>
                        <th>Batch</th>
                        <th>Storage</th>
                    </tr>
                    <tr>
                        <td>${response.Mode}</td>
                        <td>${response.Varian}</td>
                        <td>${response.Batch}</td>
                        <td>${response.Storage}</td>
                    </tr>
                `;
                    } else {
                        console.error('No data found');
                    }
                } else {
                    console.error('Failed to load data: ' + xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        }


        // Call loadLatestData on page load to display the initial data
        window.onload = function() {
            loadLatestData();
            setInterval(loadLatestData, 5000); // Memuat data setiap 5 detik
        };


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