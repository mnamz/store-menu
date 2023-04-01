<?php

include_once 'templates/header_menu.php';
$page = 'Menu';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mh-0">
    <section class="content-header">
        <!-- <div class="container-fluid"> -->
            <div class="row mb-2">
                <div class="col-sm-6 d-flex justify-content-center align-items-center">
                    <img src="dronecare.jpg" alt="Logo" style="max-height: 50px;">
                </div>
            </div>
        <!-- </div> -->
</div>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php foreach ($categories as $category) : ?>
                <div class="col-lg-3 col-6">
                    <div class="card card-primary collapsed-card" data-card-widget="collapse" data-category-id="<?= $category['id'] ?>">
                        <div class="card-header">
                            <h3 class="card-title"><?= $category['name'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool"><i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="card-body" id="subcategory-container" style="display: block;"> -->
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                <?php
                                $cat_id = $category['id'];
                                $stmt = $pdo->query("SELECT * FROM subcategories WHERE category_id = $cat_id ");
                                $subcats = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($subcats as $subcat) :
                                ?>
                                    <li class="nav-item">
                                        <a href="#" data-cat-id="<?= $category['id']; ?>" data-subcat-id="<?= $subcat['id']; ?>" class="nav-link">
                                        <?= $subcat['name']; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>

                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row" id="product-grid">
            <?php foreach ($products as $product) : ?>
                <div class="col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title product-name"><?php echo $product['name']; ?></h5>
                            <p class="card-text product-price">RM <?php echo $product['price']; ?></p>
                            <img src="uploads/<?php echo $product['image']; ?>" class="img-fluid card-img mb-4">
                            <button class="btn btn-primary view-product" data-toggle="modal" data-target="#productModal" data-id="<?php echo $product['id']; ?>">View</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <style>
            @media (max-width: 767px) {
                #product-grid .col-md-4 {
                    width: 50%;
                    float: left;
                }
            }

            .card-img {
                object-fit: cover;
                min-height: 130px;
            }

            .mh-0 {
                min-height: 0 !important;
                background-color: white !important;
            }

            .card-body {
                border: 1px solid #ccc;
                padding: 10px;
            }

            .subcategory-item {
                list-style: none;
                border-top: 1px solid #ccc;
                margin-top: 10px;
                padding-top: 10px;
                color: #000;
            }

            .subcategory-item:first-of-type {
                border-top: none;
                margin-top: 0;
                padding-top: 0;
            }

            .subcategory-item a {
                color: #000;
                text-decoration: none;
            }

            .subcategory-item a:hover {
                text-decoration: underline;
            }
        </style>


    </div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="product-info"></div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'templates/footer.php'; ?>

<script>
    $(document).ready(function() {
        // Set up DataTable
        var table = $('#product-table').DataTable({
            "paging": false,
            "searching": false,
            "info": false
        });

        // Category filter
        $('.nav-link').on('click', function() {
            var categoryId = $(this).data('cat-id');
            var subcatId = $(this).data('subcat-id');

            if (categoryId == 'all') {
                table.columns(2).search('').draw();
            } else {
                table.columns(2).search(categoryId).draw();
            }


            // Ajax loading
            $('#product-grid').empty().html('<div class="col-md-12 text-center"><i class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: 'product/get_products.php',
                type: 'get',
                dataType: 'json',
                data: {
                    category: categoryId,
                    subcategory: subcatId
                },
                success: function(data) {
                    $('#product-grid').empty();

                    $.each(data, function(index, product) {
                        var html = '<div class="col-md-4">';
                        html += '<div class="card">';
                        html += '<div class="card-body">';
                        html += '<h5 class="card-title product-name">' + product.name + '</h5>';
                        html += '<p class="card-text product-description">RM ' + product.price + '</p>';
                        html += '<img src="uploads/' + product.image + '" class="img-fluid card-img mb-4">';
                        html += '<button class="btn btn-primary view-product" data-toggle="modal" data-target="#productModal" data-id="' + product.id + '">View</button>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';

                        $('#product-grid').append(html);
                    });

                    // Re-initialize DataTable
                    table.destroy();
                    table = $('#product-table').DataTable({
                        "paging": true,
                        "searching": false,
                        "info": false
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.view-product', function() {
            var productId = $(this).data('id');
            $.ajax({
                url: 'product/get_product_info.php',
                type: 'POST',
                data: {
                    id: productId
                },
                success: function(response) {
                    $('#product-info').html(response);
                    $('#productModal').modal('show');
                }
            });
        });


    });
</script>