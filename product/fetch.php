<?php
include_once '../db.php';

$stmt = $pdo->query("SELECT * FROM products");
$data = $stmt->fetchAll();

$results = array();
foreach ($data as $row) {
    $image = $row['image'] ? "uploads/{$row['image']}" : "";
    $results[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "price" => $row['price'],
        "description" => $row['description'],
        "category_id" => $row['category_id'],
        "image" => $image
    );
}

echo json_encode($results);
