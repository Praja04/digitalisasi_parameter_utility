@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Welcome ,{{Session::get('username')}}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>

                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="apiKeyList">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Pemakaian Listrik</h5>
                        <div class="d-flex gap-1 flex-wrap">

                            <button type="button" class="btn btn-info create-btn" data-bs-toggle="modal" data-bs-target="#batch-listrik"><i class="ri-add-line align-bottom me-1"></i>Pemakaian Listrik</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-3">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Waktu</th>
                                            <th scope="col">Operator</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all text-center" id="listrikList">

                                    </tbody>
                                </table>
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ API Keys We did not find any API for you search.</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>
</div>

<div class="modal fade" id="batch-listrik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pemakaian Listrik</h5>
                <button type="button" class="btn-close" id="close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPemakaianListrik" autocomplete="off">
                    <div id="api-key-error-msg" class="alert alert-danger py-2 d-none"></div>

                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="waktu">
                    </div>
                    <div class="mb-3">
                        <label for="operator" class="form-label">Operator<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="operator">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-primary" id="save-button">Save Changes</button>
                </div>
            </div>
        </div>
        <!-- modal content -->
    </div>
</div>
<script>
    $(document).ready(function() {
        let currentPage = 1;
        let perPage = 10;
        let totalPages = 1;
        let listrikData = [];

        function renderTable() {
            let start = (currentPage - 1) * perPage;
            let paginatedData = listrikData.slice(start, start + perPage);
            let rows = '';

            paginatedData.forEach((listrik, index) => {
                let detailUrl = `{{ route('listrik.data_detail', ['id' => '__ID__']) }}`.replace('__ID__', listrik.id);
                let deleteUrl = `{{ route('listrik.update', ['id' => '__ID__']) }}`.replace('__ID__', listrik.id);
                let rowNumber = (currentPage - 1) * perPage + (index + 1);

                let waktuFormatted = listrik.waktu ? listrik.waktu : '-';
                let operatorFormatted = listrik.operator ? listrik.operator : '-';
                let status = '';
                if (listrik.status === 'completed') {
                    status = 'completed';
                } else {
                    status = 'pending';
                }

                rows += `
        <tr id="listrik-${listrik.id}">
            <td>${rowNumber}</td>
            <td class="waktu">${waktuFormatted}</td>
            <td class="operator">${operatorFormatted}</td>
            <td class="status">
                ${status === 'completed' ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-warning">Pending</span>'}
            </td>
            <td>
                <a href="${detailUrl}" class="btn btn-info btn-sm">Detail</a>
                <button class="btn btn-danger btn-sm delete-listrik" data-url="${deleteUrl}">Hapus</button>
            </td>
        </tr>`;
            });

            $('#listrikList').html(rows);

            if (listrikData.length === 0) {
                $('.noresult').show();
            } else {
                $('.noresult').hide();
            }

            updatePagination();
        }


        function updatePagination() {
            let paginationHtml = '';

            $('.pagination-prev').toggleClass('disabled', currentPage === 1);
            $('.pagination-next').toggleClass('disabled', currentPage === totalPages);

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                               <a class="page-link pagination-number" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }

            $('.pagination').html(paginationHtml);
        }

        function loadBatches() {
            $.get("{{ route('listrik.data') }}", function(response) {
                listrikData = response;
                totalPages = Math.ceil(listrikData.length / perPage);
                currentPage = 1;
                renderTable();
            });
        }

        $(document).on('click', '.pagination-prev', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        $(document).on('click', '.pagination-next', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        $(document).on('click', '.pagination-number', function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            if (page !== currentPage) {
                currentPage = page;
                renderTable();
            }
        });

        loadBatches();

        // Tambah Batch dengan SweetAlert
        $('#save-button').on('click', function() {
            let waktu = $('#waktu').val();
            let operator = $('#operator').val();

            if (!waktu || !operator) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Semua bidang wajib diisi!'
                });
                return;
            }

            $.ajax({
                url: "{{ route('listrik.store') }}",
                type: "POST",
                data: {
                    waktu: waktu,
                    operator: operator,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire('Sukses!', 'Data berhasil ditambahkan!', 'success');
                    $('#batch-listrik').modal('hide');
                    setInterval(function() {
                        location.reload();
                    }, 3000);
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'Gagal menambahkan Data .';
                    Swal.fire('Error!', errorMsg, 'error');
                }
            });
        });


    });
</script>
@endsection