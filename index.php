<?php
require_once 'config/db.php';
include_once 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM media ORDER BY releaseyear DESC LIMIT 6");
$recentMedia = $stmt->fetchAll();
?>

<h1>Welcome to Film-Folio</h1>
<p>Discover story recommendations across books and movies based on mood, genre, and themes.</p>

<input type="text" id="searchMedia" placeholder="🔍 Quick filter featured titles..." style="margin-bottom: 20px;">

<h2>Featured Titles</h2>
<div class="media-grid">
    <?php foreach ($recentMedia as $item): ?>
        <div class="card">
            <div>
                <span class="badge <?= $item['mediatype'] === 'Book' ? 'badge-book' : 'badge-movie' ?>">
                    <?= htmlspecialchars($item['mediatype']) ?>
                </span>
                <h3 style="margin-top: 10px;"><?= htmlspecialchars($item['title']) ?></h3>
                <p><strong>Released:</strong> <?= $item['releaseyear'] ?></p>
                <p><?= htmlspecialchars($item['description']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once 'includes/footer.php'; ?>