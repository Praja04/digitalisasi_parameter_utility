@extends('layout')

@section('style')
    <style>
        .welcome-card {
            background: linear-gradient(135deg, #3ea8eb, #1cc88a);
            color: #fff;
        }

        .welcome-card h1,
        .welcome-card p {
            color: #fff;
        }

        .img-dashboard {
            width: 110px;
            height: 110px;
            object-fit: cover
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            {{-- <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 welcome-card p-4" data-aos="fade-up">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div>
                                <h1 class="fw-bold mb-2">
                                    Selamat Datang Kembali, {{ Auth::user()->username }} 👋
                                </h1>
                                <p class="mb-0">
                                    Senang melihatmu kembali! Berikut ringkasan aktivitas dan laporan terbarumu.
                                </p>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <img src="{{ session('image_url', asset('material/assets/images/users/user-dummy-img.jpg')) }}"
                                    alt="avatar" class="rounded-circle img-dashboard">
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row mb-4">
                <div class="col-xl-6">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Total Data Per Bulan</h4>
                            </div>

                            <div class="card-body">
                                <div id="tkbmChart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Distribusi Qty Produk <span id="bulanQtyProduk"></span></h4>
                                <div class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded text-white shadow-sm"
                                        id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: #4968A6">
                                        <i class="bx bx-filter-alt fs-5"></i>
                                        <span>Filter</span>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3 rounded-3"
                                        style="min-width: 280px;" aria-labelledby="dropdownFilter">

                                        <h6 class="fw-bold mb-3">Filter Data</h6>

                                        <div class="mb-3">
                                            <label for="bulanFilter" class="form-label">Pilih Bulan</label>
                                            <input type="month" id="bulanFilter" class="form-control shadow-sm">
                                        </div>

                                        <button class="btn btn-primary w-100 rounded-3 shadow-sm" id="applyFilter">
                                            <i class="bx bx-check-circle me-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="produkDistribusi" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-6">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Total Qty Terpal <span id="bulanQtyTerpal"></span></h4>
                                <div class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded text-white shadow-sm"
                                        id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: #F2C36B">
                                        <i class="bx bx-filter-alt fs-5"></i>
                                        <span>Filter</span>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3 rounded-3"
                                        style="min-width: 280px;" aria-labelledby="dropdownFilter">

                                        <h6 class="fw-bold mb-3">Filter Data</h6>

                                        <div class="mb-3">
                                            <label for="bulanTerpal" class="form-label">Pilih Bulan</label>
                                            <input type="month" id="bulanTerpal" class="form-control shadow-sm">
                                        </div>

                                        <button class="btn btn-primary w-100 rounded-3 shadow-sm" id="filteBulanTerpal">
                                            <i class="bx bx-check-circle me-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="tkbmQtyTerpal" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Total Qty Slipsheet <span id="bulanQtySlipsheet"></span></h4>
                                <div class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded text-white shadow-sm"
                                        id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: #4968A6">
                                        <i class="bx bx-filter-alt fs-5"></i>
                                        <span>Filter</span>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3 rounded-3"
                                        style="min-width: 280px;" aria-labelledby="dropdownFilter">

                                        <h6 class="fw-bold mb-3">Filter Data</h6>

                                        <div class="mb-3">
                                            <label for="bulanSlipsheet" class="form-label">Pilih Bulan</label>
                                            <input type="month" id="bulanSlipsheet" class="form-control shadow-sm">
                                        </div>

                                        <button class="btn btn-primary w-100 rounded-3 shadow-sm"
                                            id="filteBulanSlipsheet">
                                            <i class="bx bx-check-circle me-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="tkbmQtySlipsheet" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-6">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Total Qty Pallet <span id="bulanQtyPallet"></span></h4>
                                <div class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded text-white shadow-sm"
                                        id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: #3FBFBF">
                                        <i class="bx bx-filter-alt fs-5"></i>
                                        <span>Filter</span>
                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3 rounded-3"
                                        style="min-width: 280px;" aria-labelledby="dropdownFilter">

                                        <h6 class="fw-bold mb-3">Filter Data</h6>

                                        <div class="mb-3">
                                            <label for="bulanPallet" class="form-label">Pilih Bulan</label>
                                            <input type="month" id="bulanPallet" class="form-control shadow-sm">
                                        </div>

                                        <button class="btn btn-primary w-100 rounded-3 shadow-sm" id="filteBulanPallet">
                                            <i class="bx bx-check-circle me-1"></i> Terapkan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="tkbmQtyPallet" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="" data-aos="fade-up" data-aos-delay="300">
                        <div class="card card-animate shadow-sm">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Grand Total By Month</h4>
                            </div>

                            <div class="card-body">
                                <div id="tkbmGrandTotal" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            tkbmChart();
            pieProdukTkbm();
            tkbmQtyTerpal();
            tkbmQtySlipsheet();
            tkbmQtyPallet();
            tkbmGrandTotalChart();

            let today = new Date();
            let bulanNama = today.toLocaleString('id-ID', {
                month: 'long',
                year: 'numeric'
            });

            // Set default span
            $("#bulanQtyProduk").text(`(${bulanNama})`);
            $("#bulanQtyTerpal").text(`(${bulanNama})`);
            $("#bulanQtySlipsheet").text(`(${bulanNama})`);
            $("#bulanQtyPallet").text(`(${bulanNama})`);

            // Simpan semua chart dalam 1 object global
            let charts = {};

            function renderChart(chartId, url, bulan = null, optionsBuilder) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: bulan ? {
                        bulan: bulan
                    } : {},
                    success: function(response) {
                        // Hancurkan chart lama kalau ada
                        if (charts[chartId]) {
                            charts[chartId].destroy();
                            charts[chartId] = null;
                        }

                        if (response && response.length > 0) {
                            // bikin options chart dari callback
                            const options = optionsBuilder(response);

                            $(`#${chartId}`).html('');
                            charts[chartId] = new ApexCharts(document.querySelector(`#${chartId}`),
                                options);
                            charts[chartId].render();
                        } else {
                            $(`#${chartId}`).html(`
                                <div class="text-center p-4 text-muted">
                                    <i class="mdi mdi-database-off" style="font-size:48px;"></i>
                                    <p class="mt-2 mb-0">Data tidak tersedia</p>
                                </div>
                            `);
                        }
                    },
                    error: function(err) {
                        console.error("Gagal ambil data:", err);
                    }
                });
            }

            function tkbmChart() {
                $.ajax({
                    url: "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/data/per-month') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Ambil bulan & total
                        const categories = response.map(item => item.bulan);
                        const data = response.map(item => item.banyak_data);

                        const options = {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Data TKBM',
                                data: data
                            }],
                            xaxis: {
                                categories: categories
                            },
                            colors: ['#F2C36B'],
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return Math.round(val);
                                    }
                                }
                            }
                        };

                        const chart = new ApexCharts(document.querySelector("#tkbmChart"), options);
                        chart.render();
                    },
                    error: function(err) {
                        console.error("Gagal ambil data:", err);
                    }
                });
            }

            function pieProdukTkbm(bulan = null) {
                renderChart("produkDistribusi",
                    "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/produk') }}", bulan,
                    function(
                        response) {

                        if (!response || response.length === 0) {
                            return {
                                chart: {
                                    type: 'donut',
                                    height: 300
                                },
                                series: [],
                                labels: [],
                            };
                        }

                        const item = response[0]; // ambil baris pertama
                        const totalTerpal = parseInt(item.total_terpal) || 0;
                        const totalSlipsheet = parseInt(item.total_slipsheet) || 0;
                        const totalPallet = parseInt(item.total_pallet) || 0;

                        return {
                            chart: {
                                type: 'donut',
                                height: 300
                            },
                            series: [totalTerpal, totalSlipsheet, totalPallet],
                            labels: ['Terpal', 'Slipsheet', 'Pallet'],
                            colors: ['#F2C36B', '#4968A6', '#3FBFBF'],
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                y: {
                                    formatter: val => `${val} pcs`
                                }
                            }
                        };
                    });
            }


            function tkbmQtyTerpal(bulan = null) {
                renderChart("tkbmQtyTerpal",
                    "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/qty-terpal') }}",
                    bulan,
                    function(
                        response) {
                        const categories = response.map(item => {
                            let dateObj = new Date(item.tanggal);
                            return ("0" + dateObj.getDate()).slice(-2);
                        });
                        const data = response.map(item => parseInt(item.total_terpal));

                        return {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Qty Terpal',
                                data: data
                            }],
                            xaxis: {
                                categories: categories,
                                title: {
                                    text: 'Tanggal',
                                    offsetY: 90
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Qty Terpal'
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: '10px'
                                }
                            },
                            colors: ['#F2C36B'],
                            tooltip: {
                                y: {
                                    formatter: val => val.toLocaleString("id-ID") + ' pcs'
                                }
                            }
                        };
                    });
            }

            function tkbmQtySlipsheet(bulan = null) {
                renderChart("tkbmQtySlipsheet",
                    "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/qty-slipsheet') }}",
                    bulan,
                    function(
                        response) {
                        const categories = response.map(item => {
                            let dateObj = new Date(item.tanggal);
                            return ("0" + dateObj.getDate()).slice(-2);
                        });
                        const data = response.map(item => parseInt(item.total_slipsheet));

                        return {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Qty Slipsheet',
                                data: data
                            }],
                            xaxis: {
                                categories: categories,
                                title: {
                                    text: 'Tanggal',
                                    offsetY: 90
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Qty Slipsheet'
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: '10px'
                                }
                            },
                            colors: ['#4968A6'],
                            tooltip: {
                                y: {
                                    formatter: val => val.toLocaleString("id-ID") + ' pcs'
                                }
                            }
                        };
                    });
            }

            // Chart Pallet
            function tkbmQtyPallet(bulan = null) {
                renderChart("tkbmQtyPallet",
                    "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/qty-pallet') }}",
                    bulan,
                    function(
                        response) {
                        const categories = response.map(item => {
                            let dateObj = new Date(item.tanggal);
                            return ("0" + dateObj.getDate()).slice(-2);
                        });
                        const data = response.map(item => parseInt(item.total_pallet));

                        return {
                            chart: {
                                type: 'bar',
                                height: 300
                            },
                            series: [{
                                name: 'Qty Pallet',
                                data: data
                            }],
                            xaxis: {
                                categories: categories,
                                title: {
                                    text: 'Tanggal',
                                    offsetY: 90
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Qty Pallet'
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: '10px'
                                }
                            },
                            colors: ['#3FBFBF'],
                            tooltip: {
                                y: {
                                    formatter: val => val.toLocaleString("id-ID") + ' pcs'
                                }
                            }
                        };
                    });
            }

            function tkbmGrandTotalChart() {
                $.ajax({
                    url: "{{ url('http://10.11.10.130:8087/warehouse/public/api/dashboard/tkbm/grand-total') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status && response.data.length > 0) {
                            let categories = [];
                            let grandTotalSeries = [];

                            response.data.forEach(item => {
                                categories.push(item.bulan_nama);
                                grandTotalSeries.push(parseFloat(item.grand_total));
                            });

                            const options = {
                                chart: {
                                    type: 'bar',
                                    height: 350
                                },
                                series: [{
                                    name: 'Grand Total',
                                    data: grandTotalSeries
                                }],
                                xaxis: {
                                    categories: categories,
                                    title: {
                                        text: 'Month',
                                        offsetY: 90, // Tambahkan ini untuk menurunkan posisi title
                                    }
                                },
                                colors: ['#3FBFBF'],
                                yaxis: {
                                    title: {
                                        text: 'Grand Total (Rp)'
                                    },
                                    labels: {
                                        formatter: function(val) {
                                            return 'Rp ' + val.toLocaleString("id-ID");
                                        }
                                    }
                                },
                                dataLabels: {
                                    enabled: true,
                                    formatter: function(val) {
                                        if (val >= 1000000000) {
                                            return 'Rp ' + (val / 1000000000).toFixed(1) + 'M';
                                        } else if (val >= 1000000) {
                                            return 'Rp ' + (val / 1000000).toFixed(1) + 'Jt';
                                        } else if (val >= 1000) {
                                            return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                                        }
                                        return '';
                                    },
                                    style: {
                                        fontSize: '12px',
                                        fontWeight: 'bold',
                                        rotation: 90
                                    },
                                    background: {
                                        enabled: false
                                    },
                                    offsetY: 0,
                                    textAnchor: 'middle'
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return 'Rp ' + val.toLocaleString("id-ID");
                                        }
                                    }
                                }
                            };

                            const chart = new ApexCharts(document.querySelector("#tkbmGrandTotal"),
                                options);
                            chart.render();
                        } else {
                            $("#tkbmGrandTotal").html("<p class='text-center'>Tidak ada data</p>");
                        }
                    },
                    error: function(err) {
                        console.error("Gagal ambil data:", err);
                        $("#tkbmGrandTotal").html(
                            "<p class='text-center text-danger'>Error load data</p>");
                    }
                });
            }

            $('#applyFilter').click(function() {
                let bulan = $("#bulanFilter").val();
                if (!bulan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih bulan terlebih dahulu.',
                    });
                    return;
                }

                let [year, month] = bulan.split("-");
                let bulanNama = new Date(bulan + "-01").toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                $("#bulanQtyProduk").text(`(${bulanNama})`);

                pieProdukTkbm(bulan);
            });

            $('#filteBulanTerpal').click(function() {
                let bulan = $("#bulanTerpal").val();
                if (!bulan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih bulan terlebih dahulu.',
                    });
                    return;
                }

                let [year, month] = bulan.split("-");
                let bulanNama = new Date(bulan + "-01").toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                $("#bulanQtyTerpal").text(`(${bulanNama})`);

                // Panggil fungsi chart
                tkbmQtyTerpal(bulan);
            });

            $('#filteBulanSlipsheet').click(function() {
                let bulan = $("#bulanSlipsheet").val();
                if (!bulan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih bulan terlebih dahulu.',
                    });
                    return;
                }

                let [year, month] = bulan.split("-");
                let bulanNama = new Date(bulan + "-01").toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                $("#bulanQtySlipsheet").text(`(${bulanNama})`);

                // Panggil fungsi chart
                tkbmQtySlipsheet(bulan);
            });

            $('#filteBulanPallet').click(function() {
                let bulan = $("#bulanPallet").val();
                if (!bulan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih bulan terlebih dahulu.',
                    });
                    return;
                }

                let [year, month] = bulan.split("-");
                let bulanNama = new Date(bulan + "-01").toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                $("#bulanQtyPallet").text(`(${bulanNama})`);

                // Panggil fungsi chart
                tkbmQtyPallet(bulan);
            });
        });
    </script>
@endsection
