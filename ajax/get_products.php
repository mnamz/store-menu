<?php

require_once '../controllers/Product.php';

$subcategoryId = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : null ;
$categoryId = isset($_POST['category_id']) ? $_POST['category_id'] : null;

if (isset($categoryId) && isset($subcategoryId)) {
    $products = Product::getProductsBySubcategoryId($subcategoryId, $categoryId);
} else {
    $products = Product::getProducts();
}

foreach ($products as $product) :
?>
    <article class="products__item">
        <img src="<?= 'uploads/'.$product['image']; ?>" alt="<?= $product['name']; ?>" class="product-img">
        <section class="product-desc">
            <a href="#more">
                <h5 class="product-desc__title"><?= $product['name']; ?></h5>
            </a>
            <p class="product-desc__text"><?= $product['price']; ?></p>
        </section>
        <div class="wrap-item-button view-product" data-id="<?= $product['id']; ?>"><a href="#more" class="item-button">View</a></div>
    </article>
<?php
endforeach;
?>