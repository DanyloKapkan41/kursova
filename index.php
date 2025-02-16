<?php
session_start();
require 'functions.php';

$minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : 100000;
$inStockOnly = isset($_GET['in_stock_only']) && $_GET['in_stock_only'] == '1';
$productType = isset($_GET['product_type']) ? $_GET['product_type'] : '';

// Отримуємо список унікальних типів товарів для заповнення випадаючого списку
$productTypes = getProductTypes($pdo);

// Отримання відфільтрованих продуктів
$filteredProducts = getFilteredProducts($pdo, $minPrice, $maxPrice, $inStockOnly, $productType);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Електронний магазин</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header class="main_header">
        <h1>Електронний магазин</h1>        
        <?php include 'include/header.php'; ?>
    </header>
    
    <main>
        <section id="products-filter">
            <h2>Фільтрація продуктів</h2>
            <form method="GET">
                <label for="min_price">Мінімальна ціна:</label>
                <input type="number" id="min_price" name="min_price" value="<?php echo htmlspecialchars($minPrice); ?>">

                <label for="max_price">Максимальна ціна:</label>
                <input type="number" id="max_price" name="max_price" value="<?php echo htmlspecialchars($maxPrice); ?>">

                <label for="product_type">Тип продукту:</label>
                <select id="product_type" name="product_type">
                    <option value="">Всі типи</option>
                    <?php foreach ($productTypes as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['type']); ?>" <?php if ($productType == $type['type']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($type['type']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="in_stock_only">
                    <input type="checkbox" id="in_stock_only" name="in_stock_only" value="1" <?php if ($inStockOnly) echo 'checked'; ?>>
                    Тільки в наявності
                </label>

                <button type="submit">Застосувати фільтри</button>
            </form>
        </section>
        
        <section id="filtered-products">
            <h2>Список продуктів</h2>
            <div id="product-list">
                <?php foreach ($filteredProducts as $product): ?>
                    <div class="product">
                        <a href="product.php?id=<?php echo $product['id']; ?>" target="_blank">
                            <?php if (!empty($product['image'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        </a>
                        <p>Тип: <?php echo htmlspecialchars($product['type']); ?></p>
                        <p>Ціна: <?php echo htmlspecialchars($product['price']); ?> грн</p>
                        <p>Наявність: <?php echo $product['in_stock'] ? 'В наявності' : 'Немає'; ?></p>
                        <a href="add_to_cart.php?product_id=<?php echo $product['id']; ?>">Додати до кошика</a>

                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
       
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
