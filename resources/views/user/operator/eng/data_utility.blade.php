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
                renderSummaryTable(data);
            });
        });

        function renderSummaryTable(data) {
            allData = data;
            applyFilters();

        }

        $(document).on('click', '.view-detail', function() {
            const index = $(this).data('index');
            const entry = allData[index];
            $('#modalDate').text(entry.tanggal);
            $('#modalContent').html(generatePivot(entry));
            $('#detailModal').modal('show');
        });

        function generatePivot(entry) {
            if (currentUnit === 'Listrik') {
                const headers = entry.panels;
                const parameters = Object.keys(entry.rows || {});
                const usage = entry.usage || {};

                // Baris operator
                const operatorRow = `<tr><th>Operator</th>${headers.map(panel => `<td>${entry.operator?.[panel] ?? '-'}</td>`).join('')}</tr>`;

                // Baris usage volt
                const usageRow = `<tr><th>Usage (Volt)</th>${headers.map(panel => `<td>${usage[panel] ?? '-'}</td>`).join('')}</tr>`;

                // Baris parameter (volt, a, kw, dll)
                const paramRows = parameters.map(param => {
                    const cells = headers.map(panel => `<td>${entry.rows[param][panel] ?? '-'}</td>`);
                    return `<tr><th>${param}</th>${cells.join('')}</tr>`;
                });

                const allRows = [operatorRow, usageRow, ...paramRows];

                return renderTable(headers, allRows, 'Keterangan');
            }

            if (currentUnit === 'Air') {
                const headers = entry.data.map(d => d.jenis_pemakaian);
                const rows = [{
                        label: 'Awal',
                        cells: entry.data.map(d => `${d.pemakaian_awal} liter`)
                    },
                    {
                        label: 'Akhir',
                        cells: entry.data.map(d => `${d.pemakaian_akhir} liter`)
                    },
                    {
                        label: 'Created By',
                        cells: entry.data.map(d => d.created_by)
                    }
                ];

                return renderTable(headers, rows.map(r => {
                    const td = r.cells.map(c => `<td>${c}</td>`).join('');
                    return `<tr><th>${r.label}</th>${td}</tr>`;
                }), 'Jenis Pemakaian');
            }

            if (currentUnit === 'Chemical') {
                const shiftsSet = new Set();
                const allParams = ['Nilai Pemakaian', 'Area', 'Operator', 'Notes'];

                entry.data.forEach(d => d.shifts.forEach(s => shiftsSet.add(s.shift)));
                const shifts = Array.from(shiftsSet);
                const headers = shifts; // horizontal = shift

                const rows = entry.data.map(d => {
                    const barisNilai = shifts.map(s => {
                        const dataShift = d.shifts.find(x => x.shift === s);
                        return `<td>${dataShift?.nilai_pemakaian ?? '-'}</td>`;
                    }).join('');
                    const barisArea = shifts.map(s => {
                        const dataShift = d.shifts.find(x => x.shift === s);
                        return `<td>${dataShift?.area ?? '-'}</td>`;
                    }).join('');
                    const barisOperator = shifts.map(s => {
                        const dataShift = d.shifts.find(x => x.shift === s);
                        return `<td>${dataShift?.operator ?? '-'}</td>`;
                    }).join('');
                    const barisNotes = shifts.map(s => {
                        const dataShift = d.shifts.find(x => x.shift === s);
                        return `<td>${dataShift?.notes ?? '-'}</td>`;
                    }).join('');

                    return `
          <tr class="table-primary"><th colspan="${shifts.length + 1}">${d.jenis_pemakaian}</th></tr>
          <tr><th>Nilai Pemakaian</th>${barisNilai}</tr>
          <tr><th>Area</th>${barisArea}</tr>
          <tr><th>Operator</th>${barisOperator}</tr>
          <tr><th>Notes</th>${barisNotes}</tr>
        `;
                });

                return renderTable(headers, rows, 'Parameter');
            }

            return '<p>Data tidak tersedia.</p>';
        }

        function renderTable(headers, rows, rowHeader) {
            return `
      <div class="table-responsive" style="overflow-x: auto;">
        <table class="table table-bordered table-striped" style="min-width: 800px;">
          <thead>
            <tr><th>${rowHeader}</th>${headers.map(h => `<th>${h}</th>`).join('')}</tr>
          </thead>
          <tbody>${rows.join('')}</tbody>
        </table>
      </div>
    `;
        }


        function applyFilters() {
            const keyword = $('#searchInput').val().toLowerCase();
            const filterDate = $('#filterDate').val();
            const tbody = $('#dateTable tbody').empty();

            const filtered = allData.filter((item) => {
                const tgl = item.tanggal.toLowerCase();
                const keywordMatch = !keyword || tgl.includes(keyword);
                const dateMatch = !filterDate || tgl === filterDate;
                return keywordMatch && dateMatch;
            });

            if (filtered.length === 0) {
                tbody.append('<tr><td colspan="3" class="text-center">Tidak ada data ditemukan.</td></tr>');
                return;
            }

            filtered.forEach((item, index) => {
                let count = 0;
                if (currentUnit === 'Air') count = item.data?.length || 0;
                else if (currentUnit === 'Listrik') count = item.panels?.length || 0;
                else if (currentUnit === 'Chemical') count = item.data?.length || 0;

                const row = `
            <tr>
                <td>${item.tanggal}</td>
                <td>${count}</td>
                <td><button class="btn btn-sm btn-primary view-detail" data-index="${index}">Lihat Detail</button></td>
            </tr>`;
                tbody.append(row);
            });
        }

        $('#searchInput, #filterDate').on('input change', function() {
            applyFilters();
        });

        $('#resetFilter').on('click', function() {
            $('#searchInput').val('');
            $('#filterDate').val('');
            applyFilters();
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