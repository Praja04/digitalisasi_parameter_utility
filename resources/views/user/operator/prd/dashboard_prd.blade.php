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
                           <h1>PRD Form</h1>
                           <p class="fs-16 lh-base">
                              Perusahaan makanan kelas dunia dimulai dari pencatatan produksi yang rapi.
                           </p>
                        </div>
                     </div>
                     <div class="col-sm-2 text-end">
                        <img src="{{ asset('assets/images/produksi.jpg') }}" class="img-fluid" alt="" style="max-height: 100px;">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Card Unit -->
      <div class="row">
         <div class="col-md-6">
            <div class="card clickable card-unit batch-card" data-unit="batch">
               <div class="card-body text-center">
                  <h4 class="card-title">Output Batch</h4>
                  <img src="{{ asset('assets/images/batch.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                  <p class="text-muted">Klik untuk pemeriksaan</p>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card clickable card-unit status-card" data-unit="status">
               <div class="card-body text-center">
                  <h4 class="card-title">Status Running Pasteurisasi Line 1</h4>
                  <img src="{{ asset('assets/images/status_running.png') }}" alt="gambar" class="img-fluid" style="border-radius: 20px; max-height: 150px; object-fit: contain;">
                  <p class="text-muted">Klik untuk pemeriksaan</p>
               </div>
            </div>
         </div>
      </div>

      <!-- Form -->
      <div class="row mt-4" id="form-container" style="display: none;">
         <div class="col-md-10 offset-md-1">
            <div class="card">
               <div class="card-header">
                  <h5 id="form-title">Form PRD</h5>
               </div>
               <div class="card-body">
                  <div id="form-batch" style="display: none;">
                     <form id="form-pemakaian-batch">
                        @csrf
                        <div class="mb-3">
                           <label for="waktu" class="form-label">Waktu</label>
                           <input type="date" name="waktu" class="form-control" id="waktu_batch" readonly>
                        </div>
                        <div class="mb-3">
                           <label for="shift" class="form-label">shift</label>
                           <select class="form-select" name="shift" id="shift">
                              <option value="">Pilih Shift</option>
                              <option value="1">Shift 1</option>
                              <option value="2">Shift 2</option>
                              <option value="3">Shift 3</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label for="line" class="form-label">line</label>
                           <input type="text" name="line" class="form-control" id="line_batch">
                        </div>
                        <div class="mb-3">
                           <label for="variant" class="form-label">variant</label>
                           <input type="text" name="variant" class="form-control" id="variant_batch">
                        </div>
                        <div class="mb-3">
                           <label for="jumlah_batch" class="form-label">jumlah_batch</label>
                           <input type="text" name="jumlah_batch" class="form-control" id="jumlah_batch_batch">
                        </div>
                        <div class="mb-3">
                           <label for="berat_batch" class="form-label">berat_batch</label>
                           <input type="text" name="berat_batch" class="form-control" id="berat_batch_batch">
                        </div>
                        <button type="submit" class="btn btn-danger">Simpan batch</button>
                     </form>
                  </div>

                  <div id="form-status" style="display: none;">
                     <form id="form-pemakaian-status">
                        @csrf
                        <div class="mb-3">
                           <label for="tanggal" class="form-label">Tanggal</label>
                           <input type="date" name="tanggal" id="tanggal_status" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                           <label for="mode" class="form-label">Mode <span class="text-danger">*</span></label>
                           <select name="mode" id="mode" class="form-select">
                              <option value="">Pilih Mode</option>
                              <option value="CIP">CIP</option>
                              <option value="Repro">Repro</option>
                              <option value="Produksi">Produksi</option>
                              <option value="SIP">SIP</option>
                              <option value="Flushing">Flushing</option>
                              <option value="STK">STK</option>
                              <option value="Switch STK">Switch STK</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label for="varian" class="form-label">Varian <span class="text-danger">*</span></label>
                           <select name="varian" id="varian" class="form-select">
                              <option value="">Pilih Varian</option>
                              <option value="BB">BB</option>
                              <option value="JB">JB</option>
                              <option value="SS1">SS1</option>
                              <option value="SS2">SS2</option>
                              <option value="MSD">MSD</option>
                              <option value="NR2">NR2</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label for="storage" class="form-label">Storage <span class="text-danger">*</span></label>
                           <select name="storage" id="storage" class="form-select">
                              <option value="">Pilih Storage</option>
                              <option value="A1">A1</option>
                              <option value="A2">A2</option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                              <option value="A5">A5</option>
                              <option value="B1">B1</option>
                              <option value="B2">B2</option>
                              <option value="B3">B3</option>
                              <option value="B4">B4</option>
                              <option value="B5">B5</option>
                              <option value="C1">C1</option>
                              <option value="C2">C2</option>
                              <option value="C3">C3</option>
                              <option value="C4">C4</option>
                              <option value="C5">C5</option>
                              <option value="D1">D1</option>
                              <option value="D2">D2</option>
                              <option value="D3">D3</option>
                              <option value="D4">D4</option>
                              <option value="D5">D5</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label for="batch" class="form-label">Batch <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="batch">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan status</button>
                     </form>
                  </div>
               </div>

            </div>
         </div>
      </div>

   </div>
