@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- Modern Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-factory-line text-white fs-16"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold text-dark">Pasteurisasi Line 1</h3>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 fs-12">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-primary">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Produksi</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Welcome back, <span class="fw-semibold text-dark">{{ Session::get('username') }}</span> 👋</p>
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
                <div class="card border-0 shadow-sm abnormal-card h-100" data-type="suhuholding" style="cursor: pointer;">
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
                <div class="card border-0 shadow-sm abnormal-card h-100" data-type="suhuheating" style="cursor: pointer;">
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
                <div class="card border-0 shadow-sm abnormal-card h-100" data-type="flowrate" style="cursor: pointer;">
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

        <!-- Charts Section -->
        <div class="row">
            <!-- Temperature Chart -->
            <div class="col-xxl-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
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
                            <input type="date" id="datePicker" class="form-control form-control-sm d-none" style="min-width: 150px;">
                            <input type="date" id="startDate" class="form-control form-control-sm d-none" style="min-width: 150px;">
                            <input type="date" id="endDate" class="form-control form-control-sm d-none" style="min-width: 150px;">
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
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                        <div>
                            <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                                <i class="ri-speed-line text-success"></i>
                                Flowrate Monitoring
                            </h5>
                            <p class="text-muted mb-0 fs-13">Flow rate analysis and trends</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <select id="filterDataFlowrate" class="form-select form-select-sm" style="min-width: 120px;">
                                <option value="latest">Latest Data</option>
                                <option value="daily">Daily View</option>
                                <option value="weekly">Weekly View</option>
                            </select>
                            <input type="date" id="datePickerFlowrate" class="form-control form-control-sm d-none" style="min-width: 150px;">
                            <input type="date" id="startDateFlowrate" class="form-control form-control-sm d-none" style="min-width: 150px;">
                            <input type="date" id="endDateFlowrate" class="form-control form-control-sm d-none" style="min-width: 150px;">
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

        <!-- Filter Controls for Abnormal Data (Hidden by default) -->
        <div class="row mb-4 d-none" id="abnormal-filters">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Filter Type</label>
                                <select id="filter" class="form-select">
                                    <option value="today">Today</option>
                                    <option value="date">Specific Date</option>
                                    <option value="range">Date Range</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-none" id="start-date-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" id="start-date" class="form-control">
                            </div>
                            <div class="col-md-3 d-none" id="end-date-group">
                                <label class="form-label">End Date</label>
                                <input type="date" id="end-date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <button id="apply-filter" class="btn btn-primary w-100">
                                    <i class="ri-filter-line me-1"></i>Apply Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <div class="card border border-primary border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                    <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa Mixing</h6>
                                    <div class="display-4 fw-bold text-primary" id="speed_pompa_mixing_value">0%</div>
                                    <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                        <div id="speed_pompa_mixing_bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Speed Pompa BT1 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card border border-success border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                    <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa BT1</h6>
                                    <div class="display-4 fw-bold text-success" id="speed_pompa_bt1_value">0%</div>
                                    <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                        <div id="speed_pompa_bt1_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Running -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card border border-info border-opacity-25 h-100">
                                    <div class="card-body">
                                        <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Status Running</h6>
                                        <div class="status-table">
                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                                <span class="fw-medium text-dark fs-13">Mode</span>
                                                <span class="text-muted fs-13" id="mode_status_running">-</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                                                <span class="fw-medium text-dark fs-13">Storage</span>
                                                <span class="text-muted fs-13" id="storage_status_running">-</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
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
                                <div class="card border border-warning border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                    <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa BT2</h6>
                                    <div class="display-4 fw-bold text-warning" id="speed_pompa_bt2_value">0%</div>
                                    <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                        <div id="speed_pompa_bt2_bar" class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Speed Pompa VD (Full Width Row) -->
                            <div class="col-12">
                                <div class="row justify-content-center">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card border border-danger border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                            <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Speed Pompa VD</h6>
                                            <div class="display-4 fw-bold text-danger" id="speed_pompa_vd_value">0%</div>
                                            <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                                <div id="speed_pompa_vd_bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
        <div class="modal fade" id="abnormalModal" tabindex="-1" aria-labelledby="abnormalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title d-flex align-items-center gap-2" id="abnormalModalLabel">
                            <i class="ri-information-line text-primary"></i>
                            Abnormal Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
