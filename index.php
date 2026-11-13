<?php
require 'vendor/autoload.php';

use App\Database;
use App\Auth;

session_start();

$db = new Database();
$auth = new Auth($db);

// Автоматический вход по кукам
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $user = $db->getUserByToken($_COOKIE['remember_token']);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        setcookie('bg_color', $user['bg_color'], time() + (86400 * 30), "/");
        setcookie('font_color', $user['font_color'], time() + (86400 * 30), "/");
    }
}

$action = $_GET['action'] ?? 'login';

if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'register') {
        $auth->register($_POST);
        header('Location: index.php');
        exit;
    } elseif ($action === 'login') {
        if ($auth->login($_POST['login'], $_POST['password'], isset($_POST['remember']))) {
            header('Location: index.php');
            exit;
        } else {
            $error = "Неверный логин или пароль";
        }
    } elseif ($action === 'settings' && isset($_SESSION['user_id'])) {
        $auth->updateSettings($_SESSION['user_id'], $_POST);
        header('Location: index.php');
        exit;
    }
}

if (isset($_SESSION['user_id'])) {
    $settings = $db->getUserSettings($_SESSION['user_id']);
    require 'templates/dashboard.php';
} elseif ($action === 'register') {
    require 'templates/register.php';
} else {
    require 'templates/login.php';
}
