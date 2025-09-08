@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- Page Header with Gradient Background -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-gradient-primary p-4 rounded-3 mb-4 text-white shadow-lg">
                    <div>
                        <h4 class="mb-1 text-white fw-bold">Engineering Dashboard</h4>
                        <p class="mb-0 opacity-75">Monitor utilitas air, listrik, dan chemical secara real-time</p>
                    </div>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0 bg-transparent">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);" class="text-white-50">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active text-white">
                                Utility
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center">
                                    <i class="ri-drop-line fs-4 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted fw-semibold text-uppercase tracking-wide">Total Air</h6>
                                <h4 class="mb-0" id="total-air-usage">- m³</h4>
                                <p class="text-muted mb-0 small">Bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center">
                                    <i class="ri-flashlight-line fs-4 text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted fw-semibold text-uppercase tracking-wide">Total Listrik</h6>
                                <h4 class="mb-0" id="total-electricity-usage">- mWh</h4>
                                <p class="text-muted mb-0 small">Bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-success-subtle d-flex align-items-center justify-content-center">
                                    <i class="ri-test-tube-line fs-4 text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted fw-semibold text-uppercase tracking-wide">Total Chemical</h6>
                                <h4 class="mb-0" id="total-chemical-usage">- kg</h4>
                                <p class="text-muted mb-0 small">Bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="row g-4">
            <!-- Water Usage Process & Support -->
            <div class="col-xxl-6 col-lg-6">
                <div class="card chart-card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Air Proses & Support</h5>
                                <p class="text-muted mb-0 small">Pemakaian air untuk utilitas</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-calendar-line me-1"></i>
                                    <span id="selectedBulanAir">Pilih Periode</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-3 border-0 shadow-lg" style="min-width: 300px;">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Dari Tanggal</label>
                                        <input type="date" id="startDateAir" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Sampai Tanggal</label>
                                        <input type="date" id="endDateAir" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-primary btn-sm w-100" id="applyAirRange">
                                        <i class="ri-refresh-line me-1"></i>Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="chart-loading" id="loading-air">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted mb-0">Memuat data pemakaian air...</p>
                            </div>
                        </div>
                        <div id="pemakaian-air-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Raw Water Usage -->
            <div class="col-xxl-6 col-lg-6">
                <div class="card chart-card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Air Raw</h5>
                                <p class="text-muted mb-0 small">Pemakaian air mentah</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-calendar-line me-1"></i>
                                    <span id="selectedBulanAirRaw">Pilih Periode</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-3 border-0 shadow-lg" style="min-width: 300px;">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Dari Tanggal</label>
                                        <input type="date" id="startDateAirRaw" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Sampai Tanggal</label>
                                        <input type="date" id="endDateAirRaw" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-primary btn-sm w-100" id="applyAirRawRange">
                                        <i class="ri-refresh-line me-1"></i>Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="chart-loading" id="loading-air-raw">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-info" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted mb-0">Memuat data air raw...</p>
                            </div>
                        </div>
                        <div id="pemakaian-air-chart-raw" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Electricity Usage -->
            <div class="col-xxl-6 col-lg-6">
                <div class="card chart-card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Pemakaian Listrik</h5>
                                <p class="text-muted mb-0 small">Konsumsi energi listrik</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-calendar-line me-1"></i>
                                    <span id="selectedBulanListrik">Pilih Periode</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-3 border-0 shadow-lg" style="min-width: 300px;">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Dari Tanggal</label>
                                        <input type="date" id="startDateListrik" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Sampai Tanggal</label>
                                        <input type="date" id="endDateListrik" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-primary btn-sm w-100" id="applyListrikRange">
                                        <i class="ri-refresh-line me-1"></i>Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="chart-loading" id="loading-listrik">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-warning" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted mb-0">Memuat data listrik...</p>
                            </div>
                        </div>
                        <div id="pemakaian-listrik-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Chemical Usage -->
            <div class="col-xxl-6 col-lg-6">
                <div class="card chart-card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Pemakaian Chemical</h5>
                                <p class="text-muted mb-0 small">Konsumsi bahan kimia</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-calendar-line me-1"></i>
                                    <span id="selectedBulanChemical">Pilih Periode</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end p-3 border-0 shadow-lg" style="min-width: 300px;">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Dari Tanggal</label>
                                        <input type="date" id="startDateChemical" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-muted">Sampai Tanggal</label>
                                        <input type="date" id="endDateChemical" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-primary btn-sm w-100" id="applyChemicalRange">
                                        <i class="ri-refresh-line me-1"></i>Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="chart-loading" id="loading-chemical">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted mb-0">Memuat data chemical...</p>
                            </div>
                        </div>
                        <div id="pemakaian-chemical-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend Analysis Section -->
        <div class="row g-4 mt-2">
            <!-- Water Trend -->
            <div class="col-xl-12">
                <div class="card trend-card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-white fw-semibold">Trend Pemakaian Air</h5>
                                <p class="mb-0 opacity-75 small">Analisis pola konsumsi air harian</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                
                                <input type="month" id="filter_bulan" class="form-control form-control-sm bg-white" style="width: 140px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chart-loading" id="loading-trend-air">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-primary" role="status"></div>
                                <p class="mt-3 text-muted mb-0">Memuat trend data air...</p>
                            </div>
                        </div>
                        <div id="pemakaian_air_chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

           
        </div>

        <div class="row g-4 mt-2">
            <!-- Electricity Trend -->
            <div class="col-xl-12">
                <div class="card trend-card border-0 shadow-sm">
                    <div class="card-header bg-gradient-warning text-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-white fw-semibold">Trend Pemakaian Listrik</h5>
                                <p class="mb-0 opacity-75 small">Analisis pola konsumsi listrik harian</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                              
                                <input type="month" id="filter_bulan_listrik" class="form-control form-control-sm bg-white" style="width: 140px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chart-loading" id="loading-trend-listrik">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-warning" role="status"></div>
                                <p class="mt-3 text-muted mb-0">Memuat trend data listrik...</p>
                            </div>
                        </div>
                        <div id="pemakaian_listrik_chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Chemical Trend -->
            <div class="col-xl-12">
                <div class="card trend-card border-0 shadow-sm">
                    <div class="card-header bg-gradient-success text-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-white fw-semibold">Trend Pemakaian Chemical</h5>
                                <p class="mb-0 opacity-75 small">Analisis pola konsumsi chemical harian</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                              
                                <input type="month" id="filter_bulan_chemical" class="form-control form-control-sm bg-white" style="width: 140px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chart-loading" id="loading-trend-chemical">
                            <div class="text-center p-5">
                                <div class="spinner-grow text-success" role="status"></div>
                                <p class="mt-3 text-muted mb-0">Memuat trend data chemical...</p>
                            </div>
                        </div>
                        <div id="pemakaian_chemical_chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Simpan instance chart biar bisa update
    const chartInstances = {};

    function showLoading(id) {
        $(`#${id}`).fadeIn(200);
    }

    function hideLoading(id) {
        $(`#${id}`).fadeOut(300);
    }

    // Base options
    function baseOptions(type = 'bar') {
        return {
            chart: {
                type,
                height: 300,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: type === 'line' ? 'smooth' : 'straight',
                width: 2
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 3
            },
            xaxis: {
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: '#8c9097'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: '#8c9097'
                    }
                }
            },
            noData: {
                text: 'Memuat data...'
            }
        };
    }

    // Render bar chart
    function renderBar(labels, values, selector, key, unit, color) {
        const options = baseOptions('bar');
        options.series = [{
            name: `Total (${unit})`,
            data: values
        }];
        options.xaxis.categories = labels;
        options.colors = [color];
        options.tooltip = {
            y: {
                formatter: val => `${val} ${unit}`
            }
        };

        if (chartInstances[key]) {
            chartInstances[key].updateOptions(options, true, true);
        } else {
            chartInstances[key] = new ApexCharts(document.querySelector(selector), options);
            chartInstances[key].render();
        }
    }

    // Fetch data untuk bar chart
    function fetchAir(start, end) {
        showLoading('loading-air');
        $.getJSON(`{{ url('eng/top5/air') }}?start_date=${start}&end_date=${end}`, data => {
            renderBar(data.map(d => d.jenis_pemakaian), data.map(d => +d.total_pemakaian),
                "#pemakaian-air-chart", 'air', 'm³', '#3B82F6');
        }).always(() => hideLoading('loading-air'));
    }

    function fetchAirRaw(start, end) {
        showLoading('loading-air-raw');
        $.getJSON(`{{ url('eng/top5/air/raw') }}?start_date=${start}&end_date=${end}`, data => {
            renderBar(data.map(d => d.jenis_pemakaian), data.map(d => +d.total_pemakaian),
                "#pemakaian-air-chart-raw", 'airRaw', 'm³', '#06B6D4');
        }).always(() => hideLoading('loading-air-raw'));
    }

    function fetchListrik(start, end) {
        showLoading('loading-listrik');
        $.getJSON(`{{ url('eng/top5/listrik') }}?start_date=${start}&end_date=${end}`, data => {
            renderBar(data.map(d => d.panel_type), data.map(d => +d.total_usage),
                "#pemakaian-listrik-chart", 'listrik', 'mWh', '#F59E0B');
        }).always(() => hideLoading('loading-listrik'));
    }

    function fetchChemical(start, end) {
        showLoading('loading-chemical');
        $.getJSON(`{{ url('eng/top5/chemical') }}?start_date=${start}&end_date=${end}`, data => {
            renderBar(data.map(d => d.jenis_pemakaian), data.map(d => +d.total_pemakaian),
                "#pemakaian-chemical-chart", 'chemical', 'kg', '#10B981');
        }).always(() => hideLoading('loading-chemical'));
    }

    // Top Operator
    function fetchTopOperator(url, containerId) {
        $.getJSON(url, data => {
            const container = $(containerId).empty();
            if (!data.length) {
                container.html("<p class='text-muted'>Tidak ada data.</p>");
                return;
            }
            data.forEach(d => {
                const nama = d.created_by || d.operator || '-';
                container.append(`
                    <div class="d-flex align-items-center mb-2 small">
                        <i class="mdi mdi-account fs-4 text-primary me-3"></i>
                        <div class="flex-grow-1 d-flex justify-content-between">
                            <span>${nama}</span>
                            <span class="fw-bold">${d.jumlah_pengisian}x</span>
                        </div>
                    </div>
                `);
            });
        });
    }

    // Trend chart setup
    function setupTrend(selector, url, ySuffix, key, loadingId) {
        const options = baseOptions('line');
        options.chart.height = 350;
        options.series = [];
        options.xaxis.type = 'datetime';
        options.yaxis.title = {
            text: `Pemakaian (${ySuffix})`
        };
        options.tooltip = {
            x: {
                format: 'dd MMM yyyy'
            },
            y: {
                formatter: v => `${v} ${ySuffix}`
            }
        };

        const chart = new ApexCharts(document.querySelector(selector), options);
        chart.render();
        chartInstances[key] = chart;

        function fetchTrend(params = {}) {
            showLoading(loadingId);
            $.getJSON(url, params, data => {
                chart.updateSeries(data);
            }).always(() => hideLoading(loadingId));
        }

        fetchTrend(); // initial load
        return fetchTrend;
    }

    // Init
    $(function() {
        const today = new Date();
        const start = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().slice(0, 10);
        const end = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().slice(0, 10);

        // Load bar chart
        fetchAir(start, end);
        fetchAirRaw(start, end);
        fetchListrik(start, end);
        fetchChemical(start, end);

        // Load operator
        fetchTopOperator("{{ url('eng/top5/operator/air') }}", '#top-operator-list');
        fetchTopOperator("{{ url('eng/top5/operator/listrik') }}", '#top-operator-listrik');
        fetchTopOperator("{{ url('eng/top5/operator/chemical') }}", '#top-operator-chemical');

        // Trend chart
        const fetchTrendAir = setupTrend("#pemakaian_air_chart", "{{ url('eng/trend-pemakaian-air') }}", "m³", "trendAir", "loading-trend-air");
        const fetchTrendListrik = setupTrend("#pemakaian_listrik_chart", "{{ url('eng/trend-pemakaian-listrik') }}", "mWh", "trendListrik", "loading-trend-listrik");
        const fetchTrendChemical = setupTrend("#pemakaian_chemical_chart", "{{ url('eng/trend-pemakaian-chemical') }}", "kg", "trendChemical", "loading-trend-chemical");

        // Optional: pasang event listener ke filter bulan kalau ada <select>
        $('#filter_bulan').on('change', function() {
            fetchTrendAir({
                bulan: this.value
            });
        });
        $('#filter_bulan_listrik').on('change', function() {
            fetchTrendListrik({
                bulan: this.value
            });
        });
        $('#filter_bulan_chemical').on('change', function() {
            fetchTrendChemical({
                bulan: this.value
            });
        });

        // === Tambahin event listener filter date-range ===

        // Air Proses & Support
        $("#applyAirRange").on("click", function() {
            const start = $("#startDateAir").val();
            const end = $("#endDateAir").val();
            if (!start || !end) {
                alert("Pilih tanggal awal & akhir!");
                return;
            }
            $("#selectedBulanAir").text(`${start} s/d ${end}`);
            fetchAir(start, end);
        });

        // Air Raw
        $("#applyAirRawRange").on("click", function() {
            const start = $("#startDateAirRaw").val();
            const end = $("#endDateAirRaw").val();
            if (!start || !end) {
                alert("Pilih tanggal awal & akhir!");
                return;
            }
            $("#selectedBulanAirRaw").text(`${start} s/d ${end}`);
            fetchAirRaw(start, end);
        });

        // Listrik
        $("#applyListrikRange").on("click", function() {
            const start = $("#startDateListrik").val();
            const end = $("#endDateListrik").val();
            if (!start || !end) {
                alert("Pilih tanggal awal & akhir!");
                return;
            }
            $("#selectedBulanListrik").text(`${start} s/d ${end}`);
            fetchListrik(start, end);
        });

        // Chemical
        $("#applyChemicalRange").on("click", function() {
            const start = $("#startDateChemical").val();
            const end = $("#endDateChemical").val();
            if (!start || !end) {
                alert("Pilih tanggal awal & akhir!");
                return;
            }
            $("#selectedBulanChemical").text(`${start} s/d ${end}`);
            fetchChemical(start, end);
        });
       
    });
