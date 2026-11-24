<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
            Panel Donatur (NurturaGive)
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            Pantau komitmen paket pangan bergizi Anda dan serahkan ke Posyandu mitra sebelum batas waktu 48 jam berakhir.
        </p>
    </div>
    <a href="index.php?page=explore" class="btn btn-secondary" style="font-weight: 700;">
        Jelajahi Kebutuhan Lain
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
            if ($_GET['msg'] === 'komitmen_berhasil') echo "Komitmen Anda berhasil dikunci. Anda memiliki waktu 48 jam untuk menyerahkan paket pangan ke Posyandu mitra.";
            elseif ($_GET['msg'] === 'bukti_terunggah') echo "Bukti serah terima berhasil diunggah. Notifikasi penjemputan paket telah dikirimkan ke pihak ibu hamil.";
        ?>
    </div>
<?php endif; ?>

<?php if (empty($commitments)): ?>
    <div class="card" style="text-align: center; padding: 56px 20px; border: 1px solid var(--border-color);">
        <div style="width: 56px; height: 56px; background: #e0f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </div>
        <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Belum Ada Komitmen Donasi Aktif</h3>
        <p style="color: var(--text-muted); max-width: 460px; margin: 0 auto 24px auto; font-size: 0.94rem; line-height: 1.5;">
            Pilih kebutuhan pangan bergizi ibu hamil berisiko KEK di sekitar Anda, dan salurkan langsung melalui sistem drop-point Posyandu.
        </p>
        <a href="index.php?page=explore" class="btn btn-primary" style="padding: 12px 28px;">
            Mulai Donasi Pertama
        </a>
    </div>
