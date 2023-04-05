<?php
include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        if (empty($id)) {
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "name" => $name,
                "email" => $email,
                "password" => $password,
            ]);
        } else {
            $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password,
            ]);
        }

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        // Handle the exception here
        echo "Error: " . $e->getMessage();
    }
}
