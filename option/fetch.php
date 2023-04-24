<?php
include_once '../db.php';

$stmt = $pdo->query("SELECT * FROM promo");
$data = $stmt->fetchAll();

$results = array();
foreach ($data as $row) {
    $results[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "description" => $row['description'],
        "image_url" => $row['image_url'],
    );
}

echo json_encode($results);
