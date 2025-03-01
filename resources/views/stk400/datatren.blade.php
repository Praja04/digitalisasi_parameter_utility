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
        function getstk400data() {
            $.ajax({
                url: "{{ url('/stk400/data') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let data = response.data.reverse();
                        updateCharts(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching stk400 data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            //  Temperature
            let TankGlucose = data.map(item => item.Tank_Glucose);
            let Flowrate = data.map(item => item.Flowrate);
            

           
            // 🔹 Grafik Level & Tekanan Air
            new ApexCharts($("#chart-tank-glucose")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Tank Glucose",
                        data: TankGlucose
                    }
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
                        text: "Tank Glucose"
                    }
                }
            }).render();


            new ApexCharts($("#chart-flowrate")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [
                    {
                        name: "Flowrate ",
                        data: Flowrate
                      }
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
                        text: "Flowrate"
                    }
                }
            }).render();

        }

        getstk400data();
    });
</script>


@endsection