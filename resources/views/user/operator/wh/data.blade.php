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
                        <img src="{{ asset('assets/images/pallet_mover.jpg') }}" alt="gambar" height="150" style="border-radius: 20px;">
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
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Nomor Unit ">
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
                        <div id="pagination" class="mt-3 d-flex justify-content-center"></div>
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


    </div>
</div>

<!-- Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    let currentData = [];
    let palletData = [];
    let filteredData = [];
    const rowsPerPage = 10;
    let currentPage = 1;

    // Fungsi render tabel dengan pagination
    function renderTable(data, page = 1) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = data.slice(start, end);

        $('#p2hTableBody').empty();

        paginatedData.forEach((item, index) => {
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
                        data-index="${start + index}"
                        data-type="${item.jenis_p2h === 'Pallet Mover' ? 'pallet' : 'forklift'}"
                    >
                        Detail
                    </button>
                </td>
            </tr>
        `);
        });

        renderPagination(data.length, page);
    }

    // Fungsi render tombol pagination
    function renderPagination(totalItems, currentPage) {
        const totalPages = Math.ceil(totalItems / rowsPerPage);
        let html = '';

        for (let i = 1; i <= totalPages; i++) {
            html += `
            <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} mx-1 page-btn" data-page="${i}">
                ${i}
            </button>
        `;
        }

        $('#pagination').html(html);
    }

    // Fungsi filter berdasarkan keyword dan tanggal
    function applyFilter() {
        const keyword = $('#searchInput').val().toLowerCase();
        const selectedDate = $('#filterDate').val();
        const sourceData = $('#table-title').text().includes('Pallet') ? palletData : currentData;

        filteredData = sourceData.filter(item => {
            const unit = item.nomor_unit.toLowerCase();
            const jenis = item.jenis_p2h.toLowerCase();
            const tanggal = item.tanggal;

            const matchKeyword = unit.includes(keyword) || jenis.includes(keyword);
            const matchDate = !selectedDate || tanggal === selectedDate;

            return matchKeyword && matchDate;
        });

        currentPage = 1;
        renderTable(filteredData, currentPage);
    }

    // Event listener filter dan reset
    $('#searchInput').on('input', applyFilter);
    $('#filterDate').on('change', applyFilter);
    $('#resetFilter').on('click', function() {
        $('#searchInput').val('');
        $('#filterDate').val('');
        applyFilter();
    });

    // Event listener pagination
    $(document).on('click', '.page-btn', function() {
        currentPage = parseInt($(this).data('page'));
        renderTable(filteredData, currentPage);
    });

    // Event listener klik unit
    $('.card-unit').on('click', function() {
        const unit = $(this).data('unit');
        const isPallet = unit === 'Pallet Mover';

        const fetchUrl = isPallet ?
            "{{ url('wh/p2h/data/pallet/mover') }}" :
            "{{ url('wh/p2h/data') }}";

        $.ajax({
            url: fetchUrl,
            method: "GET",
            success: function(response) {
                palletData = isPallet ? response : [];
                currentData = !isPallet ? response : [];
                filteredData = response;

                $('#table-title').text(`Data P2H - ${unit}`);
                $('#table-container').slideDown();

                currentPage = 1;
                renderTable(filteredData, currentPage);
            },
            error: function() {
                Swal.fire('Gagal', 'Gagal mengambil data P2H.', 'error');
            }
        });
    });

    // Event listener tombol Detail
    $(document).on('click', '.btn-detail', function() {
        const index = $(this).data('index');
        const type = $(this).data('type');
        const data = type === 'pallet' ? palletData[index] : currentData[index];

        let html = '';

        Object.entries(data.shifts).forEach(([shift, detail]) => {
            const time = new Date(detail.created_at).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
            });

            html += `
        <div class="mb-4">
            <h5 class="mb-2">Shift ${shift}</h5>
            <p>
                <i class="bi bi-person-circle me-1"></i><strong>Operator:</strong> ${detail.operator_name}
                <i class="bi bi-clock ms-3 me-1"></i><strong>Jam Input:</strong> ${time} WIB
            </p>
            <div class="row">
        `;

            for (const [key, value] of Object.entries(detail)) {
                if (['id', 'created_at', 'updated_at', 'jenis_p2h', 'operator_name', 'p2h_model_id', 'shift'].includes(key)) continue;

                let label = key === 'jam_operasional' ? 'Hours Meter' : key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                let badge = '';

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

    // PDF download
    $('#downloadPDF').on('click', function() {
        // Ambil header dan body modal
        const header = document.querySelector('#modalDetailP2H .modal-header').cloneNode(true);
        const body = document.querySelector('#modalDetailBody').cloneNode(true);

        // Bungkus jadi 1 div untuk di-export
        const exportContainer = document.createElement('div');
        exportContainer.appendChild(header);
        exportContainer.appendChild(body);

        // Hilangkan scroll & batas tinggi
        exportContainer.style.maxHeight = 'unset';
        exportContainer.style.overflow = 'visible';

        const opt = {
            margin: 0.5,
            filename: 'detail_p2h_shift.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                scrollY: 0
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: {
                mode: ['css', 'legacy']
            } // auto page break
        };

        html2pdf()
            .set(opt)
            .from(exportContainer)
            .save();
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