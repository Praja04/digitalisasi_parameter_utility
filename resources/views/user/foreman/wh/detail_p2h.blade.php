@extends('layout')

@section('content')
<style>
    .ok-selected {
        background-color: rgb(0, 179, 68) !important;
        transition: background-color 0.4s ease;
    }

    .nok-selected {
        background-color: rgb(255, 0, 0) !important;
        transition: background-color 0.4s ease;
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12">
                <div class="d-flex flex-column h-100">
                    <div class="row h-100">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">


                                    <div class="row align-items-end">
                                        <div class="col-sm-10">
                                            <div class="p-3">
                                                <h1>P2H Online Form</h1>
                                                <div class="mt-3">
                                                    <p class="fs-16 lh-base">
                                                        Periksa Kendaraan Anda!
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="px-3">
                                                <img src="{{asset('/material/assets/images/user-illustarator-2.png')}}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                </div>
            </div> <!-- end col-->
        </div>

        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Detail P2H untuk Unit: {{ $p2h->nomor_unit }} ({{ $p2h->dept }})</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <p class="text-muted">Tanggal: {{ $p2h->tanggal }}</p>

                        <form id="formDetailP2H" class="row g-3">
                            @csrf

                            <div class="col-md-6">
                                <label for="shift" class="form-label">Shift</label>
                                <select name="shift" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="Shift 1">Shift 1</option>
                                    <option value="Shift 2">Shift 2</option>
                                    <option value="Shift 3">Shift 3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="operator_name" class="form-label">Nama Operator</label>
                                <input type="text" name="operator_name" class="form-control" required>
                            </div>

                            @php
                            $checks = [
                            'cek_baterai' => 'Cek Baterai',
                            'cek_fork' => 'Cek Fork',
                            'kondisi_body_kebersihan' => 'Kondisi Body & Kebersihan',
                            'lampu_kiri' => 'Lampu Kiri',
                            'lampu_kanan' => 'Lampu Kanan',
                            'lampu_sorot' => 'Lampu Sorot',
                            'lampu_sign_depan_kanan' => 'Lampu Sign Depan Kanan',
                            'lampu_sign_depan_kiri' => 'Lampu Sign Depan Kiri',
                            'kipas_belakang' => 'Kipas Belakang',
                            'rantai_lift' => 'Rantai Lift',
                            'sistem_hidrolik' => 'Sistem Hidrolik',
                            'kondisi_axle' => 'Kondisi Axle',
                            'sistem_kemudi' => 'Sistem Kemudi',
                            'panel_display' => 'Panel Display',
                            'jam_operasional' => 'Jam Operasional',
                            'air_aki' => 'Air Aki',
                            'klakson' => 'Klakson',
                            'buzzer_mundur' => 'Buzzer Mundur',
                            'kaca_spion' => 'Kaca Spion',
                            'kondisi_ban' => 'Kondisi Ban',
                            'fungsi_rem' => 'Fungsi Rem',
                            ];
                            @endphp

                            @foreach($checks as $field => $label)
                            <div class="col-md-6">
                                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                <select name="{{ $field }}" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="1">OK</option>
                                    <option value="0">Tidak OK</option>
                                </select>
                            </div>
                            @endforeach

                            <div class="col-12">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button class="btn btn-primary" type="submit">Simpan Shift</button>
                            </div>
                        </form>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="tasksList">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Data Pemeriksaan</h5>

                        </div>
                    </div>
                    <!--end card-body-->
                    <div class="card-body">
                        <div class="table-responsive table-card mb-4">
                            <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>Shift</th>
                                        <th>Operator</th>
                                        <th>Persentase</th>
                                        <th>Baterai</th>
                                        <th>Fork</th>
                                        <th>Body & Kebersihan</th>
                                        <th>Lampu Kiri</th>
                                        <th>Lampu Kanan</th>
                                        <th>Lampu Sorot</th>
                                        <th>Sign Kiri</th>
                                        <th>Sign Kanan</th>
                                        <th>Kipas Belakang</th>
                                        <th>Rantai Lift</th>
                                        <th>Hydrolik</th>
                                        <th>Axle</th>
                                        <th>Kemudi</th>
                                        <th>Panel</th>
                                        <th>Jam Operasional</th>
                                        <th>Air Aki</th>
                                        <th>Klakson</th>
                                        <th>Buzzer Mundur</th>
                                        <th>Kaca Spion</th>
                                        <th>Ban</th>
                                        <th>Rem</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($p2h->details as $detail)
                                    <tr>
                                        <td>{{ $detail->shift }}</td>
                                        <td>{{ $detail->operator_name }}</td>
                                        <td>
                                            @php
                                            $percent = $detail->persentase_kelayakan;
                                            $color = $percent >= 80 ? 'bg-success text-white' :
                                            ($percent >= 60 ? 'bg-warning text-dark' : 'bg-danger text-white');
                                            @endphp
                                            <span class="px-2 py-1 rounded {{ $color }}">{{ $percent }}%</span>
                                        </td>

                                        {{-- Gunakan loop untuk semua field boolean --}}
                                        @php
                                        $fields = [
                                        'cek_baterai',
                                        'cek_fork',
                                        'kondisi_body_kebersihan',
                                        'lampu_kiri',
                                        'lampu_kanan',
                                        'lampu_sorot',
                                        'lampu_sign_depan_kiri',
                                        'lampu_sign_depan_kanan',
                                        'kipas_belakang',
                                        'rantai_lift',
                                        'sistem_hidrolik',
                                        'kondisi_axle',
                                        'sistem_kemudi',
                                        'panel_display',
                                        'jam_operasional',
                                        'air_aki',
                                        'klakson',
                                        'buzzer_mundur',
                                        'kaca_spion',
                                        'kondisi_ban',
                                        'fungsi_rem',
                                        ];
                                        @endphp

                                        @foreach($fields as $field)
                                        <td>
                                            <span class="{{ $detail->$field ? 'text-success' : 'text-danger' }}">
                                                {{ $detail->$field ? 'OK' : 'NOK' }}
                                            </span>
                                        </td>
                                        @endforeach

                                        <td>{{ $detail->catatan }}</td>


                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#formDetailP2H select').change(function() {
            const val = $(this).val();

            $(this).removeClass('ok-selected nok-selected');

            if (val === '1') {
                $(this).addClass('ok-selected');
            } else if (val === '0') {
                $(this).addClass('nok-selected');
            }
        });

        $('#formDetailP2H').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let actionUrl = "{{ route('p2h.detail.store', $p2h->id) }}";

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg
                    });
                }
            });
        });
    });
</script>
@endsection