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
            <div class="col-xl-12 mt-3">
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
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->



        <div class="row">
            <div class="col-xl-12 mt-3">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Kondensat Chart</h4>
                        <div class="d-flex gap-2">
                            <input type="date" id="kondensatStart" class="form-control form-control-sm w-auto">
                            <input type="date" id="kondensatEnd" class="form-control form-control-sm w-auto">
                            <button id="applyKondensat" class="btn btn-primary btn-sm">Terapkan</button>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3">
                        <div id="kondensat_chart" class="apex-charts" dir="ltr"></div>
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
    </div>

    <!-- container-fluid -->
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let chart, chart_compresor;
        let gaugeCharts = {
            levelfeedwater: null,
            feedpressure: null,
            suhufeedtank: null,
            lhtemp: null,
            rhtemp: null,
            idfan: null,
            lhguiloutine: null,
            rhguiloutine: null,
            lhfdfan: null,
            lhstoker: null,
            rhstoker: null,
            inletwaterflow: null,
        };

        const gaugeOptions = (value) => ({
            chart: {
                height: 150,
                type: "radialBar"
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
                            fontSize: "16px",
                            formatter: function(val) {
                                return parseFloat(val).toFixed(2); // misal tampilkan 1 angka desimal
                            }
                        }
                    }
                }
            },
            colors: ["#00E396"]
        });

        const fetchData = (url, params = {}) =>
            $.ajax({
                url,
                type: "GET",
                data: params,
                dataType: "json"
            });

        const UpdateChartSensor = (data) => {
            if (!data.length) {
                chart?.updateSeries([{
                    data: []
                }]);
                Swal.fire({
                    icon: "warning",
                    title: "Data Tidak Ditemukan",
                    text: "Tidak ada data untuk rentang waktu yang dipilih."
                });
                return;
            }

            const categories = data.map(i => i.waktu);
            const series = [{
                    name: "Level Feed Water",
                    data: data.map(i => i.LevelFeedWater)
                },
                {
                    name: "PV Steam",
                    data: data.map(i => i.PVSteam)
                },
                {
                    name: "Batu Bara",
                    data: data.map(i => i.Batubara_FK)
                }
            ];

            const options = {
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series,
                colors: ["#0acf97", "#fa5c7c", "#ffbc00"],
                xaxis: {
                    categories,
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

            if (chart) {
                chart.updateOptions(options);
                chart_compresor.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#boiler_chart"), options);
                chart_compresor = new ApexCharts(document.querySelector("#compresor_chart"), options);
                chart.render();
                chart_compresor.render();
            }
        };

        const updateChart = (selector, config, instanceKey) => {
            if (gaugeCharts[instanceKey]) {
                gaugeCharts[instanceKey].updateOptions(config);
            } else {
                gaugeCharts[instanceKey] = new ApexCharts(document.querySelector(selector), config);
                gaugeCharts[instanceKey].render();
            }
        };

        const updateGaugeChart = (data) => {
            const chartData = {
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
                inletwaterflow: data.InletWaterFlow,
            };

            for (const [key, val] of Object.entries(chartData)) {
                updateChart(`#gauge_chart_${key}`, gaugeOptions(val), key);
            }
        };

        const updatePVSteam = () => {
            $.getJSON("{{ url('sensor/boiler-realtime') }}", (response) => {
                if (response) {
                    console.log(response);
                    $('#PV-bar').val(`${response.PVSteam} Bar`);
                    const $pvInput = $('#PV-bar');
                    const pvValue = parseFloat(response.PVSteam);
                    $pvInput.removeClass('bg-danger bg-warning bg-success text-white text-dark');
                    if (pvValue > 7) {
                        $pvInput.addClass('bg-danger text-white'); // merah
                    } else if (pvValue > 6) {
                        $pvInput.addClass('bg-warning text-dark'); // kuning
                    } else {
                        $pvInput.addClass('bg-success text-white'); // hijau
                    }
                    updateGaugeChart(response);

                    if (response.PVSteam > 6) {
                        $.ajax({
                            url: "{{ url('eng/send/tele') }}",
                            type: "GET",
                            dataType: "json"
                        }).done((response) => {
                            console.log(response);
                        }).fail((xhr, status, error) => console.error(`AJAX Error: ${status} ${error}`));
                    }
                }
            }).fail((xhr, status, error) => console.error(`AJAX Error: ${status} ${error}`));
        };

        const updateInputFields = () => {
            const filter = $("#filterData").val();
            $("#datePicker, #startDate, #endDate").addClass("d-none");
            if (filter === "daily") $("#datePicker").removeClass("d-none");
            else if (filter === "weekly") $("#startDate, #endDate").removeClass("d-none");
        };

        $("#filterData").on("change", updateInputFields);

        $("#applyFilter").on("click", () => {
            const filter = $("#filterData").val();
            let url = "",
                params = {};

            if (filter === "latest") {
                url = "{{ url('sensor/boiler-data') }}";
            } else if (filter === "daily") {
                const tanggal = $("#datePicker").val();
                if (!tanggal) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Tanggal!",
                    text: "Harap pilih tanggal terlebih dahulu."
                });
                url = "{{ url('sensor/boiler/data-harian') }}";
                params = {
                    tanggal
                };
            } else if (filter === "weekly") {
                const start = $("#startDate").val(),
                    end = $("#endDate").val();
                if (!start || !end) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Rentang Tanggal!",
                    text: "Harap pilih tanggal mulai dan selesai."
                });
                url = "{{ url('sensor/boiler/data-mingguan') }}";
                params = {
                    tanggal_mulai: start,
                    tanggal_selesai: end
                };
            }

            fetchData(url, params).done(response => {
                response.success ? UpdateChartSensor(response.data) :
                    Swal.fire({
                        icon: "warning",
                        title: "Data Tidak Ditemukan",
                        text: "Tidak ada data untuk rentang waktu yang dipilih."
                    });
            });
        });

        updateInputFields();
        $("#applyFilter").trigger("click");
        updatePVSteam();
        setInterval(updatePVSteam, 3000);




        function fetchData_abnormal(filter = 'today', start = '', end = '') {


            $.ajax({
                url: '{{ url("sensor/rhtemp") }}',
                method: 'GET',
                data: {
                    filter: filter,
                    start: start,
                    end: end
                },
                success: function(res) {
                    // Swal.close();
                    $('#rhtemp_abnormal').text(res.total).attr('data-target', res.total);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengambil data. Coba lagi nanti.',
                    });
                }
            });

            $.ajax({
                url: '{{ url("sensor/lhtemp") }}',
                method: 'GET',
                data: {
                    filter,
                    start,
                    end
                },
                success: function(res) {
                    Swal.close();
                    $('#lhtemp_abnormal').text(res.total).attr('data-target', res.total);
                },
                error: function() {
                    alert("Gagal mengambil data LH Temp.");
                }
            });

            $.ajax({
                url: '{{ url("sensor/pvsteam") }}',
                method: 'GET',
                data: {
                    filter,
                    start,
                    end
                },
                success: function(res) {
                    Swal.close();
                    $('#pvsteam_abnormal').text(res.total).attr('data-target', res.total);
                },
                error: function() {
                    alert("Gagal mengambil data PV Steam.");
                }
            });

            $.ajax({
                url: '{{ url("sensor/levelfeedwater") }}',
                method: 'GET',
                data: {
                    filter,
                    start,
                    end
                },
                success: function(res) {
                    Swal.close();
                    $('#levelfeed_abnormal').text(res.total).attr('data-target', res.total);
                },
                error: function() {
                    alert("Gagal mengambil data Level Feed Water.");
                }
            });
        }

        // Load data awal (today)
        fetchData_abnormal();

        $('#filter_abnormal').change(function() {
            const val = $(this).val();
            if (val === 'date') {
                $('#start-date-group').removeClass('d-none');
                $('#end-date-group').addClass('d-none');
            } else if (val === 'range') {
                $('#start-date-group').removeClass('d-none');
                $('#end-date-group').removeClass('d-none');
            } else {
                $('#start-date-group, #end-date-group').addClass('d-none');
            }
        });

        $('#apply-filter-abnormal').click(function() {
            const filter = $('#filter_abnormal').val();
            const start = $('#start-date').val();
            const end = $('#end-date').val();
            fetchData_abnormal(filter, start, end);
        });

        $('.abnormal-card').on('click', function() {
            const type = $(this).data('type');
            $.ajax({
                url: '{{ url("sensor") }}/' + type, // asumsi endpoint sama
                method: 'GET',
                data: {
                    filter: $('#filter_abnormal').val(),
                    start: $('#start-date').val(),
                    end: $('#end-date').val()
                },
                success: function(res) {
                    let html = '<p>Total: <strong>' + res.total + '</strong></p>';

                    // Tambahkan detail jika ada
                    if (res.data && Array.isArray(res.data)) {
                        html += '<ul class="list-group">';
                        res.data.forEach(item => {
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
                },
                error: function() {
                    alert('Gagal mengambil detail data!');
                }
            });
        });




        let chartKondensat;

        const UpdateChartKondensat = (response) => {
            const data = response.data || [];
            if (!data.length) {
                chartKondensat?.updateSeries([{
                    data: []
                }]);
                Swal.fire({
                    icon: "warning",
                    title: "Data Tidak Ditemukan",
                    text: "Tidak ada data kondensat untuk rentang waktu yang dipilih."
                });
                return;
            }

            const categories = data.map(i => i.waktu);

            // Buat series berdasarkan field Suhu1 - Suhu5
            const series = [];
            for (let i = 1; i <= 5; i++) {
                const key = `Suhu${i}`;
                if (data.some(d => d[key] !== null)) { // hanya tambahkan kalau ada datanya
                    series.push({
                        name: key,
                        data: data.map(d => d[key] !== null ? parseFloat(d[key]) : null)
                    });
                }
            }

            const descriptions = {
                Suhu1: [
                    "Jalur kondensat dari utility - Storage 53"
                ],
                Suhu2: [
                    "Jalur kondensat dari :",
                    "- Olahsari",
                    "- Dissolver Line 1",
                    "- Dissolver Line 2",
                    "- Pit Garam",
                    "- HW glukosa WRH",
                    "- CIP Mini"
                ],
                Suhu3: [
                    "Jalur kondensat dari :",
                    "- Pasteur Line 1",
                    "- Pasteur Line 2"
                ],
                Suhu4: [
                    "Jalur kondensat dari :",
                    "- CIP Kitchen",
                    "- HW 10 ton"
                ],
                Suhu5: [
                    "Jalur kondensat dari header steam area Pasteur."
                ]
            };

            const options = {
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series,
                colors: ["#008FFB", "#FEB019", "#00E396", "#FF4560", "#775DD0"],
                xaxis: {
                    type: "datetime",
                    categories: categories, // tetap pakai waktu asli dari data
                    title: {
                        text: "Waktu"
                    },
                    labels: {
                        rotate: -45,
                        show: true,
                        formatter: function(value, timestamp) {
                            const date = new Date(value);
                            const hours = date.getHours();
                            // hanya tampilkan jam 08, 14, 22
                            if ([8, 14, 22].includes(hours)) {
                                return date.toLocaleTimeString("id-ID", {
                                    hour: "2-digit",
                                    minute: "2-digit"
                                });
                            }
                            return "";
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: "Suhu (°C)"
                    }
                },
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        const seriesName = w.config.series[seriesIndex].name; // ex: Suhu1
                        const value = series[seriesIndex][dataPointIndex];
                        const waktu = w.globals.categoryLabels[dataPointIndex];

                        const desc = descriptions[seriesName] || [];

                        return `
                <div style="padding:8px; max-width:250px">
                    <div><strong>${seriesName}:</strong> ${value} °C</div>
                    <div><em>${waktu}</em></div>
                    <hr style="margin:5px 0"/>
                    <div>${desc.join("<br>")}</div>
                </div>
            `;
                    }
                },
                legend: {
                    position: "top"
                }
            };


            if (chartKondensat) {
                chartKondensat.updateOptions(options);
            } else {
                chartKondensat = new ApexCharts(document.querySelector("#kondensat_chart"), options);
                chartKondensat.render();
            }
        };


        $("#applyKondensat").on("click", () => {
            const start = $("#kondensatStart").val();
            const end = $("#kondensatEnd").val();

            if (!start || !end) {
                return Swal.fire({
                    icon: "warning",
                    title: "Pilih Rentang Tanggal!",
                    text: "Harap pilih tanggal mulai dan selesai."
                });
            }

            $.ajax({
                url: "{{ url('boiler/kondensat/data') }}",
                method: "GET",
                data: {
                    start_date: start,
                    end_date: end
                },
                success: function(response) {
                    UpdateChartKondensat(response);
                },
                error: function(xhr, status, error) {
                    console.error(`AJAX Error: ${status} ${error}`);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: "Tidak bisa mengambil data kondensat."
                    });
                }
            });

        });

        // Load awal hari ini
        const today = new Date().toISOString().split("T")[0];
        $("#kondensatStart").val(today);
        $("#kondensatEnd").val(today);
        $("#applyKondensat").trigger("click");


    });



    function getChartColorsArray(chartId) {
        const colors = document.querySelector(chartId).getAttribute("data-colors");
        return JSON.parse(colors).map(value => {
            const newValue = value.replace(" ", "");
            if (newValue.indexOf("--") !== -1) {
                const style = getComputedStyle(document.documentElement);
                return style.getPropertyValue(newValue) || undefined;
            } else {
                return newValue;
            }
        });
    }
</script>

@endsection