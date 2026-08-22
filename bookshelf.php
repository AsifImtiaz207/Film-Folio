<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

$userID = 1; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_collection'])) {
    $colID = $_POST['collection_id'];
    $mediaID = $_POST['media_id'];
    
    if (!empty($colID) && !empty($mediaID)) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO contains (MediaID, CollectionID) VALUES (?, ?)");
        $stmt->execute([$mediaID, $colID]);
        $_SESSION['flash_message'] = "Item successfully added to collection!";
    }
    
    header("Location: bookshelf.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_collection'])) {
    $newColName = trim($_POST['new_collection_name']);
    
    if (!empty($newColName)) {
        $stmt = $pdo->prepare("INSERT INTO collection (name, UserID) VALUES (?, ?)");
        $stmt->execute([$newColName, $userID]);
        $_SESSION['flash_message'] = "New collection '{$newColName}' created!";
    }
    
    header("Location: bookshelf.php");
    exit();
}

$message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

include_once 'includes/header.php';

$stmt = $pdo->prepare("SELECT * FROM collection WHERE UserID = ? ORDER BY name ASC");
$stmt->execute([$userID]);
$collections = $stmt->fetchAll();

$userBookshelf = [];
foreach ($collections as $col) {
    $stmt = $pdo->prepare("
        SELECT m.* 
        FROM media m
        JOIN contains c ON m.MediaID = c.MediaID
        WHERE c.CollectionID = ?
        ORDER BY m.title ASC
    ");
    $stmt->execute([$col['CollectionID']]);
    $userBookshelf[$col['name']] = $stmt->fetchAll();
}

$allMedia = $pdo->query("SELECT MediaID, title, mediatype FROM media ORDER BY title ASC")->fetchAll();
?>

<h1>My Bookshelf & Watchlists</h1>
<p>Organize your favorite books and movies into custom collections[cite: 1].</p>

<?php if ($message): ?>
    <div style="padding: 12px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: #f8fafc;">
        <h3 style="margin-bottom: 15px;"> Create New List</h3>
        <form method="POST" action="bookshelf.php" style="margin-bottom: 0;">
            <label for="new_collection_name">List Name:</label>
            <input type="text" id="new_collection_name" name="new_collection_name" placeholder="e.g. Watched, Want to Watch" required style="margin-bottom: 12px; width: 100%;">
            <button type="submit" name="create_collection" style="width: 100%; padding: 10px; background: var(--primary-color); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                + Create List
            </button>
        </form>
    </div>

    <div class="card" style="background: #f8fafc;">
        <h3 style="margin-bottom: 15px;"> Add Title to List</h3>
        <form method="POST" action="bookshelf.php" style="margin-bottom: 0;">
            <label for="media_id">Select Title:</label>
            <select name="media_id" id="media_id" required style="margin-bottom: 12px; width: 100%;">
                <option value="">-- Choose Book or Movie --</option>
                <?php foreach ($allMedia as $m): ?>
                    <option value="<?= $m['MediaID'] ?>">
                        <?= htmlspecialchars($m['title']) ?> (<?= $m['mediatype'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="collection_id">Select Collection:</label>
            <select name="collection_id" id="collection_id" required style="margin-bottom: 12px; width: 100%;">
                <option value="">-- Choose List --</option>
                <?php foreach ($collections as $c): ?>
                    <option value="<?= $c['CollectionID'] ?>">
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add_to_collection" style="width: 100%; padding: 10px; background: var(--accent-color); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                Add to Selected List
            </button>
        </form>
    </div>
</div>

<?php if (empty($userBookshelf)): ?>
    <p><em>No collections found. Create your first list above!</em></p>
<?php else: ?>
    <?php foreach ($userBookshelf as $colName => $items): ?>
        <h2> <?= htmlspecialchars($colName) ?></h2>
        <?php if (empty($items)): ?>
            <p style="margin-bottom: 30px;"><em>No items in this collection yet.</em></p>
        <?php else: ?>
            <div class="media-grid" style="margin-bottom: 35px;">
                <?php foreach ($items as $item): ?>
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
    <?php endforeach; ?>
<?php endif; ?>

<?php include_once 'includes/footer.php'; ?>