<!-- resources/views/check_forms/index.blade.php -->

@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h4>Pemeriksaan Forklift</h4>
        <button class="btn btn-primary mb-3" id="btnTambah">+ Tambah Pemeriksaan</button>

        <table class="table table-bordered" id="tableCheckForms">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Forklift</th>
                    <th>Shift</th>
                    <th>Tanggal</th>
                    <th>Operator</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formCheck">
            @csrf
            <input type="hidden" id="form_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pemeriksaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Forklift</label>
                        <select class="form-control" id="forklift_id"></select>
                    </div>
                    <div class="mb-3">
                        <label>Shift</label>
                        <select class="form-control" id="shift">
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                            <option value="Shift 3">Shift 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label>Nama Operator</label>
                        <input type="text" class="form-control" id="operator_name">
                    </div>

                    <h5>Item Pemeriksaan</h5>
                    <div id="check_items_container"></div>
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
    let checkItems = [],
        forklifts = [];

    $(document).ready(function() {
        loadData();

        // Tombol Tambah
        $('#btnTambah').on('click', function() {
            $('#form_id').val('');
            $('#formCheck')[0].reset();

            // Ambil ulang data sebelum render form
            fetchFormData(() => {
                renderCheckItems(); // render setelah checkItems tersedia
                $('#modalForm').modal('show');
            });
        });

        // Submit Form
        $('#formCheck').on('submit', function(e) {
            e.preventDefault();
            let id = $('#form_id').val();
            let url = id ? `/wh/check-forms/${id}` : '/wh/check-forms';
            let method = id ? 'PUT' : 'POST';

            let items = [];
            $('.item-row').each(function() {
                items.push({
                    item_id: $(this).data('id'),
                    condition_value: $(this).find('.condition_value').val(),
                    remarks: $(this).find('.remarks').val(),
                });
            });

            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    forklift_id: $('#forklift_id').val(),
                    shift: $('#shift').val(),
                    tanggal: $('#tanggal').val(),
                    operator_name: $('#operator_name').val(),
                    check_items: items
                }),
                success: function(res) {
                    $('#modalForm').modal('hide');
                    loadData();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan.');
                }
            });
        });
    });

    // Ambil data forklift dan item pemeriksaan
    function fetchFormData(callback) {
        $.get('/wh/check-forms/form-data', function(res) {
            forklifts = res.forklifts;
            checkItems = res.checkItems;

            // Isi select forklift
            $('#forklift_id').empty();
            forklifts.forEach(f => {
                $('#forklift_id').append(`<option value="${f.id}">${f.name}</option>`);
            });

            if (typeof callback === 'function') callback();
        });
    }

    // Render input untuk item pemeriksaan
    function renderCheckItems(values = {}) {
        let html = '';
        checkItems.forEach(item => {
            let val = values[item.id] || {};
            html += `
                <div class="row mb-2 item-row" data-id="${item.id}">
                    <div class="col-4">
                        <label class="form-label">${item.name}</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control condition_value" value="${val.condition_value || ''}" placeholder="Nilai Kondisi">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control remarks" value="${val.remarks || ''}" placeholder="Keterangan">
                    </div>
                </div>
            `;
        });
        $('#check_items_container').html(html);
    }

    // Ambil dan tampilkan data pemeriksaan
    function loadData() {
        $.get('/wh/check-forms', function(res) {
            let rows = '';
            res.forEach((d, i) => {
                rows += `<tr>
                    <td>${i + 1}</td>
                    <td>${d.forklift.name}</td>
                    <td>${d.shift}</td>
                    <td>${d.tanggal}</td>
                    <td>${d.operator_name}</td>
                    <td>
                        <a href="{{url('/wh/operator/detail/p2h/${d.id}')}}" class="btn btn-sm btn-info">Detail</a>
                        <button class="btn btn-sm btn-warning" onclick="editData(${d.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteData(${d.id})">Hapus</button>
                    </td>
                </tr>`;
            });
            $('#tableCheckForms tbody').html(rows);
        });
    }

    // Edit data
    function editData(id) {
        $.get(`/wh/check-forms/${id}`, function(data) {
            $('#form_id').val(data.id);
            $('#forklift_id').val(data.forklift_id);
            $('#shift').val(data.shift);
            $('#tanggal').val(data.tanggal);
            $('#operator_name').val(data.operator_name);

            let values = {};
            data.check_form_items.forEach(item => {
                values[item.check_item_id] = {
                    condition_value: item.condition_value,
                    remarks: item.remarks
                };
            });

            fetchFormData(() => {
                renderCheckItems(values);
                $('#modalForm').modal('show');
            });
        });
    }

    // Hapus data
    function deleteData(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: `/wh/check-forms/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function() {
                    loadData();
                }
            });
        }
    }
</script>

@endsection