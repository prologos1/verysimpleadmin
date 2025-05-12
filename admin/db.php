<?php
// db.php

require_once 'config.php'; // Подключаем файл конфигурации

// Функция для получения имени ключевого поля таблицы
function getPrimaryKeyName($pdo, $tableName) {
    $stmt = $pdo->prepare("SHOW KEYS FROM `$tableName` WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['Column_name'];
    } else {
        return 'id'; // Значение по умолчанию, если первичный ключ не найден
    }
}

// Функция для получения списка таблиц в базе данных
function getTableList($pdo) {
    $stmt = $pdo->query("SHOW TABLES");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


// Функция для получения структуры таблицы (имена столбцов)
function getTableStructure($pdo, $tableName) {
    $stmt = $pdo->prepare("SHOW COLUMNS FROM `$tableName`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// функция для получения данных одной записи по первичному ключу (например - id)
function getRecordById($pdo, $tableName, $id, $primaryKeyName) {
    $stmt = $pdo->prepare("SELECT * FROM `$tableName` WHERE `$primaryKeyName` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Функция для создания записи
function createRecord($pdo, $tableName, $data) {
    $columns = array_keys($data);
    $placeholders = array_fill(0, count($columns), '?');

    $sql = "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

// print_r( "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $data) . ")" ); die; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_values($data));
    return $pdo->lastInsertId(); // Возвращаем ID вставленной записи
}

// Функция для обновления записи
function updateRecord($pdo, $tableName, $id, $data, $primaryKeyName) {
    $setClauses = [];
    foreach ($data as $column => $value) {
        $setClauses[] = "`$column` = ?";
    }
    $sql = "UPDATE `$tableName` SET " . implode(', ', $setClauses) . " WHERE `$primaryKeyName` = ?";
    $stmt = $pdo->prepare($sql);

    $values = array_values($data);
    $values[] = $id; // Добавляем ID в конец массива значений для WHERE clause
    $stmt->execute($values);
    return $stmt->rowCount();
}


// Функция для удаления записи
function deleteRecord($pdo, $tableName, $id, $primaryKeyName) {
    $stmt = $pdo->prepare("DELETE FROM `$tableName` WHERE `$primaryKeyName` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}



// функция для получения данных из таблицы с поиском и пагинацией
function getTableData($pdo, $tableName, $page = 1, $limit = 20, $search = null) {
    $offset = ($page - 1) * $limit;
    $sql = "SELECT * FROM `$tableName`";

    $whereClauses = [];
    if ($search) {
        $structure = getTableStructure($pdo, $tableName);
        foreach ($structure as $column) {
            $whereClauses[] = "`" . $column['Field'] . "` LIKE :search";
        }
        $sql .= " WHERE " . implode(" OR ", $whereClauses);
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    if ($search) {
        $searchTerm = '%' . $search . '%';
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// функция для получения общего количества записей с учетом поиска
function getTotalRecords($pdo, $tableName, $search = null) {
    $sql = "SELECT COUNT(*) FROM `$tableName`";
    if ($search) {
        $whereClauses = [];
        $structure = getTableStructure($pdo, $tableName);
        foreach ($structure as $column) {
            $whereClauses[] = "`" . $column['Field'] . "` LIKE :search";
        }
        $sql .= " WHERE " . implode(" OR ", $whereClauses);
    }

    $stmt = $pdo->prepare($sql);
    if ($search) {
        $searchTerm = '%' . $search . '%';
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}

