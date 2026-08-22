<?php
require_once 'config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adaptation_id'])) {
    $stmt = $pdo->prepare("
        INSERT INTO adaptationrating (AdaptationID, loyaltyscore, castingscore, overallscore)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([
        $_POST['adaptation_id'],
        $_POST['loyaltyscore'],
        $_POST['castingscore'],
        $_POST['overallscore']
    ]);
    $_SESSION['flash_message'] = "Rating submitted successfully!";
    header("Location: adaptation.php");
    exit();
}

$message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

include_once 'includes/header.php';

$searchQuery = trim($_GET['search'] ?? '');

$sql = "
    SELECT 
        a.ID AS AdaptationID,
        b.title AS book_title,
        m.title AS movie_title,
        AVG(r.loyaltyscore) AS avg_loyalty,
        AVG(r.castingscore) AS avg_casting,
        AVG(r.overallscore) AS avg_overall,
        COUNT(r.AdaptationID) as total_ratings
    FROM adaptation a
    JOIN media b ON a.BookID = b.MediaID
    JOIN media m ON a.MovieID = m.MediaID
    LEFT JOIN adaptationrating r ON a.ID = r.AdaptationID
";

if (!empty($searchQuery)) {
    $sql .= " WHERE b.title LIKE :search OR m.title LIKE :search";
}

$sql .= " GROUP BY a.ID";

$stmt = $pdo->prepare($sql);
if (!empty($searchQuery)) {
    $stmt->execute(['search' => '%' . $searchQuery . '%']);
} else {
    $stmt->execute();
}
$adaptations = $stmt->fetchAll();
?>

<h1>Adaptation Hub & Ratings</h1>
<p>Compare book-to-movie adaptations and rate them on accuracy, casting, and overall quality.</p>

<?php if ($message): ?>
    <div style="padding: 12px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div class="card" style="background: #f8fafc; margin-bottom: 25px; padding: 20px;">
    <form method="GET" action="adaptation.php" style="margin-bottom: 0;">
        <label for="searchAdaptation"><strong> Search Adaptations:</strong></label>
        <div style="display: flex; gap: 10px; margin-top: 8px;">
            <input 
                type="text" 
                name="search" 
                id="searchAdaptation" 
                placeholder="Type a book or movie title (e.g. Harry Potter)..." 
                value="<?= htmlspecialchars($searchQuery) ?>"
                style="flex: 1; max-width: 100%;"
            >
            <button type="submit" style="padding: 10px 20px; background: var(--primary-color); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                Search
            </button>
            <?php if (!empty($searchQuery)): ?>
                <a href="adaptation.php" style="padding: 10px 15px; background: var(--border-color); color: var(--text-main); border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">Clear</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php if (empty($adaptations)): ?>
    <p><em>No adaptations found matching your search term.</em></p>
<?php else: ?>
    <div class="media-grid">
        <?php foreach ($adaptations as $ad): ?>
            <div class="card adaptation-card">
                <div>
                    <span class="badge badge-tag">Adaptation Pair</span>
                    <h3 class="adaptation-title" style="margin-top: 10px;">📖 <?= htmlspecialchars($ad['book_title']) ?></h3>
                    <h3 class="adaptation-title" style="color: var(--text-muted); font-size: 1rem;">🎬 <?= htmlspecialchars($ad['movie_title']) ?></h3>
                    
                    <div style="margin: 15px 0; font-size: 0.9rem; background: #f8fafc; padding: 10px; border-radius: 6px;">
                        <p style="margin: 0;"><strong>Faithfulness:</strong> <?= $ad['avg_loyalty'] ? number_format($ad['avg_loyalty'], 1) . '/5' : 'N/A' ?></p>
                        <p style="margin: 0;"><strong>Casting:</strong> <?= $ad['avg_casting'] ? number_format($ad['avg_casting'], 1) . '/5' : 'N/A' ?></p>
                        <p style="margin: 0;"><strong>Overall:</strong> <?= $ad['avg_overall'] ? number_format($ad['avg_overall'], 1) . '/5' : 'N/A' ?></p>
                    </div>
                </div>

                <form method="POST" action="adaptation.php" style="margin-top: 10px; margin-bottom: 0;">
                    <input type="hidden" name="adaptation_id" value="<?= $ad['AdaptationID'] ?>">
                    <label style="font-size: 0.85rem;">Rate this adaptation (1-5):</label>
                    <div style="display: flex; gap: 5px; margin-bottom: 8px;">
                        <input type="number" name="loyaltyscore" min="1" max="5" placeholder="Faithful" required style="padding: 6px; width: 33%;">
                        <input type="number" name="castingscore" min="1" max="5" placeholder="Casting" required style="padding: 6px; width: 33%;">
                        <input type="number" name="overallscore" min="1" max="5" placeholder="Overall" required style="padding: 6px; width: 33%;">
                    </div>
                    <button type="submit" style="width: 100%; padding: 8px; background: var(--accent-color); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                        Submit Rating
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchAdaptation");
    const cards = document.querySelectorAll(".adaptation-card");

    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const query = e.target.value.toLowerCase();
            cards.forEach(card => {
                const titles = card.querySelectorAll(".adaptation-title");
                let match = false;
                titles.forEach(t => {
                    if (t.textContent.toLowerCase().includes(query)) {
                        match = true;
                    }
                });
                card.style.display = match ? "flex" : "none";
            });
        });
    }
});
</script>

<?php include_once 'includes/footer.php'; ?>