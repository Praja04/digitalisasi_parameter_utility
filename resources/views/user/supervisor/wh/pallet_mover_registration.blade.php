@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <h4 class="mb-0">🚚 Pallet Mover Registration & Assignment</h4>
        </div>

        {{-- Section: Tambah Pallet Mover --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Tambah Pallet Mover</span>
                <button type="submit" form="addPalletForm" class="btn btn-primary btn-sm">Simpan Pallet</button>
            </div>
            <div class="card-body">
                <form id="addPalletForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Nomor Unit</label>
                            <input type="text" name="nomor_unit" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Departemen</label>
                            <select name="departemen" class="form-select" required>
                                <option value="warehouse">Warehouse</option>
                                <option value="produksi">Produksi</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Section: Data Pallet Mover --}}
        <div class="card">
            <div class="card-header">Daftar Pallet Mover Terdaftar</div>
            <div class="card-body">
                <table id="palletTable" class="table table-bordered table-striped dt-responsive w-100">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Departemen</th>
                            <th>Operator Utama</th>
                            <th>Jumlah Cadangan</th>
                            <th>Waktu Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- AJAX inject data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Modal: Assignment Operator --}}
<div class="modal fade" id="palletAssignmentModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="palletAssignmentForm" class="modal-content">
            @csrf
            <input type="hidden" name="pallet_mover_id" id="palletMoverId">
            <div class="modal-header">
                <h5 class="modal-title">🛠️ Assign Operator Pallet Mover</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Pilih Operator</label>
                    <select class="form-select" name="user_id" id="palletOperatorSelect">
                        @foreach($operators as $user)
                        <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->nik }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Assignment</label>
                    <select name="is_primary" class="form-select">
                        <option value="1">Primary</option>
                        <option value="0">Backup</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editPalletModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editPalletForm" class="modal-content">
            @csrf
            <input type="hidden" name="pallet_mover_id" id="editPalletId">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Pallet Mover</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3 px-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Unit</label>
                    <input type="text" name="nomor_unit" id="editNomorUnit" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Departemen</label>
                    <select name="departemen" id="editDepartemen" class="form-select" required>
                        <option value="warehouse">Warehouse</option>
                        <option value="produksi">Produksi</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="description" id="editDescription" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="palletBackupModal" tabindex="-1" aria-labelledby="palletBackupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="palletBackupModalLabel">Cadangan Pallet Mover</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="palletBackupModalBody">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editPalletAssignmentModal" tabindex="-1" aria-labelledby="editPalletAssignmentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editPalletAssignmentForm" class="modal-content">
            @csrf
            <input type="hidden" name="pallet_mover_id" id="editPalletAssignmentId">
            <div class="modal-header">
                <h5 class="modal-title" id="editPalletAssignmentLabel">Edit Assignment Pallet Mover</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Operator Utama</label>
                    <select name="primary_operator_id" id="editPrimaryOperatorSelect" class="form-select" required></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cadangan Operator</label>
                    <select name="backup_operator_ids[]" id="editBackupOperatorsSelect" class="form-select"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        const routeList = {
            data: '{{ route("wh.pallet.data") }}',
            store: '{{ route("wh.pallet.store") }}',
            assignmentStore: '{{ route("wh.pallet.assignment.store") }}',
            csrf: '{{ csrf_token() }}',
            detail: '{{ url("wh/pallet-mover/detail") }}',
            update: '{{ url("wh/pallet-mover") }}',
            delete: '{{ url("wh/pallet-mover") }}',
            backups: '{{ url("wh/pallet-mover") }}',
            assignmentDetail: '{{ url("wh/pallet-mover") }}',
            assignmentUpdate: '{{ url("wh/pallet-mover/assignment") }}'
        };

        $('#palletTable').DataTable({
            ajax: routeList.data,
            columns: [{
                    data: 'nomor_unit'
                },
                {
                    data: 'status'
                },
                {
                    data: 'departemen'
                },
                {
                    data: 'primary_operator'
                },
                {
                    data: 'backup_count',
                    title: 'Cadangan',
                    render: function(count, _, row) {
                        return `
                            <span class="badge bg-info backup-detail-btn"
                                style="cursor: pointer;"
                                data-id="${row.id}"
                                data-unit="${row.nomor_unit}">
                                ${count}
                            </span>`;
                    }
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'id',
                    render: function(id, _, row) {
                        return `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary assign-btn" data-id="${id}" data-unit="${row.nomor_unit}">Assign</button>
                                <button class="btn btn-sm btn-info edit-assignment-btn" data-id="${id}" data-unit="${row.nomor_unit}">Edit Assignment</button>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${id}" data-unit="${row.nomor_unit}">Delete</button>
                            </div>`;
                    }
                }
            ]
        });

        // Backup detail modal
        $('#palletTable').on('click', '.backup-detail-btn', function() {
            const id = $(this).data('id');
            const unit = $(this).data('unit');

            $.get(`${routeList.backups}/${id}/backups`, function(response) {
                let list = '';
                response.backups.forEach(op => {
                    list += `<li>${op.username} (${op.nik})</li>`;
                });

                $('#palletBackupModalLabel').text(`Cadangan - ${unit}`);
                $('#palletBackupModalBody').html(`<ul>${list}</ul>`);
                $('#palletBackupModal').modal('show');
            }).fail(function() {
                $('#palletBackupModalBody').html('<p class="text-danger">Gagal memuat data cadangan.</p>');
                $('#palletBackupModal').modal('show');
            });
        });

        // Assign
        $(document).on('click', '.assign-btn', function() {
            $('#palletMoverId').val($(this).data('id'));
            $('#palletAssignmentModal').modal('show');
        });

        $('#palletAssignmentForm').on('submit', function(e) {
            e.preventDefault();
            $.post(routeList.assignmentStore, $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Success', res.message, 'success');
                    $('#palletTable').DataTable().ajax.reload();
                    $('#palletAssignmentModal').modal('hide');
                } else {
                    Swal.fire('Error', res.message || 'Gagal menyimpan', 'error');
                }
            });
        });

        // Tambah pallet
        $('#addPalletForm').on('submit', function(e) {
            e.preventDefault();
            $.post(routeList.store, $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#palletTable').DataTable().ajax.reload();
                    $('#addPalletForm')[0].reset();
                } else {
                    Swal.fire('Gagal', res.error || 'Pallet mover gagal disimpan', 'error');
                }
            });
        });

        // Edit pallet
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            $.get(`${routeList.detail}/${id}`, function(data) {
                $('#editPalletId').val(id);
                $('#editNomorUnit').val(data.data.nomor_unit);
                $('#editDepartemen').val(data.data.departemen);
                $('#editStatus').val(data.data.status);
                $('#editDescription').val(data.data.description);
                $('#editPalletModal').modal('show');
            });
        });

        $('#editPalletForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editPalletId').val();
            const formData = $(this).serialize();

            $.ajax({
                url: `${routeList.update}/${id}`,
                type: 'PUT',
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Berhasil', res.message, 'success');
                        $('#palletTable').DataTable().ajax.reload();
                        $('#editPalletModal').modal('hide');
                    } else {
                        Swal.fire('Gagal', res.error || 'Gagal update pallet mover', 'error');
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    Swal.fire('Error', res?.error || 'Terjadi kesalahan saat update', 'error');
                }
            });
        });

        // Delete
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const unit = $(this).data('unit');

            Swal.fire({
                title: `Hapus ${unit}?`,
                text: "Pallet mover akan dihapus beserta semua assignment-nya.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${routeList.delete}/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: routeList.csrf
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Dihapus', res.message, 'success');
                                $('#palletTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Gagal', res.message || 'Gagal menghapus', 'error');
                            }
                        },
                        error: function(xhr) {
                            const res = xhr.responseJSON;
                            Swal.fire('Error', res?.error || 'Terjadi kesalahan saat menghapus', 'error');
                        }
                    });
                }
            });
        });

        // Edit assignment
        $(document).on('click', '.edit-assignment-btn', function() {
            const id = $(this).data('id');
            const unit = $(this).data('unit');
            $('#editPalletAssignmentId').val(id);
            $('#editPalletAssignmentLabel').text(`Edit Assignment - ${unit}`);

            $.get(`${routeList.assignmentDetail}/${id}/assignment`, function(res) {
                let operatorOptions = '';
                res.operators.forEach(op => {
                    operatorOptions += `<option value="${op.id}">${op.username} (${op.nik})</option>`;
                });

                $('#editPrimaryOperatorSelect').html(operatorOptions).val(res.primary_operator_id);
                $('#editBackupOperatorsSelect').html(operatorOptions).val(res.backup_operator_ids);
                $('#editPalletAssignmentModal').modal('show');
            });
        });

        $('#editPalletAssignmentForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editPalletAssignmentId').val();

            $.post(`${routeList.assignmentUpdate}/${id}`, $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#palletTable').DataTable().ajax.reload();
                    $('#editPalletAssignmentModal').modal('hide');
                } else {
                    Swal.fire('Gagal', res.error || 'Gagal update assignment', 'error');
                }
            }).fail(function(xhr) {
                const res = xhr.responseJSON;
                Swal.fire('Error', res?.error || 'Terjadi kesalahan saat update assignment', 'error');
            });
        });
    });
</script>

@endsection