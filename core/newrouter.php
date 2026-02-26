<?php
// ================================
// ROUTER APLIKASI SIPADU
// ================================

// Fungsi utama router
function routeRequest()
{
    $page = $_GET['page'] ?? 'login';

    if (isMaintenance($page)) {
        showMaintenance();
    }

    // =========================
    // ROUTE MAP
    // =========================
    $routes = [

        // AUTH
        'login' => [AuthController::class, 'login', ['guest']],
        'login-process' => [AuthController::class, 'authenticate', ['guest']],
        'logout' => [AuthController::class, 'logout', ['auth']],

        // USER
        'user' => [UserController::class, 'index', ['auth', 'role:Superadmin']],
        'tambah-user' => [UserController::class, 'create', ['auth', 'role:Superadmin']],
        'user-store' => [UserController::class, 'store', ['auth', 'role:Superadmin']],
    ];

    if (!isset($routes[$page])) {
        abort404();
    }

    [$controllerName, $method, $middlewares] = $routes[$page];

    // =========================
    // LOAD CONTROLLER
    // =========================
    $file = __DIR__ . "/../controllers/$controllerName.php";

    if (!file_exists($file)) {
        abort404();
    }

    require_once $file;

    $controller = new $controllerName();

    // =========================
    // EXECUTE MIDDLEWARE
    // =========================
    foreach ($middlewares ?? [] as $mw) {
        runMiddleware($mw, $controller);
    }

    // =========================
    // EXECUTE METHOD
    // =========================
    if (!method_exists($controller, $method)) {
        abort404();
    }

    $controller->$method();
}

function runMiddleware($mw, $controller)
{
    // ======================
    // AUTH (wajib login)
    // ======================
    if ($mw === 'auth') {
        if (method_exists($controller, 'auth')) {
            $controller->auth();
        }
        return;
    }

    // ======================
    // GUEST ONLY
    // ======================
    if ($mw === 'guest') {
        if (method_exists($controller, 'guest')) {
            $controller->guest();
        }
        return;
    }

    // ======================
    // ROLE CHECK
    // ======================
    if (str_starts_with($mw, 'role:')) {
        $role = explode(':', $mw)[1];

        if (method_exists($controller, 'roleOnly')) {
            $controller->roleOnly([$role]);
        }
        return;
    }
}
