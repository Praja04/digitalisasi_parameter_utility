@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12">
                <div class="d-flex flex-column h-100">
                    <div class="row h-100">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">


                                    <div class="row align-items-end">
                                        <div class="col-sm-10">
                                            <div class="p-3">
                                                <h1>P2H Online Form</h1>
                                                <div class="mt-3">
                                                    <p class="fs-16 lh-base">
                                                        Periksa Kendaraan Anda!
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="px-3">
                                                <img src="{{asset('/material/assets/images/user-illustarator-2.png')}}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                </div>
            </div> <!-- end col-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="tasksList">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Pemeriksaan Forklift</h5>
                            <div class="flex-shrink-0">
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary mb-3" id="btnTambah">Tambah Unit Pemeriksaan</button>
                                    <button class="btn btn-success" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                    <div class="card-body">
                        <div class="table-responsive table-card mb-4">
                            <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nomor Unit</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="batchList">

                                </tbody>
                            </table>
                            <!--end table-->
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 200k+ tasks We did not find any tasks for you search.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>


    </div>
</div>

<!-- Modal Form Tambah -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formCheck">
            @csrf
            <input type="hidden" id="p2h_id" name="id" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pemeriksaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-2">
                        <label for="nomor_unit" class="form-label">Nomor Unit</label>
                        <input type="text" class="form-control" id="nomor_unit" name="nomor_unit" required>
                    </div>
                    <div class="mb-2">
                        <label for="dept" class="form-label">Departemen</label>
                        <input type="text" class="form-control" id="dept" name="dept" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        let p2hData = [];

        function loadP2H() {
            $.get("{{ url('wh/p2h') }}", function(response) {
                p2hData = response;
                renderTable();
            });
        }
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            let item = p2hData.find(x => x.id == id);

            if (!item) return alert('Data tidak ditemukan!');

            // Isi form
            $('#p2h_id').val(item.id);
            $('#tanggal').val(item.tanggal);
            $('#nomor_unit').val(item.nomor_unit);
            $('#dept').val(item.dept);

            $('#modalForm').modal('show');
        });

        function renderTable() {
            let rows = '';
            p2hData.forEach((item, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.nomor_unit}</td>
                        <td>${item.dept}</td>
                        <td>${item.status}</td>
                        <td>
                          <a href="{{url('wh/foreman/detail/p2h/${item.id}')}}" class="btn btn-success btn-sm">Detail</a>
                          <button class="btn btn-warning btn-sm edit-btn" data-id="${item.id}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            $('#batchList').html(rows);
        }

        // Tampilkan modal
        $('#btnTambah').click(function() {
            $('#formCheck')[0].reset();
            $('#p2h_id').val('');
            $('#modalForm').modal('show');
        });


        // Submit form
        $('#formCheck').submit(function(e) {
            e.preventDefault();

            let id = $('#p2h_id').val();
            let url = '';
            let method = '';

            if (id) {
                // Update
                url = `{{ url('wh/p2h/update') }}/${id}`;
                method = 'PUT';
            } else {
                // Create
                url = "{{ url('wh/p2h/store') }}";
                method = 'POST';
            }

            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: function(res) {
                    $('#modalForm').modal('hide');
                    loadP2H();

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: res.message || 'Data berhasil disimpan!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let message = 'Terjadi kesalahan';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.errors) {
                            // Jika validasi error
                            message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: message,
                    });
                }
            });
        });


        // Hapus data
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Yakin hapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('wh/p2h/delete') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            loadP2H();
                            Swal.fire('Berhasil!', res.message, 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        loadP2H();
    });
</script>
@endsection