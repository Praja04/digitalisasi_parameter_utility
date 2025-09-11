@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Produksi - Pasteurisasi Line 2</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Produksi
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Welcome ,{{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <form action="javascript:void(0);">
                            <div class="row g-3 mb-0 align-items-center">
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input id="shift" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>

                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input id="date-picker" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->


                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex justify-content-start align-items-center flex-wrap">
                    <div class="me-2">
                        <select id="filter" class="form-control">
                            <option value="today" selected>Hari Ini</option>
                            <option value="date">Pilih Tanggal</option>
                            <option value="range">Rentang Tanggal</option>
                        </select>
                    </div>
                    <div class="me-2 d-none" id="start-date-group">
                        <input type="date" id="start-date" class="form-control" />
                    </div>
                    <div class="me-2 d-none" id="end-date-group">
                        <input type="date" id="end-date" class="form-control" />
                    </div>
                    <div>
                        <button class="btn btn-primary" id="apply-filter">Terapkan</button>
                    </div>
                </div><br>
                <div class="card crm-widget">
                    <div class="card-body p-0">

                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Batch
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_batch" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Shift 1

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_batch_shift1" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Shift 2

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_batch_shift2" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Shift 3

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">

                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_batch_shift3" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">

                        <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">

                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievement rate output batch

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="achievement_output_batch" data-target="">0</span>%
                                            </h2>
                                            <p>Target PPIC : <span id="target_batch"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievement kecap matang

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-pulse-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="">0</span>%
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievemnet quality

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-trophy-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="">0</span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>


        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Speed Pompa Mixing
                                    </h5>
                                    <div id="gauge_chart_pompa_mixing"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Speed Pompa Bt1

                                    </h5>
                                    <div id="gauge_chart_bt1"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13 text-center">
                                        Status Running (NOW)
                                    </h5>
                                    <div class="card-body">

                                        <div class="table-responsive mt-3">
                                            <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                                                <tbody class="border-0">
                                                    <tr>
                                                        <td>
                                                            <h4 class="text-truncate fs-10 fs-medium mb-0">Mode</h4>
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            <p class="text-muted fs-10 mb-0" id="mode_status_running"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h4 class="text-truncate fs-10 fs-medium mb-0">Storage</h4>
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            <p class="text-muted fs-10 mb-0" id="storage_status_running"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h4 class="text-truncate fs-10 fs-medium mb-0">Varian</h4>
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            <p class="text-muted fs-10 mb-0" id="varian_status_running"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h4 class="text-truncate fs-10 fs-medium mb-0">Batch</h4>
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            <p class="text-muted fs-10 mb-0" id="batch_status_running"></p>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Speed Pompa Bt2

                                    </h5>
                                    <div id="gauge_chart_bt2"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Speed Pompa VD

                                    </h5>
                                    <div id="gauge_chart_vd"></div>
                                </div>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex flex-column h-100">
                    <div class="row">
                        <div class="col-xl-4 col-md-3">
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="suhuholding">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-info);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                Suhu Holding Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="suhuholding_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!--end col-->
                        <div class="col-xl-4 col-md-3">
                            <!-- card -->
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="suhuheating">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-info);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                Suhu Heating Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="suhuheating_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-4 col-md-3">
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="flowrate">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-info);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                Flowrate Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="flowrate_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end col-->

            <!--end col-->
        </div>



        <div class="row">
            <div class="col-xxl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Suhu
                        </h4>
                        <div class="d-flex gap-2">
                            <select id="filterData" class="form-select form-select-sm w-auto">
                                <option value="latest">Terbaru</option>
                                <option value="daily">Per Hari</option>
                                <option value="weekly">Per Minggu</option>
                            </select>
                            <input type="date" id="datePicker" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="startDate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="endDate" class="form-control form-control-sm w-auto d-none">
                            <button id="applyFilter" class="btn btn-primary btn-sm">Terapkan</button>
                        </div>

                    </div>
                    <!-- end card header -->
                    <div class="card-body px-0">


                        <div id="ccp_chart"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xxl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Flowrate
                        </h4>
                        <div class="d-flex gap-2">
                            <select id="filterDataFlowrate" class="form-select form-select-sm w-auto">
                                <option value="latest">Terbaru</option>
                                <option value="daily">Per Hari</option>
                                <option value="weekly">Per Minggu</option>
                            </select>
                            <input type="date" id="datePickerFlowrate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="startDateFlowrate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="endDateFlowrate" class="form-control form-control-sm w-auto d-none">
                            <button id="applyFilterFlowrate" class="btn btn-primary btn-sm">Terapkan</button>
                        </div>

                    </div>
                    <!-- end card header -->
                    <div class="card-body px-0">


                        <div id="flowrate_chart"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->




            <!-- end col -->


        </div>




        <div class="modal fade" id="abnormalModal" tabindex="-1" aria-labelledby="abnormalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="abnormalModalLabel">Detail Abnormal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" id="abnormalModalBody">
                        <!-- Data detail akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


