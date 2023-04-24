<?php

// Include the database connection file
require_once('../db.php');

// Get the offset and limit parameters from the AJAX request
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
$category = isset($_POST['category']) ? $_POST['category'] : '';
$subcategory = isset($_POST['subcategory']) ? $_POST['subcategory'] : '';

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
$sql .= " LIMIT $limit OFFSET $offset";
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
