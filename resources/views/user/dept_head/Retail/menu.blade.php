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

            <div class="col-xl-4 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d3">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status_d3"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling</a></h5>
                        <p class="text-muted mb-4">Retail D3</p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div>Performance Output : <p id="retail_d3_mesin"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild3')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d4">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling</a></h5>
                        <p class="text-muted mb-4">Retail D4</p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div>Performance Output : <p id="retail_d4_mesin"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild4')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon" id="ribbon_d5">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text" id="mesin_status_d5"></span>
                        </div>
                        <img src="{{asset('/assets/images/retail.png')}}" alt="" height="90">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Retail Filling</a></h5>
                        <p class="text-muted mb-4">Retail D5</p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div>Performance Output : <p id="retail_d5_mesin"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('prd/dept_head/dashboard_retaild5')}}" class="btn btn-light w-100">Lihat Detail</a>
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

        function updateDateData() {
            let now = new Date();
            let formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });

            $('#date-picker').val(formattedDate);

            // Retail D3
            $.ajax({
                url: "{{ url('retail/d3/last') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    let status_mesin_d3 = data.start_mesin == 1 ? 'On' : 'Off';
                    $('#ribbon_d3').removeClass('ribbon-success ribbon-danger').addClass(status_mesin_d3 === 'On' ? 'ribbon-success' : 'ribbon-danger');
                    $('#mesin_status_d3').text(status_mesin_d3);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            $.ajax({
                url: "{{ url('retail/d3/output/performance') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#retail_d3_mesin').text(data.performance_output_percent + '%');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            // Retail D4
            $.ajax({
                url: "{{ url('retail/d4/last') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    let status_mesin_d4 = data.start_mesin == 1 ? 'On' : 'Off';
                    $('#ribbon_d4').removeClass('ribbon-success ribbon-danger').addClass(status_mesin_d4 === 'On' ? 'ribbon-success' : 'ribbon-danger');
                    $('#mesin_status').text(status_mesin_d4);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            $.ajax({
                url: "{{ url('retail/d4/output/performance') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#retail_d4_mesin').text(data.performance_output_percent + '%');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            //Retail D5
            $.ajax({
                url: "{{ url('retail/d5/last') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    let status_mesin_d4 = data.start_mesin == 1 ? 'On' : 'Off';
                    $('#ribbon_d5').removeClass('ribbon-success ribbon-danger').addClass(status_mesin_d4 === 'On' ? 'ribbon-success' : 'ribbon-danger');
                    $('#mesin_status_d5').text(status_mesin_d4);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });

            $.ajax({
                url: "{{ url('retail/d5/output/performance') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#retail_d5_mesin').text(data.performance_output_percent + '%');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        updateDateData();
    });
</script>

@endsection