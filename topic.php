<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM topics WHERE id = ?');
$stmt->execute([$id]);
$topic = $stmt->fetch();

if (!$topic) {
    echo "Тема не найдена!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($topic['title']); ?></title>
    <link rel="stylesheet" href="css/dark.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($topic['title']); ?></h1>
        <div>
            <b>Автор:</b> <?php echo htmlspecialchars($topic['author']); ?><br>
            <b>Дата:</b> <?php echo htmlspecialchars($topic['created_at']); ?>
        </div>
        <hr>
        <div>
            <?php echo nl2br(htmlspecialchars($topic['content'])); ?>
        </div>
        <a href="index.php">Назад к списку тем</a>
    </div>
</body>
</html>