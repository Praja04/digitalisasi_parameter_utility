@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Monitoring - Separator Status</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Separator
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
                        <p class="text-muted mb-0">Real-time monitoring separator open/close status.</p>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <form action="javascript:void(0);">
                            <div class="row g-3 mb-0 align-items-center">
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input id="shift" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input id="date-picker" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-success btn-sm" id="autoRefresh">
                                        <i class="ri-refresh-line"></i> Auto Refresh
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Separator Status Cards -->
        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex flex-column h-100">
                    <div class="row">
                        <!-- Separator 1 -->
                        <div class="col-xl-3 col-md-6 col-sm-6">
                            <div class="card card-animate overflow-hidden separator-card" data-separator="1">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-success);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                                Separator 1
                                            </p>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="status-indicator me-2" id="status_indicator_1">
                                                    <span class="badge bg-secondary">Offline</span>
                                                </div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="separator1_status">
                                                    CLOSED
                                                </h4>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">
                                                    Duration: <span id="separator1_duration">-</span>
                                                </small>
                                                <small class="text-muted">
                                                    Count: <span id="separator1_count">0</span>
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                Last Update: <span id="separator1_last_update"></span>
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-light border">
                                                <span class="avatar-title rounded-circle bg-primary-subtle  fs-2">
                                                    <i class="ri-settings-3-line rotate-icon" id="separator1_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Separator 2 -->
                        <div class="col-xl-3 col-md-6 col-sm-6">
                            <div class="card card-animate overflow-hidden separator-card" data-separator="2">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-warning);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                                Separator 2
                                            </p>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="status-indicator me-2" id="status_indicator_2">
                                                    <span class="badge bg-secondary">Offline</span>
                                                </div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="separator2_status">
                                                    CLOSED
                                                </h4>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">
                                                    Duration: <span id="separator2_duration">-</span>
                                                </small>
                                                <small class="text-muted">
                                                    Count: <span id="separator2_count">0</span>
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                Last Update: <span id="separator2_last_update">Never</span>
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-light border">
                                                <span class="avatar-title rounded-circle bg-warning-subtle text-warning fs-2">
                                                    <i class="ri-settings-3-line rotate-icon" id="separator2_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Separator 3 -->
                        <div class="col-xl-3 col-md-6 col-sm-6">
                            <div class="card card-animate overflow-hidden separator-card" data-separator="3">
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
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                                Separator 3
                                            </p>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="status-indicator me-2" id="status_indicator_3">
                                                    <span class="badge bg-secondary">Offline</span>
                                                </div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="separator3_status">
                                                    CLOSED
                                                </h4>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">
                                                    Duration: <span id="separator3_duration">-</span>
                                                </small>
                                                <small class="text-muted">
                                                    Count: <span id="separator3_count">0</span>
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                Last Update: <span id="separator3_last_update">Never</span>
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-light border">
                                                <span class="avatar-title rounded-circle bg-info-subtle text-info fs-2">
                                                    <i class="ri-settings-3-line rotate-icon" id="separator3_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Separator 4 -->
                        <div class="col-xl-3 col-md-6 col-sm-6">
                            <div class="card card-animate overflow-hidden separator-card" data-separator="4">
                                <div class="position-absolute start-0" style="z-index: 0">
                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                        <style>
                                            .s0 {
                                                opacity: 0.05;
                                                fill: var(--vz-danger);
                                            }
                                        </style>
                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                    </svg>
                                </div>
                                <div class="card-body" style="z-index: 1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                                Separator 4
                                            </p>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="status-indicator me-2" id="status_indicator_4">
                                                    <span class="badge bg-secondary">Offline</span>
                                                </div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="separator4_status">
                                                    CLOSED
                                                </h4>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">
                                                    Duration: <span id="separator4_duration">-</span>
                                                </small>
                                                <small class="text-muted">
                                                    Count: <span id="separator4_count">0</span>
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                Last Update: <span id="separator4_last_update">Never</span>
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-light border">
                                                <span class="avatar-title rounded-circle bg-danger-subtle text-danger fs-2">
                                                    <i class="ri-settings-3-line rotate-icon" id="separator4_icon"></i>
                                                </span>
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

        <!-- Summary Statistics -->
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center text-white">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-white-50 text-truncate mb-2">
                                            Active Now
                                        </p>
                                        <h4 class="fs-22 fw-semibold mb-0 text-white">
                                            <span id="currently_active">0</span>/4
                                        </h4>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="ri-play-circle-line fs-1 text-white-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                            Total Operations Today
                                        </p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                            <span id="total_operations_today">0</span>
                                        </h4>
                                        <small class="text-success">
                                            <i class="ri-arrow-up-line"></i> Today
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                            Average Duration
                                        </p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                            <span id="avg_duration">0</span> Menit
                                        </h4>
                                        <small class="text-muted">Per operation</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-2">
                                            Last Activity
                                        </p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                            <span id="last_activity_time"></span>
                                        </h4>
                                        <small class="text-muted" id="last_activity_separator">No activity</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Status Chart -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Real-time Status Timeline</h4>
                        <div class="d-flex gap-2">
                            <select id="timelineRange" class="form-select form-select-sm w-auto">
                                <option value="1">Last 1 Hour</option>
                                <option value="6">Last 6 Hours</option>
                                <option value="24" selected>Last 24 Hours</option>
                            </select>
                            <button class="btn btn-primary btn-sm" id="refreshChart">
                                <i class="ri-refresh-line"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div id="status_timeline_chart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Activity Log</h4>
                        <div class="d-flex gap-2">
                            <select id="logSeparatorFilter" class="form-select form-select-sm w-auto">
                                <option value="all">All Separators</option>
                                <option value="1">Separator 1</option>
                                <option value="2">Separator 2</option>
                                <option value="3">Separator 3</option>
                                <option value="4">Separator 4</option>
                            </select>
                            <select id="logActionFilter" class="form-select form-select-sm w-auto">
                                <option value="all">All Actions</option>
                                <option value="open">Open Only</option>
                                <option value="close">Close Only</option>
                            </select>
                            <button class="btn btn-outline-primary btn-sm" id="exportLog">
                                <i class="ri-download-line"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-borderless table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="timestamp">
                                            <i class="ri-time-line"></i> Timestamp
                                        </th>
                                        <th scope="col" class="sort" data-sort="separator">
                                            <i class="ri-settings-3-line"></i> Separator
                                        </th>
                                        <th scope="col" class="sort" data-sort="action">
                                            <i class="ri-arrow-up-down-line"></i> Action
                                        </th>
                                        <th scope="col" class="sort" data-sort="duration">
                                            <i class="ri-timer-line"></i> Duration
                                        </th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="activity_log_tbody">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="ri-file-list-line fs-1 text-muted mb-2 d-block"></i>
                                            No activity data available
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Include ApexCharts -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let chart;

        function initChart(data) {
            console.log('Chart data length:', data.length);

            if (!data || data.length === 0) {
                document.querySelector("#status_timeline_chart").innerHTML =
                    '<div class="text-center text-muted py-5"><i class="ri-bar-chart-line fs-1 mb-2 d-block"></i>No data available</div>';
                return;
            }

            const options = {
                chart: {
                    type: 'line',
                    height: 400,
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Separator 1',
                    data: data.map(d => [d.waktu, parseInt(d.separator1) || 0])
                }, {
                    name: 'Separator 2',
                    data: data.map(d => [d.waktu, parseInt(d.separator2) || 0])
                }, {
                    name: 'Separator 3',
                    data: data.map(d => [d.waktu, parseInt(d.separator3) || 0])
                }, {
                    name: 'Separator 4',
                    data: data.map(d => [d.waktu, parseInt(d.separator4) || 0])
                }],

                colors: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                xaxis: {
                    type: 'datetime',
                    labels: {
                        format: 'dd/MM HH:mm',
                        datetimeUTC: true
                    }
                },
                yaxis: {
                    min: 0,
                    max: 2,
                    tickAmount: 4,
                    labels: {
                        formatter: function(val) {
                            if (val === 0) return 'TUTUP';
                            if (val === 1) return 'BUKA';
                            return val.toFixed(1);
                        }
                    }
                },
                stroke: {
                    curve: 'straight',
                    width: 1
                },
                markers: {
                    size: 0
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center'
                },
                tooltip: {
                    x: {
                        format: 'dd MMM HH:mm:ss'
                    },
                    y: {
                        formatter: function(val) {
                            return val === 0 ? 'TUTUP' : 'BUKA';
                        }
                    }
                }
            };

            if (chart) chart.destroy();

            chart = new ApexCharts(document.querySelector("#status_timeline_chart"), options);
            chart.render();
        }

        function fetchData() {
            console.log('Fetching data...');


            $.ajax({
                url: 'http://10.11.11.200:8080/api/separator/sensor',
                method: 'GET',
                timeout: 15000,
                success: function(response) {
                    if (!response?.data?.length) {
                        initChart([]);
                        return;
                    }

                    let data = response.data.sort((a, b) => new Date(a.waktu) - new Date(b.waktu));

                    // Ambil sample data untuk performa lebih baik
                    if (data.length > 500) {
                        const step = Math.ceil(data.length / 500);
                        data = data.filter((_, index) => index % step === 0);
                    }

                    console.log('Using data points:', data.length);
                    initChart(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    document.querySelector("#status_timeline_chart").innerHTML =
                        '<div class="text-center text-danger py-4">Error loading data</div>';
                }
            });
        }

        // Event handlers
        $('#refreshChart').on('click', function() {
            fetchData();
        });

        // Disable timelineRange dropdown since we're showing all data
        $('#timelineRange').prop('disabled', true).val('all');

        // Initial load
        fetchData();
    });
