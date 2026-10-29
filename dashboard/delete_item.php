<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login_form.php');
    exit;
}
require '../config/db.php';

$item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$user_id = (int) $_SESSION['user_id'];
if (!$item_id) {
    http_response_code(400);
    exit('Invalid item ID.');
}

$stmt = $conn->prepare('SELECT item_image FROM items WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    http_response_code(404);
    exit('Item not found or you do not have permission to delete it.');
}
$item = $result->fetch_assoc();

$delete = $conn->prepare('DELETE FROM items WHERE id = ? AND user_id = ?');
$delete->bind_param('ii', $item_id, $user_id);
if ($delete->execute() && !empty($item['item_image'])) {
    $image_path = dirname(__DIR__) . '/uploads/' . basename($item['item_image']);
    if (is_file($image_path)) {
        unlink($image_path);
    }
}
header('Location: index.php?section=myItems');
exit;
?>