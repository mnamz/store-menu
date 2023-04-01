<?php
include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetch the list of categories
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $category_id = $_POST["category_id"];
    $subcategory_id = $_POST["subcategory_id"];
    $image = $_FILES["image"]["name"]; // Get the image file name
    $imagePath = "../uploads/" . $image; // Set the image upload path

    try {
        if (empty($id)) {
            $sql = "INSERT INTO products (name, description, price, image, category_id, subcategory_id) VALUES (:name, :description, :price, :image, :category_id, :subcategory_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "name" => $name,
                "price" => $price,
                "description" => $description,
                "image" => $image,
                "category_id" => $category_id,
                "subcategory_id" => $subcategory_id,
            ]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        } else {
            if (!empty($image)) {
                $sql = "UPDATE products SET name = :name, description = :description, price = :price, image = :image, category_id = :category_id, subcategory_id = :subcategory_id WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    "name" => $name,
                    "price" => $price,
                    "description" => $description,
                    "image" => $image,
                    "id" => $id,
                    "category_id" => $category_id,
                    "subcategory_id" => $subcategory_id,
                ]);
                // Upload the image file if it's set
                move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
            } else {
                $sql = "UPDATE products SET name = :name, description = :description, price = :price, category_id = :category_id, subcategory_id = :subcategory_id WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    "name" => $name,
                    "price" => $price,
                    "description" => $description,
                    "id" => $id,
                    "category_id" => $category_id,
                    "subcategory_id" => $subcategory_id,
                ]);
            }
        }

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        // Handle the exception here
        echo "Error: " . $e->getMessage();
    }
}
