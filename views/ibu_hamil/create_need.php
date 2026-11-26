<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>
<style>
/* Nurtura Clinical Care - Scoped Form Pengajuan Ibu Hamil (100% rem / vw / %) */
.need-form-page { max-width: min(57.5rem, 100%); margin: 0 auto; color: var(--text-main); }
.need-form-page .form-intro { display: flex; align-items: flex-start; gap: 0.875rem; margin: 0.375rem 0 1.375rem 0; }
.need-form-page .intro-icon {
    display: grid; place-items: center; flex: 0 0 2.875rem; height: 2.875rem;
    border-radius: var(--radius-md); background: var(--surface-low); border: 0.0625rem solid var(--border-color); color: var(--primary);
}
.need-form-page h1 { font-size: clamp(1.45rem, 4.5vw, 2rem); line-height: 1.25; margin: 0.25rem 0 0.375rem 0; font-weight: 700; }
.need-form-page .muted { color: var(--text-muted); font-size: 0.92rem; margin: 0; }
.need-form-page .form-shell {
    background: var(--surface-lowest); border: 0.0625rem solid var(--border-color);
    border-radius: var(--radius); padding: clamp(1.125rem, 3vw, 2.125rem);
}
.need-form-page .form-section { padding: 1.375rem 0; border-top: 0.0625rem solid var(--border-subtle); }
.need-form-page .form-section:first-of-type { border-top: 0; padding-top: 0.25rem; }
.need-form-page .section-title { display: flex; align-items: center; gap: 0.625rem; margin-bottom: 1rem; }
.need-form-page .section-number {
    display: grid; place-items: center; width: 1.875rem; height: 1.875rem; border-radius: 50%; flex-shrink: 0;
    background: var(--surface-low); color: var(--primary); font-family: var(--font-mono); font-size: 0.8rem; font-weight: 700;
}
.need-form-page .section-title h2 { font-family: var(--font-sans); font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--text-main); }
.need-form-page textarea.form-control { min-height: 6.875rem; resize: vertical; }
.need-form-page .field-help { display: block; color: var(--text-muted); font-size: 0.78rem; margin-top: 0.375rem; line-height: 1.5; }
.need-form-page .upload-box { border: 0.09375rem dashed var(--outline-variant); background: var(--surface-low); border-radius: var(--radius-md); padding: 1.25rem; }
.need-form-page .privacy-note {
    display: flex; gap: 0.625rem; padding: 0.875rem; border-radius: var(--radius-sm);
    background: var(--surface-lowest); border-left: 0.1875rem solid var(--botanical); color: var(--text-main); font-size: 0.84rem; line-height: 1.55; margin-top: 0.875rem;
}
.need-form-page .form-actions {
    display: flex; justify-content: space-between; gap: 0.875rem; align-items: center;
    flex-wrap: wrap; padding-top: 1.375rem; border-top: 0.0625rem solid var(--border-subtle);
}
.need-form-page .back-link {
    display: inline-flex; align-items: center; gap: 0.375rem; min-height: var(--touch-target); margin-bottom: 0.75rem; color: var(--primary); font-weight: 600; font-size: 0.9rem;
}
@media (max-width: 32.5rem) {
    .need-form-page .form-actions { align-items: stretch; }
    .need-form-page .form-actions a, .need-form-page .form-actions button { width: 100%; }
}
</style>

