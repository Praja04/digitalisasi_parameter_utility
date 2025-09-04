@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Engineering</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Engineering
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
                                <!--end col-->
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input style="font-size: 24px; width: 200px; height: 50px;" id="PV-bar" type="text" class="text-center form-control border-0 dash-filter-picker shadow " disabled>
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <h5 class="text-white">PV</h5>
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

        <div class="row mb-6 ">
            <div class="d-flex justify-content-end align-items-center flex-wrap">
                <div class="me-2">
                    <select id="filter_abnormal" class="form-control">
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
                    <button class="btn btn-primary" id="apply-filter-abnormal">Terapkan</button>
                </div>
            </div>
        </div>
        <br>


        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex flex-column h-100">
                    <div class="row">
                        <div class="col-xl-3 col-md-3">
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="rhtemp">
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
                                                RH Temp Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="rhtemp_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!--end col-->
                        <div class="col-xl-3 col-md-3">
                            <!-- card -->
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="lhtemp">
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
                                                LH Temp Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="lhtemp_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-3 col-md-3">
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="pvsteam">
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
                                                PV Steam Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="pvsteam_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!--end col-->
                        <div class="col-xl-3 col-md-3">
                            <!-- card -->
                            <div class="card card-animate overflow-hidden abnormal-card" data-type="levelfeed">
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
                                                Level Feed Water Abnormal
                                            </p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" id="levelfeed_abnormal" data-target=""></span>
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end col-->

            <!--end col-->
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-6 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LevelFeedWater
                                    </h5>
                                    <div id="gauge_chart_levelfeedwater"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        FeedPressure

                                    </h5>
                                    <div id="gauge_chart_feedpressure"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        SuhuFeedTank

                                    </h5>
                                    <div id="gauge_chart_suhufeedtank"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHTemp

                                    </h5>
                                    <div id="gauge_chart_lhtemp"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHTemp

                                    </h5>
                                    <div id="gauge_chart_rhtemp"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        IDFan

                                    </h5>
                                    <div id="gauge_chart_idfan"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHGuiloutine

                                    </h5>
                                    <div id="gauge_chart_lhguiloutine"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHGuiloutine

                                    </h5>
                                    <div id="gauge_chart_rhguiloutine"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHFDFan

                                    </h5>
                                    <div id="gauge_chart_lhfdfan"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHStoker

                                    </h5>
                                    <div id="gauge_chart_lhstoker"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHStoker

                                    </h5>
                                    <div id="gauge_chart_rhstoker"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        InletWaterFlow

                                    </h5>
                                    <div id="gauge_chart_inletwaterflow"></div>
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


            <div class="col-xxl-12 order-xxl-0 order-first">

                <div class="d-flex flex-column h-900">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Sensor Boiler Chart</h4>
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
                                <div class="card-body p-0 pb-3">
                                    <div id="boiler_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>



            <!-- end col -->
        </div>
        <!-- end row -->



        <div class="row">
            <div class="col-xl-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Sensor Kondensat Chart</h4>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <input type="date" id="condensate-startDate" class="form-control form-control-sm" />
                                <input type="date" id="condensate-endDate" class="form-control form-control-sm" />
                                <button id="loadChart" class="btn btn-sm btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="condensat_chart" class="apex-charts" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
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

        <!-- container-fluid -->
    </div>
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Configuration
        const CONFIG = {
            REFRESH_INTERVAL: 3000,
            PV_THRESHOLDS: {
                HIGH: 7,
                MEDIUM: 6
            }
        };

        // Global state
        let charts = {
            main: null,
            compressor: null,
            condensate: null,
            gauges: {}
        };
        let updateInterval = null;

        // Utility functions
        function showAlert(type, title, text) {
            Swal.fire({
                icon: type,
                title,
                text
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function formatDate(date) {
            return new Date(date).toISOString().split('T')[0];
        }

        // Gauge chart options
        function createGaugeOptions(value) {
            return {
                chart: {
                    height: 150,
                    type: 'radialBar'
                },
                series: [parseFloat(value) || 0],
                labels: [''],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                formatter: (val) => parseFloat(val).toFixed(2)
                            }
                        }
                    }
                },
                colors: ['#00E396']
            };
        }

        // Update or create gauge chart
        function updateGaugeChart(selector, value, key) {
            const options = createGaugeOptions(value);
            const element = document.querySelector(selector);

            if (!element) return;

            if (charts.gauges[key]) {
                charts.gauges[key].updateOptions(options);
            } else {
                charts.gauges[key] = new ApexCharts(element, options);
                charts.gauges[key].render();
            }
        }

        // Update all gauge charts
        function updateAllGauges(data) {
            const gaugeMapping = {
                levelfeedwater: data.LevelFeedWater,
                feedpressure: data.FeedPressure,
                suhufeedtank: data.SuhuFeedTank,
                lhtemp: data.LHTemp,
                rhtemp: data.RHTemp,
                idfan: data.IDFan,
                lhguiloutine: data.LHGuiloutine,
                rhguiloutine: data.RHGuiloutine,
                lhfdfan: data.LHFDFan,
                lhstoker: data.LHStoker,
                rhstoker: data.RHStoker,
                inletwaterflow: data.InletWaterFlow
            };

            Object.entries(gaugeMapping).forEach(([key, value]) => {
                updateGaugeChart(`#gauge_chart_${key}`, value, key);
            });
        }

        // Update PV Steam and gauges
        async function updatePVSteam() {
            try {
                const response = await $.ajax({
                    url: "{{ url('sensor/boiler-realtime') }}",
                    type: 'GET',
                    dataType: 'json',
                    timeout: 10000
                });

                if (!response) return;

                const pvValue = parseFloat(response.PVSteam);
                const $pvInput = $('#PV-bar');

                $pvInput.val(`${response.PVSteam} Bar`);
                $pvInput.removeClass('bg-danger bg-warning bg-success text-white text-dark');

                if (pvValue > CONFIG.PV_THRESHOLDS.HIGH) {
                    $pvInput.addClass('bg-danger text-white');
                    sendTelegramNotification();
                } else if (pvValue > CONFIG.PV_THRESHOLDS.MEDIUM) {
                    $pvInput.addClass('bg-warning text-dark');
                } else {
                    $pvInput.addClass('bg-success text-white');
                }

                updateAllGauges(response);
            } catch (error) {
                console.error('Failed to update PV Steam:', error);
            }
        }

        // Debounced telegram notification
        const sendTelegramNotification = debounce(() => {
            $.ajax({
                url: "{{ url('eng/send/tele') }}",
                type: 'GET',
                dataType: 'json'
            }).fail(error => console.error('Telegram notification failed:', error));
        }, 30000);

        // Update main chart
        function updateMainChart(data) {
            if (!data || !data.length) {
                if (charts.main) {
                    charts.main.updateSeries([{
                        data: []
                    }]);
                }
                showAlert('warning', 'Data Tidak Ditemukan', 'Tidak ada data untuk rentang waktu yang dipilih.');
                return;
            }

            const options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                        name: 'Level Feed Water',
                        data: data.map(i => i.LevelFeedWater)
                    },
                    {
                        name: 'PV Steam',
                        data: data.map(i => i.PVSteam)
                    },
                    {
                        name: 'Batu Bara',
                        data: data.map(i => i.Batubara_FK)
                    }
                ],
                colors: ['#0acf97', '#fa5c7c', '#ffbc00'],
                xaxis: {
                    categories: data.map(i => i.waktu),
                    title: {
                        text: 'Waktu'
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Sensor Value'
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd MMM HH:mm'
                    }
                }
            };

            // Update or create main chart
            const mainElement = document.querySelector('#boiler_chart');
            if (mainElement) {
                if (charts.main) {
                    charts.main.updateOptions(options);
                } else {
                    charts.main = new ApexCharts(mainElement, options);
                    charts.main.render();
                }
            }

            // Update or create compressor chart
            const compressorElement = document.querySelector('#compresor_chart');
            if (compressorElement) {
                if (charts.compressor) {
                    charts.compressor.updateOptions(options);
                } else {
                    charts.compressor = new ApexCharts(compressorElement, options);
                    charts.compressor.render();
                }
            }
        }

        // Load boiler chart data
        async function loadBoilerChart() {
            const filter = $('#filterData').val();
            let url = '';
            let params = {};

            switch (filter) {
                case 'daily':
                    const date = $('#datePicker').val();
                    if (!date) {
                        showAlert('warning', 'Pilih Tanggal!', 'Harap pilih tanggal terlebih dahulu.');
                        return;
                    }
                    url = "{{ url('sensor/boiler/data-harian') }}";
                    params = {
                        tanggal: date
                    };
                    break;

                case 'weekly':
                    const start = $('#startDate').val();
                    const end = $('#endDate').val();
                    if (!start || !end) {
                        showAlert('warning', 'Pilih Rentang Tanggal!', 'Harap pilih tanggal mulai dan selesai.');
                        return;
                    }
                    url = "{{ url('sensor/boiler/data-mingguan') }}";
                    params = {
                        tanggal_mulai: start,
                        tanggal_selesai: end
                    };
                    break;

                default:
                    url = "{{ url('sensor/boiler-data') }}";
                    break;
            }

            try {
                const response = await $.ajax({
                    url: url,
                    type: 'GET',
                    data: params,
                    dataType: 'json',
                    timeout: 10000
                });

                if (response && response.success) {
                    updateMainChart(response.data);
                } else {
                    showAlert('warning', 'Data Tidak Ditemukan', 'Tidak ada data untuk rentang waktu yang dipilih.');
                }
            } catch (error) {
                console.error('Failed to load boiler chart:', error);
                showAlert('error', 'Error', 'Gagal mengambil data dari server');
            }
        }

        // Fetch abnormal data
        async function fetchAbnormalData(filter = 'today', start = '', end = '') {
            const abnormalTypes = [{
                    type: 'rhtemp',
                    element: 'rhtemp_abnormal'
                },
                {
                    type: 'lhtemp',
                    element: 'lhtemp_abnormal'
                },
                {
                    type: 'pvsteam',
                    element: 'pvsteam_abnormal'
                },
                {
                    type: 'levelfeedwater',
                    element: 'levelfeed_abnormal'
                }
            ];

            const promises = abnormalTypes.map(async ({
                type,
                element
            }) => {
                try {
                    const response = await $.ajax({
                        url: `{{ url('sensor') }}/${type}`,
                        type: 'GET',
                        data: {
                            filter,
                            start,
                            end
                        },
                        dataType: 'json',
                        timeout: 10000
                    });

                    if (response && response.total !== undefined) {
                        $(`#${element}`).text(response.total).attr('data-target', response.total);
                    }
                } catch (error) {
                    console.error(`Failed to fetch ${type} data:`, error);
                }
            });

            await Promise.allSettled(promises);
        }

        // Update condensate chart
        function updateCondensateChart(waktu, suhu1, suhu2, suhu3, suhu4, suhu5) {
            const options = {
                chart: {
                    type: 'line',
                    height: 400,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                        name: 'Suhu1',
                        data: suhu1
                    },
                    {
                        name: 'Suhu2',
                        data: suhu2
                    },
                    {
                        name: 'Suhu3',
                        data: suhu3
                    },
                    {
                        name: 'Suhu4',
                        data: suhu4
                    },
                    {
                        name: 'Suhu5',
                        data: suhu5
                    }
                ],
                xaxis: {
                    categories: waktu,
                    title: {
                        text: 'Waktu'
                    },
                    labels: {
                        rotate: -45
                    }
                },
                yaxis: {
                    title: {
                        text: 'Suhu (°C)'
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yyyy HH:mm:ss'
                    }
                },
                noData: {
                    text: 'Tidak ada data tersedia'
                }
            };

            const element = document.querySelector('#condensat_chart');
            if (!element) return;

            if (charts.condensate) {
                charts.condensate.updateOptions(options);
            } else {
                charts.condensate = new ApexCharts(element, options);
                charts.condensate.render();
            }
        }

        // Load condensate chart
        async function loadCondensateChart() {
            const start = $('#condensate-startDate').val();
            const end = $('#condensate-endDate').val();

            if (!start || !end) {
                showAlert('warning', 'Pilih Tanggal!', 'Harap pilih tanggal mulai dan akhir untuk chart kondensat.');
                return;
            }

            try {
                const response = await $.ajax({
                    url: '/boiler/kondensat/data',
                    type: 'GET',
                    data: {
                        start_date: start,
                        end_date: end
                    },
                    dataType: 'json',
                    timeout: 10000
                });

                if (response && response.data && response.data.length > 0) {
                    const {
                        data
                    } = response;
                    const waktu = data.map(item => item.waktu);
                    const suhu1 = data.map(item => item.Suhu1);
                    const suhu2 = data.map(item => item.Suhu2);
                    const suhu3 = data.map(item => item.Suhu3);
                    const suhu4 = data.map(item => item.Suhu4);
                    const suhu5 = data.map(item => item.Suhu5);

                    updateCondensateChart(waktu, suhu1, suhu2, suhu3, suhu4, suhu5);
                } else {
                    showAlert('warning', 'Data Tidak Ditemukan', 'Tidak ada data kondensat untuk rentang tanggal yang dipilih.');
                    updateCondensateChart([], [], [], [], [], []);
                }
            } catch (error) {
                console.error('Failed to load condensate chart:', error);
                showAlert('error', 'Error', 'Gagal mengambil data kondensat');
            }
        }

        // Show abnormal modal
        async function showAbnormalModal(type) {
            const filter = $('#filter_abnormal').val();
            const start = $('#start-date').val();
            const end = $('#end-date').val();

            try {
                const response = await $.ajax({
                    url: `{{ url('sensor') }}/${type}`,
                    type: 'GET',
                    data: {
                        filter,
                        start,
                        end
                    },
                    dataType: 'json',
                    timeout: 10000
                });

                if (response) {
                    let html = `<p>Total: <strong>${response.total}</strong></p>`;

                    if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                        html += '<ul class="list-group">';
                        response.data.forEach(item => {
                            html += `
                            <li class="list-group-item">
                                <strong>Waktu Mulai:</strong> ${item.waktu_mulai}<br>
                                <strong>Waktu Akhir:</strong> ${item.waktu_akhir}
                            </li>
                        `;
                        });
                        html += '</ul>';
                    }

                    $('#abnormalModalBody').html(html);
                    $('#abnormalModal').modal('show');
                }
            } catch (error) {
                console.error('Failed to fetch abnormal modal data:', error);
                showAlert('error', 'Error', 'Gagal mengambil detail data!');
            }
        }

        // Event handlers
        function initializeEventHandlers() {
            // Filter controls
            $('#filterData').on('change', function() {
                const filter = $(this).val();
                $('#datePicker, #startDate, #endDate').addClass('d-none');

                if (filter === 'daily') {
                    $('#datePicker').removeClass('d-none');
                } else if (filter === 'weekly') {
                    $('#startDate, #endDate').removeClass('d-none');
                }
            });

            $('#applyFilter').on('click', debounce(loadBoilerChart, 300));

            // Abnormal controls
            $('#filter_abnormal').on('change', function() {
                const val = $(this).val();
                const startGroup = $('#start-date-group');
                const endGroup = $('#end-date-group');

                startGroup.toggleClass('d-none', val === 'today');
                endGroup.toggleClass('d-none', val !== 'range');
            });

            $('#apply-filter-abnormal').on('click', function() {
                const filter = $('#filter_abnormal').val();
                const start = $('#start-date').val();
                const end = $('#end-date').val();
                fetchAbnormalData(filter, start, end);
            });

            $('.abnormal-card').on('click', function() {
                const type = $(this).data('type');
                showAbnormalModal(type);
            });

            // Condensate controls
            $('#loadChart').on('click', loadCondensateChart);
        }

        // Initialize
        function initialize() {
            // Set default dates for condensate chart
            const today = formatDate(new Date());
            $('#condensate-startDate, #condensate-endDate').val(today);

            // Initialize event handlers
            initializeEventHandlers();

            // Load initial data
            $('#filterData').trigger('change');
            $('#applyFilter').trigger('click');
            fetchAbnormalData();
            loadCondensateChart();

            // Start real-time updates
            updatePVSteam();
            updateInterval = setInterval(updatePVSteam, CONFIG.REFRESH_INTERVAL);
        }

        // Cleanup on page unload
        $(window).on('beforeunload', function() {
            if (updateInterval) {
                clearInterval(updateInterval);
            }

            Object.values(charts.gauges).forEach(chart => {
                if (chart && typeof chart.destroy === 'function') {
                    chart.destroy();
                }
            });

            [charts.main, charts.compressor, charts.condensate].forEach(chart => {
                if (chart && typeof chart.destroy === 'function') {
                    chart.destroy();
                }
            });
        });

        // Start the application
        initialize();
    });
</script>

@endsection