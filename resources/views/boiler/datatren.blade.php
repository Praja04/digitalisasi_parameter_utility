@extends('layout')
@section('dynamic_url', 'boiler/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Boiler Sensor Monitoring</h4>
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
            <div class="col-md-4 mt-4" >
                <button class="btn btn-primary" id="apply-filter">search</button>
            </div>
        </div>

        <hr>

        <!-- 🔹 Grafik Level & Tekanan Air -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Water Level & Pressure</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-water-pressure"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Grafik Temperatur & Gas -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Temperature & Gas Analysis</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-temp-gas"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Grafik Fan & Stoker -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Fan & Stoker Performance</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-fan-stoker"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Grafik Flow Rate & Bahan Bakar -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Flow Rate & Fuel Consumption</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-flow-fuel"></div>
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
        function getBoilerData(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Tidak Ditemukan',
                            text: 'Tidak ada data untuk tanggal yang dipilih.',
                        });
                        updateCharts([]); // Kosongkan grafik
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching boiler data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu) || [];
            let levelFeedWater = data.map(item => item.LevelFeedWater) || [];
            let feedPressure = data.map(item => item.FeedPressure) || [];
            let pvSteam = data.map(item => item.PVSteam) || [];
            let lhTemp = data.map(item => item.LHTemp) || [];
            let rhTemp = data.map(item => item.RHTemp) || [];
            let suhuFeedTank = data.map(item => item.SuhuFeedTank) || [];
            let o2 = data.map(item => item.O2) || [];
            let co2 = data.map(item => item.CO2) || [];
            let idFan = data.map(item => item.IDFan) || [];
            let lhFDFan = data.map(item => item.LHFDFan) || [];
            let rhFDFan = data.map(item => item.RHFDFan) || [];
            let lhStoker = data.map(item => item.LHStoker) || [];
            let rhStoker = data.map(item => item.RHStoker) || [];
            let inletFlow = data.map(item => item.InletWaterFlow) || [];
            let outletFlow = data.map(item => item.OutletSteamFlow) || [];
            let batubaraFK = data.map(item => item.Batubara_FK) || [];
            let steamFK = data.map(item => item.Steam_FK) || [];

            let chartOptions = (series, title, type = "line") => ({
                chart: {
                    type,
                    height: 300
                },
                series,
                xaxis: {
                    categories: waktu,
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

            new ApexCharts($("#chart-water-pressure")[0], chartOptions([{
                    name: "Feed Water Level (%)",
                    data: levelFeedWater
                },
                {
                    name: "Feed Pressure (bar)",
                    data: feedPressure
                },
                {
                    name: "Steam Pressure (bar)",
                    data: pvSteam
                }
            ], "Tekanan & Level")).render();

            new ApexCharts($("#chart-temp-gas")[0], chartOptions([{
                    name: "LH Temperature (°C)",
                    data: lhTemp
                },
                {
                    name: "RH Temperature (°C)",
                    data: rhTemp
                },
                {
                    name: "Feed Tank Temperature (°C)",
                    data: suhuFeedTank
                },
                {
                    name: "Oxygen (O2) (%)",
                    data: o2
                },
                {
                    name: "Carbon Dioxide (CO2) (%)",
                    data: co2
                }
            ], "Temperatur & Gas")).render();

            new ApexCharts($("#chart-fan-stoker")[0], chartOptions([{
                    name: "ID Fan (Hz)",
                    data: idFan
                },
                {
                    name: "LH FD Fan (Hz)",
                    data: lhFDFan
                },
                {
                    name: "RH FD Fan (Hz)",
                    data: rhFDFan
                },
                {
                    name: "LH Stoker (Hz)",
                    data: lhStoker
                },
                {
                    name: "RH Stoker (Hz)",
                    data: rhStoker
                }
            ], "Frekuensi Fan & Stoker (Hz)", "bar")).render();

            new ApexCharts($("#chart-flow-fuel")[0], chartOptions([{
                    name: "Inlet Water Flow (m³/h)",
                    data: inletFlow
                },
                {
                    name: "Outlet Steam Flow (ton/h)",
                    data: outletFlow
                },
                {
                    name: "Coal Consumption (kg/h)",
                    data: batubaraFK
                },
                {
                    name: "Steam Production (ton/h)",
                    data: steamFK
                }
            ], "Flow & Fuel Usage", "area")).render();
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

        $("#filter-normal").click(function() {
            getBoilerData("/sensor/boiler/data-normal");
        });

        $("#filter-harian").click(function() {
            let tanggal = $("#input-tanggal").val();
            if (!tanggal) {
                Swal.fire({
                    icon: "warning",
                    title: "Pilih Tanggal",
                    text: "Silakan pilih tanggal terlebih dahulu."
                });
                return;
            }
            getBoilerData("/sensor/boiler/data-harian", {
                tanggal: tanggal
            });
        });

        // 🔹 Jalankan pertama kali dengan data normal
        getBoilerData("{{ url('/sensor/boiler-data') }}");
    });
</script> -->
<script>
    $(document).ready(function() {
    let chartInstances = [];

    function getBoilerData(url, params = {}) {
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
                console.error("Error fetching boiler data:", error);
            }
        });
    }

    function resetCharts() {
        chartInstances.forEach(chart => chart.destroy());
        chartInstances = [];
    }

    function updateCharts(data) {
        let waktu = data.map(item => item.waktu) || [];
        let levelFeedWater = data.map(item => item.LevelFeedWater) || [];
        let feedPressure = data.map(item => item.FeedPressure) || [];
        let pvSteam = data.map(item => item.PVSteam) || [];
        let lhTemp = data.map(item => item.LHTemp) || [];
        let rhTemp = data.map(item => item.RHTemp) || [];
        let suhuFeedTank = data.map(item => item.SuhuFeedTank) || [];
        let o2 = data.map(item => item.O2) || [];
        let co2 = data.map(item => item.CO2) || [];
        let idFan = data.map(item => item.IDFan) || [];
        let lhFDFan = data.map(item => item.LHFDFan) || [];
        let rhFDFan = data.map(item => item.RHFDFan) || [];
        let lhStoker = data.map(item => item.LHStoker) || [];
        let rhStoker = data.map(item => item.RHStoker) || [];
        let inletFlow = data.map(item => item.InletWaterFlow) || [];
        let outletFlow = data.map(item => item.OutletSteamFlow) || [];
        let batubaraFK = data.map(item => item.Batubara_FK) || [];
        let steamFK = data.map(item => item.Steam_FK) || [];

        let chartOptions = (series, title, type = "line") => ({
            chart: {
                type,
                height: 300
            },
            series,
            xaxis: {
                categories: waktu,
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

        let chart1 = new ApexCharts($("#chart-water-pressure")[0], chartOptions([
            { name: "Feed Water Level (%)", data: levelFeedWater },
            { name: "Feed Pressure (bar)", data: feedPressure },
            { name: "Steam Pressure (bar)", data: pvSteam }
        ], "Tekanan & Level"));
        chart1.render();
        chartInstances.push(chart1);

        let chart2 = new ApexCharts($("#chart-temp-gas")[0], chartOptions([
            { name: "LH Temperature (°C)", data: lhTemp },
            { name: "RH Temperature (°C)", data: rhTemp },
            { name: "Feed Tank Temperature (°C)", data: suhuFeedTank },
            { name: "Oxygen (O2) (%)", data: o2 },
            { name: "Carbon Dioxide (CO2) (%)", data: co2 }
        ], "Temperatur & Gas"));
        chart2.render();
        chartInstances.push(chart2);

        let chart3 = new ApexCharts($("#chart-fan-stoker")[0], chartOptions([
            { name: "ID Fan (Hz)", data: idFan },
            { name: "LH FD Fan (Hz)", data: lhFDFan },
            { name: "RH FD Fan (Hz)", data: rhFDFan },
            { name: "LH Stoker (Hz)", data: lhStoker },
            { name: "RH Stoker (Hz)", data: rhStoker }
        ], "Frekuensi Fan & Stoker (Hz)", "bar"));
        chart3.render();
        chartInstances.push(chart3);

        let chart4 = new ApexCharts($("#chart-flow-fuel")[0], chartOptions([
            { name: "Inlet Water Flow (m³/h)", data: inletFlow },
            { name: "Outlet Steam Flow (ton/h)", data: outletFlow },
            { name: "Coal Consumption (kg/h)", data: batubaraFK },
            { name: "Steam Production (ton/h)", data: steamFK }
        ], "Flow & Fuel Usage", "area"));
        chart4.render();
        chartInstances.push(chart4);
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
            getBoilerData("/sensor/boiler-data");
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
            getBoilerData("/sensor/boiler/data-harian", { tanggal: tanggal });
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
            getBoilerData("/sensor/boiler/data-mingguan", {
                tanggal_mulai: tanggalMulai,
                tanggal_selesai: tanggalSelesai
            });
        }
    });

    // Jalankan pertama kali dengan data normal
    getBoilerData("{{ url('/sensor/boiler-data') }}");
});

</script>
@endsection