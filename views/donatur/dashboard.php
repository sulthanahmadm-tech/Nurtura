<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="margin-bottom: 24px;">
    <h2>Dashboard Donatur (NurturaGive)</h2>
    <p style="color: var(--text-muted);">
        Terima kasih atas partisipasi Anda dalam mendukung gizi ibu hamil untuk mencegah stunting sejak masa kandungan.
    </p>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
            if ($_GET['msg'] === 'komitmen_berhasil') echo "Komitmen Anda berhasil dikunci! Anda memiliki waktu 48 jam untuk menyerahkan paket pangan ke Posyandu mitra.";
            elseif ($_GET['msg'] === 'bukti_terunggah') echo "Bukti serah terima berhasil diunggah! Pihak ibu hamil dan Posyandu telah menerima notifikasi pengambilan.";
        ?>
    </div>
<?php endif; ?>

<?php if (empty($commitments)): ?>
    <div class="card" style="text-align: center; padding: 48px 20px;">
        <h3>Anda belum memiliki komitmen donasi aktif.</h3>
        <p style="color: var(--text-muted); margin: 12px 0 20px 0;">Bantu penuhi kebutuhan gizi ibu hamil berisiko KEK di sekitar Anda sekarang.</p>
        <a href="index.php?page=explore" class="btn btn-primary">Jelajahi Katalog Kebutuhan</a>
    </div>
<?php else: ?>
    <?php foreach ($commitments as $c): ?>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 4px;"><?= htmlspecialchars($c['title']) ?></h3>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Komitmen dibuat: <?= format_datetime_id($c['committed_at']) ?>
                    </span>
                </div>
                <div>
                    <?php if ($c['status'] === 'committed'): ?>
                        <div class="countdown-box">
                            ⏳ <span class="countdown-timer" data-expires="<?= date('c', strtotime($c['lock_expires_at'])) ?>">Menghitung sisa waktu...</span>
                        </div>
                    <?php elseif ($c['status'] === 'proof_uploaded'): ?>
                        <span class="badge badge-info">Bukti Terunggah (Menunggu Pengambilan)</span>
                    <?php elseif ($c['status'] === 'completed'): ?>
                        <span class="badge badge-success">Selesai Diterima Ibu Hamil</span>
                    <?php elseif ($c['status'] === 'cancelled_ghosting'): ?>
                        <span class="badge badge-danger">Batal (Melewati Batas 48 Jam)</span>
                    <?php endif; ?>
                </div>
            </div>

            <div style="background: #f8fafc; padding: 14px; border-radius: 8px; margin-bottom: 14px;">
                <strong>Rincian Bahan Pangan yang Perlu Disiapkan:</strong>
                <p style="margin-top: 4px; color: #1e293b;"><?= nl2br(htmlspecialchars($c['food_items_needed'])) ?></p>
            </div>

            <div style="background: #f1f5f9; padding: 14px; border-radius: 8px; margin-bottom: 16px; font-size: 0.95rem;">
                📍 <strong>Alamat Tujuan Pengiriman / Titik Posyandu:</strong><br>
                <strong><?= htmlspecialchars($c['drop_point_name']) ?></strong><br>
                <?= htmlspecialchars($c['drop_point_address']) ?><br>
                <span style="color: var(--text-muted); font-size: 0.85rem;">Petugas: <?= htmlspecialchars($c['officer_in_charge']) ?> (<?= htmlspecialchars($c['drop_point_phone']) ?>)</span>
            </div>

            <?php if ($c['status'] === 'committed'): ?>
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 16px; border-radius: 8px;">
                    <h4 style="color: #065f46; margin-bottom: 8px;">Unggah Bukti Serah Terima di Posyandu</h4>
                    <p style="font-size: 0.85rem; color: #047857; margin-bottom: 12px;">
                        Setelah mengantarkan paket langsung ke posyandu atau mengirimkannya via jasa kurir/ojek online, unggah foto bukti serah terima atau resi pengiriman di bawah ini:
                    </p>
                    <form action="index.php?action=upload-proof" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                        <input type="hidden" name="donation_id" value="<?= $c['id'] ?>">

                        <div class="form-group">
                            <label for="proof_file_<?= $c['id'] ?>">Foto Bukti / Tanda Terima Paket:</label>
                            <input type="file" id="proof_file_<?= $c['id'] ?>" name="proof_file" class="form-control" accept="image/*" required>
                        </div>

                        <div class="form-group">
                            <label for="donor_notes_<?= $c['id'] ?>">Catatan Tambahan (Opsional, misal nama kurir atau pesan semangat):</label>
                            <input type="text" id="donor_notes_<?= $c['id'] ?>" name="donor_notes" class="form-control" placeholder="Contoh: Paket dititipkan ke Ibu Bidan Sri pukul 10.00 WIB">
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Bukti Serah Terima</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
