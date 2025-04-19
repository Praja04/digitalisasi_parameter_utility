@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="container">
            <h2 class="mb-3">📋 Detail QC After Cooling</h2>

            <!-- Informasi Batch -->
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text"><strong>Tanggal:</strong>{{$data->tanggal}} </p>
                    <p class="card-text"><strong>Created By: </strong>{{$data->created_by_user}} </p>
                    <p class="card-text"><strong>Created At: </strong>{{$data->created_at}} </p>
                </div>
            </div>

            <!-- Form Tambah Shift -->
            <h4 class="mb-3">➕ Tambah Data After Cooling </h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                Tambah Data After Cooling
            </button>
            <input type="hidden" name="id_after" id="id_after" value="{{ $data->id }}">
            <hr>

            <!-- Tabel Daftar Shift -->
            <h4 class="mb-3">📊 Data Produksi batch pasteurisasi 1 per Shift</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shift</th>
                        <th scope="col">Brix</th>
                        <th scope="col">Viscositas</th>
                        <th scope="col">Aw</th>
                        <th scope="col">pH</th>
                        <th scope="col">Bj</th>
                        <th scope="col">Buih</th>
                        <th scope="col">Endapan</th>
                        <th scope="col">Organo</th>
                        <th scope="col">Warna</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="shiftList">

                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal Tambah Data After Cooling -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahDetail">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data After Cooling</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_after_cooling" value="{{ $data->id }}">

                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift</label>
                            <select class="form-control" name="shift" id="shift" required>
                                <option value="1">Shift 1</option>
                                <option value="2">Shift 2</option>
                                <option value="3">Shift 3</option>
                            </select>
                        </div>
                        <div class="mb-3"><label>Brix</label><input id="brix" type="number" step="0.01" class="form-control" name="brix" required></div>
                        <div class="mb-3"><label>Viscositas</label><input id="viscositas" type="number" step="0.01" class="form-control" name="viscositas" required></div>
                        <div class="mb-3"><label>pH</label><input id="ph" type="number" step="0.01" class="form-control" name="ph" required></div>
                        <div class="mb-3"><label>Bj</label><input id="bj" type="number" step="0.01" class="form-control" name="bj" required></div>
                        <div class="mb-3"><label>Aw</label><input id="aw" type="number" step="0.01" class="form-control" name="aw" required></div>
                        <div class="mb-3"><label>Buih</label><input id="buih" type="number" step="0.01" class="form-control" name="buih" required></div>
                        <div class="mb-3"><label>Endapan</label><input id="endapan" type="number" step="0.01" class="form-control" name="endapan" required></div>
                        <div class="mb-3"><label>Organo</label><input id="organo" type="text" class="form-control" name="organo" required></div>
                        <div class="mb-3"><label>Warna</label><input id="warna" type="text" class="form-control" name="warna" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        const idAfterCooling = $('#id_after').val();
        console.log(idAfterCooling);
        // Load data detail saat halaman dibuka
        loadShiftData();

        // Submit form tambah detail
        $('#formTambahDetail').on('submit', function(e) {
            e.preventDefault();
            // const idAfterCooling = $('#id_after_cooling').val();

            $.ajax({
                url: `/qc/detail/store/${idAfterCooling}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    shift: $('#shift').val(),
                    viscositas: $('#viscositas').val(),
                    brix: $('#brix').val(),
                    ph: $('#ph').val(),
                    bj: $('#bj').val(),
                    aw: $('#aw').val(),
                    buih: $('#buih').val(),
                    endapan: $('#endapan').val(),
                    organo: $('#organo').val(),
                    warna: $('#warna').val()
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Shift berhasil ditambahkan.',
                        timer: 2000,
                        showConfirmButton: true
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.responseJSON?.message || 'Terjadi kesalahan.'
                    });
                }

            });
        });

        // Ambil dan tampilkan data shift
        function loadShiftData() {
            $.get(`/qc/detail/${idAfterCooling}`, function(data) {
                let rows = '';
                if (data.length === 0) {
                    rows = '<tr><td colspan="10" class="text-center">Belum ada data.</td></tr>';
                } else {
                    data.forEach((item, index) => {
                        rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.shift}</td>
                            <td>${item.viscositas}</td>
                            <td>${item.aw}</td>
                            <td>${item.ph}</td>
                            <td>${item.bj}</td>
                            <td>${item.buih}</td>
                            <td>${item.endapan}</td>
                            <td>${item.organo}</td>
                            <td>${item.warna}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="${item.id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${item.id}">Hapus</button>
                            </td>
                        </tr>
                    `;
                    });
                }
                $('#shiftList').html(rows);
            });
        }

        // Hapus detail
        $(document).on('click', '.delete-btn', function() {
            const idDetail = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/qc/detail/delete/${idDetail}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });
                            loadShiftData();
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: err.responseJSON?.message || 'Terjadi kesalahan saat menghapus.'
                            });
                        }
                    });
                }
            });
        });


        // Edit detail
        $(document).on('click', '.edit-btn', function() {
            const idDetail = $(this).data('id');

            // Ambil data by ID
            $.get(`/qc/detail/${idAfterCooling}`, function(data) {
                const detail = data.find(d => d.id === idDetail);
                if (detail) {
                    const formHtml = `
                    <form id="editForm">
                        @csrf
                        <input type="hidden" id="edit_id" value="${detail.id}">
                        <div class="mb-2"><label>Shift:</label><input type="number" class="form-control" id="edit_shift" value="${detail.shift}"></div>
                        <div class="mb-2"><label>Brix:</label><input type="number" class="form-control" id="edit_brix" value="${detail.brix}"></div>
                        <div class="mb-2"><label>Viscositas:</label><input type="number" class="form-control" id="edit_viscositas" value="${detail.viscositas}"></div>
                        <div class="mb-2"><label>Brix:</label><input type="number" class="form-control" id="edit_brix" value="${detail.brix}"></div>
                        <div class="mb-2"><label>pH:</label><input type="number" class="form-control" id="edit_ph" value="${detail.ph}"></div>
                        <div class="mb-2"><label>BJ:</label><input type="number" class="form-control" id="edit_bj" value="${detail.bj}"></div>
                        <div class="mb-2"><label>Aw:</label><input type="number" class="form-control" id="edit_aw" value="${detail.aw}"></div>
                        <div class="mb-2"><label>Buih:</label><input type="number" class="form-control" id="edit_buih" value="${detail.buih}"></div>
                        <div class="mb-2"><label>Endapan:</label><input type="number" class="form-control" id="edit_endapan" value="${detail.endapan}"></div>
                        <div class="mb-2"><label>Organo:</label><input type="text" class="form-control" id="edit_organo" value="${detail.organo}"></div>
                        <div class="mb-2"><label>Warna:</label><input type="text" class="form-control" id="edit_warna" value="${detail.warna}"></div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                `;

                    Swal.fire({
                        title: 'Edit Data Shift',
                        html: formHtml,
                        showConfirmButton: false,
                    });

                    $(document).on('submit', '#editForm', function(e) {
                        e.preventDefault();
                        const id = $('#edit_id').val();

                        $.ajax({
                            url: `/qc/detail/update/${id}`,
                            method: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                shift: $('#edit_shift').val(),
                                viscositas: $('#edit_viscositas').val(),
                                brix: $('#edit_brix').val(),
                                ph: $('#edit_ph').val(),
                                bj: $('#edit_bj').val(),
                                aw: $('#edit_aw').val(),
                                buih: $('#edit_buih').val(),
                                endapan: $('#edit_endapan').val(),
                                organo: $('#edit_organo').val(),
                                warna: $('#edit_warna').val()
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Shift berhasil ditambahkan.',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: err.responseJSON?.message || 'Gagal menyimpan data.'
                                });
                            }

                        });
                    });
                }
            });
        });
    });
</script>


@endsection