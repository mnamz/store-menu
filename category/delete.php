<?php

include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "DELETE FROM categories WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);
}
