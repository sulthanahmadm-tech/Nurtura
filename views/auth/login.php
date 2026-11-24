<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22v-9"/>
                    <path d="M12 13c-3-2-6-1-7 2 3 1 6 0 7-2z"/>
                    <path d="M12 13c3-3 6-2 7 1-3 2-6 0-7-1z"/>
                </svg>
            </div>
            <div style="font-size: 0.76rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px;">
                Otentikasi Akun • NurturaID
            </div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
                Masuk ke Nurtura
            </h1>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Platform Dukungan Gizi Ibu Hamil & Pencegahan Stunting
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="font-size: 0.88rem; padding: 12px 16px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registrasi_sukses'): ?>
            <div class="alert alert-success" style="font-size: 0.88rem; padding: 12px 16px; margin-bottom: 20px;">
                Pendaftaran berhasil. Silakan masuk menggunakan akun baru Anda.
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="email" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                    Alamat Email:
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="nama@email.com"
                    required
                    autocomplete="email"
                    style="background: #ffffff;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                    <label for="password" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin: 0;">
                        Kata Sandi:
                    </label>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan kata sandi"
                    required
                    autocomplete="current-password"
                    style="background: #ffffff;">
            </div>

            <button type="submit" id="btn-login-submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 0.95rem;">
                Masuk ke Akun
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; margin-bottom: 0; font-size: 0.9rem; color: var(--text-muted);">
            Belum memiliki akun? <a href="index.php?page=register" style="font-weight: 700; color: #0284c7;">Daftar sekarang</a>
        </p>

        <!-- Akun Pengujian Demo (1-Click Quick-Fill & Zero Emoji) -->
        <div style="margin-top: 24px; padding: 16px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px dashed #cbd5e1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em;">
                    Akun Pengujian Demo (1-Klik Isi Cepat):
                </span>
                <span class="badge badge-secondary" style="font-size: 0.7rem; padding: 3px 8px;">Seed Data</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <button type="button" class="demo-fill-btn" onclick="fillDemo('admin@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: #0f172a; display: block;">Administrator (NurturaGuard)</strong>
                        <span style="font-size: 0.74rem; color: #64748b;">admin@nurtura.local</span>
                    </div>
                    <span style="font-size: 0.74rem; font-weight: 700; color: #0284c7;">Pilih &rsaquo;</span>
                </button>

                <button type="button" class="demo-fill-btn" onclick="fillDemo('ibu.siti@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: #0f172a; display: block;">Ibu Hamil (Siti Aminah)</strong>
                        <span style="font-size: 0.74rem; color: #64748b;">ibu.siti@nurtura.local • Indikasi KEK</span>
                    </div>
                    <span style="font-size: 0.74rem; font-weight: 700; color: #0284c7;">Pilih &rsaquo;</span>
                </button>

                <button type="button" class="demo-fill-btn" onclick="fillDemo('donatur.budi@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: #0f172a; display: block;">Donatur (Budi Santoso)</strong>
                        <span style="font-size: 0.74rem; color: #64748b;">donatur.budi@nurtura.local • Siap Bantu</span>
                    </div>
                    <span style="font-size: 0.74rem; font-weight: 700; color: #0284c7;">Pilih &rsaquo;</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function fillDemo(email, password) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    if (emailInput && passwordInput) {
        emailInput.value = email;
        passwordInput.value = password;
        
        // Animasi highlight lembut
        emailInput.style.borderColor = '#0284c7';
        passwordInput.style.borderColor = '#0284c7';
        setTimeout(() => {
            emailInput.style.borderColor = '';
            passwordInput.style.borderColor = '';
        }, 1000);

        const btnSubmit = document.getElementById('btn-login-submit');
        if (btnSubmit) btnSubmit.focus();
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
