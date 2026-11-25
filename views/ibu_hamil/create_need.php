<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>
<style>
/* Nurtura - form pengajuan ibu hamil (scope: halaman ini saja) */
.need-form-page{max-width:920px;margin:0 auto;color:#17223b}
.need-form-page .form-intro{display:flex;align-items:flex-start;gap:14px;margin:4px 0 20px}
.need-form-page .intro-icon{display:grid;place-items:center;flex:0 0 48px;height:48px;border-radius:15px;background:#e0f3ff;font-size:1.45rem}
.need-form-page h1{font-size:clamp(1.4rem,3vw,1.9rem);line-height:1.25;margin:8px 0 7px;font-weight:800}
.need-form-page .muted{color:#64748b}
.need-form-page .form-shell{background:#fff;border:1px solid #dceaf4;border-radius:24px;padding:clamp(20px,3vw,34px);box-shadow:0 12px 32px #16456b0d}
.need-form-page .form-section{padding:22px 0;border-top:1px solid #e8f0f6}
.need-form-page .form-section:first-of-type{border-top:0;padding-top:8px}
.need-form-page .section-title{display:flex;align-items:center;gap:10px;margin-bottom:16px}
.need-form-page .section-number{display:grid;place-items:center;width:30px;height:30px;border-radius:50%;background:#e0f3ff;color:#0878b8;font-size:.82rem;font-weight:800}
.need-form-page .section-title h2{font-size:1.05rem;font-weight:800;margin:0;color:#0f172a}
.need-form-page .form-group{margin-bottom:18px}
.need-form-page .form-group label{font-weight:700;color:#1e293b;margin-bottom:7px;display:block;font-size:0.9rem}
.need-form-page .form-control{min-height:46px;border:1px solid #d5e2ed;border-radius:12px;background:#fbfdff;padding:11px 14px;font-size:0.92rem;width:100%}
.need-form-page textarea.form-control{min-height:116px;resize:vertical}
.need-form-page .form-control:focus{border-color:#0284c7;box-shadow:0 0 0 3px rgba(2, 132, 199, 0.15);outline:none}
.need-form-page .field-help{display:block;color:#64748b;font-size:.78rem;margin-top:6px;line-height:1.5}
.need-form-page .upload-box{border:2px dashed #9bcbe5;background:#f4faff;border-radius:16px;padding:20px}
.need-form-page input[type=file]{padding:10px;background:#fff}
.need-form-page .privacy-note{display:flex;gap:10px;padding:14px;border-radius:12px;background:#effaf5;color:#176548;font-size:.82rem;line-height:1.55;margin-top:14px}
.need-form-page .form-actions{display:flex;justify-content:space-between;gap:14px;align-items:center;flex-wrap:wrap;padding-top:22px;border-top:1px solid #e8f0f6}
.need-form-page .back-link{display:inline-flex;align-items:center;gap:6px;margin-bottom:16px;color:#0284c7;font-weight:700;text-decoration:none;font-size:0.9rem}
.need-form-page .back-link:hover{text-decoration:underline}
@media(max-width:520px){.need-form-page .form-actions{align-items:stretch}.need-form-page .form-actions .btn{width:100%}.need-form-page .intro-icon{flex-basis:42px;height:42px}}
</style>

<div class="need-form-page">
    <a href="index.php?page=ibu-hamil-dashboard" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Dashboard Ibu Hamil
    </a>

    <div class="form-intro">
        <div class="intro-icon" aria-hidden="true">🥗</div>
        <div>
            <span class="badge badge-info">NurturaNeeds · Pengajuan Ibu Hamil</span>
            <h1>Ajukan Kebutuhan Pangan Bergizi</h1>
            <p class="muted">Lengkapi informasi berikut agar tim NurturaGuard dapat meninjau kebutuhan Anda berdasarkan data Buku KIA.</p>
        </div>
    </div>

    <div class="form-shell">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="index.php?page=create-need" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

            <!-- BAGIAN 1: INFORMASI KEBUTUHAN PANGAN & LIVE RADAR -->
            <section class="form-section">
                <div class="section-title">
                    <span class="section-number">01</span>
                    <h2>Informasi Kebutuhan Pangan & Gizi</h2>
                </div>

                <div class="form-group">
                    <label for="title">Judul Singkat Pengajuan</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Paket Telur & Susu Hamil Trimester 2" maxlength="150" required>
                    <small class="field-help">Buat judul yang singkat dan menggambarkan kebutuhan utama Anda.</small>
                </div>

                <div class="form-group">
                    <label for="food_items_needed">Rincian Paket Bahan Pangan yang Dibutuhkan</label>
                    <textarea id="food_items_needed" name="food_items_needed" class="form-control" rows="4" placeholder="Contoh:&#10;• Telur ayam 2 kg&#10;• Susu ibu hamil 2 kotak&#10;• Hati ayam / Daging sapi 500g&#10;• Sayur bayam & kacang hijau" required></textarea>
                    <small class="field-help">Ketik bahan makanan di atas. Diagram radar 5 sumbu di bawah akan memetakan keseimbangan nutrisinya secara langsung.</small>
                </div>

                <!-- Live Mini 5-Axis Nutritional Radar Preview -->
                <div class="card-3d-tactile" style="padding: 20px; background: #f8fafc; margin-top: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0284c7;">
                                Indeks Nutrisi Terpadu
                            </span>
                            <h3 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                                Pratinjau Keseimbangan 5 Sumbu Gizi (AKG Bumil)
                            </h3>
                        </div>
                        <span class="badge badge-info" style="font-size: 0.7rem;">Live Dynamic Radar</span>
                    </div>
                    <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 10px;">
                        Diagram ini memetakan perkiraan pemenuhan Protein Hewani, Kalsium, Kalori, Asam Folat, dan Zat Besi berdasarkan rincian pangan di atas.
                    </p>
                    <div id="live-nutrition-radar" style="display: flex; justify-content: center; align-items: center;"></div>
                </div>

                <div class="form-group" style="margin-top: 18px; margin-bottom: 0;">
                    <label for="description">Alasan atau Kondisi Kehamilan Saat Ini</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Ceritakan secara singkat kondisi nafsu makan, anjuran bidan/dokter, atau keterbatasan akses pangan yang dihadapi..." required></textarea>
                </div>
            </section>

            <!-- BAGIAN 2: DATA PEMERIKSAAN & POSYANDU -->
            <section class="form-section">
                <div class="section-title">
                    <span class="section-number">02</span>
                    <h2>Data Pemeriksaan & Lokasi Serah Terima</h2>
                </div>

                <div class="form-group">
                    <label for="lila_measurement">Lingkar Lengan Atas (LILA) Terakhir (cm)</label>
                    <input type="number" step="0.1" min="10" max="60" id="lila_measurement" name="lila_measurement" class="form-control" value="<?= htmlspecialchars($profile['lila_cm'] ?? '') ?>" placeholder="Contoh: 21.5" required>
                    <small class="field-help">Masukkan hasil pengukuran terakhir dalam sentimeter. Standar Kemenkes RI: Nilai di bawah 23,5 cm merupakan indikator risiko Kurang Energi Kronis (KEK).</small>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label for="drop_point_id">Titik Posyandu Mitra Serah Terima Paket</label>
                    <select id="drop_point_id" name="drop_point_id" class="form-control" required>
                        <option value="">Pilih Posyandu atau Bidan Desa mitra...</option>
                        <?php foreach ($drop_points as $dp): ?>
                            <option value="<?= $dp['id'] ?>">
                                <?= htmlspecialchars($dp['name']) ?> (<?= htmlspecialchars($dp['district']) ?>) — <?= htmlspecialchars($dp['address_full']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="field-help">Paket pangan akan diserahkan donatur ke titik Posyandu ini. Anda tidak perlu membagikan alamat rumah pribadi.</small>
                </div>
            </section>

            <!-- BAGIAN 3: UNGGAH BUKU KIA DENGAN LIVE PREVIEW -->
            <section class="form-section">
                <div class="section-title">
                    <span class="section-number">03</span>
                    <h2>Unggah Dokumen Lembar Buku KIA</h2>
                </div>

                <div class="upload-box">
                    <div class="form-group" style="margin-bottom:0">
                        <label for="kia_document">Foto atau Scan Lembar Pemeriksaan Buku KIA</label>
                        <input type="file" id="kia_document" name="kia_document" class="form-control" accept="image/jpeg,image/png,application/pdf" onchange="previewKiaImage(this)" required>
                        <small class="field-help">Format yang diterima: JPG, PNG, atau PDF. Pastikan foto memuat catatan tanggal pemeriksaan dan ukuran LILA secara jelas.</small>
                    </div>

                    <!-- Live Image Preview Container -->
                    <div id="kia-preview-container" style="display: none; margin-top: 16px; text-align: center; background: #ffffff; padding: 16px; border-radius: 14px; border: 1px solid #cbd5e1;">
                        <span style="font-size: 0.78rem; font-weight: 700; color: #0284c7; display: block; margin-bottom: 8px;">
                            ✓ Pratinjau Dokumen Lembar Buku KIA Terpilih:
                        </span>
                        <img id="kia-preview-img" src="" alt="Pratinjau Lembar KIA" style="max-height: 240px; max-width: 100%; border-radius: 10px; box-shadow: 0 4px 14px rgba(0,0,0,0.08);">
                    </div>

                    <div class="privacy-note">
                        <span aria-hidden="true">🔒</span>
                        <span><strong>Privasi Medis Terjamin:</strong> Berkas Buku KIA hanya digunakan untuk proses verifikasi oleh Admin NurturaGuard dan tidak pernah dipublikasikan secara umum.</span>
                    </div>
                </div>
            </section>

            <!-- FORM ACTIONS DENGAN LIME GREEN CTA BUTTON -->
            <div class="form-actions">
                <a href="index.php?page=ibu-hamil-dashboard" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-lime" style="padding: 14px 30px; font-size: 0.96rem;">
                    Kirim Pengajuan ke NurturaGuard →
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Live Image Preview for Buku KIA
    function previewKiaImage(input) {
        const file = input.files && input.files[0];
        const container = document.getElementById('kia-preview-container');
        const img = document.getElementById('kia-preview-img');
        if (!container || !img) return;

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    }

    // Bind Live 5-Axis Nutritional Radar Preview
    document.addEventListener('DOMContentLoaded', function () {
        if (window.MedicalCharts && typeof window.MedicalCharts.bindLiveNutritionalPreview === 'function') {
            window.MedicalCharts.bindLiveNutritionalPreview('food_items_needed', 'live-nutrition-radar');
        }
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
