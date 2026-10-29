<?php
session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../signup_form.php");
    exit();
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Please enter a name and valid email address.");
}
if ($password !== $confirm) {
    http_response_code(400);
    exit("Passwords do not match.");
}
if (strlen($password) < 8) {
    http_response_code(400);
    exit("Password must contain at least 8 characters.");
}

$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    http_response_code(409);
    exit("Email already registered.");
}
$check->close();

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed);

if ($stmt->execute()) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['user_name'] = $name;
    header("Location: ../dashboard/index.php");
    exit();
}

http_response_code(500);
echo "Signup failed. Please try again.";
?>