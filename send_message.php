<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'] ?? 'User' . $user_id;
    $club_id = $_SESSION['club_id'];

    if ($message !== '') {
        $stmt = $conn->prepare("INSERT INTO chat_messages (club_id, user_id, username, message, sent_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiss", $club_id, $user_id, $username, $message);
        $stmt->execute();
    }
}
?>
