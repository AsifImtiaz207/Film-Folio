<?php
require_once 'config/db.php';
include_once 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM media ORDER BY releaseyear DESC LIMIT 6");
$recentMedia = $stmt->fetchAll();
?>

<h1>Welcome to Film-Folio</h1>
<p>Connect books and movies through recommendations based on mood, genre, and themes.</p>

<h2>Featured Titles</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
    <?php foreach ($recentMedia as $item): ?>
        <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><strong>Type:</strong> <?= htmlspecialchars($item['mediatype']) ?></p>
            <p><strong>Year:</strong> <?= $item['releaseyear'] ?></p>
            <p><?= htmlspecialchars($item['description']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once 'includes/footer.php'; ?>