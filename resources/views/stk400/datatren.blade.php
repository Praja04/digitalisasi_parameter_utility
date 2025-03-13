@extends('layout')
@section('dynamic_url', 'stk400/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">STK400 Monitoring</h4>
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


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tank Glucose</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tank-glucose"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Flow Rate</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-flowrate"></div>
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
        let charts = {};

        function getSTK400Data(url, params = {}) {
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
                            icon: "warning",
                            title: "Data Tidak Ditemukan",
                            text: "Tidak ada data untuk tanggal yang dipilih.",
                        });
                        updateCharts([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching STK400 data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            createOrUpdateChart("chart-tank-glucose", "Tank Glucose", waktu, [{
                name: "Tank Glucose",
                data: data.map(item => parseFloat(item.Tank_Glucose))
            }]);

            createOrUpdateChart("chart-flowrate", "Flowrate", waktu, [{
                name: "Flowrate",
                data: data.map(item => parseFloat(item.Flowrate))
            }]);
        }

        function createOrUpdateChart(id, title, categories, seriesData) {
            if (charts[id]) {
                charts[id].updateSeries(seriesData);
            } else {
                charts[id] = new ApexCharts(document.getElementById(id), {
                    chart: {
                        type: "area",
                        height: 300
                    },
                    stroke: {
                        curve: "smooth"
                    },
                    series: seriesData,
                    xaxis: {
                        categories: categories,
                        labels: {
                            show: false
                        }
                    },
                    markers: {
                        size: 5,
                        shape: "circle"
                    },
                    yaxis: {
                        title: {
                            text: title
                        }
                    }
                });
                charts[id].render();
            }
        }

        function resetCharts() {
            for (let key in charts) {
                charts[key].destroy();
            }
            charts = {};
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
                getSTK400Data("{{ url('stk400/data') }}");
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
                getSTK400Data("{{ url('stk400/data-harian') }}", {
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
                getSTK400Data("{{ url('stk400/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getSTK400Data("{{ url('/stk400/data') }}");
    });
</script>


@endsection