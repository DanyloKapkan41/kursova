<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: enter.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Отримання товарів з кошика
$stmt = $pdo->prepare("
    SELECT ci.id, p.name, p.price, ci.quantity, (p.price * ci.quantity) AS total_price
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body class="cart_body">
 
    <header>
        <h1>Ваш кошик</h1>  
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <?php if (empty($cartItems)): ?>
            <p>Ваш кошик порожній.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Ціна за одиницю</th>
                        <th>Кількість</th>
                        <th>Загальна ціна</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?> грн</td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['total_price']); ?> грн</td>
                            <td>
                                <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
