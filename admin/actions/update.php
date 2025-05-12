<?php
require_once '../config.php';
require_once '../db.php';
require_once '../auth.php';
requireLogin();

$tableName = $_POST['table'] ?? null;
$id = $_POST['id'] ?? null;
$primaryKeyName = $_POST['primaryKeyName'] ?? null; // Получаем имя ключа

if (!$tableName || !in_array($tableName, getTableList($pdo)) || !$id || !$primaryKeyName ) {
    die("Неверные параметры.");
}

$data = [];
$structure = getTableStructure($pdo, $tableName);

foreach ($structure as $column) {
    $fieldName = $column['Field'];
    $type = strtoupper($column['Type']);

    if ($fieldName == $primaryKeyName) { // if ($fieldName == 'id') {
        continue; // Не обновляем первичный ключ
    }

    $rawValue = $_POST[$fieldName] ?? null;
    $value = trim((string)$rawValue);

    // Обязательное поле
    if ($column['Null'] === 'NO' && $value === '' && $fieldName !== $primaryKeyName) {
        die($primaryKeyName ."Поле " . $fieldName . " обязательно для заполнения.");
    }

    // Обработка даты и времени
    if (strpos($type, 'DATE') !== false || strpos($type, 'TIME') !== false) {
        $value = ($value === '') ? null : $value;
    }
    // Числовые типы
    elseif (preg_match('/(INT|DECIMAL|FLOAT|DOUBLE)/', $type)) {
        $value = ($value === '') ? null : $value + 0; // автоопределение числа
    }
    // Остальные (строки, enum и пр.)
    else {
        $value = ($value === '') ? null : strip_tags($value);
    }

    $data[$fieldName] = $value;
}

$affectedRows = updateRecord($pdo, $tableName, $id, $data, $primaryKeyName);

header("Location: ../table.php?table=" . urlencode($tableName));
exit;
