<?php

include_once 'templates_menu/shop-header.php';
include_once 'db.php';

$stmt = $pdo->query('SELECT * FROM categories');
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare("SELECT * FROM products WHERE featured = 1");
$query->execute();
$featured = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->prepare("SELECT * FROM promo");
$query->execute();
$slideItemsHtml = '';
$n = 1;

?>

<?php
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $imageUrl = htmlspecialchars($row['image_url']);
    $title = htmlspecialchars($row['title']);
    $subtitle = htmlspecialchars($row['subtitle']);
    $cta_color = htmlspecialchars($row['cta_color']);
    $cta = intval($row['cta']);
    $ctaText = $cta ? htmlspecialchars($row['cta_text']) : '';
    $ctaPosition = $cta ? htmlspecialchars($row['cta_position']) : '';
    $pos = ($ctaPosition == 'left') ? '' : 'justify-content-end';

    $slideItemsHtml .= '<div class="slide-item slide-item-bag position-relative">';
    $slideItemsHtml .= '<img class="slide-img d-none d-md-block w-100" src="' . $imageUrl . '" alt="slide-' . $n . '">';
    $slideItemsHtml .= '<img class="slide-img d-md-none w-100" src="' . $imageUrl . '" alt="slide-' . $n . '">';
    $slideItemsHtml .= '<div class="content-absolute content-slide">';
    $slideItemsHtml .= '<div class="container height-inherit d-flex align-items-center ' . $pos . '">';
    $slideItemsHtml .= '<div class="content-box slide-content py-4">';
    $slideItemsHtml .= '<p style="color:' . $cta_color . ';" class="slide-text heading_24 animate__animated animate__fadeInUp" data-animation="animate__animated animate__fadeInUp">';
    $slideItemsHtml .= $title;
    $slideItemsHtml .= '</p>';
    $slideItemsHtml .= '<h2 style="color:' . $cta_color . ';" class="slide-heading heading_72 animate__animated animate__fadeInUp" data-animation="animate__animated animate__fadeInUp">';
    $slideItemsHtml .= $subtitle;
    $slideItemsHtml .= '</h2>';
    if ($cta) {
        $slideItemsHtml .= '<a class="btn-primary slide-btn animate__animated animate__fadeInUp" href="' . $ctaPosition . '" data-animation="animate__animated animate__fadeInUp">' . $ctaText . '</a>';
    }
    $slideItemsHtml .= '</div></div></div></div>';
    $n++;
}

?>

<main id="MainContent" class="content-for-layout">
    <!-- slideshow start -->
    <div class="slideshow-section position-relative">
        <div class="slideshow-active activate-slider" data-slick='{
                    "slidesToShow": 1, 
                    "slidesToScroll": 1, 
                    "dots": true,
                    "arrows": true,
                    "responsive": [
                        {
                            "breakpoint": 768,
                            "settings": {
                                "arrows": false
                            }
                        }
                    ]
                }'>

            <?php echo $slideItemsHtml; ?>
        </div>
        <div class="activate-arrows"></div>
        <div class="activate-dots dot-tools"></div>
    </div>
    <!-- slideshow end -->

    <!-- collection start -->
    <div class="featured-collection mt-100 overflow-hidden">
        <div class="collection-tab-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Featured Products</h2>
                </div>
                <div class="row">
                    <?php foreach ($featured as $row) { ?>
                        <div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="700">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <img class="primary-img" src="uploads/<?= $row['image']; ?>" onerror="this.onerror=null; this.src='uploads/noimage.png';" alt="product-img">
                                    <div class="product-card-action product-card-action-2">
                                        <a href="#quickview-modal" data-id="<?= $row['id']; ?>" class="quickview-btn view-product btn-primary" data-bs-toggle="modal">QUICKVIEW</a>
                                    </div>
                                </div>
                                <div class="product-card-details text-center">
                                    <h3 class="product-card-title"><a href="collection-left-sidebar.html"><?= $row['name']; ?></a></h3>
                                    <div class="product-card-price">
                                        <span class="card-price-regular"><?= '$' . $row['price']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- collection end -->

    <!-- shop by category start -->
    <div class="shop-category mt-100 overflow-hidden">
        <div class="collection-tab-inner">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-heading">Shop By Category</h2>
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