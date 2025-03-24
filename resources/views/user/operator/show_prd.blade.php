@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="container">
            <h2 class="mb-3">📋 Detail Batch Produksi</h2>

            <!-- Informasi Batch -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Batch Code: {{ $batch->batch_code }}</h5>
                    <p class="card-text"><strong>Tanggal:</strong> {{ $batch->batch_date }}</p>
                    <p class="card-text"><strong>Target Batch:</strong> {{ $batch->target_batch }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ ucfirst($batch->status) }}</p>
                </div>
            </div>

            <!-- Form Tambah Shift -->
            <h4 class="mb-3">➕ Tambah Data Shift</h4>
            <form id="formTambahShift">
                @csrf
                <input type="hidden" id="batch_id" value="{{ $batch->id }}">

                <div class="mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <select class="form-control" id="shift" name="shift" required>
                        <option value="1">Shift 1</option>
                        <option value="2">Shift 2</option>
                        <option value="3">Shift 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="batch_count" class="form-label">Jumlah Produksi</label>
                    <input type="number" class="form-control" id="batch_count" name="batch_count" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Shift</button>
            </form>

            <hr>

            <!-- Tabel Daftar Shift -->
            <h4 class="mb-3">📊 Data Produksi per Shift</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shift</th>
                        <th>Jumlah Produksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="shiftList">
                    @foreach ($batch->details as $index => $shift)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>Shift {{ $shift->shift }}</td>
                        <td>
                            <span class="batch-count-text">{{ $shift->batch_count }}</span>
                            <input type="number" class="form-control batch-count-input d-none" data-id="{{ $shift->id }}" value="{{ $shift->batch_count }}">
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $shift->id }}">Edit</button>
                            <button class="btn btn-success btn-sm btn-save d-none" data-id="{{ $shift->id }}">Simpan</button>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $shift->id }}">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let batchId = $('#batch_id').val();

        // Tambah Shift Baru
        $('#formTambahShift').submit(function(e) {
            e.preventDefault();
            let formData = {
                _token: "{{ csrf_token() }}",
                shift: $('#shift').val(),
                batch_count: $('#batch_count').val()
            };

            $.post("{{ url('/prd/batch') }}/" + batchId + "/shift/store", formData, function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Shift berhasil ditambahkan.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

                // Update status batch jika berubah
                if (response.status) {
                    $('#batchStatus').text(response.status.charAt(0).toUpperCase() + response.status.slice(1));
                }
            }).fail(function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: xhr.responseJSON.message || 'Terjadi kesalahan.',
                });
            });
        });

        // Hapus Shift
        $(document).on('click', '.btn-delete', function() {
            let shiftId = $(this).data('id');

            Swal.fire({
                title: 'Hapus Shift?',
                text: "Data shift akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/prd/batch/shift') }}/" + shiftId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Shift berhasil dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON.message || 'Terjadi kesalahan.',
                            });
                        }
                    });
                }
            });
        });

        // Tombol Edit
        $(document).on('click', '.btn-edit', function() {
            let row = $(this).closest('tr');
            row.find('.batch-count-text').addClass('d-none');
            row.find('.batch-count-input').removeClass('d-none');
            row.find('.btn-edit').addClass('d-none');
            row.find('.btn-save').removeClass('d-none');
        });

        // Tombol Simpan Update
        $(document).on('click', '.btn-save', function() {
            let row = $(this).closest('tr');
            let shiftId = $(this).data('id');
            let newCount = row.find('.batch-count-input').val();

            $.ajax({
                url: "{{ url('/prd/batch/shift/update') }}/" + shiftId,
                type: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    batch_count: newCount
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Jumlah produksi berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON.message || 'Terjadi kesalahan.',
                    });
                }
            });
        });
    });
</script>
@endsection