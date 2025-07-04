<?php
session_start();
require_once 'config.php';

function is_uzbek_phone($phone) {
    return preg_match('/^\+9989[0-9]{8}$/', $phone);
}

$reg_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $reg_error = 'Логин только латиница и цифры!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $reg_error = 'Некорректный email!';
    } elseif (!is_uzbek_phone($phone)) {
        $reg_error = 'Только узбекские номера +9989XXXXXXXX!';
    } elseif (strlen($password) < 4) {
        $reg_error = 'Пароль слишком короткий!';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username=? OR email=? OR phone=?');
        $stmt->execute([$username, $email, $phone]);
        if ($stmt->fetch()) {
            $reg_error = 'Пользователь уже существует!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $email, $phone, $hash]);
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/dark.css">
</head>
<body>
    <div class="container">
        <div class="form-title">Регистрация</div>
        <?php if ($reg_error) echo '<div class="error">'.$reg_error.'</div>'; ?>
        <form class="form-box" method="post">
            <input type="text" name="username" placeholder="Логин (латиница)" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Номер телефона (+9989XXXXXXXX)" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <div style="text-align:center; margin-top:16px;">
            Уже есть аккаунт? <a href="login.php" style="color:#2ecc40;">Войти</a>
        </div>
    </div>
</body>
</html>
