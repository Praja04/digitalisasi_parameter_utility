@extends('layout')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row align-items-end">
                            <div class="col-sm-10">
                                <div class="p-3">
                                    <h1>P2H Online Form</h1>
                                    <p class="fs-16 lh-base">Periksa Forklift Anda dengan Teliti</p>
                                </div>
                            </div>
                            <div class="col-sm-2 text-end">
                                <img src="{{ asset('assets/images/gudang.png') }}" class="img-fluid" alt="" style="max-height: 100px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Unit -->
        <div class="row">
            <div class="col-md-6">
                <div class="card clickable card-unit forklift-card" data-unit="Forklift">
                    <div class="card-body text-center">
                        <h4 class="card-title">Forklift</h4>
                        <img src="{{ asset('assets/images/forklift.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
                        <p class="text-muted">Klik untuk pemeriksaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card clickable card-unit pallet-card" data-unit="Pallet Mover">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pallet Mover</h4>
                        <img src="{{ asset('assets/images/pallet.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
                        <p class="text-muted">Klik untuk pemeriksaan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row mt-4" id="form-container" style="display: none;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5 id="form-title">Form Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        <form id="formP2H">
                            @csrf
                            <input type="hidden" id="jenis_p2h" name="jenis_p2h" />

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Nomor Unit</label>
                                    <input type="text" class="form-control" name="nomor_unit">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Departemen</label>
                                    <input type="text" class="form-control" name="dept" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Shift</label>
                                    <select class="form-control" name="shift" required>
                                        <option value="">-- Pilih Shift --</option>
                                        <option value="1">Shift 1</option>
                                        <option value="2">Shift 2</option>
                                        <option value="3">Shift 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Jam Operasional</label>
                                    <input type="text" class="form-control" name="jam_operasional" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Operator</label>
                                    <input type="text" class="form-control" value="{{ Session::get('username') }}" name="operator_name" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Catatan</label>
                                    <textarea class="form-control" name="catatan"></textarea>
                                </div>
                            </div>

                            <hr>
                            <h5>Pemeriksaan Item</h5>
                            <div class="row">
                                @php
                                $checks = [
                                'cek_baterai' => 'Baterai',
                                'cek_fork' => 'Fork',
                                'kondisi_body_kebersihan' => 'Body & Kebersihan',
                                'lampu_kiri' => 'Lampu Kiri',
                                'lampu_kanan' => 'Lampu Kanan',
                                'lampu_sorot' => 'Lampu Sorot',
                                'lampu_sign_depan_kanan' => 'Sign Depan Kanan',
                                'lampu_sign_depan_kiri' => 'Sign Depan Kiri',
                                'kipas_belakang' => 'Kipas Belakang',
                                'rantai_lift' => 'Rantai Lift',
                                'sistem_hidrolik' => 'Sistem Hidrolik',
                                'kondisi_axle' => 'Axle',
                                'sistem_kemudi' => 'Sistem Kemudi',
                                'panel_display' => 'Panel Display',
                                'air_aki' => 'Air Aki',
                                'klakson' => 'Klakson',
                                'buzzer_mundur' => 'Buzzer Mundur',
                                'kaca_spion' => 'Kaca Spion',
                                'kondisi_ban' => 'Ban',
                                'fungsi_rem' => 'Rem',
                                ];
                                @endphp
                                @foreach ($checks as $key => $label)
                                <div class="col-md-4 mb-3">
                                    <label>{{ $label }}</label>
                                    <div>
                                        <label class="me-2 radio-label" data-type="ok">
                                            <input type="radio" name="{{ $key }}" value="1" required> OK
                                        </label>
                                        <label class="radio-label" data-type="nok">
                                            <input type="radio" name="{{ $key }}" value="0"> NOK
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" id="cancelForm">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        $('.card-unit').on('click', function() {
            let unit = $(this).data('unit');

            // Sembunyikan form dulu
            $('#form-container').slideUp(600, function() {
                // Setelah tertutup, set data baru dan tampilkan kembali
                $('#jenis_p2h').val(unit);
                $('#form-title').text(`Form Pemeriksaan - ${unit}`);
                $('#formP2H')[0].reset();
                $('#form-container').slideDown();
            });
        });


        $('#cancelForm').on('click', function() {
            $('#formP2H')[0].reset();
            $('#form-container').slideUp();
        });

        $('#formP2H').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('wh/p2h/store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message ?? 'Data P2H disimpan!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#formP2H')[0].reset();
                    $('#form-container').slideUp();
                    setInterval(() => {
                        location.reload();
                    }, 3000);
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan.';
                    if (xhr.responseJSON?.errors) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Gagal', msg, 'error');
                }

            });
        });

        $('input[type=radio]').on('change', function() {
            const name = $(this).attr('name');
            const isOk = $(this).val() === '1';

            const group = $(`input[name="${name}"]`);

            group.each(function() {
                $(this).closest('.radio-label').removeClass('ok-selected nok-selected');
            });

            if (isOk) {
                $(this).closest('.radio-label').addClass('ok-selected');
            } else {
                $(this).closest('.radio-label').addClass('nok-selected');
            }
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

    .forklift-card:hover {
        background-color: #ffe5e5;
        border: 1px solid #dc3545;
    }

    .pallet-card:hover {
        background-color: #e0f0ff;
        border: 1px solid #0d6efd;
    }

    .radio-label {
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        display: inline-block;
    }

    .radio-label.ok-selected {
        background-color: #d1f7d6;
        color: #0f5132;
        border-color: #198754;
    }

    .radio-label.nok-selected {
        background-color: #f8d7da;
        color: #842029;
        border-color: #dc3545;
    }
</style>

@endsection