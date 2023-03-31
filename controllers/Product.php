<?php

class Product {
    private static $pdo;
    
    public static function init() {
        include_once '../db.php';
        self::$pdo = $pdo;
    }
    
    public static function getProducts() {
        $stmt = self::$pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProduct($id) {
        $stmt = self::$pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductsBySubcategoryId($subcategory_id, $category_id) {
        if($subcategory_id == 'All'){
            $stmt = self::$pdo->prepare("SELECT * FROM products WHERE category_id = ?");
            $stmt->execute([$category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = self::$pdo->prepare("SELECT * FROM products WHERE subcategory_id = ? AND category_id = ?");
            $stmt->execute([$subcategory_id, $category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function getProductsByCategoryId($category_id) {
        $stmt = self::$pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

Product::init();
