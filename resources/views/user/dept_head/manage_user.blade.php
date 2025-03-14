@extends('layout')
@section('dynamic_url', 'st53/realtime-tankA')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div
                    class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Team</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Pages</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Team
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-sm-4">
                        <div class="search-box">
                            <input type="text" class="form-control" id="searchMemberList" placeholder="Search for name or designation..." />
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">
                            <button type="button" id="grid-view-button" class="btn btn-soft-info nav-link btn-icon fs-14 active filter-button shadow-none">
                                <i class="ri-grid-fill"></i>
                            </button>
                            <button type="button" id="list-view-button" class="btn btn-soft-info nav-link btn-icon fs-14 filter-button shadow-none">
                                <i class="ri-list-unordered"></i>
                            </button>
                            <button type="button" class="btn btn-success addMembers-modal" data-bs-toggle="modal" data-bs-target="#addmemberModal">
                                <i class="ri-add-fill me-1 align-bottom"></i> Add Members
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div id="teamlist">
                    <div class="team-list grid-view-filter row" id="team-member-list"></div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addmemberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-body">
                        <form id="memberlist-form" class="needs-validation" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <div class="avatar-lg">
                                                <img src="{{ asset('material/assets/images/users/user-dummy-img.jpg') }}" id="member-img" class="avatar-md rounded-circle h-auto" />
                                            </div>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label for="member-image-input" class="mb-0" title="Select Member Image">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                            <i class="ri-image-fill"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input class="form-control d-none" id="member-image-input" type="file" name="image" accept="image/png, image/gif, image/jpeg" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="teammembersName" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="teammembersName" name="username" placeholder="Enter name" required />
                                        <div class="invalid-feedback">Please enter a member name.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
                                        <div class="invalid-feedback">Please enter a valid email.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter email" required />
                                        <div class="invalid-feedback">Please enter a password</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="designation" class="form-label">Jabatan</label>
                                        <select class="form-control" id="designation" name="jabatan" required>
                                            <option value="" disabled selected>Pilih Jabatan</option>
                                            <option value="dept_head">Head of Departemen</option>
                                            <option value="foreman">Foreman</option>
                                            <option value="supervisor">Supervisor</option>
                                            <option value="operator">Operator</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a Jabatan.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="departemen" class="form-label">Departemen</label>
                                        <select class="form-control" id="departemen" name="departemen" required>
                                            <option value="" disabled selected>Pilih Departemen</option>
                                            <option value="engineering">Engineering</option>
                                            <option value="qc">QC</option>
                                            <option value="produksi">Produksi</option>
                                            <option value="warehouse">Warehouse</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a Departemen.</div>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Add Member</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMemberLabel">Edit Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMemberForm">
                            <input type="hidden" id="editUserId" name="user_id">

                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="editJabatan" class="form-label">Jabatan</label>
                                <select class="form-control" id="editJabatan" name="jabatan" required>
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    <option value="dept_head">Head Departemen</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="foreman">Foreman</option>
                                    <option value="operator">Operator</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="editDepartemen" class="form-label">Departemen</label>
                                <select class="form-control" id="editDepartemen" name="departemen" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    <option value="engineering">Engineering</option>
                                    <option value="qc">QC</option>
                                    <option value="produksi">Produksi</option>
                                    <option value="warehouse">Warehouse</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Password (Opsional)</label>
                                <input type="password" class="form-control" id="editPassword" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="editImage" class="form-label">Upload Foto</label>
                                <input type="file" class="form-control" id="editImage" name="image">
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- container-fluid -->
</div>

