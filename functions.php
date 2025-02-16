<?php
require 'db.php';

function getAllProducts($pdo) {
    $stmt = $pdo->query('SELECT * FROM products');
    return $stmt->fetchAll();
}

function getProductTypes($pdo) {
    $stmt = $pdo->query('SELECT DISTINCT type FROM products');
    return $stmt->fetchAll();
}

function getFilteredProducts($pdo, $minPrice, $maxPrice, $inStockOnly, $productType) {
    $sql = 'SELECT * FROM products WHERE price BETWEEN :minPrice AND :maxPrice';
    
    // Додаємо умову для фільтрації за наявністю
    if ($inStockOnly) {
        $sql .= ' AND in_stock = 1';
    }

    // Додаємо умову для фільтрації за типом товару, якщо обрано конкретний тип
    if (!empty($productType)) {
        $sql .= ' AND type = :productType';
    }

    $stmt = $pdo->prepare($sql);
    $params = ['minPrice' => $minPrice, 'maxPrice' => $maxPrice];
    if (!empty($productType)) {
        $params['productType'] = $productType;
    }
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getProductsByPrice($pdo, $maxPrice) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE price < ?');
    $stmt->execute([$maxPrice]);
    return $stmt->fetchAll();
}

function getEmployeeByName($pdo, $name) {
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE name LIKE ?');
    $stmt->execute(["%$name%"]);
    return $stmt->fetch();
}

function getAllSuppliers($pdo) {
    $stmt = $pdo->query('SELECT * FROM suppliers');
    return $stmt->fetchAll();
}

function getTechSuppliers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM suppliers WHERE name LIKE ?");
    $stmt->execute(['%Техно%']);
    return $stmt->fetchAll();
}
?>
