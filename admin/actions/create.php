<?php
require_once '../config.php';
require_once '../db.php';
require_once '../auth.php';
requireLogin();

$tableName = $_POST['table'] ?? null;

$primaryKeyName = $_POST['primaryKeyName'] ?? null; // Получаем имя ключа
$id = $_POST['id'] ?? null;

if (!$tableName || !in_array($tableName, getTableList($pdo))) {
    die("Таблица не найдена.");
}

// Подготовка данных для вставки
$data = [];
$structure = getTableStructure($pdo, $tableName);

foreach ($structure as $column) {
    $fieldName = $column['Field'];
    $type = strtoupper($column['Type']);

    // Пропустить только если это автоинкремент
    if ($fieldName === $primaryKeyName && strpos(strtolower($column['Extra']), 'auto_increment') !== false) {
        continue;
    }

    $rawValue = $_POST[$fieldName] ?? null;
    $value = trim((string)$rawValue);

    // Обязательное поле
    // if ($column['Null'] === 'NO' && $value === '' && $fieldName !== $primaryKeyName) {
        // die($primaryKeyName ."Поле " . $fieldName . " обязательно для заполнения.");
    // }
	
    // Обязательное поле (если нет дефолта и не автоинкремент)
    if (
        $column['Null'] === 'NO' &&
        $value === '' &&
        !isset($column['Default']) &&
        !($fieldName === $primaryKeyName && strpos(strtolower($column['Extra']), 'auto_increment') !== false)
    ) {
        die("Поле " . $fieldName . " обязательно для заполнения.");
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


$newId = createRecord($pdo, $tableName, $data);

header("Location: ../table.php?table=" . urlencode($tableName));
exit;
