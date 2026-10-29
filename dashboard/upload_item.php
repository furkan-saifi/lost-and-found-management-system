<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item - Lost and Found</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-page">
    <main class="form-panel">
        <a class="back-link" href="index.php">&larr; Back to dashboard</a>
        <p class="eyebrow">CAMPUS COMMUNITY</p>
        <h1>Report an item</h1>
        <p class="form-intro">Share a few details so the community can help reunite an item with its owner.</p>
        <form action="upload_process.php" method="POST" enctype="multipart/form-data">
            <label for="item_name">Item name</label>
            <input id="item_name" type="text" name="item_name" maxlength="255" placeholder="e.g. Blue water bottle" required>
            <label for="location">Location lost or found</label>
            <input id="location" type="text" name="location" maxlength="255" placeholder="e.g. Library, second floor" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" maxlength="3000" placeholder="Describe identifying details..." required></textarea>
            <label for="item_type">Listing type</label>
            <select id="item_type" name="item_type" required>
                <option value="">Choose one</option>
                <option value="lost">Lost</option>
                <option value="found">Found</option>
            </select>
            <label for="item_image">Item photo <span>(JPG, PNG, GIF or WEBP; max 5 MB)</span></label>
            <input id="item_image" type="file" name="item_image" accept="image/jpeg,image/png,image/gif,image/webp" required>
            <button class="button button-primary form-submit" type="submit">Publish listing</button>
        </form>
    </main>
</div>
</body>
</html>