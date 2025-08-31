<?php
require_once __DIR__ . '/User.php';

class Auth {
    public static function login($username, $password) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $user = User::authenticate($username, $password);
        
        if ($user) {
            // Check if volunteer account is active
            if ($user->role === UserRole::VOLUNTEER && $user->volunteer_id) {
                $db = require_once __DIR__ . '../db_connection.php';
                $stmt = $db->prepare("SELECT status FROM volunteer WHERE volunteer_id = ?");
                $stmt->execute([$user->volunteer_id]);
                $volunteer = $stmt->fetch();
                
                if ($volunteer && $volunteer['status'] !== 'active') {
                    return ['success' => false, 'message' => 'Your volunteer account is not active.'];
                }
            }
            
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role->value;
            $_SESSION['volunteer_id'] = $user->volunteer_id;
            
            return ['success' => true, 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'Invalid credentials.'];
    }

    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        header('Location: /Lab03_Group05/public/auth/login.php');
        exit;
    }
    
    public static function requireAuth() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Lab03_Group05/public/auth/login.php');
            exit;
        }
    }
    
    public static function requireAdmin() {
        self::requireAuth();
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /Lab03_Group05/public/index.php?error=access_denied');
            exit;
        }
    }
    
    public static function isAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    public static function isVolunteer() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer';
    }
}