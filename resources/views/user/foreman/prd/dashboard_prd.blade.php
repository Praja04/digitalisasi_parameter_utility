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
                  <h5 class="card-title flex-grow-1 mb-0">Batch - Pasteurisasi 1</h5>
                  <div class="d-flex gap-1 flex-wrap">

                     <button type="button" class="btn btn-info create-btn" data-bs-toggle="modal" data-bs-target="#batch-modal"><i class="ri-add-line align-bottom me-1"></i>Catat Batch</button>
                  </div>
               </div>
               <div class="card-body">
                  <div>
                     <div class="table-responsive table-card mb-3">
                        <table class="table align-middle table-nowrap mb-0">
                           <thead class="table-light text-center">
                              <tr>

                                 
                                 <th  scope="col">no</th>
                                 <th scope="col">Tanggal Batch</th>
                                 <th scope="col">Target Batch</th>
                                 <th scope="col">Batch Code</th>
                                 <th scope="col">aksi</th>
                              </tr>
                           </thead>
                           <tbody class="list form-check-all text-center" id="batchList">

                           </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                           <div class="text-center">
                              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                              <h5 class="mt-2">Sorry! No Result Found</h5>
                              <p class="text-muted mb-0">We've searched more than 150+ API Keys We did not find any API for you search.</p>
                           </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                           <div class="pagination-wrap hstack gap-2">
                              <a class="page-item pagination-prev disabled" href="#">
                                 Previous
                              </a>
                              <ul class="pagination listjs-pagination mb-0"></ul>
                              <a class="page-item pagination-next" href="#">
                                 Next
                              </a>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
         </div>
         <!-- end col -->
      </div>
   </div>
</div>

<div class="modal fade" id="batch-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Batch</h5>
            <button type="button" class="btn-close" id="close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="formTambahBatch" autocomplete="off">
               <div id="api-key-error-msg" class="alert alert-danger py-2 d-none"></div>

               <div class="mb-3">
                  <label for="tanggal-batch" class="form-label">Tanggal <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="tanggal-batch">
               </div>
               <div class="mb-3">
                  <label for="target-batch" class="form-label">Target Batch <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="target-batch">
               </div>

            </form>
         </div>
         <div class="modal-footer">
            <div class="hstack gap-2 justify-content-end">
               <button type="button" class="btn btn-primary" id="save-button">Save Changes</button>
            </div>
         </div>
      </div>
      <!-- modal content -->
   </div>
</div>
<script>
   $(document).ready(function() {
      let currentPage = 1;
      let perPage = 10;
      let totalPages = 1;
      let batchData = [];

      function renderTable() {
         let start = (currentPage - 1) * perPage;
         let paginatedData = batchData.slice(start, start + perPage);
         let rows = '';

         paginatedData.forEach((batch,index) => {
            let detailUrl = `{{ route('operator.batch.show', ['id' => '__ID__']) }}`.replace('__ID__', batch.id);
            let deleteUrl = `{{ route('batch.destroy', ['id' => '__ID__']) }}`.replace('__ID__', batch.id);
            let rowNumber = (currentPage - 1) * perPage + (index + 1);
            rows += `
         <tr id="batch-${batch.id}">
          <td>${rowNumber}</td>
            <td class="tanggal">${batch.batch_date}</td>
            <td class="target">${batch.target_batch ?? '-'}</td>
            <td class="batchcode form-control apikey-value">${batch.batch_code}</td>
            <td>
               <a href="${detailUrl}" class="btn btn-info btn-sm">Detail</a>
               <button class="btn btn-danger btn-sm delete-batch" data-url="${deleteUrl}">Hapus</button>
            </td>
         </tr>`;
         });

         $('#batchList').html(rows);
         updatePagination();
      }

      function updatePagination() {
         let paginationHtml = '';

         $('.pagination-prev').toggleClass('disabled', currentPage === 1);
         $('.pagination-next').toggleClass('disabled', currentPage === totalPages);

         for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                               <a class="page-link pagination-number" href="#" data-page="${i}">${i}</a>
                            </li>`;
         }

         $('.pagination').html(paginationHtml);
      }

      function loadBatches() {
         $.get("{{ route('batch.index') }}", function(response) {
            batchData = response.filter(batch => batch.status !== 'completed').sort((a, b) => new Date(b.batch_date) - new Date(a.batch_date));
            batchData2 = batchData.sort((a, b) => new Date(b.batch_date) - new Date(a.batch_date));
            totalPages = Math.ceil(batchData.length / perPage);
            currentPage = 1;
            renderTable();
         });
      }

      $(document).on('click', '.pagination-prev', function(e) {
         e.preventDefault();
         if (currentPage > 1) {
            currentPage--;
            renderTable();
         }
      });

      $(document).on('click', '.pagination-next', function(e) {
         e.preventDefault();
         if (currentPage < totalPages) {
            currentPage++;
            renderTable();
         }
      });

      $(document).on('click', '.pagination-number', function(e) {
         e.preventDefault();
         let page = $(this).data('page');
         if (page !== currentPage) {
            currentPage = page;
            renderTable();
         }
      });

      loadBatches();

      // Tambah Batch dengan SweetAlert
      $('#save-button').on('click', function() {
         let batch_date = $('#tanggal-batch').val();
         let target_batch = $('#target-batch').val();

         if (!batch_date || !target_batch) {
            Swal.fire({
               icon: 'error',
               title: 'Oops...',
               text: 'Semua bidang wajib diisi!'
            });
            return;
         }

         $.ajax({
            url: "{{ route('batch.store') }}",
            type: "POST",
            data: {
               batch_date: batch_date,
               target_batch: target_batch,
               _token: "{{ csrf_token() }}"
            },
            success: function(response) {
               $('#batch-modal').modal('hide');
               $('#formTambahBatch')[0].reset();
               loadBatches();
               Swal.fire('Sukses!', 'Batch berhasil ditambahkan!', 'success');
            },
            error: function(xhr) {
               let errorMsg = xhr.responseJSON?.message || 'Gagal menambahkan batch.';
               Swal.fire('Error!', errorMsg, 'error');
            }
         });
      });

      // Hapus Batch dengan SweetAlert
      $(document).on('click', '.delete-batch', function() {
         let deleteUrl = $(this).data('url');

         Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  url: deleteUrl,
                  type: 'POST',
                  data: {
                     _token: "{{ csrf_token() }}",
                     _method: "DELETE"
                  },
                  success: function(response) {
                     Swal.fire('Deleted!', response.message, 'success');
                     loadBatches();
                  },
                  error: function() {
                     Swal.fire('Error!', 'Gagal menghapus batch.', 'error');
                  }
               });
            }
         });
      });
   });
</script>
@endsection