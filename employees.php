<?php
session_start();
require 'functions.php';

$stmt = $pdo->query('SELECT * FROM employees');
$employees = $stmt->fetchAll();
$suppliers = getAllSuppliers($pdo);
$techSuppliers = getTechSuppliers($pdo);
$employeeName = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
$employee = $employeeName ? getEmployeeByName($pdo, $employeeName) : null;
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Електронний магазин (працівники)</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
</head>
<body>
    <header class="main_header">
        <h1>Електронний магазин (працівники)</h1>              
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <section id="employee">
            <h2>Співробітники</h2>
            <div id="employee-list">
            <?php foreach ($employees as $employee): ?>
                <div class="employee">
                <?php if (!empty($employee['image'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($employee['image']); ?>" alt="<?php echo htmlspecialchars($employee['name']); ?>">
                                <?php endif; ?>
                    <h3><?php echo htmlspecialchars($employee['name']); ?></h3>
                    <p><b>Посада:</b> <?php echo htmlspecialchars($employee['position']); ?></p>
                    <p><b>Дата народження:</b> <?php echo htmlspecialchars($employee['birthdate']); ?></p>
                    <p><b>Адреса:</b> <?php echo htmlspecialchars($employee['address']); ?></p>
                    <p><b>Телефон:</b> <?php echo htmlspecialchars($employee['phone']); ?></p>
                </div>
            <?php endforeach; ?>
            <?php
                $employeeName = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
                $employee = $employeeName ? getEmployeeByName($pdo, $employeeName) : null;
            ?>
            
            </div>
            <hr>
                <h2>Пошук співробітника за ПІБ</h2>
                <form method="GET">
                    <label for="employee_name">ПІБ:</label>
                    <input type="text" id="employee_name" name="employee_name" value="<?php echo htmlspecialchars($employeeName); ?>">
                    <button type="submit">Пошук</button>
                </form>
                <?php if ($employee): ?>
                    <div class="employee">
                        <h3><?php echo htmlspecialchars($employee['name']); ?></h3>
                        <p> <b>Посада:</b> <?php echo htmlspecialchars($employee['position']); ?></p>
                        <p> <b>Дата народження:</b> <?php echo htmlspecialchars($employee['birthdate']); ?></p>
                        <p> <b>Адреса:</b> <?php echo htmlspecialchars($employee['address']); ?></p>
                        <p> <b>Телефон:</b> <?php echo htmlspecialchars($employee['phone']); ?></p>
                    </div>
                <?php elseif ($employeeName): ?>
                    <p>Співробітника не знайдено.</p>
                <?php endif; ?>
            </section>

        <section id="suppliers">
            <h2>Список постачальників</h2>
            <div id="supplier-list">
                <?php foreach ($suppliers as $supplier): ?>
                    <div class="supplier">
                        <h3><?php echo htmlspecialchars($supplier['name']); ?></h3>
                        <p><b>Адреса:</b> <?php echo htmlspecialchars($supplier['address']); ?></p>
                        <p><b>Телефон:</b> <?php echo htmlspecialchars($supplier['phone']); ?></p>
                        <p><b>Email:</b> <?php echo htmlspecialchars($supplier['email']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <hr>
        <section id="tech-suppliers">
            <h2>Постачальники з назвою, що містить "Техно"</h2>
            <div id="tech-supplier-list">
                <?php foreach ($techSuppliers as $supplier): ?>
                    <div class="supplier">
                    <h3><?php echo htmlspecialchars($supplier['name']); ?></h3>
                        <p><b>Адреса:</b> <?php echo htmlspecialchars($supplier['address']); ?></p>
                        <p><b>Телефон:</b> <?php echo htmlspecialchars($supplier['phone']); ?></p>
                        <p><b>Email:</b> <?php echo htmlspecialchars($supplier['email']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <hr>
        
      
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
