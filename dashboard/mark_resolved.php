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

$stmt = $conn->prepare('UPDATE items SET is_resolved = 1 WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $item_id, $user_id);
$stmt->execute();
if ($stmt->affected_rows === 0) {
    // A record can already be resolved; confirm it belongs to the current user.
    $check = $conn->prepare('SELECT id FROM items WHERE id = ? AND user_id = ?');
    $check->bind_param('ii', $item_id, $user_id);
    $check->execute();
    if ($check->get_result()->num_rows !== 1) {
        http_response_code(404);
        exit('Item not found or you do not have permission.');
    }
}
header('Location: index.php?section=myItems');
exit;
?>