</div>
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3 z-index-9999">
        <div id="divertToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="divertToastBody">
                    🚨 Peringatan! Terjadi divert pada Pasteurisasi Line 1. Silakan cek suhu proses!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    function showDivertToast(message) {
        const toastBody = document.getElementById('divertToastBody');
        toastBody.innerHTML = message;

        const toastElement = document.getElementById('divertToast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    function checkDivertStatus() {
        fetch("{{ url('pasteurisasi1/status/divert') }}")
            .then(response => response.json())
            .then(data => {
                if (data.divert === true) {
                    const message = `
                        🚨 <strong>DIVERT TERDETEKSI - Pasteurisasi Line 1</strong><br>
                        📅 <strong>Waktu:</strong> ${data.waktu}<br>
                        📌 <strong>Status:</strong> ${data.reason}<br>
                        🌡️ <strong>Suhu Heating:</strong> ${data.suhuHeating}°C<br>
                        🌡️ <strong>Suhu Holding:</strong> ${data.suhuHolding}°C
                    `;
                    showDivertToast(message);
                }
            })
            .catch(error => {
                console.error('Gagal mengambil status divert:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkDivertStatus();
        setInterval(checkDivertStatus, 60000); // Cek setiap 1 menit
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize charts object
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

        // Utility Functions
        function fetchData(url, params = {}) {
            return $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json"
            });
        }

        function showAlert(type, title, text) {
            Swal.fire({
                icon: type,
                title: title,
                text: text,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }

        function updateChart(selector, config, chartInstance) {
            if (chartInstance) {
                chartInstance.updateOptions(config, false, true);
                return chartInstance;
            } else {
                const chart = new ApexCharts(document.querySelector(selector), config);
                chart.render();
                return chart;
            }
        }

        function createLineChartOptions(data, seriesArray, colors, yAxisTitle) {
            const categories = data.map(item => item.Waktu);
            return {
                chart: {
                    type: "line",
                    height: 350,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    },
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true
                        }
                    },
                    zoom: {
                        enabled: true
                    }
                },
                stroke: {
                    width: 3,
                    curve: "smooth"
                },
                series: seriesArray,
                colors: colors,
                xaxis: {
                    categories: categories,
                    title: {
                        text: "Time",
                        style: {
                            fontSize: '12px',
                            fontWeight: 600
                        }
                    },
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: yAxisTitle,
                        style: {
                            fontSize: '12px',
                            fontWeight: 600
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM HH:mm"
                    }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 3
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                }
            };
        }

        function updateChartSuhu(data) {
            if (data.length === 0) {
                if (charts.main) {
                    charts.main.updateSeries([{
                        data: []
                    }, {
                        data: []
                    }], true);
                }
                return showAlert("warning", "No Data", "No temperature data found for the selected time range.");
            }

            const series = [{
                    name: "Heating Temperature",
                    data: data.map(item => parseFloat(item.SuhuHeating) || 0)
                },
                {
                    name: "Holding Temperature",
                    data: data.map(item => parseFloat(item.SuhuHolding) || 0)
                }
            ];
            const colors = ["#0acf97", "#fa5c7c"];
            const options = createLineChartOptions(data, series, colors, "Temperature (°C)");
            charts.main = updateChart("#ccp_chart", options, charts.main);
        }

        function updateChartFlowrate(data) {
            if (data.length === 0) {
                if (charts.flowrate) {
                    charts.flowrate.updateSeries([{
                        data: []
                    }], true);
                }
                return showAlert("warning", "No Data", "No flowrate data found for the selected time range.");
            }

            const series = [{
                name: "Flowrate",
                data: data.map(item => parseFloat(item.Flowrate) || 0)
            }];
            const colors = ["#39afd1"];
            const options = createLineChartOptions(data, series, colors, "Flowrate (L/min)");
            charts.flowrate = updateChart("#flowrate_chart", options, charts.flowrate);
        }

        function createGaugeOptions(value, title) {
            const numValue = parseFloat(value) || 0;
            return {
                chart: {
                    height: 200,
                    type: "radialBar",
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                series: [numValue],
                labels: [title],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: "60%"
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: "18px",
                                fontWeight: "bold",
                                formatter: function(val) {
                                    return val + "%";
                                }
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
                url = "{{ url('pasteurisasi1/data') }}";
            } else if (filter === "daily") {
                const selectedDate = $(`#datePicker${prefix}`).val();
                if (!selectedDate) {
                    return showAlert("warning", "Select Date", "Please select a date first.");
                }
                url = "{{ url('pasteurisasi1/data-harian') }}";
                params = {
                    tanggal: selectedDate
                };
            } else if (filter === "weekly") {
                const start = $(`#startDate${prefix}`).val();
                const end = $(`#endDate${prefix}`).val();
                if (!start || !end) {
                    return showAlert("warning", "Select Date Range", "Please select both start and end dates.");
                }
                url = "{{ url('pasteurisasi/data-mingguan') }}";
                params = {
                    tanggal_mulai: start,
                    tanggal_selesai: end
                };
            }

            fetchData(url, params)
                .done(res => {
                    if (prefix === "") {
                        updateChartSuhu(res.success ? res.data : []);
                    } else {
                        updateChartFlowrate(res.success ? res.data : []);
                    }
                })
                .fail(() => {
                    showAlert("error", "Error", "Failed to fetch data. Please try again.");
                });
        }

        function updateRealtimeInfo() {
            // Update gauge charts
            fetchData("{{ url('pasteurisasi1/data-realtime') }}")
                .done(res => {
                    updateGaugeChart(res);
                })
                .fail(() => {
                    console.error('Failed to fetch realtime gauge data');
                });

            // Update status running
            fetchData("{{ url('prd/data/status-running') }}")
                .done(res => {
                    $('#varian_status_running').text(res.varian || '-');
                    $('#mode_status_running').text(res.mode || '-');
                    $('#batch_status_running').text(res.batch || '-');
                    $('#storage_status_running').text(res.storage || '-');
                })
                .fail(() => {
                    console.error('Failed to fetch status running data');
                });
        }

        function getShift(now) {
            const hours = now.getHours();
            const minutes = now.getMinutes();

            if ((hours === 6 && minutes >= 1) || (hours > 6 && hours < 14) || (hours === 14 && minutes === 0)) {
                return "Shift 1";
            } else if ((hours === 14 && minutes >= 1) || (hours > 14 && hours < 22) || (hours === 22 && minutes === 0)) {
                return "Shift 2";
            } else {
                return "Shift 3";
            }
        }

        function updateDateTime() {
            const now = new Date();
            const formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });
            const shift = getShift(now);

            $('#date-picker').val(formattedDate);
            $('#shift').val(shift);
        }

        function fetchDataAbnormal(filter = 'today', start = '', end = '') {
            const endpoints = [{
                    url: '{{ url("pasteurisasi1/suhuholding") }}',
                    target: '#suhuholding_abnormal'
                },
                {
                    url: '{{ url("pasteurisasi1/suhuheating") }}',
                    target: '#suhuheating_abnormal'
                },
                {
                    url: '{{ url("pasteurisasi1/flowrate") }}',
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

        // Event Handlers
        $('#filterData, #filterDataFlowrate').on('change', function() {
            const id = $(this).attr('id');
            const prefix = id.includes('Flowrate') ? 'Flowrate' : '';
            updateInputFields(prefix);
        });

        $('#applyFilter').on('click', () => handleFilterClick());
        $('#applyFilterFlowrate').on('click', () => handleFilterClick('Flowrate'));

        $('.abnormal-card').on('click', function() {
            const type = $(this).data('type');
            $('#abnormalModalBody').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading data...</p>
            </div>
        `);
            $('#abnormalModal').modal('show');

            fetchData(`{{ url("pasteurisasi1") }}/${type}`, {
                filter: $('#filter').val() || 'today',
                start: $('#start-date').val(),
                end: $('#end-date').val()
            }).done(res => {
                let html = `
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    Total Abnormal Records: <strong>${res.total}</strong>
                </div>
            `;

                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    html += `
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="ri-time-line me-1"></i>Start Time</th>
                                    <th><i class="ri-time-line me-1"></i>End Time</th>
                                    <th><i class="ri-calendar-line me-1"></i>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                    res.data.forEach((item, index) => {
                        html += `
                        <tr>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    ${item.waktu_mulai || '-'}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success">
                                    ${item.waktu_akhir || '-'}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    ${item.duration || 'N/A'}
                                </span>
                            </td>
                        </tr>
                    `;
                    });
                    html += `
                            </tbody>
                        </table>
                    </div>
                `;
                } else {
                    html += `
                    <div class="text-center py-4">
                        <i class="ri-inbox-line text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-2">No abnormal data found</h6>
                        <p class="text-muted">There are no abnormal records for the selected period.</p>
                    </div>
                `;
                }

                $('#abnormalModalBody').html(html);
            }).fail(() => {
                $('#abnormalModalBody').html(`
                <div class="alert alert-danger">
                    <i class="ri-error-warning-line me-2"></i>
                    Failed to load abnormal data. Please try again.
                </div>
            `);
            });
        });

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

        // Initialize functions
        function initializeDashboard() {
            // Update input fields
            updateInputFields();
            updateInputFields('Flowrate');

            // Load initial data
            $('#applyFilter').trigger('click');
            $('#applyFilterFlowrate').trigger('click');

            // Load abnormal data
            fetchDataAbnormal();

            // Update date time
            updateDateTime();

            // Load realtime info
            updateRealtimeInfo();

            // Set interval for realtime updates
            setInterval(updateRealtimeInfo, 10000); // Update every 10 seconds
            setInterval(updateDateTime, 60000); // Update datetime every minute
        }

        // Custom CSS for better styling
        $('<style>').prop('type', 'text/css').html(`
        .abnormal-card {
            transition: all 0.3s ease;
        }
        .abnormal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1) !important;
        }
        .status-table .border-light {
            border-color: #e9ecef !important;
        }
        .card {
            border-radius: 12px;
        }
        .btn {
            border-radius: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .avatar-sm {
            width: 2.5rem;
            height: 2.5rem;
        }
        .counter-value {
            font-family: 'Inter', sans-serif;
        }
        .apexcharts-toolbar {
            border-radius: 6px !important;
        }
        .modal-content {
            border-radius: 12px;
        }
        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            border-bottom: 2px solid #dee2e6;
        }
        .badge {
            font-size: 0.75rem;
        }
        .ri-temp-hot-line, .ri-fire-line, .ri-water-flash-line {
            opacity: 0.1;
        }
    `).appendTo('head');

        // Initialize dashboard
        initializeDashboard();

        // Add loading states for better UX
        function showLoadingState(selector) {
            $(selector).html(`
            <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Loading chart data...</p>
                </div>
            </div>
        `);
        }

        // Error handling for charts
        function showChartError(selector, message) {
            $(selector).html(`
            <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                <div class="text-center">
                    <i class="ri-error-warning-line text-danger mb-2" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0">${message}</p>
                </div>
            </div>
        `);
        }

        // Add smooth animations
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Auto-refresh notification
        let refreshCount = 0;
        setInterval(function() {
            refreshCount++;
            if (refreshCount % 6 === 0) { // Every minute (10s * 6)
                showAlert('info', 'Data Updated', 'Real-time data has been refreshed.');
            }
        }, 10000);

        // Responsive chart resizing
        $(window).on('resize', function() {
            if (charts.main) charts.main.resize();
            if (charts.flowrate) charts.flowrate.resize();
            Object.values(charts.gauges).forEach(chart => {
                if (chart) chart.resize();
            });
        });

        // Add keyboard shortcuts
        $(document).on('keydown', function(e) {
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                updateRealtimeInfo();
                showAlert('info', 'Manual Refresh', 'Data has been manually refreshed.');
            }
        });

        // Add double-click to reset zoom on charts
        $('#ccp_chart, #flowrate_chart').on('dblclick', function() {
            const chartId = $(this).attr('id');
            if (chartId === 'ccp_chart' && charts.main) {
                charts.main.resetSeries();
            } else if (chartId === 'flowrate_chart' && charts.flowrate) {
                charts.flowrate.resetSeries();
            }
        });

        // Performance monitoring
        console.log('Dashboard initialized successfully');

        // Add connection status indicator
        let isOnline = navigator.onLine;

        function updateConnectionStatus() {
            if (!isOnline && navigator.onLine) {
                isOnline = true;
                showAlert('success', 'Back Online', 'Connection restored. Data will be updated.');
                updateRealtimeInfo();
            } else if (isOnline && !navigator.onLine) {
                isOnline = false;
                showAlert('warning', 'Connection Lost', 'No internet connection. Using cached data.');
            }
        }

        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
    });
</script>

@endsection