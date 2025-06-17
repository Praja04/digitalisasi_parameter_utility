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
                                    <h1>Utility Form</h1>
                                    <p class="fs-16 lh-base">Periksa Utility Untuk Diri Kita Sendiri!</p>
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
            <div class="col-md-4">
                <div class="card clickable card-unit listrik-card" data-unit="Listrik">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pemakaian Listik</h4>
                        <img src="{{ asset('assets/images/listrik.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                        <p class="text-muted">Klik untuk pemeriksaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable card-unit air-card" data-unit="Air">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pemakaian Air</h4>
                        <img src="{{ asset('assets/images/air.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                        <p class="text-muted">Klik untuk pemeriksaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable card-unit chemical-card" data-unit="Chemical">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pemakaian Chemical</h4>
                        <img src="{{ asset('assets/images/chemical.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
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
                        <div id="form-listrik" style="display: none;">
                            <form id="form-pemakaian-listrik">
                                @csrf
                                <div class="mb-3">
                                    <label for="waktu" class="form-label">Waktu</label>
                                    <input type="date" name="waktu" class="form-control" id="waktu_listrik" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="panel_type" class="form-label">Panel Type</label>
                                    <select id="panel_type" name="panel_type" class="form-select" required>
                                        <option value="">Pilih Panel</option>
                                        @foreach(['MDP','COS','SDP1','SDP2','SDP3','SDP4','SDP5','SDP6','SDP7','SDP8','SDP9','SDP10','SDP11','SDP12','SDP13','SDP14'] as $panel)
                                        <option value="{{ $panel }}">{{ $panel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="volt" class="form-label">Volt</label>
                                    <input type="number" name="volt" class="form-control" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="a" class="form-label">Ampere</label>
                                    <input type="number" name="a" class="form-control" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="kw" class="form-label">KW</label>
                                    <input type="number" name="kw" class="form-control" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="mwh" class="form-label">MWh</label>
                                    <input type="number" name="mwh" class="form-control" step="0.01">
                                </div>
                                <button type="submit" class="btn btn-danger">Simpan Listrik</button>
                            </form>
                        </div>

                        <div id="form-air" style="display: none;">
                            <form id="form-pemakaian-air">
                                @csrf
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal_air" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="pemakaian_liter_awal" class="form-label">Volume Awal (Liter)</label>
                                    <input type="number" name="pemakaian_liter_awal" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pemakaian_liter_akhir" class="form-label">Volume Akhir (Liter)</label>
                                    <input type="number" name="pemakaian_liter_akhir" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pemakaian (area)</label>
                                    <select name="jenis_pemakaian" class="form-control" required>
                                        <option value="">-- Pilih Jenis Pemakaian --</option>
                                        <option value="Outlet Storage RO">Outlet Storage RO</option>
                                        <option value="Outlet Storage RO Reject">Outlet Storage RO Reject</option>
                                        <option value="Outlet Fresh Water 1">Outlet Fresh Water 1</option>
                                        <option value="Outlet Fresh Water 2">Outlet Fresh Water 2</option>
                                        <option value="WWTP - Boiler - Fasum3">WWTP - Boiler - Fasum3</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan</label>
                                    <textarea name="notes" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Air</button>
                            </form>
                        </div>

                        <div id="form-chemical" style="display: none;">
                            <form id="chemical-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal_chemical" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="area" class="form-label">Pilih Shift</label>
                                    <select id="shift" name="shift" class="form-select" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="shift 1">Shift 1</option>
                                        <option value="shift 2">Shift 2</option>
                                        <option value="shift 3">Shift 3</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="area" class="form-label">Pilih Area</label>
                                    <select id="chemical-area" name="chemical_area" class="form-select" required>
                                        <option value="">Pilih Area</option>

                                    </select>
                                </div>
                                <div id="chemical-input-container">
                                    {{-- Akan diisi dinamis berdasarkan API --}}
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary">Simpan Chemical</button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        $.get("{{url('eng/chemical-area')}}", function(data) {
            data.forEach(function(area) {
                $('#chemical-area').append(
                    $('<option>', {
                        value: area.nama_area, // value = string nama_area
                        text: area.nama_area, // label = string nama_area
                        'data-id': area.id
                    })
                );
            });
        });

        const today = new Date().toISOString().split('T')[0];
        $('#waktu_listrik').val(today);
        $('#tanggal_air').val(today);
        $('#tanggal_chemical').val(today);

        $('.card-unit').click(function() {
            const unit = $(this).data('unit');

            // Slide up dulu
            $('#form-container').slideUp(300, function() {
                // Setelah selesai slide up, sembunyikan semua form
                $('#form-listrik, #form-air, #form-chemical').hide();

                // Atur judul form
                $('#form-title').text('Form Pemeriksaan ' + unit);

                // Tampilkan form sesuai unit yang diklik
                if (unit === 'Listrik') {
                    $('#form-listrik').show();
                } else if (unit === 'Air') {
                    $('#form-air').show();
                } else if (unit === 'Chemical') {
                    $('#form-chemical').show();
                }

                // Setelah atur semua, slide down container
                $('#form-container').slideDown(400);
            });
        });


        // Event perubahan dropdown area chemical
        $('#chemical-area').change(function() {
            const areaId = $(this).find('option:selected').data('id');
            if (areaId) {
                $.ajax({
                    url: "{{ url('eng/chemical-types') }}/" + areaId,
                    type: 'GET',
                    success: function(data) {
                        // Kosongkan container input
                        $('#chemical-input-container').empty();

                        if (data.length === 0) {
                            $('#chemical-input-container').html('<p class="text-danger">Tidak ada chemical untuk area ini.</p>');
                            return;
                        }

                        // Loop data chemical dan generate input
                        data.forEach((chemical, index) => {
                            const inputGroup = `
                                    <div class="mb-3 border rounded p-3">
                                        <input type="hidden" name="chemical_ids[]" value="${chemical.id}">
                                        <div class="mb-1">
                                            <label class="form-label">${chemical.nama_chemical}</label>
                                            <input type="hidden" name="jenis_pemakaian[]" class="form-control" value="${chemical.nama_chemical}" readonly>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Jumlah Pemakaian (Kg)</label>
                                            <input type="number" name="jumlah_pemakaian[]" class="form-control" step="0.01" required>
                                        </div>
                                    </div>
                                 `;
                            $('#chemical-input-container').append(inputGroup);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data chemical');
                    }
                });
            } else {
                $('#chemical-input-container').empty();
            }
        });


        $('#chemical-form').submit(function(e) {
            e.preventDefault(); // Stop form default submit

            let form = $(this);
            let formData = form.serialize(); // Ambil semua input

            $.ajax({
                url: "{{ url('eng/store/chemical') }}", // Ganti dengan route POST kamu
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                beforeSend: function() {
                    // Bisa tampilkan loading spinner di tombol
                    $('button[type="submit"]').prop('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Data chemical berhasil disimpan.'
                    });
                    form.trigger("reset");
                    $('#chemical-input-container').empty();
                    setInterval(() => {
                        location.reload(); // Reload halaman untuk update data
                    }, 3000);

                },
                error: function(xhr) {
                    let err = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err
                    });
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false).text('Simpan Chemical');
                }
            });
        });

        $('#form-pemakaian-air').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/eng/data/air/store',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                    });

                    // Reset form
                    $('#form-pemakaian-air')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorList = '';

                        $.each(errors, function(key, value) {
                            errorList += `<li>${value[0]}</li>`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: `<ul style="text-align:left">${errorList}</ul>`,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan data.',
                        });
                    }
                }
            });
        });

        $('#form-pemakaian-listrik').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/eng/data/listrik/store',
                method: 'POST',
                data: formData,
                success: function(res) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#form-pemakaian-listrik')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = '<ul>';
                        $.each(errors, function(key, value) {
                            message += '<li>' + value[0] + '</li>';
                        });
                        message += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: message
                        });
                    } else {
                        Swal.fire('Error', 'Gagal menyimpan data listrik.', 'error');
                    }
                }
            });
        });

        $('#cancelForm').on('click', function() {

            $('#form-container').slideUp();
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

    .listrik-card:hover {
        background-color: #ffe5e5;
        border: 1px solid #dc3545;
    }

    .air-card:hover {
        background-color: #e0f0ff;
        border: 1px solid #0d6efd;
    }

    .chemical-card:hover {
        background-color: rgb(137, 137, 137);
        border: 1px solid #000;
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