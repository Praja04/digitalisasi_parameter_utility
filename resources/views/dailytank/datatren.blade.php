@extends('layout')
@section('dynamic_url', 'daily-tank/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Daily Tank Monitoring</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item active">Analytics Data Trend</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label for="filter-mode">Filter Data:</label>
                <select id="filter-mode" class="form-control">
                    <option value="normal">Terbaru</option>
                    <option value="harian">Per Hari</option>
                    <option value="mingguan">Per Minggu</option>
                </select>
            </div>
            <div class="col-md-4" id="filter-tanggal-container" style="display: none;">
                <label for="filter-tanggal">Pilih Tanggal:</label>
                <input type="date" id="filter-tanggal" class="form-control">
            </div>
            <div class="col-md-4" id="filter-mingguan-container" style="display: none;">
                <label>Pilih Rentang Tanggal:</label>
                <div class="d-flex">
                    <input type="date" id="tanggal-mulai" class="form-control">
                    <span class="mx-2">sampai</span>
                    <input type="date" id="tanggal-selesai" class="form-control">
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <button class="btn btn-primary" id="apply-filter">search</button>
            </div>
        </div>

        <hr>

        <!-- 🔹 Grafik DT Ro & Salt  -->
        <!-- 'DT_RO',
        'DT_Salt',
        'DT_SoySauceA',
        'DT_SoySauceB',
        'DT_SoySauceC', -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">DT RO Water & Salt Water</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-dt-ro-salt"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Grafik Soy Sauce -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">DT Soy Sauce</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-soy-sauce"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- <script>
    $(document).ready(function() {
        function getDailytankData(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching dailytank data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            //  Dt ro & salt
            let DTRO = data.map(item => item.DT_RO);
            let DTSalt = data.map(item => item.DT_Salt);

            //  Dt soy sauce
            let SoySauceA = data.map(item => item.DT_SoySauceA);
            let SoySauceB = data.map(item => item.DT_SoySauceB);
            let SoySauceC = data.map(item => item.DT_SoySauceC);
            // 🔹 Grafik Level & Tekanan Air
            new ApexCharts($("#chart-dt-ro-salt")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "DT Ro Water (Liter)",
                        data: DTRO
                    },
                    {
                        name: "DT Salt Water (Liter)",
                        data: DTSalt
                    }
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                },
                markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "DT Ro Water & DT Salt Water"
                    }
                }
            }).render();

            // 🔹 Grafik Temperatur & Gas
            new ApexCharts($("#chart-soy-sauce")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [{
                        name: "DT Soy Sauce A (Kg)",
                        data: SoySauceA
                    },
                    {
                        name: "DT Soy Sauce B (Kg)",
                        data: SoySauceB
                    },
                    {
                        name: "DT Soy Sauce C (Kg)",
                        data: SoySauceC
                    }
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                },
                markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "DT Soy Sauce"
                    }
                }
            }).render();
        }


        $("#filter-mode").change(function() {
            let mode = $(this).val();
            $("#filter-tanggal-container, #filter-mingguan-container").hide();
            if (mode === "harian") {
                $("#filter-tanggal-container").show();
            } else if (mode === "mingguan") {
                $("#filter-mingguan-container").show();
            }
        });

        $("#apply-filter").click(function() {
            let mode = $("#filter-mode").val();

            if (mode === "normal") {
                getDailytankData("daily-tank/data");
            } else if (mode === "harian") {
                let tanggal = $("#filter-tanggal").val();
                if (!tanggal) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Tanggal",
                        text: "Silakan pilih tanggal terlebih dahulu."
                    });
                    return;
                }
                getDailytankData("/daily-tank/data-harian", {
                    tanggal: tanggal
                });
            } else if (mode === "mingguan") {
                let tanggalMulai = $("#tanggal-mulai").val();
                let tanggalSelesai = $("#tanggal-selesai").val();
                if (!tanggalMulai || !tanggalSelesai) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Rentang Tanggal",
                        text: "Silakan pilih tanggal mulai dan selesai."
                    });
                    return;
                }
                getDailytankData("/daily-tank/data-mingguan", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getDailytankData("{{ url('/daily-tank/data') }}");
    });
</script> -->

<script>
    $(document).ready(function() {
        let chartInstances = [];

        function getDailytankData(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(response) {
                    resetCharts();
                    if (response.success && response.data.length > 0) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Tidak Ditemukan',
                            text: 'Tidak ada data untuk tanggal yang dipilih.',
                        });
                        updateCharts([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching dailytank data:", error);
                }
            });
        }

        function resetCharts() {
            chartInstances.forEach(chart => chart.destroy());
            chartInstances = [];
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu) || [];
            let DTRO = data.map(item => item.DT_RO) || [];
            let DTSalt = data.map(item => item.DT_Salt) || [];
            let SoySauceA = data.map(item => item.DT_SoySauceA) || [];
            let SoySauceB = data.map(item => item.DT_SoySauceB) || [];
            let SoySauceC = data.map(item => item.DT_SoySauceC) || [];

            let chartOptions = (series, title, type = "line") => ({
                chart: { type, height: 300 },
                series,
                xaxis: { categories: waktu, labels: { show: false } },
                markers: { size: 5, shape: "circle" },
                yaxis: { title: { text: title } }
            });

            let chart1 = new ApexCharts($("#chart-dt-ro-salt")[0], chartOptions([
                { name: "DT Ro Water (Liter)", data: DTRO },
                { name: "DT Salt Water (Liter)", data: DTSalt }
            ], "DT Ro Water & DT Salt Water"));
            chart1.render();
            chartInstances.push(chart1);

            let chart2 = new ApexCharts($("#chart-soy-sauce")[0], chartOptions([
                { name: "DT Soy Sauce A (Kg)", data: SoySauceA },
                { name: "DT Soy Sauce B (Kg)", data: SoySauceB },
                { name: "DT Soy Sauce C (Kg)", data: SoySauceC }
            ], "DT Soy Sauce", "area"));
            chart2.render();
            chartInstances.push(chart2);
        }

        $("#filter-mode").change(function() {
            let mode = $(this).val();
            $("#filter-tanggal-container, #filter-mingguan-container").hide();
            if (mode === "harian") {
                $("#filter-tanggal-container").show();
            } else if (mode === "mingguan") {
                $("#filter-mingguan-container").show();
            }
        });

        $("#apply-filter").click(function() {
            let mode = $("#filter-mode").val();

            if (mode === "normal") {
                getDailytankData("{{ url('/daily-tank/data') }}");
            } else if (mode === "harian") {
                let tanggal = $("#filter-tanggal").val();
                if (!tanggal) {
                    Swal.fire({ icon: "warning", title: "Pilih Tanggal", text: "Silakan pilih tanggal terlebih dahulu." });
                    return;
                }
                getDailytankData("{{ url('/daily-tank/data-harian') }}", { tanggal: tanggal });
            } else if (mode === "mingguan") {
                let tanggalMulai = $("#tanggal-mulai").val();
                let tanggalSelesai = $("#tanggal-selesai").val();
                if (!tanggalMulai || !tanggalSelesai) {
                    Swal.fire({ icon: "warning", title: "Pilih Rentang Tanggal", text: "Silakan pilih tanggal mulai dan selesai." });
                    return;
                }
                getDailytankData("{{ url('/daily-tank/data-mingguan') }}", { tanggal_mulai: tanggalMulai, tanggal_selesai: tanggalSelesai });
            }
        });

        getDailytankData("{{ url('/daily-tank/data') }}");
    });
</script>
@endsection