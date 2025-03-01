@extends('layout')
@section('dynamic_url', 'st53/realtime-tankA')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">ST53 Monitoring</h4>
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
                        <h4 class="card-title">Tank A</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tank-a"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tank B</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tank-b"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tank C</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tank-c"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tank D</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-tank-d"></div>
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
        function getst53data() {
            $.ajax({
                url: "{{ url('/st53/data') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching st53 data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            //  Tank A
            let TankA1 = data.map(item => item.A1);
            let TankA2 = data.map(item => item.A2);
            let TankA3 = data.map(item => item.A3);
            let TankA4 = data.map(item => item.A4);
            //  Tank B
            let TankB1 = data.map(item => item.B1);
            let TankB2 = data.map(item => item.B2);
            let TankB3 = data.map(item => item.B3);
            let TankB4 = data.map(item => item.B4);
            //  Tank C
            let TankC1 = data.map(item => item.C1);
            let TankC2 = data.map(item => item.C2);
            let TankC3 = data.map(item => item.C3);
            let TankC4 = data.map(item => item.C4);
            //  Tank D
            let TankD1 = data.map(item => item.D1);
            let TankD2 = data.map(item => item.D2);
            let TankD3 = data.map(item => item.D3);
            let TankD4 = data.map(item => item.D4);

           
            // 🔹 Grafik Tank A
            new ApexCharts($("#chart-tank-a")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Tank A 1 ",
                        data: TankA1
                    },
                    {
                        name: "Tank A 2 ",
                        data: TankA2
                    },
                    {
                        name: "Tank A 3 ",
                        data: TankA3
                    },
                    {
                        name: "Tank A 4 ",
                        data: TankA4
                    },
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                }, markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "Tank A"
                    }
                }
            }).render();


            // Tank B
            new ApexCharts($("#chart-tank-b")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Tank B 1 ",
                        data: TankB1
                    },
                    {
                        name: "Tank B 2 ",
                        data: TankB2
                    },
                    {
                        name: "Tank B 3 ",
                        data: TankB3
                    },
                    {
                        name: "Tank B 4 ",
                        data: TankB4
                    },
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                }, markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "Tank B"
                    }
                }
            }).render();

            // Tank C
            new ApexCharts($("#chart-tank-c")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Tank C 1 ",
                        data: TankC1
                    },
                    {
                        name: "Tank C 2 ",
                        data: TankC2
                    },
                    {
                        name: "Tank C 3 ",
                        data: TankC3
                    },
                    {
                        name: "Tank C 4 ",
                        data: TankC4
                    },
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                }, markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "Tank C"
                    }
                }
            }).render();


            // Tank D
            new ApexCharts($("#chart-tank-d")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Tank D 1 ",
                        data: TankD1
                    },
                    {
                        name: "Tank D 2 ",
                        data: TankD2
                    },
                    {
                        name: "Tank D 3 ",
                        data: TankD3
                    },
                    {
                        name: "Tank D 4 ",
                        data: TankD4
                    },
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                }, markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "Tank D"
                    }
                }
            }).render();
         

        }

        getst53data();
    });
</script>


@endsection