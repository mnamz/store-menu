<?php

include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "SELECT c.*, s.id as subcategory_id, s.name as subcategory_name
            FROM categories c 
            LEFT JOIN subcategories s ON c.id = s.category_id 
            WHERE c.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);
    $data = $stmt->fetchAll();

    // Restructure subcategories data as an array
    $subcategories = [];
    foreach ($data as $row) {
        if ($row["subcategory_id"]) {
            $subcategories[] = [
                "id" => $row["subcategory_id"],
                "name" => $row["subcategory_name"],
            ];
        }
    }

    // Merge subcategories array into category data
    $category = [
        "id" => $data[0]["id"],
        "name" => $data[0]["name"],
        "description" => $data[0]["description"],
        "subcategories" => $subcategories,
    ];

    echo json_encode($category);
}
