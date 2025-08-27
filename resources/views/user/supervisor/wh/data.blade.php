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
                                    <h1>Data P2H Online</h1>
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

        <!-- Tabel Data P2H -->
        <div id="table-container" style="display: none;">
            <!-- Filter Controls -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Nomor Unit / Jenis P2H">
                </div>
                <div class="col-md-4">
                    <input type="date" id="filterDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary w-100" id="resetFilter">Reset</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 id="table-title" class="mb-3">Data P2H</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="p2hTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nomor Unit</th>
                                    <th>Jenis P2H</th>
                                    <th>Shift Tersedia</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="p2hTableBody">
                                <!-- Data akan dimasukkan di sini oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Shift -->
        <div class="modal fade" id="modalDetailP2H" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="detailModalLabel">Detail Pemeriksaan Shift</h5><br>


                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" id="modalDetailBody">
                        <!-- Konten detail akan diisi via JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="downloadPDF">Download PDF</button>
                    </div>
                </div>
            </div>


        </div>

        <!-- Modal Edit Shift -->
        <div class="modal fade" id="modalEditShift" tabindex="-1" aria-labelledby="editShiftLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editShiftForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pemeriksaan Shift</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="editShiftBody">
                            <!-- Isi via JS -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        let currentData = [];

        // Saat klik kartu unit (Forklift atau Pallet Mover)
        $('.card-unit').on('click', function() {
            let unit = $(this).data('unit');

            // Ambil data dari controller via AJAX
            $.ajax({
                url: "{{ url('wh/p2h/data') }}",
                method: "GET",
                data: {
                    jenis_p2h: unit
                },
                success: function(response) {
                    currentData = response; // Simpan data untuk tombol Detail
                    $('#p2hTableBody').empty();
                    $('#table-title').text(`Data P2H - ${unit}`);
                    $('#table-container').slideDown();

                    response.forEach((item, index) => {
                        const shiftKeys = Object.keys(item.shifts).join(', ');

                        $('#p2hTableBody').append(`
                        <tr>
                            <td>${item.tanggal}</td>
                            <td>${item.nomor_unit}</td>
                            <td>${item.jenis_p2h}</td>
                            <td>${shiftKeys}</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary btn-detail" 
                                    data-index="${index}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `);
                    });
                },
                error: function() {
                    Swal.fire('Gagal', 'Gagal mengambil data P2H.', 'error');
                }
            });
        });

        // Handler filter lokal
        function filterTable() {
            const keyword = $('#searchInput').val().toLowerCase();
            const selectedDate = $('#filterDate').val();

            $('#p2hTableBody tr').each(function() {
                const unit = $(this).find('td:eq(1)').text().toLowerCase();
                const jenis = $(this).find('td:eq(2)').text().toLowerCase();
                const tanggal = $(this).find('td:eq(0)').text();

                const matchesKeyword = unit.includes(keyword) || jenis.includes(keyword);
                const matchesDate = !selectedDate || tanggal === selectedDate;

                if (matchesKeyword && matchesDate) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Event listener
        $('#searchInput').on('input', filterTable);
        $('#filterDate').on('change', filterTable);
        $('#resetFilter').on('click', function() {
            $('#searchInput').val('');
            $('#filterDate').val('');
            filterTable();
        });


        // Saat klik tombol Detail

        $(document).on('click', '.btn-detail', function() {
            const index = $(this).data('index');
            const data = currentData[index];

            let html = '';

            Object.entries(data.shifts).forEach(([shift, detail]) => {
                // Ambil waktu dari created_at
                const time = new Date(detail.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                });

                html += `
                        <div class="mb-4">
                            <h5 class="mb-2">Shift ${shift}</h5>
                            <p>
                                <i class="bi bi-person-circle me-1"></i><strong>Operator:</strong> ${detail.operator_name}
                                <i class="bi bi-clock me-1"></i><strong>Jam Input:</strong> ${time} WIB
                            </p>
                            <button class="btn btn-sm btn-warning mb-3 btn-edit-shift" data-shift="${shift}"  data-id="${detail.id}">
                                Edit ${detail.id}
                            </button>
                            <div class="row">
                    `;


                for (const [key, value] of Object.entries(detail)) {
                    if (['id', 'created_at', 'updated_at', 'jenis_p2h', 'operator_name', 'p2h_model_id', 'shift'].includes(key)) continue;

                    let label = key === 'jam_operasional' ? 'Hours Meter' : key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    let badge;

                    if (value === 1 || value === '1') {
                        badge = `<span class="badge bg-success">OK</span>`;
                    } else if (value === 0 || value === '0') {
                        badge = `<span class="badge bg-danger">NOK</span>`;
                    } else {
                        badge = `<span class="text-muted">${value}</span>`;
                    }

                    html += `
                    <div class="col-md-4 mb-2">
                        <strong>${label}</strong><br>${badge}
                    </div>
                `;
                }

                html += `</div></div>`;
            });

            $('#modalDetailBody').html(html);
            $('#modalDetailP2H').modal('show');
        });

        $('#downloadPDF').on('click', function() {
            const element = document.getElementById('modalDetailBody');

            // Opsi konfigurasi
            const opt = {
                margin: 0.5,
                filename: 'detail_p2h_shift.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save();
        });


        $(document).on('click', '.btn-edit-shift', function() {
            const id = $(this).data('id');
            const shift = $(this).data('shift');

            const detail = Object.values(currentData).flatMap(p2h => Object.values(p2h.shifts)).find(d => d.id == id);

            if (!detail) return;

            let formHtml = '';

            for (const [key, value] of Object.entries(detail)) {
                if (['created_at', 'updated_at', 'p2h_model_id', 'operator_name', 'shift'].includes(key)) continue;

                const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                // Display as text only
                if (['tanggal', 'jenis_p2h', 'nomor_unit', 'dept'].includes(key)) {
                    formHtml += `
                <div class="mb-3">
                    <label class="form-label"><strong>${label}</strong></label>
                    <p class="form-control-plaintext">${value}</p>
                </div>
            `;
                } else if (key === 'id') {
                    formHtml += `
              
                    <input type="hidden" class="form-control" id="${key}" name="${key}" value="${value}">
            `;
                } else if (key === 'jam_operasional') {
                    formHtml += `
                <div class="mb-3">
                    <label class="form-label"><strong>Hours Meter</strong></label>
                    <input type="text" class="form-control" name="${key}" value="${value}">
                </div>
            `;
                } else if (key === 'catatan') {
                    formHtml += `
                <div class="mb-3">
                    <label class="form-label"><strong>${label}</strong></label>
                    <input type="text" class="form-control" name="${key}">
                </div>
            `;
                } else {
                    formHtml += `
                <div class="mb-3">
                    <label class="form-label"><strong>${label}</strong></label>
                    <select name="${key}" class="form-select">
                        <option value="1" ${value == 1 ? 'selected' : ''}>OK</option>
                        <option value="0" ${value == 0 ? 'selected' : ''}>NOK</option>
                    </select>
                </div>
            `;
                }
            }

            $('#editShiftForm').data('id', id);
            $('#editShiftBody').html(formHtml);
            $('#modalEditShift').modal('show');
        });


        $('#editShiftForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#id').val();
            const formData = $(this).serialize();

            $.ajax({
                url: "{{url('wh/p2h/update-detail')}}/" + id,
                method: 'PUT',
                data: formData,
                success: function(res) {
                    Swal.fire('Berhasil', 'Data berhasil diperbarui', 'success');
                    $('#modalEditShift').modal('hide');
                    $('#modalDetailP2H').modal('hide');
                    setInterval(() => {
                        location.reload(); // Reload halaman untuk melihat perubahan
                    }, 1000);
                },
                error: function(err) {
                    Swal.fire('Gagal', 'Gagal mengupdate data', 'error');
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