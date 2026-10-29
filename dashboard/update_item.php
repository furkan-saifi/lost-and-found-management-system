<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit;
}
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}
$item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
$item_name = trim($_POST['item_name'] ?? '');
$location = trim($_POST['location'] ?? '');
$description = trim($_POST['description'] ?? '');
$item_type = $_POST['item_type'] ?? '';
$user_id = (int) $_SESSION['user_id'];

if (!$item_id || $item_name === '' || $location === '' || $description === '' || !in_array($item_type, ['lost', 'found'], true)) {
    http_response_code(400);
    exit('Please complete all fields correctly.');
}
$stmt = $conn->prepare('SELECT item_image FROM items WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    http_response_code(404);
    exit('Item not found or you do not have permission to edit it.');
}
$existing = $result->fetch_assoc();
$old_image = $existing['item_image'];
$image_name = $old_image;
$new_path = null;

if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['item_image'];
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
        http_response_code(400);
        exit('The new image must be uploaded successfully and be 5 MB or smaller.');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime]) || !is_uploaded_file($file['tmp_name'])) {
        http_response_code(400);
        exit('Please upload a valid JPG, PNG, GIF, or WEBP image.');
    }
    $upload_dir = dirname(__DIR__) . '/uploads/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0755, true)) {
        http_response_code(500);
        exit('Could not create the uploads directory.');
    }
    $image_name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $new_path = $upload_dir . $image_name;
    if (!move_uploaded_file($file['tmp_name'], $new_path)) {
        http_response_code(500);
        exit('Image upload failed. Please try again.');
    }
}

$update = $conn->prepare('UPDATE items SET item_name = ?, location = ?, description = ?, item_type = ?, item_image = ? WHERE id = ? AND user_id = ?');
$update->bind_param('sssssii', $item_name, $location, $description, $item_type, $image_name, $item_id, $user_id);
if ($update->execute()) {
    if ($new_path !== null && !empty($old_image)) {
        $old_path = dirname(__DIR__) . '/uploads/' . basename($old_image);
        if (is_file($old_path)) {
            unlink($old_path);
        }
    }
    header('Location: index.php?section=myItems');
    exit;
}
if ($new_path !== null && is_file($new_path)) {
    unlink($new_path);
}
http_response_code(500);
echo 'Could not update the item. Please try again.';
?>