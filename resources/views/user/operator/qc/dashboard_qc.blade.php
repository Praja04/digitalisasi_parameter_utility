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
                  <h5 class="card-title flex-grow-1 mb-0">AfterCooling</h5>
                  <div class="d-flex gap-1 flex-wrap">
                     <button type="button" class="btn btn-info create-btn" data-bs-toggle="modal" data-bs-target="#aftercooling-modal">
                        <i class="ri-add-line align-bottom me-1"></i> Catat Data
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
                                 <th>
                                    Created By
                                 </th>
                                 <th scope="col">Aksi</th>
                              </tr>
                           </thead>
                           <tbody class="list form-check-all text-center" id="dataList"></tbody>
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

<div class="modal fade" id="aftercooling-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Data Aftercooling</h5>
            <button type="button" class="btn-close" id="close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="formTambahdata" autocomplete="off">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <div id="api-key-error-msg" class="alert alert-danger py-2 d-none"></div>

               <div class="mb-3">
                  <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="tanggal">
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
      let baseUrl = "{{ url('qc/data') }}";
      let csrfToken = $('meta[name="csrf-token"]').attr("content");
      let currentPage = 1;
      let itemsPerPage = 10;
      let allData = [];
      let filteredData = [];

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
         };

         $.ajax({
            url: baseUrl + "/store",
            type: "POST",
            data: JSON.stringify(formData), // Kirim sebagai JSON
            contentType: "application/json", // Pastikan format JSON
            headers: {
               "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
               alert("Data berhasil disimpan!");
               $("#aftercooling-modal").modal("hide");
               loadData();
            },
            error: function(xhr) {
               console.error("Error saving data:", xhr.responseJSON);
               alert("Gagal menyimpan data. Pastikan semua field terisi.");
            },
         });
      });

      // 🔹 Hapus Data
      $(document).on("click", ".delete-button", function() {
         let id = $(this).data("id");
         if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
               url: baseUrl + "/" + id,
               type: "DELETE",
               headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
               },
               success: function() {
                  alert("Data berhasil dihapus!");
                  loadData();
               },
               error: function(xhr) {
                  console.error("Error deleting data:", xhr);
                  alert("Gagal menghapus data.");
               },
            });
         }
      });

      // 🔹 Update Tampilan Tabel
      function updateTable() {
         let tbody = $("#dataList");
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
               let detailUrl ="{{url('qc/operator/detail')}}";
               let row = `
                  <tr>
                     <td>${rowNumber}</td>
                     <td>${item.tanggal}</td>
                     <td>${item.created_by_user}</td>
                     <td>
                      <a href="${detailUrl}/${item.id}" class="btn btn-info btn-sm">Detail</a>
                        <button class="btn btn-danger btn-sm delete-button" data-id="${item.id}">Hapus</button>
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

      // 🔹 Load Data Saat Halaman Dibuka
      loadData();
   });
</script>


@endsection