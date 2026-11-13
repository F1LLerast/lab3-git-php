<?php
namespace App;

class Auth {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($data) {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $bg = $data['bg_color'] ?? '#ffffff';
        $font = $data['font_color'] ?? '#000000';
        
        $userId = $this->db->createUser($data['login'], $hash, $bg, $font);
        
        $_SESSION['user_id'] = $userId;
        $_SESSION['login'] = $data['login'];
        
        setcookie('bg_color', $bg, time() + (86400 * 30), "/");
        setcookie('font_color', $font, time() + (86400 * 30), "/");
    }

    public function login($login, $password, $remember) {
        $user = $this->db->getUserByLogin($login);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            
            setcookie('bg_color', $user['bg_color'], time() + (86400 * 30), "/");
            setcookie('font_color', $user['font_color'], time() + (86400 * 30), "/");
            
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $this->db->saveToken($user['id'], $token);
                setcookie('remember_token', $token, time() + (86400 * 30), "/");
            }
            return true;
        }
        return false;
    }

    public function updateSettings($userId, $data) {
        $bg = $data['bg_color'];
        $font = $data['font_color'];
        $this->db->updateSettings($userId, $bg, $font);
        
        setcookie('bg_color', $bg, time() + (86400 * 30), "/");
        setcookie('font_color', $font, time() + (86400 * 30), "/");
    }

    public function logout() {
        session_destroy();
        setcookie('bg_color', '', time() - 3600, "/");
        setcookie('font_color', '', time() - 3600, "/");
        setcookie('remember_token', '', time() - 3600, "/");
    }
}