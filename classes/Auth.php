<?php
class Auth {
    public static function login($username, $password) {
        $db = require __DIR__ . '/../db_connection.php';
        
        $stmt = $db->prepare("
            SELECT u.*, v.full_name, v.status as volunteer_status 
            FROM Users u 
            LEFT JOIN Volunteers v ON u.volunteer_id = v.volunteer_id 
            WHERE u.username = ?
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Check if volunteer account is active
            if ($user['role'] === 'volunteer' && $user['volunteer_status'] !== 'active') {
                return ['success' => false, 'message' => 'Your volunteer account is not active.'];
            }
            
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['volunteer_id'] = $user['volunteer_id'];
            
            return ['success' => true, 'user' => $user];
        }
        
        return ['success' => false, 'message' => 'Invalid credentials.'];
    }
    
    public static function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Lab03_Group05/public/login.php');
            exit;
        }
    }
    
    public static function requireAdmin() {
        self::requireAuth();
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /Lab03_Group05/public/dashboard.php?error=access_denied');
            exit;
        }
    }
    
    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    public static function isVolunteer() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer';
    }
}