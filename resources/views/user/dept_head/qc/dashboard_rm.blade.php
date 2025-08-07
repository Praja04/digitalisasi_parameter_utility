@extends('layout')
@section('title', 'Dashboard Sampling RMPM')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="container mt-4">
            <h2 class="mb-4 fw-bold">📊 Dashboard Sampling RMPM</h2>
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Kondisi Mobil</div>
                        <div class="card-body" id="chart-mobil"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Dokumen</div>
                        <div class="card-body" id="chart-dokumen"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Fisik Kemasan</div>
                        <div class="card-body" id="chart-kemasan"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Fisik Bahan Mentah</div>
                        <div class="card-body" id="chart-raw"></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Sampling Umum</div>
                        <div class="card-body" id="card-umum"></div>
                    </div>
                </div>

                <h2 class="mb-4 fw-bold">📋 Analisa Kualitas Bahan & Disposisi</h2>

                <div class="row gy-4">
                    {{-- Parameter Kualitas --}}
                    @foreach (['Gula', 'Garam', 'Gula Tebu', 'Gula Kelapa'] as $jenis)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Parameter Kualitas: {{ $jenis }}</div>
                            <div class="card-body" id="chart-{{ Str::slug($jenis) }}"></div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Disposisi Total --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Rekap Disposisi</div>
                            <div class="card-body" id="chart-disposisi-total"></div>
                        </div>
                    </div>

                    {{-- Pending Disposisi --}}
                    <div class="col-md-6">
                        <div class="card bg-warning-subtle border-0">
                            <div class="card-body text-center">
                                <h5>Total Pending Disposisi</h5>
                                <h1 id="pending-count" class="display-4 fw-bold">...</h1>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(function() {
        const endpoints = {


            mobil: {
                url: "http://10.11.10.130:8081/public/api/dashboard-rmpm/mobil",
                key: 'mobil'
            },
            dokumen: {
                url: "http://10.11.10.130:8081/public/api/dashboard-rmpm/dokumen",
                key: 'dokumen'
            },
            kemasan: {
                url: "http://10.11.10.130:8081/public/api/dashboard-rmpm/kemasan",
                key: 'kemasan'
            },
            raw: {
                url: "http://10.11.10.130:8081/public/api/dashboard-rmpm/raw",
                key: 'raw_material'
            },
            umum: "http://10.11.10.130:8081/public/api/dashboard-rmpm/umum"
        };

        function renderStackedBarChart(containerId, dataObj) {
            const categories = Object.keys(dataObj);
            const yesData = categories.map(k => dataObj[k].yes);
            const noData = categories.map(k => dataObj[k].no);

            const options = {
                chart: {
                    type: 'bar',
                    stacked: true,
                    height: 300
                },
                series: [{
                        name: 'Yes',
                        data: yesData
                    },
                    {
                        name: 'No',
                        data: noData
                    }
                ],
                xaxis: {
                    categories: categories.map(k => k.replace(/_/g, ' ').toUpperCase())
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                colors: ['#00E396', '#FF4560'],
                legend: {
                    position: 'top'
                }
            };

            new ApexCharts(document.querySelector(`#chart-${containerId}`), options).render();
        }

        $.each(endpoints, function(id, config) {
            $.get(config.url, function(res) {
                renderStackedBarChart(id, res[config.key]);
            });
        });


        $.get(endpoints.umum, res => {
            $('#card-umum').html(`
            <div class="row">
                <div class="col-md-4">
                    <strong>Total Identitas:</strong> ${res.total_identitas}
                    <br><strong>Jenis Gula:</strong>
                    <ul>${Object.entries(res.jenis_gula).map(([key, val]) => `<li>${key}: ${val}</li>`).join('')}</ul>
                </div>
                <div class="col-md-4">
                    <strong>Top Supplier:</strong>
                    <ul>${Object.entries(res.top_supplier).map(([key, val]) => `<li>${key}: ${val}</li>`).join('')}</ul>
                </div>
                <div class="col-md-4">
                    <strong>Sampling Completion:</strong>
                    <ul>${Object.entries(res.sampling_completion).map(([key, val]) => `<li>${key}: ${val}</li>`).join('')}</ul>
                </div>
            </div>
        `);
        });
    });

    $(function() {
        const jenisList = ['Gula', 'Garam', 'Gula Tebu', 'Gula Kelapa'];

        jenisList.forEach(jenis => {
            $.get("http://10.11.10.130:8081/public/api/dashboard-rmpm/parameter-kualitas-per-jenis", {
                jenis_gula: jenis
            }, function(res) {
                const el = document.querySelector('#chart-' + slugify(jenis));
                if (!res.data || res.data.length === 0) {
                    el.innerHTML = '<p class="text-muted">Tidak ada data</p>';
                    return;
                }

                let categories = res.data.map(row => row.disposisi);
                let series = [];

                if (res.analisa === 'garam_gula') {
                    series = [{
                            name: '%KA',
                            data: res.data.map(d => parseFloat(d.avg_ka).toFixed(2))
                        },
                        {
                            name: '%NaCl',
                            data: res.data.map(d => parseFloat(d.avg_nacl).toFixed(2))
                        },
                        {
                            name: 'Gross Weight',
                            data: res.data.map(d => parseFloat(d.avg_weight).toFixed(2))
                        }
                    ];
                } else {
                    series = [{
                            name: 'Brix',
                            data: res.data.map(d => parseFloat(d.avg_brix).toFixed(2))
                        },
                        {
                            name: 'pH',
                            data: res.data.map(d => parseFloat(d.avg_ph).toFixed(2))
                        }
                    ];
                }

                const options = {
                    chart: {
                        type: 'bar',
                        height: 300
                    },
                    series,
                    xaxis: {
                        categories
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    },
                    colors: ['#008FFB', '#FEB019', '#00E396']
                };

                new ApexCharts(el, options).render();
            });
        });

        $.get("http://10.11.10.130:8081/public/api/dashboard-rmpm/disposisi", function(res) {
            const data = res.rekap_disposisi || [];
            const series = data.map(row => row.total);
            const labels = data.map(row => row.disposisi);

            new ApexCharts(document.querySelector("#chart-disposisi-total"), {
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels,
                series,
                colors: ['#28a745', '#dc3545', '#ffc107'],
                tooltip: {
                    y: {
                        formatter: v => v + ' data'
                    }
                }
            }).render();

            $('#pending-count').text(res.total_pending_disposisi);
        });

        function slugify(str) {
            return str.toLowerCase().replace(/\s+/g, '-');
        }
    });
</script>
@endsection