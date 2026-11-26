<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div class="auth-split-shell">
    <!-- Left Info & Demo Accounts Panel (5 cols) -->
    <aside class="auth-aside">
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div style="width: 2.75rem; height: 2.75rem; border-radius: var(--radius-md); background: var(--primary); color: var(--on-primary); display: inline-flex; align-items: center; justify-content: center;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <circle cx="12" cy="10" r="2.5"/>
                </svg>
            </div>
            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary);">
                Otentikasi Akun · NurturaID
            </span>
            <h1 style="font-size: clamp(1.45rem, 4.5vw, 1.65rem); font-weight: 700; color: var(--text-main); margin: 0;">
                Masuk ke Nurtura
            </h1>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.55; margin: 0;">
                Akses panel dukungan gizi ibu hamil, pantau penyaluran paket pangan Posyandu, atau kelola verifikasi Buku KIA.
            </p>
        </div>

        <!-- Quick Demo Accounts -->
        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">Akun Pengujian Demo</span>
                <span class="font-mono" style="font-size: 0.75rem; font-weight: 600; color: var(--primary);">1-Klik Isi</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <button type="button" class="demo-fill-btn" onclick="fillDemo('admin@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: var(--text-main); display: block;">Administrator (NurturaGuard)</strong>
                        <span class="font-mono" style="font-size: 0.75rem; color: var(--text-muted);">admin@nurtura.local</span>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">Pilih →</span>
                </button>

                <button type="button" class="demo-fill-btn" onclick="fillDemo('ibu.siti@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: var(--text-main); display: block;">Ibu Hamil (Siti Aminah)</strong>
                        <span class="font-mono" style="font-size: 0.75rem; color: var(--text-muted);">ibu.siti@nurtura.local</span>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">Pilih →</span>
                </button>

                <button type="button" class="demo-fill-btn" onclick="fillDemo('donatur.budi@nurtura.local', 'password123')">
                    <div>
                        <strong style="color: var(--text-main); display: block;">Donatur (Budi Santoso)</strong>
                        <span class="font-mono" style="font-size: 0.75rem; color: var(--text-muted);">donatur.budi@nurtura.local</span>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">Pilih →</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Right Sign-In Form (7 cols) -->
    <section class="auth-form-panel">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                Masuk dengan Email Terdaftar
            </h2>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Masukkan kredensial akun Nurtura Anda di bawah ini.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="margin-bottom: 0;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registrasi_sukses'): ?>
            <div class="alert alert-success" style="margin-bottom: 0;">
                Pendaftaran berhasil. Silakan masuk menggunakan akun baru Anda.
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <div class="form-group" style="margin-bottom: 0;">
                <label for="email">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="nama@email.com"
                    required
                    autocomplete="email">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="password">Kata Sandi</label>
                <div style="position: relative;">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        style="padding-right: 3rem;"
                        placeholder="Masukkan kata sandi"
                        required
                        autocomplete="current-password">
                    <button type="button" id="toggle-password" aria-label="Tampilkan atau sembunyikan kata sandi" style="position: absolute; right: 0.375rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; min-width: 2.5rem; min-height: 2.5rem; padding: 0.25rem;">
                        <svg id="toggle-password-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" id="btn-login-submit" class="btn-cerulean" style="width: 100%; padding: 0.75rem; font-size: 0.94rem; margin-top: 0.25rem;">
                Masuk ke Akun
            </button>
        </form>

        <p style="text-align: center; margin: 0.25rem 0 0 0; font-size: 0.88rem; color: var(--text-muted);">
            Belum memiliki akun? <a href="index.php?page=register" style="font-weight: 600; color: var(--primary);">Daftar sekarang</a>
        </p>
    </section>
</div>

<script>
function fillDemo(email, password) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    if (emailInput && passwordInput) {
        emailInput.value = email;
        passwordInput.value = password;
        emailInput.style.borderColor = '#376386';
        passwordInput.style.borderColor = '#376386';
        setTimeout(() => {
            emailInput.style.borderColor = '';
            passwordInput.style.borderColor = '';
        }, 900);
        const btnSubmit = document.getElementById('btn-login-submit');
        if (btnSubmit) btnSubmit.focus();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-password');
    const passInput = document.getElementById('password');
    if (toggleBtn && passInput) {
        toggleBtn.addEventListener('click', () => {
            passInput.type = passInput.type === 'password' ? 'text' : 'password';
        });
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
