<!-- resources/views/dashboard/index.blade.php -->
@extends('layout')

@section('style')
<link href="{{ asset('assetswebbased/css/boiler/homepage.css') }}" rel="stylesheet" type="text/css" />
@endsection
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



@section('content')
<div class="card-container" style="margin-top: 100px;">
    @php
    $menus = [
    ['url' => 'boiler/datatren', 'image' => 'boiler/background.png', 'name' => 'Boiler'],
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

<!-- Include Chart.js library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
@endsection