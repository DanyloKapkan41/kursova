<?php
require 'functions.php';
require 'db.php';

function getAllRecords($pdo, $table) {
    $stmt = $pdo->query("SELECT * FROM $table");
    return $stmt->fetchAll();
}

$tables = ['suppliers', 'products', 'employees', 'users'];

$data = [];
foreach ($tables as $table) {
    $data[$table] = getAllRecords($pdo, $table);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Електронний магазин (адмін)</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="icons/Fasticon-Shop-Cart-Shop-cart.ico" type="image/x-icon">
    
</head>
<body>
    <header class="main_header">
        <h1>Електронний магазин (адмін)</h1>
        <?php include 'include/header.php'; ?>
    </header>
    <main>
        <?php foreach ($tables as $table): ?>
            <section id="<?php echo $table; ?>">
                <h2><?php echo ucfirst($table); ?></h2>
                <table>
                    <thead>
                        <tr>
                            <?php foreach (array_keys($data[$table][0]) as $column): ?>
                                <th><?php echo $column; ?></th>
                            <?php endforeach; ?>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody class="qwe">
                        <?php foreach ($data[$table] as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars($cell); ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <a target="_blank" href="edit.php?table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>">Редагувати</a>
                                    <a class="Del" target="_blank" href="delete.php?table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a class="ADD" target="_blank" href="add.php?table=<?php echo $table; ?>">Додати новий запис</a>
            </section>
        <?php endforeach; ?>
        
    </main>
    <?php include 'include/footer.php'; ?>
</body>
</html>
