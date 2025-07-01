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
            <div class="col-xxl-4 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Top 5 Pemakaian Air
                        </h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownPemakaianListrik">
                                    <span class="fw-semibold text-uppercase fs-12">Sort by: </span>
                                    <span class="text-muted" id="selectedBulan">Bulan Ini<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" id="bulan-dropdown">
                                    <a class="dropdown-item" href="#" data-bulan="2025-06">Juni 2025</a>
                                    <a class="dropdown-item" href="#" data-bulan="2025-05">Mei 2025</a>
                                    <a class="dropdown-item" href="#" data-bulan="2025-04">April 2025</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body pb-0">
                        <div id="pemakaian-air-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>

            <div class="col-xxl-4 col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Top 5 Pemakaian Listrik
                        </h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownPemakaianListrik">
                                    <span class="fw-semibold text-uppercase fs-12">Sort by: </span>
                                    <span class="text-muted" id="selectedBulanListrik">Bulan Ini<i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" id="bulan-dropdown-listrik">
                                    <a class="dropdown-item" href="#" data-bulan="2025-06">Juni 2025</a>
                                    <a class="dropdown-item" href="#" data-bulan="2025-05">Mei 2025</a>
                                    <a class="dropdown-item" href="#" data-bulan="2025-04">April 2025</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body pb-0">
                        <div id="pemakaian-listrik-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end page title -->
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
            <!-- end col -->
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


    <!-- container-fluid -->
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let chartPemakaianAir = null;
    let chartListrik = null;

    function fetchPemakaianAir(bulan = null) {
        const url = "{{ url('eng/top5/air') }}" + (bulan ? `?bulan=${bulan}` : '');

        $.getJSON(url, function(data) {
            const labels = data.map(d => d.jenis_pemakaian);
            const values = data.map(d => parseFloat(d.total_pemakaian));
            renderBarChart(labels, values);
        });
    }

    function loadTop5Listrik(bulan = '2025-06') {
        $.ajax({
            url: '/eng/top5/listrik',
            type: 'GET',
            data: {
                bulan: bulan
            },
            success: function(data) {
                const labels = data.slice(0, 5).map(item => item.panel_type);
                const usage = data.slice(0, 5).map(item => item.total_usage);

                const optionsListrik = {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 500,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '50%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    series: [{
                        name: 'Pemakaian (mWh)',
                        data: usage
                    }],
                    xaxis: {
                        categories: labels
                    },
                    fill: {
                        opacity: 1,
                        colors: ['#FEB019']
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " mWh"
                            }
                        }
                    }
                };

                if (chartListrik) {
                    chartListrik.updateOptions({
                        xaxis: {
                            categories: labels
                        },
                        series: [{
                            name: 'Pemakaian (mWh)',
                            data: usage
                        }]
                    }, true, true);
                } else {
                    chartListrik = new ApexCharts(document.querySelector("#pemakaian-listrik-chart"), optionsListrik);
                    chartListrik.render();
                }
            },
            error: function() {
                console.error("Gagal memuat data pemakaian listrik.");
            }
        });
    }


    function renderBarChart(labels, values) {
        if (chartPemakaianAir) chartPemakaianAir.destroy();

        chartPemakaianAir = new ApexCharts(document.querySelector("#pemakaian-air-chart"), {
            chart: {
                type: 'bar',
                height: 300
            },
            series: [{
                name: 'Total Pemakaian',
                data: values
            }],
            xaxis: {
                categories: labels,
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px'
                },
                formatter: val => val
            },
            tooltip: {
                y: {
                    formatter: val => `${val} m³`
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%'
                }
            },
            colors: ['#008FFB']
        });

        chartPemakaianAir.render();
    }

    function loadTopOperator(utility, containerId, bulan = null) {
        const url = `{{ url('eng/top5/operator') }}/${utility}` + (bulan ? `?bulan=${bulan}` : '');

        $.getJSON(url, function(data) {
            const container = $(containerId).empty();
            if (!data.length) return container.append('<p class="text-muted">Tidak ada data.</p>');

            data.forEach(item => {
                const nama = item.created_by || item.operator || '-';
                container.append(`
                    <div class="d-flex align-items-center mb-2 small">
                        <i class="mdi mdi-account fs-4 text-primary me-3"></i>
                        <div class="flex-grow-1 d-flex justify-content-between">
                            <span>${nama}</span>
                            <span class="fw-bold">${item.jumlah_pengisian}x</span>
                        </div>
                    </div>
                `);
            });
        });
    }

    function setupTrendChart({
        selector,
        url,
        ySuffix,
        filterBtnClass,
        inputBulanId
    }) {
        const el = document.querySelector(selector);
        const chart = new ApexCharts(el, {
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [],
            xaxis: {
                type: 'datetime',
                title: {
                    text: 'Tanggal'
                }
            },
            yaxis: {
                title: {
                    text: `Total Pemakaian (${ySuffix})`
                }
            },
            tooltip: {
                shared: true,
                x: {
                    format: 'dd MMM yyyy'
                },
                y: {
                    formatter: val => `${val} ${ySuffix}`
                }
            },
            noData: {
                text: 'Memuat data...',
                style: {
                    fontSize: '14px'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            }
        });

        chart.render();

        const fetch = (params = {}) => {
            const query = $.param(params);
            $.get(`${url}${query ? '?' + query : ''}`, data => chart.updateSeries(data))
                .fail(err => console.error("Gagal load:", err.responseText));
        };

        fetch(); // initial

        $(filterBtnClass).on('click', function() {
            const range = $(this).data('range');
            const date = new Date();
            if (range === '1M') date.setMonth(date.getMonth() - 1);
            else if (range === '6M') date.setMonth(date.getMonth() - 6);
            else if (range === '1Y') date.setFullYear(date.getFullYear() - 1);
            else return fetch();

            fetch({
                bulan: date.toISOString().slice(0, 7)
            });
        });

        $(inputBulanId).on("change", function() {
            const bulan = $(this).val();
            if (bulan) fetch({
                bulan
            });
        });
    }

    $(document).ready(function() {
        // Load awal
        fetchPemakaianAir();
        loadTop5Listrik();

        loadTopOperator('air', '#top-operator-list');
        loadTopOperator('listrik', '#top-operator-listrik');
        loadTopOperator('chemical', '#top-operator-chemical');

        // Dropdown pemakaian air
        $('#bulan-dropdown .dropdown-item').on('click', function() {
            const bulan = $(this).data('bulan');
            $('#selectedBulan').html(`${$(this).text()}<i class="mdi mdi-chevron-down ms-1"></i>`);
            $("#pemakaian-air-chart").empty();
            fetchPemakaianAir(bulan);
        });
        // Dropdown filter bulan
        $('#bulan-dropdown-listrik a').on('click', function(e) {
            e.preventDefault();
            const bulan = $(this).data('bulan');
            $('#selectedBulanListrik').text($(this).text());
            $("#pemakaian-listrik-chart").empty(); // hapus chart lama
            loadTop5Listrik(bulan);
        });

        // Filter operator air
        $('#filterBulanOperator').on('change', function() {
            loadTopOperator('air', '#top-operator-list', $(this).val());
        });

        // Setup semua chart tren
        setupTrendChart({
            selector: "#pemakaian_air_chart",
            url: "{{ url('/eng/trend-pemakaian-air') }}",
            ySuffix: "m³",
            filterBtnClass: ".filter-btn",
            inputBulanId: "#filter_bulan"
        });

        setupTrendChart({
            selector: "#pemakaian_listrik_chart",
            url: "{{ url('/eng/trend-pemakaian-listrik') }}",
            ySuffix: "mwh",
            filterBtnClass: ".filter-btn-listrik",
            inputBulanId: "#filter_bulan_listrik"
        });

        setupTrendChart({
            selector: "#pemakaian_chemical_chart",
            url: "{{ url('/eng/trend-pemakaian-chemical') }}",
            ySuffix: "mwh",
            filterBtnClass: ".filter-btn-chemical",
            inputBulanId: "#filter_bulan_chemical"
        });
    });
</script>



<style>
    #pemakaian_air_chart {
        max-width: 95%;

    }
</style>

@endsection