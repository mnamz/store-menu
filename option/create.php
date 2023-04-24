<?php

include_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $cta = $_POST["cta"];
    $title = $_POST["title"];
    $subtitle = $_POST["subtitle"];
    $cta_text = $_POST["cta_text"];
    $cta_link = $_POST["cta_link"];
    $cta_position = $_POST["cta_position"];
    $cta_color = $_POST["cta_color"];
    $image = $_FILES["image"];

    try {
        if (!empty($image["name"])) {
            $target_dir = "../uploads/";
            $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
            $target_file = $target_dir . uniqid() . '.' . $imageFileType;

            // Check if image file is a actual image or fake image
            $check = getimagesize($image["tmp_name"]);
            if ($check === false) {
                echo json_encode(["success" => false, "message" => "File is not an image."]);
                exit;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo json_encode(["success" => false, "message" => "Sorry, file already exists."]);
                exit;
            }

            // Check file size
            if ($image["size"] > 5000000) {
                echo json_encode(["success" => false, "message" => "Sorry, your file is too large."]);
                exit;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo json_encode(["success" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
                exit;
            }

            // Resize and save the image
            $new_image = imagecreatefromstring(file_get_contents($image["tmp_name"]));
            list($width, $height) = getimagesize($image["tmp_name"]);

            // Calculate the new width and height for 16:9 aspect ratio
            if ($width / $height > 16 / 9) {
                $new_height = $width / 16 * 9;
                $new_width = $width;
            } else {
                $new_width = $height / 9 * 16;
                $new_height = $height;
            }

            $resized_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($resized_image, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($resized_image, $target_file);
            imagedestroy($new_image);
            imagedestroy($resized_image);


            $image_url = "uploads/" . basename($target_file);
        }

        if (empty($id)) {
            $sql = "INSERT INTO promo (name, description, image_url, title, subtitle, cta, cta_text, cta_link, cta_position, cta_color) VALUES (:name, :description, :image_url, :title, :subtitle, :cta, :cta_text, :cta_link, :cta_position, :cta_color)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "name" => $name,
                "description" => $description,
                "title" => $title,
                "subtitle" => $subtitle,
                "cta" => $cta,
                "cta_text" => $cta_text,
                "cta_link" => $cta_link,
                "cta_position" => $cta_position,
                "cta_color" => $cta_color,
                "image_url" => $image_url ?? null,
            ]);
        } else {
            $sql = "UPDATE promo SET name = :name, description = :description, title = :title, subtitle = :subtitle, cta = :cta, cta_text = :cta_text, cta_link = :cta_link, cta_position = :cta_position, cta_color = :cta_color";
            $values = [
                "name" => $name,
                "description" => $description,
                "title" => $title,
                "subtitle" => $subtitle,
                "cta" => $cta,
                "cta_text" => $cta_text,
                "cta_link" => $cta_link,
                "cta_position" => $cta_position,
                "cta_color" => $cta_color,
            ];
            if (!empty($image["name"])) {
                $sql .= ", image_url = :image_url";
                $values["image_url"] = $image_url;
            }
            $sql .= " WHERE id = :id";
            $values["id"] = $id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);
        }

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        // Handle the exception here
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
