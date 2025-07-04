<?php
session_start();
require_once 'config.php';
$current_user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$stmt = $pdo->query('SELECT * FROM chat_messages ORDER BY id DESC LIMIT 30');
$messages = array_reverse($stmt->fetchAll());
foreach ($messages as $msg) {
    $is_me = ($msg['username'] === $current_user);
    $align = $is_me ? 'right' : 'left';
    $bg = $is_me ? '#2e8b57' : '#333';
    $color = $is_me ? '#fff' : '#eee';
    echo '<div style="text-align:'.$align.';">
        <span style="display:inline-block; background:'.$bg.'; color:'.$color.'; border-radius:8px; padding:6px 12px; margin:2px 0; max-width:70%; word-break:break-word;">
            <b>'.htmlspecialchars($msg['username']).':</b> '.htmlspecialchars($msg['message']).'
            <span style="color:#aaa; font-size:10px;">['.htmlspecialchars($msg['created_at']).']</span>
        </span>
    </div>';
}