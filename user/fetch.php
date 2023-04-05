<?php
include_once '../db.php';

$stmt = $pdo->query("SELECT * FROM users");
$data = $stmt->fetchAll();

$results = array();
foreach ($data as $row) {
    $results[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "email" => $row['email'],
        "password" => $row['password'],
    );
}

echo json_encode($results);
