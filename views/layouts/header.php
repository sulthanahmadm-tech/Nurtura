<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$currentPage = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> — <?= APP_TAGLINE ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/brand/nurtura-favicon.svg">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/../../public/assets/css/style.css') ?>">
</head>
<body>
    <header class="navbar-clean">
        <div class="nav-clean-container">
            <a href="index.php?page=home" class="brand" title="<?= APP_NAME ?> — Platform Solidaritas Gizi Ibu Hamil">
                <span class="brand-mark" aria-hidden="true">
                    <svg class="brand-mark-svg" viewBox="0 0 256 256" fill="none">
                        <circle cx="67" cy="58" r="18" fill="#19496B"/>
                        <circle cx="189" cy="58" r="18" fill="#19496B"/>
                        <path d="M 48 85 C 31 91 22 114 24 142 C 27 179 59 211 106 212 C 146 213 177 190 192 156 C 194 151 190 150 186 155 C 167 178 139 190 110 187 C 86 184 71 171 67 154 C 78 164 93 169 111 171 C 118 172 122 168 122 163 C 122 158 117 155 110 153 C 87 146 72 127 69 101 C 67 88 58 81 48 85 Z" fill="#19496B"/>
                        <path d="M 208 85 C 198 81 189 88 187 101 C 184 127 169 146 146 153 C 139 155 134 158 134 163 C 134 168 138 172 145 171 C 164 169 180 163 190 152 C 183 180 159 203 125 216 C 119 218 121 221 128 220 C 185 214 229 178 232 142 C 234 114 225 91 208 85 Z" fill="#19496B"/>
                        <circle cx="128" cy="96" r="13.5" fill="#376386"/>
                        <path d="M 94 102 C 90 98 85 101 88 107 C 94 120 105 131 114 139 C 117 142 118 147 119 151 C 120 155 124 157 128 157 C 132 157 136 155 137 151 C 138 147 139 142 142 139 C 151 131 162 120 168 107 C 171 101 166 98 162 102 C 153 112 141 122 128 122 C 115 122 103 112 94 102 Z" fill="#376386"/>
                    </svg>
                </span>
                <span><?= APP_NAME ?></span>
            </a>

            <nav class="nav-desktop-nav" aria-label="Navigasi Utama">
                <ul class="nav-links">
                    <li>
                        <a href="index.php?page=home" class="nav-tab <?= $currentPage === 'home' ? 'is-active' : '' ?>">Beranda</a>
                    </li>
                    <li>
                        <a href="index.php?page=explore" class="nav-tab <?= ($currentPage === 'explore' || $currentPage === 'need-detail') ? 'is-active' : '' ?>">Katalog Kebutuhan</a>
                    </li>

                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <li>
                                <a href="index.php?page=admin-dashboard" class="nav-tab <?= $currentPage === 'admin-dashboard' ? 'is-active' : '' ?>">Panel Admin</a>
                            </li>
                        <?php elseif (is_ibu_hamil()): ?>
                            <li>
                                <a href="index.php?page=ibu-hamil-dashboard" class="nav-tab <?= $currentPage === 'ibu-hamil-dashboard' ? 'is-active' : '' ?>">Dashboard Saya</a>
                            </li>
                        <?php elseif (is_donatur()): ?>
                            <li>
                                <a href="index.php?page=donatur-dashboard" class="nav-tab <?= $currentPage === 'donatur-dashboard' ? 'is-active' : '' ?>">Komitmen Donasi</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="nav-actions">
                <?php if (is_logged_in()): ?>
                    <?php if (is_ibu_hamil()): ?>
                        <a href="index.php?page=create-need" class="btn-cerulean btn-sm">+ Ajukan Kebutuhan</a>
                    <?php endif; ?>
                    <?php $shortName = explode(' ', trim(current_user()['full_name']))[0]; ?>
                    <a href="index.php?action=logout" class="btn-ghost-clean btn-sm" title="Masuk sebagai <?= htmlspecialchars(current_user()['full_name']) ?>">Keluar (<?= htmlspecialchars($shortName) ?>)</a>
                <?php else: ?>
                    <a href="index.php?page=login" class="btn-ghost-clean btn-sm">Masuk</a>
                    <a href="index.php?page=register" class="btn-cerulean btn-sm">Daftar</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Header Controls (Compact 3.5rem Bar: 1 Quick CTA + Hamburger Drawer) -->
            <div class="nav-mobile-controls">
                <?php if (is_logged_in()): ?>
                    <?php if (is_ibu_hamil()): ?>
                        <a href="index.php?page=create-need" class="btn-cerulean btn-sm">+ Ajukan</a>
                    <?php elseif (is_admin()): ?>
                        <a href="index.php?page=admin-dashboard" class="btn-cerulean btn-sm">Moderasi</a>
                    <?php else: ?>
                        <a href="index.php?page=explore" class="btn-cerulean btn-sm">Katalog</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="index.php?page=login" class="btn-cerulean btn-sm">Masuk</a>
                <?php endif; ?>

                <button type="button" id="mobile-nav-toggle" class="nav-hamburger-btn" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-nav-drawer">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav-backdrop" class="mobile-nav-backdrop" aria-hidden="true"></div>
    <aside id="mobile-nav-drawer" class="mobile-nav-drawer" aria-label="Menu Navigasi Mobile" aria-hidden="true">
        <div>
            <div class="mobile-nav-header">
                <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--font-display); font-size: 1.15rem; font-weight: 700; color: var(--text-main);">
                    <svg style="width: 1.375rem; height: 1.375rem; flex-shrink: 0;" viewBox="0 0 256 256" fill="none" aria-hidden="true">
                        <circle cx="67" cy="58" r="18" fill="#19496B"/>
                        <circle cx="189" cy="58" r="18" fill="#19496B"/>
                        <path d="M 48 85 C 31 91 22 114 24 142 C 27 179 59 211 106 212 C 146 213 177 190 192 156 C 194 151 190 150 186 155 C 167 178 139 190 110 187 C 86 184 71 171 67 154 C 78 164 93 169 111 171 C 118 172 122 168 122 163 C 122 158 117 155 110 153 C 87 146 72 127 69 101 C 67 88 58 81 48 85 Z" fill="#19496B"/>
                        <path d="M 208 85 C 198 81 189 88 187 101 C 184 127 169 146 146 153 C 139 155 134 158 134 163 C 134 168 138 172 145 171 C 164 169 180 163 190 152 C 183 180 159 203 125 216 C 119 218 121 221 128 220 C 185 214 229 178 232 142 C 234 114 225 91 208 85 Z" fill="#19496B"/>
                        <circle cx="128" cy="96" r="13.5" fill="#376386"/>
                        <path d="M 94 102 C 90 98 85 101 88 107 C 94 120 105 131 114 139 C 117 142 118 147 119 151 C 120 155 124 157 128 157 C 132 157 136 155 137 151 C 138 147 139 142 142 139 C 151 131 162 120 168 107 C 171 101 166 98 162 102 C 153 112 141 122 128 122 C 115 122 103 112 94 102 Z" fill="#376386"/>
                    </svg>
                    <span>Menu <?= APP_NAME ?></span>
                </span>
                <button type="button" id="mobile-nav-close" class="modal-close-circle" aria-label="Tutup menu">&times;</button>
            </div>

            <?php if (is_logged_in()): ?>
                <div class="inset-well" style="margin-top: 0.875rem; margin-bottom: 0.875rem; padding: 0.75rem 0.875rem;">
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--primary);">
                        Akun Aktif (<?= htmlspecialchars(str_replace('_', ' ', user_role())) ?>)
                    </div>
                    <div style="font-size: 0.92rem; font-weight: 700; color: var(--text-main); margin-top: 0.15rem;">
                        <?= htmlspecialchars(current_user()['full_name']) ?>
                    </div>
                </div>
            <?php endif; ?>

            <ul class="mobile-drawer-links" style="margin-top: 0.5rem;">
                <li>
                    <a href="index.php?page=home" class="mobile-drawer-link <?= $currentPage === 'home' ? 'is-active' : '' ?>">
                        <span>Beranda</span>
                        <span>→</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?page=explore" class="mobile-drawer-link <?= ($currentPage === 'explore' || $currentPage === 'need-detail') ? 'is-active' : '' ?>">
                        <span>Katalog Kebutuhan</span>
                        <span>→</span>
                    </a>
                </li>
                <?php if (is_logged_in()): ?>
                    <?php if (is_admin()): ?>
                        <li>
                            <a href="index.php?page=admin-dashboard" class="mobile-drawer-link <?= $currentPage === 'admin-dashboard' ? 'is-active' : '' ?>">
                                <span>Panel Admin</span>
                                <span>→</span>
                            </a>
                        </li>
                    <?php elseif (is_ibu_hamil()): ?>
                        <li>
                            <a href="index.php?page=ibu-hamil-dashboard" class="mobile-drawer-link <?= $currentPage === 'ibu-hamil-dashboard' ? 'is-active' : '' ?>">
                                <span>Dashboard Saya</span>
                                <span>→</span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?page=create-need" class="mobile-drawer-link <?= $currentPage === 'create-need' ? 'is-active' : '' ?>">
                                <span>Ajukan Kebutuhan Gizi</span>
                                <span>→</span>
                            </a>
                        </li>
                    <?php elseif (is_donatur()): ?>
                        <li>
                            <a href="index.php?page=donatur-dashboard" class="mobile-drawer-link <?= $currentPage === 'donatur-dashboard' ? 'is-active' : '' ?>">
                                <span>Komitmen Donasi</span>
                                <span>→</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="mobile-drawer-actions">
            <?php if (is_logged_in()): ?>
                <a href="index.php?action=logout" class="btn-danger-outline" style="width: 100%;">Keluar dari Akun</a>
            <?php else: ?>
                <a href="index.php?page=register" class="btn-cerulean" style="width: 100%;">Daftar Akun Baru</a>
                <a href="index.php?page=login" class="btn-ghost-clean" style="width: 100%;">Masuk ke Akun</a>
            <?php endif; ?>
        </div>
    </aside>

    <main class="container main-shell">
