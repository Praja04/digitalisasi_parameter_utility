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
        let chartSuhu, chartPompa, chartTekanan, chartLevel, chartMV;

        function getData() {
            $.ajax({
                url: "{{ url('/pasteurisasi2/data') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function initCharts(waktu, suhuPreheating, suhuHeating, suhuHolding, suhuPrecooling, suhuCooling, speedPompaMixing, speedPumpBT1, speedPumpVD, speedPumpBT2, pressureMixing, pressureBT2, levelBT1, levelVD, levelBT2, flowrateAM, flowrate, mv1, mv2) {
            // 🔹 Inisialisasi Chart Suhu
            chartSuhu = new ApexCharts(document.querySelector("#chart-suhu"), {
                series: [
                    { name: "Suhu Preheating", data: suhuPreheating },
                    { name: "Suhu Heating", data: suhuHeating },
                    { name: "Suhu Holding", data: suhuHolding },
                    { name: "Suhu Precooling", data: suhuPrecooling },
                    { name: "Suhu Cooling", data: suhuCooling }
                ],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: waktu },
                stroke: { curve: 'smooth' },
                title: { text: 'Tren Suhu' }
            });
            chartSuhu.render();

            // 🔹 Chart Pompa & Kecepatan
            chartPompa = new ApexCharts(document.querySelector("#chart-pompa"), {
                series: [
                    { name: "Speed Pompa Mixing", data: speedPompaMixing },
                    { name: "Speed Pump BT1", data: speedPumpBT1 },
                    { name: "Speed Pump VD", data: speedPumpVD },
                    { name: "Speed Pump BT2", data: speedPumpBT2 }
                ],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: waktu },
                stroke: { curve: 'smooth' },
                title: { text: 'Pompa & Kecepatan' }
            });
            chartPompa.render();

            // 🔹 Chart Tekanan
            chartTekanan = new ApexCharts(document.querySelector("#chart-tekanan"), {
                series: [
                    { name: "Pressure Mixing", data: pressureMixing },
                    { name: "Pressure BT2", data: pressureBT2 }
                ],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: waktu },
                stroke: { curve: 'smooth' },
                title: { text: 'Tekanan (Pressure)' }
            });
            chartTekanan.render();

            // 🔹 Chart Level & Flowrate
            chartLevel = new ApexCharts(document.querySelector("#chart-level"), {
                series: [
                    { name: "Level BT1", data: levelBT1 },
                    { name: "Level VD", data: levelVD },
                    { name: "Level BT2", data: levelBT2 },
                    { name: "Flowrate AM", data: flowrateAM },
                    { name: "Flowrate", data: flowrate }
                ],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: waktu },
                stroke: { curve: 'smooth' },
                title: { text: 'Level & Flowrate' }
            });
            chartLevel.render();

            // 🔹 Chart Motor Valve Control
            chartMV = new ApexCharts(document.querySelector("#chart-mv"), {
                series: [
                    { name: "MV1", data: mv1 },
                    { name: "MV2", data: mv2 }
                ],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: waktu },
                stroke: { curve: 'smooth' },
                title: { text: 'Motor Valve Control' }
            });
            chartMV.render();
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            // 🔹 Ambil Data untuk Grafik
            let suhuPreheating = data.map(item => item.SuhuPreheating);
            let suhuHeating = data.map(item => item.SuhuHeating);
            let suhuHolding = data.map(item => item.SuhuHolding);
            let suhuPrecooling = data.map(item => item.SuhuPrecooling);
            let suhuCooling = data.map(item => item.SuhuCooling);
            let speedPompaMixing = data.map(item => item.SpeedPompaMixing);
            let speedPumpBT1 = data.map(item => item.SpeedPumpBT1);
            let speedPumpVD = data.map(item => item.SpeedPumpVD);
            let speedPumpBT2 = data.map(item => item.SpeedPumpBT2);
            let pressureMixing = data.map(item => item.PressureMixing);
            let pressureBT2 = data.map(item => item.PressureBT2);
            let levelBT1 = data.map(item => item.LevelBT1);
            let levelVD = data.map(item => item.LevelVD);
            let levelBT2 = data.map(item => item.LevelBT2);
            let flowrateAM = data.map(item => item.FlowrateAM);
            let flowrate = data.map(item => item.Flowrate);
            let mv1 = data.map(item => item.MV1);
            let mv2 = data.map(item => item.MV2);

            if (!chartSuhu) {
                initCharts(waktu, suhuPreheating, suhuHeating, suhuHolding, suhuPrecooling, suhuCooling, speedPompaMixing, speedPumpBT1, speedPumpVD, speedPumpBT2, pressureMixing, pressureBT2, levelBT1, levelVD, levelBT2, flowrateAM, flowrate, mv1, mv2);
            } else {
                // 🔹 Update Data Grafik Tanpa Render Ulang
                chartSuhu.updateSeries([
                    { name: "Suhu Preheating", data: suhuPreheating },
                    { name: "Suhu Heating", data: suhuHeating },
                    { name: "Suhu Holding", data: suhuHolding },
                    { name: "Suhu Precooling", data: suhuPrecooling },
                    { name: "Suhu Cooling", data: suhuCooling }
                ]);

                chartPompa.updateSeries([
                    { name: "Speed Pompa Mixing", data: speedPompaMixing },
                    { name: "Speed Pump BT1", data: speedPumpBT1 },
                    { name: "Speed Pump VD", data: speedPumpVD },
                    { name: "Speed Pump BT2", data: speedPumpBT2 }
                ]);

                chartTekanan.updateSeries([
                    { name: "Pressure Mixing", data: pressureMixing },
                    { name: "Pressure BT2", data: pressureBT2 }
                ]);

                chartLevel.updateSeries([
                    { name: "Level BT1", data: levelBT1 },
                    { name: "Level VD", data: levelVD },
                    { name: "Level BT2", data: levelBT2 },
                    { name: "Flowrate AM", data: flowrateAM },
                    { name: "Flowrate", data: flowrate }
                ]);

                chartMV.updateSeries([
                    { name: "MV1", data: mv1 },
                    { name: "MV2", data: mv2 }
                ]);
            }
        }

        // 🔄 Panggil fungsi pertama kali & set interval update data
        getData();
        setInterval(getData, 5000);
    });
</script>




@endsection