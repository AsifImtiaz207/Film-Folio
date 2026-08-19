<?php
require_once 'config/db.php';

$userID = 1; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_collection'])) {
    $colID = $_POST['collection_id'];
    $mediaID = $_POST['media_id'];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO contains (MediaID, CollectionID) VALUES (?, ?)");
    $stmt->execute([$mediaID, $colID]);
}


$stmt = $pdo->prepare("SELECT * FROM collection WHERE UserID = ?");
$stmt->execute([$userID]);
$collections = $stmt->fetchAll();


$userBookshelf = [];
foreach ($collections as $col) {
    $stmt = $pdo->prepare("
        SELECT m.* 
        FROM media m
        JOIN contains c ON m.MediaID = c.MediaID
        WHERE c.CollectionID = ?
    ");
    $stmt->execute([$col['CollectionID']]);
    $userBookshelf[$col['name']] = $stmt->fetchAll();
}

$allMedia = $pdo->query("SELECT MediaID, title FROM media ORDER BY title ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Bookshelf & Watchlists - Film-Folio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>My Collections</h1>

    <form method="POST" action="bookshelf.php">
        <label>Add Title:</label>
        <select name="media_id" required>
            <?php foreach ($allMedia as $m): ?>
                <option value="<?= $m['MediaID'] ?>"><?= htmlspecialchars($m['title']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>To List:</label>
        <select name="collection_id" required>
            <?php foreach ($collections as $c): ?>
                <option value="<?= $c['CollectionID'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="add_to_collection">Add Item</button>
    </form>

    <hr>

    <?php foreach ($userBookshelf as $colName => $items): ?>
        <h2>📁 <?= htmlspecialchars($colName) ?></h2>
        <?php if (empty($items)): ?>
            <p>No items in this list yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li><strong><?= htmlspecialchars($item['title']) ?></strong> (<?= $item['mediatype'] ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>