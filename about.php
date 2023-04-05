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
<section class="about">

    <section class="products__header mt-4">
        <a onclick='location.href = "/";'><img src="dronecare.jpg" alt="Logo" class="header-logo" style="max-height: 100px;"></a>
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
                    <?php if (!isset($_GET['category_id'])) : ?>
                        <li class="nav-item">
                            <a class='nav-link px-3 <?= ($_SERVER['REQUEST_URI'] == "/about.php") ? "hover" : "" ?>' href='about.php'>About Us</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="information">
        <div class="container">
            <h3 class="container-products-header">Dronecare Puchong</h3>
            <address>(Retail & Service Center) Monday - Saturday (11am-7pm) <br>
                No 57A, Jalan PU 7/4, Taman Puchong Utama, 47100 Puchong, Selangor, Malaysia. <br>
                https://waze.com/ul/hw28302dft <br>
            </address>

            <h3 class="container-products-header">Drone Care (Setapak)</h3>
            <address>(Retail) Monday - Saturday (12pm-8pm) <br>
                Platinum Walk, Block E-65-1, No 2, Jalan Langkawi, 53300 Wilayah Persekutuan Kuala Lumpur, Malaysia. <br>
                https://waze.com/ul/hw2864xv89 <br>
            </address>

            <p>Park basement, find block E Lift, then level 1. Once get out from lift turn left then right. TQ</p>

            📲Steven Liew
            <address>
            +601162303363 <br>
            Whatapps: <a style="color:black" href='https://api.whatsapp.com/send?phone=601162303363'>Click here</a> <br>
            </address>

            📲Brandon Foo
            <address>
            +601115555520 <br>
            Whatapps: <a style="color:black" href='https://api.whatsapp.com/send?phone=601115555520'>Click here</a> <br>
            </address>
        </div>
    </section>




    <button id="scroll-to-top"><i class="fas fa-arrow-up"></i></button>

</section>

<style>
    #scroll-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 50%;
        font-size: 18px;
    }

    #scroll-to-top:hover {
        cursor: pointer;
    }

    .container-products-header {
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .container-products-title {
        text-align: center;
    }
</style>
<!-- jQuery -->
<link rel="stylesheet" href="assets/css/menu.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/js/menu.js"></script>
<script>
    $('.modal-header').on('click', function() {
        $('#productModal').modal('hide');
    });
    $(document).ready(function() {
        // Show/hide the button based on scroll position
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#scroll-to-top').fadeIn();
            } else {
                $('#scroll-to-top').fadeOut();
            }
        });

        // Scroll to top when the button is clicked
        $('#scroll-to-top').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
</script>