<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// 1. Зареждане на .env променливите
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// 2. Връзка с базата данни (използваме вашите променливи от .env)
try {
    $db = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Грешка при връзка с базата данни.");
}

$error = '';

// 3. Обработка на формата при POST заявка
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_number = $_POST['course_number'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE course_number = ?");
    $stmt->execute([$course_number]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверка: потребителят съществува, потвърден е и паролата съвпада
    if ($user && $user['is_verified'] && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: quiz.php"); // Пренасочване към успешната страница
        exit;
    } else {
        // Уточняваме грешката за по-добра навигация
        if ($user && !$user['is_verified']) {
            $error = "Профилът още не е потвърден! Проверете имейла си.";
        } else {
            $error = "Грешен курс номер или парола!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Quiz App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo-32.png">
</head>

<body class="auth-page">
    <div class="animated-bg" id="animatedBg"></div>

    <div class="container">
        <div class="content">
            <h2>Вход</h2>

            <?php if ($error): ?>
                <div class="message error" style="display:block;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" class="form">
                <div class="form-group">
                    <label for="course_number">Курс номер</label>
                    <input type="text" id="course_number" name="course_number" required>
                </div>

                <div class="form-group">
                    <label for="password">Парола</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="auth-links">
                    <a href="forgot_password.php">Забравена парола?</a>
                    <a href="index.php">Регистрация</a>
                </div>

                <div class="form-group">
                    <input type="submit" value="Вход">
                </div>
            </form>
        </div>
    </div>
</body>

</html>