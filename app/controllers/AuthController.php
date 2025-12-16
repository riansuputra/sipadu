<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/auth.php';
require_once __DIR__ . '/../config/config.php';

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate()
    {
        // Sudah login → langsung ke dashboard
        if (isLoggedIn()) {
            redirectToDashboard();
        }

        global $pdo;

        $stmt = $pdo->prepare("
            SELECT u.*, r.role_code, wg.group_type
            FROM users u
            JOIN roles r ON u.role_id = r.id
            LEFT JOIN work_groups wg ON u.work_group_id = wg.id
            WHERE u.username = ?
            LIMIT 1
        ");
        $stmt->execute([$_POST['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (
            !$user ||
            !password_verify($_POST['password'], $user['password_hash'])
        ) {
            $_SESSION['error'] = 'Login gagal';
            header('Location: ' . BASE_URL . '/?page=login');
            exit;
        }

        // set session
        login($user);

        // satu pintu redirect
        redirectToDashboard();
    }
}
