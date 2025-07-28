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
                        <img src="{{ asset('assets/images/pallet_mover.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
                        <p class="text-muted">Klik untuk pemeriksaan</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-4" id="form-forklift" style="display: none;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5 id="form-title-forklift">Form Pemeriksaan - Forklift</h5>
                    </div>
                    <div class="card-body">
                        <form id="formP2HForklift" data-url="{{ url('wh/p2h/store') }}">
                            @csrf
                            <input type="hidden" name="jenis_p2h" value="Forklift" />

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Nomor Unit</label>
                                    @if($forklifts->count() > 1)
                                    <select name="nomor_unit" id="forkliftSelect" class="form-select">
                                        @foreach($forklifts as $unit)
                                        <option value="{{ $unit['nomor_unit'] }}" data-departemen="{{ $unit['departemen'] }}">
                                            {{ $unit['nomor_unit'] }} ({{ $unit['is_primary'] ? 'Primary' : 'Backup' }})
                                        </option>
                                        @endforeach
                                    </select>

                                    @elseif($forklifts->count() === 1)
                                    <input type="text" name="nomor_unit" class="form-control" value="{{ $forklifts[0]['nomor_unit'] }}" readonly>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Departemen</label>
                                    <input type="text" class="form-control" id="departemenInput" name="dept" value="{{ ucfirst($departemen) }}" readonly>
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
                                    <label>Hours Meter</label>
                                    <input type="text" class="form-control" name="jam_operasional" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Operator</label>
                                    <input type="text" class="form-control" value="{{ Session::get('username') }}" name="operator_name" readonly>
                                </div>
                                <!-- <div class="col-md-12 mb-3">
                                    <label>Catatan</label>
                                    <textarea class="form-control" name="catatan"></textarea>
                                </div> -->
                            </div>

                            <hr>
                            <h5>Pemeriksaan Item</h5>
                            <div class="row">
                                @php
                                $checks = [
                                'cek_baterai' => ['label' => 'Check Baterai', 'desc' => 'Tidak kurang dari 30%'],
                                'cek_fork' => ['label' => 'Pengecekan Fork', 'desc' => 'Mengecek kebengkokan/patah'],
                                'kondisi_body_kebersihan' => ['label' => 'Check Body Unit dan Kebersihan', 'desc' => 'Tidak lecet, penyok dan kotor'],
                                'lampu_kiri' => ['label' => 'Check Kombinasi Lampu Kiri', 'desc' => 'Menyala normal dan tidak pecah'],
                                'lampu_kanan' => ['label' => 'Check Kombinasi Lampu Kanan', 'desc' => 'Menyala normal dan tidak pecah'],
                                'lampu_sorot' => ['label' => 'Check Lampu Sorot / Headlamp', 'desc' => 'Menyala normal dan tidak pecah'],
                                'lampu_sign_depan_kanan' => ['label' => 'Check Lampu Sign Depan Kanan', 'desc' => 'Menyala normal dan tidak pecah'],
                                'lampu_sign_depan_kiri' => ['label' => 'Check Lampu Sign Depan Kiri', 'desc' => 'Menyala normal dan tidak pecah'],
                                'kipas_belakang' => ['label' => 'Pengecekan Fan Belakang', 'desc' => 'Kondisi fan berfungsi dengan baik'],

                                'rantai_lift' => ['label' => 'Lift Chains', 'desc' => 'Kekencangan kanan dan kiri sama serta terlubrikasi'],
                                'sistem_hidrolik' => ['label' => 'Hydraulic System + Selang', 'desc' => 'Berfungsi dengan baik dan terlubrikasi'],
                                'kondisi_axle' => ['label' => 'Check Kondisi Axle', 'desc' => 'Kondisi ban normal, tidak ada noise saat dioperasikan'],
                                'sistem_kemudi' => ['label' => 'Sistem Kemudi', 'desc' => 'Tidak berat dan lancar'],
                                'panel_display' => ['label' => 'Check Panel Display', 'desc' => 'Berfungsi normal, tidak pecah, tidak ada alarm'],

                                'air_aki' => ['label' => 'Check Isi Air Aki', 'desc' => 'Berada di level standar'],

                                'klakson' => ['label' => 'Check Klakson / Horn', 'desc' => 'Bunyi ketika tombol ditekan'],
                                'buzzer_mundur' => ['label' => 'Check Buzzer Back', 'desc' => 'Berbunyi normal saat maju/mundur'],
                                'kaca_spion' => ['label' => 'Check Kaca Spion', 'desc' => 'Terpasang dan tidak pecah'],
                                'kondisi_ban' => ['label' => 'Check Ban', 'desc' => 'Masih bagus dan layak pakai'],
                                'fungsi_rem' => ['label' => 'Check Fungsi Rem', 'desc' => 'Pengereman berfungsi dengan baik'],
                                ];
                                @endphp

                                @foreach ($checks as $key => $item)
                                <div class="col-md-6 mb-3">
                                    <label>{{ $item['label'] }}</label>
                                    <small class="text-muted d-block">{{ $item['desc'] }}</small>
                                    <div class="d-flex gap-2">
                                        <label class="me-2 radio-label">
                                            <input type="radio" name="{{ $key }}" value="1" required> OK
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="{{ $key }}" value="0"> Tidak OK
                                        </label>
                                    </div>
                                    <input type="text" class="form-control mt-2 item-note" name="note_{{ $key }}" placeholder="Catatan jika Tidak OK (max 100 karakter)" maxlength="100" style="display:none;">
                                </div>
                                @endforeach
                            </div>
                            <textarea name="catatan" id="catatan-hidden" hidden></textarea>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" id="cancelFormForklift">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" id="form-pallet" style="display: none;">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5 id="form-title">Form Pemeriksaan</h5>
                    </div>
                    <div class="card-body">

                        <form id="formP2HPalletMover" data-url="{{ url('wh/p2h/store/pallet') }}">
                            @csrf
                            <input type="hidden" name="jenis_p2h" value="Pallet Mover" />

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Nomor Unit</label>
                                    @if($pallets->count() > 1)
                                    <select name="nomor_unit" id="palletselect" class="form-select">
                                        @foreach($pallets as $unit)
                                        <option value="{{ $unit['nomor_unit'] }}" data-departemen="{{ $unit['departemenpallet'] }}">
                                            {{ $unit['nomor_unit'] }} ({{ $unit['is_primary'] ? 'Primary' : 'Backup' }})
                                        </option>
                                        @endforeach
                                    </select>

                                    @elseif($pallets->count() === 1)
                                    <input type="text" name="nomor_unit" class="form-control" value="{{ $pallets[0]['nomor_unit'] }}" readonly>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Departemen</label>
                                    <input type="text" class="form-control" id="departemenInputpallet" name="dept" value="{{ ucfirst($departemenpallet) }}" readonly>
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
                                    <label>Nama Operator</label>
                                    <input type="text" class="form-control" name="operator_name" value="{{ Session::get('username') }}" readonly>
                                </div>

                            </div>

                            <hr>
                            <h5>Pemeriksaan Item</h5>
                            <div class="row">
                                @php
                                $checks = [
                                'check_air_accu' => ['label' => 'Air Accu', 'desc' => 'Level air accu harus sesuai standar minimum'],
                                'check_battery' => ['label' => 'Battery', 'desc' => 'Baterai terisi baik, tidak kembung atau bocor'],
                                'check_body_unit' => ['label' => 'Body Unit', 'desc' => 'Tidak ada kerusakan fisik atau penyok'],
                                'check_klakson' => ['label' => 'Klakson', 'desc' => 'Berbunyi ketika ditekan'],
                                'check_roda' => ['label' => 'Roda', 'desc' => 'Tekanan cukup dan tidak aus berlebihan'],
                                'check_sistem_kemudi' => ['label' => 'Sistem Kemudi', 'desc' => 'Tidak berat dan tidak ada bunyi abnormal'],
                                'check_kebersihan_unit' => ['label' => 'Kebersihan Unit', 'desc' => 'Unit dalam keadaan bersih dan rapi'],
                                'check_kunci_pm' => ['label' => 'Kunci PM', 'desc' => 'Kunci dapat digunakan dan tidak patah'],
                                'check_hydraulic' => ['label' => 'Hydraulic', 'desc' => ' fungsi angkat normal'],
                                ];
                                @endphp

                                @foreach ($checks as $key => $item)
                                <div class="col-md-6 mb-3">
                                    <label>{{ $item['label'] }}</label>
                                    <small class="text-muted d-block">{{ $item['desc'] }}</small>
                                    <div class="d-flex gap-2">
                                        <label class="me-2 radio-label">
                                            <input type="radio" name="{{ $key }}" value="1" required> OK
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="{{ $key }}" value="0"> Tidak OK
                                        </label>
                                    </div>
                                    <input type="text" class="form-control mt-2 item-note" name="note_{{ $key }}" placeholder="Catatan jika Tidak OK (max 100 karakter)" maxlength="100" style="display:none;">
                                </div>
                                @endforeach
                            </div>
                            <textarea name="catatan" id="catatan-hidden" hidden></textarea>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" id="cancelFormPallet">Batal</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        const $select = $('#forkliftSelect');
        const $selectpallet = $('#palletselect');
        const $departemenInput = $('#departemenInput');
        const $departemenInputpallet = $('#departemenInputpallet');

        function updateDepartemen() {
            const departemen = $select.find(':selected').data('departemen');
            console.log('Selected Departemen:', departemen);
            $departemenInput.val(departemen);
        }

        function updateDepartemenpallet() {
            const departemenpallet = $selectpallet.find(':selected').data('departemen');
            console.log('Selected Departemen:', departemenpallet);
            $departemenInputpallet.val(departemenpallet);
        }

        $select.on('change', updateDepartemen);
        $selectpallet.on('change', updateDepartemenpallet);
        updateDepartemen(); // Set saat load awal
        updateDepartemenpallet(); // Set saat load awal

        $('.card-unit').on('click', function() {
            let unit = $(this).data('unit');

            // Sembunyikan semua form dulu
            $('#form-forklift, #form-pallet').slideUp(300);

            // Setelah disembunyikan, reset dan tampilkan form yang sesuai
            setTimeout(() => {
                if (unit === 'Forklift') {
                    $('#form-forklift input[name="jenis_p2h"]').val('Forklift');
                    $('#form-title-forklift').text(`Form Pemeriksaan - ${unit}`);
                    $('#formP2HForklift')[0].reset();
                    $('#form-forklift').slideDown();
                } else if (unit === 'Pallet Mover') {
                    $('#form-pallet input[name="jenis_p2h"]').val('Pallet Mover');
                    $('#form-title-pallet').text(`Form Pemeriksaan - ${unit}`);
                    $('#formP2HPalletMover')[0].reset();
                    $('#form-pallet').slideDown();
                }
            }, 400);
        });

        // Tombol batal Forklift
        $('#cancelFormForklift').on('click', function() {
            $('#formP2HForklift')[0].reset();
            $('#form-forklift').slideUp();
        });

        // Tombol batal Pallet Mover
        $('#cancelFormPallet').on('click', function() {
            $('#formP2HPalletMover')[0].reset();
            $('#form-pallet').slideUp();
        });

        // Fungsi validasi untuk memastikan catatan diisi jika status "Tidak OK"
        function validateP2HForm(form) {
            let isValid = true;
            let errorMessages = [];

            // Reset error styling
            $(form).find('.item-note').removeClass('is-invalid shake');
            $(form).find('.invalid-feedback').remove();
            $(form).find('.mb-3').removeClass('has-error');

            // Cek setiap item yang bernilai "Tidak OK"
            $(form).find('input[type=radio][value="0"]:checked').each(function() {
                const name = $(this).attr('name');
                const noteField = $(form).find(`input[name="note_${name}"]`);
                const itemLabel = $(this).closest('.mb-3').find('label').first().text().trim();
                const parentGroup = $(this).closest('.mb-3');

                if (noteField.length && noteField.is(':visible')) {
                    const noteValue = noteField.val().trim();

                    if (!noteValue) {
                        isValid = false;
                        errorMessages.push(`Catatan untuk "${itemLabel}" wajib diisi karena status "Tidak OK"`);

                        // Tambahkan styling error
                        noteField.addClass('is-invalid shake');
                        parentGroup.addClass('has-error');
                        noteField.after('<div class="invalid-feedback">Catatan wajib diisi untuk status "Tidak OK" <span class="required-indicator">*</span></div>');

                        // Focus ke field pertama yang error
                        if (errorMessages.length === 1) {
                            setTimeout(() => {
                                noteField.focus();
                            }, 100);
                        }

                        // Hapus animasi shake setelah selesai
                        setTimeout(() => {
                            noteField.removeClass('shake');
                        }, 300);
                    }
                }
            });

            // Tampilkan pesan error jika ada
            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    html: `<div style="text-align: left;">${errorMessages.join('<br>• ')}</div>`,
                    confirmButtonText: 'OK',
                    customClass: {
                        htmlContainer: 'text-start'
                    }
                });

                // Scroll ke item error pertama
                const firstError = $(form).find('.item-note.is-invalid').first();
                if (firstError.length) {
                    firstError[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }

            return isValid;
        }

        // Handler submit untuk forklift dengan validasi
        $('#formP2HForklift').submit(function(e) {
            e.preventDefault();

            // Validasi sebelum submit
            if (!validateP2HForm(this)) {
                return false;
            }

            submitP2HForm(this);
        });

        // Handler submit untuk pallet mover dengan validasi
        $('#formP2HPalletMover').submit(function(e) {
            e.preventDefault();

            // Validasi sebelum submit
            if (!validateP2HForm(this)) {
                return false;
            }

            submitP2HForm(this);
        });

        // Reusable AJAX submit logic
        function submitP2HForm(form) {
            const actionUrl = $(form).data("url");
            const formId = $(form).attr("id");
            let notes = [];

            $(`#${formId} .item-note:visible`).each(function() {
                let label = $(this).closest('.mb-3').find('label').first().text().trim();
                label = label.replace(/^check\s+/i, '').trim();

                const text = $(this).val().trim();
                if (text) notes.push(`${label.toLowerCase()} ${text}`);
            });

            const gabungan = notes.join(', ');
            $(`#${formId} [name="catatan"]`).val(gabungan);

            $.ajax({
                url: actionUrl,
                method: "POST",
                data: $(form).serialize(),
                success: function(response) {
                    const persen = response.persentase ?? '-';
                    const status = response.status_unit ?? '-';

                    const kriteriaHTML = `
                <hr>
                <div style="text-align:left; font-size:14px; line-height:1.5; margin-top:10px;">
                    <strong>Kriteria Kelayakan:</strong><br>
                    ✅ <b>90-100%</b>: Unit MHE <i>sangat layak</i> untuk dioperasikan<br>
                    ✅ <b>80-89%</b>: Layak dengan <i>perbaikan minor</i><br>
                    ⚠️ <b>70-79%</b>: Perlu <i>perbaikan signifikan</i> sebelum operasi<br>
                    ❌ <b><70%</b>: Tidak layak untuk dioperasikan
                </div>
            `;

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: `
                    <strong>Data P2H disimpan!</strong><br><br>
                    Kondisi unit: <b>${status}</b><br>
                    Persentase kelayakan: <b>${persen}%</b>
                    ${kriteriaHTML}
                `,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                        form.reset();
                        $(form).closest('.row').slideUp();
                        location.reload();
                    });
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
        }

        // Highlight radio selection (untuk semua form)
        $('body').on('change', 'input[type=radio]', function() {
            const name = $(this).attr('name');
            const isOk = $(this).val() === '1';
            const group = $(`input[name="${name}"]`);

            group.each(function() {
                $(this).closest('.radio-label').removeClass('ok-selected nok-selected');
            });

            $(this)
                .closest('.radio-label')
                .addClass(isOk ? 'ok-selected' : 'nok-selected');
        });

        // Real-time validation saat user mengetik di catatan
        $('body').on('input', '.item-note', function() {
            const $this = $(this);

            // Hapus error styling jika user mulai mengetik
            if ($this.hasClass('is-invalid') && $this.val().trim()) {
                $this.removeClass('is-invalid');
                $this.siblings('.invalid-feedback').remove();
                $this.closest('.mb-3').removeClass('has-error');
            }

            const formSelector = '#' + $(this).closest('form').attr('id');
            updateGlobalCatatan(formSelector);
        });
    });

    // Inisialisasi note form global
    const $noteWrapper = $('<div class="col-md-12 mb-3" id="note-container" style="display:none;">')
        .append('<label>Catatan Pemeriksaan</label>')
        .append('<textarea class="form-control" name="catatan" maxlength="500" rows="3" readonly></textarea>');

    // Inject ke setiap form P2H
    $('#formP2HForklift .card-body').append($noteWrapper.clone());
    $('#formP2HPalletMover .card-body').append($noteWrapper.clone());

    function highlightNextCheck(currentInput) {
        const currentGroup = $(currentInput).closest(".mb-3");
        const container = currentGroup.closest(".row");
        const allGroups = container.find(".mb-3:has(input[type=radio])");
        const currentIndex = allGroups.index(currentGroup);

        if (currentIndex !== -1 && currentIndex < allGroups.length - 1) {
            const nextGroup = allGroups.eq(currentIndex + 1);
            allGroups.removeClass("check-highlight");
            nextGroup.addClass("check-highlight");
            nextGroup.find("input[type=radio]").first().focus();
        } else {
            allGroups.removeClass("check-highlight");
        }
    }

    function updateGlobalCatatan(formSelector) {
        const notes = [];
        $(`${formSelector} .item-note:visible`).each(function() {
            const label = $(this).closest('.mb-3').find('label').first().text().trim();
            const text = $(this).val().trim();
            if (text) {
                notes.push(`${label.toLowerCase()} ${text}`);
            }
        });
        const fullNote = notes.join(', ');
        $(`${formSelector} #note-container`).show().find('textarea').val(fullNote);
    }

    $('body').on('change', 'input[type=radio]', function() {
        highlightNextCheck(this);
        const name = $(this).attr('name');
        const isOk = $(this).val() === '1';
        const group = $(`input[name="${name}"]`);
        const formSelector = '#' + $(this).closest('form').attr('id');

        group.each(function() {
            $(this).closest('.radio-label').removeClass('ok-selected nok-selected');
        });

        $(this).closest('.radio-label').addClass(isOk ? 'ok-selected' : 'nok-selected');

        // Tampilkan atau sembunyikan input catatan per item
        const noteField = $(this).closest('.mb-3').find('.item-note');
        if (!isOk) {
            noteField.show().focus();
            // Tambahkan placeholder yang lebih deskriptif
            noteField.attr('placeholder', 'Wajib diisi! Jelaskan kondisi/masalah yang ditemukan (max 100 karakter)');
        } else {
            noteField.hide().val('');
            // Reset error state jika ada
            noteField.removeClass('is-invalid');
            noteField.siblings('.invalid-feedback').remove();
            $(this).closest('.mb-3').removeClass('has-error');
        }

        updateGlobalCatatan(formSelector);
    });

    // Monitor pengetikan di input catatan individual
    $('body').on('input', '.item-note', function() {
        const formSelector = '#' + $(this).closest('form').attr('id');
        updateGlobalCatatan(formSelector);
    });

    // Opsional: kasih highlight pertama saat form muncul
    function highlightFirstItem(formId) {
        const first = $(`${formId} .mb-3:has(input[type=radio])`).first();
        first.addClass("check-highlight");
    }

    // Contoh panggil saat form dibuka
    highlightFirstItem('#formP2HForklift');
    highlightFirstItem('#formP2HPalletMover');
