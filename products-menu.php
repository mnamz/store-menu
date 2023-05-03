<?php

include_once 'templates_menu/shop-header.php';
include_once 'db.php';


$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$subcategory_id = isset($_GET['subcategory']) ? intval($_GET['subcategory']) : null;

// Query the database to retrieve the category name
if ($category_id !== null) {
    $sql = "SELECT name FROM categories WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $result ? $result['name'] : 'All';

    // $sql = "SELECT COUNT(*) AS total_products FROM products WHERE category_id = ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$category_id]);
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // $total_products = $result['total_products'];

    $sql = "SELECT * FROM subcategories WHERE category_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $category_name = 'All';
    // $query = $pdo->prepare('SELECT COUNT(*) AS total_products FROM products');
    // $query->execute();
    // $result = $query->fetch(PDO::FETCH_ASSOC);
    // $total_products = $result['total_products'];
}

if (isset($_GET['category']) && isset($_GET['subcategory'])) {
    $category_id = intval($_GET['category']);
    $subcategory_id = intval($_GET['subcategory']);

    // Query the database to retrieve the subcategory name
    $sql = "SELECT name FROM subcategories WHERE id = ? AND category_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$subcategory_id, $category_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $subcategory_name = $result ? $result['name'] : null;
} elseif (isset($_GET['category'])) {
    $subcategory_name = 'All';
}

$sql = "SELECT COUNT(*) as total_products FROM products";
if ($category_id !== null) {
    $sql .= " WHERE category_id = :category_id";
    if ($subcategory_id !== null) {
        $sql .= " AND subcategory_id = :subcategory_id";
    }
}
$stmt = $pdo->prepare($sql);
if ($category_id !== null) {
    $stmt->bindParam(':category_id', $category_id);
    if ($subcategory_id !== null) {
        $stmt->bindParam(':subcategory_id', $subcategory_id);
    }
}
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_products = $result['total_products'];

?>


