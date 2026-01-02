<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use QuizApp\User;
use QuizApp\Quiz;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = new User();
$user->loadById($_SESSION['user_id']);

$quiz = new Quiz();

// Handle account deletion
if (isset($_POST['delete_account'])) {
    $user->delete();
    session_destroy();
    header("Location: index.php?msg=account_deleted");
    exit;
}

// Show categories if no category selected
if (!isset($_GET['category_id'])) {
    $categories = $quiz->getCategories();
?>
    <!DOCTYPE html>
    <html lang="bg">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz App - Изберете категория</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" sizes="32x32" href="images/logo-32.png">
    </head>

    <body>
        <div class="animated-bg" id="animatedBg"></div>
        <div class="container">
            <h1>Quiz App</h1>
            <h2>Изберете категория</h2>

            <div class="category-list">
                <?php foreach ($categories as $cat): ?>
                    <a href="quiz.php?category_id=<?= $cat['id'] ?>" class="category-item">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="top-buttons">
                <?php if ($user->isAdmin()): ?>
                    <a href="admin.php" class="category-item" style="background:#27ae60;">Админ панел</a>
                <?php endif; ?>
                <a href="logout.php" class="category-item" style="background:#e74c3c;">Изход</a>
                <button type="button" onclick="confirmDelete()" class="category-item" style="background:#c0392b;">
                    Изтрий акаунта
                </button>
            </div>

            <form id="deleteForm" method="post" style="display:none;">
                <input type="hidden" name="delete_account" value="1">
            </form>
        </div>

        <script>
            const bg = document.getElementById('animatedBg');
            for (let i = 0; i < 260; i++) {
                const span = document.createElement('span');
                bg.appendChild(span);
            }

            function confirmDelete() {
                if (confirm('Сигурни ли сте, че искате да изтриете акаунта си? Това действие е необратимо!')) {
                    document.getElementById('deleteForm').submit();
                }
            }
        </script>
    </body>

    </html>
<?php
    exit;
}
