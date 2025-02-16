<?php
session_start();
require 'db.php';  // Підключення до бази даних

// Перевірка, чи були надіслані дані форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Підготовка та виконання SQL-запиту для отримання даних користувача
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    // Перевірка наявності користувача та пароля
    if ($user && password_verify($password, $user['password'])) {
        // Збереження даних користувача у сесії
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['status'] = $user['status'];

        // Перенаправлення на головну сторінку
        header("Location: index.php");
        exit;
    } else {
        $error = "Неправильний логін або пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід користувача</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header class="main_header">
        <h1>Електронний магазин</h1>        
        <?php include 'include/header.php'; ?>
    </header>
    <main class="main_login">
        <section class="login">
            <h2>Вхід користувача</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="enter.php" method="POST">
                <label for="login">Логін:</label>
                <input type="text" id="login" name="login" required>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Увійти</button>
            </form>         
        </section>
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
