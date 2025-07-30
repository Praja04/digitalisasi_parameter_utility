@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <h4 class="mb-0">📦 Forklift Registration & Assignment</h4>
        </div>

        {{-- Section: Tambah Forklift --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Tambah Forklift</span>
                <button type="submit" form="addForkliftForm" class="btn btn-primary btn-sm">Simpan Forklift</button>
            </div>
            <div class="card-body">
                <form id="addForkliftForm">
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

        {{-- Section: Data Forklift --}}
        <div class="card">
            <div class="card-header">Daftar Forklift Terdaftar</div>
            <div class="card-body">
                <!-- Tambahkan wrapper untuk horizontal scroll di mobile -->
                <div class="table-responsive">
                    <table id="forkliftTable" class="table table-bordered table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Deskripsi</th>
                                <th>Operator Utama</th>
                                <th>Jumlah Cadangan</th>
                                <th>Waktu Buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- AJAX akan inject data di sini --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Assignment Operator --}}
<div class="modal fade" id="assignmentModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="assignmentForm" class="modal-content">
            @csrf
            <input type="hidden" name="forklift_id" id="forkliftId">
            <div class="modal-header">
                <h5 class="modal-title">🛠️ Assign Operator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Pilih Operator</label>
                    <select class="form-select" name="user_id" id="userSelect">
                        @foreach($operators as $user)
                        <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->nik }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="is_primary" class="form-label">Tipe Assignment</label>
                    <select name="is_primary" class="form-select">
                        <option value="1">Primary</option>
                        <option value="0">Backup</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
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

<div class="modal fade" id="editForkliftModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForkliftForm" class="modal-content">
            @csrf
            <input type="hidden" name="forklift_id" id="editForkliftId">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Forklift</h5>
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