</script>



<!-- Enhanced CSS Styles -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
        --success-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%);
        --warning-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        --danger-gradient: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        --info-gradient: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background-color: #F8FAFC;
    }

    .page-content {
        animation: fadeInUp 0.6s ease-out;
    }

    .bg-gradient-primary {
        background: var(--primary-gradient);
    }

    .bg-gradient-success {
        background: var(--success-gradient);
    }

    .bg-gradient-warning {
        background: var(--warning-gradient);
    }

    /* Enhanced Card Styles */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        background: #FFFFFF;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        border-left: 4px solid #3B82F6;
    }

    .chart-card {
        background: #FFFFFF;
    }

    .trend-card .card-header {
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
    }

    .operator-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #F9FAFB 100%);
    }

    /* Enhanced Loading States */
    .chart-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        z-index: 10;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spinner-grow {
        animation-duration: 1.5s;
    }

    /* Enhanced Operator Lists */
    .operator-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .operator-item {
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .operator-item:hover {
        background: rgba(59, 130, 246, 0.05);
        border-color: rgba(59, 130, 246, 0.2);
        transform: translateX(4px);
    }

    /* Enhanced Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-group .btn.active {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        transform: scale(0.95);
    }

    /* Enhanced Dropdowns */
    .dropdown-menu {
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border-radius: 12px;
        padding: 1rem;
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.95);
    }

    .dropdown-toggle::after {
        transition: transform 0.2s ease;
    }

    .dropdown[aria-expanded="true"] .dropdown-toggle::after {
        transform: rotate(180deg);
    }

    /* Enhanced Form Controls */
    .form-control {
        border-radius: 8px;
        border: 2px solid #E2E8F0;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .form-control:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: scale(1.02);
    }

    /* Enhanced Breadcrumbs */
    .breadcrumb {
        background: transparent;
        margin: 0;
    }

    .breadcrumb-item a {
        text-decoration: none;
        transition: opacity 0.2s ease;
    }

    .breadcrumb-item a:hover {
        opacity: 0.8;
    }

    /* Enhanced Avatar */
    .avatar-xs {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }

    /* Custom Tooltip */
    .custom-tooltip {
        background: #1F2937;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        font-size: 13px;
    }

    .tooltip-header {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .tooltip-value {
        font-weight: 700;
        color: #60A5FA;
    }

    /* Enhanced Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 4px;
        transition: background 0.2s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }

    /* Enhanced Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .card {
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .page-title-box {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .dropdown-menu {
            min-width: 280px !important;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .apex-charts {
            height: 300px !important;
        }
    }

    /* Dark mode support (if needed) */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #0F172A;
            --card-bg: #1E293B;
            --text-color: #F1F5F9;
        }
    }

    /* Utility Classes */
    .tracking-wide {
        letter-spacing: 0.05em;
    }

    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

@endsection