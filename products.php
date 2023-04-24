<?php

include_once 'templates/header.php';
$page = 'Product';

$stmt = $pdo->query("SELECT id, name FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

                        <form id="product" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="item-name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-price">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="form-group">
                                    <label for="item-description">Description:</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category_id" required>
                                        <option value="">Select a category</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subcategory">Subcategory</label>
                                    <select class="form-control" id="subcategory" name="subcategory_id" required>
                                        <option value="">Select a subcategory</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Image:</label>
                                    <input type="file" name="image" id="image" accept="image/*" class="form-control-file">
                                    <img id="image-preview" src="" alt="Image Preview" width="200">
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
                                <table class="table" id="product-list">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Featured</th>
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
        $("#cancelBtn").hide();
        if ($('#image-preview').attr('src') == '') {
            $('#image-preview').hide();
        }

    });

    // Create
    $(document).on("submit", "#product", function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "product/create.php",
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
                    $("#description").val('');
                    $("#price").val('');
                    $("#category").val('');
                    $("#subcategory").val('');
                    $("#image-preview").attr("src", '');
                    $("#form-header").removeClass("card-warning").addClass("card-success");
                    $('#form-title').text('Add');
                    $("#cancelBtn").hide();
                    $("#subcategory").empty();
                    $('#image-preview').hide();
                    // Add a default option
                    $("#subcategory").append("<option value=''>Select a subcategory</option>");
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
            url: "product/edit.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#description").val(data.description);
                $("#price").val(data.price);
                $("#category").val(data.category_id);
                $("#subcategory").val(data.subcategory_id);
                $("#image-preview").attr("src", 'uploads/' + data.image);
                $("#form-header").removeClass("card-success").addClass("card-warning");
                $('#form-title').text('Edit');
                $("#cancelBtn").show();
                $('#image-preview').show();
                // Get subcategories for the selected category
                $.ajax({
                    url: "category/get_subcategories.php",
                    type: "POST",
                    data: {
                        category_id: data.category_id
                    },
                    success: function(response) {
                        var subcategories = JSON.parse(response);
                        // Clear the subcategory dropdown
                        $("#subcategory").empty();
                        // Add a default option
                        $("#subcategory").append("<option value=''>Select a subcategory</option>");
                        // Add options for each subcategory
                        $.each(subcategories, function(index, subcategory) {
                            if (data.subcategory_id === subcategory.id) {
                                $("#subcategory").append("<option selected value='" + subcategory.id + "'>" + subcategory.name + "</option>");
                            } else {
                                $("#subcategory").append("<option value='" + subcategory.id + "'>" + subcategory.name + "</option>");
                            }
                        });
                    }
                });
            }
        });
    });

    $(document).on("click", ".featuredBtn", function() {
        var productId = $(this).data('id');
        var featured = $(this).hasClass('btn-success') ? 0 : 1;
        var button = $(this);

        $.ajax({
            url: 'product/featured.php',
            type: 'POST',
            data: {
                id: productId,
                featured: featured
            },
            success: function(response) {
                console.log('test')
                if (featured) {
                    button.removeClass('btn-primary').addClass('btn-success').text('Yes');
                } else {
                    button.removeClass('btn-success').addClass('btn-primary').text('No');
                }
            },
            error: function() {
                console.log('An error occurred while updating the featured status.');
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
                    url: "product/delete.php",
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

    $(document).on("change", "#category", function() {
        var category_id = $(this).val();
        if (category_id !== "") {
            $.ajax({
                url: "category/get_subcategories.php",
                type: "POST",
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    var subcategories = JSON.parse(response);
                    var subcategory_dropdown = $("#subcategory");
                    subcategory_dropdown.empty();
                    subcategory_dropdown.append('<option value="">Select a subcategory</option>');
                    subcategories.forEach(function(subcategory) {
                        subcategory_dropdown.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                    // check if subcategories are found
                    if (subcategories.length > 0) {
                        // add required attribute
                        $('#subcategory').prop('required', true);
                    } else {
                        // remove required attribute
                        $('#subcategory').prop('required', false);
                    }

                }
            });
        }
    });



    function fetchData() {
        $.ajax({
            url: "product/fetch.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                var table = $('#product-list').DataTable();
                table.clear();
                $.each(data, function(index, row) {
                    var featuredBtn = '';
                    if (row.featured == '1') {
                        featuredBtn = '<button class="featuredBtn btn btn-success" data-id="' + row.id + '">Yes</button>';
                    } else {
                        featuredBtn = '<button class="featuredBtn btn btn-primary" data-id="' + row.id + '">No</button>';
                    }
                    table.row.add([
                        row.id,
                        row.name,
                        row.price,
                        row.description,
                        '<img src="' + row.image + '" width="50" height="50">',
                        featuredBtn,
                        '<button class="editBtn btn btn-primary" data-id="' + row.id + '">Edit</button> <button class="deleteBtn btn btn-danger" data-id="' + row.id + '">Delete</button>'
                    ]);
                });
                table.draw();

                // Add click event listener for featured button



            }
        });
    }
</script>