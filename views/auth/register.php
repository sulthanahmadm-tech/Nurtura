<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div class="auth-container register">
    <div class="auth-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
            </div>
            <div style="font-size: 0.76rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px;">
                Registrasi Pengguna • NurturaID
            </div>
            <h1 style="font-size: 1.55rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">
                Pendaftaran Akun Baru
            </h1>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
                Bergabung bersama gerakan terpadu intervensi gizi ibu hamil dan pencegahan stunting.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="font-size: 0.88rem; padding: 12px 16px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=register" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <!-- Pemilihan Peran (Dual Interactive Cards) -->
            <div style="margin-bottom: 16px;">
                <label style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 8px; display: block;">
                    Pilih Peran Akun:
                </label>
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

            <!-- Identitas Diri -->
            <div class="form-group" style="margin-bottom: 16px;">
                <label for="full_name" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                    Nama Lengkap (Sesuai KTP):
                </label>
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    class="form-control"
                    placeholder="Contoh: Siti Aminah"
                    required
                    style="background: #ffffff;">
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
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

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="phone_number" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                        Nomor WhatsApp / Telepon:
                    </label>
                    <input
                        type="text"
                        id="phone_number"
                        name="phone_number"
                        class="form-control"
                        placeholder="Contoh: 081234567890"
                        required
                        style="background: #ffffff;">
                </div>
            </div>

            <!-- Domisili -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 18px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="regency_city" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                        Kabupaten / Kota:
                    </label>
                    <input
                        type="text"
                        id="regency_city"
                        name="regency_city"
                        class="form-control"
                        value="Banyumas"
                        required
                        style="background: #ffffff;">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="district" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                        Kecamatan:
                    </label>
                    <input
                        type="text"
                        id="district"
                        name="district"
                        class="form-control"
                        value="Purwokerto Timur"
                        required
                        style="background: #ffffff;">
                </div>
            </div>

            <!-- Bagian Khusus Ibu Hamil (Toggle Mulus via Dual Cards) -->
            <div id="pregnant-mother-fields" style="background: #f0fdf4; padding: 20px; border-radius: var(--radius-sm); border: 1px solid #bbf7d0; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 0.76rem; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.04em;">
                        Data Medis Awal Kehamilan (Rujukan Buku KIA)
                    </span>
                    <span class="badge badge-success" style="font-size: 0.7rem;">Klinis Medis</span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="gestational_age_weeks" style="font-weight: 700; color: #0f172a; font-size: 0.84rem; margin-bottom: 6px; display: block;">
                            Usia Kehamilan (Minggu):
                        </label>
                        <input
                            type="number"
                            id="gestational_age_weeks"
                            name="gestational_age_weeks"
                            class="form-control"
                            placeholder="Contoh: 24"
                            min="1"
                            max="42"
                            style="background: #ffffff;">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="estimated_birth_date" style="font-weight: 700; color: #0f172a; font-size: 0.84rem; margin-bottom: 6px; display: block;">
                            Hari Perkiraan Lahir (HPL):
                        </label>
                        <input
                            type="date"
                            id="estimated_birth_date"
                            name="estimated_birth_date"
                            class="form-control"
                            style="background: #ffffff;">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 14px; margin-bottom: 0;">
                    <label for="lila_cm" style="font-weight: 700; color: #0f172a; font-size: 0.84rem; margin-bottom: 6px; display: block;">
                        Ukuran Lingkar Lengan Atas (LILA dalam cm):
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        id="lila_cm"
                        name="lila_cm"
                        class="form-control"
                        placeholder="Contoh: 21.5 (Di bawah 23,5 cm terindikasi risiko KEK)"
                        style="background: #ffffff;">
                    <span style="font-size: 0.74rem; color: #166534; display: block; margin-top: 4px;">
                        Data ini digunakan untuk verifikasi status Kurang Energi Kronis (KEK) sesuai standar Kemenkes.
                    </span>
                </div>
            </div>

            <!-- Kata Sandi -->
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="password" style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin-bottom: 6px; display: block;">
                    Kata Sandi Akun:
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Minimal 6 karakter"
                    required
                    autocomplete="new-password"
                    style="background: #ffffff;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 0.95rem;">
                Daftar Akun Baru
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; margin-bottom: 0; font-size: 0.9rem; color: var(--text-muted);">
            Sudah memiliki akun? <a href="index.php?page=login" style="font-weight: 700; color: #0284c7;">Masuk di sini</a>
        </p>
    </div>
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
        if (pregnantFields) pregnantFields.style.display = 'block';
    } else {
        if (radioDonatur) radioDonatur.checked = true;
        if (cardDonatur) cardDonatur.classList.add('selected');
        if (cardIbu) cardIbu.classList.remove('selected');
        if (pregnantFields) pregnantFields.style.display = 'none';
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