<!-- Dashboard init -->


<script>
    $(document).ready(function() {
        let charts = {
            main: null,
            flowrate: null,
            gauges: {
                mixing: null,
                BT1: null,
                BT2: null,
                VD: null
            }
        };

        function fetchData(url, params = {}) {
            return $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json"
            });
        }

        function showWarning(title, text) {
            Swal.fire({
                icon: "warning",
                title,
                text
            });
        }

        function updateChart(selector, config, chartInstance) {
            if (chartInstance) {
                chartInstance.updateOptions(config, false, true); // animate enabled
                return chartInstance;
            } else {
                const chart = new ApexCharts(document.querySelector(selector), config);
                chart.render();
                return chart;
            }
        }

        function createLineChartOptions(data, seriesArray, colors, yAxisTitle) {
            const categories = data.map(item => item.waktu);
            return {
                chart: {
                    type: "line",
                    height: 350,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series: seriesArray,
                colors,
                xaxis: {
                    categories,
                    title: {
                        text: "waktu"
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: yAxisTitle
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM HH:mm"
                    }
                }
            };
        }

        function updateChartSuhu(data) {
            console.log("Update Suhu:", data); // cek isi array
            console.log("waktu Series:", data.map(item => item.waktu));

            if (data.length === 0) {
                if (charts.main) charts.main.updateSeries([{
                    data: []
                }, {
                    data: []
                }], true);
                return showWarning("Data Tidak Ditemukan", "Tidak ada data suhu untuk rentang waktu yang dipilih.");
            }

            const series = [{
                    name: "Suhu Heating",
                    data: data.map(item => item.SuhuHeating)
                },
                {
                    name: "Suhu Holding",
                    data: data.map(item => item.SuhuHolding)
                }
            ];
            const colors = ["#0acf97", "#fa5c7c"];

            const options = createLineChartOptions(data, series, colors, "CCP");

            charts.main = updateChart("#ccp_chart", options, charts.main);
        }

        function updateChartFlowrate(data) {
            if (data.length === 0) {
                if (charts.flowrate) charts.flowrate.updateSeries([{
                    data: []
                }], true);
                return showWarning("Data Tidak Ditemukan", "Tidak ada data flowrate untuk rentang waktu yang dipilih.");
            }

            const series = [{
                name: "Flowrate",
                data: data.map(item => item.Flowrate)
            }];
            const colors = ["#39afd1"];

            const options = createLineChartOptions(data, series, colors, "Flowrate");

            charts.flowrate = updateChart("#flowrate_chart", options, charts.flowrate);
        }

        function createGaugeOptions(value) {
            return {
                chart: {
                    height: 150,
                    type: "radialBar",
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 50
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    toolbar: {
                        show: false
                    }
                },
                series: [parseFloat(value)],
                labels: [""],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: "50%"
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: "16px"
                            }
                        }
                    }
                },
                colors: ["#00E396"]
            };
        }

        function updateGaugeChart(value) {
            charts.gauges.mixing = updateChart("#gauge_chart_pompa_mixing", createGaugeOptions(value.SpeedPompaMixing), charts.gauges.mixing);
            charts.gauges.BT1 = updateChart("#gauge_chart_bt1", createGaugeOptions(value.SpeedPumpBT1), charts.gauges.BT1);
            charts.gauges.BT2 = updateChart("#gauge_chart_bt2", createGaugeOptions(value.SpeedPumpBT2), charts.gauges.BT2);
            charts.gauges.VD = updateChart("#gauge_chart_vd", createGaugeOptions(value.SpeedPumpVD), charts.gauges.VD);
        }

        function updateInputFields(prefix = "") {
            const filter = $(`#filterData${prefix}`).val();
            $(`#datePicker${prefix}, #startDate${prefix}, #endDate${prefix}`).addClass("d-none");

            if (filter === "daily") {
                $(`#datePicker${prefix}`).removeClass("d-none");
            } else if (filter === "weekly") {
                $(`#startDate${prefix}, #endDate${prefix}`).removeClass("d-none");
            }
        }

        function handleFilterClick(prefix = "") {
            const filter = $(`#filterData${prefix}`).val();
            let url = "",
                params = {};

            if (filter === "latest") {
                url = "{{ url('pasteurisasi2/data') }}";
            } else if (filter === "daily") {
                const selectedDate = $(`#datePicker${prefix}`).val();
                if (!selectedDate) return showWarning("Pilih Tanggal!", "Harap pilih tanggal terlebih dahulu.");
                url = "{{ url('pasteurisasi2/data-harian') }}";
                params = {
                    tanggal: selectedDate
                };
            } else if (filter === "weekly") {
                const start = $(`#startDate${prefix}`).val(),
                    end = $(`#endDate${prefix}`).val();
                if (!start || !end) return showWarning("Pilih Rentang Tanggal!", "Harap lengkapi tanggal mulai dan selesai.");
                url = "{{ url('pasteurisasi2/data-mingguan') }}";
                params = {
                    tanggal_mulai: start,
                    tanggal_selesai: end
                };
            }

            fetchData(url, params).done(res => {
                if (prefix === "") {
                    res.success ? updateChartSuhu(res.data) : updateChartSuhu([]);
                } else {
                    res.success ? updateChartFlowrate(res.data) : updateChartFlowrate([]);
                }
            });
        }

        function updateRealtimeInfo() {
            fetchData("{{ url('pasteurisasi2/data-realtime') }}").done(res => {
                if (res.SpeedPompaMixing !== undefined && res.SpeedPompaMixing !== null) {
                    updateGaugeChart(res);
                }
            }).fail(handleAjaxError);

            fetchData("{{ url('prd/data/status-running/pasteurisasi2') }}").done(res => {
                $('#varian_status_running').text(res.varian);
                $('#mode_status_running').text(res.mode);
                $('#batch_status_running').text(res.batch);
                $('#storage_status_running').text(res.storage);
            }).fail(handleAjaxError);
        }

        function handleAjaxError(_xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }

        function getShift(now) {
            let hours = now.getHours();
            let minutes = now.getMinutes();

            if ((hours === 6 && minutes >= 1) || (hours > 6 && hours < 14) || (hours === 14 && minutes === 0)) {
                return "Shift 1";
            } else if ((hours === 14 && minutes >= 1) || (hours > 14 && hours < 22) || (hours === 22 && minutes === 0)) {
                return "Shift 2";
            } else {
                return "Shift 3"; // Dari jam 22:01 sampai 06:00 keesokan harinya
            }
        }

        function updateDateTime() {
            let now = new Date();
            let formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });

            let shift = getShift(now);
            $('#date-picker').val(formattedDate);
            $('#shift').val(shift);
        }

        function fetchDataAbnormal(filter = 'today', start = '', end = '') {
            const endpoints = [{
                    url: '{{ url("pasteurisasi2/suhuholding") }}',
                    target: '#suhuholding_abnormal'
                },
                {
                    url: '{{ url("pasteurisasi2/suhuheating") }}',
                    target: '#suhuheating_abnormal'
                },
                {
                    url: '{{ url("pasteurisasi2/flowrate") }}',
                    target: '#flowrate_abnormal'
                }
            ];

            endpoints.forEach(endpoint => {
                fetchData(endpoint.url, {
                        filter,
                        start,
                        end
                    })
                    .done(res => {
                        $(endpoint.target).text(res.total).attr('data-target', res.total);
                    })
                    .fail(() => {
                        alert(`Gagal mengambil data dari ${endpoint.url}.`);
                    });
            });
        }

        $('.abnormal-card').on('click', function() {
            const type = $(this).data('type');
            fetchData(`{{ url("pasteurisasi1") }}/${type}`, {
                filter: $('#filter').val(),
                start: $('#start-date').val(),
                end: $('#end-date').val()
            }).done(res => {
                let html = `<p>Total: <strong>${res.total}</strong></p>`;
                if (res.data && Array.isArray(res.data)) {
                    html += '<ul class="list-group">';
                    res.data.forEach(item => {
                        html += `
                            <li class="list-group-item">
                                <strong>waktu Mulai:</strong> ${item.waktu_mulai}<br>
                                <strong>waktu Akhir:</strong> ${item.waktu_akhir}
                            </li>
                        `;
                    });
                    html += '</ul>';
                }
                $('#abnormalModalBody').html(html);
                $('#abnormalModal').modal('show');
            }).fail(() => {
                alert('Gagal mengambil detail data!');
            });
        });

        function fetchAchievement(filter = 'today', startDate = null, endDate = null) {
            fetchData("{{url('/prd/achievement')}}", {
                    filter,
                    start_date: startDate,
                    end_date: endDate
                })
                .done(res => {
                    $('#output_batch').attr('data-target', res.total_batch_count).text(res.total_batch_count + ' ton');
                    $('#output_batch_shift1').attr('data-target', res.shift_counts.shift_1).text(res.shift_counts.shift_1 + ' ton');
                    $('#output_batch_shift2').attr('data-target', res.shift_counts.shift_2).text(res.shift_counts.shift_2 + ' ton');
                    $('#output_batch_shift3').attr('data-target', res.shift_counts.shift_3).text(res.shift_counts.shift_3 + ' ton');
                    $('#achievement_output_batch').attr('data-target', res.achievement_percentage).text(res.achievement_percentage);
                    $('#target_batch').text(res.total_target_batch + ' ton');
                })
                .fail(xhr => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengambil data. Coba lagi nanti.',
                    });
                    console.error(xhr.responseText);
                });
        }

        $('#filter').on('change', function() {
            const selected = $(this).val();
            $('#start-date-group, #end-date-group').addClass('d-none');

            if (selected === 'date') {
                $('#start-date-group').removeClass('d-none');
            } else if (selected === 'range') {
                $('#start-date-group, #end-date-group').removeClass('d-none');
            }
        });

        $('#apply-filter').on('click', function() {
            const filter = $('#filter').val();
            const start = $('#start-date').val();
            const end = $('#end-date').val();
            fetchDataAbnormal(filter, start, end);

            let startDate = null;
            let endDate = null;

            if (filter === 'date') {
                startDate = $('#start-date').val();
            } else if (filter === 'range') {
                startDate = $('#start-date').val();
                endDate = $('#end-date').val();
            }

            // fetchAchievement(filter, startDate, endDate);
        });

        // Initialization
        updateInputFields();
        updateInputFields("Flowrate");

        $("#filterData, #filterDataFlowrate").on("change", function() {
            const id = $(this).attr("id");
            const prefix = id.includes("Flowrate") ? "Flowrate" : "";
            updateInputFields(prefix);
        });

        $("#applyFilter").on("click", () => handleFilterClick());
        $("#applyFilterFlowrate").on("click", () => handleFilterClick("Flowrate"));

        // Load initial data
        $("#applyFilter").trigger("click");
        $("#applyFilterFlowrate").trigger("click");
        fetchDataAbnormal();
        updateDateTime();
        updateRealtimeInfo();
        setInterval(updateRealtimeInfo, 10000);
        // fetchAchievement();
    });
</script>





@endsection