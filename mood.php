<?php
require_once 'config/db.php';

$selectedTagID = $_GET['tag_id'] ?? null;

$moods = $pdo->query("SELECT * FROM tag WHERE tagtype = 'Mood' ORDER BY tagname ASC")->fetchAll();

$mediaItems = [];
if ($selectedTagID) {
    $stmt = $pdo->prepare("
        SELECT m.* 
        FROM media m
        JOIN has h ON m.MediaID = h.MediaID
        WHERE h.TagID = ?
    ");
    $stmt->execute([$selectedTagID]);
    $mediaItems = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mood & Vibe Discovery - Film-Folio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Browse by Mood & Vibe</h1>
    <div class="mood-buttons">
        <?php foreach ($moods as $mood): ?>
            <a href="mood.php?tag_id=<?= $mood['TagID'] ?>" class="btn">
                <?= htmlspecialchars($mood['tagname']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($selectedTagID): ?>
        <h2>Matching Stories:</h2>
        <ul>
            <?php foreach ($mediaItems as $item): ?>
                <li>
                    <strong><?= htmlspecialchars($item['title']) ?></strong> 
                    (<?= $item['mediatype'] ?>, <?= $item['releaseyear'] ?>) 
                    - <?= htmlspecialchars($item['description']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>