<div class="need-form-page">
    <a href="index.php?page=ibu-hamil-dashboard" class="back-link">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Dashboard Ibu Hamil
    </a>

    <div class="form-intro">
        <div class="intro-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="12" y1="18" x2="12" y2="12"/>
                <line x1="9" y1="15" x2="15" y2="15"/>
            </svg>
        </div>
        <div>
            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary);">
                NurturaNeeds · Pengajuan Ibu Hamil
            </span>
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
                    <h2>Informasi Kebutuhan Pangan &amp; Gizi</h2>
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
                <div class="inset-well" style="padding: 1.125rem; margin-top: 0.875rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.375rem; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--primary);">
                                Indeks Nutrisi Terpadu
                            </span>
                            <h3 style="font-size: 0.96rem; font-weight: 700; color: var(--text-main); margin: 0;">
                                Pratinjau Keseimbangan 5 Sumbu Gizi (AKG Bumil)
                            </h3>
                        </div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary);">Live Dynamic Radar</span>
                    </div>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.625rem;">
                        Diagram ini memetakan perkiraan pemenuhan Protein Hewani, Kalsium, Kalori, Asam Folat, dan Zat Besi berdasarkan rincian pangan di atas.
                    </p>
                    <div id="live-nutrition-radar" style="display: flex; justify-content: center; align-items: center;"></div>
                </div>

                <div class="form-group" style="margin-top: 1.125rem; margin-bottom: 0;">
                    <label for="description">Alasan atau Kondisi Kehamilan Saat Ini</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Ceritakan secara singkat kondisi nafsu makan, anjuran bidan/dokter, atau keterbatasan akses pangan yang dihadapi..." required></textarea>
                </div>
            </section>

            <!-- BAGIAN 2: DATA PEMERIKSAAN & POSYANDU -->
            <section class="form-section">
                <div class="section-title">
                    <span class="section-number">02</span>
                    <h2>Data Pemeriksaan &amp; Lokasi Serah Terima</h2>
                </div>

                <div class="form-group">
                    <label for="lila_measurement">Lingkar Lengan Atas (LILA) Terakhir (cm)</label>
                    <input type="number" step="0.1" min="10" max="60" id="lila_measurement" name="lila_measurement" class="form-control" value="<?= htmlspecialchars($profile['lila_cm'] ?? '') ?>" placeholder="Contoh: 21.5" required oninput="updateLiveLilaIndicator(this.value)">
                    <div id="lila-live-indicator" style="margin-top: 0.5rem; font-size: 0.84rem; font-weight: 600; display: none; padding: 0.625rem 0.875rem; border-radius: var(--radius-sm); background: var(--surface-low);"></div>
                    <small class="field-help">Masukkan hasil pengukuran terakhir dalam sentimeter. Standar Kemenkes RI: Nilai di bawah 23,5 cm merupakan indikator risiko Kurang Energi Kronis (KEK).</small>
                </div>
                <script>
                function updateLiveLilaIndicator(val) {
                    const el = document.getElementById('lila-live-indicator');
                    if (!el) return;
                    const num = parseFloat(val);
                    if (isNaN(num) || num <= 0) {
                        el.style.display = 'none';
                        return;
                    }
                    el.style.display = 'block';
                    if (num < 23.5) {
                        el.style.borderLeft = '0.1875rem solid #A83836';
                        el.style.color = '#A83836';
                        el.textContent = 'Indikasi Risiko KEK (LILA ' + num.toFixed(1) + ' cm < 23,5 cm) — Memenuhi prioritas intervensi pangan bergizi.';
                    } else {
                        el.style.borderLeft = '0.1875rem solid #006D30';
                        el.style.color = '#006D30';
                        el.textContent = 'Status LILA Normal (' + num.toFixed(1) + ' cm ≥ 23,5 cm) — Tetap jaga asupan protein hewani dan Tablet Tambah Darah.';
                    }
                }
                document.addEventListener('DOMContentLoaded', function () {
                    const input = document.getElementById('lila_measurement');
                    if (input && input.value) updateLiveLilaIndicator(input.value);
                });
                </script>

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

                    <div id="kia-preview-container" style="display: none; margin-top: 1rem; text-align: center; background: var(--surface-lowest); padding: 1rem; border-radius: var(--radius-md); border: 0.0625rem solid var(--border-color);">
                        <span style="font-size: 0.78rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.5rem;">
                            ✓ Pratinjau Dokumen Lembar Buku KIA Terpilih:
                        </span>
                        <img id="kia-preview-img" src="" alt="Pratinjau Lembar KIA" style="max-height: 15rem; max-width: 100%; border-radius: var(--radius-sm); margin: 0 auto;">
                        <div id="kia-preview-pdf" style="display: none; padding: 0.75rem; background: var(--surface-low); border-radius: var(--radius-sm); color: var(--primary); font-size: 0.88rem;"></div>
                    </div>

                    <div class="privacy-note">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#006D30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 0.125rem;" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span><strong>Privasi Medis Terjamin:</strong> Berkas Buku KIA hanya digunakan untuk proses verifikasi oleh Admin NurturaGuard dan tidak pernah dipublikasikan secara umum.</span>
                    </div>
                </div>
            </section>

            <!-- FORM ACTIONS -->
            <div class="form-actions">
                <a href="index.php?page=ibu-hamil-dashboard" class="btn-ghost-clean">
                    Batal
                </a>
                <button type="submit" class="btn-cerulean" style="padding: 0.75rem 1.625rem;">
                    Kirim Pengajuan ke NurturaGuard →
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewKiaImage(input) {
        const file = input.files && input.files[0];
        const container = document.getElementById('kia-preview-container');
        const img = document.getElementById('kia-preview-img');
        const pdfNotice = document.getElementById('kia-preview-pdf');
        if (!container || !img) return;

        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                    if (pdfNotice) pdfNotice.style.display = 'none';
                    container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                img.style.display = 'none';
                if (pdfNotice) {
                    pdfNotice.style.display = 'block';
                    pdfNotice.innerHTML = '<strong>Dokumen PDF Terpilih:</strong> ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                }
                container.style.display = 'block';
            }
        } else {
            container.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (window.MedicalCharts && typeof window.MedicalCharts.bindLiveNutritionalPreview === 'function') {
            window.MedicalCharts.bindLiveNutritionalPreview('food_items_needed', 'live-nutrition-radar');
        }
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
