<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h2>Dashboard Ibu Hamil (NurturaID)</h2>
        <p style="color: var(--text-muted);">Selamat datang, <strong><?= htmlspecialchars($profile['full_name']) ?></strong>.</p>
    </div>
    <a href="index.php?page=create-need" class="btn btn-primary">+ Ajukan Kebutuhan Gizi Baru</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
            if ($_GET['msg'] === 'pengajuan_berhasil') echo "Pengajuan berhasil dikirim dan sedang menunggu validasi berkas Buku KIA oleh tim admin NurturaGuard.";
            elseif ($_GET['msg'] === 'bantuan_selesai') echo "Terima kasih! Konfirmasi penerimaan paket telah disimpan. Semoga bermanfaat untuk kesehatan ibu dan janin.";
            elseif ($_GET['msg'] === 'dispute_diajukan') echo "Laporan kendala berhasil diajukan dan sedang ditangani oleh admin NurturaGuard.";
        ?>
    </div>
<?php endif; ?>

<!-- Ringkasan Profil Medis -->
<div class="card" style="border: 1px solid var(--border-color); background: #ffffff;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="color: var(--text-main); font-size: 1.25rem;">🩺 Informasi Kesehatan Kehamilan Anda</h3>
        <span class="badge badge-info">Rekam Medis KIA</span>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div style="background: var(--bg-page); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Usia Kehamilan</span>
            <strong style="font-size: 1.2rem; color: var(--text-main);"><?= $profile['gestational_age_weeks'] ?? '-' ?> Minggu</strong>
        </div>
        <div style="background: var(--bg-page); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Hari Perkiraan Lahir (HPL)</span>
            <strong style="font-size: 1.1rem; color: var(--text-main);"><?= $profile['estimated_birth_date'] ? date('d M Y', strtotime($profile['estimated_birth_date'])) : '-' ?></strong>
        </div>
        <div style="background: var(--accent-coral-light); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid #fecdd3;">
            <span style="font-size: 0.85rem; color: var(--accent-coral-dark); display: block; margin-bottom: 4px;">Ukuran LILA Terakhir</span>
            <strong style="font-size: 1.2rem; color: var(--accent-coral-dark);">
                <?= number_format($profile['lila_cm'], 1) ?> cm 
                <span style="font-size: 0.8rem; font-weight: normal;"><?= ($profile['lila_cm'] < 23.5) ? '(Indikasi KEK)' : '(Normal)' ?></span>
            </strong>
        </div>
        <div style="background: var(--bg-page); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Wilayah Domisili</span>
            <strong style="font-size: 1.05rem; color: var(--text-main);"><?= htmlspecialchars($profile['district']) ?>, <?= htmlspecialchars($profile['regency_city']) ?></strong>
        </div>
    </div>
</div>

<h3 style="margin-top: 32px; margin-bottom: 16px;">Riwayat Pengajuan Kebutuhan Pangan (NurturaNeeds)</h3>

<?php if (empty($needs)): ?>
    <div class="card" style="text-align: center; padding: 40px 20px;">
        <p style="color: var(--text-muted); margin-bottom: 16px;">Anda belum memiliki pengajuan kebutuhan pangan bergizi aktif.</p>
        <a href="index.php?page=create-need" class="btn btn-primary">Mulai Ajukan Kebutuhan Pertama</a>
    </div>
<?php else: ?>
    <?php foreach ($needs as $n): ?>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 4px;"><?= htmlspecialchars($n['title']) ?></h3>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Diajukan pada: <?= format_datetime_id($n['submitted_at']) ?> • LILA Tertera: <strong><?= number_format($n['lila_measurement'], 1) ?> cm</strong>
                    </span>
                </div>
                <div>
                    <?= render_status_badge($n['status']) ?>
                </div>
            </div>

            <div style="background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 12px; font-size: 0.95rem;">
                <strong>Paket Pangan yang Diajukan:</strong>
                <p style="margin-top: 4px;"><?= nl2br(htmlspecialchars($n['food_items_needed'])) ?></p>
            </div>

            <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">
                📍 <strong>Drop-Point Posyandu:</strong> <?= htmlspecialchars($n['drop_point_name']) ?> (<?= htmlspecialchars($n['drop_point_address']) ?>)
            </div>

            <?php if (!empty($n['admin_notes'])): ?>
                <div class="alert alert-info" style="font-size: 0.85rem; padding: 8px 12px;">
                    <strong>Catatan Admin NurturaGuard:</strong> <?= htmlspecialchars($n['admin_notes']) ?>
                </div>
            <?php endif; ?>

            <!-- Aksi jika paket sudah diantar donatur ke posyandu -->
            <?php if ($n['status'] === 'menunggu_pengambilan'): ?>
                <div style="background: #e0f2fe; border: 1px solid #7dd3fc; padding: 16px; border-radius: 8px; margin-top: 12px;">
                    <h4 style="color: #0369a1; margin-bottom: 6px;">🎉 Paket Telah Tiba di Posyandu!</h4>
                    <p style="font-size: 0.9rem; color: #0c4a6e; margin-bottom: 12px;">
                        Donatur telah mengantarkan paket pangan ke Posyandu. Silakan ambil paket Anda dan lakukan konfirmasi di bawah ini.
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <form action="index.php?action=confirm-received" method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $n['id'] ?>">
                            <button type="submit" class="btn btn-primary" data-confirm="Apakah Anda sudah mengambil paket di Posyandu dan memastikan isinya sesuai?">
                                ✅ Konfirmasi Paket Telah Diterima
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('dispute-form-<?= $n['id'] ?>').style.display='block';">
                            ⚠️ Laporkan Masalah / Paket Tidak Ada
                        </button>

                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="openProofModal(<?= (int)$n['id'] ?>)">
                            <span>📷</span> Lihat Bukti Bantuan
                        </button>

                    </div>

                    <!-- Dispute Form Hidden -->
                    <div id="dispute-form-<?= $n['id'] ?>" style="display: none; margin-top: 16px; background: #ffffff; padding: 16px; border-radius: 8px; border: 1px solid #fecaca;">
                        <h5 style="color: #b91c1c; margin-bottom: 8px;">Ajukan Laporan Sengketa / Dispute</h5>
                        <form action="index.php?action=dispute" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $n['id'] ?>">
                            <div class="form-group">
                                <label for="reason">Jelaskan Kendala (misal: petugas posyandu belum menerima paket, atau barang rusak):</label>
                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Kirim Laporan ke Admin</button>
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('dispute-form-<?= $n['id'] ?>').style.display='none';">Batal</button>
                        </form>
                    </div>
                </div>

                <!-- Modal Bukti Bantuan -->
                <div id="proof-modal-<?= (int)$n['id'] ?>"
                    class="proof-modal"
                    onclick="closeProofModal(<?= (int)$n['id'] ?>)">

                    <div class="proof-modal-content"
                        onclick="event.stopPropagation()">

                        <div class="proof-modal-header">
                            <h3>Bukti Bantuan dari Donatur</h3>

                            <button type="button"
                                    class="proof-close"
                                    onclick="closeProofModal(<?= (int)$n['id'] ?>)">
                                &times;
                            </button>
                        </div>

                        <div class="proof-modal-body">
                            <img
                                id="proof-image-<?= (int)$n['id'] ?>"
                                src=""
                                alt="Foto bukti bantuan dari donatur">

                            <p id="proof-loading-<?= (int)$n['id'] ?>">
                                Memuat foto bukti bantuan...
                            </p>
                        </div>

                    </div>
                </div>

            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
