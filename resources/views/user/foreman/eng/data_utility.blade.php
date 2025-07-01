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
                                    <h1>Utility Data</h1>
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
                        <p class="text-muted">Klik untuk data</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable card-unit air-card" data-unit="Air">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pemakaian Air</h4>
                        <img src="{{ asset('assets/images/air.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                        <p class="text-muted">Klik untuk data</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable card-unit chemical-card" data-unit="Chemical">
                    <div class="card-body text-center">
                        <h4 class="card-title">Pemakaian Chemical</h4>
                        <img src="{{ asset('assets/images/chemical.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                        <p class="text-muted">Klik untuk data</p>
                    </div>
                </div>
            </div>
        </div>


        <div id="table-container" style="display: none;">
            <!-- Filter Controls -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
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
                    <h5 id="table-title" class="mb-3"></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dateTable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total Entries</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris diisi oleh JS/jQuery -->
                            </tbody>
                        </table>
                        <div id="export-container" class="mt-3" style="display:none;">
                            <button class="btn btn-success" id="exportListrikBtn">
                                Export Excel (Listrik)
                            </button>
                        </div>

                        <!-- Modal Pilih Bulan -->
                        <div class="modal fade" id="bulanModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pilih Bulan untuk Export</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="month" id="bulanPicker" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary" id="confirmExport">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pagination" class="mt-3 d-flex justify-content-center"></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Shift -->
        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Details: <span id="modalDate"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editPanelModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="editPanelForm" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="editPanelFormBody">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        const endpoints = {
            Listrik: "{{url('/eng/data/listrik')}}",
            Air: "{{url('/eng/data/air')}}",
            Chemical: "{{url('/eng/data/chemical')}}"
        };

        let currentUnit = '';
        let allData = [];

        $('.card-unit').on('click', function() {
            currentUnit = $(this).data('unit');
            $('#table-title').text(`Data Pemakaian ${currentUnit}`);
            $('#table-container').show();

            $.getJSON(endpoints[currentUnit], function(data) {
                allData = data;
                applyFilters();
            });

            $('#export-container').toggle(currentUnit === 'Listrik');
        });

        $('#searchInput, #filterDate').on('input change', applyFilters);
        $('#resetFilter').on('click', function() {
            $('#searchInput, #filterDate').val('');
            applyFilters();
        });

        $('#exportListrikBtn').on('click', () => $('#bulanModal').modal('show'));

        $('#confirmExport').on('click', function() {
            const bulan = $('#bulanPicker').val();
            if (!bulan) return alert('Silakan pilih bulan terlebih dahulu.');
            window.open(`/export-pemakaian-listrik?bulan=${bulan}`, '_blank');
            $('#bulanModal').modal('hide');
        });

        $(document).on('click', '.view-detail', function() {
            const entry = $(this).data('entry');
            $('#modalDate').text(entry.tanggal);
            $('#modalContent').html(generatePivot(entry));
            $('#detailModal').modal('show');
        });

        function applyFilters() {
            const keyword = $('#searchInput').val().toLowerCase();
            const filterDate = $('#filterDate').val();

            const filtered = allData.filter(item => {
                const tanggal = item.tanggal.toLowerCase();
                return (!keyword || tanggal.includes(keyword)) &&
                    (!filterDate || tanggal === filterDate);
            });

            renderPagination(filtered);
        }

        function getEntryCount(entry) {
            if (currentUnit === 'Air' || currentUnit === 'Chemical') return entry.data?.length || 0;
            if (currentUnit === 'Listrik') return entry.panels?.length || 0;
            return 0;
        }

        function renderPagination(data, itemsPerPage = 10) {
            const paginationContainer = $('#pagination').empty();
            const totalPages = Math.ceil(data.length / itemsPerPage);
            let currentPage = 1;

            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const sliced = data.slice(start, start + itemsPerPage);
                renderTableRows(sliced);
            }

            function renderTableRows(dataSlice) {
                const tbody = $('#dateTable tbody').empty();

                if (!dataSlice.length) {
                    tbody.append('<tr><td colspan="3" class="text-center">Tidak ada data ditemukan.</td></tr>');
                    return;
                }

                dataSlice.forEach(item => {
                    const count = getEntryCount(item);
                    const row = `
                    <tr>
                        <td>${item.tanggal}</td>
                        <td>${count}</td>
                        <td>
                            <button class="btn btn-sm btn-primary view-detail" data-entry='${JSON.stringify(item)}'>
                                Lihat Detail
                            </button>
                        </td>
                    </tr>`;
                    tbody.append(row);
                });
            }

            function buildButtons() {
                paginationContainer.empty(); // bersihkan tombol sebelumnya
                for (let i = 1; i <= totalPages; i++) {
                    const btn = $(`<button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} mx-1">${i}</button>`);
                    btn.on('click', () => {
                        currentPage = i;
                        renderPage(currentPage);
                        buildButtons();
                    });
                    paginationContainer.append(btn);
                }
            }

            renderPage(currentPage);
            buildButtons();
        }

        function generatePivot(entry) {
            switch (currentUnit) {
                case 'Listrik':
                    return buildListrikTable(entry);
                case 'Air':
                    return buildAirTable(entry);
                case 'Chemical':
                    return buildChemicalTable(entry);
                default:
                    return '<p>Data tidak tersedia.</p>';
            }
        }

        function renderTable(headers, rows, rowHeader) {
            return `
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped" style="min-width: 800px;">
                    <thead><tr><th>${rowHeader}</th>${headers.map(h => `<th>${h}</th>`).join('')}</tr></thead>
                    <tbody>${rows.join('')}</tbody>
                </table>
            </div>`;
        }

        function buildListrikTable(entry) {
            const headers = entry.panels;
            const parameters = Object.keys(entry.rows || {});

            const operatorRow = `<tr>
                <th>Operator</th>
                ${headers.map(p => `
                    <td>
                    ${entry.operator?.[p] ?? '-'}
                    <button class="btn btn-sm btn-warning btn-edit-panel mt-1" 
                            data-panel="${p}" 
                            data-entry='${JSON.stringify(entry)}'>
                        Edit
                    </button>
                    </td>
                `).join('')}
                </tr>`;

            const usageRow = `<tr><th>Usage (Volt)</th>${headers.map(p => `<td>${entry.usage?.[p] ?? '-'}</td>`).join('')}</tr>`;

            const paramRows = parameters.map(param => {
                const cells = headers.map(p => `<td>${entry.rows[param][p] ?? '-'}</td>`);
                return `<tr><th>${param}</th>${cells.join('')}</tr>`;
            });

            return renderTable(headers, [operatorRow, usageRow, ...paramRows], 'Keterangan');
        }

        function buildAirTable(entry) {
            const headers = entry.data.map(d => d.jenis_pemakaian);
            const rows = [{
                    label: 'Awal',
                    cells: entry.data.map(d => `${d.pemakaian_awal} m³`)
                },
                {
                    label: 'Akhir',
                    cells: entry.data.map(d => `${d.pemakaian_akhir} m³`)
                },
                {
                    label: 'Created By',
                    cells: entry.data.map(d => d.created_by)
                },
                {
                    label: 'Action',
                    cells: entry.data.map(d => `
                <button class="btn btn-sm btn-warning btn-edit-air"
                        data-entry='${JSON.stringify(d)}'
                        data-tanggal="${entry.tanggal}">
                    Edit
                </button>
            `)
                }
            ];

            const markup = rows.map(r => `<tr><th>${r.label}</th>${r.cells.map(c => `<td>${c}</td>`).join('')}</tr>`);
            return renderTable(headers, markup, 'Jenis Pemakaian');
        }

        function buildChemicalTable(entry) {
            const shifts = Array.from(new Set(entry.data.flatMap(d => d.shifts.map(s => s.shift))));
            const rows = entry.data.map(d => {
                const actionRow = `<tr><th>Action</th>${
            shifts.map(s => {
                const shiftData = d.shifts.find(x => x.shift === s);
                return `<td>
                    ${shiftData ? `
                        <button class="btn btn-sm btn-warning btn-edit-chemical"
                                data-shift="${s}" 
                                data-jenis="${d.jenis_pemakaian}" 
                                data-tanggal="${entry.tanggal}"
                                data-entry='${JSON.stringify(shiftData)}'>
                            Edit
                        </button>` : '-' }
                </td>`;
            }).join('')
        }</tr>`;

                const group = ['nilai_pemakaian', 'area', 'operator', 'notes'].map(attr => {
                    const cells = shifts.map(s => {
                        const sd = d.shifts.find(x => x.shift === s);
                        return `<td>${sd?.[attr] ?? '-'}</td>`;
                    });
                    const label = attr.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                    return `<tr><th>${label}</th>${cells.join('')}</tr>`;
                });

                return `
            <tr class="table-primary"><th colspan="${shifts.length + 1}">${d.jenis_pemakaian}</th></tr>
            ${group.join('')}
            ${actionRow}
        `;
            });

            return renderTable(shifts, rows, 'Parameter');
        }
        $(document).on('click', '.btn-edit-panel', function() {
            const panel = $(this).data('panel');
            const data = $(this).data('entry');

            const volt = data.rows?.volt?.[panel] ?? '';
            const amp = data.rows?.a?.[panel] ?? '';
            const kw = data.rows?.kw?.[panel] ?? '';
            const mwh = data.rows?.mwh?.[panel] ?? '';
            const cos = data.rows?.cos?.[panel] ?? '';
            const usage = data.usage?.[panel] ?? '';
            const operator = data.operator?.[panel] ?? '';

            const formHtml = `
                <input type="hidden" name="tanggal" value="${data.tanggal}">
                <input type="hidden" name="panel_type" value="${panel}">
                <div class="mb-2"><label>Volt</label><input class="form-control" name="volt" value="${volt}"></div>
                <div class="mb-2"><label>Ampere</label><input class="form-control" name="a" value="${amp}"></div>
                <div class="mb-2"><label>KW</label><input class="form-control" name="kw" value="${kw}"></div>
                <div class="mb-2"><label>MWH</label><input class="form-control" name="mwh" value="${mwh}"></div>
                <div class="mb-2"><label>Cos φ</label><input class="form-control" name="cos" value="${cos}"></div>
                `;

            $('#editPanelFormBody').html(formHtml);
            $('#editPanelModal').modal('show');
        });

        $(document).on('click', '.btn-edit-air', function() {
            const data = $(this).data('entry');
            const tanggal = $(this).data('tanggal');

            const formHtml = `
        <input type="hidden" name="id" value="${data.id ?? ''}">
        <input type="hidden" name="tanggal" value="${tanggal}">
        <div class="mb-2"><label>Jenis Pemakaian</label><input class="form-control" name="jenis_pemakaian" value="${data.jenis_pemakaian}" readonly></div>
        <div class="mb-2"><label>Pemakaian Awal</label><input class="form-control" name="pemakaian_awal" value="${data.pemakaian_awal}"></div>
        <div class="mb-2"><label>Pemakaian Akhir</label><input class="form-control" name="pemakaian_akhir" value="${data.pemakaian_akhir}"></div>
        <div class="mb-2"><label>Catatan</label><textarea class="form-control" name="notes">${data.notes ?? ''}</textarea></div>
    `;

            $('#editPanelFormBody').html(formHtml);
            $('#editPanelModal').modal('show');
        });

        $(document).on('click', '.btn-edit-chemical', function() {
            const shift = $(this).data('shift');
            const jenis = $(this).data('jenis');
            const tanggal = $(this).data('tanggal');
            const data = $(this).data('entry');
            const rawNilai = data.nilai_pemakaian ?? '';
            const angkaNilai = typeof rawNilai === 'string' ? rawNilai.match(/\d+(\.\d+)?/)?.[0] ?? '' : rawNilai;

            const formHtml = `
        <input type="hidden" name="tanggal" value="${tanggal}">
        <input type="hidden" name="shift" value="${shift}">
        <input type="hidden" name="chemical_area" value="${data.area ?? ''}">
        <div class="mb-2"><label>Jenis Pemakaian</label><input class="form-control" name="jenis_pemakaian" value="${jenis}" readonly></div>
        <div class="mb-2"><label>Nilai Pemakaian</label><input class="form-control" name="nilai_pemakaian" value="${angkaNilai}"></div>
        <div class="mb-2"><label>Catatan</label><textarea class="form-control" name="notes">${data.notes ?? ''}</textarea></div>
    `;

            $('#editPanelFormBody').html(formHtml);
            $('#editPanelModal').modal('show');
        });

        $('#editPanelForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            let url = '';

            if (currentUnit === 'Listrik') {
                url = '/eng/update-panel-listrik';
            } else if (currentUnit === 'Air') {
                url = '/eng/update-pemakaian-air';
            } else if (currentUnit === 'Chemical') {
                url = '/eng/update-pemakaian-chemical';
            }

            $.post(url, formData, function(res) {
                $('#editPanelModal').modal('hide');
                $('#detailModal').modal('hide');

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbarui.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    location.reload();
                }, 2000);
            }).fail(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal menyimpan data. Silakan periksa kembali.',
                    icon: 'error'
                });
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

    .table-border-thick td,
    .table-border-thick th {
        border: 1px solid #333 !important;
    }
</style>

@endsection