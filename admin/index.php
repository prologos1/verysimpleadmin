<?php
require_once 'auth.php';
requireLogin(); // Требуем авторизацию


require_once 'config.php';
require_once 'db.php';
include 'templates/header.php'; // Подключаем шапку

$tables = getTableList($pdo);

include 'templates/table_list.php'; // Подключаем шаблон списка таблиц
include 'templates/footer.php'; // Подключаем подвал
?>
