@extends('layout')
@section('dynamic_url', 'pasteurisasi1/realtime-pasteurizer')
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- 🔹 Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Pasteurisasi 1 Monitoring</h4>
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
                        <option value="latest">Terbaru</option>
                        <option value="daily">Per Hari</option>
                        <option value="weekly">Per Minggu</option>
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
                            <h4 class="card-title">Pasteurizer Suhu</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-pasteu-suhu"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pasteurizer Aliran & Kontrol</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-pasteu-aliran"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pasteurizer Tangki & Tekanan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-pasteu-tangki"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Vacuum Deaerator Pompa & Level Tangki</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-vacum-pompa"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Vacuum Deaerator Tekanan & Kontrol Vacuum</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-vacum-tekanan"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                                                                                                                            <div class="col-xl-12">
                                                                                                                                <div class="card">
                                                                                                                                    <div class="card-header">
                                                                                                                                        <h4 class="card-title">Vacuum Deaerator Arus & Aktivitas Mesin</h4>
                                                                                                                                    </div>
                                                                                                                                    <div class="card-body">
                                                                                                                                        <div id="chart-vacum-arus"></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div> -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Mixing Kecepatan Pompa & Tekanan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-mixing-kecepatan"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                                                                                                                            <div class="col-xl-12">
                                                                                                                                <div class="card">
                                                                                                                                    <div class="card-header">
                                                                                                                                        <h4 class="card-title">Mixing Arus Listrik & Aktivitas Mesin</h4>
                                                                                                                                    </div>
                                                                                                                                    <div class="card-body">
                                                                                                                                        <div id="chart-mixing-arus"></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div> -->
        </div>
    </div>

    <!-- 🔹 Include ApexCharts & jQuery -->
    <script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>





    <!-- <script>
        $(document).ready(function() {
            let chartInstances = [];

            function getData(url, params = {}) {
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
                        if (response.success && response.data.length > 0) {
                            let data = response.data.reverse();
                            updateCharts(data);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Tidak Ditemukan',
                                text: 'Tidak ada data untuk rentang tanggal yang dipilih.',
                            });
                            updateCharts([]);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            function updateCharts(data) {
                const step = Math.ceil(data.length / 1000);
                const sampledData = data.filter((_, index) => index % step === 0);
                let waktu = sampledData.map(item => item.Waktu);

                let charts = [{
                        id: "#chart-pasteu-suhu",
                        title: "Pasteurizer - Suhu",
                        series: [{
                                name: "Preheating (°C)",
                                data: data.map(item => item.SuhuPreheating)
                            },
                            {
                                name: "Heating (°C)",
                                data: data.map(item => item.SuhuHeating)
                            },
                            {
                                name: "Holding (°C)",
                                data: data.map(item => item.SuhuHolding)
                            },
                            {
                                name: "Precooling (°C)",
                                data: data.map(item => item.SuhuPrecooling)
                            },
                            {
                                name: "Cooling (°C)",
                                data: data.map(item => item.SuhuCooling)
                            }
                        ]
                    },
                    {
                        id: "#chart-pasteu-aliran",
                        title: "Pasteurizer - Aliran & Kontrol",
                        series: [{
                                name: "Flowrate (L/min)",
                                data: data.map(item => item.Flowrate)
                            },
                            {
                                name: "PCV1 (%)",
                                data: data.map(item => item.PCV1)
                            },
                            {
                                name: "Time Divert (s)",
                                data: data.map(item => item.TimeDivert)
                            }
                        ]
                    },
                    {
                        id: "#chart-pasteu-tangki",
                        title: "Pasteurizer - Tangki & Tekanan",
                        series: [{
                                name: "Level BT2 (cm)",
                                data: data.map(item => item.LevelBT2)
                            },
                            {
                                name: "Speed Pump BT2 (rpm)",
                                data: data.map(item => item.SpeedPumpBT2)
                            },
                            {
                                name: "Pressure BT2 (bar)",
                                data: data.map(item => item.PressureBT2)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-pompa",
                        title: "Vacuum Deaerator - Pompa & Level Tangki",
                        series: [{
                                name: "Speed Pump BT1 (rpm)",
                                data: data.map(item => item.SpeedPumpBT1)
                            },
                            {
                                name: "Level BT1 (cm)",
                                data: data.map(item => item.LevelBT1)
                            },
                            {
                                name: "Speed Pump VD (rpm)",
                                data: data.map(item => item.SpeedPumpVD)
                            },
                            {
                                name: "Level VD (cm)",
                                data: data.map(item => item.LevelVD)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-tekanan",
                        title: "Vacuum Deaerator - Tekanan & Kontrol Vacuum",
                        series: [{
                                name: "Tekanan VDHH (bar)",
                                data: data.map(item => item.PressVDHH)
                            },
                            {
                                name: "Tekanan VDLL (bar)",
                                data: data.map(item => item.PressVDLL)
                            },
                            {
                                name: "Tekanan ke Pasteur (bar)",
                                data: data.map(item => item.PressToPasteur)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-arus",
                        title: "Vacuum Deaerator - Arus & Aktivitas Mesin",
                        series: [{
                                name: "Arus BT1 (A)",
                                data: data.map(item => item.BT1AM)
                            },
                            {
                                name: "Arus VD (A)",
                                data: data.map(item => item.VDAM)
                            }
                        ]
                    },
                    {
                        id: "#chart-mixing-kecepatan",
                        title: "Mixing - Kecepatan Pompa & Tekanan",
                        series: [{
                                name: "Speed Pompa Mixing (rpm)",
                                data: data.map(item => item.SpeedPompaMixing)
                            },
                            {
                                name: "Pressure Mixing (bar)",
                                data: data.map(item => item.PressureMixing)
                            }
                        ]
                    },
                    {
                        id: "#chart-mixing-arus",
                        title: "Mixing - Arus Listrik & Aktivitas Mesin",
                        series: [{
                            name: "Arus Mixing (A)",
                            data: data.map(item => item.MixingAM)
                        }]
                    }
                ];

                charts.forEach((chart, index) => {
                    if (!chartInstances[index]) {
                        chartInstances[index] = new ApexCharts($(chart.id)[0], {
                            chart: {
                                type: "line",
                                height: 300
                            },
                            series: chart.series,
                            xaxis: {
                                categories: waktu,
                                labels: {
                                    show: false
                                }
                            }
                        });
                        chartInstances[index].render();
                    } else {
                        chartInstances[index].updateOptions({
                            series: chart.series,
                            xaxis: {
                                categories: waktu,
                                labels: {
                                    show: false
                                }
                            }
                        }, false, true);
                    }
                });
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
                    getData("{{ url('/pasteurisasi1/data') }}");
                } else if (mode === "harian") {
                    let tanggal = $("#filter-tanggal").val();
                    if (!tanggal) {
                        Swal.fire({
                            icon: "warning",
                            title: "Pilih Tanggal",
                            text: "Silakan pilih tanggal."
                        });
                        return;
                    }
                    getData("{{ url('/pasteurisasi1/data-harian') }}", {
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
                    getData("{{ url('/pasteurisasi1/data-mingguan') }}", {
                        tanggal_mulai: tanggalMulai,
                        tanggal_selesai: tanggalSelesai
                    });
                }
            });

            // Panggil fungsi getData saat halaman dimuat
            getData("{{ url('/pasteurisasi1/data') }}");

        });
    </script> -->

    <script>
        $(document).ready(function() {
            let chart;

            function fetchData(url, params = {}) {
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
                if (!data || data.length === 0) {
                    if (chart) {
                        chart.updateSeries([{
                            data: []
                        }]); // Kosongkan chart
                    }
                    Swal.fire({
                        icon: "warning",
                        title: "Data Tidak Ditemukan",
                        text: "Tidak ada data untuk rentang waktu yang dipilih.",
                    });
                    return;
                }

                // console.log('Data received:', data);

                let categories = data.map(item => item.waktu);
                let seriesData = {
                    SuhuHolding: data.map(item => item.SuhuHolding),
                    SuhuHeating: data.map(item => item.SuhuHeating),
                    SuhuCooling: data.map(item => item.SuhuCooling),
                    SuhuPrecooling: data.map(item => item.SuhuPrecooling),
                    SuhuPreheating: data.map(item => item.SuhuPreheating)
                };

                console.log('Series Data:', seriesData);
                // let seriesData2 = {
                //     LevelBT2: data.map(item => item.LevelBT2),
                //     SpeedPumpBT2: data.map(item => item.SpeedPumpBT2),
                //     PressureBT2: data.map(item => item.PressureBT2),
                // };

                let chartOptions = {
                    chart: {
                        type: "line",
                        height: 350
                    },
                    stroke: {
                        width: 2,
                        curve: "smooth"
                    },
                    series: [{
                            name: "Suhu Holding",
                            data: seriesData.SuhuHolding
                        },
                        {
                            name: "Suhu Heating",
                            data: seriesData.SuhuHeating
                        },
                        {
                            name: "Suhu Cooling",
                            data: seriesData.SuhuCooling
                        },
                        {
                            name: "Suhu Precooling",
                            data: seriesData.SuhuPrecooling
                        },
                        {
                            name: "Suhu PreHeating",
                            data: seriesData.SuhuPreheating
                        }
                    ],
                    colors: ["#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#727cf5"],
                    xaxis: {
                        categories: categories,
                        title: {
                            text: "Waktu"
                        },
                        labels: {
                            show: false
                        }
                    },
                    yaxis: {
                        title: {
                            text: "Sensor Suhu Value"
                        }
                    },
                    tooltip: {
                        x: {
                            format: "dd MMM HH:mm"
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(chartOptions);

                } else {
                    chart = new ApexCharts(document.querySelector("#chart-pasteu-suhu"), chartOptions);

                    chart.render();
                }
            }

            function updateInputFields() {
                let filter = $("#filter-mode").val();
                $("#datePicker, #startDate, #endDate").addClass("d-none");

                if (filter === "daily") {
                    $("#datePicker").removeClass("d-none");
                } else if (filter === "weekly") {
                    $("#startDate, #endDate").removeClass("d-none");
                }
            }

            $("#filter-mode").change(function() {
                let mode = $(this).val();
                $("#filter-tanggal-container, #filter-mingguan-container").hide();
                if (mode === "harian") $("#filter-tanggal-container").show();
                if (mode === "mingguan") $("#filter-mingguan-container").show();
                updateInputFields();
            });

            $("#apply-filter").on("click", function() {
                let filter = $("#filter-mode").val();
                let url = "";
                let params = {};

                if (filter === "latest") {
                    url = "{{ url('pasteurisasi1/data') }}";
                    // console.log(url);
                } else if (filter === "daily") {
                    let selectedDate = $("#datePicker").val();
                    if (!selectedDate) {
                        Swal.fire({
                            icon: "warning",
                            title: "Pilih Tanggal!",
                            text: "Harap pilih tanggal sebelum menerapkan filter.",
                        });
                        return;
                    }
                    url = "{{ url('pasteurisasi1/data-harian') }}";
                    params = {
                        tanggal: selectedDate
                    };
                } else if (filter === "weekly") {
                    let startDate = $("#startDate").val();
                    let endDate = $("#endDate").val();
                    if (!startDate || !endDate) {
                        Swal.fire({
                            icon: "warning",
                            title: "Pilih Rentang Tanggal!",
                            text: "Harap pilih tanggal mulai dan tanggal selesai sebelum menerapkan filter.",
                        });
                        return;
                    }
                    url = "{{ url('pasteurisasi1/data-mingguan') }}";
                    params = {
                        tanggal_mulai: startDate,
                        tanggal_selesai: endDate
                    };
                }

                fetchData(url, params).done(response => {
                    if (response.success) {
                        // console.log(response.data);
                        updateChart(response.data);
                    } else {
                        if (chart) {
                            chart.updateSeries([{
                                data: []
                            }]); // Kosongkan chart jika data tidak ditemukan
                        }
                        Swal.fire({
                            icon: "warning",
                            title: "Data Tidak Ditemukan",
                            text: "Tidak ada data untuk rentang waktu yang dipilih.",
                        });
                    }
                });
            });

            updateInputFields();

        });
    </script>

    <!-- <script>
        $(document).ready(function() {
            let chartInstances = [];

            function fetchData(filterType, params = {}) {
                let url = "";

                switch (filterType) {
                    case "latest":
                        url = "{{ url('pasteurisasi1/data') }}";
                        break;
                    case "daily":
                        url = "{{ url('pasteurisasi1/data-harian') }}";
                        break;
                    case "weekly":
                        url = "{{ url('pasteurisasi1/data-mingguan') }}";
                        break;
                    default:
                        return Promise.reject("Filter tidak valid");
                }

                return $.ajax({
                    url: url,
                    type: "GET",
                    data: params,
                    dataType: "json",
                });
            }

            function updateChart(data) {
                if (data.length === 0) {
                    chartInstances.forEach(chart => chart.updateSeries([{
                        data: []
                    }]));
                    Swal.fire({
                        icon: "warning",
                        title: "Data Tidak Ditemukan",
                        text: "Tidak ada data untuk rentang waktu yang dipilih.",
                    });
                    return;
                }

                let categories = data.map(item => item.waktu);
                let charts = [{
                        id: "#chart-pasteu-suhu",
                        title: "Pasteurizer - Suhu",
                        series: [{
                                name: "Preheating (°C)",
                                data: data.map(item => item.SuhuPreheating)
                            },
                            {
                                name: "Heating (°C)",
                                data: data.map(item => item.SuhuHeating)
                            },
                            {
                                name: "Holding (°C)",
                                data: data.map(item => item.SuhuHolding)
                            },
                            {
                                name: "Precooling (°C)",
                                data: data.map(item => item.SuhuPrecooling)
                            },
                            {
                                name: "Cooling (°C)",
                                data: data.map(item => item.SuhuCooling)
                            }
                        ]
                    },
                    {
                        id: "#chart-pasteu-aliran",
                        title: "Pasteurizer - Aliran & Kontrol",
                        series: [{
                                name: "Flowrate (L/min)",
                                data: data.map(item => item.Flowrate)
                            },
                            {
                                name: "PCV1 (%)",
                                data: data.map(item => item.PCV1)
                            },
                            {
                                name: "Time Divert (s)",
                                data: data.map(item => item.TimeDivert)
                            }
                        ]
                    },
                    {
                        id: "#chart-pasteu-tangki",
                        title: "Pasteurizer - Tangki & Tekanan",
                        series: [{
                                name: "Level BT2 (cm)",
                                data: data.map(item => item.LevelBT2)
                            },
                            {
                                name: "Speed Pump BT2 (rpm)",
                                data: data.map(item => item.SpeedPumpBT2)
                            },
                            {
                                name: "Pressure BT2 (bar)",
                                data: data.map(item => item.PressureBT2)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-pompa",
                        title: "Vacuum Deaerator - Pompa & Level Tangki",
                        series: [{
                                name: "Speed Pump BT1 (rpm)",
                                data: data.map(item => item.SpeedPumpBT1)
                            },
                            {
                                name: "Level BT1 (cm)",
                                data: data.map(item => item.LevelBT1)
                            },
                            {
                                name: "Speed Pump VD (rpm)",
                                data: data.map(item => item.SpeedPumpVD)
                            },
                            {
                                name: "Level VD (cm)",
                                data: data.map(item => item.LevelVD)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-tekanan",
                        title: "Vacuum Deaerator - Tekanan & Kontrol Vacuum",
                        series: [{
                                name: "Tekanan VDHH (bar)",
                                data: data.map(item => item.PressVDHH)
                            },
                            {
                                name: "Tekanan VDLL (bar)",
                                data: data.map(item => item.PressVDLL)
                            },
                            {
                                name: "Tekanan ke Pasteur (bar)",
                                data: data.map(item => item.PressToPasteur)
                            }
                        ]
                    },
                    {
                        id: "#chart-vacum-arus",
                        title: "Vacuum Deaerator - Arus & Aktivitas Mesin",
                        series: [{
                                name: "Arus BT1 (A)",
                                data: data.map(item => item.BT1AM)
                            },
                            {
                                name: "Arus VD (A)",
                                data: data.map(item => item.VDAM)
                            }
                        ]
                    },
                    {
                        id: "#chart-mixing-kecepatan",
                        title: "Mixing - Kecepatan Pompa & Tekanan",
                        series: [{
                                name: "Speed Pompa Mixing (rpm)",
                                data: data.map(item => item.SpeedPompaMixing)
                            },
                            {
                                name: "Pressure Mixing (bar)",
                                data: data.map(item => item.PressureMixing)
                            }
                        ]
                    },
                    {
                        id: "#chart-mixing-arus",
                        title: "Mixing - Arus Listrik & Aktivitas Mesin",
                        series: [{
                            name: "Arus Mixing (A)",
                            data: data.map(item => item.MixingAM)
                        }]
                    }
                ];

                charts.forEach((chartConfig, index) => {
                    let chartElement = document.querySelector(chartConfig.id);
                    if (!chartElement) return;

                    let chartOptions = {
                        chart: {
                            type: "line",
                            height: 350
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth"
                        },
                        series: chartConfig.series,
                        colors: ["#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#727cf5"],
                        xaxis: {
                            categories: categories,
                            title: {
                                text: "Waktu"
                            },
                            labels: {
                                show: false
                            }
                        },
                        yaxis: {
                            title: {
                                text: "Sensor Value"
                            }
                        },
                        tooltip: {
                            x: {
                                format: "dd MMM HH:mm"
                            }
                        }
                    };

                    if (!chartInstances[index]) {
                        chartInstances[index] = new ApexCharts(chartElement, chartOptions);
                        chartInstances[index].render();
                    } else {
                        chartInstances[index].updateOptions(chartOptions);
                    }
                });
            }

            function updateInputFields() {
                let filter = $("#filterData").val();
                $("#datePicker, #startDate, #endDate").addClass("d-none");

                if (filter === "daily") {
                    $("#datePicker").removeClass("d-none");
                } else if (filter === "weekly") {
                    $("#startDate, #endDate").removeClass("d-none");
                }
            }

            $("#filterData").on("change", updateInputFields);

            $("#applyFilter").on("click", function() {
                let filter = $("#filterData").val();
                let params = {};

                if (filter === "daily") {
                    let selectedDate = $("#datePicker").val();
                    if (!selectedDate) {
                        Swal.fire({
                            icon: "warning",
                            title: "Pilih Tanggal!",
                            text: "Harap pilih tanggal sebelum menerapkan filter."
                        });
                        return;
                    }
                    params.tanggal = selectedDate;
                } else if (filter === "weekly") {
                    let startDate = $("#startDate").val();
                    let endDate = $("#endDate").val();
                    if (!startDate || !endDate) {
                        Swal.fire({
                            icon: "warning",
                            title: "Pilih Rentang Tanggal!",
                            text: "Harap pilih tanggal mulai dan tanggal selesai sebelum menerapkan filter."
                        });
                        return;
                    }
                    params = {
                        tanggal_mulai: startDate,
                        tanggal_selesai: endDate
                    };
                }

                fetchData(filter, params)
                    .done(response => {
                        if (response.success) {
                            updateChart(response.data);
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: "Data Tidak Ditemukan",
                                text: "Tidak ada data untuk rentang waktu yang dipilih."
                            });
                        }
                    })
                    .fail(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Kesalahan!",
                            text: "Gagal mengambil data. Silakan coba lagi."
                        });
                    });
            });

            updateInputFields();
            $("#applyFilter").trigger("click");

            // function updatePVSteam() {
            //     $.ajax({
            //         url: "{{ url('sensor/boiler-realtime') }}",
            //         dataType: "json",
            //         success: function(response) {
            //             $("#PV-bar").val(response.PVSteam + " Bar");
            //         },
            //         error: function(_xhr, status, error) {
            //             console.error("AJAX Error: " + status + error);
            //         }
            //     });
            // }

            // updatePVSteam();
            // setInterval(updatePVSteam, 5000);
        });
    </script> -->
@endsection
