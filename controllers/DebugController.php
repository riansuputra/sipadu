<?php

require_once __DIR__ . '/../core/BaseController.php';


class DebugController extends BaseController
{
    // tampilkan log
    public function index()
    {
        $this->auth();

        // hanya superadmin
        $this->roleOnly(['Superadmin']);

        $file = __DIR__ . '/../logs/debug.log';

        $content = '';

        if (file_exists($file)) {
            $content = file_get_contents($file);
        }

        require __DIR__ . '/../views/debug/index.php';
    }

    // clear log
    public function clear()
    {
        $this->auth();

        $this->roleOnly(['Superadmin']);

        $file = __DIR__ . '/../logs/debug.log';

        file_put_contents($file, '');

        $_SESSION['success'] = 'Log berhasil dibersihkan';

        header('Location: /debug');
        exit;
    }
}
