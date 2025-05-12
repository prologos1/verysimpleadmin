<?php

session_start(); // Запускаем сессию в начале файла

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function login($username, $password) {
    // **ОЧЕНЬ ВАЖНО:** Никогда не храните пароли в открытом виде!
    // Используйте хеширование паролей (например, password_hash и password_verify).
    $users = [
        'user1' => 'a7db43d42fd817f88efda05628300bf7c219baed3ba0e828b9ba7f460e5d47e0', // password for user1: admin 
    ];
	$salt = 'frgh711&@ftq';

    if (isset($users[$username]) && $users[$username] === hash('sha256', $salt . $password)) {
        $_SESSION['user_id'] = $username;
        return true;
    }

    return false;
}

function logout() {
    session_unset();
    session_destroy();
}
