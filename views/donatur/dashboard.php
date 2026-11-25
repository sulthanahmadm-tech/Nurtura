<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="max-width: 1080px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Header Panel Donatur -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span class="badge badge-info">NurturaGive · Panel Donatur</span>
                <span class="badge badge-secondary">Sistem Drop-Point Faskes</span>
            </div>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
                Komitmen & Penyaluran Paket Pangan
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
                Pantau paket pangan bergizi yang telah Anda kunci dan serahkan ke Posyandu mitra sebelum batas waktu 48 jam berakhir.
            </p>
        </div>
        <a href="index.php?page=explore" class="btn-lime">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            Jelajahi Kebutuhan Gizi Lain
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin-bottom: 24px;">
            <?php
                if ($_GET['msg'] === 'komitmen_berhasil') echo "Komitmen Anda berhasil dikunci! Anda memiliki waktu 48 jam untuk menyerahkan paket pangan ke Posyandu mitra.";
                elseif ($_GET['msg'] === 'bukti_terunggah') echo "Bukti serah terima berhasil diunggah. Notifikasi penjemputan paket telah dikirimkan ke pihak ibu hamil.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (empty($commitments)): ?>
        <div class="card-modern" style="text-align: center; padding: 64px 24px; border: 1px solid rgba(226, 232, 240, 0.9);">
            <div style="width: 64px; height: 64px; background: #e0f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px; color: #0284c7;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
                Belum Ada Komitmen Donasi Aktif
            </h3>
            <p style="color: var(--text-muted); max-width: 480px; margin: 0 auto 26px auto; font-size: 0.94rem; line-height: 1.6;">
                Pilih kebutuhan pangan bergizi ibu hamil berisiko KEK di sekitar Anda, lalu salurkan langsung dalam wujud bahan makanan riil melalui sistem drop-point Posyandu.
            </p>
            <a href="index.php?page=explore" class="btn-lime" style="padding: 14px 32px; font-size: 0.98rem;">
                Mulai Donasi Pertama Anda →
            </a>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <?php foreach ($commitments as $c): ?>
                <div class="card-modern" style="border: 1px solid rgba(226, 232, 240, 0.9); padding: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 18px; flex-wrap: wrap; gap: 14px;">
                        <div>
                            <span style="font-size: 0.72rem; font-weight: 800; color: #0284c7; text-transform: uppercase;">
                                ID: #DON-<?= str_pad($c['id'], 4, '0', STR_PAD_LEFT) ?>
                            </span>
                            <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 2px 0 6px 0;">
                                <?= htmlspecialchars($c['title']) ?>
                            </h3>
                            <span style="font-size: 0.84rem; color: var(--text-muted);">
                                Komitmen dikunci pada: <strong><?= format_datetime_id($c['committed_at']) ?></strong>
                            </span>
                        </div>
                        <div>
                            <?php if ($c['status'] === 'committed'): ?>
                                <div class="countdown-pill" style="box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span class="countdown-timer" data-expires="<?= date('c', strtotime($c['lock_expires_at'])) ?>">Menghitung sisa waktu...</span>
                                </div>
                            <?php elseif ($c['status'] === 'proof_uploaded'): ?>
                                <span class="badge badge-info" style="font-size: 0.82rem; padding: 6px 14px;">Bukti Terunggah (Menunggu Penjemputan)</span>
                            <?php elseif ($c['status'] === 'completed'): ?>
                                <span class="badge badge-success" style="font-size: 0.82rem; padding: 6px 14px;">Selesai Diterima Ibu Hamil</span>
                            <?php elseif ($c['status'] === 'cancelled_ghosting'): ?>
                                <span class="badge badge-danger" style="font-size: 0.82rem; padding: 6px 14px;">Batal (Melewati Batas 48 Jam)</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Dark Hero Countdown Card (Khusus Status Committed) -->
                    <?php if ($c['status'] === 'committed'): ?>
                        <div class="card-dark-3d" style="padding: 20px 24px; margin-bottom: 22px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 1.1rem;">⏳</span>
                                    <span style="font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #c7f22b;">
                                        Tenggat Waktu Drop-Point (Maksimal 48 Jam)
                                    </span>
                                </div>
                                <span style="font-size: 0.82rem; color: #cbd5e1;">
                                    Batas Akhir: <strong style="color: #ffffff;"><?= date('d M Y, H:i', strtotime($c['lock_expires_at'])) ?> WIB</strong>
                                </span>
                            </div>
                            <div style="width: 100%; height: 9px; background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-pill); overflow: hidden; margin-top: 8px;">
                                <div class="countdown-progress-bar" style="height: 100%; width: 100%; background: linear-gradient(90deg, #c7f22b, #38bdf8); transition: width 0.5s ease; border-radius: var(--radius-pill);"></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Rincian Bahan Pangan yang Perlu Disiapkan -->
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 18px 22px; border-radius: 16px; margin-bottom: 20px;">
                        <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">
                            Rincian Paket Bahan Pangan yang Perlu Disiapkan:
                        </span>
                        <p style="margin: 0; color: #0c4a6e; font-weight: 600; line-height: 1.6; font-size: 0.96rem;">
                            <?= nl2br(htmlspecialchars($c['food_items_needed'])) ?>
                        </p>
                    </div>

                    <!-- Titik Antar Posyandu Mitra -->
                    <div class="card-3d-tactile" style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px 22px; margin-bottom: 22px; display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #15803d; margin-top: 2px;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div style="font-size: 0.94rem; line-height: 1.55;">
                            <span style="font-size: 0.72rem; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 2px;">
                                Tujuan Pengantaran Paket (Posyandu Mitra Resmi)
                            </span>
                            <div style="color: #0f172a; font-size: 1.15rem; font-weight: 800;"><?= htmlspecialchars($c['drop_point_name']) ?></div>
                            <div style="color: #334155; margin-top: 2px; font-size: 0.9rem;"><?= htmlspecialchars($c['drop_point_address']) ?></div>
                            <div style="color: #15803d; font-size: 0.85rem; font-weight: 700; margin-top: 4px;">
                                Petugas Penanggung Jawab: <?= htmlspecialchars($c['officer_in_charge']) ?> • No. Kontak: <?= htmlspecialchars($c['drop_point_phone']) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Form Unggah Bukti Serah Terima (Khusus Status Committed) -->
                    <?php if ($c['status'] === 'committed'): ?>
                        <div class="card-3d-tactile" style="background: #ffffff; border: 1px solid #bae6fd; padding: 24px; box-shadow: 0 4px 16px rgba(2, 132, 199, 0.06);">
                            <h4 style="color: #0369a1; margin: 0 0 6px 0; font-size: 1.15rem; font-weight: 800;">
                                Unggah Bukti Serah Terima Paket
                            </h4>
                            <p style="font-size: 0.88rem; color: #0c4a6e; margin: 0 0 18px 0; line-height: 1.55;">
                                Setelah menitipkan paket langsung ke petugas Posyandu mitra di atas, unggah foto tanda terima, dokumentasi serah terima, atau resi pengiriman untuk diverifikasi.
                            </p>
                            <form action="index.php?action=upload-proof" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                <input type="hidden" name="donation_id" value="<?= $c['id'] ?>">

                                <div class="form-group" style="margin-bottom: 16px;">
                                    <label for="proof_file_<?= $c['id'] ?>" style="font-weight: 700; color: #0f172a; font-size: 0.9rem; margin-bottom: 8px; display: block;">
                                        Foto Bukti Serah Terima / Dokumentasi:
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

                                <button type="submit" class="btn-lime" style="padding: 13px 28px;">
                                    Kirim Bukti Serah Terima Paket →
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
