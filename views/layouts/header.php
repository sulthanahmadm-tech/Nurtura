<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> — <?= APP_TAGLINE ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/../../public/assets/css/style.css') ?>">
</head>
<body>
    <header class="navbar-clean">
        <div class="nav-clean-container">
            <a href="index.php?page=home" class="brand">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;">
                    <path d="M12 22v-9"/>
                    <path d="M12 13c-3-2-6-1-7 2 3 1 6 0 7-2z"/>
                    <path d="M12 13c3-3 6-2 7 1-3 2-6 0-7-1z"/>
                </svg>
                <span><?= APP_NAME ?></span>
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php?page=home">Beranda</a></li>
                    <li><a href="index.php?page=explore">Katalog Kebutuhan</a></li>
                    
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <li><a href="index.php?page=admin-dashboard" class="btn btn-warning btn-sm">Panel Admin</a></li>
                        <?php elseif (is_ibu_hamil()): ?>
                            <li><a href="index.php?page=ibu-hamil-dashboard">Dashboard Saya</a></li>
                            <li><a href="index.php?page=create-need" class="btn-lime">+ Ajukan Kebutuhan</a></li>
                        <?php elseif (is_donatur()): ?>
                            <li><a href="index.php?page=donatur-dashboard" class="btn-lime">Komitmen Donasi</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            $shortName = explode(' ', trim(current_user()['full_name']))[0]; 
                        ?>
                        <li><a href="index.php?action=logout" class="btn-ghost-clean" style="padding: 6px 16px; font-size: 0.85rem;" title="Masuk sebagai <?= htmlspecialchars(current_user()['full_name']) ?>">Keluar (<?= htmlspecialchars($shortName) ?>)</a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=login" class="btn-ghost-clean" style="padding: 7px 18px; font-size: 0.88rem;">Masuk</a></li>
                        <li><a href="index.php?page=register" class="btn-lime" style="padding: 7px 20px; font-size: 0.88rem;">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container" style="padding-top: 28px; padding-bottom: 56px;">
