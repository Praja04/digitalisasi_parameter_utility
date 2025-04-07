@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Produksi Pasteurisasi 1</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pasteurisasi 1</a></li>
                            <li class="breadcrumb-item active">Batch</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
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

        <!-- end page title -->

        <div class="row">

            <div class="col-lg-6">
                <div class="card card-animate card-height-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Completed</p>
                                <h2 class="mt-4 ff-secondary fw-bold"><span class="counter-value batch-completed" data-target=""></span></h2>

                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded-circle fs-2">
                                        <i data-feather="check-circle" class="text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!--end col-->
            <div class="col-lg-6">
                <div class="card card-animate card-height-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Not Completed</p>
                                <h2 class="mt-4 ff-secondary fw-bold"><span class="counter-value batch-not-completed" data-target=""></span></h2>

                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-danger rounded-circle fs-2">
                                        <i data-feather="alert-octagon" class="text-danger"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!--end col-->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="apiKeyList">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">History Batch</h5>

                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-3">
                                <table id="batchTable" class="table text-center align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Batch</th>
                                            <th scope="col">Tanggal Batch</th>
                                            <th scope="col">Target Batch</th>
                                            <th scope="col">Total Batch</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Dibuat pada</th>
                                            <th scope="col">Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                    </tbody>
                                </table>

                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ API Keys We did not find any API for you search.</p>
                                    </div>
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
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>


    </div>
</div>

<script>
    $(document).ready(function() {
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;
        let allData = [];

        function loadBatchData() {
            $.ajax({
                url: "{{ url('/prd/batch') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    allData = data;
                    totalPages = Math.ceil(allData.length / itemsPerPage);
                    updateTable();
                    updatePagination();
                },
                error: function() {
                    console.error("Gagal mengambil data.");
                }
            });
        }

        function updateTable() {
            let tbody = $(".list.form-check-all");
            tbody.empty();

            let start = (currentPage - 1) * itemsPerPage;
            let end = start + itemsPerPage;
            let paginatedData = allData.slice(start, end);

            if (paginatedData.length === 0) {
                $(".noresult").show();
            } else {
                $(".noresult").hide();
                $.each(paginatedData, function(index, batch) {
                    let statusBadgeClass = batch.status === "completed" ? "badge-soft-success" : "badge-soft-danger";
                    let createdDate = new Date(batch.created_at).toLocaleDateString("id-ID");
                    let rowNumber = start + index + 1;
                    let row = `
                    <tr>
                        <td>${rowNumber} %</td>
                        <td>${batch.batch_code}</td>
                        <td>${batch.batch_date}</td>
                        <td>${batch.target_batch}</td>
                        <td>${batch.total_batch_count}</td>
                        <td><span class="badge ${statusBadgeClass}">${batch.status}</span></td>
                        <td>${createdDate}</td>
                        <td>${batch.created_by_user}</td>
                    </tr>
                `;
                    tbody.append(row);
                });
            }
        }

        function updatePagination() {
            let paginationList = $(".listjs-pagination");
            paginationList.empty();

            for (let i = 1; i <= totalPages; i++) {
                let activeClass = i === currentPage ? "active" : "";
                paginationList.append(`<li class="page-item ${activeClass}" data-page="${i}"><a href="#">${i}</a></li>`);
            }

            $(".pagination-prev").toggleClass("disabled", currentPage === 1);
            $(".pagination-next").toggleClass("disabled", currentPage === totalPages);
        }

        // Event Listener untuk Pagination
        $(document).on("click", ".pagination-prev", function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                updatePagination();
            }
        });

        $(document).on("click", ".pagination-next", function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
                updatePagination();
            }
        });

        $(document).on("click", ".page-item", function(e) {
            e.preventDefault();
            let page = $(this).data("page");
            if (page) {
                currentPage = page;
                updateTable();
                updatePagination();
            }
        });

        loadBatchData();

        function gettotalcompleted() {
            $.ajax({
                type: "GET",
                url: "{{ url('/prd/batch-completed') }}",
                dataType: "json",
                success: function(data) {
                    $(".batch-completed").attr("data-target", data.completed).text(data.completed);
                    $(".batch-not-completed").attr("data-target", data.not_completed).text(data.not_completed);
                },
                error: function() {
                    console.error("Gagal mengambil data.");
                }
            });

        }

        gettotalcompleted();
    });
</script>



@endsection