<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <style>
        body { background-color: <?= $_COOKIE['bg_color'] ?? '#ffffff' ?>; color: <?= $_COOKIE['font_color'] ?? '#000000' ?>; font-family: sans-serif; }
    </style>
</head>
<body>
    <h2>Авторизация</h2>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST" action="?action=login">
        <label>Логин: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <label><input type="checkbox" name="remember"> Запомнить меня</label><br><br>
        <button type="submit">Войти</button>
    </form>
    <p><a href="?action=register">Регистрация</a></p>
</body>
</html>