</script>

<script>
    $(document).ready(function() {
        // Configuration object
        const CONFIG = {
            API_URL: 'http://10.11.11.200:8080/api/separator/status',
            REFRESH_INTERVAL: 1000,
            REQUEST_TIMEOUT: 10000
        };

        // State management
        const state = {
            autoRefreshInterval: null,
            isAutoRefreshActive: false
        };

        // Cache DOM elements
        const elements = {
            autoRefresh: $('#autoRefresh'),
            datePicker: $('#date-picker'),
            shift: $('#shift'),
            errorToast: null
        };

        // Initialize application
        function init() {
            updateDateAndShift();
            bindEvents();
            loadSeparatorData();
        }

        // Event bindings
        function bindEvents() {
            elements.autoRefresh.on('click', toggleAutoRefresh);
        }

        // Date and shift management
        function updateDateAndShift() {
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const hour = now.getHours();
            const shift = getShiftByHour(hour);

            elements.datePicker.val(dateStr);
            elements.shift.val(shift);
        }

        function getShiftByHour(hour) {
            if (hour >= 6 && hour < 14) return 'Shift 1 (06:00 - 14:00)';
            if (hour >= 14 && hour < 22) return 'Shift 2 (14:00 - 22:00)';
            return 'Shift 3 (22:00 - 06:00)';
        }

        // Auto refresh functionality
        function toggleAutoRefresh() {
            if (state.isAutoRefreshActive) {
                stopAutoRefresh();
            } else {
                startAutoRefresh();
            }
        }

        function startAutoRefresh() {
            state.autoRefreshInterval = setInterval(loadSeparatorData, CONFIG.REFRESH_INTERVAL);
            state.isAutoRefreshActive = true;
            updateAutoRefreshButton(true);
            loadSeparatorData();
        }

        function stopAutoRefresh() {
            clearInterval(state.autoRefreshInterval);
            state.isAutoRefreshActive = false;
            updateAutoRefreshButton(false);
        }

        function updateAutoRefreshButton(isActive) {
            const btn = elements.autoRefresh;
            if (isActive) {
                btn.removeClass('btn-success').addClass('btn-danger')
                    .html('<i class="ri-stop-circle-line"></i> Stop Refresh');
            } else {
                btn.removeClass('btn-danger').addClass('btn-success')
                    .html('<i class="ri-refresh-line"></i> Auto Refresh');
            }
        }

        // API calls
        async function loadSeparatorData() {
            try {
                const response = await fetchWithTimeout(CONFIG.API_URL, CONFIG.REQUEST_TIMEOUT);
                if (response.success) {
                    updateUI(response);
                    logSuccess();
                } else {
                    throw new Error(response.message || 'Unknown error');
                }
            } catch (error) {
                handleError('Koneksi ke server gagal. Periksa jaringan Anda.', error);
            }
        }

        async function fetchWithTimeout(url, timeout) {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), timeout);

            try {
                const response = await fetch(url, {
                    signal: controller.signal,
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                clearTimeout(timeoutId);
                return await response.json();
            } catch (error) {
                clearTimeout(timeoutId);
                throw error;
            }
        }

        // UI Updates
        function updateUI(response) {
            updateSeparatorCards(response);
            updateSummaryStats(response);
        }

        function updateSeparatorCards(response) {
            const {
                status,
                data,
                last_update
            } = response;
            const lastUpdateTime = formatTimestamp(last_update);

            for (let separatorId = 1; separatorId <= 4; separatorId++) {
                const separatorStatus = status[separatorId.toString()];
                const separatorData = data[separatorId.toString()];
                updateSeparatorCard(separatorId, separatorStatus, separatorData, lastUpdateTime);
            }
        }

        function updateSeparatorCard(separatorId, status, data, lastUpdateTime) {
            const selectors = {
                card: $(`.separator-card[data-separator="${separatorId}"]`),
                status: $(`#separator${separatorId}_status`),
                indicator: $(`#status_indicator_${separatorId}`),
                duration: $(`#separator${separatorId}_duration`),
                count: $(`#separator${separatorId}_count`),
                lastUpdate: $(`#separator${separatorId}_last_update`),
                icon: $(`#separator${separatorId}_icon`)
            };

            const {
                totalCount,
                totalDuration
            } = calculateTotals(data);
            const statusInfo = getStatusInfo(status);

            // Update UI elements
            selectors.status.text(status || 'OFFLINE');
            selectors.indicator.html(`<span class="badge ${statusInfo.badgeClass}">${statusInfo.badgeText}</span>`);
            selectors.card.attr('data-status', statusInfo.cardStatus);
            selectors.count.text(totalCount);
            selectors.duration.text(formatDuration(totalDuration));
            selectors.lastUpdate.text(lastUpdateTime);

            // Handle animations
            if (status === 'OPEN') {
                selectors.icon.addClass('pulse');
            } else {
                selectors.icon.removeClass('pulse');
            }
        }

        function calculateTotals(data) {
            let totalCount = 0,
                totalDuration = 0;

            if (data) {
                Object.values(data).forEach(shift => {
                    totalCount += shift.count || 0;
                    totalDuration += shift.duration || 0;
                });
            }

            return {
                totalCount,
                totalDuration
            };
        }

        function getStatusInfo(status) {
            const statusMap = {
                'OPEN': {
                    badgeClass: 'bg-success',
                    badgeText: 'Online',
                    cardStatus: 'open'
                },
                'CLOSED': {
                    badgeClass: 'bg-danger',
                    badgeText: 'Online',
                    cardStatus: 'closed'
                }
            };

            return statusMap[status] || {
                badgeClass: 'bg-secondary',
                badgeText: 'Offline',
                cardStatus: 'offline'
            };
        }

        function updateSummaryStats(response) {
            const {
                status,
                data
            } = response;
            const activeCount = Object.values(status).filter(s => s === 'OPEN').length;
            const {
                totalOperationsToday,
                totalDurationToday,
                mostActiveSeparator
            } = calculateSummaryData(data);
            const avgDuration = (totalDurationToday / 60).toFixed(2);

            // Update summary cards
            $('#currently_active').text(activeCount);
            $('#total_operations_today').text(totalOperationsToday);
            $('#avg_duration').text(avgDuration);

            if (response.last_update) {
                $('#last_activity_time').text(formatTimestamp(response.last_update));
                $('#last_activity_separator').text(mostActiveSeparator || 'No activity');
            } else {
                $('#last_activity_time').text('--:--');
                $('#last_activity_separator').text('No activity');
            }
        }

        function calculateSummaryData(data) {
            let totalOperationsToday = 0;
            let totalDurationToday = 0;
            let maxCount = 0;
            let mostActiveSeparator = '';

            Object.keys(data).forEach(separatorId => {
                const separatorData = data[separatorId];
                let separatorTotal = 0;

                Object.values(separatorData).forEach(shift => {
                    totalOperationsToday += shift.count || 0;
                    totalDurationToday += shift.duration || 0;
                    separatorTotal += shift.count || 0;
                });

                if (separatorTotal > maxCount) {
                    maxCount = separatorTotal;
                    mostActiveSeparator = `Separator ${separatorId}`;
                }
            });

            return {
                totalOperationsToday,
                totalDurationToday,
                mostActiveSeparator
            };
        }

        function updateOfflineStatus() {
            for (let i = 1; i <= 4; i++) {
                const card = $(`.separator-card[data-separator="${i}"]`);
                const statusElement = $(`#separator${i}_status`);
                const indicatorElement = $(`#status_indicator_${i}`);
                const iconElement = $(`#separator${i}_icon`);

                statusElement.text('OFFLINE');
                indicatorElement.html('<span class="badge bg-secondary">Offline</span>');
                card.attr('data-status', 'offline');
                iconElement.removeClass('pulse');
            }

            // Reset summary stats
            $('#currently_active').text('0');
            $('#last_activity_time').text('--:--');
            $('#last_activity_separator').text('Connection lost');
        }

        // Utility functions
        function formatTimestamp(timestamp) {
            if (!timestamp) return '-';

            const [datePart, timePartRaw] = timestamp.split('T');
            const timePart = timePartRaw.replace('Z', '');
            const [year, month, day] = datePart.split('-');
            const [hour, minute, second] = timePart.split(':');

            return `${day}/${month}/${year} ${hour}:${minute}:${second}`;
        }

        function formatDuration(seconds) {
            if (!seconds || seconds === 0) return '-';

            if (seconds < 60) return `${seconds}s`;
            if (seconds < 3600) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}m ${remainingSeconds}s`;
            }

            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            return `${hours}h ${minutes}m`;
        }

        function showError(message) {
            if (!elements.errorToast) {
                elements.errorToast = $(`
                <div id="errorToast" class="toast position-fixed top-0 end-0 m-3" style="z-index: 9999;">
                    <div class="toast-header bg-danger text-white">
                        <i class="ri-error-warning-line me-2"></i>
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body bg-light">${message}</div>
                </div>
            `);
                $('body').append(elements.errorToast);
            } else {
                elements.errorToast.find('.toast-body').text(message);
            }

            const toast = new bootstrap.Toast(elements.errorToast[0]);
            toast.show();
        }

        function handleError(message, error) {
            console.error('Error:', error);
            showError(message);
            updateOfflineStatus();
        }

        function logSuccess() {
            console.log('Data separator berhasil dimuat:', new Date().toLocaleTimeString());
        }

        // Cleanup
        function cleanup() {
            if (state.autoRefreshInterval) {
                clearInterval(state.autoRefreshInterval);
            }
        }

        // Event listeners
        $(window).on('beforeunload', cleanup);

        // Public API
        window.separatorMonitor = {
            refreshData: loadSeparatorData,
            toggleAutoRefresh: toggleAutoRefresh,
            cleanup: cleanup
        };

        // Initialize application
        init();
    });
</script>

<style>
    /* Separator Card Styling */
    .separator-card {
        transition: all 0.3s ease;
        position: relative;
    }

    .separator-card[data-status="open"] {
        border-left: 4px solid #28a745;
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.08), transparent);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.15);
    }

    .separator-card[data-status="closed"] {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.08), transparent);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.15);
    }

    .separator-card[data-status="offline"] {
        border-left: 4px solid #6c757d;
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.08), transparent);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.15);
    }

    /* Badge Styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.bg-success {
        background: linear-gradient(45deg, #28a745, #20c997) !important;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .badge.bg-danger {
        background: linear-gradient(45deg, #dc3545, #fd7e14) !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .badge.bg-secondary {
        background: linear-gradient(45deg, #6c757d, #adb5bd) !important;
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
    }

    /* Animation Effects */
    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.6;
        }

        100% {
            opacity: 1;
        }
    }

    .rotate-icon {
        transition: transform 0.3s ease;
    }

    .separator-card[data-status="open"] .rotate-icon {
        animation: rotate 2s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Card Hover Effects */
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Table Enhancements */
    .table th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        background: rgba(248, 249, 250, 0.95);
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: all 0.2s ease;
    }

    .sort {
        cursor: pointer;
        user-select: none;
    }

    .sort:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Custom Scrollbar */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .separator-card .card-body {
            padding: 1rem 0.75rem;
        }

        .fs-22 {
            font-size: 1.2rem !important;
        }

        .col-xl-3 {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

@endsection