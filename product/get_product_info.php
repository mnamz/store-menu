<?php

include_once '../db.php';

// Retrieve the product information based on the ID
$id = $_POST['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Format the product information as HTML
$html = '<dl class="row">';
$html .= '<dt class="col-sm-3">Name:</dt><dd class="col-sm-9">' . $product['name'] . '</dd>';
$html .= '<dt class="col-sm-3">Description:</dt><dd class="col-sm-9">' . $product['description'] . '</dd>';
$html .= '<dt class="col-sm-3">Price:</dt><dd class="col-sm-9">$' . $product['price'] . '</dd>';
$html .= '<img src="uploads/' . $product['image'] . '" class="img-fluid">';
$html .= '</dl>';

// Return the HTML as the response
echo $html;
?>
