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
                                <h3 class="mb-0 fw-bold text-dark">Pasteurisasi Line 1 - Comprehensive Monitoring</h3>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 fs-12">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-primary">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Produksi</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Welcome back, <span class="fw-semibold text-dark">{{ Session::get('username') }}</span></p>
                    </div>

                    <!-- Date & Shift Display -->
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

        <!-- Quick Report Generate -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                        <div>
                            <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                                <i class="ri-file-pdf-line text-danger"></i>
                                Generate Laporan Harian
                            </h5>
                            <p class="text-muted mb-0 fs-13">Buat laporan PDF data pasteurisasi per jam</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <input type="date" id="reportDate" class="form-control form-control-sm" style="min-width: 150px;" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                            <button id="generateReport" class="btn btn-danger btn-sm">
                                <i class="ri-download-line me-1"></i>
                                <span class="btn-text">Generate PDF</span>
                                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-lg-3 col-md-6">
                                <div class="alert alert-info mb-0 p-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-time-line"></i>
                                        <small><strong>Data Per Jam:</strong> Hanya jam:00:00</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="alert alert-warning mb-0 p-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-thermometer-line"></i>
                                        <small><strong>Batas Normal:</strong> 105°C - 120°C</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="alert alert-success mb-0 p-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-bar-chart-line"></i>
                                        <small><strong>Analisis:</strong> Periode abnormal</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="alert alert-primary mb-0 p-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ri-file-text-line"></i>
                                        <small><strong>Format:</strong> PDF Landscape</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Date Selection -->
                        <div class="border-top pt-3">
                            <h6 class="fw-semibold mb-2 text-muted">Quick Select:</h6>
                            <div class="row g-2">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-primary btn-sm quick-date-btn" data-days="0">
                                        Hari Ini
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date-btn" data-days="1">
                                        Kemarin
                                    </button>
                                </div>
                                @for($i = 2; $i <= 7; $i++) <div class="col-auto">
                                    <button type="button" class="btn btn-outline-secondary btn-sm quick-date-btn" data-days="{{ $i }}">
                                        {{ \Carbon\Carbon::now()->subDays($i)->format('d/m') }}
                                    </button>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Status Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="ri-information-line text-primary"></i>
                        Process Status Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-primary-subtle rounded">
                                        <i class="ri-settings-line text-primary fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Mode</h6>
                                    <p class="mb-0 fw-semibold" id="mode_status">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-success-subtle rounded">
                                        <i class="ri-database-line text-success fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Storage</h6>
                                    <p class="mb-0 fw-semibold" id="storage_status">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-info-subtle rounded">
                                        <i class="ri-flask-line text-info fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Varian</h6>
                                    <p class="mb-0 fw-semibold" id="varian_status">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-warning-subtle rounded">
                                        <i class="ri-bookmark-line text-warning fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Batch</h6>
                                    <p class="mb-0 fw-semibold" id="batch_status">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Temperature Monitoring Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                    <div>
                        <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                            <i class="ri-temp-cold-line text-danger"></i>
                            Temperature Monitoring
                        </h5>
                        <p class="text-muted mb-0 fs-13">Real-time temperature tracking across all stages</p>
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
                    <div class="row g-3 mb-4">
                        <!-- Current Temperature Values -->
                        <div class="col-lg-3 col-md-6">
                            <div class="text-center p-3 border rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Preheating</h6>
                                <h3 class="mb-0 fw-bold text-info" id="suhu_preheating">0°C</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-center p-3 border rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Heating</h6>
                                <h3 class="mb-0 fw-bold text-warning" id="suhu_heating">0°C</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-center p-3 border rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Holding</h6>
                                <h3 class="mb-0 fw-bold text-danger" id="suhu_holding">0°C</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-center p-3 border rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Precooling</h6>
                                <h3 class="mb-0 fw-bold text-primary" id="suhu_precooling">0°C</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="text-center p-3 border rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Cooling</h6>
                                <h3 class="mb-0 fw-bold text-success" id="suhu_cooling">0°C</h3>
                            </div>
                        </div>
                    </div>
                    <div id="temperature_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pressure and Flow Monitoring -->
    <div class="row mb-4">
        <div class="col-xxl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                        <i class="ri-gauge-line text-primary"></i>
                        Pressure Monitoring
                    </h5>
                    <p class="text-muted mb-0 fs-13">System pressure tracking</p>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Mixing</h6>
                                <h4 class="mb-0 fw-bold text-primary" id="pressure_mixing">0 Bar</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">BT2</h6>
                                <h4 class="mb-0 fw-bold text-success" id="pressure_bt2">0 Bar</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">To Pasteur</h6>
                                <h4 class="mb-0 fw-bold text-warning" id="press_to_pasteur">0 Bar</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">VD High</h6>
                                <h4 class="mb-0 fw-bold text-danger" id="press_vdhh">0 Bar</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">VD Low</h6>
                                <h4 class="mb-0 fw-bold text-info" id="press_vdll">0 Bar</h4>
                            </div>
                        </div>
                    </div>
                    <div id="pressure_chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                        <i class="ri-speed-line text-success"></i>
                        Flow & Level Monitoring
                    </h5>
                    <p class="text-muted mb-0 fs-13">Flow rate and tank levels</p>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="text-center p-3 bg-gradient-success text-white rounded">
                                <h6 class="text-white text-uppercase fs-12 mb-2">Flowrate</h6>
                                <h3 class="mb-0 fw-bold text-white" id="flowrate_value">0 L/min</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Level BT1</h6>
                                <h4 class="mb-0 fw-bold text-primary" id="level_bt1">0%</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Level VD</h6>
                                <h4 class="mb-0 fw-bold text-info" id="level_vd">0%</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fs-12 mb-2">Level BT2</h6>
                                <h4 class="mb-0 fw-bold text-warning" id="level_bt2">0%</h4>
                            </div>
                        </div>
                    </div>
                    <div id="flowrate_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pump Speed Monitoring -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="ri-dashboard-line text-primary"></i>
                        Pump Speed Monitoring
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Speed Pompa Mixing -->
                        <div class="col-lg-2dot4 col-md-6">
                            <div class="card border border-primary border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Pompa Mixing</h6>
                                <div class="display-4 fw-bold text-primary" id="speed_pompa_mixing_value">0%</div>
                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                    <div id="speed_pompa_mixing_bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Speed Pompa BT1 -->
                        <div class="col-lg-2dot4 col-md-6">
                            <div class="card border border-success border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Pompa BT1</h6>
                                <div class="display-4 fw-bold text-success" id="speed_pompa_bt1_value">0%</div>
                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                    <div id="speed_pompa_bt1_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Speed Pompa VD -->
                        <div class="col-lg-2dot4 col-md-6">
                            <div class="card border border-info border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Pompa VD</h6>
                                <div class="display-4 fw-bold text-info" id="speed_pompa_vd_value">0%</div>
                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                    <div id="speed_pompa_vd_bar" class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Speed Pompa BT2 -->
                        <div class="col-lg-2dot4 col-md-6">
                            <div class="card border border-warning border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">Pompa BT2</h6>
                                <div class="display-4 fw-bold text-warning" id="speed_pompa_bt2_value">0%</div>
                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                    <div id="speed_pompa_bt2_bar" class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- PCV1 Value -->
                        <div class="col-lg-2dot4 col-md-6">
                            <div class="card border border-danger border-opacity-25 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <h6 class="text-muted text-uppercase fs-12 mb-3 text-center">PCV1</h6>
                                <div class="display-4 fw-bold text-danger" id="pcv1_value">0%</div>
                                <div class="progress w-100 mt-3" style="height: 8px; border-radius: 6px;">
                                    <div id="pcv1_bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Automation Status -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="ri-robot-line text-success"></i>
                        Automation Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-primary-subtle rounded" id="mixing_am_indicator">
                                        <i class="ri-settings-3-line text-primary fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Mixing AM</h6>
                                    <p class="mb-0 fw-semibold" id="mixing_am_status">OFF</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-success-subtle rounded" id="bt1_am_indicator">
                                        <i class="ri-database-2-line text-success fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">BT1 AM</h6>
                                    <p class="mb-0 fw-semibold" id="bt1_am_status">OFF</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-info-subtle rounded" id="vd_am_indicator">
                                        <i class="ri-droplet-line text-info fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">VD AM</h6>
                                    <p class="mb-0 fw-semibold" id="vd_am_status">OFF</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm bg-warning-subtle rounded">
                                        <i class="ri-time-line text-warning fs-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-muted text-uppercase fs-12">Time Divert</h6>
                                    <p class="mb-0 fw-semibold" id="time_divert">0 min</p>
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

