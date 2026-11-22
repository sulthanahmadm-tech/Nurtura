<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 500px; margin: 30px auto;">
    <div class="card">
        <h2 style="text-align: center; margin-bottom: 20px;">Pendaftaran Akun Nurtura</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="index.php?page=register" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <div class="form-group">
                <label for="role-select">Mendaftar Sebagai:</label>
                <select name="role" id="role-select" class="form-control" required>
                    <option value="ibu_hamil">Ibu Hamil (Pengaju Dukungan Gizi)</option>
                    <option value="donatur">Masyarakat / Donatur (Pemberi Dukungan)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="full_name">Nama Lengkap:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Nama lengkap sesuai KTP" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Nomor WhatsApp / Telepon:</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="08xxxxxxxxxx" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label for="regency_city">Kabupaten / Kota:</label>
                    <input type="text" id="regency_city" name="regency_city" class="form-control" value="Banyumas" required>
                </div>
                <div class="form-group">
                    <label for="district">Kecamatan:</label>
                    <input type="text" id="district" name="district" class="form-control" value="Purwokerto Timur" required>
                </div>
            </div>

            <!-- Bagian Khusus Ibu Hamil (Toggle via JavaScript) -->
            <div id="pregnant-mother-fields" style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px dashed var(--border-color); margin-bottom: 16px;">
                <h4 style="margin-bottom: 12px; color: #065f46;">Data Medis Awal Kehamilan</h4>
                
                <div class="form-group">
                    <label for="gestational_age_weeks">Usia Kehamilan Saat Ini (Minggu):</label>
                    <input type="number" id="gestational_age_weeks" name="gestational_age_weeks" class="form-control" placeholder="Contoh: 24" min="1" max="42">
                </div>

                <div class="form-group">
                    <label for="estimated_birth_date">Hari Perkiraan Lahir (HPL):</label>
                    <input type="date" id="estimated_birth_date" name="estimated_birth_date" class="form-control">
                </div>

                <div class="form-group">
                    <label for="lila_cm">Lingkar Lengan Atas (LILA dalam cm):</label>
                    <input type="number" step="0.1" id="lila_cm" name="lila_cm" class="form-control" placeholder="Contoh: 21.5 (Di bawah 23.5 cm terindikasi KEK)">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Daftar Sekarang</button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
            Sudah memiliki akun? <a href="index.php?page=login">Masuk di sini</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
