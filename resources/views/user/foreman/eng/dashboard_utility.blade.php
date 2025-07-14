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
                    <!-- end card header -->
                    <div class="card-body pb-0">
                        <div id="pemakaian-air-chart-raw" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                <!-- end card -->
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
                    <!-- end card header -->
                    <div class="card-body pb-0">
                        <div id="pemakaian-chemical-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
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
    let chartPemakaianAirRaw = null;
    let chartListrik = null;
    let chartChemical = null;

    function fetchPemakaianAir(start, end) {
        const url = `{{ url('eng/top5/air') }}?start_date=${start}&end_date=${end}`;

        $.getJSON(url, function(data) {
            const labels = data.map(d => d.jenis_pemakaian);
            const values = data.map(d => parseFloat(d.total_pemakaian));
            const tipe = "#pemakaian-air-chart";
            renderBarChart(labels, values, tipe);
        });
    }

    function fetchPemakaianAirRaw(start, end) {
        const url = `{{ url('eng/top5/air/raw') }}?start_date=${start}&end_date=${end}`;

        $.getJSON(url, function(data) {
            const labels = data.map(d => d.jenis_pemakaian);
            const values = data.map(d => parseFloat(d.total_pemakaian));
            const tipe = "#pemakaian-air-chart-raw";
            renderBarChartRaw(labels, values, tipe);
        });
    }


    function loadPemakaianListrik(start, end) {
        $.ajax({
            url: "{{url('/eng/top5/listrik')}}",
            type: 'GET',
            data: {
                start_date: start,
                end_date: end
            },
            success: function(data) {
                const labels = data.map(item => item.panel_type);
                const usage = data.map(item => item.total_usage);

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
                            formatter: val => `${val} mWh`
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

    function loadPemakaianChemical(start, end) {
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

                const optionsChemical = {
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
                        }
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
                        name: 'Pemakaian Chemical',
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
                            formatter: function(val, {
                                dataPointIndex
                            }) {
                                const unit = satuan[dataPointIndex] || '';
                                return `${val} ${unit}`;
                            }
                        }
                    }
                };

                if (chartChemical) {
                    chartChemical.updateOptions({
                        xaxis: {
                            categories: labels
                        },
                        series: [{
                            name: 'Pemakaian Chemical',
                            data: usage
                        }]
                    }, true, true);
                } else {
                    chartChemical = new ApexCharts(document.querySelector("#pemakaian-chemical-chart"), optionsChemical);
                    chartChemical.render();
                }
            },
            error: function() {
                console.error("Gagal memuat data pemakaian chemical.");
            }
        });
    }

    function renderBarChart(labels, values, tipe) {
        if (chartPemakaianAir) chartPemakaianAir.destroy();

        chartPemakaianAir = new ApexCharts(document.querySelector(tipe), {
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

    function renderBarChartRaw(labels, values, tipe) {
        if (chartPemakaianAirRaw) chartPemakaianAirRaw.destroy();

        chartPemakaianAirRaw = new ApexCharts(document.querySelector(tipe), {
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

        chartPemakaianAirRaw.render();
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
        // Load default bulan ini
        const today = new Date();
        const startDefault = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().slice(0, 10);
        const endDefault = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().slice(0, 10);

        $('#startDateAir').val(startDefault);
        $('#endDateAir').val(endDefault);
        $('#startDateListrik').val(startDefault);
        $('#endDateListrik').val(endDefault);

        fetchPemakaianAir(startDefault, endDefault);
        fetchPemakaianAirRaw(startDefault, endDefault);
        loadPemakaianListrik(startDefault, endDefault);
        loadPemakaianChemical(startDefault, endDefault);


        loadTopOperator('air', '#top-operator-list');
        loadTopOperator('listrik', '#top-operator-listrik');
        loadTopOperator('chemical', '#top-operator-chemical');

        $('#applyAirRange').on('click', function() {
            const start = $('#startDateAir').val();
            const end = $('#endDateAir').val();
            if (!start || !end) return alert("Isi rentang tanggal Air.");

            $('#selectedBulanAir').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            $("#pemakaian-air-chart").empty();
            fetchPemakaianAir(start, end);
        });

        $('#applyAirRawRange').on('click', function() {
            const start = $('#startDateAirRaw').val();
            const end = $('#endDateAirRaw').val();
            if (!start || !end) return alert("Isi rentang tanggal Air.");

            $('#selectedBulanAirRaw').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            $("#pemakaian-air-chart-raw").empty();
            fetchPemakaianAirRaw(start, end);
        });

        // Filter Listrik
        $('#applyListrikRange').on('click', function() {
            const start = $('#startDateListrik').val();
            const end = $('#endDateListrik').val();
            if (!start || !end) return alert("Isi rentang tanggal Listrik.");

            $('#selectedBulanListrik').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            $("#pemakaian-listrik-chart").empty();
            loadPemakaianListrik(start, end);
        });
        $('#applyChemicalRange').on('click', function() {
            const start = $('#startDateChemical').val();
            const end = $('#endDateChemical').val();
            if (!start || !end) return alert("Isi rentang tanggal Chemical.");

            $('#selectedBulanChemical').html(`Dari ${start} s/d ${end}<i class="mdi mdi-chevron-down ms-1"></i>`);
            $("#pemakaian-chemical-chart").empty();
            loadPemakaianListrik(start, end);
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