<?php else: ?>
    <?php foreach ($commitments as $c): ?>
        <div class="card" style="border: 1px solid var(--border-color); padding: 28px; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;"><?= htmlspecialchars($c['title']) ?></h3>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Komitmen dikunci pada: <strong><?= format_datetime_id($c['committed_at']) ?></strong>
                    </span>
                </div>
                <div>
                    <?php if ($c['status'] === 'committed'): ?>
                        <div class="countdown-pill">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span class="countdown-timer" data-expires="<?= date('c', strtotime($c['lock_expires_at'])) ?>">Menghitung sisa waktu...</span>
                        </div>
                    <?php elseif ($c['status'] === 'proof_uploaded'): ?>
                        <span class="badge badge-info" style="font-size: 0.78rem;">Bukti Terunggah (Menunggu Penjemputan)</span>
                    <?php elseif ($c['status'] === 'completed'): ?>
                        <span class="badge badge-success" style="font-size: 0.78rem;">Selesai Diterima Ibu Hamil</span>
                    <?php elseif ($c['status'] === 'cancelled_ghosting'): ?>
                        <span class="badge badge-danger" style="font-size: 0.78rem;">Batal (Melewati Batas 48 Jam)</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Progress Bar Countdown Waktu 48 Jam (Khusus Status Committed) -->
            <?php if ($c['status'] === 'committed'): ?>
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.03em;">
                        <span>Tenggat Waktu Drop-Point (48 Jam)</span>
                        <span>Batas Akhir: <?= date('d M Y, H:i', strtotime($c['lock_expires_at'])) ?> WIB</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: var(--radius-pill); overflow: hidden;">
                        <div class="countdown-progress-bar" style="height: 100%; width: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); transition: width 0.5s ease; border-radius: var(--radius-pill);"></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Rincian Bahan Pangan -->
            <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 16px 20px; border-radius: var(--radius-sm); margin-bottom: 18px;">
                <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">
                    Rincian Paket Bahan Pangan yang Perlu Disiapkan:
                </span>
                <p style="margin: 0; color: #1e293b; font-weight: 600; line-height: 1.6; font-size: 0.95rem;">
                    <?= nl2br(htmlspecialchars($c['food_items_needed'])) ?>
                </p>
            </div>

            <!-- Titik Antar Posyandu Mitra -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 18px 20px; border-radius: var(--radius-sm); margin-bottom: 20px; display: flex; gap: 14px; align-items: flex-start;">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #15803d; margin-top: 2px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <div style="font-size: 0.92rem; line-height: 1.5;">
                    <span style="font-size: 0.74rem; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 2px;">
                        Tujuan Pengantaran Paket (Posyandu Mitra Resmi)
                    </span>
                    <strong style="color: #0f172a; font-size: 1.05rem;"><?= htmlspecialchars($c['drop_point_name']) ?></strong>
                    <div style="color: #334155; margin-top: 2px;"><?= htmlspecialchars($c['drop_point_address']) ?></div>
                    <div style="color: #15803d; font-size: 0.84rem; font-weight: 700; margin-top: 4px;">
                        Petugas Penerima: <?= htmlspecialchars($c['officer_in_charge']) ?> • No. Kontak: <?= htmlspecialchars($c['drop_point_phone']) ?>
                    </div>
                </div>
            </div>

            <!-- Form Unggah Bukti Serah Terima (Khusus Status Committed) -->
            <?php if ($c['status'] === 'committed'): ?>
                <div style="background: #ffffff; border: 1px solid #bae6fd; padding: 22px; border-radius: var(--radius-sm); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.05);">
                    <h4 style="color: #0369a1; margin: 0 0 6px 0; font-size: 1.1rem; font-weight: 800;">
                        Unggah Bukti Serah Terima Paket
                    </h4>
                    <p style="font-size: 0.88rem; color: #0c4a6e; margin: 0 0 18px 0; line-height: 1.5;">
                        Setelah menitipkan paket langsung ke petugas Posyandu atau mengirimkannya melalui kurir terpercaya, unggah foto tanda terima, dokumentasi serah terima, atau resi pengiriman di bawah ini.
                    </p>
                    <form action="index.php?action=upload-proof" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                        <input type="hidden" name="donation_id" value="<?= $c['id'] ?>">

                        <div class="form-group" style="margin-bottom: 16px;">
                            <label for="proof_file_<?= $c['id'] ?>" style="font-weight: 700; color: #0f172a; font-size: 0.9rem; margin-bottom: 8px; display: block;">
                                Foto Bukti Serah Terima / Resi:
                            </label>

                            <div class="upload-dropzone" onclick="document.getElementById('proof_file_<?= $c['id'] ?>').click();">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.92rem;">
                                    Klik untuk memilih foto tanda terima
                                </div>
                                <div style="color: #64748b; font-size: 0.8rem; margin-top: 4px;">
                                    Mendukung format JPG, PNG, atau WEBP (Maksimal 5MB)
                                </div>
                            </div>

                            <input
                                type="file"
                                id="proof_file_<?= $c['id'] ?>"
                                name="proof_file"
                                style="display: none;"
                                accept="image/*"
                                required
                                onchange="previewSelectedImage(this, 'proof_preview_img_<?= $c['id'] ?>', 'proof_preview_wrap_<?= $c['id'] ?>')">

                            <!-- Live Image Preview -->
                            <div id="proof_preview_wrap_<?= $c['id'] ?>" class="upload-preview-container">
                                <span style="font-size: 0.75rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.03em; display: block; margin-bottom: 6px;">
                                    Pratinjau Foto Terpilih:
                                </span>
                                <img id="proof_preview_img_<?= $c['id'] ?>" src="" alt="Pratinjau foto bukti" class="upload-preview-img">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="donor_notes_<?= $c['id'] ?>" style="font-weight: 700; color: #0f172a; font-size: 0.9rem; margin-bottom: 6px; display: block;">
                                Catatan Tambahan (Opsional):
                            </label>
                            <input
                                type="text"
                                id="donor_notes_<?= $c['id'] ?>"
                                name="donor_notes"
                                class="form-control"
                                placeholder="Contoh: Paket dititipkan kepada Bidan Ani pukul 10:30 WIB"
                                style="background: #ffffff;">
                        </div>

                        <button type="submit" class="btn btn-primary" style="padding: 12px 26px;">
                            Kirim Bukti Serah Terima
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
