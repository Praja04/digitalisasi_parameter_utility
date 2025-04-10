@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">QC - Pasteurisasi Line 1</h4>

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


        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Brix
                                    </h5>
                                    <div id="chart_brix"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Viscositas

                                    </h5>
                                    <div id="chart_viscositas"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Aw

                                    </h5>
                                    <div id="chart_aw"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        pH

                                    </h5>
                                    <div id="chart_ph"></div>
                                </div>
                            </div>
                            <!-- end col -->


                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->

                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="mt-4 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Bj

                                    </h5>
                                    <div id="chart_bj"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-4 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Buih

                                    </h5>
                                    <div id="chart_buih"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-4 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Endapan

                                    </h5>
                                    <div id="chart_endapan"></div>
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
        $.ajax({
            url: "{{ url('qc/data') }}",
            method: "GET",
            dataType: "json",
            success: function(data) {
                const categories = data.map(item => {
                    let date = new Date(item.created_at);
                    return date.toISOString().split('T')[0]; // hasil: "2025-04-09"
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

                const chartOptions = (title, dataSeries, id) => ({
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
                            show: false,
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
                                return val + ' %';
                            }
                        }
                    }
                });

                new ApexCharts(document.querySelector("#chart_brix"), chartOptions('Brix', chartData.brix)).render();
                new ApexCharts(document.querySelector("#chart_viscositas"), chartOptions('Viscositas', chartData.viscositas)).render();
                new ApexCharts(document.querySelector("#chart_aw"), chartOptions('Aw', chartData.aw)).render();
                new ApexCharts(document.querySelector("#chart_ph"), chartOptions('pH', chartData.ph)).render();
                new ApexCharts(document.querySelector("#chart_bj"), chartOptions('Bj', chartData.bj)).render();
                new ApexCharts(document.querySelector("#chart_buih"), chartOptions('Buih', chartData.buih)).render();
                new ApexCharts(document.querySelector("#chart_endapan"), chartOptions('Endapan', chartData.endapan)).render();
            },
            error: function(xhr) {
                console.error("Gagal ambil data QC:", xhr);
            }
        });


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

        function updateRealtimeInfo() {
            $.ajax({
                url: "{{ url('pasteurisasi1/data-realtime') }}",
                dataType: "json",
                success: function(res) {
                    $('#varian_status_running').text(res.Varian);
                    $('#mode_status_running').text(res.Mode);
                    $('#batch_status_running').text(res.Batch);
                    $('#storage_status_running').text(res.Storage);

                    // Update gauge dari suhu holding realtime
                    if (res.SpeedPompaMixing !== undefined && res.SpeedPompaMixing !== null) {
                        updateGaugeChart(res);
                    }
                },
                error: function(_xhr, status, error) {
                    console.error('AJAX Error:', status, error);
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
        updateRealtimeInfo();

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
        }

        // Panggil fungsi pertama kali
        updateDateTime();
    })
</script>
@endsection