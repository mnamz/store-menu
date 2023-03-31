<?php

require_once '../controllers/Product.php';

$id = $_POST['id'];
$products = Product::getProduct($id);
foreach ($products as $product) :
$html = '<dl class="row">';
$html .= '<dt class="col-sm-3">Name:</dt><dd class="col-sm-9">' . $product['name'] . '</dd>';
$html .= '<dt class="col-sm-3">Description:</dt><dd class="col-sm-9">' . $product['description'] . '</dd>';
$html .= '<dt class="col-sm-3">Price:</dt><dd class="col-sm-9">RM ' . $product['price'] . '</dd>';
$html .= '<img src="uploads/' . $product['image'] . '" class="img-fluid">';
$html .= '</dl>';
endforeach;
echo $html;
?>
