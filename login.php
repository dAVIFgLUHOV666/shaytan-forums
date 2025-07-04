<?php
session_start();
require_once 'config.php';

$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    // Если похоже на номер телефона, добавим +
    if (preg_match('/^9989\d{8}$/', $login)) {
        $login = '+' . $login;
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username=? OR email=? OR phone=?');
    $stmt->execute([$login, $login, $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $login_error = 'Пользователь не найден!';
    } elseif (!password_verify($password, $user['password'])) {
        $login_error = 'Пароль неверный!';
    } else {
        $_SESSION['user'] = $user['username'];
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/dark.css">
</head>
<body>
    <div class="container">
        <div class="form-title">Вход</div>
        <?php if ($login_error) echo '<div class="error">'.$login_error.'</div>'; ?>
        <form class="form-box" method="post">
            <input type="text" name="login" placeholder="Логин, email или номер телефона" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        <div style="text-align:center; margin-top:16px;">
            Нет аккаунта? <a href="register.php" style="color:#2ecc40;">Регистрация</a>
        </div>
    </div>
</body>
</html>
