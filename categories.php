<?php

include_once 'templates/header.php';
$page = 'Categories';

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

                        <form id="category" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="item-name">Category Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-description">Description:</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <table class="table table-bordered" id="subcategory-table">
                                        <thead>
                                            <tr>
                                                <th>Subcategory Name</th>
                                                <th>Add</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control subcategory-name" name="subcategories[0][name]"></td>
                                                <td><button type="button" class="btn btn-success add-subcategory"><i class="fa fa-plus"></i></button></td>
                                                <td><button type="button" class="btn btn-danger remove-subcategory" disabled><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        </tbody>

                                    </table>

                                </div>
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
                        <div class="card-body">
                            <h5 class="card-title">List</h5>
                            <table class="table" id="category-list">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
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
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include_once 'templates/footer.php'; ?>
<style>
    .subcategory-container {
        background-color: #444444;
        padding: 10px;
    }

    .subcategory-container button {
        margin-top: 10px;
    }
</style>
<script>
    $(document).ready(function() {
        fetchData();
        $("#cancelBtn").hide();
    });

    $(document).on("click", ".remove-subcategory", function() {
        $(this).closest("tr").remove();
        updateSubcategoryIndices();
    });

    $(document).on("click", ".add-subcategory", function() {
        var currentIndex = $(this).closest("tr").index();
        var newIndex = currentIndex + 1;
        var newRow = `
        <tr>
            <td><input type="text" class="form-control subcategory-name" name="subcategories[${newIndex}][name]" required></td>
            <td><button type="button" class="btn btn-success add-subcategory"><i class="fa fa-plus"></i></button></td>
            <td><button type="button" class="btn btn-danger remove-subcategory"><i class="fa fa-trash"></i></button></td>
        </tr>
    `;
        $(this).closest("tr").after(newRow);
        updateSubcategoryIndices();
        $(this).closest("tr").next().find(".remove-subcategory").prop("disabled", false);
    });

    function updateSubcategoryIndices() {
        $("input[name^='subcategories']").each(function() {
            var oldName = $(this).attr("name");
            var newName = oldName.replace(/\[\d+\]/, function(match) {
                return "[" + $(this).closest("tr").index() + "]";
            });
            $(this).attr("name", newName);
        });
    }



    // Create
    $(document).on("submit", "#category", function(event) {
        event.preventDefault();

        // Create array to store subcategories
        var subcategories = [];

        // Loop through each row in subcategory table and add to array
        $('#subcategory-table tbody tr').each(function() {
            var name = $(this).find('.subcategory-name').val();
            var description = $(this).find('.subcategory-description').val();
            var subcategory = {
                name: name,
                description: description
            };
            subcategories.push(subcategory);
        });

        // Add subcategories array to form data
        var formData = new FormData(this);
        formData.append('subcategories', JSON.stringify(subcategories));

        $.ajax({
            url: "category/create.php",
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
                } else {
                    Swal.fire({
                        icon: "error",
                        text: result.message
                    });
                }
                $("#category")[0].reset();
                $("#form-header").removeClass("card-warning").addClass("card-success");
                $('#form-title').text('Add');
                $("#subcategory-table tbody").empty();
                $("#cancelBtn").hide();

                var subcategoriesHtml = '<tr>\
        <td><input type="text" class="form-control subcategory-name" name="subcategories[0][name]" required></td>\
        <td><button type="button" class="btn btn-success add-subcategory"><i class="fa fa-plus"></i></button></td>\
        <td><button type="button" class="btn btn-danger remove-subcategory" disabled><i class="fa fa-trash"></i></button></td>\
    </tr>';
                $("#subcategory-table tbody").html(subcategoriesHtml);
                fetchData();
            }
        });
    });




    // Edit
    $(document).on("click", ".editBtn", function() {
        var id = $(this).data("id");
        $.ajax({
            url: "category/edit.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#description").val(data.description);
                $("#form-header").removeClass("card-success").addClass("card-warning");
                $('#form-title').text('Edit');
                $("#cancelBtn").show();

                // Clear existing rows in subcategories table
                $("#subcategory-table tbody").empty();

                // Loop through subcategories and append rows to table
                if (data.subcategories.length > 0) {
                    var subcategoriesHtml = "";
                    $.each(data.subcategories, function(index, subcategory) {
                        subcategoriesHtml += '<tr>\
            <td><input type="text" class="form-control subcategory-name" name="subcategories[' + index + '][name]" value="' + subcategory.name + '" required></td>\
            <td><button type="button" class="btn btn-success add-subcategory"><i class="fa fa-plus"></i></button></td>\
            <td><button type="button" class="btn btn-danger remove-subcategory"><i class="fa fa-trash"></i></button></td>\
        </tr>';
                    });
                    $("#subcategory-table tbody").html(subcategoriesHtml);
                } else {
                    var subcategoriesHtml = '<tr>\
        <td><input type="text" class="form-control subcategory-name" name="subcategories[0][name]" required></td>\
        <td><button type="button" class="btn btn-success add-subcategory"><i class="fa fa-plus"></i></button></td>\
        <td><button type="button" class="btn btn-danger remove-subcategory" disabled><i class="fa fa-trash"></i></button></td>\
    </tr>';
                    $("#subcategory-table tbody").html(subcategoriesHtml);
                }

            }

        });
    });


    $(document).on("click", "#cancelBtn", function() {
        $("#id").val('');
        $("#name").val('');
        $("#description").val('');
        $("#form-header").removeClass("card-warning").addClass("card-success");
        $('#form-title').text('Add');
        $("#subcategory-table tbody").empty();
        $("#cancelBtn").hide();
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
                    url: "category/delete.php",
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
            url: "category/fetch.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                var table = $('#category-list').DataTable();
                table.clear();
                $.each(data, function(index, row) {
                    table.row.add([
                        row.id,
                        row.name,
                        row.description,
                        '<button class="editBtn btn btn-primary" data-id="' + row.id + '">Edit</button> <button class="deleteBtn btn btn-danger" data-id="' + row.id + '">Delete</button>'
                    ]);
                });
                table.draw();
            }
        });
    }
</script>