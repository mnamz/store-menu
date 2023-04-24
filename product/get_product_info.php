<?php

require_once '../controllers/Product.php';

$id = $_POST['id'];
$products = Product::getProduct($id);
foreach ($products as $product) :
$html = '<div class="row m-3">';
$html .= '<div class="col-lg-6 col-md-12 col-12">';
$html .= '<div class="product-gallery product-gallery-vertical d-flex">';
$html .= '<div class="product-img-large">';
$html .= '<div class="img-large-wrapper">';
$html .= '<img src="uploads/' . $product['image'] . '" alt="' . $product['name'] . '" onerror="this.onerror=null; this.src=\'uploads/noimage.png\';">';
$html .= '</div></div></div></div>';
$html .= '<div class="col-lg-6 col-md-12 col-12">';
$html .= '<div class="product-details ps-lg-4">';
$html .= '<div class="mb-3"><span class="product-availability">In Stock</span></div>';
$html .= '<h2 class="product-title mb-3">' . $product['name'] . '</h2>';
$html .= '<div class="product-price-wrapper mb-4">';
$html .= '<span class="product-price regular-price">RM ' . $product['price'] . '</span>';
$html .= '</div>';
$html .= '<div class="product-vendor product-meta mb-3">';
$html .= '<strong class="label">Description:</strong>';
$html .= '</div>';
$html .= '<div class="product-vendor product-meta mb-3">';
$html .= '<p>' . nl2br($product['description']) . '</p>';
$html .= '</div></div></div></div>';
endforeach;
echo $html;
?>
