@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Produksi - Retail Filling D5</h4>

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
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Counter</p>
                            </div>

                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" id="total_counter"></span></h4>
                                <p>Retail D5</p>
                            </div>
                            <div class="avatar-sm flex-shrink-0" data-aos="flip-up">
                                <span class=" avatar-title bg-success rounded fs-3">
                                    <i class="bx bx-plus-circle"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Average Main Speed (Spm)</p>
                            </div>

                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" id="average_main_speed"></span></h4>
                                <p>Retail D5</p>
                            </div>
                            <div class="avatar-sm flex-shrink-0" data-aos="flip-up">
                                <span class=" avatar-title bg-info rounded fs-3">
                                    <i class="bx bx-tachometer"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-animate total_stop_mesin">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Stop Periods Mesin</p>
                            </div>

                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" id="total_stop_mesin"></span></h4>

                                <p>See details Downtime Mesin</p>

                            </div>
                            <div class="avatar-sm flex-shrink-0" data-aos="flip-up">
                                <span class=" avatar-title bg-warning rounded fs-3">
                                    <i class="bx bx-cog"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-animate ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Performance Output </p>
                            </div>

                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" id="performance_output_realtime"></span></h4>

                                <p>Realtime <span id="shift_performance"></span></p>

                            </div>
                            <div class="avatar-sm flex-shrink-0" data-aos="flip-up">
                                <span class=" avatar-title bg-primary rounded fs-3">
                                    <i class="bx bx-bar-chart-alt-2"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>
        <div class="d-flex justify-content-start align-items-center flex-wrap">
            <div class="me-2">
                <select id="filter" class="form-control">
                    <option value="today" selected>Hari Ini</option>
                    <option value="date">Pilih Tanggal</option>
                    <!-- <option value="range">Rentang Tanggal</option> -->
                </select>
            </div>
            <div class="me-2 d-none" id="start-date-group">
                <input type="date" id="start-date" class="form-control" />
            </div>
            <div class="me-2 d-none" id="end-date-group">
                <input type="date" id="end-date" class="form-control" />
            </div>
            <div>
                <button class="btn btn-primary" id="apply-filter">Terapkan</button>
            </div>
        </div><br>



        <div class="row project-wrapper">

            <div class="col-xxl-8">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success rounded-2 fs-2">
                                            <i data-feather="trending-up"></i>
                                        </span>

                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Uptime Mesin</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 1</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 2</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 3</h6>

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="uptime_shift1"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="uptime_shift2"></span></h4>

                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="uptime_shift3"></span></h4>

                                        </div>
                                        <p class="text-muted mb-0">By date - Shift</p>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger rounded-2 fs-2">
                                            <i data-feather="power"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Downtime Mesin</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 1</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 2</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 3</h6>

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="downtime_shift1"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="downtime_shift2"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="downtime_shift3"></span></h4>

                                        </div>
                                        <p class="text-muted mb-0">By date - Shift</p>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div><!-- end col -->
                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning rounded-2 fs-2">
                                            <i data-feather="award"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Performance Output</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 1</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 2</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 3</h6>

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="performance_shift1"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="performance_shift2"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="performance_shift3"></span></h4>

                                        </div>
                                        <p class="text-muted mb-0">By date - Shift</p>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info rounded-2 fs-2">
                                            <i data-feather="x-circle"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                            Gagal Filling</p>
                                        <div class="d-flex align-items-center mb-3">
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 1</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 2</h6>
                                            <h6 class="fs-6 flex-grow-1 mb-0">Shift 3</h6>

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="gagal_filling_shift1"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="gagal_filling_shift2"></span></h4>
                                            <h4 class="fs-6 flex-grow-1 mb-0"><span class="badge badge-soft-primary" id="gagal_filling_shift3"></span></h4>

                                        </div>
                                        <p class="text-muted mb-0">By date - Shift</p>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div><!-- end col -->

                </div><!-- end row -->
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-xl-12">

                <div class="card crm-widget">
                    <div class="card-body p-0">

                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Total Nozzle 1
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="total_nozzle1" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 1 Shift 1

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle1_shift1" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 1 Shift 2

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle1_shift2" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 1 Shift 3

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle1_shift3" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div> 
                    </div> 
                </div>

                <div class="card crm-widget">
                    <div class="card-body p-0">

                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Total Nozzle 2
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="total_nozzle2" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 2 Shift 1

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle2_shift1" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 2 Shift 2

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle2_shift2" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col">
                                <div class="mt-3 mt-lg-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13">
                                        Output Nozzle 2 Shift 3

                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-space-ship-line display-6 text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h2 class="mb-0">
                                                <span class="counter-value" id="output_nozzle2_shift3" data-target=""></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div> 
                    </div> 
                </div> 
            </div>
            
        </div>  -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card crm-widget">
                    <div class="card-body p-0">
                        <div class="row row-cols-xxl-2 row-cols-md-3 row-cols-1 g-0">
                            <div class="col">
                                <div class="py-4 px-3">
                                    <h5 class="text-muted text-center text-uppercase fs-13">
                                        Main Speed
                                    </h5>
                                    <div id="gauge_main_speed"></div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col">
                                <div class="mt-3 mt-md-0 py-4 px-3">
                                    <h5 class="text-muted text-uppercase fs-13 text-center">
                                        Status Mesin (NOW)
                                    </h5>
                                    <div class="card-body text-center" data-aos="fade-right" id="start_mesin">

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
    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->
