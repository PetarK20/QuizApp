<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use QuizApp\User;
use QuizApp\Mailer;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $result = $user->register(trim($_POST['email']), trim($_POST['course_number']));
    
    if ($result['success']) {
        $mailer = new Mailer();
        if ($mailer->sendVerificationEmail($result['email'], $result['token'])) {
            $success = "Регистрацията е успешна! Проверете имейла си за потвърждение.";
        } else {
            $error = "Грешка при изпращане на имейл. Моля, опитайте отново.";
        }
    } else {
        $error = $result['message'];
    }
}

$showSuccessMessage = isset($_GET['msg']) && $_GET['msg'] === 'account_deleted';
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
                    <input type="email" id="email" name="email" required>
                    <label for="email">Имейл адрес</label>
                </div>
                
                <div class="form-group">
                    <input type="text" id="course_number" name="course_number" 
                           pattern="\d{1,5}" title="Максимум 5 цифри" required>
                    <label for="course_number">Курс номер (до 5 цифри)</label>
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
    
    <script>
        const bg = document.getElementById('animatedBg');
        for (let i = 0; i < 260; i++) {
            const span = document.createElement('span');
            bg.appendChild(span);
        }
    </script>
</body>
</html>