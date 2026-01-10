<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Зареждане на променливите от .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Конфигурация на БД (quiz_app)
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'quiz_app';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Грешка при връзка с БД: " . $e->getMessage());
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $course_number = trim($_POST['course_number']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Невалиден имейл адрес!';
    } elseif (!preg_match('/^\d{5}$/', $course_number)) {
        $error = 'Курс номерът трябва да е число с точно 5 цифри!';
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? OR course_number = ? LIMIT 1");
        $stmt->execute([$email, $course_number]);

        if ($stmt->rowCount() > 0) {
            $error = 'Имейл или курс номер вече съществува!';
        } else {
            $token = bin2hex(random_bytes(16));
            $expires = date('Y-m-d H:i:s', time() + 7200);

            $stmt = $db->prepare("INSERT INTO users (email, course_number, verification_token, verification_expires) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$email, $course_number, $token, $expires])) {

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = $_ENV['MAIL_HOST'];
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $_ENV['MAIL_USERNAME'];
                    $mail->Password   = $_ENV['MAIL_PASSWORD'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = $_ENV['MAIL_PORT'];
                    $mail->CharSet    = 'UTF-8';
                    $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);

                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Потвърждение на регистрация';

                    $verifyLink = rtrim($_ENV['APP_URL'], '/') . "/verify.php?token=" . $token;
                    $mail->Body = "Натиснете тук, за да потвърдите: <a href='$verifyLink'>$verifyLink</a>";

                    $mail->send();
                    $success = "Регистрацията е успешна! Проверете имейла си.";
                } catch (Exception $e) {
                    $error = "Грешка при имейл: " . $mail->ErrorInfo;
                }
            }
        }
    }
}
$showSuccessMessage = isset($_GET['deleted']) && $_GET['deleted'] == '1';
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Quiz App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo-32.png">
</head>

<body class="auth-page">
    <div class="animated-bg" id="animatedBg"></div>

    <div class="container">
        <div class="content">
            <h2>Регистрация</h2>

            <?php if ($showSuccessMessage): ?>
                <div class="message success">Акаунтът беше успешно изтрит.</div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="message error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="message success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" class="form">
                <div class="form-group">
                    <label for="email">Имейл адрес</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="course_number">Курс номер (точно 5 цифри)</label>
                    <input type="text"
                        id="course_number"
                        name="course_number"
                        inputmode="numeric"
                        pattern="\d{5}"
                        minlength="5"
                        maxlength="5"
                        title="Моля, въведете точно 5 цифри"
                        required>
                </div>

                <div class="auth-links">
                    <span></span>
                    <a href="login.php">Вход</a>
                </div>

                <div class="form-group">
                    <input type="submit" value="Регистрация">
                </div>
            </form>
        </div>
    </div>
</body>


</html>
