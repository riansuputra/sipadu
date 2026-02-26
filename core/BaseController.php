<?php

require_once __DIR__ . '/auth.php';

class BaseController
{
    protected $user;
    protected $role;
    protected $pokja;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->role = Auth::role();
        $this->pokja = Auth::pokja();
    }

    protected function auth()
    {
        if (!Auth::check()) {
            $this->redirect('?page=login');
        }

        // refresh data dari session
        $this->user = Auth::user();
        $this->role = Auth::role();
        $this->pokja = Auth::pokja();

        // extra safety
        if (!$this->user || empty($this->user['id'])) {
            $this->abort403();
        }
    }

    protected function view($path, $data = [])
    {
        extract($data);

        require __DIR__ . "/../views/$path.php";
    }

    protected function redirect($url)
    {
        header("Location: " . url($url));
        exit;
    }

    protected function model($name)
    {
        require_once __DIR__ . "/../models/$name.php";
        return new $name();
    }

    // ==============================
    // ERROR RESPONSE
    // ==============================
    protected function abort404()
    {
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
        exit;
    }

    protected function abort403()
    {
        http_response_code(403);
        require __DIR__ . '/../views/errors/403.php';
        exit;
    }

    // ==============================
    // MAINTENANCE
    // ==============================
    protected function maintenance()
    {
        require __DIR__ . '/../views/errors/maintenance.php';
        exit;
    }

    protected function log($data)
    {
        $this->model('LogModel')->create($data);
    }

    protected function roleOnly(array $roles)
    {
        if (!in_array($this->role, $roles)) {
            $this->abort403();
        }
    }

    protected function guest()
    {
        if (Auth::check()) {
            $this->redirect('?page=dashboard');
        }
    }

    protected function flash($status, $message)
    {
        $_SESSION['flash'] = [
            'status' => $status,
            'message' => $message
        ];
    }
}
