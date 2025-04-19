@extends('layout')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">QC Pasteurisasi 1 - After Cooling</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pasteurisasi 1</a></li>
                            <li class="breadcrumb-item active">After Cooling</li>
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
                        <h5 class="card-title flex-grow-1 mb-0">Data After Cooling</h5>

                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-3">
                                <table class="table table-bordered text-center align-middle table-wrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Tanggal</th>
                                            <th rowspan="2">Created By</th>
                                            <th colspan="10">Detail After Cooling</th>
                                        </tr>
                                        <tr>
                                            <th>Shift</th>
                                            <th>Brix</th>
                                            <th>Viscositas</th>
                                            <th>Aw</th>
                                            <th>pH</th>
                                            <th>Bj</th>
                                            <th>Buih</th>
                                            <th>Endapan</th>
                                            <th>Organo</th>
                                            <th>Warna</th>
                                        </tr>
                                    </thead>
                                    <tbody id="afterCoolingData">
                                        <!-- Data dari JavaScript akan ditambahkan di sini -->
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
    let allData = []; // Menyimpan semua data hasil fetch
    let currentPage = 1;
    const rowsPerPage = 5;
    let totalPages = 1;

    function renderTablePage(page) {
        const tbody = document.getElementById('afterCoolingData');
        tbody.innerHTML = "";

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = allData.slice(start, end);

        let no = start + 1;

        pageData.forEach(item => {
            const rowSpan = item.details.length;

            item.details.forEach((detail, index) => {
                const tr = document.createElement('tr');

                if (index === 0) {
                    tr.innerHTML += `
                        <td rowspan="${rowSpan}">${no++}</td>
                        <td rowspan="${rowSpan}">${item.tanggal}</td>
                        <td rowspan="${rowSpan}">${item.created_by_user}</td>
                    `;
                }

                tr.innerHTML += `
                    <td>${detail.shift}</td>
                    <td>${detail.brix}</td>
                    <td>${detail.viscositas}</td>
                    <td>${detail.aw}</td>
                    <td>${detail.ph}</td>
                    <td>${detail.bj}</td>
                    <td>${detail.buih}</td>
                    <td>${detail.endapan}</td>
                    <td>${detail.organo}</td>
                    <td>${detail.warna}</td>
                `;

                tbody.appendChild(tr);
            });
        });
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
            renderTablePage(currentPage);
            updatePagination();
        }
    });

    $(document).on("click", ".pagination-next", function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            renderTablePage(currentPage);
            updatePagination();
        }
    });

    $(document).on("click", ".page-item", function(e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page) {
            currentPage = page;
            renderTablePage(currentPage);
            updatePagination();
        }
    });

    // Ambil data dari API dan inisialisasi
    fetch('{{ url("/qc/all/data") }}')
        .then(response => response.json())
        .then(data => {
            allData = data;
            totalPages = Math.ceil(allData.length / rowsPerPage);
            renderTablePage(currentPage);
            updatePagination();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    // Mengambil data completed / not completed
    function gettotalcompleted() {
        $.ajax({
            type: "GET",
            url: "{{ url('/qc/data/status') }}",
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
</script>




@endsection