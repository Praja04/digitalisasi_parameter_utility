@extends('layout')
@section('dynamic_url', 'pasteurisasi2/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pasteurisasi 2 Monitoring</h4>
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
                        <h4 class="card-title">Suhu (temperature)</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-suhu"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pompa & Kecepatan</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-pompa"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tekanan (pressure)</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tekanan"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Level & Flowrate</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-level"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">MV (Motor Valve Control)</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-mv"></div>
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
        let chartInstances = {};

        function getPasteurisasi2(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                beforeSend: function() {
                    $("#apply-filter").prop("disabled", true).text("Memuat...");
                },
                success: function(response) {
                    $("#apply-filter").prop("disabled", false).text("Terapkan Filter");
                    //resetCharts();
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
                    console.error("Error fetching pasteurisasi2 data:", error);
                }
            });
        }

        function updateCharts(data) {
            const step = Math.ceil(data.length / 1000);
            const sampledData = data.filter((_, index) => index % step === 0);
            let waktu = sampledData.map(item => item.waktu);

            let charts = [{
                    id: "#chart-suhu",
                    series: [{
                            name: "Suhu Preheating",
                            data: sampledData.map(item => parseFloat(item.SuhuPreheating))
                        },
                        {
                            name: "Suhu Heating",
                            data: sampledData.map(item => parseFloat(item.SuhuHeating))
                        },
                        {
                            name: "Suhu Holding",
                            data: sampledData.map(item => parseFloat(item.SuhuHolding))
                        },
                        {
                            name: "Suhu Precooling",
                            data: sampledData.map(item => parseFloat(item.SuhuPrecooling))
                        },
                        {
                            name: "Suhu Cooling",
                            data: sampledData.map(item => parseFloat(item.SuhuCooling))
                        }
                    ]
                },
                {
                    id: "#chart-pompa",
                    series: [{
                            name: "Speed Pompa Mixing",
                            data: sampledData.map(item => parseFloat(item.SpeedPompaMixing))
                        },
                        {
                            name: "Speed Pump BT1",
                            data: sampledData.map(item => parseFloat(item.SpeedPumpBT1))
                        },
                        {
                            name: "Speed Pump VD",
                            data: sampledData.map(item => parseFloat(item.SpeedPumpVD))
                        },
                        {
                            name: "Speed Pump BT2",
                            data: sampledData.map(item => parseFloat(item.SpeedPumpBT2))
                        }
                    ]
                },
                {
                    id: "#chart-tekanan",
                    series: [{
                            name: "Pressure Mixing",
                            data: sampledData.map(item => parseFloat(item.PressureMixing))
                        },
                        {
                            name: "Pressure BT2",
                            data: sampledData.map(item => parseFloat(item.PressureBT2))
                        }
                    ]
                },
                {
                    id: "#chart-level",
                    series: [{
                            name: "Level BT1",
                            data: sampledData.map(item => parseFloat(item.LevelBT1))
                        },
                        {
                            name: "Level VD",
                            data: sampledData.map(item => parseFloat(item.LevelVD))
                        },
                        {
                            name: "Level BT2",
                            data: sampledData.map(item => parseFloat(item.LevelBT2))
                        },
                        {
                            name: "Flowrate AM",
                            data: sampledData.map(item => parseFloat(item.FlowrateAM))
                        },
                        {
                            name: "Flowrate",
                            data: sampledData.map(item => parseFloat(item.Flowrate))
                        }
                    ]
                },
                {
                    id: "#chart-mv",
                    title: "Motor Valve Control",
                    series: [{
                            name: "MV1",
                            data: sampledData.map(item => parseFloat(item.MV1))
                        },
                        {
                            name: "MV2",
                            data: sampledData.map(item => parseFloat(item.MV2))
                        }
                    ]
                }
            ];

            charts.forEach(chart => {
                let element = $(chart.id)[0];
                if (!element) return;

                let options = {
                    chart: {
                        type: "line",
                        height: 300,
                       
                    },
                    stroke: {
                        curve: "smooth"
                    },
                    series: chart.series,
                    xaxis: {
                        categories: waktu,
                        labels: {
                            show: false
                        }
                    },
                    yaxis: {
                        title: {
                            text: chart.id.replace('#chart-', '').toUpperCase()
                        }
                    }
                };

                if (!chartInstances[chart.id]) {
                    chartInstances[chart.id] = new ApexCharts(element, options);
                    chartInstances[chart.id].render();
                } else {
                    chartInstances[chart.id].updateSeries(chart.series);
                    chartInstances[chart.id].updateOptions({
                        xaxis: {
                            categories: waktu
                        }
                    });
                }
            });
        }

        function resetCharts() {
            for (let key in chartInstances) {
                chartInstances[key].destroy();
            }
            chartInstances = {};
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
                getPasteurisasi2("{{ url('pasteurisasi2/data') }}");
            } else if (mode === "harian") {
                let tanggal = $("#filter-tanggal").val();
                if (!tanggal) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Tanggal",
                    text: "Silakan pilih tanggal."
                });
                getPasteurisasi2("{{ url('pasteurisasi2/data-harian') }}", {
                    tanggal: tanggal
                });
            } else if (mode === "mingguan") {
                let tanggalMulai = $("#tanggal-mulai").val();
                let tanggalSelesai = $("#tanggal-selesai").val();
                if (!tanggalMulai || !tanggalSelesai) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Rentang Tanggal",
                    text: "Silakan pilih tanggal mulai dan selesai."
                });
                getPasteurisasi2("{{ url('pasteurisasi2/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getPasteurisasi2("{{ url('/pasteurisasi2/data') }}");
    });
</script>


@endsection