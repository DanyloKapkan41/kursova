<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "StudyCourse");

$mysql = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysql->connect_error) exit('Помилка під\'єднання');
$mysql->set_charset('utf8');
?>
