<?php
require 'db.php';

$table = $_GET['table'];

// Отримання списку колонок для таблиці
$columns = $pdo->query("DESCRIBE $table")->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [];
    foreach ($columns as $column) {
        if ($column != 'id' && $column != 'image') {
            $data[$column] = $_POST[$column];
        }
    }

    // Обробка завантаження зображення
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $data['image'] = $imageData;
    } else {
        $data['image'] = null;  // Якщо зображення не завантажене, встановлюємо значення NULL
    }

    $columnsList = implode(',', array_keys($data));
    $placeholders = implode(',', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $table ($columnsList) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_values($data));
    
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати запис</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Додати запис у таблицю <?php echo ucfirst($table); ?></h1>
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <form method="post" enctype="multipart/form-data">
            <?php foreach ($columns as $column): ?>
                <?php if ($column != 'id' && $column != 'image'): ?>
                    <div>
                        <label for="<?php echo $column; ?>"><?php echo $column; ?></label>
                        <input type="text" name="<?php echo $column; ?>" id="<?php echo $column; ?>" required>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- Поле для завантаження зображення -->
            <div>
                <label for="image">Зображення</label>
                <input type="file" name="image" id="image">
            </div>

            <button type="submit">Додати</button>
        </form>
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
