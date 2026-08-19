<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_rating'])) {
    $adaptationID = $_POST['adaptation_id'];
    $userID       = 1; 
    $loyalty      = $_POST['loyalty'];
    $casting      = $_POST['casting'];
    $overall      = $_POST['overall'];

    $stmt = $pdo->prepare("
        INSERT INTO adaptationrating (UserID, AdaptationID, loyaltyscore, castingscore, overallscore)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$userID, $adaptationID, $loyalty, $casting, $overall]);
    header("Location: adaptation.php?id=" . $adaptationID);
    exit;
}


$adaptations = $pdo->query("
    SELECT a.ID AS AdaptationID, 
           b.title AS BookTitle, b.description AS BookDesc, ba.author,
           m.title AS MovieTitle, m.description AS MovieDesc, m.director, m.runtime
    FROM adaptation a
    JOIN media b ON a.BookID = b.MediaID
    JOIN media m ON a.MovieID = m.MediaID
    LEFT JOIN book_author ba ON b.MediaID = ba.MediaID
")->fetchAll();

$selectedID = $_GET['id'] ?? ($adaptations[0]['AdaptationID'] ?? null);


$ratingSummary = null;
if ($selectedID) {
    $stmt = $pdo->prepare("
        SELECT AVG(loyaltyscore) as avg_loyalty, 
               AVG(castingscore) as avg_casting, 
               AVG(overallscore) as avg_overall
        FROM adaptationrating
        WHERE AdaptationID = ?
    ");
    $stmt->execute([$selectedID]);
    $ratingSummary = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adaptation Hub - Film-Folio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Adaptation Hub</h1>
    

    <form method="GET" action="adaptation.php">
        <select name="id" onchange="this.form.submit()">
            <?php foreach ($adaptations as $ad): ?>
                <option value="<?= $ad['AdaptationID'] ?>" <?= $selectedID == $ad['AdaptationID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ad['BookTitle']) ?> ➔ <?= htmlspecialchars($ad['MovieTitle']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php 
    $current = array_filter($adaptations, fn($a) => $a['AdaptationID'] == $selectedID);
    $current = reset($current);
    if ($current): 
    ?>
        <div style="display:flex; gap:20px; margin-top:20px;">
            <div style="flex:1; border:1px solid #ccc; padding:10px;">
                <h3>📖 Book Details</h3>
                <h4><?= htmlspecialchars($current['BookTitle']) ?></h4>
                <p><strong>Author:</strong> <?= htmlspecialchars($current['author'] ?? 'N/A') ?></p>
                <p><?= htmlspecialchars($current['BookDesc']) ?></p>
            </div>
            <div style="flex:1; border:1px solid #ccc; padding:10px;">
                <h3>🎬 Movie Details</h3>
                <h4><?= htmlspecialchars($current['MovieTitle']) ?></h4>
                <p><strong>Director:</strong> <?= htmlspecialchars($current['director'] ?? 'N/A') ?></p>
                <p><strong>Runtime:</strong> <?= $current['runtime'] ?> mins</p>
                <p><?= htmlspecialchars($current['MovieDesc']) ?></p>
            </div>
        </div>

        <h3>Adaptation Community Scores</h3>
        <p>Faithfulness: <?= round($ratingSummary['avg_loyalty'] ?? 0, 1) ?> / 5</p>
        <p>Casting: <?= round($ratingSummary['avg_casting'] ?? 0, 1) ?> / 5</p>
        <p>Overall Quality: <?= round($ratingSummary['avg_overall'] ?? 0, 1) ?> / 5</p>

        <h3>Rate This Adaptation</h3>
        <form method="POST" action="adaptation.php">
            <input type="hidden" name="adaptation_id" value="<?= $current['AdaptationID'] ?>">
            <label>Faithfulness (1-5): <input type="number" name="loyalty" min="1" max="5" required></label><br>
            <label>Casting (1-5): <input type="number" name="casting" min="1" max="5" required></label><br>
            <label>Overall Quality (1-5): <input type="number" name="overall" min="1" max="5" required></label><br>
            <button type="submit" name="submit_rating">Submit Rating</button>
        </form>
    <?php endif; ?>
</body>
</html>