<?php
namespace App;
use PDO;

class Database {
    private $pdo;

    public function __construct() {
        // Создаем папку data, если ее нет
        if (!is_dir(__DIR__ . '/../data')) {
            mkdir(__DIR__ . '/../data', 0777, true);
        }
        $this->pdo = new PDO('sqlite:' . __DIR__ . '/../data/app.sqlite');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->initTables();
    }

    private function initTables() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            login TEXT UNIQUE,
            password_hash TEXT,
            bg_color TEXT DEFAULT '#ffffff',
            font_color TEXT DEFAULT '#000000'
        )");
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS remember_tokens (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            token TEXT UNIQUE
        )");
    }

    public function getUserByLogin($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($login, $password_hash, $bg, $font) {
        $stmt = $this->pdo->prepare("INSERT INTO users (login, password_hash, bg_color, font_color) VALUES (?, ?, ?, ?)");
        $stmt->execute([$login, $password_hash, $bg, $font]);
        return $this->pdo->lastInsertId();
    }

    public function saveToken($userId, $token) {
        $stmt = $this->pdo->prepare("INSERT INTO remember_tokens (user_id, token) VALUES (?, ?)");
        $stmt->execute([$userId, $token]);
    }

    public function getUserByToken($token) {
        $stmt = $this->pdo->prepare("SELECT u.* FROM users u JOIN remember_tokens t ON u.id = t.user_id WHERE t.token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSettings($userId, $bg, $font) {
        $stmt = $this->pdo->prepare("UPDATE users SET bg_color = ?, font_color = ? WHERE id = ?");
        $stmt->execute([$bg, $font, $userId]);
    }

    public function getUserSettings($userId) {
        $stmt = $this->pdo->prepare("SELECT bg_color, font_color FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}