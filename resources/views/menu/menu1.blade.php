<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT BAS')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/utility/homepage.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/icon-utility/wings.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .right {
            text-align: right;
            margin-right: 20px;
        }

        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logout-btn a {
            color: white;
            text-decoration: none;
        }

        .logout-btn a:hover {
            text-decoration: underline;
        }

        .logout-btn:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="logo" class="logo">
            <h2>PT BUMI ALAM SEGAR</h2>
            <div class="right">
                <button class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <a href="{{ url('/logout') }}">Logout</a>
                </button>
            </div>
        </div>
    </div>

    <div class="card-container">
        @php
            $menus = [
                ['url' => 'boiler', 'image' => 'boiler/background.png', 'name' => 'Boiler'],
                ['url' => 'pasteurisasi', 'image' => 'pasteurisasi/pasteur.png', 'name' => 'Pasteurisasi Line 1'],
                ['url' => 'dissolver', 'image' => 'dissolver/dissolver.jpg', 'name' => 'Dissolver'],
                ['url' => 'olahsari', 'image' => 'olahsari/olahsari.png', 'name' => 'Olahsari'],
                ['url' => 'glucose', 'image' => 'glucose/glucose.png', 'name' => 'Glucose'],
                ['url' => 'daily_tank', 'image' => 'daily_tank/daily_tank.jpg', 'name' => 'Daily Tank'],
                ['url' => 'pasteurisasi_line_2', 'image' => 'pasteurisasi_line_2/pasteur_line2.jpeg', 'name' => 'Pasteurisasi Line 2'],
                ['url' => 'stk400', 'image' => 'stk400/stk400.jpg', 'name' => 'STK400'],
                ['url' => 'st53/tankA', 'image' => 'st53/st53.jpg', 'name' => 'ST53'],
            ];
        @endphp

        @foreach ($menus as $menu)
            <a href="{{ url($menu['url']) }}" class="card">
                <img src="{{ asset('assets/images/icon-utility/' . $menu['image']) }}" alt="{{ $menu['name'] }}">
                <p>{{ $menu['name'] }}</p>
            </a>
        @endforeach
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