<div class="modal fade" id="abnormalModal" tabindex="-1" aria-labelledby="abnormalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="abnormalModalLabel">Detail data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="abnormalModalBody">
                <!-- Data detail akan ditampilkan di sini -->
            </div>
        </div>
    </div>
</div>


<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


<!-- Dashboard init -->

<script>
    let gaugeChart = null;

    function initGaugeChart(value) {
        const options = {
            chart: {
                type: 'radialBar',
                height: 200,
            },
            series: [value],
            labels: ['Main Speed'],
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '60%',
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: '18px',
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            formatter: function(val) {
                                return parseFloat(val).toFixed(1) + ' Spm';
                            }
                        }
                    }
                }
            },
            fill: {
                colors: ['#008FFB']
            }
        };

        gaugeChart = new ApexCharts(document.querySelector("#gauge_main_speed"), options);
        gaugeChart.render();
    }

    function updateGaugeChart(value) {
        if (gaugeChart) {
            gaugeChart.updateSeries([value]);
        }
    }

    function getShift(now) {
        const hours = now.getHours();
        const minutes = now.getMinutes();

        if ((hours === 6 && minutes >= 1) || (hours > 6 && hours < 14) || (hours === 14 && minutes === 0)) {
            return "Shift 1";
        } else if ((hours === 14 && minutes >= 1) || (hours > 14 && hours < 22) || (hours === 22 && minutes === 0)) {
            return "Shift 2";
        } else {
            return "Shift 3";
        }
    }

    function updateDateTime() {
        const now = new Date();
        const formattedDate = now.toLocaleDateString("en-GB", {
            day: "2-digit",
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });

        document.querySelector('#date-picker').value = formattedDate;
        document.querySelector('#shift').value = getShift(now);
    }

    async function get_data() {
        try {
            const data = await fetch("{{ url('retail/d5/last') }}").then(res => res.json());

            document.querySelector('#total_counter').textContent = data.total_counter;
            // document.querySelector('#performance_output_realtime').textContent = data.performance_output_percent + ' %';
            // document.querySelector('#shift_performance').textContent = data.shift;
            // document.querySelector('#total_stop_mesin').textContent = data.total_stop_mesin;
            document.querySelector('#average_main_speed').textContent = parseFloat(data.main_speed).toFixed(2);

            const machineStatusImg = data.Start_Mesin == 1 ?
                '{{ asset("assets/images/hijau.png") }}' :
                '{{ asset("assets/images/merah.png") }}';
            document.querySelector('#start_mesin').innerHTML = `<img src="${machineStatusImg}" alt="Status Mesin" style="height: 100px;">`;

            const speed = parseFloat(data.main_speed) || 0;
            if (!gaugeChart) initGaugeChart(speed);
            else updateGaugeChart(speed);

            updateDateTime();
            $.ajax({
                url: "{{ url('retail/d4/output/performance') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    //console.log(data);
                    $('#performance_output_realtime').text(data.performance_output_percent + ' %');
                    $('#shift_performance').text(data.shift);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            $.ajax({
                url: "{{url('retail/d4/mesin-stop-periods')}}",
                method: 'GET',
                // data: data,
                dataType: "json",
                success: function(response) {
                    $('#total_stop_mesin').text(response.total);
                    // const total = parseInt(response.total) || 0;
                    // animateCounter($('#total_stop_mesin'), total, 1000);
                    //  console.log(response);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseJSON);
                }
            });


        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    // Initialize and set refresh interval
    get_data();
    const dataRefreshInterval = setInterval(get_data, 5000);
    $(document).on('click', '.total_stop_mesin', function() {
        let filter = $('#filter').val() || 'today';
        let data = {};

        if (filter === 'today') {
            data.filter = 'realtime';
        } else if (filter === 'date') {
            data.filter = 'tanggal';
            data.tanggal = $('#start-date').val();
        } else if (filter === 'range') {
            data.filter = 'range';
            data.start_date = $('#start-date').val();
            data.end_date = $('#end-date').val();
        }

        // Ambil ulang data dan tampilkan ke modal
        $.ajax({
            url: "{{url('retail/d4/mesin-stop-periods')}}",
            method: 'GET',
            data: data,
            success: function(response) {
                const detailList = response.data;

                let html = '';
                if (detailList.length > 0) {
                    html += '<ul class="list-group">';
                    detailList.forEach(function(item, index) {
                        html += `
                        <li class="list-group-item">
                            <strong>${index + 1}.</strong>
                            <br>Mesin: Retail D4
                            <br>Start Downtime: ${item.ts_mulai ?? '-'}
                            <br>End Downtime: ${item.ts_akhir ?? '-'}
                            
                        </li>
                    `;
                    });
                    html += '</ul>';
                } else {
                    html = '<p class="text-muted">Tidak ada data stop periods untuk periode ini.</p>';
                }

                $('#abnormalModalLabel').text('Detail Stop Periods Mesin');
                $('#abnormalModalBody').html(html);
                $('#abnormalModal').modal('show');
            },
            error: function(xhr) {
                $('#abnormalModalBody').html('<p class="text-danger">Gagal memuat data</p>');
                $('#abnormalModal').modal('show');
            }
        });
    });
    // Filter change handler
    document.querySelector('#filter').addEventListener('change', function() {
        const selected = this.value;
        document.querySelectorAll('#start-date-group, #end-date-group').forEach(el => el.classList.add('d-none'));

        if (selected === 'date') {
            document.querySelector('#start-date-group').classList.remove('d-none');
        } else if (selected === 'range') {
            document.querySelectorAll('#start-date-group, #end-date-group').forEach(el => el.classList.remove('d-none'));
        }
    });

    async function fetchdataFilter() {
        const filter = document.querySelector('#filter').value || 'today';
        const today = new Date().toISOString().split('T')[0];
        const data = {
            filter
        };

        if (filter === 'date') {
            data.tanggal = document.querySelector('#start-date').value;
            data.useRealtimeUrl = data.tanggal === today;
        } else if (filter === 'range') {
            data.start_date = document.querySelector('#start-date').value;
            data.end_date = document.querySelector('#end-date').value;
        }

        const startUrl = data.useRealtimeUrl ?
            "{{ url('retail/d5/mesin/start/realtime') }}" :
            "{{ url('retail/d5/mesin/start') }}";

        const stopUrl = data.useRealtimeUrl ?
            "{{ url('retail/d5/mesin/stop/realtime') }}" :
            "{{ url('retail/d5/mesin/stop') }}";

        try {
            const [startResponse, stopResponse, performanceResponse, gagalFillingResponse] = await Promise.all([
                fetch(startUrl).then(res => res.json()),
                fetch(stopUrl).then(res => res.json()),
                fetch("{{url('retail/d5/output/performance/all_shift')}}").then(res => res.json()),
                fetch("{{url('retail/d5/output/gagal/filling')}}").then(res => res.json())
            ]);

            // Process responses
            Object.entries(startResponse.result).forEach(([shiftKey, shiftData]) => {
                document.querySelector(`#uptime_${shiftKey}`).textContent = (shiftData.hasil * 100).toFixed(2) + ' %';
            });

            Object.entries(stopResponse.result).forEach(([shiftKey, shiftData]) => {
                document.querySelector(`#downtime_${shiftKey}`).textContent = (shiftData.hasil * 100).toFixed(2) + ' %';
            });

            performanceResponse.forEach(item => {
                const shiftId = item.shift.toLowerCase().replace(' ', '');
                document.querySelector(`#performance_${shiftId}`).textContent = item.performance_output_percent + ' %';
            });

            gagalFillingResponse.forEach(item => {
                const shiftId = item.shift.toLowerCase().replace(' ', '');
                document.querySelector(`#gagal_filling_${shiftId}`).textContent = item.performance_gagal_filling_percent + ' %';
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Event listeners
    document.querySelector('#apply-filter').addEventListener('click', fetchdataFilter);
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('total_stop_mesin')) {
            const filter = document.querySelector('#filter').value || 'today';
            const requestData = {
                filter
            };

            if (filter === 'date') {
                requestData.tanggal = document.querySelector('#start-date').value;
            } else if (filter === 'range') {
                requestData.start_date = document.querySelector('#start-date').value;
                requestData.end_date = document.querySelector('#end-date').value;
            }

            fetch("{{url('retail/d5/mesin-stop-periods')}}", {
                    method: 'GET',
                    body: new URLSearchParams(requestData)
                })
                .then(res => res.json())
                .then(response => {
                    const html = response.data.length > 0 ?
                        `<ul class="list-group">${response.data.map((item, index) => `
                    <li class="list-group-item">
                        <strong>${index + 1}.</strong>
                        <br>Mesin: Retail D4
                        <br>Start Downtime: ${item.ts_mulai ?? '-'}
                        <br>End Downtime: ${item.ts_akhir ?? '-'}
                    </li>`).join('')}</ul>` :
                        '<p class="text-muted">Tidak ada data stop periods untuk periode ini.</p>';

                    document.querySelector('#abnormalModalLabel').textContent = 'Detail Stop Periods Mesin';
                    document.querySelector('#abnormalModalBody').innerHTML = html;
                    new bootstrap.Modal(document.querySelector('#abnormalModal')).show();
                })
                .catch(error => {
                    document.querySelector('#abnormalModalBody').innerHTML = '<p class="text-danger">Gagal memuat data</p>';
                    new bootstrap.Modal(document.querySelector('#abnormalModal')).show();
                });
        }
    });

    // Initial fetch
    fetchdataFilter();
</script>


@endsection