<script>
    $(document).ready(function() {

        $("#searchMemberList").on("keyup", function() {
            let searchText = $(this).val().toLowerCase();
            console.log("Search Text:", searchText); // Debugging

            $(".team-box").each(function() {
                let username = $(this).find(".team-content h5").text().toLowerCase();
                let designation = $(this).find(".member-designation").text().toLowerCase();
                let departemen = $(this).find(".member-departemen").text().toLowerCase();

                //console.log("Checking:", username, designation); // Debugging

                if (username.includes(searchText) || designation.includes(searchText) || departemen.includes(searchText)) {
                    $(this).closest(".col").show(); // Pastikan elemen yang berisi card ditampilkan
                } else {
                    $(this).closest(".col").hide();
                }
            });
        });

        $('#memberlist-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '{{ route("users.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait while we save the data.",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: response.success,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#addmemberModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(xhr) {
                    console.error("Error Response:", xhr);

                    let errorMsg = "Failed to add user.";
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join("\n");
                        } else if (xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                    }

                    Swal.fire({
                        title: "Error!",
                        text: errorMsg,
                        icon: "error"
                    });
                }
            });
        });



        $("#grid-view-button").on("click", function() {
            $(this).addClass("active");
            $("#list-view-button").removeClass("active");
            loadUsers(); // Kembali ke tampilan grid
        });

        // List View - Card Simplified
        $("#list-view-button").on("click", function() {
            $(this).addClass("active");
            $("#grid-view-button").removeClass("active");

            $.ajax({
                url: "{{ route('users.get') }}",
                type: "GET",
                success: function(users) {
                    let userList = '';

                    users.forEach(user => {
                        let imageUrl = user.image ?
                            "{{ url('/uploads/users') }}/" + user.image :
                            "{{ asset('material/assets/images/users/user-dummy-img.jpg') }}";

                        userList += `
                        <div class="col-lg-12">
                            <div class="card team-box">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <!-- Profile Image -->
                                        <div class="col-auto">
                                            <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">
                                                <img src="${imageUrl}" alt="" class="member-img img-fluid d-block rounded-circle" style="height:85px;">
                                            </div>
                                        </div>

                                        <!-- Name & Position -->
                                        <div class="col">
                                            <a class="member-name" data-bs-toggle="offcanvas" href="#member-overview" aria-controls="member-overview">
                                                <h5 class="fs-16 mb-1 nama_user">${user.username}</h5>
                                            </a>
                                            <p class="text-muted mb-0">${user.jabatan}</p>
                                        </div>

                                        <!-- Email & Jabatan -->
                                        <div class="col text-center">
                                            <h5 class="mb-1 projects-num">${user.email}</h5>
                                            <p class="text-muted mb-0">Email</p>
                                        </div>
                                        <div class="col text-center">
                                            <h5 class="mb-1 tasks-num">${user.departemen}</h5>
                                            <p class="text-muted mb-0">Departemen</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-auto">
                                            <button class="btn btn-sm btn-primary edit-list" data-bs-toggle="modal" 
                                                data-bs-target="#editMemberModal" data-edit-id="${user.id}" 
                                                data-username="${user.username}" data-jabatan="${user.jabatan}" 
                                                data-email="${user.email}">
                                                <i class="ri-pencil-line"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger remove-list" data-bs-toggle="modal" 
                                                data-bs-target="#removeMemberModal" data-remove-id="${user.id}">
                                                <i class="ri-delete-bin-5-line"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    $('#team-member-list').html(userList);
                },
                error: function(xhr) {
                    console.log("Error fetching data:", xhr.responseText);
                }
            });
        });

        function loadUsers() {
            $.ajax({
                url: "{{ route('users.get') }}",
                type: "GET",
                success: function(users) {
                    let userList = '';
                    users.forEach(user => {
                        let imageUrl = user.image ? "{{ url('/uploads/users') }}/" + user.image : "{{ asset('material/assets/images/users/user-dummy-img.jpg') }}";

                        let randomImageNumber = Math.floor(Math.random() * 10) + 1; // Pilih angka 1-10 secara acak
                        let randomImage = "{{ asset('material/assets/images/small/img-') }}" + randomImageNumber + ".jpg";

                        userList += `
                            <div class="col">
                                <div class="card team-box">
                                    <div class="team-cover">
                                        <img src="${randomImage}" alt="" class="img-fluid">
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row align-items-center team-row">
                                            <div class="col team-settings">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="flex-shrink-0 me-2">
                                                            <button type="button" class="btn btn-light btn-icon rounded-circle btn-sm favourite-btn">
                                                                <i class="ri-star-fill fs-14"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col text-end dropdown">
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill fs-17"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item edit-list" href="#editMemberModal" data-bs-toggle="modal" 
                                                                   data-edit-id="${user.id}" data-username="${user.username}" 
                                                                   data-jabatan="${user.jabatan}" data-email="${user.email}">
                                                                    <i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="${user.id}">
                                                                    <i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col">
                                                <div class="team-profile-img">
                                                    <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">
                                                        <img src="${imageUrl}" alt="" class="member-img img-fluid d-block rounded-circle" style="height:90px;">
                                                    </div>
                                                    <div class="team-content">
                                                        <h5 class="fs-16 mb-1">${user.username}</h5>
                                                        <p class="text-muted member-designation mb-0">${user.jabatan}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col">
                                                <div class="row text-muted text-center">
                                                    <div class="col-12">
                                                        <p class="mb-1">${user.email}</p>
                                                        <p class="text-muted member-departemen mb-0">${user.departemen}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#team-member-list').html(userList);
                },
                error: function(xhr) {
                    console.log("Error fetching data:", xhr.responseText);
                }
            });
        }

        loadUsers(); // Panggil fungsi saat halaman dimuat

        // Set data ke modal edit saat tombol edit diklik
        $(document).on('click', '.edit-list', function() {
            let id = $(this).data('edit-id');
            let username = $(this).data('username');
            let jabatan = $(this).data('jabatan');
            let email = $(this).data('email');
            let password = $(this).data('password');

            $('#editUserId').val(id);
            $('#editUsername').val(username);
            $('#editJabatan').val(jabatan);
            $('#editEmail').val(email);
            $('#editPassword').val(password);
        });

        $('#editMemberForm').submit(function(e) {
            e.preventDefault();

            let userId = $('#editUserId').val();
            let formData = new FormData(this);

            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('_method', 'POST'); // Laravel mendukung PUT/PATCH dengan ini

            Swal.fire({
                title: "Are you sure?",
                text: "You are about to update this user!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Update",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/users') }}/" + userId,

                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: response.success,
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#editMemberModal').modal('hide');
                            setTimeout(() => location.reload(), 2000);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON.message || "Something went wrong!",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });


        $(document).on("click", ".remove-list", function() {
            let userId = $(this).data("remove-id");

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${userId}`,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content") // CSRF token
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.success,
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to delete user.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

    });
</script>

@endsection