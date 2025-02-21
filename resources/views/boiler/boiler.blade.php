<!-- resources/views/dashboard/index.blade.php -->
@extends('layout')
@section('style')
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
    var BASE_URL= "{{ url('sensor') }}";
</script>
@endsection
@section('content')
<div class="container">
    
    <div class="data">
        <div class="data">
            <div class="info">
                <img src="{{ asset('assetswebbased/img/boiler/tampilan.png') }}" alt="">
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
       
    </div>
    @endsection