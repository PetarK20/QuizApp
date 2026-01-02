$categoryId = (int)$_GET['category_id'];
$category = $quiz->getCategoryById($categoryId);

if (!$category) {
    header("Location: quiz.php");
    exit;
}

// Initialize quiz start time
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_SESSION['quiz_start_time'])) {
    $_SESSION['quiz_start_time'] = time();
}

// Get or load questions
if (isset($_SESSION['quiz_questions']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $questions = $_SESSION['quiz_questions'];
} else {
    $questions = $quiz->getQuestions($categoryId);
    $_SESSION['quiz_questions'] = $questions;
}

$result = null;

// Process answers
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $result = $quiz->submitAnswers(
        $user->getId(),
        $categoryId,
        $questions,
        $_POST['answers'],
        $_SESSION['quiz_start_time'] ?? time()
    );

    unset($_SESSION['quiz_questions']);
    unset($_SESSION['quiz_start_time']);
}

$previousScores = $quiz->getUserScores($user->getId(), $categoryId);
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - <?= htmlspecialchars($category['name']) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="logo-32.png">
</head>

<body>
    <div class="animated-bg" id="animatedBg"></div>
    <div class="container">
        <h2>Quiz - <?= htmlspecialchars($category['name']) ?></h2>

        <?php if ($result): ?>
            <div class="result">
                Резултат: <?= $result['score'] ?> / <?= $result['total'] ?>
            </div>

            <div class="top-buttons">
                <a href="quiz.php" class="category-item">Обратно към категориите</a>
                <a href="quiz.php?category_id=<?= $categoryId ?>" class="category-item">Повтори теста</a>
                <a href="logout.php" class="category-item" style="background:#e74c3c;">Изход</a>
            </div>

            <h3>Преглед на въпросите:</h3>
            <?php foreach ($result['review'] as $r): ?>
                <div class="review-question <?= $r['is_correct'] ? 'correct' : 'wrong' ?>">
                    <p><strong><?= htmlspecialchars($r['question']) ?></strong></p>
                    <p>Ваш отговор:
                        <span class="<?= $r['is_correct'] ? 'correct-answer' : 'user-answer' ?>">
                            <?= htmlspecialchars($r['user_answer']) ?>
                        </span>
                    </p>
                    <?php if (!$r['is_correct']): ?>
                        <p>Правилен отговор:
                            <span class="correct-answer"><?= htmlspecialchars($r['correct_answer']) ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <form id="quizForm" method="post">
                <?php foreach ($questions as $i => $q): ?>
                    <div class="quiz-question <?= $i === 0 ? 'active' : '' ?>" data-question="<?= $i ?>">
                        <p><strong><?= ($i + 1) . ". " . htmlspecialchars($q['question_text']) ?></strong></p>
                        <?php foreach ($q['answers'] as $j => $a): ?>
                            <label>
                                <input type="radio" name="answers[<?= $i ?>]" value="<?= $j ?>"
                                    onchange="document.querySelector('[data-question=&quot;<?= $i ?>&quot;]').classList.remove('unanswered')">
                                <?= htmlspecialchars($a['text']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <div class="nav-buttons">
                    <button type="button" id="prevBtn" onclick="navigate(-1)" style="display:none;">Назад</button>
                    <button type="button" id="nextBtn" onclick="navigate(1)">Напред</button>
                    <button type="submit" id="submitBtn" style="display:none;">Изпрати отговорите</button>
                </div>
            </form>
        <?php endif; ?>

        <h3>Предишни резултати за <?= htmlspecialchars($category['name']) ?>:</h3>
        <?php if (!empty($previousScores)): ?>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Резултат</th>
                        <th>Общо</th>
                        <th>Време</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($previousScores as $row):
                        $duration = (int)($row['duration'] ?? 0);
                        $minutes = floor($duration / 60);
                        $seconds = $duration % 60;
                        $timeStr = sprintf("%d мин %02d сек", $minutes, $seconds);
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['score']) ?></td>
                            <td><?= htmlspecialchars($row['total']) ?></td>
                            <td><?= $timeStr ?></td>
                            <td><?= htmlspecialchars($row['quiz_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Все още нямате резултати в тази категория.</p>
        <?php endif; ?>
    </div>

    <script>
        const bg = document.getElementById('animatedBg');
        for (let i = 0; i < 260; i++) {
            const span = document.createElement('span');
            bg.appendChild(span);
        }

        let current = 0;
        const total = <?= count($questions) ?>;

        function navigate(dir) {
            const questions = document.querySelectorAll('.quiz-question');
            questions[current].classList.remove('active');
            current += dir;
            questions[current].classList.add('active');
            updateButtons();
        }

        function updateButtons() {
            document.getElementById('prevBtn').style.display = current === 0 ? 'none' : 'inline-block';
            document.getElementById('nextBtn').style.display = current === total - 1 ? 'none' : 'inline-block';
            document.getElementById('submitBtn').style.display = current === total - 1 ? 'inline-block' : 'none';
        }

        document.getElementById('quizForm')?.addEventListener('submit', function(e) {
            const questions = document.querySelectorAll('.quiz-question');
            let firstUnanswered = null;

            questions.forEach((q, i) => {
                const answered = q.querySelector('input[type="radio"]:checked');
                if (!answered) {
                    q.classList.add('unanswered');
                    if (firstUnanswered === null) firstUnanswered = i;
                } else {
                    q.classList.remove('unanswered');
                }
            });

            if (firstUnanswered !== null) {
                e.preventDefault();
                questions[current].classList.remove('active');
                current = firstUnanswered;
                questions[current].classList.add('active');
                updateButtons();
                alert('Моля, отговорете на всички въпроси! Пропуснат въпрос № ' + (firstUnanswered + 1));
            }
        });

        updateButtons();
    </script>
</body>
</html>