<!-- Toast Notification for Reports -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="reportToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="ri-file-pdf-line text-danger me-2"></i>
                <strong class="me-auto">Laporan PDF</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="reportToastMessage">
                Laporan sedang dibuat...
            </div>
        </div>
    </div>
</div>

<!-- Divert Toast Notification -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3 z-index-9999" style="margin-top: 80px;">
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
    // Custom CSS for responsive grid
    $('<style>').prop('type', 'text/css').html(`
        .col-lg-2dot4 {
            flex: 0 0 auto;
            width: 20%;
        }
        @media (max-width: 991.98px) {
            .col-lg-2dot4 {
                width: 50%;
            }
        }
        @media (max-width: 575.98px) {
            .col-lg-2dot4 {
                width: 100%;
            }
        }
        .abnormal-card {
            transition: all 0.3s ease;
        }
        .abnormal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1) !important;
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
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .automation-indicator.active {
            background-color: #28a745 !important;
        }
        .automation-indicator.inactive {
            background-color: #dc3545 !important;
        }
    `).appendTo('head');

    // Divert Toast Functions
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

    $(document).ready(function() {
        // Initialize charts object
        let charts = {
            temperature: null,
            pressure: null,
            flowrate: null
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

        // Update Temperature Chart with all temperature sensors
        function updateTemperatureChart(data) {
            if (data.length === 0) {
                if (charts.temperature) {
                    charts.temperature.updateSeries([], true);
                }
                return showAlert("warning", "No Data", "No temperature data found for the selected time range.");
            }

            const series = [{
                    name: "Preheating",
                    data: data.map(item => parseFloat(item.SuhuPreheating) || 0)
                },
                {
                    name: "Heating",
                    data: data.map(item => parseFloat(item.SuhuHeating) || 0)
                },
                {
                    name: "Holding",
                    data: data.map(item => parseFloat(item.SuhuHolding) || 0)
                },
                {
                    name: "Precooling",
                    data: data.map(item => parseFloat(item.SuhuPrecooling) || 0)
                },
                {
                    name: "Cooling",
                    data: data.map(item => parseFloat(item.SuhuCooling) || 0)
                }
            ];
            const colors = ["#17a2b8", "#ffc107", "#dc3545", "#6f42c1", "#28a745"];
            const options = createLineChartOptions(data, series, colors, "Temperature (°C)");
            charts.temperature = updateChart("#temperature_chart", options, charts.temperature);
        }

        // Update Pressure Chart
        function updatePressureChart(data) {
            if (data.length === 0) {
                if (charts.pressure) {
                    charts.pressure.updateSeries([], true);
                }
                return;
            }

            const series = [{
                    name: "Mixing Pressure",
                    data: data.map(item => parseFloat(item.PressureMixing) || 0)
                },
                {
                    name: "BT2 Pressure",
                    data: data.map(item => parseFloat(item.PressureBT2) || 0)
                },
                {
                    name: "To Pasteur Pressure",
                    data: data.map(item => parseFloat(item.PressToPasteur) || 0)
                }
            ];
            const colors = ["#007bff", "#28a745", "#ffc107"];
            const options = createLineChartOptions(data, series, colors, "Pressure (Bar)");
            charts.pressure = updateChart("#pressure_chart", options, charts.pressure);
        }

        // Update Flowrate Chart
        function updateFlowrateChart(data) {
            if (data.length === 0) {
                if (charts.flowrate) {
                    charts.flowrate.updateSeries([], true);
                }
                return;
            }

            const series = [{
                name: "Flowrate",
                data: data.map(item => parseFloat(item.Flowrate) || 0)
            }];
            const colors = ["#28a745"];
            const options = createLineChartOptions(data, series, colors, "Flow Rate (L/min)");
            charts.flowrate = updateChart("#flowrate_chart", options, charts.flowrate);
        }

        // Update all real-time values
        function updateRealtimeValues(data) {
            if (!data) return;

            // Temperature values
            $('#suhu_preheating').text((parseFloat(data.SuhuPreheating) || 0) + '°C');
            $('#suhu_heating').text((parseFloat(data.SuhuHeating) || 0) + '°C');
            $('#suhu_holding').text((parseFloat(data.SuhuHolding) || 0) + '°C');
            $('#suhu_precooling').text((parseFloat(data.SuhuPrecooling) || 0) + '°C');
            $('#suhu_cooling').text((parseFloat(data.SuhuCooling) || 0) + '°C');

            // Pressure values
            $('#pressure_mixing').text((parseFloat(data.PressureMixing) || 0) + ' Bar');
            $('#pressure_bt2').text((parseFloat(data.PressureBT2) || 0) + ' Bar');
            $('#press_to_pasteur').text((parseFloat(data.PressToPasteur) || 0) + ' Bar');
            $('#press_vdhh').text((parseFloat(data.PressVDHH) || 0) + ' Bar');
            $('#press_vdll').text((parseFloat(data.PressVDLL) || 0) + ' Bar');

            // Flow and level values
            $('#flowrate_value').text((parseFloat(data.Flowrate) || 0) + ' L/min');
            $('#level_bt1').text((parseFloat(data.LevelBT1) || 0) + '%');
            $('#level_vd').text((parseFloat(data.LevelVD) || 0) + '%');
            $('#level_bt2').text((parseFloat(data.LevelBT2) || 0) + '%');

            // Pump speeds
            function updateSpeed(idValue, idBar, value) {
                const val = Math.round(parseFloat(value)) || 0;
                $(`#${idValue}`).text(val + '%');
                $(`#${idBar}`).css('width', val + '%').attr('aria-valuenow', val);
            }

            updateSpeed('speed_pompa_mixing_value', 'speed_pompa_mixing_bar', data.SpeedPompaMixing);
            updateSpeed('speed_pompa_bt1_value', 'speed_pompa_bt1_bar', data.SpeedPumpBT1);
            updateSpeed('speed_pompa_bt2_value', 'speed_pompa_bt2_bar', data.SpeedPumpBT2);
            updateSpeed('speed_pompa_vd_value', 'speed_pompa_vd_bar', data.SpeedPumpVD);
            updateSpeed('pcv1_value', 'pcv1_bar', data.PCV1);

            // Process status
            $('#mode_status').text(data.Mode || '-');
            $('#storage_status').text(data.Storage || '-');
            $('#varian_status').text(data.Varian || '-');
            $('#batch_status').text(data.Batch || '-');

            // Automation status
            function updateAutomationStatus(statusId, indicatorId, value) {
                const isActive = parseInt(value) === 1;
                $(`#${statusId}`).text(isActive ? 'ON' : 'OFF');
                $(`#${indicatorId}`).removeClass('automation-indicator active inactive bg-primary-subtle bg-danger-subtle')
                    .addClass(isActive ? 'automation-indicator active bg-success-subtle' : 'automation-indicator inactive bg-danger-subtle');
            }

            updateAutomationStatus('mixing_am_status', 'mixing_am_indicator', data.MixingAM);
            updateAutomationStatus('bt1_am_status', 'bt1_am_indicator', data.BT1AM);
            updateAutomationStatus('vd_am_status', 'vd_am_indicator', data.VDAM);
            $('#time_divert').text((parseFloat(data.TimeDivert) || 0) + ' min');
        }

        // Filter and data fetching functions
        function updateInputFields() {
            const filter = $('#filterData').val();
            $('#datePicker, #startDate, #endDate').addClass("d-none");

            if (filter === "daily") {
                $('#datePicker').removeClass("d-none");
            } else if (filter === "weekly") {
                $('#startDate, #endDate').removeClass("d-none");
            }
        }

        function handleFilterClick() {
            const filter = $('#filterData').val();
            let url = "",
                params = {};

            if (filter === "latest") {
                url = "{{ url('pasteurisasi1/data') }}";
            } else if (filter === "daily") {
                const selectedDate = $('#datePicker').val();
                if (!selectedDate) {
                    return showAlert("warning", "Select Date", "Please select a date first.");
                }
                url = "{{ url('pasteurisasi1/data-harian') }}";
                params = {
                    tanggal: selectedDate
                };
            } else if (filter === "weekly") {
                const start = $('#startDate').val();
                const end = $('#endDate').val();
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
                    const data = res.success ? res.data : [];
                    updateTemperatureChart(data);
                    updatePressureChart(data);
                    updateFlowrateChart(data);
                })
                .fail(() => {
                    showAlert("error", "Error", "Failed to fetch data. Please try again.");
                });
        }

        function updateRealtimeInfo() {
            fetchData("{{ url('pasteurisasi1/data-realtime') }}")
                .done(res => {
                    updateRealtimeValues(res);
                })
                .fail(() => {
                    console.error('Failed to fetch realtime data');
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

            $('#date-picker').text(formattedDate);
            $('#shift').text(shift);
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

        // Report generation functions
        function showReportToast(message, type = 'info') {
            const toast = $('#reportToast');
            const toastMessage = $('#reportToastMessage');
            const header = toast.find('.toast-header');

            // Set message
            toastMessage.text(message);

            // Set color based on type
            if (type === 'success') {
                header.find('i').removeClass('text-danger text-warning').addClass('text-success');
            } else if (type === 'warning') {
                header.find('i').removeClass('text-danger text-success').addClass('text-warning');
            } else if (type === 'error') {
                header.find('i').removeClass('text-success text-warning').addClass('text-danger');
            } else {
                header.find('i').removeClass('text-success text-warning').addClass('text-danger');
            }

            // Show toast
            const bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();
        }

        function generateDailyReport() {
            const btn = $('#generateReport');
            const btnText = btn.find('.btn-text');
            const spinner = btn.find('.spinner-border');
            const selectedDate = $('#reportDate').val();

            if (!selectedDate) {
                showAlert('warning', 'Pilih Tanggal', 'Silakan pilih tanggal untuk generate laporan.');
                return;
            }

            // Show loading state
            btn.prop('disabled', true);
            btnText.text('Generating...');
            spinner.removeClass('d-none');

            // Show toast
            showReportToast('Laporan sedang dibuat, mohon tunggu...', 'info');

            // Use AJAX to check data first, then download
            $.ajax({
                url: '{{ route("report.pasteurisasi.daily") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tanggal: selectedDate
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, status, xhr) {
                    // Check if response is JSON (error) or PDF (success)
                    const contentType = xhr.getResponseHeader('content-type');

                    if (contentType && contentType.includes('application/json')) {
                        // Handle JSON error response
                        const reader = new FileReader();
                        reader.onload = function() {
                            const response = JSON.parse(reader.result);
                            showReportToast(response.message || 'Terjadi error saat generate laporan', 'error');
                        };
                        reader.readAsText(data);
                    } else {
                        // Handle PDF success response
                        const blob = new Blob([data], {
                            type: 'application/pdf'
                        });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `Laporan_Pasteurisasi_${selectedDate}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);

                        showReportToast('Laporan PDF berhasil didownload!', 'success');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('PDF Generation Error:', error);
                    let message = 'Terjadi error saat generate laporan.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        message = 'Data tidak ditemukan untuk tanggal yang dipilih.';
                    } else if (xhr.status === 500) {
                        message = 'Server error. Silakan coba lagi.';
                    }

                    showReportToast(message, 'error');
                },
                complete: function() {
                    // Reset button
                    setTimeout(function() {
                        btn.prop('disabled', false);
                        btnText.text('Generate PDF');
                        spinner.addClass('d-none');
                    }, 1000);
                }
            });
        }

        // Event Handlers
        $('#filterData').on('change', updateInputFields);
        $('#applyFilter').on('click', handleFilterClick);
        $('#generateReport').on('click', generateDailyReport);

        // Quick date selection for report
        $('.quick-date-btn').on('click', function() {
            const daysBack = parseInt($(this).data('days'));
            const selectedDate = new Date();
            selectedDate.setDate(selectedDate.getDate() - daysBack);
            const dateString = selectedDate.toISOString().split('T')[0];

            $('#reportDate').val(dateString);

            // Visual feedback
            $('.quick-date-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary btn-outline-primary').addClass('btn-primary');
        });

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

            fetchData(`{{ url("pasteurisasi1") }}/${type}`)
                .done(res => {
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
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;
                        res.data.forEach((item) => {
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
                                </tr>
                            `;
                        });
                        html += `</tbody></table></div>`;
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
                })
                .fail(() => {
                    $('#abnormalModalBody').html(`
                        <div class="alert alert-danger">
                            <i class="ri-error-warning-line me-2"></i>
                            Failed to load abnormal data. Please try again.
                        </div>
                    `);
                });
        });

        // Initialize dashboard
        function initializeDashboard() {
            updateInputFields();
            $('#applyFilter').trigger('click');
            fetchDataAbnormal();
            updateDateTime();
            updateRealtimeInfo();

            // Set intervals
            setInterval(updateRealtimeInfo, 10000); // Update every 10 seconds
            setInterval(updateDateTime, 60000); // Update datetime every minute
        }

        initializeDashboard();

        // Initialize divert checking
        checkDivertStatus();
        setInterval(checkDivertStatus, 60000); // Check every 1 minute
    });
</script>

@endsection