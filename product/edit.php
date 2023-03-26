<?php

include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetch the list of categories
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $id = $_POST["id"];
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);
    $data = $stmt->fetch();
    echo json_encode($data);
}
