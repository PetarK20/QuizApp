<?php
session_start();

// Проверка дали потребителят е влязъл
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Успешен вход - Quiz App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo-32.png">
</head>
<body class="auth-page">
    <div class="animated-bg" id="animatedBg"></div>
    
    <div class="container">
        <div class="content" style="text-align: center;">
            <h1 style="color: #ff5100; margin-bottom: 20px;">Поздравления!</h1>
            <p style="font-size: 1.2rem; color: #a72020ff; margin-bottom: 30px;">
                Ти се регистрира / влезе успешно.
            </p>
            
            <a href="logout.php" style="
                display: inline-block;
                padding: 12px 30px;
                background-color: #ff5100;
                color: #000;
                text-decoration: none;
                font-weight: bold;
                border-radius: 5px;
                text-transform: uppercase;
            ">Изход</a>
        </div>
    </div>
</body>
</html>