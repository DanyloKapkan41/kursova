<?php
require 'db.php';

$table = $_GET['table'];
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin.php");
exit;
?>
