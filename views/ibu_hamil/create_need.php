<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>
<style>
/* Nurtura - form pengajuan ibu hamil (scope: halaman ini saja) */
.need-form-page{max-width:900px;margin:0 auto;color:#17223b}
.need-form-page .form-intro{display:flex;align-items:flex-start;gap:14px;margin:4px 0 20px}
.need-form-page .intro-icon{display:grid;place-items:center;flex:0 0 48px;height:48px;border-radius:15px;background:#e0f3ff;font-size:1.45rem}
.need-form-page h1{font-size:clamp(1.4rem,3vw,1.9rem);line-height:1.25;margin:8px 0 7px}
.need-form-page .muted{color:#64748b}
.need-form-page .form-shell{background:#fff;border:1px solid #dceaf4;border-radius:20px;padding:clamp(18px,3vw,30px);box-shadow:0 10px 28px #16456b0d}
.need-form-page .form-section{padding:19px 0;border-top:1px solid #e8f0f6}
.need-form-page .form-section:first-of-type{border-top:0;padding-top:8px}
.need-form-page .section-title{display:flex;align-items:center;gap:10px;margin-bottom:15px}
.need-form-page .section-number{display:grid;place-items:center;width:29px;height:29px;border-radius:50%;background:#e0f3ff;color:#0878b8;font-size:.8rem;font-weight:800}
.need-form-page .section-title h2{font-size:1rem;margin:0}
.need-form-page .form-group{margin-bottom:15px}
.need-form-page .form-group label{font-weight:700;color:#26364f;margin-bottom:7px}
.need-form-page .form-control{min-height:45px;border:1px solid #d5e2ed;border-radius:11px;background:#fbfdff;padding:11px 13px}
.need-form-page textarea.form-control{min-height:112px;resize:vertical}
.need-form-page .form-control:focus{border-color:#0792d2;box-shadow:0 0 0 3px #0792d21c}
.need-form-page .field-help{display:block;color:#64748b;font-size:.8rem;margin-top:6px;line-height:1.55}
.need-form-page .upload-box{border:1.5px dashed #9bcbe5;background:#f4faff;border-radius:15px;padding:18px}
.need-form-page input[type=file]{padding:10px;background:#fff}
.need-form-page .privacy-note{display:flex;gap:10px;padding:13px;border-radius:12px;background:#effaf5;color:#176548;font-size:.82rem;line-height:1.55;margin-top:12px}
.need-form-page .form-actions{display:flex;justify-content:space-between;gap:12px;align-items:center;flex-wrap:wrap;padding-top:18px;border-top:1px solid #e8f0f6}
.need-form-page .submit-btn{background:#c7f22b;color:#17223b!important;border-radius:999px;padding:13px 22px;box-shadow:0 7px 18px #c7f22b55}
.need-form-page .submit-btn:hover{background:#b9e91c;transform:translateY(-1px)}
.need-form-page .back-link{display:inline-flex;margin-bottom:16px;color:#0878b8;font-weight:700;text-decoration:none}
@media(max-width:520px){.need-form-page .form-actions{align-items:stretch}.need-form-page .form-actions .btn{width:100%}.need-form-page .intro-icon{flex-basis:42px;height:42px}}
</style>

<div class="need-form-page">
    <a href="index.php?page=ibu-hamil-dashboard" class="back-link">← Kembali ke Dashboard</a>

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

            <section class="form-section">
                <div class="section-title"><span class="section-number">01</span><h2>Informasi kebutuhan pangan</h2></div>
                <div class="form-group">
                    <label for="title">Judul singkat pengajuan</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Paket Telur & Susu Hamil Trimester 2" maxlength="150" required>
                    <small class="field-help">Buat judul yang singkat dan menggambarkan kebutuhan utama Anda.</small>
                </div>

                <div class="form-group">
                    <label for="food_items_needed">Rincian paket bahan pangan yang dibutuhkan</label>
                    <textarea id="food_items_needed" name="food_items_needed" class="form-control" rows="4" placeholder="Contoh:&#10;• Telur ayam 2 kg&#10;• Susu ibu hamil 2 kotak&#10;• Kacang hijau 1 kg" required></textarea>
                    <small class="field-help">Utamakan sumber protein hewani dan asam folat sesuai kebutuhan serta anjuran tenaga kesehatan.</small>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label for="description">Alasan atau kondisi kehamilan saat ini</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Ceritakan secara singkat kondisi nafsu makan, anjuran bidan/dokter, atau keterbatasan akses pangan yang dihadapi..." required></textarea>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title"><span class="section-number">02</span><h2>Data pemeriksaan dan lokasi serah terima</h2></div>
                <div class="form-group">
                    <label for="lila_measurement">Lingkar Lengan Atas (LILA) terakhir</label>
                    <div style="position:relative">
                        <input type="number" step="0.1" min="10" max="60" id="lila_measurement" name="lila_measurement" class="form-control" value="<?= htmlspecialchars($profile['lila_cm'] ?? '') ?>" placeholder="Contoh: 21.5" required>
                    </div>
                    <small class="field-help">Masukkan hasil pengukuran terakhir dalam sentimeter. Nilai di bawah 23,5 cm merupakan indikator risiko KEK yang perlu dikonsultasikan dengan tenaga kesehatan.</small>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label for="drop_point_id">Titik serah terima paket</label>
                    <select id="drop_point_id" name="drop_point_id" class="form-control" required>
                        <option value="">Pilih Posyandu atau Bidan Desa mitra</option>
                        <?php foreach ($drop_points as $dp): ?>
                            <option value="<?= $dp['id'] ?>">
                                <?= htmlspecialchars($dp['name']) ?> (<?= htmlspecialchars($dp['district']) ?>) — <?= htmlspecialchars($dp['address_full']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="field-help">Paket akan diserahkan donatur ke titik ini. Anda tidak perlu membagikan alamat rumah pribadi.</small>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title"><span class="section-number">03</span><h2>Unggah dokumen Buku KIA</h2></div>
                <div class="upload-box">
                    <div class="form-group" style="margin-bottom:0">
                        <label for="kia_document">Foto atau scan lembar pemeriksaan Buku KIA</label>
                        <input type="file" id="kia_document" name="kia_document" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
                        <small class="field-help">Format yang diterima: JPG, PNG, atau PDF. Pilih dokumen yang terbaca jelas dan memuat informasi pemeriksaan yang diperlukan.</small>
                    </div>
                    <div class="privacy-note"><span aria-hidden="true">🔒</span><span><strong>Privasi dokumen:</strong> Berkas Buku KIA digunakan untuk proses validasi oleh Admin NurturaGuard. Jangan unggah dokumen milik orang lain.</span></div>
                </div>
            </section>

            <div class="form-actions">
                <a href="index.php?page=ibu-hamil-dashboard" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary submit-btn">Kirim Pengajuan ke NurturaGuard →</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
