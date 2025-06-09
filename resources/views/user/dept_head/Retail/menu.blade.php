@extends('layout')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Retail Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Mesin</a></li>
                            <li class="breadcrumb-item active">Retail</li>
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
                        <h4 class="fs-16 mb-1">Selamat Datang, {{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Mari tingkatkan kualitas agar menjadi perusahan makanan kelas dunia.</p>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <form action="javascript:void(0);">
                            <div class="row g-3 mb-0 align-items-center">
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input id="date-picker" type="text" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-auto">
                                    <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn shadow-none"><i class="ri-pulse-line"></i></button>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>

        <div class="row mt-4">

            <div class="col-xl-3 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d3">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status_d3"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling D3</a></h5>
                        <p class="text-muted mb-4">Performance Output</p>
                        <div class="px-2 py-2 mt-1">
                            <p class="mb-1">Shift 1 :
                                <span id="total_counter_d3_shift1"></span> <span class="float-end" id="retail_d3_mesin_shift1"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" id="progress_d3_shift1" role="progressbar">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 2 :
                                <span id="total_counter_d3_shift2"></span>
                                <span class="float-end" id="retail_d3_mesin_shift2"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d3_shift2">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 3 :
                                <span id="total_counter_d3_shift3"></span> <span class="float-end" id="retail_d3_mesin_shift3"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d3_shift3">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild3')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d4">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling D4</a></h5>
                        <p class="text-muted mb-4">Performance Output</p>
                        <div class="px-2 py-2 mt-1">
                            <p class="mb-1">Shift 1 :
                                <span id="total_counter_d4_shift1"></span> <span class="float-end" id="retail_d4_mesin_shift1"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d4_shift1">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 2 :
                                <span id="total_counter_d4_shift2"></span>
                                <span class="float-end" id="retail_d4_mesin_shift2"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d4_shift2">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 3 :
                                <span id="total_counter_d4_shift3"></span> <span class="float-end" id="retail_d4_mesin_shift3"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d4_shift3">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild4')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d5">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status_d5"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling D5</a></h5>
                        <p class="text-muted mb-4">Performance Output</p>
                        <div class="px-2 py-2 mt-1">
                            <p class="mb-1">Shift 1 :
                                <span id="total_counter_d5_shift1"></span> <span class="float-end" id="retail_d5_mesin_shift1"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d5_shift1">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 2 :
                                <span id="total_counter_d5_shift2"></span>
                                <span class="float-end" id="retail_d5_mesin_shift2"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d5_shift2">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 3 :
                                <span id="total_counter_d5_shift3"></span> <span class="float-end" id="retail_d5_mesin_shift3"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d5_shift3">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild5')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d6">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status_d6"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling D6</a></h5>
                        <p class="text-muted mb-4">Performance Output</p>
                        <div class="px-2 py-2 mt-1">
                            <p class="mb-1">Shift 1 :
                                <span id="total_counter_d6_shift1"></span> <span class="float-end" id="retail_d6_mesin_shift1"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d6_shift1">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 2 :
                                <span id="total_counter_d6_shift2"></span>
                                <span class="float-end" id="retail_d6_mesin_shift2"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d6_shift2">
                                </div>
                            </div>

                            <p class="mt-3 mb-1">Shift 3 :
                                <span id="total_counter_d6_shift3"></span> <span class="float-end" id="retail_d6_mesin_shift3"></span>
                            </p>
                            <div class="progress bg-soft-primary mt-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" id="progress_d6_shift3">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild6')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
</div>

<script>
    $(document).ready(function() {

        async function fetchJSON(url) {
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return await response.json();
            } catch (error) {
                console.error("Error fetching data:", error);
                return null;
            }
        }

        async function updateDateData() {
            // Format tanggal
            let now = new Date();
            let formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });
            $('#date-picker').val(formattedDate);

            // Array mesin
            const mesinList = ['d3', 'd4', 'd5', 'd6'];

            for (const mesin of mesinList) {
                // Ambil status mesin
                const statusData = await fetchJSON(`{{ url('retail/${mesin}/last') }}`.replace('${mesin}', mesin));
                if (statusData) {
                    const status = statusData.start_mesin == 1 ? 'On' : 'Off';
                    $(`#ribbon_${mesin}`).removeClass('ribbon-success ribbon-danger').addClass(status === 'On' ? 'ribbon-success' : 'ribbon-danger');

                    // Penyesuaian id mesin_status
                    if (mesin === 'd4') {
                        $('#mesin_status').text(status); // khusus d4 pakai id ini
                    } else {
                        $(`#mesin_status_${mesin}`).text(status);
                    }
                }

                // Ambil performance mesin
                const perfData = await fetchJSON(`{{ url('retail/${mesin}/output/performance/all_shift?filter=realtime') }}`.replace('${mesin}', mesin));
                if (perfData && Array.isArray(perfData)) {
                    perfData.forEach(item => {
                        let shiftNum = '';
                        if (item.shift.includes('1')) shiftNum = 'shift1';
                        else if (item.shift.includes('2')) shiftNum = 'shift2';
                        else if (item.shift.includes('3')) shiftNum = 'shift3';
                        else return;

                        // Total Counter
                        $(`#total_counter_${mesin}_${shiftNum}`).text(item.total_counter ?? '-');

                        // Nama Mesin (jika tersedia di item)
                        $(`#retail_${mesin}_mesin_${shiftNum}`).text((item.performance_output_percent + '%') ?? '');
                        const progress = item.performance_output_percent ?? 0;
                        $(`#progress_${mesin}_${shiftNum}`)
                            .css('width', `${progress}%`)
                            .attr('aria-valuenow', progress)
                            .attr('aria-valuemax', 100); // max selalu 100%
                    });
                }


            }
        }

        updateDateData();
    });
</script>



@endsection