</script>
<style>
    .check-highlight {
        border: 2px dashed #0d6efd;
        padding: 10px;
        border-radius: 8px;
        background-color: #eaf4ff;
    }

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

    /* Error styling untuk input catatan */
    .item-note.is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        background-color: #fff5f5;
    }

    .invalid-feedback {
        display: block !important;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
        font-weight: 500;
    }

    /* Highlight item yang memiliki error */
    .mb-3.has-error {
        border: 2px solid #dc3545;
        padding: 15px;
        border-radius: 8px;
        background-color: #fff5f5;
        margin-bottom: 1rem;
    }

    /* Animasi shake untuk field error */
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-3px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(3px);
        }
    }

    .item-note.shake {
        animation: shake 0.5s ease-in-out;
    }

    /* Styling untuk required indicator */
    .required-indicator {
        color: #dc3545;
        font-weight: bold;
        margin-left: 3px;
    }

    /* Hover effect untuk catatan yang wajib diisi */
    .item-note:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        background-color: #fff;
    }

    /* Styling khusus untuk catatan NOK */
    .item-note[style*="display: block"],
    .item-note[style*="display: inline-block"],
    .item-note:not([style*="display: none"]) {
        border-left: 4px solid #ffc107;
        padding-left: 10px;
    }

    /* Tooltip untuk catatan wajib */
    .item-note::placeholder {
        color: #6c757d;
        font-style: italic;
    }

    /* Styling untuk form yang sedang dalam proses validasi */
    .validating {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Indikator loading saat submit */
    .btn[type="submit"]:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Styling untuk catatan yang sudah diisi dengan benar */
    .item-note.valid {
        border-color: #198754;
        background-color: #f8fff9;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .mb-3.has-error {
            padding: 10px;
            margin-bottom: 0.75rem;
        }

        .invalid-feedback {
            font-size: 0.8em;
        }
    }
</style>

@endsection