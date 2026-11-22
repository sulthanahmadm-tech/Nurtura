<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 16px;">
        <a href="index.php?page=ibu-hamil-dashboard">← Kembali ke Dashboard</a>
    </div>

    <div class="card">
        <h2 style="margin-bottom: 8px;">Formulir Pengajuan Kebutuhan Gizi (NurturaNeeds)</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
            Ajukan kebutuhan pangan bergizi untuk mendukung masa kehamilan Anda. Pengajuan akan ditinjau oleh admin berdasarkan lampiran Buku KIA sebelum dipublikasikan kepada donatur.
        </p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="index.php?page=create-need" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <div class="form-group">
                <label for="title">Judul Singkat Pengajuan:</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Paket Telur & Susu Hamil Trimester 2" required>
            </div>

            <div class="form-group">
                <label for="food_items_needed">Rincian Paket Bahan Pangan yang Dibutuhkan:</label>
                <textarea id="food_items_needed" name="food_items_needed" class="form-control" rows="3" placeholder="Contoh:&#10;• Telur ayam 2 kg&#10;• Susu ibu hamil rasa cokelat 2 kotak (400 gram)&#10;• Kacang hijau 1 kg" required></textarea>
                <small style="color: var(--text-muted);">Utamakan sumber protein hewani dan asam folat tinggi untuk pencegahan stunting.</small>
            </div>

            <div class="form-group">
                <label for="description">Alasan / Kondisi Kehamilan Saat Ini:</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Jelaskan secara singkat kondisi nafsu makan, anjuran bidan/dokter, atau keterbatasan akses pangan yang dihadapi..." required></textarea>
            </div>

            <div class="form-group">
                <label for="lila_measurement">Pengukuran Lingkar Lengan Atas (LILA) Terakhir (cm):</label>
                <input type="number" step="0.1" id="lila_measurement" name="lila_measurement" class="form-control" value="<?= htmlspecialchars($profile['lila_cm'] ?? '') ?>" placeholder="Contoh: 21.5" required>
                <small style="color: #b91c1c;">*Nilai LILA &lt; 23,5 cm merupakan acuan indikasi medis Kurang Energi Kronis (KEK).</small>
            </div>

            <div class="form-group">
                <label for="drop_point_id">Pilih Titik Serah Terima Paket (Posyandu / Bidan Desa Mitra):</label>
                <select id="drop_point_id" name="drop_point_id" class="form-control" required>
                    <option value="">-- Pilih Posyandu Terdekat dari Domisili Anda --</option>
                    <?php foreach ($drop_points as $dp): ?>
                        <option value="<?= $dp['id'] ?>">
                            <?= htmlspecialchars($dp['name']) ?> (<?= htmlspecialchars($dp['district']) ?>) — <?= htmlspecialchars($dp['address_full']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: var(--text-muted);">Paket donasi akan dikirim donatur ke titik ini. Anda tidak perlu membagikan alamat rumah pribadi.</small>
            </div>

            <div class="form-group" style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px dashed var(--border-color);">
                <label for="kia_document"><strong>Unggah Lembar Pemeriksaan Buku KIA (Foto / Scan):</strong></label>
                <input type="file" id="kia_document" name="kia_document" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
                <small style="color: #475569; display: block; margin-top: 6px;">
                    📌 <strong>Penting:</strong> Lampirkan foto lembar Buku KIA yang menunjukkan data identitas kehamilan, HPL, dan catatan LILA. Berkas ini disimpan di folder privat terenkripsi dan <strong>hanya dapat dilihat oleh Admin NurturaGuard</strong> untuk validasi medis.
                </small>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px; font-size: 1.05rem; padding: 12px;">
                🚀 Kirim Pengajuan ke Admin NurturaGuard
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
