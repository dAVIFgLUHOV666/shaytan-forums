<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user']) || empty($_POST['message'])) exit;
$msg = trim($_POST['message']);
if ($msg) {
    $stmt = $pdo->prepare('INSERT INTO chat_messages (username, message, created_at) VALUES (?, ?, NOW())');
    $stmt->execute([$_SESSION['user'], $msg]);
}