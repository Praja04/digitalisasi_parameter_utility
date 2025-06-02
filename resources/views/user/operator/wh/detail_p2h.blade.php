@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h4>Detail Pemeriksaan Forklift</h4>

        <a href="{{ url('/wh/operator/dashboard') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <div class="card">
            <div class="card-body">
                <h5>Informasi Umum</h5>
                <table class="table table-bordered" id="info-general">
                    <tr>
                        <th>Forklift</th>
                        <td id="forklift-name">Loading...</td>
                    </tr>
                    <tr>
                        <th>Shift</th>
                        <td id="shift">Loading...</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td id="tanggal">Loading...</td>
                    </tr>
                    <tr>
                        <th>Operator</th>
                        <td id="operator-name">Loading...</td>
                    </tr>
                </table>

                <h5 class="mt-4">Item Pemeriksaan</h5>
                <table class="table table-bordered" id="check-items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Nilai Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let id = "{{$id}}";
        console.log('ID dari controller:', id);
        // Ganti angka 1 di URL sesuai dengan ID check form yang ingin diambil
        $.ajax({
            url: "{{ url('wh/check-forms') }}/"+id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                // Isi informasi umum
                $('#forklift-name').text(data.forklift.name);
                $('#shift').text(data.shift);
                $('#tanggal').text(data.tanggal);
                $('#operator-name').text(data.operator_name);

                // Isi tabel item pemeriksaan
                let tbody = '';
                if (data.check_form_items.length > 0) {
                    data.check_form_items.forEach(function(item) {
                        tbody += `<tr>
                        <td>${item.check_item.name}</td>
                        <td>${item.condition_value}</td>
                        <td>${item.remarks}</td>
                    </tr>`;
                    });
                } else {
                    tbody = '<tr><td colspan="3">Tidak ada data item pemeriksaan.</td></tr>';
                }
                $('#check-items-table tbody').html(tbody);
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data: ' + error);
                $('#forklift-name, #shift, #tanggal, #operator-name').text('-');
                $('#check-items-table tbody').html('<tr><td colspan="3">Gagal memuat data item pemeriksaan.</td></tr>');
            }
        });
    });
</script>
@endsection