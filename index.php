<?php
session_start();
require_once 'config.php';

function get_avatar($username) {
    $file = 'avatarka/01.jpg';
    return $file;
}

// Получаем темы из базы
$stmt = $pdo->query('SELECT * FROM topics ORDER BY created_at DESC');
$topics = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Shaytan Forums</title>
    <link rel="stylesheet" href="css/dark.css">
</head>
<body>
    <div class="navbar">
        <img src="<?php echo get_avatar(isset($_SESSION['user']) ? $_SESSION['user'] : ''); ?>" class="avatar" alt="avatar">
        <span class="logo">Shaytan Forums</span>
        <a href="index.php">Главная</a>
        <a href="chat.php">Чат</a>
        <a href="create_topic.php">Создать тему</a>
        <div class="right">
            <?php if (isset($_SESSION['user'])): ?>
                <span>Привет, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <h1>Shaytan Forums</h1>
        <div class="table">
            <table width="100%">
                <tr><th>Тема</th><th>Автор</th><th>Дата</th></tr>
                <?php foreach ($topics as $topic): ?>
                <tr>
                    <td>
                        <a href="topic.php?id=<?php echo $topic['id']; ?>">
                            <?php echo htmlspecialchars($topic['title']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($topic['author']); ?></td>
                    <td><?php echo htmlspecialchars($topic['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>