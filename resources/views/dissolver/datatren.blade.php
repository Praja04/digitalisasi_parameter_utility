@extends('layout')
@section('dynamic_url', 'dissolver/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dissolver Monitoring</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Analytics Data Trend</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>



        <!-- 🔹 Pilih Dissolver -->
        <div class="row mb-3">
            <div class="col-xl-3">
                <label for="">Pilih Dissolver</label>
                <select id="dissolver-selector" class="form-control">
                    <option value="dissolver1">Dissolver 1</option>
                    <option value="dissolver2">Dissolver 2</option>
                    <option value="dissolver3">Dissolver 3</option>
                    <option value="dissolver4">Dissolver 4</option>
                    <option value="dissolver5">Dissolver 5</option>
                    <option value="dissolver6">Dissolver 6</option>
                    <option value="dissolver7">Dissolver 7</option>
                    <option value="dissolver8">Dissolver 8</option>
                </select>
            </div>
            <div class="col-xl-2 mt-4">
                <button id="load-data" class="btn btn-primary">Muat Data</button>
            </div>

            <div class="col-md-3">
                <label for="filter-mode">Filter Data:</label>
                <select id="filter-mode" class="form-control">
                    <option value="normal">Terbaru</option>
                    <option value="harian">Per Hari</option>
                    <option value="mingguan">Per Minggu</option>
                </select>
            </div>
            <div class="col-md-3" id="filter-tanggal-container" style="display: none;">
                <label for="filter-tanggal">Pilih Tanggal:</label>
                <input type="date" id="filter-tanggal" class="form-control">
            </div>
            <div class="col-md-3" id="filter-mingguan-container" style="display: none;">
                <label>Pilih Rentang Tanggal:</label>
                <div class="d-flex">
                    <input type="date" id="tanggal-mulai" class="form-control">
                    <span class="mx-2">sampai</span>
                    <input type="date" id="tanggal-selesai" class="form-control">
                </div>
            </div>
            <div class="col-md-3 mt-4">
                <button class="btn btn-primary" id="apply-filter">search</button>
            </div>
        </div>
        <hr>

        <!-- 🔹 Grafik -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Grafik 1</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-grafik1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Grafik 2</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-grafik2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Grafik 3</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-grafik3"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Grafik 4</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-grafik4"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


<script>
    $(document).ready(function() {
        let selectedDissolver = "dissolver1"; // Default ke dissolver1
        let chartInstances = {}; // Menyimpan instance chart agar bisa diupdate ulang

        function getData() {
            $.ajax({
                url: "{{ url('/dissolver/data') }}/" + selectedDissolver, // Pastikan prefix /api/
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // console.log("Response Data:", response);
                    if (response.success && response.data.length > 0) {
                        let data = response.data.reverse();
                        //console.log("Processed Data:", data);
                        updateCharts(data);
                    } else {
                        console.warn("No data received.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.created_at);

            let seriesData = {
                "grafik1": [{
                        name: "Brix GGA",
                        data: data.map(item => item.Brix_GGA)
                    },
                    {
                        name: "Warna GGA",
                        data: data.map(item => item.Warna_GGA)
                    },
                    {
                        name: "Brix GGAS",
                        data: data.map(item => item.Brix_GGAS)
                    },
                    {
                        name: "Warna GGAS",
                        data: data.map(item => item.Warna_GGAS)
                    }
                ],
                "grafik2": [{
                        name: "NaCl GGA",
                        data: data.map(item => item.NaCl_GGA)
                    },
                    {
                        name: "Organo GGA",
                        data: data.map(item => item.Organo_GGA)
                    },
                    {
                        name: "NaCl GGAS",
                        data: data.map(item => item.NaCl_GGAS)
                    },
                    {
                        name: "Organo GGAS",
                        data: data.map(item => item.Organo_GGAS)
                    }
                ],
                "grafik3": [{
                        name: "Status GGA",
                        data: data.map(item => (item.Status_GGA === "OK" ? 1 : 0))
                    },
                    {
                        name: "Status GGAS",
                        data: data.map(item => (item.Status_GGAS === "OK" ? 1 : 0))
                    }
                ],
                "grafik4": [{
                        name: "Gula",
                        data: data.map(item => item.Gula)
                    },
                    {
                        name: "PO Masak",
                        data: data.map(item => item.PO_Masak)
                    }
                ]
            };

            Object.keys(seriesData).forEach((grafik, index) => {
                let chartElement = `#chart-${grafik}`;
                let options = {
                    series: seriesData[grafik],
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    xaxis: {
                        categories: waktu
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: `Grafik ${index + 1}`
                    }
                };

                if (chartInstances[grafik]) {
                    chartInstances[grafik].destroy(); // Hancurkan chart lama agar tidak tumpang tindih
                }
                chartInstances[grafik] = new ApexCharts(document.querySelector(chartElement), options);
                chartInstances[grafik].render();
            });
        }

        // 🔹 Pilih Dissolver dan Fetch Data
        $("#load-data").click(function() {
            selectedDissolver = $("#dissolver-selector").val();
            getData();
        });

        // 🔄 Ambil data pertama kali
        getData();
    });
</script>

@endsection