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
                                        @foreach(['MDP','SDP1','SDP2','SDP3','SDP4','SDP5','SDP6','SDP7','SDP8','SDP9','SDP10','SDP11','SDP12','SDP13','SDP14'] as $panel)
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
                                <div class="mb-3">
                                    <label for="cos" class="form-label">Cos</label>
                                    <input type="number" name="cos" class="form-control" step="0.01">
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
                                    <label for="pemakaian_liter_awal" class="form-label">Awal (m³)</label>
                                    <input type="number" name="pemakaian_liter_awal" class="form-control" step="any" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pemakaian_liter_akhir" class="form-label">Akhir (m³)</label>
                                    <input type="number" name="pemakaian_liter_akhir" class="form-control" step="any" required>
                                </div>
                                <div class="mb-3">
                                    <label for="area" class="form-label">Pilih Area</label>
                                    <select id="air_area" name="jenis_pemakaian" class="form-select" required>


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
    function setTanggalChemical() {
        const now = new Date();
        let tanggal = new Date(now); // default: hari ini

        const jam = now.getHours();
        const menit = now.getMinutes();
        const detik = now.getSeconds();
        const selectedShift = $('#shift').val();

        // Hitung total detik dari jam 00:00:00
        const totalDetik = jam * 3600 + menit * 60 + detik;

        // 06:00:00 = 21600 detik
        const batasAwalShift1 = 6 * 3600;

        // Kalau shift 3 dan waktu sekarang masih di bawah jam 06:00:00, anggap masih hari sebelumnya
        if (selectedShift === 'shift 3' && totalDetik < batasAwalShift1) {
            tanggal.setDate(tanggal.getDate() - 1);
        }

        const tanggalFormatted = tanggal.toISOString().split('T')[0];
        $('#tanggal_chemical').val(tanggalFormatted);
    }
    // Trigger saat shift dipilih
    $('#shift').on('change', function() {
        setTanggalChemical();
    });
    $(document).ready(function() {

        function toggleCosInput() {
            if ($('#panel_type').val() === 'MDP') {
                $('label[for="cos"]').parent().show();
                $('input[name="cos"]').val('').prop('readonly', false);
            } else {
                $('label[for="cos"]').parent().hide();
                let cos_value = null;
                $('input[name="cos"]').val(cos_value).prop('readonly', true);
            }
        }

        // Inisialisasi saat halaman dimuat
        toggleCosInput();

        // Jalankan saat pilihan berubah
        $('#panel_type').on('change', toggleCosInput);

        $.get("{{url('eng/chemical-area')}}", function(data) {
            const $select = $('#chemical-area');
            $select.empty(); // Kosongkan option terlebih dahulu

            // Tambahkan option default
            $select.append($('<option>', {
                value: '',
                text: 'Pilih Area',
                disabled: true,
                selected: true
            }));

            // Tambahkan option untuk setiap area
            data.forEach(function(area) {
                const $option = $('<option>', {
                    value: area.nama_area,
                    text: area.nama_area,
                    'data-id': area.id,
                    'data-nama': area.nama_area
                });
                $select.append($option);
            });
        });

        $.get("{{url('eng/air-area')}}", function(data) {
            const $select = $('#air_area');
            $select.empty(); // Kosongkan option terlebih dahulu

            // Tambahkan option default
            $select.append($('<option>', {
                value: '',
                text: 'Pilih Area',
                disabled: true,
                selected: true
            }));

            // Tambahkan option untuk setiap area
            data.forEach(function(area) {
                const $option = $('<option>', {
                    value: area.nama_area,
                    text: area.nama_area,
                });
                $select.append($option);
            });
        });


        const today = new Date().toISOString().split('T')[0];
        $('#waktu_listrik').val(today);
        $('#tanggal_air').val(today);



        setTanggalChemical();

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
            const selectedOption = $(this).find('option:selected');
            const areaId = selectedOption.data('id');
            const areaName = selectedOption.data('nama')?.toLowerCase();

            if (areaId) {
                $.ajax({
                    url: "{{ url('eng/chemical-types') }}/" + areaId,
                    type: 'GET',
                    success: function(data) {
                        console.log(areaName);
                        $('#chemical-input-container').empty();

                        if (data.length === 0) {
                            $('#chemical-input-container').html('<p class="text-danger">Tidak ada chemical untuk area ini.</p>');
                            return;
                        }

                        data.forEach((chemical) => {
                            const satuan = chemical.satuan || 'Kg';
                            const isDefoamer = chemical.nama_chemical.toLowerCase().includes('defoamer');
                            const requiredAttr = isDefoamer ? '' : 'required';

                            let runningHourInput = '';

                            // ⏱️ Tambahkan input Running Hour jika area WWTP
                            if (areaName == 'wwtp') {
                                runningHourInput = `
                            <div class="mb-1">
                                <label class="form-label">Running Hour (jam)</label>
                                <input type="number" name="running_hour[]" class="form-control" step="0.1" required>
                            </div>
                        `;
                            } else {
                                runningHourInput = `<input type="hidden" name="running_hour[]" value="">`;
                            }

                            const inputGroup = `
                        <div class="mb-3 border rounded p-3">
                            <input type="hidden" name="chemical_ids[]" value="${chemical.id}">
                            <div class="mb-1">
                                <label class="form-label">${chemical.nama_chemical}</label>
                                <input type="hidden" name="jenis_pemakaian[]" class="form-control" value="${chemical.nama_chemical}" readonly>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Jumlah Pemakaian (${satuan})</label>
                                <input type="number" name="jumlah_pemakaian[]" class="form-control" step="0.01" ${requiredAttr}>
                            </div>
                            ${runningHourInput}
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
                url: "{{url('/eng/data/air/store')}}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                    });

                    setInterval(() => {
                        location.reload(); // Reload halaman untuk update data
                    }, 3000);
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
                url: "{{url('/eng/data/listrik/store')}}",
                method: 'POST',
                data: formData,
                success: function(res) {
                    Swal.fire('Berhasil', res.message, 'success');
                    setInterval(() => {
                        location.reload(); // Reload halaman untuk update data
                    }, 3000);
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