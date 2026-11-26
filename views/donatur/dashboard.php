<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

$commitmentsList = is_array($commitments ?? null) ? $commitments : [];
$activeCount = 0;
$completedCount = 0;
$faskesNames = [];
foreach ($commitmentsList as $row) {
    if (($row['status'] ?? '') === 'committed') $activeCount++;
    if (($row['status'] ?? '') === 'completed') $completedCount++;
    if (!empty($row['drop_point_name'])) {
        $faskesNames[$row['drop_point_name']] = true;
    }
}
$faskesCount = count($faskesNames);
?>

<div style="display: flex; flex-direction: column; gap: 1.75rem; padding-bottom: 2.5rem;">
    <!-- Page Header + CTA -->
    <section style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: block; margin-bottom: 0.375rem;">
                NurturaGive · Panel Donatur · Sistem Drop-Point Faskes
            </span>
            <h1 style="font-size: clamp(1.5rem, 4.5vw, 2.15rem); font-weight: 700; color: var(--text-main); margin: 0 0 0.25rem 0;">
                Komitmen &amp; Penyaluran Paket Pangan
            </h1>
            <p style="color: var(--text-muted); font-size: 0.94rem; margin: 0;">
                Pantau paket pangan bergizi yang telah Anda kunci dan serahkan ke Posyandu mitra sebelum batas waktu 48 jam berakhir.
            </p>
        </div>

        <a href="index.php?page=explore" class="btn-cerulean" style="padding: 0.6875rem 1.375rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            Jelajahi Kebutuhan Gizi Lain
        </a>
    </section>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 0;">
            <?php
                if ($_GET['msg'] === 'komitmen_berhasil') echo "Komitmen Anda berhasil dikunci! Anda memiliki waktu 48 jam untuk menyerahkan paket pangan ke Posyandu mitra.";
                elseif ($_GET['msg'] === 'bukti_terunggah') echo "Bukti serah terima berhasil diunggah. Notifikasi penjemputan paket telah dikirimkan ke pihak ibu hamil.";
            ?>
        </div>
    <?php endif; ?>

    <!-- 3 Summary Metrics -->
    <section aria-label="Ringkasan Kontribusi Donatur" class="grid-3col">
        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: var(--warning); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); line-height: 1.1;"><?= $activeCount ?> Paket</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Komitmen Aktif (48 Jam)</div>
            </div>
        </div>

        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: var(--botanical); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); line-height: 1.1;"><?= $completedCount ?> Paket</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Selesai Tersalurkan</div>
            </div>
        </div>

        <div class="card-clean" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-md); background: var(--surface-low); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </div>
            <div>
                <div class="font-mono" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); line-height: 1.1;"><?= $faskesCount ?> Faskes</div>
                <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-top: 0.125rem;">Posyandu Mitra Terjangkau</div>
            </div>
        </div>
    </section>

    <?php if (empty($commitmentsList)): ?>
        <div class="card-clean" style="text-align: center; padding: clamp(2rem, 6vw, 3.75rem) 1.5rem;">
            <div style="width: 3.5rem; height: 3.5rem; border-radius: 50%; background: var(--surface-low); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">
                Belum Ada Komitmen Donasi Aktif
            </h3>
            <p style="color: var(--text-muted); max-width: min(30rem, 100%); margin: 0 auto 1.5rem auto; font-size: 0.92rem; line-height: 1.6;">
                Pilih kebutuhan pangan bergizi ibu hamil berisiko KEK di sekitar Anda, lalu salurkan langsung dalam wujud bahan makanan riil melalui sistem drop-point Posyandu.
            </p>
            <a href="index.php?page=explore" class="btn-cerulean" style="padding: 0.75rem 1.625rem;">
                Mulai Donasi Pertama Anda →
            </a>
        </div>
    <?php else: ?>
        <section style="display: flex; flex-direction: column; gap: 1.375rem;">
            <?php foreach ($commitmentsList as $c): ?>
                <?php $isCommitted = ($c['status'] === 'committed'); ?>
                <article class="card-clean" style="padding: clamp(1.125rem, 3vw, 1.75rem); display: flex; flex-direction: column; gap: 1.125rem; <?= $isCommitted ? 'border-color: rgba(144, 77, 0, 0.45);' : '' ?>">
                    <header style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.875rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.25rem;">
                                <span class="font-mono" style="font-size: 0.78rem; font-weight: 700; color: var(--primary);">
                                    #DON-<?= str_pad($c['id'], 4, '0', STR_PAD_LEFT) ?>
                                </span>
                                <span style="font-size: 0.82rem; color: var(--text-muted);">
                                    · Dikunci pada <?= format_datetime_id($c['committed_at']) ?>
                                </span>
                            </div>
                            <h2 style="font-family: var(--font-sans); font-size: 1.22rem; font-weight: 700; color: var(--text-main); margin: 0;">
                                <?= htmlspecialchars($c['title']) ?>
                            </h2>
                        </div>

                        <div>
                            <?php if ($isCommitted): ?>
                                <div class="countdown-pill">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span class="countdown-timer" data-expires="<?= date('c', strtotime($c['lock_expires_at'])) ?>">Menghitung sisa waktu...</span>
                                </div>
                            <?php elseif ($c['status'] === 'proof_uploaded'): ?>
                                <span class="badge badge-info">Bukti Terunggah (Menunggu Penjemputan)</span>
                            <?php elseif ($c['status'] === 'completed'): ?>
                                <span class="badge badge-success">Selesai Diterima Ibu Hamil</span>
                            <?php elseif ($c['status'] === 'cancelled_ghosting'): ?>
                                <span class="badge badge-danger">Batal (Melewati Batas 48 Jam)</span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <!-- Countdown Progress Bar -->
                    <?php if ($isCommitted): ?>
                        <div class="inset-well" style="padding: 0.875rem 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: var(--warning);">
                                    Tenggat Waktu Drop-Point (Maksimal 48 Jam)
                                </span>
                                <span class="font-mono" style="font-size: 0.78rem; color: var(--text-main);">
                                    Batas Akhir: <strong><?= date('d M Y, H:i', strtotime($c['lock_expires_at'])) ?> WIB</strong>
                                </span>
                            </div>
                            <div style="width: 100%; height: 0.5rem; background: var(--surface-high); border-radius: var(--radius-pill); overflow: hidden;">
                                <div class="countdown-progress-bar" style="height: 100%; width: 100%; background: var(--warning); transition: width 0.5s ease; border-radius: var(--radius-pill);"></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 2-Col Food Package + Posyandu Drop-Point Wells -->
                    <div class="grid-2col">
                        <div class="inset-well" style="padding: 1rem;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); display: block; margin-bottom: 0.25rem;">
                                Rincian Paket Bahan Pangan yang Perlu Disiapkan
                            </span>
                            <p style="margin: 0; color: var(--text-main); font-weight: 500; line-height: 1.55; font-size: 0.9rem;">
                                <?= nl2br(htmlspecialchars($c['food_items_needed'])) ?>
                            </p>
                        </div>

                        <div class="inset-well" style="padding: 1rem;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--botanical); display: block; margin-bottom: 0.25rem;">
                                Tujuan Pengantaran (Posyandu Mitra Resmi)
                            </span>
                            <div style="color: var(--text-main); font-size: 0.98rem; font-weight: 700;"><?= htmlspecialchars($c['drop_point_name']) ?></div>
                            <div style="color: var(--text-muted); margin-top: 0.125rem; font-size: 0.84rem;"><?= htmlspecialchars($c['drop_point_address']) ?></div>
                            <div style="color: var(--text-main); font-size: 0.82rem; font-weight: 600; margin-top: 0.25rem;">
                                PJ: <?= htmlspecialchars($c['officer_in_charge']) ?> · <span class="font-mono"><?= htmlspecialchars($c['drop_point_phone']) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Unggah Bukti Serah Terima -->
                    <?php if ($isCommitted): ?>
                        <div style="padding-top: 1rem; border-top: 0.0625rem solid var(--border-subtle);">
                            <h3 style="color: var(--text-main); margin: 0 0 0.25rem 0; font-size: 1.05rem; font-weight: 700;">
                                Unggah Bukti Serah Terima Paket
                            </h3>
                            <p style="font-size: 0.86rem; color: var(--text-muted); margin: 0 0 0.875rem 0; line-height: 1.55;">
                                Setelah menitipkan paket langsung ke petugas Posyandu mitra di atas, unggah foto tanda terima, dokumentasi serah terima, atau resi pengiriman.
                            </p>

                            <form action="index.php?action=upload-proof" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                                <input type="hidden" name="donation_id" value="<?= $c['id'] ?>">

                                <div class="form-group" style="margin-bottom: 0.875rem;">
                                    <label for="proof_file_<?= $c['id'] ?>">Foto Bukti Serah Terima / Dokumentasi</label>
                                    <div class="upload-dropzone" onclick="document.getElementById('proof_file_<?= $c['id'] ?>').click();">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#376386" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.375rem;" aria-hidden="true">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;">
                                            Klik untuk memilih foto tanda terima
                                        </div>
                                        <div style="color: var(--text-muted); font-size: 0.78rem; margin-top: 0.25rem;">
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

                                    <div id="proof_preview_wrap_<?= $c['id'] ?>" class="upload-preview-container">
                                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; display: block; margin-bottom: 0.375rem;">
                                            Pratinjau Foto Terpilih
                                        </span>
                                        <img id="proof_preview_img_<?= $c['id'] ?>" src="" alt="Pratinjau foto bukti" class="upload-preview-img">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label for="donor_notes_<?= $c['id'] ?>">Catatan Tambahan (Opsional)</label>
                                    <input
                                        type="text"
                                        id="donor_notes_<?= $c['id'] ?>"
                                        name="donor_notes"
                                        class="form-control"
                                        placeholder="Contoh: Paket dititipkan kepada Bidan Ani pukul 10:30 WIB">
                                </div>

                                <button type="submit" class="btn-cerulean" style="padding: 0.6875rem 1.5rem;">
                                    Kirim Bukti Serah Terima Paket →
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