<!-- Modal Detail Cadangan -->
<div class="modal fade" id="backupModal" tabindex="-1" aria-labelledby="backupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backupModalLabel">Cadangan Forklift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="backupModalBody">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAssignmentModal" tabindex="-1" aria-labelledby="editAssignmentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAssignmentForm" class="modal-content">
            @csrf
            <input type="hidden" name="forklift_id" id="editAssignmentForkliftId">
            <div class="modal-header">
                <h5 class="modal-title" id="editAssignmentLabel">Edit Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Operator Utama</label>
                    <select name="primary_operator_id" id="primaryOperatorSelect" class="form-select" required></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cadangan Operator</label>
                    <select name="backup_operator_ids[]" id="backupOperatorsSelect" class="form-select"></select>
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
        // Load Forklift ke DataTable dengan pengaturan responsif yang lebih baik
        $('#forkliftTable').DataTable({
            ajax: '{{ route("wh.forklift.data") }}',
            responsive: true,
            scrollX: true,
            autoWidth: false,
            columnDefs: [{
                    targets: -1, // Kolom terakhir (Aksi)
                    orderable: false,
                    className: 'text-center',
                    width: '200px'
                },
                {
                    targets: [4], // Kolom cadangan
                    className: 'text-center',
                    width: '80px'
                },
                {
                    targets: [1], // Status
                    width: '80px'
                },
                {
                    targets: [2], // Departemen
                    width: '100px'
                }
            ],
            columns: [{
                    data: 'nomor_unit',
                    width: '100px'
                },
                {
                    data: 'status',
                    render: function(data) {
                        let badgeClass = 'bg-success';
                        if (data === 'maintenance') badgeClass = 'bg-warning';
                        if (data === 'inactive') badgeClass = 'bg-danger';
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    }
                },
                {
                    data: 'departemen'
                }, 
                {
                    data: 'notes',
                    render: function(data) {
                        return data;
                    }
                } ,{
                    data: 'primary_operator',
                    render: function(data) {
                        return data || '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'backup_count',
                    render: function(count, _, row) {
                        return `
                            <span class="badge bg-info backup-detail-btn" 
                                style="cursor: pointer;" 
                                data-id="${row.id}" 
                                data-unit="${row.nomor_unit}">
                                ${count}
                            </span>
                        `;
                    }
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: 'id',
                    render: function(id, _, row) {
                        return `
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-primary assign-btn" data-id="${id}" data-unit="${row.nomor_unit}" title="Assign Operator">
                                   Assign Operator
                                </button>
                                <button class="btn btn-sm btn-info edit-assignment-btn" data-id="${id}" data-unit="${row.nomor_unit}" title="Edit Assignment">
                                    Edit Assignment
                                </button>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${id}" title="Edit Forklift">
                                    Edit Forklift
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${id}" data-unit="${row.nomor_unit}" title="Delete">
                                    Delete Data
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                "decimal": "",
                "emptyTable": "Tidak ada data tersedia",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ total entri)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "loadingRecords": "Memuat...",
                "processing": "Memproses...",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "aria": {
                    "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                    "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
        });

        // Event handlers tetap sama seperti sebelumnya
        $('#forkliftTable').on('click', '.backup-detail-btn', function() {
            const forkliftId = $(this).data('id');
            const unit = $(this).data('unit');

            $.ajax({
                url: "{{url('wh/forklift')}}/" + forkliftId + "/backups",
                method: 'GET',
                success: function(response) {
                    let list = '';
                    response.backups.forEach(op => {
                        list += `<li>${op.username} (${op.nik})</li>`;
                    });

                    $('#backupModalLabel').text(`Cadangan - ${unit}`);
                    $('#backupModalBody').html(`<ul>${list}</ul>`);
                    $('#backupModal').modal('show');
                },
                error: function() {
                    $('#backupModalBody').html('<p class="text-danger">Gagal memuat data cadangan.</p>');
                    $('#backupModal').modal('show');
                }
            });
        });

        // Open modal assignment
        $(document).on('click', '.assign-btn', function() {
            $('#forkliftId').val($(this).data('id'));
            $('#assignmentModal').modal('show');
        });

        // Handle submit assignment
        $('#assignmentForm').on('submit', function(e) {
            e.preventDefault();
            $.post('{{ route("wh.forklift.assignment.store") }}', $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Success', res.message, 'success');
                    $('#forkliftTable').DataTable().ajax.reload();
                    $('#assignmentModal').modal('hide');
                } else {
                    Swal.fire('Error', res.message || 'Gagal menyimpan', 'error');
                }
            });
        });

        // Forklift creation handler
        $('#addForkliftForm').on('submit', function(e) {
            e.preventDefault();
            $.post('{{ route("wh.forklift.store") }}', $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#forkliftTable').DataTable().ajax.reload();
                    $('#addForkliftForm')[0].reset();
                } else {
                    Swal.fire('Gagal', res.error || 'Forklift gagal disimpan', 'error');
                }
            });
        });

        // Open Edit Modal
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            $.get("{{url('/wh/forklift')}}/" + id,
                function(data) {
                    $('#editForkliftId').val(id);
                    $('#editNomorUnit').val(data.nomor_unit);
                    $('#editDepartemen').val(data.departemen);
                    $('#editStatus').val(data.status);
                    $('#editDescription').val(data.description);
                    $('#editForkliftModal').modal('show');
                });
        });

        $('#editForkliftForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#editForkliftId').val();
            const formData = $(this).serialize();

            $.ajax({
                url: "{{url('/wh/forklift')}}/" + id,
                type: 'PUT',
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Berhasil', res.message, 'success');
                        $('#forkliftTable').DataTable().ajax.reload();
                        $('#editForkliftModal').modal('hide');
                    } else {
                        Swal.fire('Gagal', res.error || 'Gagal update forklift', 'error');
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    Swal.fire('Error', res?.error || 'Terjadi kesalahan saat update', 'error');
                }
            });
        });

        // Handle Delete Forklift
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const unit = $(this).data('unit');

            Swal.fire({
                title: `Hapus ${unit}?`,
                text: "Forklift akan dihapus permanen beserta semua assignment-nya.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('wh/forklift')}}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Dihapus', res.message, 'success');
                                $('#forkliftTable').DataTable().ajax.reload();
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

        $(document).on('click', '.edit-assignment-btn', function() {
            const forkliftId = $(this).data('id');
            const unit = $(this).data('unit');
            $('#editAssignmentForkliftId').val(forkliftId);
            $('#editAssignmentLabel').text(`Edit Assignment - ${unit}`);

            $.get("{{url('/wh/forklift')}}/" + forkliftId + "/assignment",
                function(res) {
                    let operatorOptions = '';
                    res.operators.forEach(op => {
                        operatorOptions += `<option value="${op.id}">${op.username} (${op.nik})</option>`;
                    });

                    $('#primaryOperatorSelect').html(operatorOptions).val(res.primary_operator_id);
                    $('#backupOperatorsSelect').html(operatorOptions).val(res.backup_operator_ids);
                    $('#editAssignmentModal').modal('show');
                });
        });

        $('#editAssignmentForm').on('submit', function(e) {
            e.preventDefault();
            $.post('{{ route("wh.forklift.assignment.update") }}', $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#forkliftTable').DataTable().ajax.reload();
                    $('#editAssignmentModal').modal('hide');
                } else {
                    Swal.fire('Gagal', res.error || 'Gagal update assignment', 'error');
                }
            });
        });
    });
</script>

<style>
    /* Custom CSS untuk responsif */
    @media (max-width: 768px) {
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .card-header {
            padding: 0.75rem;
        }

        .card-header .btn {
            font-size: 0.8rem;
            padding: 0.375rem 0.75rem;
        }

        /* Pastikan form tetap rapi di mobile */
        .modal-body .row>.col-md-6 {
            margin-bottom: 1rem;
        }
    }

    /* Perbaikan untuk tombol aksi */
    .btn-group {
        display: flex;
        flex-wrap: nowrap;
    }

    .btn-group .btn {
        border-radius: 0;
        margin-right: 1px;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
        margin-right: 0;
    }

    /* Responsive table wrapper */
    .table-responsive {
        border-radius: 0.375rem;
    }

    /* DataTables responsive styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: center;
            margin-bottom: 0.5rem;
        }
    }
</style>

@endsection