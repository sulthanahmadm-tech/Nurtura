<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 450px; margin: 36px auto;">
    <div class="card" style="padding: 36px 32px; border: 1px solid var(--border-color); box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 50px; height: 50px; background: var(--primary-light); color: var(--primary); border-radius: var(--radius-sm); display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 12px;">
                🌱
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">Masuk ke Nurtura</h2>
            <p style="font-size: 0.88rem; color: var(--text-muted);">Platform Dukungan Gizi Ibu Hamil & Pencegahan Stunting</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="display: flex; align-items: center; gap: 8px;">
                <span>⚠️</span>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registrasi_sukses'): ?>
            <div class="alert alert-success">Pendaftaran berhasil! Silakan masuk dengan akun Anda.</div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <div class="form-group">
                <label for="email">Alamat Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Kata sandi akun" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; font-size: 1rem; padding: 12px;">Masuk ke Akun</button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
            Belum memiliki akun? <a href="index.php?page=register" style="font-weight: 600;">Daftar sekarang</a>
        </p>

        <div style="margin-top: 24px; padding: 14px; background: var(--bg-page); border-radius: var(--radius-sm); border: 1px dashed var(--border-color); font-size: 0.82rem; color: var(--text-muted);">
            <strong style="color: var(--text-main); display: block; margin-bottom: 6px;">Akun Pengujian Demo (Seed):</strong>
            <div style="display: flex; flex-direction: column; gap: 3px;">
                <div>🛡️ <strong>Admin:</strong> <code>admin@nurtura.local</code> (Pass: <code>password123</code>)</div>
                <div>🤰 <strong>Ibu Hamil:</strong> <code>ibu.siti@nurtura.local</code> (Pass: <code>password123</code>)</div>
                <div>🤝 <strong>Donatur:</strong> <code>donatur.budi@nurtura.local</code> (Pass: <code>password123</code>)</div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
