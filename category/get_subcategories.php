<?php 

include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $category_id = $_POST["category_id"];
  $sql = "SELECT * FROM subcategories WHERE category_id = :category_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(["category_id" => $category_id]);
  $subcategories = $stmt->fetchAll();
  echo json_encode($subcategories);
}
