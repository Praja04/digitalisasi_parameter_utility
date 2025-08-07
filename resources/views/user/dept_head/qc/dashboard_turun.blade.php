@extends('layout')


@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Monitoring Turun Blending</h4>

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
                        <h4 class="card-title mb-0">Monitoring Turun Blending Disposition Analysis</h4>
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
        const parameterList = ['brix', 'nacl', 'bj', 'visco', 'aw', 'buih', 'organo', 'ph'];

        // ⏱️ Load awal tanpa filter
        loadMonitoringCharts();
        loadDispositionChart();

        // 🎯 Event filter berdasarkan tanggal
        $('#filter-data').on('click', function() {
            const start = $('#start_date').val();
            const end = $('#end_date').val();

            loadMonitoringCharts(start, end);
            loadDispositionChart(start, end);
        });

        // 📈 Load grafik line per parameter dari monitoring_turun_blending
        function loadMonitoringCharts(startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/monitoring/turun/analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const monitoringData = response.monitoring_turun_blending || [];

                parameterList.forEach(parameter => {
                    const series = monitoringData
                        .filter(entry => entry[parameter] !== null)
                        .map(entry => ({
                            x: `Batch ${entry.batch_range} • Shift ${entry.shift}`,
                            y: parseFloat(entry[parameter]),
                            meta: {
                                po: entry.po_number,
                                variant: entry.variant
                            }
                        }));

                    renderLineChart(`#chart-${parameter}`, series, parameter.toUpperCase());
                });
            });
        }

        // 📊 Load chart batang untuk disposisi
        function loadDispositionChart(startDate = null, endDate = null) {
            let url = "http://10.11.10.130:8081/public/api/monitoring/turun/disposition-analysis";
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            $.getJSON(url, function(response) {
                const disposition = response.disposition_summary || {};
                const labels = Object.keys(disposition);
                const values = Object.values(disposition);

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Jumlah',
                        data: values
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
                        text: 'Monitoring Turun Blending Disposition Summary',
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

        // 🧭 Render line chart per parameter
        function renderLineChart(selector, data, title) {
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
                    data: data
                }],
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 4,
                    hover: {
                        size: 6
                    }
                },
                title: {
                    text: `${title} Trend`,
                    align: 'left'
                },
                xaxis: {
                    type: 'category',
                    title: {
                        text: 'Batch Range'
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
                        const point = w.config.series[seriesIndex].data[dataPointIndex];
                        if (!point || typeof point.y === 'undefined') {
                            return `<div class="apex-tooltip">Data tidak tersedia</div>`;
                        }

                        return `
                        <div class="apex-tooltip">
                            <strong>${title}: ${point.y.toFixed(2)}</strong><br/>
                            PO Number: ${point.meta?.po || '-' }<br/>
                            Variant: ${point.meta?.variant || '-' }
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