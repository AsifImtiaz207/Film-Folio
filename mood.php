<?php
require_once 'config/db.php';
include_once 'includes/header.php';

$selectedTagID = $_GET['tag_id'] ?? null;


$moods = $pdo->query("SELECT * FROM tag WHERE tagtype = 'Mood' ORDER BY tagname ASC")->fetchAll();

$mediaItems = [];
if ($selectedTagID) {
    $stmt = $pdo->prepare("
        SELECT m.* FROM media m 
        JOIN has h ON m.MediaID = h.MediaID 
        WHERE h.TagID = ?
        ORDER BY m.title ASC
    ");
    $stmt->execute([$selectedTagID]);
    $mediaItems = $stmt->fetchAll();
}
?>

<h1>Mood & Vibe Discovery</h1>
<p>Filter books and movies by atmospheric vibes and emotional tones.</p>

<form method="GET" action="mood.php">
    <label for="tag_id">Choose a Mood:</label>
    <select name="tag_id" id="tag_id" onchange="this.form.submit()">
        <option value="">-- Select a Vibe --</option>
        <?php foreach ($moods as $mood): ?>
            <option value="<?= $mood['TagID'] ?>" <?= $selectedTagID == $mood['TagID'] ? 'selected' : '' ?>>
                 <?= htmlspecialchars($mood['tagname']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($selectedTagID): ?>
    <h2>Matching Stories</h2>
    <?php if (empty($mediaItems)): ?>
        <p><em>No books or movies currently tagged with this mood.</em></p>
    <?php else: ?>
        <div class="media-grid">
            <?php foreach ($mediaItems as $item): ?>
                <div class="card">
                    <div>
                        <span class="badge <?= $item['mediatype'] === 'Book' ? 'badge-book' : 'badge-movie' ?>">
                            <?= htmlspecialchars($item['mediatype']) ?>
                        </span>
                        <h3 style="margin-top: 10px;"><?= htmlspecialchars($item['title']) ?> (<?= $item['releaseyear'] ?>)</h3>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include_once 'includes/footer.php'; ?>