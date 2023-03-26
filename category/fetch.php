<?php
include_once '../db.php';

$stmt = $pdo->query("SELECT * FROM categories");
$data = $stmt->fetchAll();

$results = array();
foreach ($data as $row) {
    $results[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "description" => $row['description'],
    );
}

echo json_encode($results);
