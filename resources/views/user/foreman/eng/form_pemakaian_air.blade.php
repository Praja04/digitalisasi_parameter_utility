@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Selamat Datang, {{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Mari tingkatkan kualitas agar menjadi perusahan makanan kelas dunia.</p>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <form action="javascript:void(0);">
                            <div class="row g-3 mb-0 align-items-center">
                                <div class="col-sm-auto">
                                    <div class="input-group">
                                        <input id="date-picker" type="text" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                        <div class="input-group-text bg-primary border-primary text-white">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-auto">
                                    <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn shadow-none"><i class="ri-pulse-line"></i></button>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>

        <!-- FORM INPUT PEMAKAIAN AIR -->
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Pemakaian Air</h5>
                    </div>
                    <div class="card-body">
                        <form id="formTambahPemakaianAir" autocomplete="off">
                            @csrf
                            <div id="api-key-error-msg" class="alert alert-danger py-2 d-none"></div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal">
                            </div>

                            <div class="mb-3">
                                <label for="pemakaian_liter_awal" class="form-label">Pemakaian Air Awal (Liter) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="pemakaian_liter_awal" placeholder="Masukkan nilai...">
                            </div>

                            <div class="mb-3">
                                <label for="pemakaian_liter_akhir" class="form-label">Pemakaian Air Akhir (Liter) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="pemakaian_liter_akhir" placeholder="Masukkan nilai...">
                            </div>

                            <div class="mb-3">
                                <label for="jenis_pemakaian" class="form-label">Jenis Pemakaian <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenis_pemakaian" name="jenis_pemakaian" required>
                                    <option value="Outlet Storage RO">Outlet Storage RO</option>
                                    <option value="Outlet Storage RO Reject">Outlet Storage RO Reject</option>
                                    <option value="Outlet Fresh Water 1">Outlet Fresh Water 1</option>
                                    <option value="Outlet Fresh Water 2">Outlet Fresh Water 2</option>
                                    <option value="WWTP - Boiler - Fasum3">WWTP - Boiler - Fasum3</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <input type="text" class="form-control" id="notes" placeholder="Opsional...">
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary" id="save-button">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        let baseUrl = "{{ url('eng/data/air') }}";
        let csrfToken = $('meta[name="csrf-token"]').attr("content");

        $("#save-button").on("click", function() {
            let formData = {
                _token: csrfToken,
                tanggal: $("#tanggal").val(),
                pemakaian_liter_awal: $("#pemakaian_liter_awal").val(),
                pemakaian_liter_akhir: $("#pemakaian_liter_akhir").val(),
                jenis_pemakaian: $("#jenis_pemakaian").val(),
                notes: $("#notes").val() || "-"
            };

            $.ajax({
                url: `${baseUrl}/store`,
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#formTambahPemakaianAir")[0].reset();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                    });
                },
            });
        });

        function updateDateTime() {
            let now = new Date();
            let formattedDate = now.toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            });
            $('#date-picker').val(formattedDate);
        }

        updateDateTime()
    });
</script>
@endsection