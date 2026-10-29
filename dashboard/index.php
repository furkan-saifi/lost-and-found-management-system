<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit;
}

require '../config/db.php';

$user_id = (int) $_SESSION['user_id'];
$section = (($_GET['section'] ?? 'allItems') === 'myItems') ? 'myItems' : 'allItems';
$isMyItems = $section === 'myItems';
$page = max(1, (int) ($_GET['page'] ?? 1));
$limit = 6;
$offset = ($page - 1) * $limit;

if ($isMyItems) {
    $count = $conn->prepare('SELECT COUNT(*) FROM items WHERE user_id = ?');
    $count->bind_param('i', $user_id);
} else {
    $count = $conn->prepare('SELECT COUNT(*) FROM items');
}
$count->execute();
$count->bind_result($totalItems);
$count->fetch();
$count->close();
$totalPages = max(1, (int) ceil($totalItems / $limit));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

if ($isMyItems) {
    $stmt = $conn->prepare('SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?');
    $stmt->bind_param('iii', $user_id, $limit, $offset);
} else {
    $stmt = $conn->prepare('SELECT items.*, users.name AS owner_name FROM items JOIN users ON items.user_id = users.id ORDER BY items.created_at DESC LIMIT ? OFFSET ?');
    $stmt->bind_param('ii', $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
function h($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lost and Found</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="dashboard-container">
    <header class="top-bar">
        <div>
            <p class="eyebrow">CAMPUS COMMUNITY</p>
            <h1>Lost &amp; Found</h1>
            <p class="welcome">Welcome, <?= h($_SESSION['user_name'] ?? 'User') ?>.</p>
        </div>
        <nav class="top-actions" aria-label="Account actions">
            <a class="button button-primary" href="upload_item.php">+ Add Item</a>
            <a class="button button-ghost" href="../auth/logout.php">Logout</a>
        </nav>
    </header>

    <section class="intro">
        <div>
            <h2>Find what matters.</h2>
            <p>Browse reported items or share something you've lost or found on campus.</p>
        </div>
        <div class="stats"><strong><?= (int) $totalItems ?></strong><span><?= $isMyItems ? 'your listings' : 'community listings' ?></span></div>
    </section>

    <nav class="tabs" aria-label="Listing filters">
        <a class="<?= !$isMyItems ? 'active' : '' ?>" href="index.php?section=allItems&page=1">All Items</a>
        <a class="<?= $isMyItems ? 'active' : '' ?>" href="index.php?section=myItems&page=1">My Items</a>
    </nav>

    <section class="items-grid" aria-label="Item listings">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <article class="item-card">
                <?php if (!empty($row['item_image'])): ?>
                    <img src="../uploads/<?= h($row['item_image']) ?>" alt="Photo of <?= h($row['item_name']) ?>" class="item-image" loading="lazy">
                <?php else: ?>
                    <div class="image-placeholder">No image provided</div>
                <?php endif; ?>
                <div class="item-content">
                    <div class="item-heading">
                        <h3><?= h($row['item_name']) ?></h3>
                        <span class="type-badge <?= h($row['item_type']) ?>"><?= h(ucfirst($row['item_type'])) ?></span>
                    </div>
                    <p class="location"><strong>Location:</strong> <?= h($row['location']) ?></p>
                    <p class="description"><?= nl2br(h($row['description'])) ?></p>
                    <?php if (!$isMyItems && isset($row['owner_name'])): ?>
                        <p class="posted-by">Posted by <?= h($row['owner_name']) ?></p>
                    <?php endif; ?>
                    <p class="posted-time">Posted <?= h(date('M j, Y', strtotime($row['created_at']))) ?></p>
                    <div class="item-actions">
                        <?php if ((int) $row['is_resolved'] === 1): ?>
                            <span class="resolved">✓ Resolved</span>
                        <?php elseif ((int) $row['user_id'] === $user_id): ?>
                            <a href="mark_resolved.php?id=<?= (int) $row['id'] ?>" onclick="return confirm('Mark this item as resolved?')">Mark resolved</a>
                        <?php endif; ?>
                        <?php if ((int) $row['user_id'] === $user_id): ?>
                            <a href="edit_item.php?id=<?= (int) $row['id'] ?>">Edit</a>
                            <a class="danger-link" href="delete_item.php?id=<?= (int) $row['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <h3>No items yet</h3>
            <p><?= $isMyItems ? 'You have not posted anything yet.' : 'Be the first to report a lost or found item.' ?></p>
            <a class="button button-primary" href="upload_item.php">Add an item</a>
        </div>
    <?php endif; ?>
    </section>

    <?php if ($totalItems > $limit): ?>
    <nav class="pagination" aria-label="Pagination">
        <?php if ($page > 1): ?><a href="?section=<?= h($section) ?>&amp;page=<?= $page - 1 ?>">&larr; Previous</a><?php endif; ?>
        <span>Page <?= $page ?> of <?= $totalPages ?></span>
        <?php if ($page < $totalPages): ?><a href="?section=<?= h($section) ?>&amp;page=<?= $page + 1 ?>">Next &rarr;</a><?php endif; ?>
    </nav>
    <?php endif; ?>

    <footer class="page-footer">Lost &amp; Found Management System · Built for campus communities</footer>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>