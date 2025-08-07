@extends('layout')


@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blending Awal</h4>

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
            <div class="col-xxl-12 mx-auto">
                <div class="card card-height-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Blending Awal Disposition Analysis</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-disposition-blending" class="apex-charts" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <!-- Filter Tanggal -->
            <div class="col-12 mb-4">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" class="form-control">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100" id="filter-data">Apply Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Container -->
            @php
            $parameters = ['brix', 'nacl', 'bj', 'visco', 'aw', 'buih', 'organo', 'ph'];
            @endphp

            @foreach ($parameters as $param)
            <div class="col-xxl-6 mb-4">
                <div class="card card-height-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0 text-capitalize">{{ strtoupper($param) }} Analysis</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-{{ $param }}" class="apex-charts" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>

<script>
    $(document).ready(function() {
        const params = ['brix', 'nacl', 'bj', 'visco', 'aw', 'buih', 'organo', 'ph'];

        // Load default grafik blending awal & disposisi
        fetchBlendingData();
        fetchDispositionData();

        // Filter event
        $('#filter-data').on('click', function() {
            const start = $('#start_date').val();
            const end = $('#end_date').val();

            fetchBlendingData(start, end);
            fetchDispositionData(start, end);
        });

        // 🔍 Ambil data blending dan render line chart per parameter
        function fetchBlendingData(startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/blending/awal/analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const data = response.blending_awal;

                params.forEach(param => {
                    const seriesData = data
                        .filter(d => d[param] !== null)
                        .map(item => ({
                            x: `Batch ${item.batch_range} (No ${item.nomor_blending})`,
                            y: parseFloat(item[param]),
                            meta: {
                                po: item.po_number,
                                variant: item.variant
                            }
                        }));

                    renderLineChart(`#chart-${param}`, seriesData, param.toUpperCase());
                });
            });
        }

        // 📊 Ambil data disposisi dan render bar chart
        function fetchDispositionData(startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/blending/awal/disposition-analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const summary = response.disposition_summary || {};
                const labels = Object.keys(summary);
                const counts = Object.values(summary);

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
                        text: 'Blending Awal Disposition Summary',
                        align: 'left'
                    },
                    colors: ['#0AB39C'],
                    tooltip: {
                        y: {
                            formatter: val => `${val} kasus`
                        }
                    }
                };

                $('#chart-disposition-blending').html('');
                new ApexCharts(document.querySelector('#chart-disposition-blending'), options).render();
            });
        }

        // 📈 Fungsi render line chart
        function renderLineChart(selector, seriesData, title) {
            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                    name: title,
                    data: seriesData
                }],
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: `${title} Trend`,
                    align: 'left'
                },
                markers: {
                    size: 4,
                    hover: {
                        size: 6
                    }
                },
                xaxis: {
                    type: 'category',
                    title: {
                        text: 'Blending Number / Range'
                    }
                },
                yaxis: {
                    title: {
                        text: title
                    }
                },
                tooltip: {
                    shared: false,
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        const item = w.config.series[seriesIndex].data[dataPointIndex];
                        if (!item || typeof item.y === 'undefined') {
                            return `<div class="apex-tooltip">Data tidak tersedia</div>`;
                        }

                        return `
                        <div class="apex-tooltip">
                            <strong>${title}: ${item.y.toFixed(2)}</strong><br/>
                            PO Number: ${item.meta?.po || '-' }<br/>
                            Variant: ${item.meta?.variant || '-' }
                        </div>
                    `;
                    }
                }
            };

            $(selector).html('');
            new ApexCharts(document.querySelector(selector), options).render();
        }
    });
</script>
@endsection