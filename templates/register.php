<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <style>
        body { background-color: <?= $_COOKIE['bg_color'] ?? '#ffffff' ?>; color: <?= $_COOKIE['font_color'] ?? '#000000' ?>; font-family: sans-serif; }
    </style>
</head>
<body>
    <h2>Регистрация</h2>
    <form method="POST" action="?action=register">
        <label>Логин: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <label>Цвет фона: <input type="color" name="bg_color" value="#ffffff"></label><br><br>
        <label>Цвет шрифта: <input type="color" name="font_color" value="#000000"></label><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p><a href="index.php">Войти</a></p>
</body>
</html>