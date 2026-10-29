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

$item_name = trim($_POST['item_name'] ?? '');
$location = trim($_POST['location'] ?? '');
$description = trim($_POST['description'] ?? '');
$item_type = $_POST['item_type'] ?? '';

if ($item_name === '' || $location === '' || $description === '' || !in_array($item_type, ['lost', 'found'], true)) {
    http_response_code(400);
    exit('Please complete all fields and choose Lost or Found.');
}
if (!isset($_FILES['item_image']) || $_FILES['item_image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit('Please select an image to upload.');
}

$file = $_FILES['item_image'];
if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    exit('The image must be 5 MB or smaller.');
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
$target_path = $upload_dir . $image_name;
if (!move_uploaded_file($file['tmp_name'], $target_path)) {
    http_response_code(500);
    exit('Image upload failed. Please try again.');
}

$user_id = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('INSERT INTO items (user_id, item_name, location, description, item_type, item_image) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('isssss', $user_id, $item_name, $location, $description, $item_type, $image_name);

if ($stmt->execute()) {
    header('Location: index.php?section=myItems');
    exit;
}
if (is_file($target_path)) {
    unlink($target_path);
}
http_response_code(500);
echo 'Could not save the item. Please try again.';
?>