<?php
require_once 'config/db.php';

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_answers'])) {
    $selectedQuizIDs = $_POST['quiz_answers']; 

    if (!empty($selectedQuizIDs)) {
        $inQuery = implode(',', array_fill(0, count($selectedQuizIDs), '?'));
        
        $sql = "
            SELECT m.*, COUNT(h.TagID) as score
            FROM media m
            JOIN has h ON m.MediaID = h.MediaID
            JOIN filter f ON h.TagID = f.TagID
            WHERE f.QuizID IN ($inQuery)
            GROUP BY m.MediaID
            ORDER BY score DESC
            LIMIT 5
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($selectedQuizIDs);
        $results = $stmt->fetchAll();
    }
}

$quizzes = $pdo->query("SELECT * FROM quiz LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Story Discovery Quiz - Film-Folio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Story Recommendation Quiz</h1>

    <form method="POST" action="quiz.php">
        <?php foreach ($quizzes as $q): ?>
            <p>
                <strong><?= htmlspecialchars($q['quiztext']) ?></strong><br>
                <label>
                    <input type="checkbox" name="quiz_answers[]" value="<?= $q['QuizID'] ?>"> 
                    Include preference
                </label>
            </p>
        <?php endforeach; ?>
        <button type="submit">Find Matches</button>
    </form>

    <?php if (!empty($results)): ?>
        <h2>Your Top Recommendations:</h2>
        <ul>
            <?php foreach ($results as $res): ?>
                <li>
                    <strong><?= htmlspecialchars($res['title']) ?></strong> (<?= $res['mediatype'] ?>) 
                    - Match Score: <?= $res['score'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>