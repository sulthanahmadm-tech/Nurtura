<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../app/helpers/format_helper.php';
require_once __DIR__ . '/../../app/helpers/auth_helper.php';

// Helper Stepper Alur Status Kebutuhan (Tanpa Emoji)
function render_need_progress_tracker($status) {
    $stages = [
        1 => 'Verifikasi KIA',
        2 => 'Katalog Terbuka',
        3 => 'Diproses Donatur',
        4 => 'Tiba di Posyandu',
        5 => 'Selesai Diterima',
    ];

    $current = 1;
    if ($status === 'menunggu_peninjauan' || $status === 'draf') $current = 1;
    elseif ($status === 'dipublikasikan') $current = 2;
    elseif ($status === 'dalam_komitmen') $current = 3;
    elseif ($status === 'menunggu_pengambilan') $current = 4;
    elseif ($status === 'selesai') $current = 5;

    $html = '<div class="timeline-track">';
    foreach ($stages as $stepNum => $stageLabel) {
        $stateClass = '';
        if ($stepNum < $current) $stateClass = 'completed';
        elseif ($stepNum === $current) $stateClass = 'active';

        $html .= '<div class="timeline-step ' . $stateClass . '">';
        $html .= '<div class="timeline-dot">' . $stepNum . '</div>';
        $html .= '<span class="timeline-label">' . htmlspecialchars($stageLabel) . '</span>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; letter-spacing: -0.02em;">
            Panel Ibu Hamil (NurturaID)
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
            Selamat datang, <strong><?= htmlspecialchars($profile['full_name']) ?></strong>. Pantau kondisi gizi dan perkembangan bantuan kehamilan Anda.
        </p>
    </div>
    <a href="index.php?page=create-need" class="btn btn-primary" style="padding: 11px 24px;">
        Ajukan Kebutuhan Gizi Baru
    </a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
            if ($_GET['msg'] === 'pengajuan_berhasil') echo "Pengajuan berhasil dikirim dan sedang menunggu validasi berkas Buku KIA oleh tim admin NurturaGuard.";
            elseif ($_GET['msg'] === 'bantuan_selesai') echo "Konfirmasi penerimaan paket telah disimpan. Semoga bermanfaat untuk kesehatan ibu dan janin.";
            elseif ($_GET['msg'] === 'dispute_diajukan') echo "Laporan kendala berhasil diajukan dan sedang ditangani oleh admin NurturaGuard.";
        ?>
    </div>
<?php endif; ?>

<!-- Ringkasan Profil Medis & Indikator Gizi (Editorial & Anti-Slop) -->
<div class="card" style="border: 1px solid var(--border-color); background: #ffffff; padding: 28px; margin-bottom: 28px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 800; margin: 0;">Indikator Medis & Profil Kehamilan</h3>
            <span style="font-size: 0.82rem; color: var(--text-muted);">Data tersinkronisasi dengan lembar catatan Buku KIA resmi</span>
        </div>
        <span class="badge badge-info" style="font-size: 0.76rem;">Rekam Medis Terverifikasi</span>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
        <!-- Usia Kehamilan -->
        <div style="background: #f8fafc; padding: 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.76rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">Usia Kehamilan</span>
            <div style="font-size: 1.45rem; font-weight: 900; color: #0f172a;">
                <?= $profile['gestational_age_weeks'] ?? '-' ?> <span style="font-size: 0.9rem; font-weight: 700; color: #64748b;">Minggu</span>
            </div>
            <div style="margin-top: 6px;">
                <?php 
                    $weeks = (int)($profile['gestational_age_weeks'] ?? 0);
                    $trimester = ($weeks <= 12) ? 'Trimester 1' : (($weeks <= 27) ? 'Trimester 2' : 'Trimester 3');
                ?>
                <span class="badge badge-secondary" style="font-size: 0.72rem;"><?= $trimester ?></span>
            </div>
        </div>

        <!-- HPL -->
        <div style="background: #f8fafc; padding: 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.76rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">Hari Perkiraan Lahir (HPL)</span>
            <div style="font-size: 1.3rem; font-weight: 800; color: #0284c7;">
                <?= $profile['estimated_birth_date'] ? date('d M Y', strtotime($profile['estimated_birth_date'])) : '-' ?>
            </div>
            <span style="font-size: 0.78rem; color: #64748b; display: block; margin-top: 6px;">
                <?php
                    if ($profile['estimated_birth_date']) {
                        $daysLeft = (int)ceil((strtotime($profile['estimated_birth_date']) - time()) / 86400);
                        echo ($daysLeft > 0) ? "{$daysLeft} hari lagi menuju persalinan" : "Masa HPL tercapai";
                    } else {
                        echo "Tanggal belum diisi";
                    }
                ?>
            </span>
        </div>

        <!-- LILA Gauge -->
        <div style="background: #fff1f2; padding: 18px; border-radius: var(--radius-sm); border: 1px solid #fecdd3;">
            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                <span style="font-size: 0.76rem; font-weight: 800; color: #9f1239; text-transform: uppercase; letter-spacing: 0.04em;">Ukuran LILA Terakhir</span>
                <span class="badge badge-coral" style="font-size: 0.7rem;"><?= ($profile['lila_cm'] < 23.5) ? 'Indikasi KEK' : 'Normal' ?></span>
            </div>
            <div style="font-size: 1.45rem; font-weight: 900; color: #be123c; margin-top: 2px;">
                <?= number_format($profile['lila_cm'], 1) ?> <span style="font-size: 0.85rem; font-weight: 700;">cm</span>
            </div>
            <div class="metric-bar-bg" style="margin-top: 8px;">
                <?php 
                    $pct = min(100, max(20, ($profile['lila_cm'] / 28) * 100));
                ?>
                <div class="metric-bar-fill" style="width: <?= $pct ?>%;"></div>
            </div>
            <span style="font-size: 0.72rem; color: #9f1239; display: block; margin-top: 5px;">
                Standar Kurang Energi Kronis (KEK): di bawah 23,5 cm
            </span>
        </div>

        <!-- Domisili -->
        <div style="background: #f8fafc; padding: 18px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
            <span style="font-size: 0.76rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">Wilayah Domisili</span>
            <div style="font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                <?= htmlspecialchars($profile['district']) ?>
            </div>
            <span style="font-size: 0.8rem; color: #64748b; display: block; margin-top: 6px;">
                <?= htmlspecialchars($profile['regency_city']) ?>
            </span>
        </div>
    </div>
</div>

<!-- Riwayat Pengajuan Kebutuhan Pangan -->
<div style="margin-bottom: 20px;">
    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Riwayat Pengajuan Kebutuhan Pangan</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Lacak progres bantuan dari proses verifikasi hingga serah terima di posyandu mitra.</p>
</div>

<?php if (empty($needs)): ?>
    <div class="card" style="text-align: center; padding: 48px 20px;">
        <h3 style="font-size: 1.25rem; color: #0f172a; margin-bottom: 8px;">Belum Ada Pengajuan Kebutuhan Aktif</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 0.94rem;">Jika ukuran LILA Anda di bawah 23,5 cm, Anda berhak mengajukan paket bantuan pangan bergizi.</p>
        <a href="index.php?page=create-need" class="btn btn-primary">Mulai Ajukan Kebutuhan Pertama</a>
    </div>
<?php else: ?>
    <?php foreach ($needs as $n): ?>
        <div class="card" style="border: 1px solid var(--border-color); padding: 26px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 4px; color: #0f172a;"><?= htmlspecialchars($n['title']) ?></h3>
                    <span style="font-size: 0.84rem; color: var(--text-muted);">
                        Diajukan pada: <strong><?= format_datetime_id($n['submitted_at']) ?></strong> • LILA Tertera: <strong><?= number_format($n['lila_measurement'], 1) ?> cm</strong>
                    </span>
                </div>
                <div>
                    <?= render_status_badge($n['status']) ?>
                </div>
            </div>

            <!-- Progress Tracker Stepper (01 - 05 Minimalis) -->
            <?= render_need_progress_tracker($n['status']) ?>

            <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 14px; border-radius: var(--radius-sm); margin-bottom: 14px; font-size: 0.92rem;">
                <span style="font-size: 0.74rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">
                    Paket Pangan yang Diajukan:
                </span>
                <p style="margin: 0; color: #1e293b; font-weight: 600; line-height: 1.5;"><?= nl2br(htmlspecialchars($n['food_items_needed'])) ?></p>
            </div>

            <div style="font-size: 0.86rem; color: var(--text-muted); margin-bottom: 16px; line-height: 1.45;">
                <span style="font-size: 0.74rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.03em; display: block;">Titik Antar Posyandu:</span>
                <span style="color: #0f172a; font-weight: 700;"><?= htmlspecialchars($n['drop_point_name']) ?></span> (<?= htmlspecialchars($n['drop_point_address']) ?>)
            </div>

            <?php if (!empty($n['admin_notes'])): ?>
                <div class="alert alert-info" style="font-size: 0.88rem; padding: 10px 14px; margin-bottom: 14px;">
                    <strong>Catatan Admin NurturaGuard:</strong> <?= htmlspecialchars($n['admin_notes']) ?>
                </div>
            <?php endif; ?>

            <!-- Aksi jika paket sudah diantar donatur ke posyandu (Aksi Bertingkat) -->
            <?php if ($n['status'] === 'menunggu_pengambilan'): ?>
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px; border-radius: var(--radius-sm); margin-top: 14px;">
                    <h4 style="color: #15803d; margin: 0 0 6px 0; font-size: 1.1rem; font-weight: 800;">
                        Paket Telah Tiba di Posyandu
                    </h4>
                    <p style="font-size: 0.92rem; color: #166534; margin: 0 0 16px 0; line-height: 1.5;">
                        Donatur telah menitipkan paket pangan bergizi ke Posyandu. Silakan ambil paket Anda saat jadwal kontrol dan lakukan konfirmasi penerimaan.
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                        <form action="index.php?action=confirm-received" method="POST" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $n['id'] ?>">
                            <button type="submit" class="btn btn-primary" data-confirm="Apakah Anda sudah mengambil paket di Posyandu dan memastikan isinya sesuai?">
                                Konfirmasi Paket Telah Diterima
                            </button>
                        </form>

                        <button
                            type="button"
                            class="btn btn-secondary btn-sm"
                            onclick="openProofModal(<?= (int)$n['id'] ?>)">
                            Lihat Bukti Drop Donatur
                        </button>

                        <button type="button" class="btn btn-sm" style="background: transparent; color: #b91c1c; border: 1px solid #fecaca;" onclick="document.getElementById('dispute-form-<?= $n['id'] ?>').style.display='block';">
                            Laporkan Kendala Penerimaan
                        </button>
                    </div>

                    <!-- Dispute Form Hidden -->
                    <div id="dispute-form-<?= $n['id'] ?>" style="display: none; margin-top: 16px; background: #ffffff; padding: 18px; border-radius: 8px; border: 1px solid #fecaca;">
                        <h5 style="color: #b91c1c; margin: 0 0 8px 0; font-weight: 800; font-size: 0.95rem;">Laporan Kendala Paket (Dispute)</h5>
                        <form action="index.php?action=dispute" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                            <input type="hidden" name="need_id" value="<?= $n['id'] ?>">
                            <div class="form-group">
                                <label for="reason">Jelaskan Kendala (misal: petugas posyandu belum menerima paket, atau barang tidak sesuai):</label>
                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button type="submit" class="btn btn-danger btn-sm">Kirim Laporan ke Admin</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('dispute-form-<?= $n['id'] ?>').style.display='none';">Batal</button>
                            </div>
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
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">Bukti Penyerahan Donatur di Posyandu</h3>
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
