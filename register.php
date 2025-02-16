<?php
session_start();
require 'db.php';  // Підключення до бази даних

// Перевірка, чи була надіслана форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $status = 0; // За замовчуванням - звичайний користувач

    // Перевірка на помилки
    $errors = [];

    // Перевірка унікальності логіна
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = "Користувач з таким логіном вже існує.";
    }

    // Перевірка пароля і підтвердження
    if ($password !== $confirmPassword) {
        $errors[] = "Паролі не співпадають.";
    }

    // Перевірка довжини пароля
    if (strlen($password) < 6) {
        $errors[] = "Пароль повинен містити мінімум 6 символів.";
    }

    // Якщо помилок немає, реєструємо користувача
    if (empty($errors)) {
        // Хешування пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Вставка нового користувача в базу даних
        $stmt = $pdo->prepare("INSERT INTO users (username, password, status) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $status]);

        // Після реєстрації переспрямовуємо користувача на сторінку входу
        $_SESSION['message'] = "Реєстрація успішна! Увійдіть за допомогою своїх даних.";
        header("Location: enter.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header class="main_header">
        <h1>Реєстрація</h1>
        <?php include 'include/header.php'; ?>
    </header>
    <main class="main_register">
        <section class="register">
            <h2>Створити новий обліковий запис</h2>
            <?php if (!empty($errors)): ?>
                <div style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <label for="username">Логін:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm_password">Підтвердьте пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                
                <button type="submit">Зареєструватися</button>
            </form>
            <p>Вже маєте обліковий запис? <a href="enter.php">Увійти</a></p>
        </section>
        
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
