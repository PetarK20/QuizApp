<?php
session_start();

// Show errors for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to load autoloader
$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    die('<h1>Error: Composer autoloader not found</h1>
         <p>Please run the following commands in your QuizApp directory:</p>
         <pre>composer install
composer dump-autoload</pre>
         <p>Current directory: ' . __DIR__ . '</p>');
}

require $autoloadPath;

// Check if class exists
if (!class_exists('QuizApp\\User')) {
    die('<h1>Error: QuizApp\\User class not found</h1>
         <p>Please ensure:</p>
         <ol>
             <li>File <code>src/User.php</code> exists</li>
             <li>File starts with <code>namespace QuizApp;</code></li>
             <li>You ran <code>composer dump-autoload</code></li>
         </ol>
         <p><a href="check_setup.php">Run Diagnostics</a></p>');
}

use QuizApp\User;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = new User();
        
        if ($user->login($_POST['course_number'], $_POST['password'])) {
            header("Location: quiz.php");
            exit;
        } else {
            $error = "Грешен курс номер или парола!";
        }
    } catch (Exception $e) {
        $error = "Грешка: " . $e->getMessage();
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
    <link rel="icon" type="image/png" sizes="32x32" href="imeges/logo-32.png">
</head>
<body class="auth-page">
    <div class="animated-bg" id="animatedBg"></div>
    
    <div class="container">
        <div class="content">
            <h2>Вход</h2>

            <?php if ($error): ?>
                <div class="message error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" class="form">
                <div class="form-group">
                    <input type="text" id="course_number" name="course_number" required autofocus>
                    <label for="course_number">Курс номер</label>
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Парола</label>
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
    
    <script>
        const bg = document.getElementById('animatedBg');
        for (let i = 0; i < 260; i++) {
            const span = document.createElement('span');
            bg.appendChild(span);
        }
    </script>
</body>
</html>