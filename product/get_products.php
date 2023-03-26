<?php

include_once '../db.php';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;
    
    if($category == 'all'){
        $stmt = $pdo->query("SELECT * FROM products");
    } else {
        $sql = "SELECT products.*
                FROM products
                LEFT JOIN subcategories ON products.subcategory_id = subcategories.id
                WHERE products.category_id = ? OR subcategories.category_id = ?";
        $params = [$category, $category];
        
        if ($subcategory) {
            $sql .= " AND products.subcategory_id = ?";
            $params[] = $subcategory;
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($products);
