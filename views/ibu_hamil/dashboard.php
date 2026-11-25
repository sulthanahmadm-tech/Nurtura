<?php
require_once __DIR__ . '/../../app/helpers/format_helper.php';

// Ambil data asli dari controller dengan fallback aman (anti Undefined Variable)
$nama_ibu       = $profile['full_name'] ?? $_SESSION['user']['full_name'] ?? 'Bunda';
$usia_minggu    = (int)($gestationalWeeks ?? 0);
$usia_hari      = $usia_minggu * 7;
$hpl_formatted  = !empty($profile['estimated_birth_date']) ? date('d M Y', strtotime($profile['estimated_birth_date'])) : 'Belum diisi';

$raw_lila       = $lilaValue ?? $profile['lila_cm'] ?? null;
$lila_tampil    = ($raw_lila !== null && $raw_lila !== '') ? number_format((float)$raw_lila, 1) : '-';
$is_kek         = isset($lilaAtRisk) ? (bool)$lilaAtRisk : ($raw_lila !== null && $raw_lila !== '' && (float)$raw_lila < 23.5);

$domisili       = trim(($profile['district'] ?? '') . ', ' . ($profile['regency_city'] ?? ''), ', ');
if ($domisili === '') $domisili = 'Belum diisi';

$status_lila    = $is_kek ? 'Risiko KEK (< 23.5 cm)' : 'Normal / Aman';
$badge_lila     = $is_kek ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700';
$needs_list     = is_array($needs ?? null) ? $needs : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NurturaCare — Dashboard Ibu Hamil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f3f5f8;
            color: #1e293b;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.85; }
            50% { transform: scale(1.05); opacity: 1; }
        }
        .fetus-glow {
            animation: pulseGlow 4s ease-in-out infinite;
        }
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .badge-warning, .badge-pending { background-color: #fef3c7; color: #b45309; }
        .badge-success, .badge-approved, .badge-completed { background-color: #d1fae5; color: #047857; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }
        .badge-danger, .badge-rejected { background-color: #fee2e2; color: #b91c1c; }
        .proof-modal { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 9999; align-items: center; justify-content: center; padding: 16px; }
        .proof-modal.active { display: flex; }
        .proof-modal-content { background: #fff; border-radius: 20px; max-width: 520px; width: 100%; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); }
        .proof-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; }
        .proof-modal-header h3 { font-weight: 700; font-size: 1rem; color: #0f172a; }
        .proof-close { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 9999px; font-size: 1.1rem; cursor: pointer; color: #475569; }
        .proof-modal-body { padding: 20px; text-align: center; }
        .proof-modal-body img { max-height: 360px; width: auto; margin: 0 auto; border-radius: 12px; }
    </style>
</head>
<body class="min-h-screen bg-[#f3f5f8] antialiased">

    <!-- 1. SIDEBAR NAVIGASI KIRI -->
    <aside class="w-20 bg-[#18181b] text-white flex flex-col items-center py-6 justify-between fixed top-0 bottom-0 left-0 z-40">
        <div class="flex flex-col items-center gap-8 w-full">
            <a href="index.php?page=ibu-hamil-dashboard" title="NurturaCare Dashboard" class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center font-bold text-lg tracking-wider text-sky-300 hover:bg-white/20 transition">
                NT
            </a>

            <nav class="flex flex-col items-center gap-3 w-full px-3">
                <a href="index.php?page=ibu-hamil-dashboard" title="Dashboard Ibu Hamil" class="w-12 h-12 rounded-2xl bg-sky-300 text-slate-900 flex items-center justify-center shadow-md transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    </svg>
                </a>

                <a href="index.php?page=create-need" title="Ajukan Kebutuhan Gizi" class="w-12 h-12 rounded-2xl text-zinc-400 hover:text-white hover:bg-white/10 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </a>

                <a href="#riwayat-pengajuan" title="Riwayat Pengajuan Pangan" class="w-12 h-12 rounded-2xl text-zinc-400 hover:text-white hover:bg-white/10 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </a>

                <a href="#health-metrics" title="Metrik Kesehatan & LILA" class="w-12 h-12 rounded-2xl text-zinc-400 hover:text-white hover:bg-white/10 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </a>
            </nav>
        </div>

        <div class="flex flex-col items-center gap-2">
            <a href="index.php?page=home" title="Halaman Depan Nurtura" class="w-12 h-12 rounded-2xl text-zinc-400 hover:text-white hover:bg-white/10 flex items-center justify-center transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
            <a href="index.php?action=logout" title="Keluar Akun" class="w-12 h-12 rounded-2xl text-zinc-400 hover:text-rose-400 hover:bg-white/10 flex items-center justify-center transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </a>
        </div>
    </aside>

    <!-- 2. AREA KONTEN UTAMA (Memakai pl-28 agar tidak tertutup sidebar kiri dan penuh melebar) -->
    <div class="w-full pl-28 pr-6 py-6 lg:pr-10 lg:py-8 box-border">
        <div class="max-w-[1440px] mx-auto space-y-6">

            <!-- Notifikasi Flash Message -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium" role="status">
                    <?php
                    if ($_GET['msg'] === 'pengajuan_berhasil') echo "Pengajuan berhasil dikirim dan sedang menunggu validasi berkas Buku KIA oleh tim admin NurturaGuard.";
                    elseif ($_GET['msg'] === 'bantuan_selesai') echo "Terima kasih! Konfirmasi penerimaan paket telah disimpan. Semoga bermanfaat untuk kesehatan ibu dan janin.";
                    elseif ($_GET['msg'] === 'dispute_diajukan') echo "Laporan kendala berhasil diajukan dan sedang ditangani oleh admin NurturaGuard.";
                    else echo "Perubahan berhasil disimpan.";
                    ?>
                </div>
            <?php endif; ?>

            <!-- GRID UTAMA 3 KOLOM -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

                <!-- KOLOM KIRI (5 Kolom): Sapaan, Visual Utama & Ringkasan LILA/HPL -->
                <section class="lg:col-span-5 bg-[#faf9f6] rounded-3xl p-7 shadow-sm border border-slate-200/70 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="inline-block text-xs font-semibold text-sky-700 bg-sky-100/80 px-3 py-1 rounded-full">NurturaCare · Ibu Hamil</span>
                                <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 tracking-tight mt-2.5">
                                    Halo, <?= htmlspecialchars($nama_ibu) ?>!
                                </h1>
                                <p class="text-sm text-slate-500 mt-1">
                                    <?= $usia_minggu > 0 ? "Hari ke-{$usia_hari} perjalanan kehamilan Anda (Minggu ke-{$usia_minggu})" : "Pantau status gizi & bantuan pangan Anda" ?>
                                </p>
                            </div>
                            <?php if ($usia_minggu > 0): ?>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-900 text-white shrink-0">
                                Trimester <?= $usia_minggu <= 13 ? '1' : ($usia_minggu <= 27 ? '2' : '3') ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Ilustrasi Visual Kehamilan -->
                        <div class="my-8 relative flex flex-col items-center justify-center">
                            <div class="w-56 h-56 rounded-full bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 shadow-xl flex items-center justify-center relative overflow-hidden border-4 border-white">
                                <div class="w-36 h-36 rounded-full bg-gradient-to-tr from-orange-600 via-amber-500 to-rose-400 blur-md opacity-75 absolute fetus-glow"></div>
                                <div class="relative z-10 text-center text-white px-4">
                                    <span class="text-[11px] uppercase tracking-widest text-sky-300 font-semibold">Usia Kehamilan</span>
                                    <div class="text-4xl font-bold mt-1">
                                        <?= $usia_minggu > 0 ? $usia_minggu . ' <span class="text-base font-normal">Minggu</span>' : '-' ?>
                                    </div>
                                    <p class="text-xs text-slate-300 mt-2">Perkiraan HPL:<br><strong class="text-white"><?= htmlspecialchars($hpl_formatted) ?></strong></p>
                                </div>
                            </div>
                            <div class="w-64 h-10 border border-dashed border-slate-300 rounded-[100%] -mt-5 pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- 3 Kartu Ringkasan Bawah -->
                    <div class="grid grid-cols-3 gap-3 pt-4 border-t border-slate-200/80">
                        <div class="bg-white p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-medium text-slate-400 uppercase block">Ukuran LILA</span>
                            <div class="text-lg font-bold text-slate-900 mt-0.5"><?= htmlspecialchars($lila_tampil) ?> <span class="text-xs font-normal text-slate-500">cm</span></div>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-semibold <?= $badge_lila ?>">
                                <?= $status_lila ?>
                            </span>
                        </div>

                        <div class="bg-white p-3.5 rounded-2xl border border-slate-100">
                            <span class="text-[11px] font-medium text-slate-400 uppercase block">Domisili</span>
                            <div class="text-xs font-bold text-slate-900 mt-1 break-words"><?= htmlspecialchars($domisili) ?></div>
                            <span class="inline-block mt-1 text-[10px] text-slate-400">Titik Posyandu</span>
                        </div>

                        <div class="bg-white p-3.5 rounded-2xl border border-slate-100 flex flex-col justify-between">
                            <span class="text-[11px] font-medium text-slate-400 uppercase block">Bantuan Gizi</span>
                            <a href="index.php?page=create-need" class="mt-2 inline-flex items-center justify-center w-full py-2 px-2.5 rounded-xl bg-[#c7f22b] text-slate-900 text-xs font-bold hover:brightness-95 transition">
                                + Ajukan
                            </a>
                        </div>
                    </div>
                </section>

                <!-- KOLOM TENGAH (3 Kolom): Weekly Progress Timeline -->
                <section class="lg:col-span-3 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/70 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-bold text-slate-900">Weekly Progress</h2>
                            <span class="text-xs font-medium text-slate-400">Panduan KIA</span>
                        </div>

                        <div class="w-40 h-40 mx-auto rounded-full bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 p-3 shadow-inner flex items-center justify-center mb-6">
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-orange-500/85 to-amber-300/85 flex flex-col items-center justify-center text-white text-center p-3">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-orange-100">Fase Aktif</span>
                                <span class="text-xl font-bold mt-0.5"><?= $usia_minggu > 0 ? "Minggu {$usia_minggu}" : "Trimester" ?></span>
                                <span class="text-[11px] text-orange-50 mt-1">Fokus Protein & Zat Besi</span>
                            </div>
                        </div>

                        <div class="space-y-3 relative before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-slate-200">
                            <div class="relative pl-9">
                                <span class="w-3 h-3 rounded-full bg-orange-500 ring-4 ring-orange-100 absolute left-2 top-3.5"></span>
                                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                    <div class="text-sm font-bold text-slate-900">Status Gizi & LILA</div>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                                        <?= $is_kek ? 'Nilai LILA di bawah 23,5 cm merupakan indikator risiko KEK dan perlu konsultasi tenaga kesehatan.' : 'Pertahankan pola makan bergizi seimbang dan konsumsi TTD rutin.' ?>
                                    </p>
                                </div>
                            </div>

                            <div class="relative pl-9">
                                <span class="w-3 h-3 rounded-full bg-slate-300 absolute left-2 top-3.5"></span>
                                <div class="bg-white border border-slate-100 rounded-2xl p-3.5">
                                    <div class="text-sm font-semibold text-slate-700">Validasi Buku KIA</div>
                                    <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Pastikan catatan pemeriksaan rutin tercatat untuk verifikasi paket pangan.</p>
                                </div>
                            </div>

                            <div class="relative pl-9">
                                <span class="w-3 h-3 rounded-full bg-slate-300 absolute left-2 top-3.5"></span>
                                <div class="bg-white border border-slate-100 rounded-2xl p-3.5">
                                    <div class="text-sm font-semibold text-slate-700">Serah Terima Posyandu</div>
                                    <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Pengambilan paket dilakukan langsung di titik Posyandu / Bidan Desa mitra.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- KOLOM KANAN (4 Kolom): Health Metrics & Ajukan Kebutuhan -->
                <section class="lg:col-span-4 flex flex-col gap-6 justify-between">

                    <!-- Kartu Health Metrics -->
                    <div id="health-metrics" class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/70">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-slate-900">Health Metrics</h2>
                            <span class="text-xs font-semibold text-slate-400">Data KIA</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Indikator LILA -->
                            <div class="bg-[#f8fafc] rounded-2xl p-4 border border-slate-100">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                    <span class="w-6 h-6 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">♥</span>
                                    <span>Lingkar Lengan</span>
                                </div>
                                <div class="flex items-end gap-1.5 h-8 my-3">
                                    <span class="w-1.5 h-5 bg-rose-700 rounded-full"></span>
                                    <span class="w-1.5 h-7 bg-rose-700 rounded-full"></span>
                                    <span class="w-1.5 h-6 bg-rose-700 rounded-full"></span>
                                    <span class="w-1.5 h-8 bg-rose-700 rounded-full"></span>
                                    <span class="w-1.5 h-6 bg-slate-200 rounded-full"></span>
                                </div>
                                <div class="text-xl font-bold text-slate-900">
                                    <?= htmlspecialchars($lila_tampil) ?> <span class="text-xs font-normal text-slate-400">cm</span>
                                </div>
                            </div>

                            <!-- Total Pengajuan -->
                            <div class="bg-[#f8fafc] rounded-2xl p-4 border border-slate-100">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                    <span class="w-6 h-6 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">📦</span>
                                    <span>Total Pengajuan</span>
                                </div>
                                <div class="my-4">
                                    <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                                        <div class="bg-sky-500 h-full rounded-full" style="width: <?= count($needs_list) > 0 ? '100%' : '15%' ?>"></div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 mt-1.5 block">NurturaNeeds aktif</span>
                                </div>
                                <div class="text-xl font-bold text-slate-900">
                                    <?= count($needs_list) ?> <span class="text-xs font-normal text-slate-400">pengajuan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Aksi Cepat Ajukan Kebutuhan -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-sm flex-1 flex flex-col justify-between gap-5">
                        <div>
                            <span class="text-xs font-semibold text-[#c7f22b] uppercase tracking-wider">Program Bantuan Pangan</span>
                            <h3 class="text-xl font-bold mt-1.5">Butuh Paket Pangan Bergizi?</h3>
                            <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                                Ajukan kebutuhan protein hewani, susu ibu hamil, dan suplemen dengan melampirkan foto Buku KIA untuk diverifikasi tim NurturaGuard.
                            </p>
                        </div>
                        <a href="index.php?page=create-need" class="inline-flex items-center justify-center w-full py-3.5 px-4 rounded-2xl bg-[#c7f22b] text-slate-900 font-bold text-sm hover:brightness-95 transition">
                            + Ajukan Kebutuhan Gizi Sekarang
                        </a>
                    </div>
                </section>
            </div>

            <!-- 3. BAGIAN BAWAH: RIWAYAT PENGAJUAN KEBUTUHAN PANGAN -->
            <section id="riwayat-pengajuan" class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-200/70">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-semibold text-sky-700 uppercase tracking-wider">NurturaNeeds</span>
                        <h2 class="text-xl font-bold text-slate-900 mt-0.5">Riwayat Pengajuan Kebutuhan Pangan</h2>
                    </div>
                    <span class="text-xs font-semibold px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-600">
                        <?= count($needs_list) ?> pengajuan tercatat
                    </span>
                </div>

                <?php if (empty($needs_list)): ?>
                    <div class="text-center py-12 px-4 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/60">
                        <div class="text-3xl mb-2">🥗</div>
                        <h3 class="text-base font-bold text-slate-900">Belum ada pengajuan kebutuhan</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 mb-5">
                            Ajukan paket pangan bergizi agar tim NurturaGuard dapat meninjau dan menyalurkannya ke Posyandu terdekat Anda.
                        </p>
                        <a href="index.php?page=create-need" class="inline-flex items-center px-5 py-2.5 rounded-full bg-[#c7f22b] text-slate-900 text-xs font-bold shadow-sm hover:brightness-95 transition">
                            + Mulai Ajukan Kebutuhan
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <?php foreach ($needs_list as $n): ?>
                            <article class="rounded-2xl border border-slate-200/90 p-5 bg-[#fafcff] flex flex-col justify-between gap-4">
                                <div>
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <span class="text-[11px] font-semibold text-sky-700 uppercase">Pengajuan Kebutuhan</span>
                                            <h3 class="text-base font-bold text-slate-900 mt-0.5"><?= htmlspecialchars($n['title']) ?></h3>
                                            <p class="text-xs text-slate-400 mt-1">
                                                Diajukan <?= function_exists('format_datetime_id') ? format_datetime_id($n['submitted_at']) : htmlspecialchars($n['submitted_at'] ?? '') ?>
                                                · LILA <?= number_format((float)($n['lila_measurement'] ?? 0), 1) ?> cm
                                            </p>
                                        </div>
                                        <div>
                                            <?= function_exists('render_status_badge') ? render_status_badge($n['status']) : '<span class="badge badge-info">' . htmlspecialchars($n['status']) . '</span>' ?>
                                        </div>
                                    </div>

                                    <div class="mt-4 p-3.5 rounded-xl bg-white border border-slate-200/70">
                                        <span class="text-[11px] font-bold text-sky-800 uppercase tracking-wider">Paket Pangan yang Diajukan</span>
                                        <p class="text-xs text-slate-700 mt-1.5 leading-relaxed"><?= nl2br(htmlspecialchars($n['food_items_needed'])) ?></p>
                                    </div>

                                    <p class="text-xs text-slate-500 mt-3">
                                        📍 <strong>Drop-point Posyandu:</strong> <?= htmlspecialchars($n['drop_point_name'] ?? '-') ?>
                                        <?= !empty($n['drop_point_district']) ? '(' . htmlspecialchars($n['drop_point_district']) . ')' : '' ?>
                                    </p>

                                    <?php if (!empty($n['admin_notes'])): ?>
                                        <div class="mt-3 p-3 rounded-xl bg-sky-50 border border-sky-200 text-xs text-sky-900">
                                            <strong>Catatan Admin NurturaGuard:</strong> <?= htmlspecialchars($n['admin_notes']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if (($n['status'] ?? '') === 'menunggu_pengambilan'): ?>
                                    <div class="p-4 rounded-xl bg-emerald-50/80 border border-emerald-200">
                                        <h4 class="text-xs font-bold text-emerald-900">🎉 Paket telah tiba di Posyandu!</h4>
                                        <p class="text-[11px] text-emerald-700 mt-1 mb-3">Silakan ambil paket Anda dan konfirmasi penerimaan di bawah ini.</p>
                                        <div class="flex flex-wrap gap-2">
                                            <form action="index.php?action=confirm-received" method="POST">
                                                <input type="hidden" name="csrf_token" value="<?= function_exists('generate_csrf_token') ? generate_csrf_token() : '' ?>">
                                                <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                                <button type="submit" class="px-3.5 py-2 rounded-lg bg-emerald-600 text-white text-xs font-semibold hover:bg-emerald-700 transition" onclick="return confirm('Apakah Anda sudah mengambil paket di Posyandu dan memastikan isinya sesuai?')">
                                                    Konfirmasi Terima Paket
                                                </button>
                                            </form>
                                            <button type="button" class="px-3 py-2 rounded-lg bg-rose-100 text-rose-700 text-xs font-semibold hover:bg-rose-200 transition" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display='block'">
                                                Ajukan Kendala
                                            </button>
                                            <button type="button" class="px-3 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition" onclick="openProofModal(<?= (int)$n['id'] ?>)">
                                                Lihat Bukti Bantuan
                                            </button>
                                        </div>

                                        <div id="dispute-form-<?= (int)$n['id'] ?>" style="display:none;" class="mt-3 p-3 rounded-xl bg-white border border-rose-200">
                                            <h5 class="text-xs font-bold text-rose-700 mb-2">Ajukan Laporan Kendala</h5>
                                            <form action="index.php?action=dispute" method="POST" class="space-y-2">
                                                <input type="hidden" name="csrf_token" value="<?= function_exists('generate_csrf_token') ? generate_csrf_token() : '' ?>">
                                                <input type="hidden" name="need_id" value="<?= (int)$n['id'] ?>">
                                                <textarea name="reason" rows="2" class="w-full rounded-lg border border-slate-300 p-2 text-xs" placeholder="Jelaskan kendala yang dialami..." required></textarea>
                                                <div class="flex gap-2">
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-600 text-white text-xs font-semibold">Kirim Laporan</button>
                                                    <button type="button" class="px-3 py-1.5 rounded-lg bg-slate-200 text-slate-700 text-xs font-semibold" onclick="document.getElementById('dispute-form-<?= (int)$n['id'] ?>').style.display='none'">Batal</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div id="proof-modal-<?= (int)$n['id'] ?>" class="proof-modal" onclick="closeProofModal(<?= (int)$n['id'] ?>)">
                                            <div class="proof-modal-content" onclick="event.stopPropagation()">
                                                <div class="proof-modal-header">
                                                    <h3>Bukti Bantuan dari Donatur</h3>
                                                    <button type="button" class="proof-close" onclick="closeProofModal(<?= (int)$n['id'] ?>)">&times;</button>
                                                </div>
                                                <div class="proof-modal-body">
                                                    <img id="proof-image-<?= (int)$n['id'] ?>" src="" alt="Foto bukti bantuan dari donatur">
                                                    <p id="proof-loading-<?= (int)$n['id'] ?>" class="text-xs text-slate-500 mt-2">Memuat foto bukti bantuan...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Footer Ringkas (Tanpa memanggil footer.php yang menutup tag dari header.php) -->
            <footer class="text-center text-xs text-slate-400 py-2">
                <strong class="text-slate-600">Nurtura</strong> — Platform Pencegahan Stunting Melalui Sistem Komunikasi &amp; Drop-Point Posyandu · Tim Gensoed Novices
            </footer>
        </div>
    </div>

    <script>
        function openProofModal(needId) {
            const modal = document.getElementById('proof-modal-' + needId);
            const img = document.getElementById('proof-image-' + needId);
            const loading = document.getElementById('proof-loading-' + needId);
            if (!modal) return;
            modal.classList.add('active');
            loading.style.display = 'block';
            img.style.display = 'none';
            fetch('index.php?action=get-donation-proof&need_id=' + needId)
                .then(r => r.json())
                .then(data => {
                    if (data && data.photo_url) {
                        img.src = data.photo_url;
                        img.style.display = 'block';
                        loading.style.display = 'none';
                    } else {
                        loading.textContent = 'Foto bukti bantuan belum tersedia.';
                    }
                })
                .catch(() => {
                    loading.textContent = 'Gagal memuat foto bukti bantuan.';
                });
        }
        function closeProofModal(needId) {
            const modal = document.getElementById('proof-modal-' + needId);
            if (modal) modal.classList.remove('active');
        }
    </script>
</body>
</html>