<?php

class Category {
    private static $pdo;
    
    public static function init() {
        include_once 'db.php';
        self::$pdo = $pdo;
    }
    
    public static function getSubcategories($categoryId) {
        $stmt = self::$pdo->prepare("SELECT * FROM subcategories WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategories() {
        $stmt = self::$pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

Category::init();
