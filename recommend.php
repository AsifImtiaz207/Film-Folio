<?php
require_once 'config/db.php';

$selectedMediaID = $_GET['id'] ?? null;
$recommendations = [];
$selectedMedia = null;

if ($selectedMediaID) {
    $stmt = $pdo->prepare("SELECT * FROM media WHERE MediaID = ?");
    $stmt->execute([$selectedMediaID]);
    $selectedMedia = $stmt->fetch();

    if ($selectedMedia) {
        $targetType = ($selectedMedia['mediatype'] === 'Book') ? 'Movie' : 'Book';
        $sql = "
            SELECT m.*, COUNT(h2.TagID) AS shared_tags_count
            FROM has h1
            JOIN has h2 ON h1.TagID = h2.TagID
            JOIN media m ON h2.MediaID = m.MediaID
            WHERE h1.MediaID = :currentMediaID 
              AND m.MediaID != :currentMediaID 
              AND m.mediatype = :targetType
            GROUP BY m.MediaID
            ORDER BY shared_tags_count DESC
            LIMIT 5
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'currentMediaID' => $selectedMediaID,
            'targetType'     => $targetType
        ]);
        $recommendations = $stmt->fetchAll();
    }
}

$allMedia = $pdo->query("SELECT MediaID, title, mediatype FROM media ORDER BY title ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cross-Media Recommendations - Film-Folio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Cross-Media Recommendation Engine</h1>
    <form method="GET" action="recommend.php">
        <label for="id">Select a Book or Movie:</label>
        <select name="id" id="id" onchange="this.form.submit()">
            <option value="">-- Choose Title --</option>
            <?php foreach ($allMedia as $item): ?>
                <option value="<?= $item['MediaID'] ?>" <?= $selectedMediaID == $item['MediaID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($item['title']) ?> (<?= $item['mediatype'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($selectedMedia): ?>
        <h2>Recommendations for "<?= htmlspecialchars($selectedMedia['title']) ?>" (<?= $selectedMedia['mediatype'] ?>):</h2>
        <?php if (empty($recommendations)): ?>
            <p>No cross-media matches found for this title.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($recommendations as $rec): ?>
                    <li>
                        <strong><?= htmlspecialchars($rec['title']) ?></strong> (<?= $rec['releaseyear'] ?>)
                        - Matching Tags: <?= $rec['shared_tags_count'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>