@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Info Header -->
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <h4 class="fs-16 mb-1">Detail Pemakaian Listrik</h4>
                <p class="text-muted mb-0">Waktu: <strong>{{ $listrik->waktu }}</strong> | Operator: <strong>{{ $listrik->operator }}</strong></p>
            </div>
        </div>

        <!-- Detail Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="detailListrikCard">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Pemakaian</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-detail-listrik">
                            <i class="ri-add-line align-bottom me-1"></i>Tambah Detail
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Panel</th>
                                    <th>Volt (V)</th>
                                    <th>Arus (A)</th>
                                    <th>Daya (kW)</th>
                                    <th>Energi (MWh)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="detailListrikTable">
                                <!-- Loaded via JS -->
                            </tbody>
                        </table>
                        <div class="noresult text-center mt-3" style="display: none;">
                            <p class="text-muted">Belum ada data detail pemakaian listrik.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Detail -->
        <div class="modal fade" id="modal-detail-listrik" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formDetailListrik" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailLabel">Tambah Data Panel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_listrik" value="{{ $listrik->id }}">
                        <div class="mb-3">
                            <label for="panel_type" class="form-label">Panel</label>
                            <select id="panel_type" class="form-select" required>
                                <option value="">Pilih Panel</option>
                                @foreach(['MDP','COS','SDP1','SDP2','SDP3','SDP4','SDP5','SDP6','SDP7','SDP8','SDP9','SDP10','SDP11','SDP12','SDP13','SDP14'] as $panel)
                                <option value="{{ $panel }}">{{ $panel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="volt" class="form-label">Volt (V)</label>
                                <input type="number" step="0.01" class="form-control" id="volt" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="a" class="form-label">Arus (A)</label>
                                <input type="number" step="0.01" class="form-control" id="a" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kw" class="form-label">Daya (kW)</label>
                                <input type="number" step="0.01" class="form-control" id="kw" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mwh" class="form-label">Energi (MWh)</label>
                                <input type="number" step="0.01" class="form-control" id="mwh" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Section -->
<script>
    $(document).ready(function() {
        const listrikId = $('#listrik_id').val();
        const id_listrik = "{{ $listrik->id }}";

        function loadDetailListrik() {
            $.get(`{{ url('eng/api/listrik/detail/${id_listrik}') }}`, function(data) {
                let html = '';
                data.forEach((item, index) => {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.panel_type}</td>
                            <td>${item.volt}</td>
                            <td>${item.a}</td>
                            <td>${item.kw}</td>
                            <td>${item.mwh}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-delete-detail" data-id="${item.id}">Hapus</button>
                            </td>
                        </tr>`;
                });
                $('#detailListrikTable').html(html);
                $('.noresult').toggle(data.length === 0);
            });
        }

        $('#formDetailListrik').on('submit', function(e) {
            e.preventDefault();

            $.post(`{{ route('listrik.store_detail', $listrik->id) }}`, {
                    _token: '{{ csrf_token() }}',
                    panel_type: $('#panel_type').val(),
                    volt: $('#volt').val(),
                    a: $('#a').val(),
                    kw: $('#kw').val(),
                    mwh: $('#mwh').val()
                })
                .done((res) => {
                    Swal.fire('Sukses', res.message, 'success');
                    $('#modal-detail-listrik').modal('hide');
                    loadDetailListrik();
                    $('#formDetailListrik')[0].reset();
                })
                .fail(err => {
                    let message = 'Terjadi kesalahan.';

                    // Ambil pesan dari response JSON (validasi / custom error)
                    if (err.responseJSON && err.responseJSON.message) {
                        message = err.responseJSON.message;
                    }

                    Swal.fire('Gagal', message, 'error');
                });
        });


        $(document).on('click', '.btn-delete-detail', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/eng/data/listrik/delete/detail/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            loadDetailListrik();
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Tidak dapat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        loadDetailListrik();
    });
</script>
@endsection