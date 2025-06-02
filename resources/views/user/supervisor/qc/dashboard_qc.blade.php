@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pasteurisasi Line 1 - After Cooling</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                QC
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Welcome ,{{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <form action="javascript:void(0);">
                            <div class="row g-3 mb-0 align-items-center">
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input id="shift" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>

                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input id="date-picker" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->


                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <!-- end row -->
        <div class="row mb-6 ">
            <div class="d-flex justify-content-end align-items-center flex-wrap">
                <div class="me-2">
                    <select id="filterType" class="form-control">
                        <option value="today">Hari Ini</option>
                        <option value="date">Pilih Tanggal</option>
                        <option value="range">Rentang Tanggal</option>
                        <option value="all" selected>All</option>
                    </select>
                </div>
                <div class="me-2 d-none" id="start-date-group">
                    <input type="date" id="start-date" class="form-control" />
                </div>
                <div class="me-2 d-none" id="end-date-group">
                    <input type="date" id="end-date" class="form-control" />
                </div>
                <div>
                    <button class="btn btn-primary" id="loadChart">Terapkan</button>
                </div>
            </div>
        </div>
        <br>


        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Brix
                                    </h5>
                                    <div id="chart_brix"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_brix"></p>
                                            </td>
                                            <td>
                                                <p id="std_brix"></p>
                                            </td>
                                            <td>
                                                <p id="min_brix"></p>
                                            </td>
                                            <td>
                                                <p id="max_brix"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Viscositas

                                    </h5>
                                    <div id="chart_viscositas"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_visco"></p>
                                            </td>
                                            <td>
                                                <p id="std_visco"></p>
                                            </td>
                                            <td>
                                                <p id="min_visco"></p>
                                            </td>
                                            <td>
                                                <p id="max_visco"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Aw

                                    </h5>
                                    <div id="chart_aw"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_aw"></p>
                                            </td>
                                            <td>
                                                <p id="std_aw"></p>
                                            </td>
                                            <td>
                                                <p id="min_aw"></p>
                                            </td>
                                            <td>
                                                <p id="max_aw"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end col -->

                            <!-- end col -->


                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->



        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="mt-4 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Bj

                                    </h5>
                                    <div id="chart_bj"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_bj"></p>
                                            </td>
                                            <td>
                                                <p id="std_bj"></p>
                                            </td>
                                            <td>
                                                <p id="min_bj"></p>
                                            </td>
                                            <td>
                                                <p id="max_bj"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- end col -->
                            <div class=" col">
                                <div class="mt-4 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Buih

                                    </h5>
                                    <div id="chart_buih"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_buih"></p>
                                            </td>
                                            <td>
                                                <p id="std_buih"></p>
                                            </td>
                                            <td>
                                                <p id="min_buih"></p>
                                            </td>
                                            <td>
                                                <p id="max_buih"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        pH

                                    </h5>
                                    <div id="chart_ph"></div>
                                </div>
                                <table class="table align-middle text-center table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Average</th>
                                            <th>STD Deviasi</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p id="average_ph"></p>
                                            </td>
                                            <td>
                                                <p id="std_ph"></p>
                                            </td>
                                            <td>
                                                <p id="min_ph"></p>
                                            </td>
                                            <td>
                                                <p id="max_ph"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xxl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Suhu
                        </h4>
                        <div class="d-flex gap-2">
                            <select id="filterData" class="form-select form-select-sm w-auto">
                                <option value="latest">Terbaru</option>
                                <option value="daily">Per Hari</option>
                                <option value="weekly">Per Minggu</option>
                            </select>
                            <input type="date" id="datePicker" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="startDate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="endDate" class="form-control form-control-sm w-auto d-none">
                            <button id="applyFilter" class="btn btn-primary btn-sm">Terapkan</button>
                        </div>

                    </div>
                    <!-- end card header -->
                    <div class="card-body px-0">


                        <div id="ccp_chart"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xxl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Flowrate
                        </h4>
                        <div class="d-flex gap-2">
                            <select id="filterDataFlowrate" class="form-select form-select-sm w-auto">
                                <option value="latest">Terbaru</option>
                                <option value="daily">Per Hari</option>
                                <option value="weekly">Per Minggu</option>
                            </select>
                            <input type="date" id="datePickerFlowrate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="startDateFlowrate" class="form-control form-control-sm w-auto d-none">
                            <input type="date" id="endDateFlowrate" class="form-control form-control-sm w-auto d-none">
                            <button id="applyFilterFlowrate" class="btn btn-primary btn-sm">Terapkan</button>
                        </div>

                    </div>
                    <!-- end card header -->
                    <div class="card-body px-0">


                        <div id="flowrate_chart"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>

            <!-- end col -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="tasksList">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">All Data AfterCooling</h5>

                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form>
                            <div class="row g-3">
                                <div class="col-xxl-5 col-sm-12">
                                    <div class="search-box">
                                        <input type="text" class="form-control search bg-light border-light" placeholder="Search for data batch..." onkeyup="SearchData()">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-2 col-sm-4">
                                    <input type="date" class="form-control bg-light border-light" id="start_date" onchange="SearchData()" placeholder="Start Date">
                                </div>
                                <div class="col-xxl-2 col-sm-4">
                                    <input type="date" class="form-control bg-light border-light" id="end_date" onchange="SearchData()" placeholder="End Date">
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end card-body-->
                    <div class="card-body">
                        <div class="table-responsive table-card mb-4">


                            <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                <thead class="table-light text-muted">

                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Tanggal</th>
                                        <th rowspan="2">Batch</th>
                                        <th rowspan="2">Varian</th>
                                        <th rowspan="2">BJ OK (%)</th>
                                        <th rowspan="2">BRIX OK (%)</th>
                                        <th rowspan="2">PH OK (%)</th>
                                        <th rowspan="2">Visco OK (%)</th>
                                        <th rowspan="2">Aw OK (%)</th>
                                        <th rowspan="2">Buih OK (%)</th>
                                        <th rowspan="2">Endapan OK (%)</th>
                                        <th rowspan="2">Organo OK (%)</th>
                                        <th colspan="12">Detail After Cooling</th>
                                    </tr>
                                    <tr>
                                        <th>Shift</th>
                                        <th>Jam</th>
                                        <th>Brix</th>
                                        <th>Viscositas</th>
                                        <th>Aw</th>
                                        <th>pH</th>
                                        <th>Bj</th>
                                        <th>Buih</th>
                                        <th>Endapan</th>
                                        <th>Organo</th>
                                        <th>Warna</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">


                                </tbody>
                            </table>
                            <!--end table-->
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0"> We did not find any tasks for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


<!-- Dashboard init -->

<script>
    $(document).ready(function() {
        let chartInstances = [];

        const $startDateGroup = $('#start-date-group');
        const $endDateGroup = $('#end-date-group');

        // Tampilkan/hidden input tanggal berdasarkan filter
        $('#filterType').change(function() {
            const val = $(this).val();
            if (val === 'date') {
                $('#start-date-group').removeClass('d-none');
                $('#end-date-group').addClass('d-none');
            } else if (val === 'range') {
                $('#start-date-group').removeClass('d-none');
                $('#end-date-group').removeClass('d-none');
            } else {
                $('#start-date-group, #end-date-group').addClass('d-none');
            }
        });

        $('#loadChart').on('click', function() {
            const filter = $('#filterType').val();
            const data = {
                filter
            };

            if (filter === 'date' || filter === 'range') {
                data.start_date = $('#start-date').val();
            }

            if (filter === 'range') {
                data.end_date = $('#end-date').val();
            }

            $.ajax({
                url: "{{ url('qc/api/chartaftercooling') }}",
                method: "GET",
                data: data,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    const categories = data.map(item => {
                        let date = new Date(item.created_at);
                        return date.toISOString().replace('T', ' ').substring(0, 19);
                    });

                    const chartData = {
                        brix: data.map(item => item.brix),
                        viscositas: data.map(item => item.viscositas),
                        aw: data.map(item => item.aw),
                        ph: data.map(item => item.ph),
                        bj: data.map(item => item.bj),
                        buih: data.map(item => item.buih),
                        endapan: data.map(item => item.endapan)
                    };

                    const chartOptions = (title, dataSeries) => ({
                        chart: {
                            type: 'line',
                            height: 200,
                            toolbar: {
                                show: false
                            }
                        },
                        series: [{
                            name: title,
                            data: dataSeries
                        }],
                        xaxis: {
                            categories: categories,
                            labels: {
                                show: false
                            },
                            title: {
                                text: "Tanggal"
                            }
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        }
                    });

                    // Destroy semua chart lama
                    chartInstances.forEach(chart => chart.destroy());
                    chartInstances = [];

                    // Tambahkan chart baru
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_brix"), chartOptions('Brix', chartData.brix)));
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_viscositas"), chartOptions('Viscositas', chartData.viscositas)));
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_aw"), chartOptions('Aw', chartData.aw)));
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_ph"), chartOptions('pH', chartData.ph)));
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_bj"), chartOptions('Bj', chartData.bj)));
                    chartInstances.push(new ApexCharts(document.querySelector("#chart_buih"), chartOptions('Buih', chartData.buih)));

                    // Render semua chart
                    chartInstances.forEach(chart => chart.render());
                },
                error: function(xhr) {
                    console.error("Gagal ambil data QC:", xhr);
                }
            });
        });

        // Optional: langsung load chart saat halaman dibuka
        $('#loadChart').click();

        let chart = null;
        let chart_flowrate = null;
        let chart_gauge = null;
        let chart_gauge_BT1 = null;
        let chart_gauge_BT2 = null;
        let chart_gauge_VD = null;

        function fetchData(url, params = {}) {
            return $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json"
            });
        }

        function showWarning(title, text) {
            Swal.fire({
                icon: "warning",
                title,
                text
            });
        }

        function updateChart(selector, config, chartInstance) {
            if (chartInstance) {
                chartInstance.updateOptions(config);
            } else {
                const chart = new ApexCharts(document.querySelector(selector), config);
                chart.render();
                return chart;
            }
        }

        function updateChartSuhu(data) {
            if (data.length === 0) {
                if (chart) chart.updateSeries([{
                    data: []
                }, {
                    data: []
                }]);
                return showWarning("Data Tidak Ditemukan", "Tidak ada data suhu untuk rentang waktu yang dipilih.");
            }

            const categories = data.map(item => item.Waktu);
            const series = [{
                    name: "Suhu Heating",
                    data: data.map(item => item.SuhuHeating)
                },
                {
                    name: "Suhu Holding",
                    data: data.map(item => item.SuhuHolding)
                }
            ];

            const options = {
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series,
                colors: ["#0acf97", "#fa5c7c"],
                xaxis: {
                    categories,
                    title: {
                        text: "Waktu"
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: "CCP"
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM HH:mm"
                    }
                }
            };

            chart = updateChart("#ccp_chart", options, chart);
        }

        function updateChartFlowrate(data) {
            if (data.length === 0) {
                if (chart_flowrate) chart_flowrate.updateSeries([{
                    data: []
                }]);
                return showWarning("Data Tidak Ditemukan", "Tidak ada data flowrate untuk rentang waktu yang dipilih.");
            }

            const categories = data.map(item => item.Waktu);
            const series = [{
                name: "Flowrate",
                data: data.map(item => item.Flowrate)
            }];

            const options = {
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series,
                colors: ["#39afd1"],
                xaxis: {
                    categories,
                    title: {
                        text: "Waktu"
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: "Flowrate"
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM HH:mm"
                    }
                }
            };

            chart_flowrate = updateChart("#flowrate_chart", options, chart_flowrate);
        }

        function updateInputFields(prefix = "") {
            const filter = $(`#filterData${prefix}`).val();
            $(`#datePicker${prefix}, #startDate${prefix}, #endDate${prefix}`).addClass("d-none");

            if (filter === "daily") {
                $(`#datePicker${prefix}`).removeClass("d-none");
            } else if (filter === "weekly") {
                $(`#startDate${prefix}, #endDate${prefix}`).removeClass("d-none");
            }
        }

        function handleFilterClick(prefix = "") {
            const filter = $(`#filterData${prefix}`).val();
            let url = "",
                params = {};

            if (filter === "latest") {
                url = "{{ url('pasteurisasi1/data') }}";
            } else if (filter === "daily") {
                const selectedDate = $(`#datePicker${prefix}`).val();
                if (!selectedDate) return showWarning("Pilih Tanggal!", "Harap pilih tanggal terlebih dahulu.");
                url = "{{ url('pasteurisasi1/data-harian') }}";
                params = {
                    tanggal: selectedDate
                };
            } else if (filter === "weekly") {
                const start = $(`#startDate${prefix}`).val(),
                    end = $(`#endDate${prefix}`).val();
                if (!start || !end) return showWarning("Pilih Rentang Tanggal!", "Harap lengkapi tanggal mulai dan selesai.");
                url = "{{ url('pasteurisasi1/data-mingguan') }}";
                params = {
                    tanggal_mulai: start,
                    tanggal_selesai: end
                };
            }

            fetchData(url, params).done(res => {
                if (prefix === "") {
                    res.success ? updateChartSuhu(res.data) : updateChartSuhu([]);
                } else {
                    res.success ? updateChartFlowrate(res.data) : updateChartFlowrate([]);
                }
            });
        }

        // Inisialisasi
        updateInputFields();
        updateInputFields("Flowrate");

        $("#filterData, #filterDataFlowrate").on("change", function() {
            const id = $(this).attr("id");
            const prefix = id.includes("Flowrate") ? "Flowrate" : "";
            updateInputFields(prefix);
        });

        $("#applyFilter").on("click", () => handleFilterClick());
        $("#applyFilterFlowrate").on("click", () => handleFilterClick("Flowrate"));

        // Load awal
        $("#applyFilter").trigger("click");
        $("#applyFilterFlowrate").trigger("click");

        function getShift(now) {
            let hours = now.getHours();
            let minutes = now.getMinutes();

            if ((hours === 6 && minutes >= 1) || (hours > 6 && hours < 14) || (hours === 14 && minutes === 0)) {
                return "Shift 1";
            } else if ((hours === 14 && minutes >= 1) || (hours > 14 && hours < 22) || (hours === 22 && minutes === 0)) {
                return "Shift 2";
            } else {
                return "Shift 3"; // Dari jam 22:01 sampai 06:00 keesokan harinya
            }
        }

        function updateDateTime() {
            let now = new Date();
            let formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });

            let shift = getShift(now);

            // Set nilai tanggal dan shift ke elemen yang sesuai
            $('#date-picker').val(formattedDate);
            $('#shift').val(shift);

            $.ajax({
                url: "{{ url('qc/api/statistikaftercooling') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#average_bj').text(parseFloat(data.bj_avg).toFixed(5));
                    $('#average_buih').text(parseFloat(data.buih_avg).toFixed(5));
                    $('#average_brix').text(parseFloat(data.brix_avg).toFixed(5));
                    $('#average_ph').text(parseFloat(data.ph_avg).toFixed(5));
                    $('#average_visco').text(parseFloat(data.visco_avg).toFixed(5));
                    $('#average_aw').text(parseFloat(data.aw_avg).toFixed(5));

                    $('#std_bj').text(parseFloat(data.bj_std).toFixed(8));
                    $('#std_buih').text(parseFloat(data.buih_std).toFixed(8));
                    $('#std_brix').text(parseFloat(data.brix_std).toFixed(8));
                    $('#std_ph').text(parseFloat(data.ph_std).toFixed(8));
                    $('#std_visco').text(parseFloat(data.visco_std).toFixed(8));
                    $('#std_aw').text(parseFloat(data.aw_std).toFixed(8));


                    $('#min_bj').text(data.bj_min);
                    $('#min_buih').text(data.buih_min);
                    $('#min_brix').text(data.brix_min);
                    $('#min_ph').text(data.ph_min);
                    $('#min_visco').text(data.visco_min);
                    $('#min_aw').text(data.aw_min);

                    $('#max_bj').text(data.bj_max);
                    $('#max_buih').text(data.buih_max);
                    $('#max_brix').text(data.brix_max);
                    $('#max_ph').text(data.ph_max);
                    $('#max_visco').text(data.visco_max);
                    $('#max_aw').text(data.aw_max);
                },
                error: function(err) {
                    console.error('Error:', err);
                }
            });
        }

        updateDateTime();
        // Panggil fungsi pertama kali
        setInterval(updateDateTime, 6000); // Update setiap 60 detik
    })
</script>

<script>
    let currentPage = 1;
    const rowsPerPage = 5;

    function paginateData(data, page = 1) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        return data.slice(start, end);
    }

    function renderPaginationControls(data) {
        const totalPages = Math.ceil(data.length / rowsPerPage);

        $('.pagination-prev').toggleClass('disabled', currentPage === 1);
        $('.pagination-next').toggleClass('disabled', currentPage === totalPages);

        $('.pagination-prev').off('click').on('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable(paginateData(data, currentPage));
                renderPaginationControls(data);
            }
        });

        $('.pagination-next').off('click').on('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(paginateData(data, currentPage));
                renderPaginationControls(data);
            }
        });
    }

    function renderTable(dataSubset) {
        let rows = '';

        if (dataSubset.length === 0) {
            $('.noresult').show();
            $('#tasksTable tbody').html('');
            return;
        }

        $('.noresult').hide();

        dataSubset.forEach((item, index) => {
            const details = item.detail_sample || [];
            const rowspan = details.length > 0 ? `rowspan="${details.length}"` : 'rowspan="1"';

            if (details.length > 0) {
                details.forEach((detail, i) => {
                    rows += `<tr>`;
                    if (i === 0) {
                        rows += `
                            <td ${rowspan}>${(currentPage - 1) * rowsPerPage + index + 1}</td>
                            <td ${rowspan}>${item.tanggal}</td>
                            <td ${rowspan}>${item.batch}</td>
                            <td ${rowspan}>${item.varian}</td>
                            <td ${rowspan}>${item.bj_ok_percent}%</td>
                            <td ${rowspan}>${item.brix_ok_percent}%</td>
                            <td ${rowspan}>${item.ph_ok_percent}%</td>
                            <td ${rowspan}>${item.visco_ok_percent}%</td>
                            <td ${rowspan}>${item.aw_ok_percent}%</td>
                            <td ${rowspan}>${item.buih_ok_percent}%</td>
                            <td ${rowspan}>${item.endapan_ok_percent}%</td>
                            <td ${rowspan}>${item.organo_ok_percent}%</td>
                        `;
                    }

                    rows += `
                        <td>${detail.shift}</td>
                       <td>${detail.created_at ? new Date(detail.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '-'}</td>
                        <td>${detail.brix}</td>
                        <td>${detail.viscositas}</td>
                        <td>${detail.aw}</td>
                        <td>${detail.ph}</td>
                        <td>${detail.bj}</td>
                        <td>${detail.buih}</td>
                        <td>${detail.endapan}</td>
                        <td>${detail.organo}</td>
                        <td>${detail.warna}</td>
                    </tr>`;
                });
            } else {
                // Jika tidak ada detail_sample
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.batch}</td>
                        <td>${item.varian}</td>
                        <td>${item.bj_ok_percent}%</td>
                        <td>${item.brix_ok_percent}%</td>
                        <td>${item.ph_ok_percent}%</td>
                        <td>${item.visco_ok_percent}%</td>
                        <td>${item.aw_ok_percent}%</td>
                        <td>${item.buih_ok_percent}%</td>
                        <td>${item.endapan_ok_percent}%</td>
                        <td>${item.organo_ok_percent}%</td>
                        <td colspan="12" class="text-center text-danger">Tidak ada data detail</td>
                    </tr>
                `;
            }
        });

        $('#tasksTable tbody').html(rows);
    }

    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/qc/api/olahaftercooling') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                allData = data;
                currentPage = 1;
                renderTable(paginateData(allData, currentPage));
                renderPaginationControls(allData);
            },
            error: function(err) {
                console.error('Error:', err);
            }
        });
    });

    function SearchData() {
        const search = $('.search').val().toLowerCase();
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        const filtered = allData.filter(item => {
            const itemDate = item.tanggal;

            // Konversi tanggal ke objek Date untuk perbandingan akurat
            const itemDateObj = new Date(itemDate);
            const startDateObj = startDate ? new Date(startDate) : null;
            const endDateObj = endDate ? new Date(endDate) : null;

            const matchDate =
                (!startDateObj || itemDateObj >= startDateObj) &&
                (!endDateObj || itemDateObj <= endDateObj);

            const itemString = JSON.stringify(item).toLowerCase(); // mencakup seluruh item dan detail_sample

            const matchSearch = !search || itemString.includes(search);

            return matchDate && matchSearch;
        });

        currentPage = 1;
        renderTable(paginateData(filtered, currentPage));
        renderPaginationControls(filtered);
    }
</script>
@endsection