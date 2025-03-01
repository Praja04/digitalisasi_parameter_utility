<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dissolver</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/css/dissolver/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assetswebbased/img/wings.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var BASE_URL = "{{ url('daily-tank') }}";
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
                <li><a href="{{ url('dissolver/datatren') }}"><i class="fas fa-tv"></i>Back to Data Trend</a></li>
                <li><a id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
            <h6>By <span id="date"></span></h6>
        </div>
    </label>
    <div class="container">

        <div class="data">

            <!-- Tanki 1 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 1</h2>
                    <div id="dissolver1-container" class="dissolver-container"></div>
                    <button id="dissolver1">Insert</button>
                </div>
            </div>

            <!-- Tanki 2 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 2</h2>
                    <div id="dissolver2-container" class="dissolver-container"></div>
                    <button id="dissolver2">Insert</button>
                </div>
            </div>

            <!-- Tanki 3 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 3</h2>
                    <div id="dissolver3-container" class="dissolver-container"></div>
                    <button id="dissolver3">Insert</button>
                </div>
            </div>

            <!-- Tanki 4 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 4</h2>
                    <div id="dissolver4-container" class="dissolver-container"></div>
                    <button id="dissolver4">Insert</button>
                </div>
            </div>

            <!-- Tanki 5 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 5</h2>
                    <div id="dissolver5-container" class="dissolver-container"></div>
                    <button id="dissolver5">Insert</button>
                </div>
            </div>

            <!-- Tanki 6 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 6</h2>
                    <div id="dissolver6-container" class="dissolver-container"></div>
                    <button id="dissolver6">Insert</button>
                </div>
            </div>

            <!-- Tanki 7 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 7</h2>
                    <div id="dissolver7-container" class="dissolver-container"></div>
                    <button id="dissolver7">Insert</button>
                </div>
            </div>

            <!-- Tanki 8 -->
            <div class="blending-container">
                <div class="ujung-lancip"></div>
                <div class="isi-bahan-baku">
                    <h2>Dissolver 8</h2>
                    <div id="dissolver8-container" class="dissolver-container"></div>
                    <button id="dissolver8">Insert</button>
                </div>
            </div>


            <!-- Inputan Dissolver 1 -->
            <div id="myModal1" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 1</h2>
                    <form action="../../function/dissolver/input/tambah1.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 2 -->
            <div id="myModal2" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 2</h2>
                    <form action="../../function/dissolver/input/tambah2.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 3 -->
            <div id="myModal3" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 3</h2>
                    <form action="../../function/dissolver/input/tambah3.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 4 -->
            <div id="myModal4" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 4</h2>
                    <form action="../../function/dissolver/input/tambah4.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 5 -->
            <div id="myModal5" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 5</h2>
                    <form action="../../function/dissolver/input/tambah5.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 6 -->
            <div id="myModal6" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 6</h2>
                    <form action="../../function/dissolver/input/tambah6.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 7 -->
            <div id="myModal7" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 7</h2>
                    <form action="../../function/dissolver/input/tambah7.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>

            <!-- Inputan Dissolver 8 -->
            <div id="myModal8" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Tambah Data Dissolver 8</h2>
                    <form action="../../function/dissolver/input/tambah8.php" method="post">

                        <label for="Batch">Batch:</label>
                        <input type="text" id="Batch" name="Batch" required>

                        <label for="Varian">Varian:</label>
                        <select id="Varian" name="Varian" required>
                            <option value="BB">BB</option>
                            <option value="JB">JB</option>
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="MSD">MSD</option>
                            <option value="NR2">NR2</option>
                        </select>

                        <label for="masak">PO Masak:</label>
                        <input type="number" id="masak" name="masak" step="0.1" required>

                        <label for="formulasi">No Formulasi:</label>
                        <input type="number" id="formulasi" name="formulasi" step="0.1" required>

                        <label for="GGA">Status GGA:</label>
                        <select id="GGA" name="GGA" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Start Adjust 1">Start Adjust 1</option>
                            <option value="Finish Adjust 1">Finish Adjust 1</option>
                            <option value="Start Adjust 2">Start Adjust 2</option>
                            <option value="Finish Adjust 2">Finish Adjust 2</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="Gula">Gula:</label>
                        <input type="number" id="Gula" name="Gula" step="0.1" required>

                        <label for="NaCl_GGA">Nacl:</label>
                        <input type="number" id="NaCl_GGA" name="NaCl_GGA" step="0.1" required>

                        <label for="Brix_GGA">Brix:</label>
                        <input type="number" id="Brix_GGA" name="Brix_GGA" step="0.1" required>

                        <label for="Warna_GGA">Warna:</label>
                        <input type="number" id="Warna_GGA" name="Warna_GGA" step="0.1" required>

                        <label for="Organo_GGA">Organo:</label>
                        <input type="number" id="Organo_GGA" name="Organo_GGA" step="0.1" required>

                        <label for="GGAS">Status GGAS:</label>
                        <select id="GGAS" name="GGAS" required>
                            <option value="0">0</option>
                            <option value="Start">Start</option>
                            <option value="Finish">Finish</option>
                            <option value="Drain">Drain</option>
                        </select>

                        <label for="NaCl_GGAS">Nacl:</label>
                        <input type="number" id="NaCl_GGAS" name="NaCl_GGAS" step="0.1" required>

                        <label for="Brix_GGAS">Brix:</label>
                        <input type="number" id="Brix_GGAS" name="Brix_GGAS" step="0.1" required>

                        <label for="Warna_GGAS">Warna:</label>
                        <input type="number" id="Warna_GGAS" name="Warna_GGAS" step="0.1" required>

                        <label for="Organo_GGAS">Organo:</label>
                        <input type="number" id="Organo_GGAS" name="Organo_GGAS" step="0.1" required>

                        <button type="submit" class="submit">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        // Ambil tahun saat ini
        document.getElementById("date").textContent = new Date().getFullYear();

        var btn1 = document.getElementById("dissolver1");
        var btn2 = document.getElementById("dissolver2");
        var btn3 = document.getElementById("dissolver3");
        var btn4 = document.getElementById("dissolver4");
        var btn5 = document.getElementById("dissolver5");
        var btn6 = document.getElementById("dissolver6");
        var btn7 = document.getElementById("dissolver7");
        var btn8 = document.getElementById("dissolver8");
        var modal1 = document.getElementById("myModal1");
        var modal2 = document.getElementById("myModal2");
        var modal3 = document.getElementById("myModal3");
        var modal4 = document.getElementById("myModal4");
        var modal5 = document.getElementById("myModal5");
        var modal6 = document.getElementById("myModal6");
        var modal7 = document.getElementById("myModal7");
        var modal8 = document.getElementById("myModal8");
        var spans = document.getElementsByClassName("close");

        // Fungsi untuk membuka modal
        function openModal(modal) {
            modal.style.display = "block";
        }

        // Ketika tombol diklik, buka modal
        btn1.onclick = function() {
            openModal(modal1);
        };
        btn2.onclick = function() {
            openModal(modal2);
        };
        btn3.onclick = function() {
            openModal(modal3);
        };
        btn4.onclick = function() {
            openModal(modal4);
        };
        btn5.onclick = function() {
            openModal(modal5);
        };
        btn6.onclick = function() {
            openModal(modal6);
        };
        btn7.onclick = function() {
            openModal(modal7);
        };
        btn8.onclick = function() {
            openModal(modal8);
        };

        // Ketika tombol close diklik, tutup modal
        for (var i = 0; i < spans.length; i++) {
            spans[i].onclick = function() {
                modal1.style.display = "none";
                modal2.style.display = "none";
                modal3.style.display = "none";
                modal4.style.display = "none";
                modal5.style.display = "none";
                modal6.style.display = "none";
                modal7.style.display = "none";
                modal8.style.display = "none";
            };
        }

        // Ketika user mengklik di luar modal, tutup modal
        window.onclick = function(event) {
            if (event.target === modal1) {
                modal1.style.display = "none";
            } else if (event.target === modal2) {
                modal2.style.display = "none";
            } else if (event.target === modal3) {
                modal3.style.display = "none";
            } else if (event.target === modal4) {
                modal4.style.display = "none";
            } else if (event.target === modal5) {
                modal5.style.display = "none";
            } else if (event.target === modal6) {
                modal6.style.display = "none";
            } else if (event.target === modal7) {
                modal7.style.display = "none";
            } else if (event.target === modal8) {
                modal8.style.display = "none";
            }
        };



        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/dissolver/data-realtime') }}", // Ganti dengan URL API JSON kamu
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        // Loop semua dissolver
                        $.each(response.data, function(key, value) {
                            // Pastikan ada elemen untuk setiap dissolver
                            let container = $(`#${key}-container`);

                            if (container.length > 0) {
                                let output = `
                            <ul>
                                <li><b>Batch</b>: ${value.Batch ?? '-'}</li>
                                <li><b>Varian</b>: ${value.Varian ?? '-'}</li>
                                <li><b>PO Masak</b>: ${value.PO_Masak ?? '-'}</li>
                                <li><b>No Formulasi</b>: ${value.No_Formulasi ?? '-'}</li>
                                <li><b>Status GGA</b>: ${value.Status_GGA ?? '-'}</li>
                                <li><b>Gula</b>: ${value.Gula ?? '-'}</li>
                                <li><b><u>Hasil Analisa GGA</u></b></li>
                                <li>NaCl: ${value.NaCl_GGA ?? '-'}</li>
                                <li>Brix: ${value.Brix_GGA ?? '-'}</li>
                                <li>Warna: ${value.Warna_GGA ?? '-'}</li>
                                <li>Organo: ${value.Organo_GGA ?? '-'}</li>
                                <li><b>Status GGAS</b>: ${value.Status_GGAS ?? '-'}</li>
                                <li><b><u>Hasil Analisa GGAS</u></b></li>
                                <li>NaCl: ${value.NaCl_GGAS ?? '-'}</li>
                                <li>Brix: ${value.Brix_GGAS ?? '-'}</li>
                                <li>Warna: ${value.Warna_GGAS ?? '-'}</li>
                                <li>Organo: ${value.Organo_GGAS ?? '-'}</li>
                                <li><b>Created At</b>: ${value.created_at ?? '-'}</li>
                            </ul>
                        `;

                                container.html(output);
                            }
                        });
                    } else {
                        $('.dissolver-container').html('<p>Tidak ada data ditemukan.</p>');
                    }
                },
                error: function() {
                    $('.dissolver-container').html('<p>Error saat mengambil data.</p>');
                }
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
        });
    </script>

</body>

</html>