<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// 1. Зареждане на .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// 2. Връзка с БД
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'quiz_app';
$username = $_ENV['DB_USER'] ?? 'root';
$db_pass = $_ENV['DB_PASSWORD'] ?? '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Грешка в базата: " . $e->getMessage());
}

$error = '';
$token = $_GET['token'] ?? '';

if (!$token) {
    $error = "Липсва токен за потвърждение!";
}

// 3. Обработка на формата
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error) {
    $password = $_POST['password'];
    $isCommon = false;
    $commonFile = __DIR__ . '/passes.txt';

    // Проверка за често срещана парола
    if (file_exists($commonFile)) {
        $commonPasswords = file($commonFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (in_array($password, $commonPasswords)) {
            $isCommon = true;
        }
    }

    if (strlen($password) < 6) {
        $error = "Паролата трябва да е поне 6 символа!";
    } elseif ($isCommon) {
        // ТУК Е КЛЮЧЪТ: Ако е в списъка, спираме и НЕ пренасочваме
        $error = "Тази парола е твърде лесна и често срещана. Моля, изберете по-сигурна!";
    } else {
        // Проверка на токена
        $stmt = $db->prepare("SELECT id FROM users WHERE verification_token = ? AND (verification_expires > NOW() OR verification_expires IS NULL) LIMIT 1");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = "Невалиден или изтекъл токен!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = $db->prepare("UPDATE users SET password_hash = ?, is_verified = 1, verification_token = NULL, verification_expires = NULL WHERE id = ?");

            if ($update->execute([$hash, $user['id']])) {
                // АВТОМАТИЧЕН ВХОД:
                $_SESSION['user_id'] = $user['id'];

                // ПРЕНАСОЧВАНЕ КЪМ QUIZ.PHP (вместо login.php)
                header("Location: quiz.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Потвърждение - Quiz App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo-32.png">
</head>

<body class="auth-page">
    <div class="animated-bg" id="animatedBg"></div>
    <div class="container">
        <div class="content">
            <h2>Задайте парола</h2>

            <?php if ($error): ?>
                <div class="message error" style="display:block;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" class="form">
                <div class="form-group">
                    <label for="password">Изберете нова парола</label>
                    <input type="password" id="password" name="password" minlength="6" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Активирай профила">
                </div>
            </form>
        </div>
    </div>
</body>

</html>