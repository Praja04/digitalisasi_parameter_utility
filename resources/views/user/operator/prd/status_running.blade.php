@extends('layout')

@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="row mb-3 pb-1">
         <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
               <div class="flex-grow-1">
                  <h4 class="fs-16 mb-1">Welcome, {{ Session::get('username') }}!</h4>
                  <p class="text-muted mb-0">Here's the current status of production running.</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card" id="statusRunningList">
               <div class="card-header d-flex align-items-center">
                  <h5 class="card-title flex-grow-1 mb-0">Status Running - Pasteurisasi 1</h5>
                  <div class="d-flex gap-1 flex-wrap">
                     <button type="button" class="btn btn-info create-btn" data-bs-toggle="modal" data-bs-target="#status-modal"><i class="ri-add-line align-bottom me-1"></i>Tambah Status</button>
                  </div>
               </div>
               <div class="card-body">
                  <div>
                     <div class="table-responsive table-card mb-3">
                        <table class="table align-middle table-nowrap mb-0">
                           <thead class="table-light text-center">
                              <tr>
                                 <th scope="col">No</th>
                                 <th scope="col">Mode</th>
                                 <th scope="col">Varian</th>
                                 <th scope="col">Batch</th>
                                 <th scope="col">Storage</th>
                                 <th scope="col">Created By</th>
                                 <th scope="col">Created At</th>
                                 <th scope="col">Aksi</th>
                              </tr>
                           </thead>
                           <tbody class="list form-check-all text-center" id="statusList">
                           </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                           <div class="text-center">
                              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                              <h5 class="mt-2">Sorry! No Result Found</h5>
                              <p class="text-muted mb-0">No data available.</p>
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

<div class="modal fade" id="status-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Tambah Status Running</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="formTambahStatus" autocomplete="off">
               <div class="mb-3">
                  <label for="mode" class="form-label">Mode <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="mode">
               </div>
               <div class="mb-3">
                  <label for="varian" class="form-label">Varian <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="varian">
               </div>
               <div class="mb-3">
                  <label for="batch" class="form-label">Batch <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="batch">
               </div>
               <div class="mb-3">
                  <label for="storage" class="form-label">Storage <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="storage">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save-status">Save Changes</button>
         </div>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      fetchStatusRunning();

      function fetchStatusRunning() {
         $.ajax({
            url: "{{ url('/prd/status-running') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
               let rows = '';
               if (response.length > 0) {
                  response.forEach((item, index) => {
                     rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.mode}</td>
                            <td>${item.varian}</td>
                            <td>${item.batch}</td>
                            <td>${item.storage}</td>
                            <td>${item.created_by}</td>
                            <td>${new Date(item.created_at).toLocaleString('id-ID', {
                                 day: '2-digit',
                                  month: '2-digit',
                                    year: 'numeric',
                                       hour: '2-digit',
                                          minute: '2-digit',
                                              hour12: false
                              })}
                           </td>
                            <td>
                                <button class='btn btn-warning btn-sm edit-btn' data-id='${item.id}'>Edit</button>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='${item.id}'>Hapus</button>
                            </td>
                        </tr>`;
                  });
                  $('.noresult').hide();
               } else {
                  rows = `<tr><td colspan='7' class='text-center'>No Data Available</td></tr>`;
                  $('.noresult').hide();
               }
               $('#statusList').html(rows);
            },
            error: function(xhr) {
               console.error('Error fetching data:', xhr.responseText);
            }
         });
      }

      $('#save-status').click(function() {
         let data = {
            mode: $('#mode').val(),
            varian: $('#varian').val(),
            batch: $('#batch').val(),
            storage: $('#storage').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
         };

         $.ajax({
            url: "{{ url('/prd/status-running/store') }}",
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function() {
               $('#status-modal').modal('hide');

               fetchStatusRunning();

               Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'Status running berhasil ditambahkan.',
                  timer: 2000,
                  showConfirmButton: false
               });
            },
            error: function(xhr) {
               let message = 'Terjadi kesalahan!';

               if (xhr.status === 422) {
                  let errors = xhr.responseJSON.errors;
                  message = Object.values(errors).map(e => e[0]).join('<br>');
                  Swal.fire({
                     icon: 'error',
                     title: 'Validasi Gagal',
                     html: message
                  });
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: xhr.responseText || message
                  });
               }
            }
         });

      });



      $(document).on('click', '.edit-btn', function() {
         let id = $(this).data('id');
         let url = "{{ url('/prd/status-running') }}/" + id;
         $.get(url, function(data) {
            $('#editMode').val(data.mode);
            $('#editVarian').val(data.varian);
            $('#editBatch').val(data.batch);
            $('#editStorage').val(data.storage);
            $('#editStatusRunningModal').modal('show');
            $('#updateStatusRunning').data('id', id);
         }).fail(function(xhr) {
            alert('Gagal mengambil data! ' + xhr.responseText);
         });
      });

      $('#updateStatusRunning').click(function() {
         let id = $(this).data('id');
         let url = "{{ url('/prd/status-running/update') }}/" + id;
         let data = {
            mode: $('#editMode').val(),
            varian: $('#editVarian').val(),
            batch: $('#editBatch').val(),
            storage: $('#editStorage').val(),
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PUT'
         };

         $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function() {
               $('#editStatusRunningModal').modal('hide');
               fetchStatusRunning();
            },
            error: function(xhr) {
               alert('Gagal memperbarui data! ' + xhr.responseText);
            }
         });
      });

      $(document).on('click', '.delete-btn', function() {
         let id = $(this).data('id');
         let url = "{{ url('/prd/status-running/delete') }}/" + id;
         if (confirm('Apakah Anda yakin ingin menghapus?')) {
            $.ajax({
               url: url,
               method: 'DELETE',
               data: {
                  _token: $('meta[name="csrf-token"]').attr('content')
               },
               success: function() {
                  fetchStatusRunning();
               },
               error: function(xhr) {
                  alert('Gagal menghapus data! ' + xhr.responseText);
               }
            });
         }
      });
   });
</script>
@endsection