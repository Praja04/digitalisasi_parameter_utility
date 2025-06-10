@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pemakaian Air</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Eng</a></li>
                            <li class="breadcrumb-item active">Operator</li>
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

            <div class="col-xl-6 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text">Form Pemakaian</span>
                        </div>
                        <img src="{{ asset('assets/images/formulir.png' ) }}" alt="gambar" height="100" style="border-radius: 20px;">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Form Pemakaian Air </a></h5>
                        <p class="text-muted mb-4">Input Pemakaian</p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div id="chart-input-po" data-colors='["--vz-danger"]'></div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('eng/foreman/pemakaian_air')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-success ribbon-shape trending-ribbon">
                            <i class="ri-hand-heart-fill text-white align-bottom"></i>
                            <span class="trending-ribbon-text">Data Pemakaian</span>
                        </div>
                        <img src="{{ asset('assets/images/pemakaian_air.png' ) }}" alt="gambar" height="100" style="border-radius: 20px;">
                        <h5 class="mb-1 mt-4"><a href="" class="link-primary">Data Pemakaian Air</a></h5>
                        <p class="text-muted mb-4">Data Pemakaian Air All Area</p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div id="chart-input-po" data-colors='["--vz-danger"]'></div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{url('eng/foreman/data_air')}}" class="btn btn-light w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection