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

    </div>
</div>

<script>
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
            const operatorRow = `<tr><th>Operator</th>${headers.map(p => `<td>${entry.operator?.[p] ?? '-'}</td>`).join('')}</tr>`;
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
                }
            ];
            const markup = rows.map(r => `<tr><th>${r.label}</th>${r.cells.map(c => `<td>${c}</td>`).join('')}</tr>`);
            return renderTable(headers, markup, 'Jenis Pemakaian');
        }

        function buildChemicalTable(entry) {
            const shifts = Array.from(new Set(entry.data.flatMap(d => d.shifts.map(s => s.shift))));
            const rows = entry.data.map(d => {
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
                ${group.join('')}`;
            });

            return renderTable(shifts, rows, 'Parameter');
        }
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