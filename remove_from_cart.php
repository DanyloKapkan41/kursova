<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: enter.php");
    exit;
}

$cartItemId = $_GET['id'];

// Видалення товару з кошика
$stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
$stmt->execute([$cartItemId, $_SESSION['user_id']]);

header("Location: cart.php");
exit;
?>