@extends('layout')
@section('dynamic_url', 'glucose/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Glucose Monitoring</h4>
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
                        <h4 class="card-title">GST</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-gst"></div>
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
        function getglucosedata() {
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

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            //  GST
            let Gst1 = data.map(item => item.GST1);
            let Gst2 = data.map(item => item.GST2);
            let Gst3 = data.map(item => item.GST3);
            let Gst4 = data.map(item => item.GST4);
            let Gst5 = data.map(item => item.GST5);


            // 🔹 Grafik Level & Tekanan Air
            new ApexCharts($("#chart-gst")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [{
                        name: "GST01",
                        data: Gst1
                    },
                    {
                        name: "GST02",
                        data: Gst2
                    },
                    {
                        name: "GST03",
                        data: Gst3
                    },
                    {
                        name: "GST04",
                        data: Gst4
                    },
                    {
                        name: "GST05",
                        data: Gst5
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
                        text: "GST01 s/d GST05"
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
                getDailytankData("{{ url('glucose/data') }}");
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
                getDailytankData("{{ url('glucose/data-harian') }}", {
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
                getDailytankData("{{ url('glucose/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });


        getglucosedata("{{ url('/glucose/data') }}");
    });
</script> -->
<script>
    $(document).ready(function() {
        let chartInstance = null;

        function getGlucoseData(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(response) {
                    resetChart();
                    if (response.success && response.data.length > 0) {
                        updateChart(response.data.reverse());
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Tidak Ditemukan',
                            text: 'Tidak ada data untuk tanggal yang dipilih.',
                        });
                        updateChart([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching glucose data:", error);
                }
            });
        }

        function resetChart() {
            if (chartInstance) {
                chartInstance.destroy();
            }
        }

        function updateChart(data) {
            let waktu = data.map(item => item.waktu);
            let seriesData = [
                { name: "GST01", data: data.map(item => item.GST1) },
                { name: "GST02", data: data.map(item => item.GST2) },
                { name: "GST03", data: data.map(item => item.GST3) },
                { name: "GST04", data: data.map(item => item.GST4) },
                { name: "GST05", data: data.map(item => item.GST5) }
            ];

            chartInstance = new ApexCharts($("#chart-gst")[0], {
                chart: { type: "area", height: 300 },
                series: seriesData,
                xaxis: { categories: waktu, labels: { show: false } },
                markers: { size: 5, shape: "circle" },
                yaxis: { title: { text: "GST01 s/d GST05" } }
            });
            chartInstance.render();
        }

        $("#filter-mode").change(function() {
            let mode = $(this).val();
            $("#filter-tanggal-container, #filter-mingguan-container").hide();
            if (mode === "harian") $("#filter-tanggal-container").show();
            if (mode === "mingguan") $("#filter-mingguan-container").show();
        });

        $("#apply-filter").click(function() {
            let mode = $("#filter-mode").val();
            if (mode === "normal") {
                getGlucoseData("{{ url('/glucose/data') }}");
            } else if (mode === "harian") {
                let tanggal = $("#filter-tanggal").val();
                if (!tanggal) {
                    Swal.fire({ icon: "warning", title: "Pilih Tanggal", text: "Silakan pilih tanggal terlebih dahulu." });
                    return;
                }
                getGlucoseData("{{ url('/glucose/data-harian') }}", { tanggal: tanggal });
            } else if (mode === "mingguan") {
                let tanggalMulai = $("#tanggal-mulai").val();
                let tanggalSelesai = $("#tanggal-selesai").val();
                if (!tanggalMulai || !tanggalSelesai) {
                    Swal.fire({ icon: "warning", title: "Pilih Rentang Tanggal", text: "Silakan pilih tanggal mulai dan selesai." });
                    return;
                }
                getGlucoseData("{{ url('/glucose/data-mingguan') }}", { tanggal_mulai: tanggalMulai, tanggal_selesai: tanggalSelesai });
            }
        });

        getGlucoseData("{{ url('/glucose/data') }}");
    });
</script>

@endsection