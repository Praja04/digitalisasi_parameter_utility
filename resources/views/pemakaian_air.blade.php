<!-- resources/views/dashboard/index.blade.php -->
@extends('layout')
<style>
  .form-air{
    background: linear-gradient(to top, #b3e5fc, #e3f2fd, #ffffff);
  }
</style>
@section('content')
<div class="page-content form-air">
    <div class="container-fluid ">
        <div class="row ">
            <div class="col-xxl-2"></div>
            <div class="col-xxl-8">
                <div class="card shadow-lg">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Gutters</h4>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="gutters-showcode" class="form-label text-muted">Show Code</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="gutters-showcode">
                            </div>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <p class="text-muted">By adding <a href="/docs/5.1/layout/gutters/" class="text-decoration-underline">gutter modifier classes</a>, you can have control over the gutter width in as well the inline as block direction. <span class="fw-medium">Also requires the <code>$enable-grid-classes</code> Sass variable to be enabled</span> (on by default).</p>
                        <div class="live-preview">
                            <form action="javascript:void(0);" class="row g-3">
                                <div class="col-md-12">
                                    <label for="fullnameInput" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="fullnameInput" placeholder="Enter your name">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Address 2</label>
                                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="inputCity" placeholder="Enter your city">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputState" class="form-label">State</label>
                                    <select id="inputState" class="form-select" data-choices data-choices-sorting="true">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputZip" class="form-label">Zip</label>
                                    <input type="text" class="form-control" id="inputZip" placeholder="Zin code">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck">
                                        <label class="form-check-label" for="gridCheck">
                                            Check me out
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection