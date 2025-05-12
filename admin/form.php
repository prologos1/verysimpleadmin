<?php
require_once 'config.php';
require_once 'db.php';
require_once 'auth.php';
requireLogin();
include 'templates/header.php';

$tableName = $_GET['table'] ?? null;
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? 'create'; // create или update
$primaryKeyName = $_GET['primaryKeyName'] ?? null; // Получаем имя ключа

if (!$tableName || !in_array($tableName, getTableList($pdo))) {
    echo "<div class='alert alert-danger'>Таблица не найдена.</div>";
    include 'templates/footer.php';
    exit;
}

if (!$primaryKeyName) {
    $primaryKeyName = getPrimaryKeyName($pdo, $tableName);
}

$structure = getTableStructure($pdo, $tableName);
$record = ($id && $action == 'update') ? getRecordById($pdo, $tableName, $id, $primaryKeyName) : null;

include 'templates/form.php';
include 'templates/footer.php';
?>
