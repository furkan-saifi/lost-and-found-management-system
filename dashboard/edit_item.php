<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit;
}
require '../config/db.php';

$item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$item_id) {
    http_response_code(400);
    exit('Invalid item ID.');
}
$stmt = $conn->prepare('SELECT * FROM items WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $item_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    http_response_code(404);
    exit('Item not found or you do not have permission to edit it.');
}
$item = $result->fetch_assoc();
function h($value) { return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - Lost and Found</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-page">
    <main class="form-panel">
        <a class="back-link" href="index.php">&larr; Back to dashboard</a>
        <p class="eyebrow">MANAGE YOUR LISTING</p>
        <h1>Edit item</h1>
        <form action="update_item.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="item_id" value="<?= (int) $item['id'] ?>">
            <label for="item_name">Item name</label>
            <input id="item_name" type="text" name="item_name" maxlength="255" value="<?= h($item['item_name']) ?>" required>
            <label for="location">Location lost or found</label>
            <input id="location" type="text" name="location" maxlength="255" value="<?= h($item['location']) ?>" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" maxlength="3000" required><?= h($item['description']) ?></textarea>
            <label for="item_type">Listing type</label>
            <select id="item_type" name="item_type" required>
                <option value="lost" <?= $item['item_type'] === 'lost' ? 'selected' : '' ?>>Lost</option>
                <option value="found" <?= $item['item_type'] === 'found' ? 'selected' : '' ?>>Found</option>
            </select>
            <?php if (!empty($item['item_image'])): ?>
                <p class="current-image">Current photo: <?= h($item['item_image']) ?></p>
            <?php endif; ?>
            <label for="item_image">Replace photo <span>(optional, max 5 MB)</span></label>
            <input id="item_image" type="file" name="item_image" accept="image/jpeg,image/png,image/gif,image/webp">
            <button class="button button-primary form-submit" type="submit">Save changes</button>
        </form>
    </main>
</div>
</body>
</html>