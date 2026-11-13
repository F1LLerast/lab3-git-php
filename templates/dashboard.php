<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <style>
        body { background-color: <?= $_COOKIE['bg_color'] ?? '#ffffff' ?>; color: <?= $_COOKIE['font_color'] ?? '#000000' ?>; font-family: sans-serif; }
    </style>
</head>
<body>
    <h2>Добро пожаловать, <?= htmlspecialchars($_SESSION['login']) ?>!</h2>
    <p>Вы успешно авторизованы.</p>

    <h3>Настройки оформления</h3>
    <form method="POST" action="?action=settings">
        <label>Цвет фона: <input type="color" name="bg_color" value="<?= $settings['bg_color'] ?>"></label><br><br>
        <label>Цвет шрифта: <input type="color" name="font_color" value="<?= $settings['font_color'] ?>"></label><br><br>
        <button type="submit">Сохранить настройки</button>
    </form>

    <br>
    <a href="?logout=1"><button>Выйти</button></a>
</body>
</html>