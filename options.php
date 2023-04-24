<?php

include_once 'templates/header.php';
$page = 'Options - Banner';

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

                        <form id="option" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="item-name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-description">Description:</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="banner-cta">CTA:</label>
                                    <select class="form-control" id="cta" name="cta">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cta-text">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="cta-text">Subtitle:</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="cta-text">CTA Text:</label>
                                    <input type="text" class="form-control" id="cta_text" name="cta_text" value="Click here" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="cta-text">CTA Link:</label>
                                    <input type="text" class="form-control" id="cta_link" name="cta_link" placeholder="Input URL" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="cta-position">CTA Position:</label>
                                    <select class="form-control" id="cta_position" name="cta_position" disabled>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cta-position">CTA Color Text:</label>
                                    <select class="form-control" id="cta_color" name="cta_color" disabled>
                                        <option value="black">Black</option>
                                        <option value="white">White</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image:</label>
                                    <input type="file" name="image" id="image" accept="image/*" class="form-control-file">
                                    <img id="image-preview" src="" class="img-fluid" alt="Image Preview" width="800" height="400">
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
                                <table class="table" id="option-list">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Thumbnail</th>
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
        $('#cta').change(function() {
            if ($(this).val() === '0') {
                $('#title').prop('disabled', true);
                $('#subtitle').prop('disabled', true);
                $('#cta_text').prop('disabled', true);
                $('#cta_link').prop('disabled', true);
                $('#cta_position').prop('disabled', true);
                $("#title").val(data.title);
                $("#subtitle").val(data.subtitle);
                $("#cta").val(data.cta);
                $("#cta_text").val(data.cta_text);
                $("#cta_position").val(data.cta_position);
            } else {
                $('#title').prop('disabled', false);
                $('#subtitle').prop('disabled', false);
                $('#cta_text').prop('disabled', false);
                $('#cta_link').prop('disabled', false);
                $('#cta_position').prop('disabled', false);
                $("#title").val(data.title);
                $("#subtitle").val(data.subtitle);
                $("#cta").val(data.cta);
                $("#cta_text").val(data.cta_text);
                $("#cta_position").val(data.cta_position);
            }
        });
        fetchData();
        $('#image-preview').hide();
    });

    // Create
    $(document).on("submit", "#option", function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "option/create.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        text: "Thumbnail saved successfully."
                    }).then(function() {
                        fetchData();
                        $("#form-modal").modal("hide");
                    });
                    $("#id").val('');
                    $("#name").val('');
                    $("#description").val('');
                    $("#image").val('');
                    $("#cta").val('0');
                    $("#title").val('');
                    $("#subtitle").val('');
                    $("#cta_text").val('');
                    $("#cta_link").val('');
                    $("#cta_position").val('left');
                    $("#cta_color").val('black');
                    $('#title').prop('disabled', true);
                    $('#subtitle').prop('disabled', true);
                    $('#cta_text').prop('disabled', true);
                    $('#cta_position').prop('disabled', true);
                    $('#cta_color').prop('disabled', true);
                    $('#image-preview').hide();
                    $("#form-header").removeClass("card-warning").addClass("card-success");
                    $('#form-title').text('Add');
                    $("#cancelBtn").hide();
                } else {
                    Swal.fire({
                        icon: "error",
                        text: result.message
                    });
                }
                $("#option")[0].reset();
                fetchData();
            }
        });
    });


    // Edit
    $(document).on("click", ".editBtn", function() {
        var id = $(this).data("id");
        $.ajax({
            url: "option/edit.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.cta == '0') {
                    $('#title').prop('disabled', true);
                    $('#subtitle').prop('disabled', true);
                    $('#cta_text').prop('disabled', true);
                    $('#cta_link').prop('disabled', true);
                    $('#cta_position').prop('disabled', true);
                    $('#cta_color').prop('disabled', true);
                } else {
                    $('#title').prop('disabled', false);
                    $('#subtitle').prop('disabled', false);
                    $('#cta_text').prop('disabled', false);
                    $('#cta_link').prop('disabled', false);
                    $('#cta_position').prop('disabled', false);
                    $('#cta_color').prop('disabled', false);
                }
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#description").val(data.description);
                $("#image-preview").attr('src', data.image_url);
                $("#title").val(data.title);
                $("#subtitle").val(data.subtitle);
                $("#cta").val(data.cta);
                $("#cta_text").val(data.cta_text);
                $("#cta_link").val(data.cta_link);
                $("#cta_position").val(data.cta_position);
                $("#cta_color").val(data.cta_color);
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
        $("#image-preview").attr("src", '');
        $("#cta").val('0');
        $("#title").val('');
        $("#subtitle").val('');
        $("#cta_text").val('');
        $("#cta_position").val('left');
        $('#title').prop('disabled', true);
        $('#subtitle').prop('disabled', true);
        $('#cta_text').prop('disabled', true);
        $('#cta_link').prop('disabled', true);
        $('#cta_position').prop('disabled', true);
        $('#cta_color').prop('disabled', true);
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
                    url: "option/delete.php",
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
            url: "option/fetch.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                var table = $('#option-list').DataTable();
                table.clear();
                $.each(data, function(index, row) {
                    table.row.add([
                        row.id,
                        row.name,
                        '<img src="' + row.image_url + '" width="50" height="50">',
                        '<button class="editBtn btn btn-primary" data-id="' + row.id + '">Edit</button> <button class="deleteBtn btn btn-danger" data-id="' + row.id + '">Delete</button>'
                    ]);
                });
                table.draw();
            }
        });
    }
</script>