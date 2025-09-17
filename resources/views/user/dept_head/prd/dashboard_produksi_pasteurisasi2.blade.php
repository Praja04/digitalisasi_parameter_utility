@extends('layout')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            {{-- header --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div
                        class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div
                                    class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-factory-line text-white fs-16"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold text-dark">Pasteurisasi Line 2</h3>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0 fs-12">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);"
                                                    class="text-primary">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Produksi</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Welcome back, <span
                                    class="fw-semibold text-dark">{{ Session::get('username') }}</span> 👋</p>
                        </div>

                        <!-- Modern Date & Shift Display -->
                        <div class="d-flex gap-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-time-line text-primary"></i>
                                        <div>
                                            <p class="mb-0 fs-11 text-muted">Current Shift</p>
                                            <p class="mb-0 fw-semibold" id="shift">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-calendar-2-line text-success"></i>
                                        <div>
                                            <p class="mb-0 fs-11 text-muted">Date & Time</p>
                                            <p class="mb-0 fw-semibold" id="date-picker">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abnormal Status Cards -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3 d-flex align-items-center gap-2">
                        <i class="ri-alert-line text-warning"></i>
                        Abnormal Monitoring
                    </h5>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm abnormal-card h-100 card-animate" data-type="suhuholding"
                        style="cursor: pointer;">
                        <div class="card-body position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 opacity-25">
                                <i class="ri-temp-hot-line" style="font-size: 4rem; color: var(--bs-danger);"></i>
                            </div>
                            <div class="position-relative">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Suhu Holding Abnormal</h6>
                                <h3 class="mb-0 fw-bold text-danger">
                                    <span class="counter-value" id="suhuholding_abnormal" data-target="">0</span>
                                </h3>
                                <p class="text-muted mb-0 fs-13">Click to view details</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm abnormal-card h-100 card-animate" data-type="suhuheating"
                        style="cursor: pointer;">
                        <div class="card-body position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 opacity-25">
                                <i class="ri-fire-line" style="font-size: 4rem; color: var(--bs-warning);"></i>
                            </div>
                            <div class="position-relative">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Suhu Heating Abnormal</h6>
                                <h3 class="mb-0 fw-bold text-warning">
                                    <span class="counter-value" id="suhuheating_abnormal" data-target="">0</span>
                                </h3>
                                <p class="text-muted mb-0 fs-13">Click to view details</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm abnormal-card h-100 card-animate" data-type="flowrate"
                        style="cursor: pointer;">
                        <div class="card-body position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 opacity-25">
                                <i class="ri-water-flash-line" style="font-size: 4rem; color: var(--bs-info);"></i>
                            </div>
                            <div class="position-relative">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Flowrate Abnormal</h6>
                                <h3 class="mb-0 fw-bold text-info">
                                    <span class="counter-value" id="flowrate_abnormal" data-target="">0</span>
                                </h3>
                                <p class="text-muted mb-0 fs-13">Click to view details</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Temperature Chart -->
            <div class="row">
                <div class="col-xxl-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 card-animate">
                        <div
                            class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                            <div>
                                <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                                    <i class="ri-temp-cold-line text-primary"></i>
                                    Temperature Monitoring
                                </h5>
                                <p class="text-muted mb-0 fs-13">Real-time temperature tracking</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <select id="filterData" class="form-select form-select-sm" style="min-width: 120px;">
                                    <option value="latest">Latest Data</option>
                                    <option value="daily">Daily View</option>
                                    <option value="weekly">Weekly View</option>
                                </select>
                                <input type="date" id="datePicker" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <input type="date" id="startDate" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <input type="date" id="endDate" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <button id="applyFilter" class="btn btn-primary btn-sm">
                                    <i class="ri-search-line me-1"></i>Apply
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="ccp_chart"></div>
                        </div>
                    </div>
                </div>


                <!-- Flowrate Chart -->
                <div class="col-xxl-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 card-animate">
                        <div
                            class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                            <div>
                                <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                                    <i class="ri-speed-line text-success"></i>
                                    Flowrate Monitoring
                                </h5>
                                <p class="text-muted mb-0 fs-13">Flow rate analysis and trends</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <select id="filterDataFlowrate" class="form-select form-select-sm"
                                    style="min-width: 120px;">
                                    <option value="latest">Latest Data</option>
                                    <option value="daily">Daily View</option>
                                    <option value="weekly">Weekly View</option>
                                </select>
                                <input type="date" id="datePickerFlowrate" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <input type="date" id="startDateFlowrate" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <input type="date" id="endDateFlowrate" class="form-control form-control-sm d-none"
                                    style="min-width: 150px;">
                                <button id="applyFilterFlowrate" class="btn btn-success btn-sm">
                                    <i class="ri-search-line me-1"></i>Apply
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="flowrate_chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- chart pump monitoring  --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom-0 pb-0">
                            <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                                <i class="ri-dashboard-line text-primary"></i>
                                Pump Speed Monitoring
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Speed Pompa Mixing -->
                                <div class="col-lg-3 col-md-6">
                                    <div
                                        class="card border border-primary border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3 card-animate">
                                        <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa Mixing
                                        </h6>
                                        <div class="display-4 fw-bold text-primary" id="speed_pompa_mixing_value">0%</div>
                                        <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                            <div id="gauge_chart_pompa_mixing" class="progress-bar bg-primary"
                                                role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Speed Pompa BT1 -->
                                <div class="col-lg-3 col-md-6">
                                    <div
                                        class="card border card-animate border-success border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                        <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa BT1</h6>
                                        <div class="display-4 fw-bold text-success" id="speed_pompa_bt1_value">0%</div>
                                        <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                            <div id="gauge_chart_bt1" class="progress-bar bg-success" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Running -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card border card-animate border-info border-opacity-25 h-100">
                                        <div class="card-body">
                                            <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Status Running
                                            </h6>
                                            <div class="status-table">
                                                <div
                                                    class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                                    <span class="fw-medium text-dark fs-13">Mode</span>
                                                    <span class="text-muted fs-13" id="mode_status_running">-</span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                                    <span class="fw-medium text-dark fs-13">Storage</span>
                                                    <span class="text-muted fs-13" id="storage_status_running">-</span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                                    <span class="fw-medium text-dark fs-13">Varian</span>
                                                    <span class="text-muted fs-13" id="varian_status_running">-</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <span class="fw-medium text-dark fs-13">Batch</span>
                                                    <span class="text-muted fs-13" id="batch_status_running">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Speed Pompa BT2 -->
                                <div class="col-lg-3 col-md-6">
                                    <div
                                        class="card border card-animate border-warning border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                        <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa BT2</h6>
                                        <div class="display-4 fw-bold text-warning" id="speed_pompa_bt2_value">0%</div>
                                        <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                            <div id="gauge_chart_bt2" class="progress-bar bg-warning" role="progressbar"
                                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Speed Pompa VD (Full Width Row) -->
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-3 col-md-6">
                                            <div
                                                class="card border card-animate border-danger border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa VD
                                                </h6>
                                                <div class="display-4 fw-bold text-danger" id="speed_pompa_vd_value">0%
                                                </div>
                                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                                    <div id="gauge_chart_vd" class="progress-bar bg-danger"
                                                        role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abnormal Details Modal -->
            <div class="modal fade" id="abnormalModal" tabindex="-1" aria-labelledby="abnormalModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title d-flex align-items-center gap-2" id="abnormalModalLabel">
                                <i class="ri-information-line text-primary"></i>
                                Abnormal Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="abnormalModalBody">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted mt-2">Loading data...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3 z-index-9999">
            <div id="divertToast" class="toast align-items-center text-bg-danger border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-semibold" id="divertToastBody">
                        🚨 Peringatan! Terjadi divert pada Pasteurisasi Line 1. Silakan cek suhu proses!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
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
                    return showWarning("Data Tidak Ditemukan",
                        "Tidak ada data suhu untuk rentang waktu yang dipilih.");
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
                    return showWarning("Data Tidak Ditemukan",
                        "Tidak ada data flowrate untuk rentang waktu yang dipilih.");
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

            function updateGaugeChart(data) {
                if (!data) return;

                // Helper to update value and progress bar
                function updateSpeed(idValue, idBar, value) {
                    const val = Math.round(parseFloat(value)) || 0;
                    $(`#${idValue}`).text(val + '%');
                    $(`#${idBar}`).css('width', val + '%').attr('aria-valuenow', val);
                }

                updateSpeed('speed_pompa_mixing_value', 'speed_pompa_mixing_bar', data.SpeedPompaMixing);
                updateSpeed('speed_pompa_bt1_value', 'speed_pompa_bt1_bar', data.SpeedPumpBT1);
                updateSpeed('speed_pompa_bt2_value', 'speed_pompa_bt2_bar', data.SpeedPumpBT2);
                updateSpeed('speed_pompa_vd_value', 'speed_pompa_vd_bar', data.SpeedPumpVD);
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
                    if (!start || !end) return showWarning("Pilih Rentang Tanggal!",
                        "Harap lengkapi tanggal mulai dan selesai.");
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
                } else if ((hours === 14 && minutes >= 1) || (hours > 14 && hours < 22) || (hours === 22 &&
                        minutes === 0)) {
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
                        url: '{{ url('pasteurisasi1/suhuholding') }}',
                        target: '#suhuholding_abnormal'
                    },
                    {
                        url: '{{ url('pasteurisasi1/suhuheating') }}',
                        target: '#suhuheating_abnormal'
                    },
                    {
                        url: '{{ url('pasteurisasi1/flowrate') }}',
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
                            console.error(`Failed to fetch data from ${endpoint.url}`);
                        });
                });
            }

            $('.abnormal-card').on('click', function() {
                const type = $(this).data('type');
                fetchData(`{{ url('pasteurisasi1') }}/${type}`, {
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
                fetchData("{{ url('/prd/achievement') }}", {
                        filter,
                        start_date: startDate,
                        end_date: endDate
                    })
                    .done(res => {
                        $('#output_batch').attr('data-target', res.total_batch_count).text(res
                            .total_batch_count + ' ton');
                        $('#output_batch_shift1').attr('data-target', res.shift_counts.shift_1).text(res
                            .shift_counts.shift_1 + ' ton');
                        $('#output_batch_shift2').attr('data-target', res.shift_counts.shift_2).text(res
                            .shift_counts.shift_2 + ' ton');
                        $('#output_batch_shift3').attr('data-target', res.shift_counts.shift_3).text(res
                            .shift_counts.shift_3 + ' ton');
                        $('#achievement_output_batch').attr('data-target', res.achievement_percentage).text(res
                            .achievement_percentage);
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
                showAlert('success', 'Filter Applied', 'Abnormal data has been updated.');
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
