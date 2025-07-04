<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = $_SESSION['user'];

    if (strlen($title) < 3) {
        $error = 'Заголовок слишком короткий!';
    } elseif (strlen($content) < 5) {
        $error = 'Описание слишком короткое!';
    } else {
        $stmt = $pdo->prepare('INSERT INTO topics (title, content, author, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$title, $content, $author]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать тему</title>
    <link rel="stylesheet" href="css/dark.css">
</head>
<body>
    <div class="container">
        <h1>Создать тему</h1>
        <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
        <form method="post">
            <input type="text" name="title" placeholder="Заголовок" required>
            <textarea name="content" placeholder="Описание темы" rows="6" required></textarea>
            <button type="submit">Создать</button>
        </form>
        <a href="index.php">На главную</a>
    </div>
</body>
</html>