</div>

<!-- Script -->
<script>
   $(document).ready(function() {





      const today = new Date().toISOString().split('T')[0];
      $('#waktu_batch').val(today);
      $('#tanggal_status').val(today);

      $('.card-unit').click(function() {
         const unit = $(this).data('unit');

         // Slide up dulu
         $('#form-container').slideUp(300, function() {
            // Setelah selesai slide up, sembunyikan semua form
            $('#form-batch, #form-status, #form-chemical').hide();

            // Atur judul form
            $('#form-title').text('Form PRD ' + unit);

            // Tampilkan form sesuai unit yang diklik
            if (unit === 'batch') {
               $('#form-batch').show();
            } else if (unit === 'status') {
               $('#form-status').show();
            }

            // Setelah atur semua, slide down container
            $('#form-container').slideDown(400);
         });
      });


      $('#form-pemakaian-status').on('submit', function(e) {
         e.preventDefault();

         let formData = $(this).serialize();

         $.ajax({
            url: "{{url('/eng/data/status/store')}}",
            method: 'POST',
            data: formData,
            success: function(response) {
               Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: response.message,
               });

               setInterval(() => {
                  location.reload(); // Reload halaman untuk update data
               }, 3000);
            },
            error: function(xhr) {
               if (xhr.status === 422) {
                  let errors = xhr.responseJSON.errors;
                  let errorList = '';

                  $.each(errors, function(key, value) {
                     errorList += `<li>${value[0]}</li>`;
                  });

                  Swal.fire({
                     icon: 'error',
                     title: 'Validasi Gagal',
                     html: `<ul style="text-align:left">${errorList}</ul>`,
                  });
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan data.',
                  });
               }
            }
         });
      });

      $('#form-pemakaian-batch').on('submit', function(e) {
         e.preventDefault();

         let formData = $(this).serialize();

         $.ajax({
            url: "{{url('/eng/data/batch/store')}}",
            method: 'POST',
            data: formData,
            success: function(res) {
               Swal.fire('Berhasil', res.message, 'success');
               setInterval(() => {
                  location.reload(); // Reload halaman untuk update data
               }, 3000);
            },
            error: function(xhr) {
               if (xhr.status === 422) {
                  let errors = xhr.responseJSON.errors;
                  let message = '<ul>';
                  $.each(errors, function(key, value) {
                     message += '<li>' + value[0] + '</li>';
                  });
                  message += '</ul>';

                  Swal.fire({
                     icon: 'error',
                     title: 'Validasi Gagal',
                     html: message
                  });
               } else {
                  Swal.fire('Error', 'Gagal menyimpan data batch.', 'error');
               }
            }
         });
      });

      $('#cancelForm').on('click', function() {

         $('#form-container').slideUp();
      });



      $('input[type=radio]').on('change', function() {
         const name = $(this).attr('name');
         const isOk = $(this).val() === '1';

         const group = $(`input[name="${name}"]`);

         group.each(function() {
            $(this).closest('.radio-label').removeClass('ok-selected nok-selected');
         });

         if (isOk) {
            $(this).closest('.radio-label').addClass('ok-selected');
         } else {
            $(this).closest('.radio-label').addClass('nok-selected');
         }
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

   .batch-card:hover {
      background-color: #ffe5e5;
      border: 1px solid #dc3545;
   }

   .status-card:hover {
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