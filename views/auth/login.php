<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 420px; margin: 40px auto;">
    <div class="card">
        <h2 style="text-align: center; margin-bottom: 20px;">Masuk ke Nurtura</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
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

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Masuk</button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
            Belum memiliki akun? <a href="index.php?page=register">Daftar sekarang</a>
        </p>

        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px dashed var(--border-color); font-size: 0.8rem; color: var(--text-muted);">
            <strong>Akun Pengujian Demo (Seed):</strong><br>
            • Admin: <code>admin@nurtura.local</code> (Pass: <code>password123</code>)<br>
            • Ibu Hamil: <code>ibu.siti@nurtura.local</code> (Pass: <code>password123</code>)<br>
            • Donatur: <code>donatur.budi@nurtura.local</code> (Pass: <code>password123</code>)
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
