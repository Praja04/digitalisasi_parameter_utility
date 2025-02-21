<!-- resources/views/dashboard/index.blade.php -->
@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Good Morning, {{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>
                  
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
    </div>
</div>

<!-- Include Chart.js library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->



@endsection