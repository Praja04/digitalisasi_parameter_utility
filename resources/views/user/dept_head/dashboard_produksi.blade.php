@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Produksi - Pasteurisasi Line 1</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Produksi
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

        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Batch
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="197">0</span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievement rate output batch

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="89.4">0</span>%
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievement kecap matang

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-pulse-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="32.89">0</span>%
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        achievemnet quality

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-trophy-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" data-target="1596.5">0</span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
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
            <div class="col-xxl-5 col-md-6">
                <hr>
                <h4>Status Running Produksi</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Varian</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" id="varian_status_running"></span></h2>

                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary rounded-circle fs-2">
                                                <i data-feather="users"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Batch</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" id="batch_status_running"></span></h2>

                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger rounded-circle fs-2">
                                                <i data-feather="activity"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Storage</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" id="storage_status_running"></span></h2>

                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning rounded-circle fs-2">
                                                <i data-feather="clock"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Mode</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" id="mode_status_running"></span></h2>

                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success rounded-circle fs-2">
                                                <i data-feather="external-link"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>

            <!-- end col -->


            <div class="col-xxl-7">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            ccp
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
            <!-- end col -->

            <div class="col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            frekuensi divert
                        </h4>
                        <div class="d-flex gap-2">
                            <select id="filterData2" class="form-select form-select-sm w-auto">
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
                </div>
                <!-- end card header -->
                <div class="card-body pb-0">
                    <div id="sales-forecast-chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning"]'
                        class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
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
        let chart;

        function fetchData(url, params = {}) {
            return $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                }
            });
        }

        function updateChart(data) {
            if (data.length === 0) {
                if (chart) {
                    chart.updateSeries([{
                        data: []
                    }]); // Kosongkan chart
                }
                Swal.fire({
                    icon: "warning",
                    title: "Data Tidak Ditemukan",
                    text: "Tidak ada data untuk rentang waktu yang dipilih.",
                });
                return;
            }

            let categories = data.map(item => item.Waktu);

            let seriesData = {
                Flowrate: data.map(item => item.Flowrate),
                SuhuHeating: data.map(item => item.SuhuHeating),
                SuhuHolding: data.map(item => item.SuhuHolding),
            };

            let chartOptions = {
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                series: [{
                        name: "Flowrate",
                        data: seriesData.Flowrate
                    },
                    {
                        name: "Suhu Heating",
                        data: seriesData.SuhuHeating
                    },
                    {
                        name: "Suhu Holding",
                        data: seriesData.SuhuHolding
                    }
                ],
                colors: ["#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#727cf5"],
                xaxis: {
                    categories: categories,
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

            if (chart) {
                chart.updateOptions(chartOptions);
            } else {
                chart = new ApexCharts(document.querySelector("#ccp_chart"), chartOptions);
                chart.render();
            }
        }

        function updateInputFields() {
            let filter = $("#filterData").val();
            $("#datePicker, #startDate, #endDate").addClass("d-none");

            if (filter === "daily") {
                $("#datePicker").removeClass("d-none");
            } else if (filter === "weekly") {
                $("#startDate, #endDate").removeClass("d-none");
            }
        }

        $("#filterData").on("change", function() {
            updateInputFields();
        });

        $("#applyFilter").on("click", function() {
            let filter = $("#filterData").val();
            let url = "";
            let params = {};

            if (filter === "latest") {
                url = "{{ url('pasteurisasi1/data') }}";
            } else if (filter === "daily") {
                let selectedDate = $("#datePicker").val();
                if (!selectedDate) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Tanggal!",
                        text: "Harap pilih tanggal sebelum menerapkan filter.",
                    });
                    return;
                }
                url = "{{ url('pasteurisasi1/data-harian') }}";
                params = {
                    tanggal: selectedDate
                };
            } else if (filter === "weekly") {
                let startDate = $("#startDate").val();
                let endDate = $("#endDate").val();
                if (!startDate || !endDate) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Rentang Tanggal!",
                        text: "Harap pilih tanggal mulai dan tanggal selesai sebelum menerapkan filter.",
                    });
                    return;
                }
                url = "{{ url('pasteurisasi1/data-mingguan') }}";
                params = {
                    tanggal_mulai: startDate,
                    tanggal_selesai: endDate
                };
            }

            fetchData(url, params).done(response => {
                if (response.success) {
                    updateChart(response.data);
                } else {
                    if (chart) {
                        chart.updateSeries([{
                            data: []
                        }]); // Kosongkan chart jika data tidak ditemukan
                    }
                    Swal.fire({
                        icon: "warning",
                        title: "Data Tidak Ditemukan",
                        text: "Tidak ada data untuk rentang waktu yang dipilih.",
                    });
                }
            });
        });

        updateInputFields();
        $("#applyFilter").trigger("click");

        function updateheatingValue() {
            $.ajax({
                url: "{{ url('pasteurisasi1/data-realtime') }}",
                dataType: 'json',
                success: function(response) {
                    $('#varian_status_running').text(response.Varian); // Update nilai feed water
                    $('#mode_status_running').text(response.Mode); // Update nilai feed water
                    $('#batch_status_running').text(response.Batch); // Update nilai feed water
                    $('#storage_status_running').text(response.Storage); // Update nilai feed water
                },
                error: function(_xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        }

        updateheatingValue();

    });
</script>
@endsection