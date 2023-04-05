<?php

include_once 'templates/header.php';
$page = 'User';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $page ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Form -->
                <div class="col-md-6">
                    <div class="card card-success" id="form-header">
                        <div class="card-header">
                            <h3 class="card-title" id="form-title">Add</h3>
                        </div>

                        <form id="user" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="item-name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-price">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-description">Password:</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="showPasswordBtn"><i class="far fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="id" id="id">

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body" style="overflow-x: auto;">
                            <h5 class="card-title border-bottom mb-4">List</h5>
                            <div class="table-body">
                                <table class="table" id="user-list">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include_once 'templates/footer.php'; ?>

<script>
    $(document).ready(function() {
        fetchData();
        $('#showPasswordBtn').click(function() {
            var passwordInput = $('#password');
            var passwordInputType = passwordInput.attr('type');

            if (passwordInputType === 'password') {
                passwordInput.attr('type', 'text');
                $('#showPasswordBtn i').removeClass('far fa-eye').addClass('far fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                $('#showPasswordBtn i').removeClass('far fa-eye-slash').addClass('far fa-eye');
            }
        });
    });


    // Create
    $(document).on("submit", "#user", function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "user/create.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        text: "Record saved successfully."
                    }).then(function() {
                        fetchData();
                        $("#form-modal").modal("hide");
                    });
                    $("#id").val('');
                    $("#name").val('');
                    $("#email").val('');
                    $("#password").val('');
                    $("#form-header").removeClass("card-warning").addClass("card-success");
                    $('#form-title').text('Add');
                    $("#cancelBtn").hide();
                } else {
                    Swal.fire({
                        icon: "error",
                        text: result.message
                    });
                }
                $("#product")[0].reset();
                fetchData();
            }
        });
    });


    // Edit
    $(document).on("click", ".editBtn", function() {
        var id = $(this).data("id");
        $.ajax({
            url: "user/edit.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#password").val(data.password);
                $("#form-header").removeClass("card-success").addClass("card-warning");
                $('#form-title').text('Edit');
                $("#cancelBtn").show();
                $('#image-preview').show();
            }
        });
    });


    $(document).on("click", "#cancelBtn", function() {
        $("#id").val('');
        $("#name").val('');
        $("#description").val('');
        $("#price").val('');
        $("#category").val('');
        $("#subcategory").val('');
        $("#image-preview").attr("src", '');
        $("#form-header").removeClass("card-warning").addClass("card-success");
        $('#form-title').text('Add');
        $("#cancelBtn").hide();
        $('#image-preview').hide();
    });


    $(document).on("click", ".deleteBtn", function() {
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "user/delete.php",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        fetchData();
                    }
                });
            }
        });
    });

    function fetchData() {
        $.ajax({
            url: "user/fetch.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                var table = $('#user-list').DataTable();
                table.clear();
                $.each(data, function(index, row) {
                    table.row.add([
                        row.id,
                        row.name,
                        row.email,
                        '<button class="editBtn btn btn-primary" data-id="' + row.id + '">Edit</button> <button class="deleteBtn btn btn-danger" data-id="' + row.id + '">Delete</button>'
                    ]);
                });
                table.draw();
            }
        });
    }
</script>