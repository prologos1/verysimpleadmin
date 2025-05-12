<?php
require_once '../config.php';
require_once '../db.php';
require_once '../auth.php';
requireLogin();

$tableName = $_GET['table'] ?? null;
$id = $_GET['id'] ?? null;
$primaryKeyName = $_GET['primaryKeyName'] ?? null; // Получаем имя ключа

if (!$tableName || !in_array($tableName, getTableList($pdo)) || !$id || !$primaryKeyName) {
    die("Неверные параметры.");
}

$deletedRows = deleteRecord($pdo, $tableName, $id, $primaryKeyName);

header("Location: ../table.php?table=" . urlencode($tableName));
exit;
