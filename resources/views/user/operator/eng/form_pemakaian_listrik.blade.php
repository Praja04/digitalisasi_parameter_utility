@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Welcome ,{{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>

                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="apiKeyList">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Form Pemakaian Listrik</h5>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-info create-btn" data-bs-toggle="modal" data-bs-target="#pemakaian-modal">
                                <i class="ri-add-line align-bottom me-1"></i> Catat Pemakaian Listrik
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-3">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" id="th-tanggal" class="position-relative">
                                                Tanggal
                                                <div id="filter-date-container" class="position-absolute top-100 start-50 translate-middle-x d-none p-2 bg-white border rounded shadow-sm">
                                                    <label>Dari: <input type="date" id="start-date" class="form-control form-control-sm"></label>
                                                    <label class="ms-2">Sampai: <input type="date" id="end-date" class="form-control form-control-sm"></label>
                                                    <button id="apply-filter" class="btn btn-sm btn-primary mt-2 w-100">Terapkan</button>
                                                </div>
                                            </th>
                                            <th scope="col">Pemakaian Listrik (kwh)</th>
                                            <th scope="col">Notes</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all text-center" id="airListrik"></tbody>
                                </table>
                                <div class="noresult text-center mt-3" style="display: none;">
                                    <p class="text-muted">Tidak ada data yang ditemukan.</p>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">Previous</a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="pemakaian-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data Pemakaian Listrik</h5>
                <button type="button" class="btn-close" id="close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPemakaianListrik" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="api-key-error-msg" class="alert alert-danger py-2 d-none"></div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="pemakaian_kwh" class="form-label">Pemakaian Listrik (kwh)<span class="text-danger">*</span></label>
                        <input class="form-control" type="number" step="0.01" id="pemakaian_kwh" placeholder="Masukkan nilai dalam liter...">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="notes" placeholder="opsional...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-primary" id="save-button">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let baseUrl = "{{ url('eng/data/listrik') }}";
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        let currentPage = 1;
        let itemsPerPage = 10;
        let allData = [];
        let filteredData = [];

        let currentEditId = null;

        $(document).on("click", ".update-button", function() {
            currentEditId = $(this).data("id");
            const item = allData.find((x) => x.id === currentEditId);

            if (item) {
                $("#tanggal").val(item.tanggal);
                $("#pemakaian_kwh").val(item.pemakaian_kwh);
                $("#notes").val(item.notes);
                $("#pemakaian-modal").modal("show");
            }
        });


        // 🔹 Ambil Data dari Server
        function loadData() {
            $.ajax({
                url: baseUrl,
                type: "GET",
                success: function(response) {
                    allData = response;
                    filteredData = allData;
                    updateTable();
                    updatePagination();
                },
                error: function(xhr) {
                    console.error("Error loading data:", xhr);
                    alert("Gagal mengambil data.");
                },
            });
        }

        // 🔹 Simpan Data Baru
        $("#save-button").on("click", function() {
            let formData = {
                _token: csrfToken,
                tanggal: $("#tanggal").val(),
                pemakaian_kwh: $("#pemakaian_kwh").val(),
                notes: $("#notes").val() || "-"
            };

            let method = currentEditId ? "PUT" : "POST";
            let url = currentEditId ?
                `${baseUrl}/${currentEditId}/update` :
                `${baseUrl}/store`;

            $.ajax({
                url: url,
                type: method,
                data: JSON.stringify(formData),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function(response) {
                    $("#pemakaian-modal").modal("hide");
                    currentEditId = null;
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    console.error("Gagal:", xhr.responseJSON);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Data gagal disimpan.',
                    });

                },
            });
        });


        // 🔹 Hapus Data
        $(document).on("click", ".delete-button", function() {
            let id = $(this).data("id");
            Swal.fire({
                title: 'Yakin ingin hapus data ini?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lanjut hapus
                    $.ajax({
                        url: baseUrl + "/" + id,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: response.message || 'Data berhasil dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadData();
                        },
                        error: function(xhr, response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message || 'Data gagal dihapus.',
                            });
                        },
                    });
                }
            });

        });

        // 🔹 Update Tampilan Tabel
        function updateTable() {
            let tbody = $("#airListrik");
            tbody.empty();

            let start = (currentPage - 1) * itemsPerPage;
            let end = start + itemsPerPage;
            let paginatedData = filteredData.slice(start, end);

            if (paginatedData.length === 0) {
                $(".noresult").show();
            } else {
                $(".noresult").hide();
                $.each(paginatedData, function(index, item) {
                    let rowNumber = start + index + 1;
                    let row = `
                  <tr>
                     <td>${rowNumber}</td>
                     <td>${new Date(item.created_at).toLocaleDateString()}</td>
                     <td>${item.pemakaian_kwh} </td>
                     <td>${item.notes} </td>
                     <td>${item.created_by} </td>
                     <td>
                        <button class="btn btn-danger btn-sm delete-button" data-id="${item.id}">Hapus</button>
                        <button class="btn btn-warning btn-sm update-button" data-id="${item.id}">Edit</button>
                     </td>
                  </tr>
               `;
                    tbody.append(row);
                });
            }
        }

        // 🔹 Update Pagination
        function updatePagination() {
            let paginationList = $(".listjs-pagination");
            paginationList.empty();

            let totalPages = Math.ceil(filteredData.length / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = i === currentPage ? "active" : "";
                paginationList.append(`<li class="page-item ${activeClass}" data-page="${i}"><a href="#">${i}</a></li>`);
            }

            $(".pagination-prev").toggleClass("disabled", currentPage === 1);
            $(".pagination-next").toggleClass("disabled", currentPage === totalPages);
        }

        // 🔹 Filter Berdasarkan Rentang Tanggal
        function applyFilter() {
            let startDate = $("#start-date").val();
            let endDate = $("#end-date").val();

            if (startDate && endDate) {
                filteredData = allData.filter(item => {
                    let itemDate = item.created_at.split("T")[0];
                    return itemDate >= startDate && itemDate <= endDate;
                });
            } else {
                filteredData = allData;
            }

            currentPage = 1;
            updateTable();
            updatePagination();
        }

        // 🔹 Navigasi Pagination
        $(document).on("click", ".pagination-prev", function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                updatePagination();
            }
        });

        $(document).on("click", ".pagination-next", function(e) {
            e.preventDefault();
            let totalPages = Math.ceil(filteredData.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
                updatePagination();
            }
        });

        $(document).on("click", ".page-item", function(e) {
            e.preventDefault();
            let page = $(this).data("page");
            if (page) {
                currentPage = page;
                updateTable();
                updatePagination();
            }
        });



        // 🔹 Klik Dua Kali untuk Menampilkan Input Rentang Tanggal
        let clickCount = 0;
        $("#th-tanggal").on("click", function() {
            clickCount++;
            setTimeout(() => {
                if (clickCount === 2) {
                    $("#filter-date-container").removeClass("d-none");
                }
                clickCount = 0;
            }, 300);
        });

        // 🔹 Terapkan Filter Saat Tombol Ditekan
        $("#apply-filter").on("click", function() {
            applyFilter();
            $("#filter-date-container").addClass("d-none");
        });

        $("#pemakaian-modal").on("hidden.bs.modal", function() {
            $("#formTambahPemakaianListrik")[0].reset();
            currentEditId = null;
        });


        // 🔹 Load Data Saat Halaman Dibuka
        loadData();
    });
</script>


@endsection