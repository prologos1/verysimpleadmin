<?php
require_once 'config.php';
require_once 'db.php';
include 'templates/header.php';
require_once 'auth.php';
requireLogin();

$tableName = $_GET['table'] ?? null;
$page = $_GET['page'] ?? 1;
$limit = 20;
$search = $_GET['search'] ?? null;

if (!$tableName || !in_array($tableName, getTableList($pdo))) {
    echo "<div class='alert alert-danger'>Таблица не найдена.</div>";
    include 'templates/footer.php';
    exit;
}

$primaryKeyName = getPrimaryKeyName($pdo, $tableName); // Получаем имя ключевого поля

// Обработка AJAX запроса
if (isset($_GET['ajax'])) {
    $data = getTableData($pdo, $tableName, $page, $limit, $search);
    echo json_encode(['data' => $data, 'primaryKeyName' => $primaryKeyName]); // Отправляем и имя ключа
    exit;
}

$data = getTableData($pdo, $tableName, $page, $limit, $search);
$totalRecords = getTotalRecords($pdo, $tableName, $search);
$totalPages = ceil($totalRecords / $limit);
$structure = getTableStructure($pdo, $tableName);

include 'templates/table_data.php';
include 'templates/footer.php';
 
