<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitalisasi Paramater BAS</title>

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('material/assets/images/favicon.ico') }}">
    

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/menu-utama.css') }}">
</head>

<body>
    <div class="context">
        <h1>Digitalisasi Parameter Proses Utility</h1><br>
        <div class="container">
            <a href="{{ url('produksi1') }}">
                <div class="card">
                    <div class="slide slide1">
                        <div class="content">
                            <div class="icon">
                                <img style="width: 100px;" class="img-fluid" src="{{ asset('assets/images/menu/manufacture.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="slide slide2">
                        <div class="content">
                            <h3>Produksi 1</h3>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ url('produksi2') }}">
                <div class="card">
                    <div class="slide slide1">
                        <div class="content">
                            <div class="icon">
                                <img style="width: 100px;" class="img-fluid" src="{{ asset('assets/images/menu/product.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="slide slide2">
                        <div class="content">
                            <h3>Produksi 2</h3>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ url('charging') }}">
                <div class="card">
                    <div class="slide slide1">
                        <div class="content">
                            <div class="icon">
                                <img style="width: 100px;" class="img-fluid" src="{{ asset('assets/images/menu/hemodialysis-machine.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="slide slide2">
                        <div class="content">
                            <h3>Charging & Industrial Battery</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="area">
        <ul class="circles">
            @for ($i = 0; $i < 10; $i++)
                <li>
                </li>
                @endfor
        </ul>
    </div>
</body>

</html>