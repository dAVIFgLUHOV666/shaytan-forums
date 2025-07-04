<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Чат</title>
    <link rel="stylesheet" href="css/dark.css">
    <style>
        #chat-box { height: 300px; overflow-y: auto; background: #222; padding: 10px; border-radius: 8px; margin-bottom: 10px;}
        #chat-box div { margin-bottom: 8px; }
        #chat-form { display: flex; gap: 10px; }
        #chat-form input[type="text"] { flex: 1; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Чат</h1>
        <div id="chat-box"></div>
        <form id="chat-form" autocomplete="off">
            <input type="text" id="message" placeholder="Введите сообщение..." required>
            <button type="submit">Отправить</button>
        </form>
        <a href="index.php">На главную</a>
    </div>
    <script>
        function loadChat() {
            fetch('chat_load.php')
                .then(r => r.text())
                .then(html => { document.getElementById('chat-box').innerHTML = html; });
        }
        document.getElementById('chat-form').onsubmit = function(e) {
            e.preventDefault();
            let msg = document.getElementById('message').value.trim();
            if (!msg) return;
            fetch('chat_send.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'message=' + encodeURIComponent(msg)
            }).then(() => {
                document.getElementById('message').value = '';
                loadChat();
            });
        };
        setInterval(loadChat, 2000);
        loadChat();
    </script>
</body>
</html>