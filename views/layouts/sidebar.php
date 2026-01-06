<?php
// ================================
// SIDEBAR DINAMIS BERDASARKAN ROLE
// ================================

$moduleModel = new ModulModel($pdo);
$modules = $moduleModel->getByRole($_SESSION['user']['role']);
?>

<aside class="sidebar">
    <ul>

        <li>
            <a href="<?= BASE_URL ?>/?page=dashboard">Dashboard</a>
        </li>

        <?php foreach ($modules as $mod): ?>
            <li>
                <a href="<?= BASE_URL ?>/?page=<?= $mod['slug'] ?>">
                    <?= ucfirst($mod['nama']) ?>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>
</aside>