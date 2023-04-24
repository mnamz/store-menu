<?php

include_once 'templates_menu/shop-header.php';
include_once 'db.php';

$stmt = $pdo->query('SELECT * FROM categories');
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<style>

</style>
<main id="MainContent" class="content-for-layout">

    <!-- shop by category start -->
    <div class="shop-category mt-100 overflow-hidden">
        <div class="collection-tab-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">All Categories</h2>
                </div>
                <div class="grid-container shop-category-inner">
                    <?php
                    for ($i = 0; $i < count($categories); $i++) {
                        $category = $categories[$i];
                        $colors = array("#4F7CAC", "#2C699A", "#1E4D6D", "#0D2C54", "#0C1C36");
                        $random_color = $colors[array_rand($colors)];
                        echo '<a class="grid-item grid-item-2 position-relative rounded mt-0 d-flex" href="products-menu.php?category=' . $category['id'] . '" style="background-color: ' . $random_color . '">';
                        echo '<img class="banner-img" style="opacity:0;" src="assets/img/banner/bag-5.jpg" alt="banner-1">';
                        echo '<div class="content-absolute content-slide">';
                        echo '<div class="container height-inherit d-flex">';
                        echo '<div class="content-box banner-content p-4">';
                        echo '<h2 class="heading_18">' . $category['name'] . '</h2>';
                        echo '<span class="text_12 mt-2 link-underline d-block">';
                        echo 'BROWSE PRODUCTS';
                        echo '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>
    <!-- shop by category end -->

</main>
<!-- scrollup start -->
<button id="scrollup">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>
<!-- scrollup end -->



<?php

include_once 'templates_menu/footer.php';

?>

<script>
    $(document).ready(function() {
        var offset = 0;
        var limit = 8;
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');
        const subcategory = urlParams.get('subcategory');

        loadProducts(offset, limit, category, subcategory);
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                // If the user has scrolled to the bottom of the page, load the next set of products
                offset += limit;
                loadProducts(offset, limit, category, subcategory);
            }
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

    function loadProducts(offset, limit, category, subcategory) {
        $.ajax({
            url: 'ajax/fetch-products.php',
            method: 'POST',
            data: {
                offset: offset,
                limit: limit,
                category: category,
                subcategory: subcategory
            },
            success: function(data) {
                $('.product-list').append(data);
            }
        });
    }


    function updateFilter(event) {
        event.preventDefault();

        const target = event.currentTarget;
        const filterId = target.getAttribute('data-id');

        const url = new URL(window.location.href);

        if (filterId === 'all') {
            url.searchParams.delete('subcategory');
        } else {
            url.searchParams.set('subcategory', filterId);
        }

        window.location.href = url.toString();
    }
</script>