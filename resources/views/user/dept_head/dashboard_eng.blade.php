@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Engineering</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Dashboards</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Engineering
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xxl-3">
                <div class="card card-height-70">
                    <div
                        class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Chemical
                        </h4>
                        <!-- <div>
                            <div class="dropdown">
                                <button
                                    class="btn btn-soft-primary btn-sm shadow-none"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="text-uppercase">Btc<i
                                            class="mdi mdi-chevron-down align-middle ms-1"></i></span>
                                </button>
                                <div
                                    class="dropdown-menu dropdown-menu-end">
                                    <a
                                        class="dropdown-item"
                                        href="#">BTC</a>
                                    <a
                                        class="dropdown-item"
                                        href="#">USD</a>
                                    <a
                                        class="dropdown-item"
                                        href="#">Euro</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- end cardheader -->
                    <div class="card-body">
                        <div
                            id="portfolio_donut_charts"
                            data-colors='["--vz-primary", "--vz-info", "--vz-warning", "--vz-success"]'
                            class="apex-charts"
                            dir="ltr"></div>

                        <ul
                            class="list-group list-group-flush border-dashed mb-0 mt-3 pt-2">
                            <li class="list-group-item px-0">
                                <div class="d-flex">
                                    <div
                                        class="flex-shrink-0 avatar-xs">
                                        <span
                                            class="avatar-title bg-light p-1 rounded-circle shadow">
                                            <img
                                                src="assets/images/svg/crypto-icons/btc.svg"
                                                class="img-fluid"
                                                alt="" />
                                        </span>
                                    </div>
                                    <div
                                        class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">
                                            Chemical A
                                        </h6>
                                        <p
                                            class="fs-12 mb-0 text-muted">
                                            <i
                                                class="mdi mdi-circle fs-10 align-middle text-primary me-1"></i>
                                        </p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 text-end">
                                        <h6 class="mb-1">
                                            1.200.000
                                        </h6>
                                        <p
                                            class="text-danger fs-12 mb-0">
                                            m2
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <!-- end -->
                            <li class="list-group-item px-0">
                                <div class="d-flex">
                                    <div
                                        class="flex-shrink-0 avatar-xs">
                                        <span
                                            class="avatar-title bg-light p-1 rounded-circle shadow">
                                            <img
                                                src="assets/images/svg/crypto-icons/eth.svg"
                                                class="img-fluid"
                                                alt="" />
                                        </span>
                                    </div>
                                    <div
                                        class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">
                                            Chemical C
                                        </h6>
                                        <p
                                            class="fs-12 mb-0 text-muted">
                                            <i
                                                class="mdi mdi-circle fs-10 align-middle text-info me-1"></i>
                                        </p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 text-end">
                                        <h6 class="mb-1">
                                            25.108
                                        </h6>
                                        <p
                                            class="text-danger fs-12 mb-0">
                                            m2
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <!-- end -->
                            <li class="list-group-item px-0">
                                <div class="d-flex">
                                    <div
                                        class="flex-shrink-0 avatar-xs">
                                        <span
                                            class="avatar-title bg-light p-1 rounded-circle shadow">
                                            <img
                                                src="assets/images/svg/crypto-icons/ltc.svg"
                                                class="img-fluid"
                                                alt="" />
                                        </span>
                                    </div>
                                    <div
                                        class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">
                                            Chemical B
                                        </h6>
                                        <p
                                            class="fs-12 mb-0 text-muted">
                                            <i
                                                class="mdi mdi-circle fs-10 align-middle text-warning me-1"></i>
                                        </p>
                                    </div>
                                    <div
                                        class="flex-shrink-0 text-end">
                                        <h6 class="mb-1">
                                            10.589
                                        </h6>
                                        <p
                                            class="text-success fs-12 mb-0">
                                            m2
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <!-- end -->

                            <!-- end -->
                        </ul>
                        <!-- end -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xxl-9 order-xxl-0 order-first">
                <div class="d-flex flex-column h-100">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Sensor Boiler Chart</h4>
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
                                <div class="card-body p-0 pb-3">
                                    <div id="boiler_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>



            <!-- end col -->
        </div>
        <!-- end row -->



        <div class="row">
            <div class="col-xl-6">
                <div class="d-flex flex-column h-100">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Sensor Compressor Chart</h4>
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
                                <div class="card-body p-0 pb-3">
                                    <div id="compresor_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-3">
                <div class="card card-height-100">
                    <div
                        class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Listrik
                        </h4>
                        <div>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                1H
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                1D
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                7D
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-primary btn-sm shadow-none">
                                1M
                            </button>
                        </div>
                    </div>
                    <!-- end card-header -->
                    <div class="card-body p-0">
                        <ul
                            class="list-group list-group-flush border-dashed mb-0">
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/btc.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Bitcoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $18.7 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $12,863.08
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$67.21 (+4.33%)
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/eth.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Eathereum
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $27.4 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $08,256.04
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$51.19<span
                                            class="ms-1">(+5.64%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/aave.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Avalanche
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $12.9 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $11,896.13
                                    </h6>
                                    <p
                                        class="text-danger fs-12 mb-0">
                                        -$59.01<span
                                            class="ms-1">(-4.08%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/doge.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Dogecoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $09.5 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $15,999.06
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$74.05<span
                                            class="ms-1">(+3.12%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/bnb.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Binance
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $14.2 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $13,786.18
                                    </h6>
                                    <p
                                        class="text-danger fs-12 mb-0">
                                        -$61.05<span
                                            class="ms-1">(-9.22%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/ltc.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Litecoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $09.5 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $10,604.27
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$76.12<span
                                            class="ms-1">(+4.92%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                        </ul>
                        <!-- end ul -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>

            <div class="col-xl-3">
                <div class="card card-height-100">
                    <div
                        class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Air
                        </h4>
                        <div>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                1H
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                1D
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-info btn-sm shadow-none">
                                7D
                            </button>
                            <button
                                type="button"
                                class="btn btn-soft-primary btn-sm shadow-none">
                                1M
                            </button>
                        </div>
                    </div>
                    <!-- end card-header -->
                    <div class="card-body p-0">
                        <ul
                            class="list-group list-group-flush border-dashed mb-0">
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/btc.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Bitcoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $18.7 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $12,863.08
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$67.21 (+4.33%)
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/eth.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Eathereum
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $27.4 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $08,256.04
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$51.19<span
                                            class="ms-1">(+5.64%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/aave.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Avalanche
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $12.9 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $11,896.13
                                    </h6>
                                    <p
                                        class="text-danger fs-12 mb-0">
                                        -$59.01<span
                                            class="ms-1">(-4.08%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/doge.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Dogecoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $09.5 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $15,999.06
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$74.05<span
                                            class="ms-1">(+3.12%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/bnb.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Binance
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $14.2 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $13,786.18
                                    </h6>
                                    <p
                                        class="text-danger fs-12 mb-0">
                                        -$61.05<span
                                            class="ms-1">(-9.22%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                            <li
                                class="list-group-item d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        src="assets/images/svg/crypto-icons/ltc.svg"
                                        class="avatar-xs shadow rounded-circle"
                                        alt="" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        Litecoin
                                    </h6>
                                    <p class="text-muted mb-0">
                                        $09.5 Billions
                                    </p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end">
                                    <h6 class="fs-14 mb-1">
                                        $10,604.27
                                    </h6>
                                    <p
                                        class="text-success fs-12 mb-0">
                                        +$76.12<span
                                            class="ms-1">(+4.92%)</span>
                                    </p>
                                </div>
                            </li>
                            <!-- end -->
                        </ul>
                        <!-- end ul -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>


            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('material/assets/js/pages/dashboard-crypto.init.js') }}"></script>
<script>
    $(document).ready(function() {
        let chart,chart_compresor;

        function fetchData(url, params = {}) {
            return $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json"
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

            let categories = data.map(item => item.waktu);
            let seriesData = {
                LevelFeedWater: data.map(item => item.LevelFeedWater),
                PVSteam: data.map(item => item.PVSteam),
                Batubara_FK: data.map(item => item.Batubara_FK),
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
                        name: "Level Feed Water",
                        data: seriesData.LevelFeedWater
                    },
                    {
                        name: "PV Steam",
                        data: seriesData.PVSteam
                    },
                    {
                        name: "Batu Bara",
                        data: seriesData.Batubara_FK
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
                        text: "Sensor Value"
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
                chart_compresor.updateOptions(chartOptions);
            } else {
                chart = new ApexCharts(document.querySelector("#boiler_chart"), chartOptions);
                chart_compresor = new ApexCharts(document.querySelector("#compresor_chart"), chartOptions);
                chart.render();
                chart_compresor.render();
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
                url = "/sensor/boiler-data";
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
                url = "/sensor/boiler/data-harian";
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
                url = "/sensor/boiler/data-mingguan";
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
    });
</script>

@endsection