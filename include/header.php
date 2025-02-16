<?php
session_start();
?>
<a href="index.php">Головна</a>
        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 2): ?>
            <a href="admin.php">Адмінка</a>
            <a href="employees.php">Робітники</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 1): ?>
            <a href="employees.php">Робітники</a>
        <?php endif; ?>
        <!-- Кнопка "Вхід" або "Вихід" залежно від статусу авторизації -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 0): ?>
                    <a href="cart.php">Кошик</a>
                <?php endif; ?>   
            <p>Ласкаво просимо, <?php echo htmlspecialchars($_SESSION['username']); ?>! (<a href="logout.php">Вийти</a>)</p>                        
            <?php else: ?>
                <a href="enter.php">Вхід</a>
                <a href="register.php">Регістрація</a>
            <?php endif; ?>
