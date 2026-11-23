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
    <header class="navbar">
        <div class="container nav-container">
            <a href="index.php?page=home" class="brand">
                <span>🌱 <?= APP_NAME ?></span>
                <span class="brand-tag">Cegah Stunting</span>
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php?page=home">Beranda</a></li>
                    <li><a href="index.php?page=explore">Katalog Kebutuhan</a></li>
                    
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <li><a href="index.php?page=admin-dashboard" class="btn btn-warning btn-sm">🛡️ Admin</a></li>
                        <?php elseif (is_ibu_hamil()): ?>
                            <li><a href="index.php?page=ibu-hamil-dashboard">Dashboard Ibu Hamil</a></li>
                            <li><a href="index.php?page=create-need" class="btn btn-primary btn-sm">+ Ajukan Kebutuhan</a></li>
                        <?php elseif (is_donatur()): ?>
                            <li><a href="index.php?page=donatur-dashboard">Komitmen Donasi Saya</a></li>
                        <?php endif; ?>
                        
                        <?php 
                            $shortName = explode(' ', trim(current_user()['full_name']))[0]; 
                        ?>
                        <li><a href="index.php?action=logout" class="btn btn-secondary btn-sm" title="Masuk sebagai <?= htmlspecialchars(current_user()['full_name']) ?>">Keluar (<?= htmlspecialchars($shortName) ?>)</a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=login" class="btn btn-secondary btn-sm">Masuk</a></li>
                        <li><a href="index.php?page=register" class="btn btn-primary btn-sm">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container" style="padding-top: 24px; padding-bottom: 40px;">
