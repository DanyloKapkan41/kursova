<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: enter.php");
    exit;
}

$userId = $_SESSION['user_id'];
$productId = $_GET['product_id'];
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

// Перевірка, чи товар вже є в кошику
$stmt = $pdo->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
$stmt->execute([$userId, $productId]);
$item = $stmt->fetch();

if ($item) {
    // Якщо товар вже є в кошику, збільшуємо кількість
    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$quantity, $userId, $productId]);
} else {
    // Якщо товару немає, додаємо його в кошик
    $stmt = $pdo->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $productId, $quantity]);
}

header("Location: cart.php");
exit;
?>