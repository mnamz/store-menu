<?php

include_once 'controllers/Category.php';

// Get category ID from URL or form
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
} else {
    $category_id = 'All'; // default category ID
}

// Get subcategories for the given category ID
if ($category_id !== 'All') {
    $subcategories = Category::getSubcategories($category_id);
    $show_all = true;
} else {
    $subcategories = Category::getCategories();
    $show_all = false;
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dronecare</title>


    <link rel="stylesheet" href="node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-buttons-dt/css/buttons.dataTables.css">

</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<section class="products">

    <section class="products__header mt-4">
        <a onclick='location.href = window.location.pathname;'><img src="dronecare.jpg" alt="Logo" class="header-logo" style="max-height: 100px;"></a>
        <p>Tagline?</p>
    </section>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid justify-content-center">
            <!-- <a class="navbar-brand" href="#">Logo</a> -->
            <button class=" border-0 navbar-toggler w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse show justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <?php if ($show_all) : ?>
                        <li class="nav-item">
                            <a class='nav-link px-3 user-select-none' data-id="All">All</a>
                        </li>
                    <?php endif; ?>
                    <?php foreach ($subcategories as $subcategory) : ?>
                        <li class="nav-item">
                            <a class='nav-link px-3 <?= isset($_GET['category_id']) ? "user-select-none" : "" ?>' data-id="<?= $subcategory['id']; ?>" <?= !isset($_GET['category_id']) ? "href='?category_id=" . $subcategory['id'] . "'" : "" ?>><?= $subcategory['name']; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>



    <section class="container-products-item">
        <!-- item will display here -->
    </section>

</section>
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

<!-- jQuery -->
<link rel="stylesheet" href="assets/css/menu.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="assets/js/menu.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $('.modal-header').on('click', function() {
        $('#productModal').modal('hide');
    });
</script>