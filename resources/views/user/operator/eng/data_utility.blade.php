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
                        <table class="table table-bordered table-hover" id="Table">
                            <thead class="table-light">
                                <tr>

                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="p2hTableBody">
                                <!-- Data akan dimasukkan di sini oleh JavaScript -->
                            </tbody>
                        </table>
                        <div id="pagination" class="mt-3 d-flex justify-content-center"></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Shift -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header ">
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
    </div>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        let allRows = []; // semua baris data mentah
        let currentUnit = '';
        let currentPage = 1;
        const rowsPerPage = 10;

        $('.card-unit').on('click', function() {
            currentUnit = $(this).data('unit');
            let url = '';
            let tableHeader = '';

            if (currentUnit === 'Air') {
                url = '/eng/data/air';
                tableHeader = `<tr>
                    <th>Tanggal</th>
                    <th>Liter Awal</th>
                    <th>Liter Akhir</th>
                    <th>Jenis</th>
                    <th>Operator</th>
                    <th>Catatan</th>
                </tr>`;
            } else if (currentUnit === 'Listrik') {
                url = '/eng/data/listrik';
                tableHeader = `<tr>
                    <th>Waktu</th>
                    <th>Operator</th>
                    <th>Panel</th>
                    <th>Volt</th>
                    <th>Ampere</th>
                    <th>KW</th>
                    <th>MWh</th>
                </tr>`;
            } else if (currentUnit === 'Chemical') {
                url = '/eng/data/chemical';
                tableHeader = `<tr>
                    <th>Tanggal</th>
                    <th>Area</th>
                    <th>Jenis</th>
                    <th>Nilai</th>
                    <th>Operator</th>
                    <th>Shift</th>
                    <th>Catatan</th>
                </tr>`;
            }

            $('#table-title').text('Data Pemakaian ' + currentUnit);
            $('#Table thead').html(tableHeader);
            $('#table-container').show();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    allRows = []; // reset
                    response.forEach(group => {
                        group.data.forEach(item => {
                            let row = '';
                            if (currentUnit === 'Air') {
                                row = `<tr>
                                    <td>${group.tanggal}</td>
                                    <td>${item.pemakaian_awal}</td>
                                    <td>${item.pemakaian_akhir}</td>
                                    <td>${item.jenis_pemakaian}</td>
                                    <td>${item.created_by}</td>
                                    <td>${item.notes || '-'}</td>
                                </tr>`;
                            } else if (currentUnit === 'Listrik') {
                                row = `<tr>
                                    <td>${item.waktu}</td>
                                    <td>${item.operator}</td>
                                    <td>${item.panel_type}</td>
                                    <td>${item.volt}</td>
                                    <td>${item.a}</td>
                                    <td>${item.kw}</td>
                                    <td>${item.mwh}</td>
                                </tr>`;
                            } else if (currentUnit === 'Chemical') {
                                row = `<tr>
                                    <td>${group.tanggal}</td>
                                    <td>${item.chemical_area}</td>
                                    <td>${item.jenis_pemakaian}</td>
                                    <td>${item.nilai_pemakaian}</td>
                                    <td>${item.operator}</td>
                                    <td>${item.shift}</td>
                                    <td>${item.notes || '-'}</td>
                                </tr>`;
                            }
                            allRows.push(row);
                        });
                    });

                    currentPage = 1;
                    applyFilterAndRender();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Gagal mengambil data.");
                }
            });
        });

        function applyFilterAndRender() {
            const keyword = $('#searchInput').val().toLowerCase();
            const date = $('#filterDate').val();

            const filteredRows = allRows.filter(rowHtml => {
                const tempDiv = $('<div>').html(rowHtml);
                const row = tempDiv.find('tr');
                const text = row.text().toLowerCase();
                const rowDate = row.find('td:first').text().trim();

                const matchKeyword = keyword === '' || text.includes(keyword);
                const matchDate = date === '' || rowDate.includes(date);
                return matchKeyword && matchDate;
            });

            renderTable(filteredRows);
        }

        function renderTable(dataRows) {
            const totalPages = Math.ceil(dataRows.length / rowsPerPage);
            if (currentPage > totalPages) currentPage = 1;

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedRows = dataRows.slice(start, start + rowsPerPage);

            $('#p2hTableBody').html(paginatedRows.join(''));

            // Render pagination
            $('#pagination').empty();
            if (totalPages <= 1) return;

            for (let i = 1; i <= totalPages; i++) {
                const btn = $('<button>')
                    .addClass('btn btn-sm mx-1 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary'))
                    .text(i)
                    .on('click', function() {
                        currentPage = i;
                        renderTable(dataRows);
                    });
                $('#pagination').append(btn);
            }
        }

        $('#resetFilter').on('click', function() {
            $('#searchInput').val('');
            $('#filterDate').val('');
            currentPage = 1;
            applyFilterAndRender();
        });

        $('#searchInput, #filterDate').on('input change', function() {
            currentPage = 1;
            applyFilterAndRender();
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