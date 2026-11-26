<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div class="auth-register-shell">
    <!-- Header -->
    <header style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 1rem; padding-bottom: 1.375rem; margin-bottom: 1.625rem; border-bottom: 0.0625rem solid var(--border-subtle);">
        <div>
            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                Registrasi Pengguna · NurturaID
            </span>
            <h1 style="font-size: clamp(1.5rem, 4.5vw, 2.05rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                Pendaftaran Akun Baru
            </h1>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">
                Bergabung bersama gerakan terpadu intervensi gizi ibu hamil dan pencegahan stunting.
            </p>
        </div>
        <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
            Sudah punya akun? <a href="index.php?page=login" style="font-weight: 600; color: var(--primary);">Masuk di sini</a>
        </p>
    </header>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?page=register" method="POST" style="display: flex; flex-direction: column; gap: 1.625rem;">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

        <!-- Role Selector -->
        <div>
            <span style="font-weight: 600; color: var(--text-main); font-size: 0.9rem; margin-bottom: 0.625rem; display: block;">
                Pilih Peran Akun
            </span>
            <div class="role-cards-grid">
                <label class="role-card selected" id="card-role-ibu" onclick="selectRole('ibu_hamil')">
                    <input type="radio" name="role" value="ibu_hamil" checked>
                    <span class="role-card-title">Ibu Hamil</span>
                    <span class="role-card-desc">Penerima manfaat bantuan pangan bernutrisi pencegahan stunting.</span>
                </label>

                <label class="role-card" id="card-role-donatur" onclick="selectRole('donatur')">
                    <input type="radio" name="role" value="donatur">
                    <span class="role-card-title">Masyarakat / Donatur</span>
                    <span class="role-card-desc">Penyalur paket pangan bergizi melalui drop-point Posyandu.</span>
                </label>
            </div>
        </div>

        <!-- 2-Column Form Fields -->
        <div class="grid-dashboard-main" style="margin-bottom: 0; align-items: start;">
            <!-- Left: Identitas & Domisili (6 cols) -->
            <div class="col-span-6" style="display: flex; flex-direction: column; gap: 0.875rem;">
                <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">
                    Identitas &amp; Domisili
                </h2>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="full_name">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Contoh: Siti Aminah" required>
                </div>

                <div class="grid-2col">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" required autocomplete="email">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="phone_number">Nomor WhatsApp / Telepon</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                <div class="grid-2col">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="regency_city">Kabupaten / Kota</label>
                        <input type="text" id="regency_city" name="regency_city" class="form-control" value="Banyumas" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="district">Kecamatan</label>
                        <input type="text" id="district" name="district" class="form-control" value="Purwokerto Timur" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="password">Kata Sandi Akun</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                </div>
            </div>

            <!-- Right: Data Medis Kehamilan (6 cols) -->
            <div id="pregnant-mother-fields" class="col-span-6 inset-well" style="padding: clamp(1rem, 3vw, 1.5rem); border: 0.0625rem solid var(--border-color); display: flex; flex-direction: column; gap: 0.875rem;">
                <header style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;">
                    <h2 style="font-family: var(--font-sans); font-size: 1.08rem; font-weight: 700; color: var(--text-main); margin: 0;">
                        Data Medis Kehamilan
                    </h2>
                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--botanical); flex-shrink: 0;">Rujukan Buku KIA</span>
                </header>

                <div class="grid-2col">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="gestational_age_weeks">Usia Kehamilan (Minggu)</label>
                        <input type="number" id="gestational_age_weeks" name="gestational_age_weeks" class="form-control" placeholder="Contoh: 24" min="1" max="42">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="estimated_birth_date">Hari Perkiraan Lahir (HPL)</label>
                        <input type="date" id="estimated_birth_date" name="estimated_birth_date" class="form-control">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="lila_cm">Ukuran Lingkar Lengan Atas (LILA dalam cm)</label>
                    <input type="number" step="0.1" id="lila_cm" name="lila_cm" class="form-control" placeholder="Contoh: 21.5 (Di bawah 23,5 cm indikasi KEK)">
                </div>

                <p style="font-size: 0.84rem; color: var(--text-muted); line-height: 1.55; margin: 0;">
                    Data ini digunakan untuk verifikasi status Kurang Energi Kronis (KEK) sesuai standar Kemenkes RI dan tidak dipublikasikan ke ruang publik.
                </p>
            </div>
        </div>

        <!-- Submit Row -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; padding-top: 1.125rem; border-top: 0.0625rem solid var(--border-subtle);">
            <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">
                Dengan mendaftar, Anda menyetujui standar privasi medis Nurtura (Zero PII Leakage).
            </span>
            <button type="submit" class="btn-cerulean" style="padding: 0.75rem 1.75rem; font-size: 0.94rem;">
                Daftar Akun Baru
            </button>
        </div>
    </form>
</div>

<script>
function selectRole(role) {
    const cardIbu = document.getElementById('card-role-ibu');
    const cardDonatur = document.getElementById('card-role-donatur');
    const pregnantFields = document.getElementById('pregnant-mother-fields');
    const radioIbu = document.querySelector('input[name="role"][value="ibu_hamil"]');
    const radioDonatur = document.querySelector('input[name="role"][value="donatur"]');

    if (role === 'ibu_hamil') {
        if (radioIbu) radioIbu.checked = true;
        if (cardIbu) cardIbu.classList.add('selected');
        if (cardDonatur) cardDonatur.classList.remove('selected');
        if (pregnantFields) pregnantFields.style.display = 'flex';
    } else {
        if (radioDonatur) radioDonatur.checked = true;
        if (cardDonatur) cardDonatur.classList.add('selected');
        if (cardIbu) cardIbu.classList.remove('selected');
        if (pregnantFields) pregnantFields.style.display = 'none';
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
