@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">GGA & GGAS</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Analytics
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <!-- GGA Chart -->
            <div class="col-xxl-6 mb-4">
                <div class="card card-height-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">GGA Analysis</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown">
                                <span class="fw-semibold text-uppercase fs-12">Filter</span>
                            </a>
                            <div class="dropdown-menu p-3" style="min-width: 250px;">
                                <label for="start_date_gga">Start Date</label>
                                <input type="date" id="start_date_gga" class="form-control mb-2">

                                <label for="end_date_gga">End Date</label>
                                <input type="date" id="end_date_gga" class="form-control mb-2">

                                <button class="btn btn-primary w-100" id="filter_gga">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-gga" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- GGAS Chart -->
            <div class="col-xxl-6 mb-4">
                <div class="card card-height-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">GGAS Analysis</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown">
                                <span class="fw-semibold text-uppercase fs-12">Filter</span>
                            </a>
                            <div class="dropdown-menu p-3" style="min-width: 250px;">
                                <label for="start_date_ggas">Start Date</label>
                                <input type="date" id="start_date_ggas" class="form-control mb-2">

                                <label for="end_date_ggas">End Date</label>
                                <input type="date" id="end_date_ggas" class="form-control mb-2">

                                <button class="btn btn-primary w-100" id="filter_ggas">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-ggas" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- GGA Disposition -->
            <div class="col-xxl-6 mb-4">
                <div class="card card-height-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">GGA Disposition Analysis</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown">
                                <span class="fw-semibold text-uppercase fs-12">Filter</span>
                            </a>
                            <div class="dropdown-menu p-3" style="min-width: 250px;">
                                <label for="start_date_gga_disposisi">Start Date</label>
                                <input type="date" id="start_date_gga_disposisi" class="form-control mb-2">

                                <label for="end_date_gga_disposisi">End Date</label>
                                <input type="date" id="end_date_gga_disposisi" class="form-control mb-2">

                                <button class="btn btn-primary w-100" id="filter_gga_disposisi">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="disposition-gga" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- GGAS Disposition -->
            <div class="col-xxl-6 mb-4">
                <div class="card card-height-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">GGAS Disposition Analysis</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-muted" data-bs-toggle="dropdown">
                                <span class="fw-semibold text-uppercase fs-12">Filter</span>
                            </a>
                            <div class="dropdown-menu p-3" style="min-width: 250px;">
                                <label for="start_date_ggas_disposisi">Start Date</label>
                                <input type="date" id="start_date_ggas_disposisi" class="form-control mb-2">

                                <label for="end_date_ggas_disposisi">End Date</label>
                                <input type="date" id="end_date_ggas_disposisi" class="form-control mb-2">

                                <button class="btn btn-primary w-100" id="filter_ggas_disposisi">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="disposition-ggas" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>


<script>
    $(document).ready(function() {

        // Load data awal
        fetchChartData('gga');
        fetchChartData('ggas');

        // Event filter GGA
        $('#filter_gga').on('click', function() {
            let start = $('#start_date_gga').val();
            let end = $('#end_date_gga').val();
            fetchChartData('gga', start, end);
        });

        // Event filter GGAS
        $('#filter_ggas').on('click', function() {
            let start = $('#start_date_ggas').val();
            let end = $('#end_date_ggas').val();
            fetchChartData('ggas', start, end);
        });

        // Ambil data & render chart
        function fetchChartData(type, startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/ggas/gga/analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const data = type === 'gga' ? response.gga : response.ggas;
                renderChart(`#chart-${type}`, data, type.toUpperCase());
            });
        }

        // Render ApexChart
        function renderChart(selector, data, title) {
            const categories = data.map(item => `Batch ${item.batch_number} - ${item.variant} (PO: ${item.po_number})`);

            const brixSeries = data.map(item => isNaN(parseFloat(item.brix)) ? 0 : parseFloat(item.brix));
            const naclSeries = data.map(item => isNaN(parseFloat(item.nacl)) ? 0 : parseFloat(item.nacl));

            const metaData = data.map(item => ({
                po: item.po_number,
                variant: item.variant,
                label: `Batch ${item.batch_number} - ${item.variant} (PO: ${item.po_number})`
            }));

            const options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                        name: 'Brix',
                        data: brixSeries
                    },
                    {
                        name: 'NaCl',
                        data: naclSeries
                    }
                ],
                xaxis: {
                    categories: categories,
                    type: 'category'
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: `${title} Brix & NaCl`,
                    align: 'left'
                },
                tooltip: {
                    shared: true,
                    custom: function({
                        series,
                        dataPointIndex
                    }) {
                        const brix = series[0][dataPointIndex];
                        const nacl = series[1][dataPointIndex];
                        const meta = metaData[dataPointIndex];

                        return `
                    <div class="apex-tooltip">
                        <strong>${meta.label}</strong><br/>
                        Brix: ${brix.toFixed(2)} °Bx<br/>
                        NaCl: ${nacl.toFixed(2)} °Bx<br/>
                        PO Number: ${meta.po}<br/>
                        Variant: ${meta.variant}
                    </div>
                `;
                    }
                }
            };

            $(selector).html('');
            new ApexCharts(document.querySelector(selector), options).render();
        }
        // Load default disposisi
        fetchDispositionData('gga');
        fetchDispositionData('ggas');

        // Event filter disposisi GGA
        $('#filter_gga_disposisi').on('click', function() {
            let start = $('#start_date_gga_disposisi').val();
            let end = $('#end_date_gga_disposisi').val();
            fetchDispositionData('gga', start, end);
        });

        // Event filter disposisi GGAS
        $('#filter_ggas_disposisi').on('click', function() {
            let start = $('#start_date_ggas_disposisi').val();
            let end = $('#end_date_ggas_disposisi').val();
            fetchDispositionData('ggas', start, end);
        });

        // Ambil data & render chart disposisi
        function fetchDispositionData(type, startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/ggas/gga/disposition-analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const data = type === 'gga' ? response.gga : response.ggas;
                renderBarChartDisposisi(`#disposition-${type}`, data, type.toUpperCase());
            });
        }

        // Render chart batang disposisi
        function renderBarChartDisposisi(selector, data, title) {
            const labels = Object.keys(data);
            const counts = Object.values(data);

            const options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Jumlah',
                    data: counts
                }],
                xaxis: {
                    categories: labels,
                    title: {
                        text: 'Disposition Type'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Total Cases'
                    }
                },
                title: {
                    text: `${title} Disposition Summary`,
                    align: 'left'
                },
                colors: ['#0AB39C'],
                tooltip: {
                    y: {
                        formatter: val => `${val} kasus`
                    }
                }
            };

            $(selector).html('');
            new ApexCharts(document.querySelector(selector), options).render();
        }

    });
</script>
@endsection