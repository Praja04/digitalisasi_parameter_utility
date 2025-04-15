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
                                Engineering
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
                                <!--end col-->
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input style="font-size: 24px; width: 200px; height: 50px;" id="PV-bar" type="text" class="text-center form-control border-0 dash-filter-picker shadow" disabled>
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <h5 class="text-white">PV</h5>
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
                        <div class="row row-cols-xxl-6 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LevelFeedWater
                                    </h5>
                                    <div id="gauge_chart_levelfeedwater"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        FeedPressure

                                    </h5>
                                    <div id="gauge_chart_feedpressure"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        SuhuFeedTank

                                    </h5>
                                    <div id="gauge_chart_suhufeedtank"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHTemp

                                    </h5>
                                    <div id="gauge_chart_lhtemp"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHTemp

                                    </h5>
                                    <div id="gauge_chart_rhtemp"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        IDFan

                                    </h5>
                                    <div id="gauge_chart_idfan"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHGuiloutine

                                    </h5>
                                    <div id="gauge_chart_lhguiloutine"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHGuiloutine

                                    </h5>
                                    <div id="gauge_chart_rhguiloutine"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHFDFan

                                    </h5>
                                    <div id="gauge_chart_lhfdfan"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        LHStoker

                                    </h5>
                                    <div id="gauge_chart_lhstoker"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        RHStoker

                                    </h5>
                                    <div id="gauge_chart_rhstoker"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        InletWaterFlow

                                    </h5>
                                    <div id="gauge_chart_inletwaterflow"></div>
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
            <div class="col-xxl-3">
                <div class="card card-height-70">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Chemical
                        </h4>
                    </div>
                    <div class="d-flex mb-3">
                        <select id="modeSelector" class="form-select w-auto">
                            <option value="harian" selected>Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                        </select>
                    </div>
                    <!-- end cardheader -->
                    <div class="card-body">
                        <div id="portfolio_donut_charts" data-colors='["--vz-primary", "--vz-info", "--vz-warning", "--vz-success"]' class="apex-charts" dir="ltr"></div>

                        <ul id="chemical-list" class="list-group list-group-flush border-dashed mb-0 mt-3 pt-2">
                            {{-- Dynamic content here --}}
                        </ul>

                        <!-- end -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xxl-9 order-xxl-0 order-first">

                <div class="d-flex flex-column h-900">
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
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Air
                        </h4>
                        <div class="d-flex mb-3">
                            <select id="modeAirSelector" class="form-select w-auto">
                                <option value="terakhir" selected>7 Terakhir</option>
                                <option value="harian">Harian</option>
                                <option value="mingguan">Mingguan</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <!-- end card-header -->
                    <div class="card-body p-0">
                        <ul id="list-air-pemakaian" class="list-group list-group-flush border-dashed mb-0">
                            <!-- Data will be inserted here -->
                        </ul>
                        <!-- end ul -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>

            <div class="col-xl-3">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Pemakaian Listrik
                        </h4>
                        <div class="d-flex mb-3">
                            <select id="modeListrikSelector" class="form-select w-auto">
                                <option value="terakhir" selected>7 Terakhir</option>
                                <option value="harian">Harian</option>
                                <option value="mingguan">Mingguan</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <!-- end card-header -->
                    <div class="card-body p-0">
                        <ul id="list-listrik-pemakaian" class="list-group list-group-flush border-dashed mb-0">
                            <!-- Data will be inserted here -->
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
<script>
    $(document).ready(function() {
        let chart, chart_compresor;
        let gaugeCharts = {
            levelfeedwater: null,
            feedpressure: null,
            suhufeedtank: null,
            lhtemp: null,
            rhtemp: null,
            idfan: null,
            lhguiloutine: null,
            rhguiloutine: null,
            lhfdfan: null,
            lhstoker: null,
            rhstoker: null,
            inletwaterflow: null,
        };

        const gaugeOptions = (value) => ({
            chart: {
                height: 150,
                type: "radialBar"
            },
            series: [parseFloat(value)],
            labels: [""],
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: "50%"
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            show: true,
                            fontSize: "16px",
                            formatter: function(val) {
                                return parseFloat(val).toFixed(1); // misal tampilkan 1 angka desimal
                            }
                        }
                    }
                }
            },
            colors: ["#00E396"]
        });

        const fetchData = (url, params = {}) =>
            $.ajax({
                url,
                type: "GET",
                data: params,
                dataType: "json"
            });

        const UpdateChartSensor = (data) => {
            if (!data.length) {
                chart?.updateSeries([{
                    data: []
                }]);
                Swal.fire({
                    icon: "warning",
                    title: "Data Tidak Ditemukan",
                    text: "Tidak ada data untuk rentang waktu yang dipilih."
                });
                return;
            }

            const categories = data.map(i => i.waktu);
            const series = [{
                    name: "Level Feed Water",
                    data: data.map(i => i.LevelFeedWater)
                },
                {
                    name: "PV Steam",
                    data: data.map(i => i.PVSteam)
                },
                {
                    name: "Batu Bara",
                    data: data.map(i => i.Batubara_FK)
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
                colors: ["#0acf97", "#fa5c7c", "#ffbc00"],
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
                chart.updateOptions(options);
                chart_compresor.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#boiler_chart"), options);
                chart_compresor = new ApexCharts(document.querySelector("#compresor_chart"), options);
                chart.render();
                chart_compresor.render();
            }
        };

        const updateChart = (selector, config, instanceKey) => {
            if (gaugeCharts[instanceKey]) {
                gaugeCharts[instanceKey].updateOptions(config);
            } else {
                gaugeCharts[instanceKey] = new ApexCharts(document.querySelector(selector), config);
                gaugeCharts[instanceKey].render();
            }
        };

        const updateGaugeChart = (data) => {
            const chartData = {
                levelfeedwater: data.LevelFeedWater,
                feedpressure: data.FeedPressure,
                suhufeedtank: data.SuhuFeedTank,
                lhtemp: data.LHTemp,
                rhtemp: data.RHTemp,
                idfan: data.IDFan,
                lhguiloutine: data.LHGuiloutine,
                rhguiloutine: data.RHGuiloutine,
                lhfdfan: data.LHFDFan,
                lhstoker: data.LHStoker,
                rhstoker: data.RHStoker,
                inletwaterflow: data.InletWaterFlow,
            };

            for (const [key, val] of Object.entries(chartData)) {
                updateChart(`#gauge_chart_${key}`, gaugeOptions(val), key);
            }
        };

        const updatePVSteam = () => {
            $.getJSON("{{ url('sensor/boiler-realtime') }}", (response) => {
                if (response) {
                    $('#PV-bar').val(`${response.PVSteam} Bar`);
                    updateGaugeChart(response);
                }
            }).fail((xhr, status, error) => console.error(`AJAX Error: ${status} ${error}`));
        };

        const updateInputFields = () => {
            const filter = $("#filterData").val();
            $("#datePicker, #startDate, #endDate").addClass("d-none");
            if (filter === "daily") $("#datePicker").removeClass("d-none");
            else if (filter === "weekly") $("#startDate, #endDate").removeClass("d-none");
        };

        $("#filterData").on("change", updateInputFields);

        $("#applyFilter").on("click", () => {
            const filter = $("#filterData").val();
            let url = "",
                params = {};

            if (filter === "latest") {
                url = "{{ url('sensor/boiler-data') }}";
            } else if (filter === "daily") {
                const tanggal = $("#datePicker").val();
                if (!tanggal) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Tanggal!",
                    text: "Harap pilih tanggal terlebih dahulu."
                });
                url = "{{ url('sensor/boiler/data-harian') }}";
                params = {
                    tanggal
                };
            } else if (filter === "weekly") {
                const start = $("#startDate").val(),
                    end = $("#endDate").val();
                if (!start || !end) return Swal.fire({
                    icon: "warning",
                    title: "Pilih Rentang Tanggal!",
                    text: "Harap pilih tanggal mulai dan selesai."
                });
                url = "{{ url('sensor/boiler/data-mingguan') }}";
                params = {
                    tanggal_mulai: start,
                    tanggal_selesai: end
                };
            }

            fetchData(url, params).done(response => {
                response.success ? UpdateChartSensor(response.data) :
                    Swal.fire({
                        icon: "warning",
                        title: "Data Tidak Ditemukan",
                        text: "Tidak ada data untuk rentang waktu yang dipilih."
                    });
            });
        });

        updateInputFields();
        $("#applyFilter").trigger("click");
        updatePVSteam();
        setInterval(updatePVSteam, 5000);

        ////////////////////chemical////////////////////////
        function fetchChemicalData(mode = 'harian') {
            let apiUrl = "{{url('/eng/api/chemical')}}" + '/' + mode;

            $.ajax({
                url: apiUrl,
                dataType: "json",
                success: function(res) {
                    console.log(res);

                    // Render Chart
                    renderChemicalChart(res.data || []);

                    // Render Top 3 List
                    renderTop3List(res.top3 || []);
                },
                error: function(_xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function renderTop3List(top3) {
            const listContainer = $("#chemical-list");
            listContainer.empty();

            if (top3.length === 0) {
                listContainer.append(`<li class="list-group-item px-0 text-center text-muted">Tidak ada data.</li>`);
                return;
            }

            const colorClass = ["text-primary", "text-warning", "text-info", "text-success"];
            const icons = ["btc.svg", "ltc.svg", "eth.svg", "usdt.svg"];

            top3.forEach((item, index) => {
                let color = colorClass[index % colorClass.length];
                let icon = icons[index % icons.length];

                listContainer.append(`
                    <li class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 avatar-xs">
                                <span class="avatar-title bg-light p-1 rounded-circle shadow">
                                    <img src="assets/images/svg/crypto-icons/${icon}" class="img-fluid" alt="" />
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-1">${item.nama_chemical}</h6>
                                <p class="fs-12 mb-0 text-muted">
                                    <i class="mdi mdi-circle fs-10 align-middle ${color} me-1"></i>
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">${item.total.toLocaleString()}</h6>
                                <p class="text-danger fs-12 mb-0">
                                Kilogram</p>
                            </div>
                        </div>
                    </li>
                `);
            });
        }

        // Dropdown filter handler
        $('#modeSelector').on('change', function() {
            const mode = $(this).val();
            fetchChemicalData(mode);
        });

        // Initial fetch
        fetchChemicalData();

        //api pemakaian air
        function loadAirData(mode = 'terakhir') {
            let apiUrl = mode === 'terakhir' ?
                "{{url('eng/api/air/terakhir')}}" :
                "{{url('eng/api/air/')}}" + $mode;

            $.ajax({
                url: apiUrl,
                dataType: 'json',
                success: function(data) {
                    renderAirList(data);
                },
                error: function(_xhr, status, error) {
                    console.error('Gagal load data air:', status, error);
                }
            });
        }

        function renderAirList(data) {
            let list = $('#list-air-pemakaian');
            list.empty();

            if (data.length === 0) {
                list.append(`<li class="list-group-item text-center text-muted">Tidak ada data.</li>`);
                return;
            }

            data.forEach((item, i) => {
                const iconList = ['btc', 'eth', 'ltc', 'aave', 'bnb', 'doge', 'usdt'];
                const icon = iconList[i % iconList.length];

                list.append(`
                    <li class="list-group-item d-flex align-items-center">
                       
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Pemakaian Air</h6>
                            <p class="text-muted mb-0">${item.tanggal}</p>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="fs-14 mb-1">${parseFloat(item.pemakaian_liter).toLocaleString()} L</h6>
                            <p class="text-success fs-12 mb-0">${item.notes ?? ''}</p>
                        </div>
                    </li>
                `);
            });
        }

        $('#modeAirSelector').on('change', function() {
            let mode = $(this).val();
            loadAirData(mode);
        });

        loadAirData(); // Load default


        // api pemakaian listrik
         function loadListrikData(mode = 'terakhir') {
            let apiUrl = mode === 'terakhir' ?
                "{{url('eng/api/listrik/terakhir')}}" :
                "{{url('eng/api/listrik/')}}" + $mode;

            $.ajax({
                url: apiUrl,
                dataType: 'json',
                success: function(data) {
                    renderListrikList(data);
                },
                error: function(_xhr, status, error) {
                    console.error('Gagal load data listrik:', status, error);
                }
            });
        }

        function renderListrikList(data) {
            let list = $('#list-listrik-pemakaian');
            list.empty();

            if (data.length === 0) {
                list.append(`<li class="list-group-item text-center text-muted">Tidak ada data.</li>`);
                return;
            }

            data.forEach((item, i) => {
                

                list.append(`
                    <li class="list-group-item d-flex align-items-center">
                       
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Pemakaian Lsitrik</h6>
                            <p class="text-muted mb-0">${item.tanggal}</p>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="fs-14 mb-1">${parseFloat(item.pemakaian_kwh).toLocaleString()} Kwh</h6>
                            <p class="text-success fs-12 mb-0">${item.notes ?? ''}</p>
                        </div>
                    </li>
                `);
            });
        }

        $('#modeListrikSelector').on('change', function() {
            let mode = $(this).val();
            loadListrikData(mode);
        });

        loadListrikData(); // Load default
    });

    let chartChemical;

    function renderChemicalChart(data) {
        const colors = getChartColorsArray("#portfolio_donut_charts");

        const labels = data.map(item => item.nama_chemical);
        const totals = data.map(item => item.total);

        const options = {
            chart: {
                type: 'donut',
                height: 250
            },
            labels: labels,
            series: totals,
            colors: colors,
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            }
        };

        if (chartChemical) {
            chartChemical.updateOptions(options);
        } else {
            chartChemical = new ApexCharts(document.querySelector("#portfolio_donut_charts"), options);
            chartChemical.render();
        }
    }

    function getChartColorsArray(chartId) {
        const colors = document.querySelector(chartId).getAttribute("data-colors");
        return JSON.parse(colors).map(value => {
            const newValue = value.replace(" ", "");
            if (newValue.indexOf("--") !== -1) {
                const style = getComputedStyle(document.documentElement);
                return style.getPropertyValue(newValue) || undefined;
            } else {
                return newValue;
            }
        });
    }
</script>

@endsection