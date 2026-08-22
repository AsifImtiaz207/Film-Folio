<?php
require_once 'config/db.php';
include_once 'includes/header.php';

$selectedMediaID = $_GET['id'] ?? null;
$recommendations = [];
$selectedMedia = null;

$allMedia = $pdo->query("SELECT MediaID, title, mediatype FROM media ORDER BY title ASC")->fetchAll();

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
            LIMIT 6
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'currentMediaID' => $selectedMediaID,
            'targetType'     => $targetType
        ]);
        $recommendations = $stmt->fetchAll();
    }
}
?>

<h1>Cross-Media Recommendations</h1>
<p>Pick a book or movie to uncover similar stories from the opposite medium based on shared themes and tags.</p>

<form method="GET" action="recommend.php">
    <label for="id">Select a Title:</label>
    <select name="id" id="id" onchange="this.form.submit()">
        <option value="">-- Select Book or Movie --</option>
        <?php foreach ($allMedia as $item): ?>
            <option value="<?= $item['MediaID'] ?>" <?= $selectedMediaID == $item['MediaID'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($item['title']) ?> (<?= $item['mediatype'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($selectedMedia): ?>
    <h2>Recommendations for "<?= htmlspecialchars($selectedMedia['title']) ?>"</h2>
    <p>Showing top matching <?= $selectedMedia['mediatype'] === 'Book' ? 'Movies' : 'Books' ?>:</p>
    
    <?php if (empty($recommendations)): ?>
        <p><em>No cross-media matches found for this title yet.</em></p>
    <?php else: ?>
        <div class="media-grid">
            <?php foreach ($recommendations as $rec): ?>
                <div class="card">
                    <div>
                        <span class="badge <?= $rec['mediatype'] === 'Book' ? 'badge-book' : 'badge-movie' ?>">
                            <?= htmlspecialchars($rec['mediatype']) ?>
                        </span>
                        <h3 style="margin-top: 10px;"><?= htmlspecialchars($rec['title']) ?> (<?= $rec['releaseyear'] ?>)</h3>
                        <p><?= htmlspecialchars($rec['description']) ?></p>
                    </div>
                    <div style="margin-top: 15px;">
                        <span class="badge badge-tag">
                            🔗 <?= $rec['shared_tags_count'] ?> Shared Tags
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include_once 'includes/footer.php'; ?>