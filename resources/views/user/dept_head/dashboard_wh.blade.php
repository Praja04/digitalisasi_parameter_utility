@extends('layout')

<!-- Font mewah dan transisi tema -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
    body {
        transition: background-color 0.3s ease;
    }

    .page-content {
        background-color: var(--bs-body-bg);
        transition: background-color 0.3s ease;
    }

    h4,
    h5 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        background-color: var(--bs-card-bg, #ffffff);
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .card {
        background-color: #1f2230;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    [data-bs-theme="dark"] h4,
    [data-bs-theme="dark"] h5 {
        color: #e4e7ec;
    }
</style>

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Forklift Dashboard --}}
        <h4 class="mb-4">Dashboard Pemeriksaan P2H - Forklift</h4>

        <div class="row">
            <div class="col-md-3" id="card-total"></div>
            <div class="col-md-3" id="card-today"></div>
            <div class="col-md-3" id="card-pending"></div>
            <div class="col-md-3" id="card-completed"></div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribusi Kelayakan</h5>
                        <div id="chartKelayakan"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Komponen Masalah Terbanyak</h5>
                        <div id="chartTopMasalah"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Operator Pemeriksa</h5>
                        <div id="chartOperator"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribusi Shift</h5>
                        <div id="chartShift"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pallet Mover Dashboard --}}
        <h4 class="mb-4 mt-5">Dashboard Pemeriksaan P2H – Pallet Mover</h4>

        <div class="row">
            <div class="col-md-3" id="pm-card-total"></div>
            <div class="col-md-3" id="pm-card-today"></div>
            <div class="col-md-3" id="pm-card-pending"></div>
            <div class="col-md-3" id="pm-card-completed"></div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribusi Kelayakan – Pallet Mover</h5>
                        <div id="chartKelayakanPallet"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Komponen Masalah Terbanyak – Pallet Mover</h5>
                        <div id="chartTopMasalahPallet"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Operator Pemeriksa – Pallet Mover</h5>
                        <div id="chartOperatorPallet"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribusi Shift – Pallet Mover</h5>
                        <div id="chartShiftPallet"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        // Load summary
        $.ajax({
            url: "{{url('/wh/p2h/summary')}}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#card-total').html(`<div class="card"><div class="card-body"><h6>Total</h6><h3>${data.total}</h3></div></div>`);
                $('#card-today').html(`<div class="card"><div class="card-body"><h6>Hari Ini</h6><h3>${data.today}</h3></div></div>`);
                $('#card-pending').html(`<div class="card"><div class="card-body"><h6>Pending</h6><h3>${data.pending}</h3></div></div>`);
                $('#card-completed').html(`<div class="card"><div class="card-body"><h6>Completed</h6><h3>${data.completed}</h3></div></div>`);
            },
            error: function(xhr, status, error) {
                console.error('Gagal load summary:', error);
            }
        });

        // Kelayakan - Doughnut Chart
        $.ajax({
            url: "{{url('/wh/p2h/kelayakan')}}",
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                var options = {
                    chart: {
                        type: 'donut',
                        height: 350
                    },
                    labels: [
                        'Layak (> 80%)',
                        'Perlu Perhatian (70–80%)',
                        'Tidak Layak (< 70%)'
                    ],
                    series: [res.layak, res.perlu_perhatian, res.tidak_layak],
                    colors: ['#28a745', '#ffc107', '#dc3545'],
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chartKelayakan"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error('Gagal load kelayakan:', error);
            }
        });

        // Masalah Terbanyak - Horizontal Bar Chart
        $.ajax({
            url: "{{url('/wh/p2h/masalah-terbanyak')}}",
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                var labels = Object.keys(res);
                var data = Object.values(res);

                var options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            barHeight: '60%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [{
                        name: 'Jumlah Masalah',
                        data: data
                    }],
                    xaxis: {
                        categories: labels
                    },
                    colors: ['#dc3545']
                };
                var chart = new ApexCharts(document.querySelector("#chartTopMasalah"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error('Gagal load masalah terbanyak:', error);
            }
        });

        // Operator - Vertical Bar Chart
        $.ajax({
            url: "{{url('/wh/p2h/operator')}}",
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                var labels = res.map(x => x.operator ?? 'Tidak Diketahui');
                var data = res.map(x => x.jumlah);

                var options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [{
                        name: 'Jumlah Pemeriksaan',
                        data: data
                    }],
                    xaxis: {
                        categories: labels
                    },
                    colors: ['#007bff']
                };

                var chart = new ApexCharts(document.querySelector("#chartOperator"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error('Gagal load operator:', error);
            }
        });


        // Shift - Pie Chart
        $.ajax({
            url: "{{url('/wh/p2h/shift')}}",
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                // Ganti null jadi 'Tidak Diisi' dan tambahkan label "Shift x"
                var labels = res.map(x => x.shift === null ? 'Tidak Diisi' : 'Shift ' + x.shift);
                var data = res.map(x => x.total);

                var options = {
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    labels: labels,
                    series: data,
                    colors: ['#007bff', '#28a745', '#ffc107', '#dc3545'], // Tambah warna kalau perlu
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#chartShift"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error('Gagal load shift:', error);
            }
        });

    });
</script>
@endsection