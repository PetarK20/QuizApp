<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// 1. Зареждане на .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// 2. Проверка дали потребителят е влязъл
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 3. Връзка с БД
try {
    $db = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4", 
        $_ENV['DB_USER'], 
        $_ENV['DB_PASSWORD']
    );
    
    // Изтриване на потребителя
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    // Унищожаване на сесията
    session_destroy();
    
    // Пренасочване към регистрация със съобщение
    header("Location: index.php?msg=deleted");
    exit;
    
} catch (PDOException $e) {
    die("Грешка при изтриване на акаунта.");
}