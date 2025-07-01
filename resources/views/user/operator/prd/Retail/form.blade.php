@extends('layout')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h1>Manajemen Produksi</h1>
                            <p class="fs-16 lh-base">Kelola Target & Shift Harian</p>
                        </div>
                        <img src="{{ asset('assets/images/gudang.png') }}" class="img-fluid" alt="" style="max-height: 100px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Unit -->
        <div class="row">
            <div class="col-md-6">
                <div class="card clickable card-unit target-card" data-target="#form-target">
                    <div class="card-body text-center">
                        <h4 class="card-title">Target Varian</h4>
                        <img src="{{ asset('assets/images/total.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
                        <p class="text-muted">Klik untuk input target produksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card clickable card-unit shift-card" data-target="#form-shift">
                    <div class="card-body text-center">
                        <h4 class="card-title">Variant Shift</h4>
                        <img src="{{ asset('assets/images/variant.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
                        <p class="text-muted">Klik untuk input data shift</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Target Varian -->
        <div class="row mt-4 form-section" id="form-target" style="display: none;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Target Varian</h5>
                    </div>
                    <div class="card-body">
                        <form id="formTargetVarian">
                            @csrf
                            <div class="mb-3">
                                <label for="variant_name">Nama Varian</label>
                                <select name="variant_name" class="form-control" required>
                                    <option value="">Pilih Varian</option>
                                    <option value="YB20gr">Varian YB20gr</option>
                                    <option value="YB77gr">Varian YB77gr</option>
                                    <option value="BB77BBG1">Varian BB77BBG1</option>
                                    <option value="BB77Harga">Varian BB77Harga</option>
                                    <option value="250gr">Varian 250gr</option>
                                    <option value="BB725">Varian BB725</option>
                                    <option value="40gr">Varian 40gr</option>
                                    <option value="700gr">Varian 700gr</option>
                                    <option value="BB725">Varian BB725</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Target Produksi</label>
                                <input type="number" class="form-control" name="target" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Target</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Variant Shift -->
        <div class="row mt-4 form-section" id="form-shift" style="display: none;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5>Form Variant Shift</h5>
                    </div>
                    <div class="card-body">
                        <!-- Form Variant Shift -->
                        <form id="formVariantShiftEntry">
                            @csrf
                            <div class="mb-3">
                                <label for="variant_name">Nama Varian</label>
                                <select name="variant_name" class="form-control" required>
                                    <option value="">Pilih Varian</option>
                                    <option value="YB20gr">Varian YB20gr</option>
                                    <option value="YB77gr">Varian YB77gr</option>
                                    <option value="BB77BBG1">Varian BB77BBG1</option>
                                    <option value="BB77Harga">Varian BB77Harga</option>
                                    <option value="250gr">Varian 250gr</option>
                                    <option value="BB725">Varian BB725</option>
                                    <option value="40gr">Varian 40gr</option>
                                    <option value="700gr">Varian 700gr</option>
                                    <option value="BB725">Varian BB725</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shift_number">Shift</label>
                                <select class="form-select" name="shift_number" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="1">Shift 1</option>
                                    <option value="2">Shift 2</option>
                                    <option value="3">Shift 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="total">Jumlah Produksi</label>
                                <input type="number" class="form-control" name="total" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <button type="submit" class="btn btn-info">Simpan Shift</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Interaktifitas -->
<script>
    $(document).ready(function() {
        $('.card-unit').on('click', function() {
            const targetId = $(this).data('target');
            $('.form-section').hide();
            $(targetId).show();
        });
    });

    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    // Submit form target varian
    $('#formTargetVarian').on('submit', function(e) {
        e.preventDefault();

        $.post("{{ url('prd/store/varian/retail') }}", $(this).serialize())
            .done(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 3000);
            })
            .fail(xhr => {
                const message = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan target!',
                    text: message
                });
            });
    });

    // Submit form data shift
    $('#formVariantShiftEntry').on('submit', function(e) {
        e.preventDefault();

        $.post("{{ url('prd/store/shift/retail') }}", $(this).serialize())
            .done(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 3000);
            })
            .fail(xhr => {
                const message = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan shift!',
                    text: message
                });
            });
    });
</script>

<style>
    .clickable {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .clickable:hover {
        transform: scale(1.03);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    }

    .target-card:hover {
        background-color: #fff3cd;
        border: 1px solid #ffc107;
    }

    .shift-card:hover {
        background-color: #cff4fc;
        border: 1px solid #0dcaf0;
    }
</style>

@endsection