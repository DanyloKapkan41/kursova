<?php
require 'db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Продукт не знайдено!";
        exit;
    }
} else {
    echo "Невірний запит!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Детальна інформація про продукт</h1>
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <section id="product-details">
            <?php if (!empty($product['image'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:200px;height:200px;">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><strong>Тип:</strong> <?php echo htmlspecialchars($product['type']); ?></p>
            <p><strong>Ціна:</strong> <?php echo htmlspecialchars($product['price']); ?> грн</p>
            <p><strong>Наявність:</strong> <?php echo $product['in_stock'] ? 'В наявності' : 'Немає'; ?></p>
            <p><strong>Опис:</strong> Тут можна додати додатковий опис продукту, якщо потрібно.</p>
            <a href="add_to_cart.php?product_id=<?php echo $product['id']; ?>">Додати до кошика</a>
            <a href="index.php">Повернутися до списку продуктів</a>
        </section>
        
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
