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

<script>
    $(document).ready(function() {
        function getBoilerData() {
            $.ajax({
                url: "{{ url('/sensor/boiler-data') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching boiler data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            // 📌 Data Level & Tekanan Air
            let levelFeedWater = data.map(item => item.LevelFeedWater);
            let feedPressure = data.map(item => item.FeedPressure);
            let pvSteam = data.map(item => item.PVSteam);

            // 📌 Data Temperatur & Gas
            let lhTemp = data.map(item => item.LHTemp);
            let rhTemp = data.map(item => item.RHTemp);
            let suhuFeedTank = data.map(item => item.SuhuFeedTank);
            let o2 = data.map(item => item.O2);
            let co2 = data.map(item => item.CO2);

            // 📌 Data Fan & Stoker
            let idFan = data.map(item => item.IDFan);
            let lhFDFan = data.map(item => item.LHFDFan);
            let rhFDFan = data.map(item => item.RHFDFan);
            let lhStoker = data.map(item => item.LHStoker);
            let rhStoker = data.map(item => item.RHStoker);

            // 📌 Data Flow & Fuel
            let inletFlow = data.map(item => item.InletWaterFlow);
            let outletFlow = data.map(item => item.OutletSteamFlow);
            let batubaraFK = data.map(item => item.Batubara_FK);
            let steamFK = data.map(item => item.Steam_FK);

            // 🔹 Grafik Level & Tekanan Air
            new ApexCharts($("#chart-water-pressure")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
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
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X
                 
                },
                yaxis: {
                    title: {
                        text: "Tekanan & Level"
                    }
                }
            }).render();

            // 🔹 Grafik Temperatur & Gas
            new ApexCharts($("#chart-temp-gas")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
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
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X
                 
                },
                yaxis: {
                    title: {
                        text: "Temperatur & Gas"
                    }
                }
            }).render();

            // 🔹 Grafik Fan & Stoker
            new ApexCharts($("#chart-fan-stoker")[0], {
                chart: {
                    type: "bar",
                    height: 300
                },
                series: [{
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
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X
                 
                },
                yaxis: {
                    title: {
                        text: "Frekuensi Fan & Stoker (Hz)"
                    }
                }
            }).render();

            // 🔹 Grafik Flow Rate & Bahan Bakar
            new ApexCharts($("#chart-flow-fuel")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [{
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
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X
                 
                },
                yaxis: {
                    title: {
                        text: "Flow & Fuel Usage"
                    }
                }
            }).render();
        }

        getBoilerData();
    });
</script>


@endsection