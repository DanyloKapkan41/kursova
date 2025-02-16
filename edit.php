<?php
require 'db.php';

$table = $_GET['table'];
$id = $_GET['id'];

// Отримання даних запису
$stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
$stmt->execute([$id]);
$record = $stmt->fetch();

// Якщо форму надіслано, обробка даних
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [];
    $columns = $pdo->query("DESCRIBE $table")->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($columns as $column) {
        if ($column != 'id' && $column != 'image') {
            $data[$column] = $_POST[$column];
        }
    }

    // Обробка завантаження нового зображення
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $data['image'] = $imageData;
    } else {
        $data['image'] = $record['image'];  // Якщо не завантажено нове зображення, залишити старе
    }

    $sets = implode('=?, ', array_keys($data)) . '=?';
    $sql = "UPDATE $table SET $sets WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge(array_values($data), [$id]));
    
    header("Location: index.php");
    exit;
}

// Функція для відображення зображення з BLOB-даних
function displayImage($imageData) {
    if ($imageData) {
        $base64Image = base64_encode($imageData);
        return "data:image/jpeg;base64," . $base64Image;
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати запис</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Редагувати запис у таблиці <?php echo ucfirst($table); ?></h1>
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <form method="post" enctype="multipart/form-data">
            <?php foreach ($record as $column => $value): ?>
                <?php if ($column != 'id' && $column != 'image'): ?>
                    <div>
                        <label for="<?php echo $column; ?>"><?php echo $column; ?></label>
                        <input type="text" name="<?php echo $column; ?>" id="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>" required>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- Відображення та заміна зображення -->
            <div>
                <label for="image">Зображення</label>
                <?php if ($record['image']): ?>
                    <img src="<?php echo displayImage($record['image']); ?>" alt="Current Image" width="100">
                <?php endif; ?>
                <input type="file" name="image" id="image">
            </div>

            <button type="submit">Зберегти</button>
        </form>
        
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
