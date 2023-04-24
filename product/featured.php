<?php

require_once('../db.php');

$id = $_POST['id'];
$featured = $_POST['featured'];

$sql = "UPDATE products SET featured = :featured WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':featured', $featured);
$stmt->execute();

echo json_encode(['success' => true]);
