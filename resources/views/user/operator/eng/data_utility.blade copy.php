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
                            <thead>
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
        let allBlocks = [];
        let allSearchableBlocks = [];
        let currentUnit = '';
        let currentPage = 1;
        const rowsPerPage = 10;

        $('.card-unit').on('click', function() {
            currentUnit = $(this).data('unit');
            currentPage = 1;
            allBlocks = [];
            allSearchableBlocks = [];

            let url = '';
            let tableHeader = '';

            switch (currentUnit) {
                case 'Listrik':
                    url = "{{url('/eng/data/listrik')}}";
                    tableHeader = `
                    <tr>
                        <th class="bg-info"><small>Tanggal</small></th>
                        <th class="bg-info">Parameter</th>
                        <th class="bg-info">Panel 1</th>
                        <th class="bg-info">Panel 2</th>
                        <th class="bg-info">Panel 3</th>
                        <!-- Tambahkan sesuai jumlah panel -->
                    </tr>`;
                    break;
                case 'Air':
                    url = "{{url('/eng/data/air')}}";
                    tableHeader = `
                    <tr>
                        <th class="bg-info"><small>Tanggal</small></th>
                        <th class="bg-info">Parameter</th>
                        <!-- Akan diisi dinamis berdasarkan jenis_pemakaian -->
                    </tr>`;
                    break;
                case 'Chemical':
                    url = "{{url('/eng/data/chemical')}}";
                    tableHeader = `
                    <tr>
                        <th class="bg-info"><small>Tanggal</small></th>
                        <th class="bg-info">Jenis</th>
                        <th class="bg-info">Shift 1</th>
                        <th class="bg-info">Shift 2</th>
                        <th class="bg-info">Shift 3</th>
                    </tr>`;
                    break;
            }

            $('#table-title').text('Data Pemakaian ' + currentUnit);
            $('#Table thead').html(tableHeader);
            $('#table-container').show();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (currentUnit === 'Listrik') {
                        response.forEach(group => {
                            const {
                                tanggal,
                                panels,
                                rows,
                                operator,
                                usage
                            } = group;

                            let block = `
                            <tr>
                                <td rowspan="8" class="align-middle text-center text-nowrap bg-info">${tanggal}</td>
                                <td class="bg-info">Parameter</td>`;
                            panels.forEach(p => block += `<td class="bg-info">${p}</td>`);
                            block += `</tr>`;

                            ['volt', 'a', 'kw', 'mwh', 'cos'].forEach(param => {
                                if (rows[param]) {
                                    block += `<tr><td>${param.toUpperCase()}</td>`;
                                    panels.forEach(p => {
                                        block += `<td>${rows[param][p] ?? '-'}</td>`;
                                    });
                                    block += `</tr>`;
                                }
                            });

                            block += `<tr class="table-warning"><td><strong>USAGE</strong></td>`;
                            panels.forEach(p => {
                                block += `<td>${usage?.[p] ?? '-'}</td>`;
                            });
                            block += `</tr>`;

                            block += `<tr class="table-secondary"><td><strong>OPERATOR</strong></td>`;
                            panels.forEach(p => {
                                block += `<td>${operator?.[p] ?? '-'}</td>`;
                            });
                            block += `</tr>`;

                            allBlocks.push(block);

                            const textSearch = `${tanggal} ` + panels.map(p =>
                                `${p} ${operator?.[p] ?? ''} ${rows.volt?.[p] ?? ''} ${rows.a?.[p] ?? ''} ${rows.kw?.[p] ?? ''} ${rows.mwh?.[p] ?? ''} ${rows.cos?.[p] ?? ''} ${usage?.[p] ?? ''}`
                            ).join(' ');

                            allSearchableBlocks.push({
                                html: block,
                                text: textSearch.toLowerCase(),
                                date: tanggal
                            });
                        });
                    }

                    if (currentUnit === 'Air') {
                        response.forEach(group => {
                            const tanggal = group.tanggal;
                            const items = group.data;
                            const columns = items.map(i => i.jenis_pemakaian || '-');

                            let block = `
                            <tr>
                                <td rowspan="6" class="align-middle text-center text-nowrap bg-info">${tanggal}</td>
                                <td class="bg-info">Parameter</td>`;
                            columns.forEach(c => block += `<td class="bg-info">${c}</td>`);
                            block += `</tr>`;

                            const row = (label, getVal) => {
                                block += `<tr><td>${label}</td>`;
                                items.forEach(i => {
                                    block += `<td>${getVal(i) ?? '-'}</td>`;
                                });
                                block += `</tr>`;
                            };

                            row('Liter Awal', i => i.pemakaian_awal);
                            row('Liter Akhir', i => i.pemakaian_akhir);
                            row('Operator', i => i.created_by);
                            row('Catatan', i => i.notes);

                            allBlocks.push(block);

                            const textSearch = `${tanggal} ` + items.map(i =>
                                `${i.jenis_pemakaian} ${i.pemakaian_awal} ${i.pemakaian_akhir} ${i.created_by} ${i.notes || ''}`
                            ).join(' ');

                            allSearchableBlocks.push({
                                html: block,
                                text: textSearch.toLowerCase(),
                                date: tanggal
                            });
                        });
                    }

                    if (currentUnit === 'Chemical') {
                        response.forEach(group => {
                            const tanggal = group.tanggal;
                            const items = group.data;

                            const shiftMap = {};
                            items.forEach(item => {
                                const jenis = item.jenis_pemakaian;
                                if (!shiftMap[jenis]) shiftMap[jenis] = {};
                                item.shifts.forEach(s => {
                                    shiftMap[jenis][s.shift?.toLowerCase()] = s.nilai_pemakaian;
                                });
                            });

                            const jenisList = Object.keys(shiftMap);
                            const shiftLabels = ['shift 1', 'shift 2', 'shift 3'];

                            let block = '';
                            jenisList.forEach((jenis, idx) => {
                                block += `<tr>`;
                                if (idx === 0) block += `<td rowspan="${jenisList.length}" class="align-middle text-center bg-info">${tanggal}</td>`;
                                block += `<td>${jenis}</td>`;
                                shiftLabels.forEach(shift => {
                                    block += `<td>${shiftMap[jenis][shift] ?? '-'}</td>`;
                                });
                                block += `</tr>`;
                            });

                            allBlocks.push(block);

                            const textSearch = `${tanggal} ` + jenisList.map(j =>
                                `${j} ${shiftLabels.map(s => shiftMap[j][s] ?? '').join(' ')}`
                            ).join(' ');

                            allSearchableBlocks.push({
                                html: block,
                                text: textSearch.toLowerCase(),
                                date: tanggal
                            });
                        });
                    }

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
            const filtered = allSearchableBlocks.filter(item =>
                (keyword === '' || item.text.includes(keyword)) &&
                (date === '' || item.date.includes(date))
            ).map(item => item.html);
            renderTable(filtered);
        }

        function renderTable(data) {
            const totalPages = Math.ceil(data.length / rowsPerPage);
            if (currentPage > totalPages) currentPage = 1;
            const start = (currentPage - 1) * rowsPerPage;
            const paginated = data.slice(start, start + rowsPerPage);
            $('#p2hTableBody').html(paginated.join(''));
            $('#pagination').empty();
            if (totalPages <= 1) return;
            for (let i = 1; i <= totalPages; i++) {
                const btn = $('<button>')
                    .addClass('btn btn-sm mx-1 ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary'))
                    .text(i)
                    .on('click', function() {
                        currentPage = i;
                        renderTable(data);
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

    .table-border-thick td,
    .table-border-thick th {
        border: 1px solid #333 !important;
    }
</style>

@endsection