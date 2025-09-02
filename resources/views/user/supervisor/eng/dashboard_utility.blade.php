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
                                Utility
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-6 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Pemakaian Air Proses & Support Utility</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownPemakaianAir">
                                    <span class="fw-semibold text-uppercase fs-12">Filter:</span>
                                    <span class="text-muted" id="selectedBulanAir">Pilih Tanggal<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;">
                                    <div class="mb-2">
                                        <label for="startDateAir" class="form-label mb-0">Dari:</label>
                                        <input type="date" id="startDateAir" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-2">
                                        <label for="endDateAir" class="form-label mb-0">Sampai:</label>
                                        <input type="date" id="endDateAir" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100" id="applyAirRange">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="chart-loading" id="loading-air" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data...</p>
                            </div>
                        </div>
                        <div id="pemakaian-air-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Air Raw
                        </h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownPemakaianAirRaw">
                                    <span class="fw-semibold text-uppercase fs-12">Filter:</span>
                                    <span class="text-muted" id="selectedBulanAirRaw">Pilih Tanggal<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;">
                                    <div class="mb-2">
                                        <label for="startDateAirRaw" class="form-label mb-0">Dari:</label>
                                        <input type="date" id="startDateAirRaw" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-2">
                                        <label for="endDateAirRaw" class="form-label mb-0">Sampai:</label>
                                        <input type="date" id="endDateAirRaw" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100" id="applyAirRawRange">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="chart-loading" id="loading-air-raw" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data...</p>
                            </div>
                        </div>
                        <div id="pemakaian-air-chart-raw" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Pemakaian Listrik</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownPemakaianListrik">
                                    <span class="fw-semibold text-uppercase fs-12">Filter:</span>
                                    <span class="text-muted" id="selectedBulanListrik">Pilih Tanggal<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;">
                                    <div class="mb-2">
                                        <label for="startDateListrik" class="form-label mb-0">Dari:</label>
                                        <input type="date" id="startDateListrik" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-2">
                                        <label for="endDateListrik" class="form-label mb-0">Sampai:</label>
                                        <input type="date" id="endDateListrik" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100" id="applyListrikRange">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="chart-loading" id="loading-listrik" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data...</p>
                            </div>
                        </div>
                        <div id="pemakaian-listrik-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Chemical
                        </h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownPemakaianChemical">
                                    <span class="fw-semibold text-uppercase fs-12">Filter:</span>
                                    <span class="text-muted" id="selectedBulanChemical">Pilih Tanggal<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;">
                                    <div class="mb-2">
                                        <label for="startDateChemical" class="form-label mb-0">Dari:</label>
                                        <input type="date" id="startDateChemical" class="form-control form-control-sm">
                                    </div>
                                    <div class="mb-2">
                                        <label for="endDateChemical" class="form-label mb-0">Sampai:</label>
                                        <input type="date" id="endDateChemical" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100" id="applyChemicalRange">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="chart-loading" id="loading-chemical" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data...</p>
                            </div>
                        </div>
                        <div id="pemakaian-chemical-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend Charts Section -->
        <div class="row">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Trend Pemakaian Air</h4>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-soft-secondary btn-sm shadow-none filter-btn" data-range="1M">1M</button>
                            <input type="month" id="filter_bulan" class="form-control form-control-sm ms-2" style="width: auto;">
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div class="chart-loading" id="loading-trend-air" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data trend...</p>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div id="pemakaian_air_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2">
                <div class="card card-height-100">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Operator Air</h5>
                        <div id="top-operator-list" class="px-2 py-2 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-2">
                <div class="card card-height-100">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Operator Listrik</h5>
                        <div id="top-operator-listrik" class="px-2 py-2 mt-2"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Trend Pemakaian Listrik</h4>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-soft-secondary btn-sm shadow-none filter-btn-listrik" data-range="1M">1M</button>
                            <input type="month" id="filter_bulan_listrik" class="form-control form-control-sm ms-2" style="width: auto;">
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div class="chart-loading" id="loading-trend-listrik" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data trend...</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <div id="pemakaian_listrik_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Trend Pemakaian Chemical</h4>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-soft-secondary btn-sm shadow-none filter-btn-chemical" data-range="1M">1M</button>
                            <input type="month" id="filter_bulan_chemical" class="form-control form-control-sm ms-2" style="width: auto;">
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div class="chart-loading" id="loading-trend-chemical" style="display: none;">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Memuat data trend...</p>
                            </div>
                        </div>
                        <div class="w-100">
                            <div id="pemakaian_chemical_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card card-height-100">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Operator Chemical</h5>
                        <div id="top-operator-chemical" class="px-2 py-2 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Global chart variables
    let chartInstances = {
        pemakaianAir: null,
        pemakaianAirRaw: null,
        pemakaianListrik: null,
        pemakaianChemical: null,
        trendAir: null,
        trendListrik: null,
        trendChemical: null
    };

    // Utility functions for smooth loading
    function showLoading(loaderId) {
        $(`#${loaderId}`).fadeIn(200);
    }

    function hideLoading(loaderId) {
        $(`#${loaderId}`).fadeOut(300);
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Enhanced chart rendering with smooth animations
    function createChartOptions(type = 'bar') {
        const baseOptions = {
            chart: {
                type: type,
                height: 300,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 100
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 400
                    }
                },
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 3,
                    left: 2,
                    blur: 4,
                    opacity: 0.1,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded',
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: type === 'line' ? 3 : 2,
                colors: type === 'line' ? undefined : ['transparent'],
                curve: type === 'line' ? 'smooth' : undefined
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 3,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
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
            fill: {
                opacity: 0.9,
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: undefined,
                    inverseColors: false,
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100]
                }
            },
            tooltip: {
                theme: 'light',
                style: {
                    fontSize: '12px'
                },
                marker: {
                    show: true
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 250
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '70%'
                        }
                    }
                }
            }]
        };

        return baseOptions;
    }

    // Enhanced fetch functions with loading states
    function fetchPemakaianAir(start, end) {
        showLoading('loading-air');
        const url = `{{ url('eng/top5/air') }}?start_date=${start}&end_date=${end}`;

        $.getJSON(url)
            .done(function(data) {
                const filtered = data.filter(item => item.panel_type !== "Outlet Fresh Water 2");
                const labels = filtered.map(d => d.jenis_pemakaian);
                const values = filtered.map(d => parseFloat(d.total_pemakaian));
                const meta = filtered.map(d => ({
                    start_date: d.start_date,
                    end_date: d.end_date
                }));

                renderBarChart(labels, values, "#pemakaian-air-chart", 'pemakaianAir', 'm³', meta);
            })
            .fail(() => console.error("Gagal memuat data pemakaian air."))
            .always(() => hideLoading('loading-air'));
    }


    function fetchPemakaianAirRaw(start, end) {
        showLoading('loading-air-raw');
        const url = `{{ url('eng/top5/air/raw') }}?start_date=${start}&end_date=${end}`;

        $.getJSON(url)
            .done(function(data) {
                const labels = data.map(d => d.jenis_pemakaian);
                const values = data.map(d => parseFloat(d.total_pemakaian));
                const meta = data.map(d => ({
                    start_date: d.start_date,
                    end_date: d.end_date
                }));

                renderBarChart(labels, values, "#pemakaian-air-chart-raw", 'pemakaianAirRaw', 'm³', meta);
            })
            .fail(() => console.error("Gagal memuat data pemakaian air raw."))
            .always(() => hideLoading('loading-air-raw'));
    }

    function loadPemakaianListrik(start, end) {
        showLoading('loading-listrik');

        $.ajax({
            url: "{{url('/eng/top5/listrik')}}",
            type: 'GET',
            data: {
                start_date: start,
                end_date: end
            },
            success: function(data) {
                const filtered = data.filter(item => item.panel_type !== "MDP");

                const labels = filtered.map(item => item.panel_type);
                const usage = filtered.map(item => item.total_usage);
                const meta = filtered.map(d => ({
                    start_date: d.start_date,
                    end_date: d.end_date
                }));

                renderBarChart(labels, usage, "#pemakaian-listrik-chart", 'pemakaianListrik', 'mWh', meta);
            },
            error: function() {
                console.error("Gagal memuat data pemakaian listrik.");
            },
            complete: function() {
                hideLoading('loading-listrik');
            }
        });
    }

    function loadPemakaianChemical(start, end) {
        showLoading('loading-chemical');

        $.ajax({
            url: "{{url('/eng/top5/chemical')}}",
            type: 'GET',
            data: {
                start_date: start,
                end_date: end
            },
            success: function(data) {
                const labels = data.map(item => item.jenis_pemakaian);
                const usage = data.map(item => item.total_pemakaian);
                const satuan = data.map(item => item.satuan);
                const meta = data.map(d => ({
                    start_date: d.start_date,
                    end_date: d.end_date
                }));

                // ambil satuan pertama sebagai default
                const unit = satuan.length > 0 ? satuan[0] : '';

                renderBarChart(
                    labels,
                    usage,
                    "#pemakaian-chemical-chart",
                    "pemakaianChemical",
                    unit,
                    meta // kirim supaya tooltip bisa render periode
                );
            },
            error: function() {
                console.error("Gagal memuat data pemakaian chemical.");
            },
            complete: function() {
                hideLoading('loading-chemical');
            }
        });
    }


    function renderBarChart(labels, values, selector, instanceKey, unit, meta = null) {
        const options = createChartOptions('bar');
        options.series = [{
            name: `Total Pemakaian (${unit})`,
            data: values
        }];
        options.xaxis.categories = labels;
        options.colors = ['#008FFB'];

        // Tooltip custom
        options.tooltip = {
            custom: function({
                series,
                seriesIndex,
                dataPointIndex,
                w
            }) {
                const value = series[seriesIndex][dataPointIndex];
                let html = `<div class="px-2 py-1">
                          <b>${labels[dataPointIndex]}</b><br/>
                          Total: ${value} ${unit}`;

                // kalau meta (start_date & end_date) ada, render periode
                if (meta && meta[dataPointIndex]) {
                    const {
                        start_date,
                        end_date
                    } = meta[dataPointIndex];
                    if (start_date && end_date) {
                        html += `<br/>Periode: ${start_date} s/d ${end_date}`;
                    }
                }

                html += "</div>";
                return html;
            }
        };

        if (chartInstances[instanceKey]) {
            chartInstances[instanceKey].updateOptions(options, true, true);
        } else {
            chartInstances[instanceKey] = new ApexCharts(document.querySelector(selector), options);
            chartInstances[instanceKey].render();
        }
    }

    function loadTopOperator(utility, containerId, bulan = null) {
        const url = `{{ url('eng/top5/operator') }}/${utility}` + (bulan ? `?bulan=${bulan}` : '');

        $.getJSON(url)
            .done(function(data) {
                const container = $(containerId);
                container.fadeOut(200, function() {
                    container.empty();
                    if (!data.length) {
                        container.append('<p class="text-muted">Tidak ada data.</p>');
                    } else {
                        data.forEach(item => {
                            const nama = item.created_by || item.operator || '-';
                            container.append(`
                                <div class="d-flex align-items-center mb-2 small operator-item" style="opacity: 0;">
                                    <i class="mdi mdi-account fs-4 text-primary me-3"></i>
                                    <div class="flex-grow-1 d-flex justify-content-between">
                                        <span>${nama}</span>
                                        <span class="fw-bold">${item.jumlah_pengisian}x</span>
                                    </div>
                                </div>
                            `);
                        });

                        // Animate operator items
                        container.find('.operator-item').each(function(index) {
                            $(this).delay(index * 100).animate({
                                opacity: 1
                            }, 300);
                        });
                    }
                    container.fadeIn(300);
                });
            })
            .fail(function() {
                console.error(`Gagal memuat data operator ${utility}.`);
            });
    }

    function setupTrendChart({
        selector,
        url,
        ySuffix,
        filterBtnClass,
        inputBulanId,
        instanceKey,
        loadingId
    }) {
        const el = document.querySelector(selector);
        const options = createChartOptions('line');

        options.chart.height = 350;
        options.series = [];
        options.xaxis = {
            type: 'datetime',
            title: {
                text: 'Tanggal'
            },
            labels: {
                style: {
                    fontSize: '12px',
                    colors: '#8c9097'
                }
            }
        };
        options.yaxis = {
            title: {
                text: `Total Pemakaian (${ySuffix})`
            },
            labels: {
                style: {
                    fontSize: '12px',
                    colors: '#8c9097'
                }
            }
        };
        options.tooltip = {
            shared: true,
            x: {
                format: 'dd MMM yyyy'
            },
            y: {
                formatter: val => `${val} ${ySuffix}`
            }
        };
        options.colors = ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"];
        options.legend = {
            position: 'top',
            horizontalAlign: 'center'
        };
        options.noData = {
            text: 'Memuat data...',
            style: {
                fontSize: '14px'
            }
        };

        const chart = new ApexCharts(el, options);
        chart.render();
        chartInstances[instanceKey] = chart;

        const debouncedFetch = debounce((params = {}) => {
            if (loadingId) showLoading(loadingId);

            const query = $.param(params);
            $.get(`${url}${query ? '?' + query : ''}`)
                .done(data => {
                    chart.updateSeries(data, true);
                })
                .fail(err => console.error("Gagal load:", err.responseText))
                .always(() => {
                    if (loadingId) hideLoading(loadingId);
                });
        }, 300);

        // Initial load
        debouncedFetch();

        // Event handlers
        $(filterBtnClass).on('click', function() {
            const range = $(this).data('range');
            const date = new Date();

            if (range === '1M') date.setMonth(date.getMonth() - 1);
            else if (range === '6M') date.setMonth(date.getMonth() - 6);
            else if (range === '1Y') date.setFullYear(date.getFullYear() - 1);
            else return debouncedFetch();

            debouncedFetch({
                bulan: date.toISOString().slice(0, 7)
            });
        });

        $(inputBulanId).on("change", function() {
            const bulan = $(this).val();
            if (bulan) debouncedFetch({
                bulan
            });
        });
    }

    // Document ready
    $(document).ready(function() {
        // Set default dates
        const today = new Date();
        const startDefault = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().slice(0, 10);
        const endDefault = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().slice(0, 10);

        // Set input values
        $('#startDateAir, #startDateAirRaw, #startDateListrik, #startDateChemical').val(startDefault);
        $('#endDateAir, #endDateAirRaw, #endDateListrik, #endDateChemical').val(endDefault);

        // Load initial data with staggered timing for smooth loading
        setTimeout(() => fetchPemakaianAir(startDefault, endDefault), 100);
        setTimeout(() => fetchPemakaianAirRaw(startDefault, endDefault), 200);
        setTimeout(() => loadPemakaianListrik(startDefault, endDefault), 300);
        setTimeout(() => loadPemakaianChemical(startDefault, endDefault), 400);

        // Load operators
        setTimeout(() => loadTopOperator('air', '#top-operator-list'), 500);
        setTimeout(() => loadTopOperator('listrik', '#top-operator-listrik'), 600);
        setTimeout(() => loadTopOperator('chemical', '#top-operator-chemical'), 700);

        // Filter event handlers with debouncing
        const debouncedAirFilter = debounce(function() {
            const start = $('#startDateAir').val();
            const end = $('#endDateAir').val();
            if (!start || !end) return alert("Isi rentang tanggal Air.");

            $('#selectedBulanAir').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            fetchPemakaianAir(start, end);
        }, 300);

        const debouncedAirRawFilter = debounce(function() {
            const start = $('#startDateAirRaw').val();
            const end = $('#endDateAirRaw').val();
            if (!start || !end) return alert("Isi rentang tanggal Air Raw.");

            $('#selectedBulanAirRaw').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            fetchPemakaianAirRaw(start, end);
        }, 300);

        const debouncedListrikFilter = debounce(function() {
            const start = $('#startDateListrik').val();
            const end = $('#endDateListrik').val();
            if (!start || !end) return alert("Isi rentang tanggal Listrik.");

            $('#selectedBulanListrik').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            loadPemakaianListrik(start, end);
        }, 300);

        const debouncedChemicalFilter = debounce(function() {
            const start = $('#startDateChemical').val();
            const end = $('#endDateChemical').val();
            if (!start || !end) return alert("Isi rentang tanggal Chemical.");

            $('#selectedBulanChemical').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            loadPemakaianChemical(start, end);
        }, 300);

        // Bind events
        $('#applyAirRange').on('click', debouncedAirFilter);
        $('#applyAirRawRange').on('click', debouncedAirRawFilter);
        $('#applyListrikRange').on('click', debouncedListrikFilter);
        $('#applyChemicalRange').on('click', debouncedChemicalFilter);

        // Filter operator air
        $('#filterBulanOperator').on('change', function() {
            loadTopOperator('air', '#top-operator-list', $(this).val());
        });

        // Setup trend charts with staggered initialization
        setTimeout(() => {
            setupTrendChart({
                selector: "#pemakaian_air_chart",
                url: "{{ url('/eng/trend-pemakaian-air') }}",
                ySuffix: "m³",
                filterBtnClass: ".filter-btn",
                inputBulanId: "#filter_bulan",
                instanceKey: "trendAir",
                loadingId: "loading-trend-air"
            });
        }, 800);

        setTimeout(() => {
            setupTrendChart({
                selector: "#pemakaian_listrik_chart",
                url: "{{ url('/eng/trend-pemakaian-listrik') }}",
                ySuffix: "mWh",
                filterBtnClass: ".filter-btn-listrik",
                inputBulanId: "#filter_bulan_listrik",
                instanceKey: "trendListrik",
                loadingId: "loading-trend-listrik"
            });
        }, 1000);

        setTimeout(() => {
            setupTrendChart({
                selector: "#pemakaian_chemical_chart",
                url: "{{ url('/eng/trend-pemakaian-chemical') }}",
                ySuffix: "kg",
                filterBtnClass: ".filter-btn-chemical",
                inputBulanId: "#filter_bulan_chemical",
                instanceKey: "trendChemical",
                loadingId: "loading-trend-chemical"
            });
        }, 1200);

        // Handle window resize for responsive charts
        $(window).on('resize', debounce(function() {
            Object.values(chartInstances).forEach(chart => {
                if (chart && chart.resize) {
                    chart.resize();
                }
            });
        }, 250));

        // Add smooth scroll behavior for better UX
        $('html').css('scroll-behavior', 'smooth');

        // Enhance dropdown animations
        $('.dropdown').on('show.bs.dropdown', function() {
            $(this).find('.dropdown-menu').addClass('animate__animated animate__fadeIn animate__faster');
        });

        $('.dropdown').on('hide.bs.dropdown', function() {
            $(this).find('.dropdown-menu').removeClass('animate__animated animate__fadeIn animate__faster');
        });
    });

    // Cleanup function when page unloads
    $(window).on('beforeunload', function() {
        Object.values(chartInstances).forEach(chart => {
            if (chart && chart.destroy) {
                chart.destroy();
            }
        });
    });
</script>

<style>
    /* Enhanced styling for smooth animations */
    .apex-charts {
        max-width: 100%;
        transition: all 0.3s ease-in-out;
    }

    .chart-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        z-index: 10;
        border-radius: 8px;
    }

    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .operator-item {
        transition: all 0.3s ease;
        border-radius: 6px;
        padding: 8px;
        margin: 4px 0;
    }

    .operator-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .spinner-border {
        animation-duration: 0.8s;
    }

    /* Loading animation keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-body {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .apex-charts {
            height: 250px !important;
        }

        .card {
            margin-bottom: 1rem;
        }

        .dropdown-menu {
            min-width: 250px !important;
        }
    }

    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Smooth focus styles */
    .form-control:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        transition: all 0.2s ease;
    }

    /* Page transition */
    .page-content {
        animation: fadeInUp 0.8s ease-out;
    }
</style>

@endsection