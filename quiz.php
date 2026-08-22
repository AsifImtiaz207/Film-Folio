<?php
require_once 'config/db.php';
include_once 'includes/header.php';

$results = [];
$formSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($formSubmitted) {
    $selectedMood = $_POST['mood'] ?? '';
    $wantRomance  = $_POST['romance'] ?? '';
    $selectedPace = $_POST['pace'] ?? '';
    $selectedTone = $_POST['tone'] ?? '';
    $mediaType    = $_POST['mediatype'] ?? 'Both';

    $searchTags = array_filter([$selectedMood, $wantRomance, $selectedPace, $selectedTone]);

    if (!empty($searchTags)) {
        $inClause = implode(',', array_fill(0, count($searchTags), '?'));
        
        $sql = "
            SELECT m.*, COUNT(DISTINCT t.TagID) as match_score
            FROM media m
            JOIN has h ON m.MediaID = h.MediaID
            JOIN tag t ON h.TagID = t.TagID
            WHERE t.tagname IN ($inClause)
        ";

        $params = array_values($searchTags);

        if ($mediaType !== 'Both') {
            $sql .= " AND m.mediatype = ?";
            $params[] = $mediaType;
        }

        $sql .= " GROUP BY m.MediaID ORDER BY match_score DESC LIMIT 6";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll();
    }
}
?>

<h1>Story Recommendation Quiz</h1>
<p>Answer a few questions about what you're in the mood for, and we'll find your perfect match.</p>

<form method="POST" action="quiz.php" class="card" style="background: #f8fafc; padding: 25px; margin-bottom: 30px;">
    
    <div style="margin-bottom: 20px;">
        <label><strong>1. What mood are you in?</strong></label><br>
        <select name="mood" style="width: 100%; margin-top: 5px;">
            <option value="">-- Any Mood --</option>
            <option value="Cozy">Cozy & Relaxing</option>
            <option value="Dark">Dark & Mysterious</option>
            <option value="Thrilling">Thrilling & Intense</option>
            <option value="Whimsical">Whimsical & Magical</option>
        </select>
    </div>

    <div style="margin-bottom: 20px;">
        <label><strong>2. Do you want romance?</strong></label><br>
        <select name="romance" style="width: 100%; margin-top: 5px;">
            <option value="">-- No Preference --</option>
            <option value="Romance">Yes, heavy romance</option>
            <option value="Subplot">A light subplot is fine</option>
            <option value="No Romance">No romance at all</option>
        </select>
    </div>

    <div style="margin-bottom: 20px;">
        <label><strong>3. Fast-paced or slow-paced?</strong></label><br>
        <select name="pace" style="width: 100%; margin-top: 5px;">
            <option value="">-- Either --</option>
            <option value="Fast-Paced">Fast-Paced & Action Packed</option>
            <option value="Slow-Burn">Slow-Burn & Character Driven</option>
        </select>
    </div>

    <div style="margin-bottom: 20px;">
        <label><strong>4. Happy or bittersweet ending?</strong></label><br>
        <select name="tone" style="width: 100%; margin-top: 5px;">
            <option value="">-- Any Ending --</option>
            <option value="Happy Ending">Happy & Uplifting</option>
            <option value="Bittersweet">Bittersweet & Emotional</option>
        </select>
    </div>

    <div style="margin-bottom: 25px;">
        <label><strong>5. Book, movie, or both?</strong></label><br>
        <select name="mediatype" style="width: 100%; margin-top: 5px;">
            <option value="Both">Both Books & Movies</option>
            <option value="Book">Books Only</option>
            <option value="Movie">Movies Only</option>
        </select>
    </div>

    <button type="submit" style="width: 100%; padding: 12px; background: var(--accent-color); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;">
        Find My Matches 
    </button>
</form>

<?php if ($formSubmitted): ?>
    <h2>Your Tailored Matches</h2>
    <?php if (empty($results)): ?>
        <p><em>No stories matched all your selected preferences. Try adjusting your answers!</em></p>
    <?php else: ?>
        <div class="media-grid">
            <?php foreach ($results as $item): ?>
                <div class="card">
                    <div>
                        <span class="badge <?= $item['mediatype'] === 'Book' ? 'badge-book' : 'badge-movie' ?>">
                            <?= htmlspecialchars($item['mediatype']) ?>
                        </span>
                        <h3 style="margin-top: 10px;"><?= htmlspecialchars($item['title']) ?> (<?= $item['releaseyear'] ?>)</h3>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                    <div style="margin-top: 15px;">
                        <span class="badge badge-tag">
                             Match Score: <?= $item['match_score'] ?> tags
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include_once 'includes/footer.php'; ?>