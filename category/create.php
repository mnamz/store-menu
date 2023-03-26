<?php 
include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $subcategories = json_decode($_POST["subcategories"], true);

    try {
        $pdo->beginTransaction();

        if (empty($id)) {
            // Insert category
            $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "name" => $name,
                "description" => $description,
            ]);

            // Get the inserted category ID
            $categoryId = $pdo->lastInsertId();

            // Insert subcategories
            $subcatSql = "INSERT INTO subcategories (name, category_id) VALUES (:name, :category_id)";
            $subcatStmt = $pdo->prepare($subcatSql);
            foreach ($subcategories as $subcat) {
                $subcatStmt->execute([
                    "name" => $subcat["name"],
                    "category_id" => $categoryId,
                ]);
            }
        } else {
            // Update category
            $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "name" => $name,
                "description" => $description,
                "id" => $id,
            ]);

            // Delete existing subcategories
            $subcatDelSql = "DELETE FROM subcategories WHERE category_id = :category_id";
            $subcatDelStmt = $pdo->prepare($subcatDelSql);
            $subcatDelStmt->execute(["category_id" => $id]);

            // Insert updated subcategories
            $subcatSql = "INSERT INTO subcategories (name, category_id) VALUES (:name, :category_id)";
            $subcatStmt = $pdo->prepare($subcatSql);
            foreach ($subcategories as $subcat) {
                $subcatStmt->execute([
                    "name" => $subcat["name"],
                    "category_id" => $id,
                ]);
            }
        }

        $pdo->commit();
        echo json_encode(["success" => true]);

    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