<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="/">Home</a></li>
            <li>
                <svg class="icon icon-breadcrumb" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.4">
                        <path d="M25.9375 8.5625L23.0625 11.4375L43.625 32L23.0625 52.5625L25.9375 55.4375L47.9375 33.4375L49.3125 32L47.9375 30.5625L25.9375 8.5625Z" fill="#000" />
                    </g>
                </svg>
            </li>
            <li>Products</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="collection mt-100">
        <div class="container">
            <div class="row">
                <!-- product area start -->
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="filter-sort-wrapper d-flex justify-content-between flex-wrap">
                        <div class="collection-title-wrap d-flex align-items-end">
                            <h2 class="collection-title heading_24 mb-0"><?= $category_name; ?> products</h2>
                            <p class="collection-counter text_16 mb-0 ms-2">(<?= $total_products; ?> items)</p>
                        </div>
                        <?php if (isset($_GET['category'])) : ?>
                            <div class="filter-sorting">
                                <div class="collection-sorting position-relative d-none d-lg-block">
                                    <div class="sorting-header text_16 d-flex align-items-center justify-content-end">
                                        <span class="sorting-title me-2">Sort by:</span>
                                        <span class="active-sorting"><?= $subcategory_name; ?></span>
                                        <span class="sorting-icon">
                                            <svg class="icon icon-down" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <ul class="sorting-lists list-unstyled m-0">
                                        <?php if (isset($subcategories)) : ?>
                                            <li><a href="#" data-id="all" onclick="updateFilter(event)" class="text_14">All</a></li>
                                            <?php foreach ($subcategories as $subcategory) : ?>
                                                <li><a href="#" data-id="<?= $subcategory['id']; ?>" onclick="updateFilter(event)" class="text_14"><?= $subcategory['name']; ?></a></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="filter-drawer-trigger mobile-filter d-flex align-items-center d-lg-none">
                                    <span class="mobile-filter-icon me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-filter">
                                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                        </svg>
                                    </span>
                                    <span class="mobile-filter-heading">Sorting</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="collection-product-container">
                        <div class="row">
                            <?php
                            $category = isset($_GET['category']) ? $_GET['category'] : '';
                            $subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
                            
                            // Prepare the SQL query to fetch products
                            $sql = "SELECT * FROM products";
                            $where = array();
                            $params = array();
                            if (!empty($category)) {
                              $where[] = "category_id = :category_id";
                              $params['category_id'] = $category;
                            }
                            if (!empty($subcategory)) {
                              $where[] = "subcategory_id = :subcategory_id";
                              $params['subcategory_id'] = $subcategory;
                            }
                            if (!empty($where)) {
                              $sql .= " WHERE " . implode(' AND ', $where);
                            }
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($params);
                            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            
                            // Generate HTML code for the products
                            $html = '';
                            foreach($products as $product) {
                              $html .= '<div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="700">';
                              $html .= '<div class="product-card">';
                              $html .= '<div class="product-card-img">';
                              $html .= '<a class="hover-switch">';
                              $html .= '<img class="primary-img" src="uploads/' . $product['image'] . '" onerror="this.onerror=null; this.src=\'uploads/noimage.png\';" alt="product-img">';
                              $html .= '</a>';
                              $html .= '<div class="product-card-action product-card-action-2 justify-content-center">';
                              $html .= '<a href="#quickview-modal" class="action-card action-quickview view-product" data-id="' . $product['id'] . '" data-bs-toggle="modal">';
                              $html .= '<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M10 0C15.5117 0 20 4.48828 20 10C20 12.3945 19.1602 14.5898 17.75 16.3125L25.7188 24.2812L24.2812 25.7188L16.3125 17.75C14.5898 19.1602 12.3945 20 10 20C4.48828 20 0 15.5117 0 10C0 4.48828 4.48828 0 10 0ZM10 2C5.57031 2 2 5.57031 2 10C2 14.4297 5.57031 18 10 18C14.4297 18 18 14.4297 18 10C18 5.57031 14.4297 2 10 2ZM11 6V9H14V11H11V14H9V11H6V9H9V6H11Z" fill="#00234D"></path>
                            </svg></a>';
                              $html .= '</div>';
                              $html .= '</div>';
                              $html .= '<div class="product-card-details">';
                              $html .= '<h3 class="product-card-title">';
                              $html .= '<a>' . $product['name'] . '</a>';
                              $html .= '</h3>';
                              $html .= '<div class="product-card-price">';
                              $html .= '<span class="card-price-regular">RM' . $product['price'] . '</span>';
                              $html .= '</div>';
                              $html .= '</div>';
                              $html .= '</div>';
                              $html .= '</div>';
                            }
                            
                            // Return the HTML code for the products
                            echo $html; 
                            ?>
                        </div>
                    </div>
                </div>
                <!-- product area end -->

                <!-- sidebar start -->
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="collection-filter filter-drawer">
                        <div class="filter-widget d-lg-none d-flex align-items-center justify-content-between">
                            <h5 class="heading_24">Sorting By</h4>
                                <button type="button" class="btn-close text-reset filter-drawer-trigger d-lg-none"></button>
                        </div>

                        <div class="filter-widget d-lg-none">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom" data-bs-toggle="collapse" data-bs-target="#filter-mobile-sort">
                                <span>
                                    <span class="sorting-title me-2">Sort by:</span>
                                    <span class="active-sorting"><?= $subcategory_name; ?></span>
                                </span>
                                <span class="faq-heading-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div id="filter-mobile-sort" class="accordion-collapse collapse show">
                                <ul class="sorting-lists-mobile list-unstyled m-0">
                                    <?php if (isset($subcategories)) : ?>
                                        <li><a href="#" data-id="all" onclick="updateFilter(event)" class="text_14">All</a></li>
                                        <?php foreach ($subcategories as $subcategory) : ?>
                                            <li><a href="#" data-id="<?= $subcategory['id']; ?>" onclick="updateFilter(event)" class="text_14"><?= $subcategory['name']; ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar end -->
            </div>
        </div>
    </div>
</main>

<!-- scrollup start -->
<button id="scrollup">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>
<!-- scrollup end -->


<!-- product quickview start -->
<div class="modal fade" tabindex="-1" id="quickview-modal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="product-info"></div>
            </div>
        </div>
    </div>
</div>
<!-- product quickview end -->

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
        const productContainer = document.getElementById('footer-container');

        loadProducts(offset, limit, category, subcategory);
        // Add an event listener to the window object that triggers when the user scrolls
        window.addEventListener('scroll', () => {
            // Check if the user has scrolled to the product container
            if (window.pageYOffset + window.innerHeight >= productContainer.offsetTop) {
                // If the user has scrolled to the product container, load the next set of products
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