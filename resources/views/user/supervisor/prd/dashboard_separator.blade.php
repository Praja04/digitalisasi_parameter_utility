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
                        <div class="col-xl-4 col-md-4">
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
                                                Last Update: <span id="separator1_last_update">Never</span>
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm rounded-circle bg-light border">
                                                <span class="avatar-title rounded-circle bg-primary-subtle  fs-2">
                                                    <i class="ri-settings-3-line" id="separator1_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
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
                                                    <i class="ri-settings-3-line" id="separator2_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="card card-animate overflow-hidden separator-card" data-separator="3">
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
                                                <span class="avatar-title rounded-circle bg-danger-subtle text-danger fs-2">
                                                    <i class="ri-settings-3-line" id="separator3_icon"></i>
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
                                            <span id="currently_active">0</span>/3
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
                                            <span id="avg_duration">0</span>s
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
                                            <span id="last_activity_time">--:--</span>
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
    }
</style>

@endsection