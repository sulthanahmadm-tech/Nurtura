<?php
/**
 * Format & Masking Helper
 */

function mask_name($name, $district = '') {
    $parts = explode(' ', trim($name));
    $first = $parts[0] ?? 'Ibu';
    $masked = mb_substr($first, 0, 2) . '****';
    if (!empty($district)) {
        return "Ibu " . $masked . " (" . htmlspecialchars($district) . ")";
    }
    return "Ibu " . $masked;
}

function render_status_badge($status) {
    $badges = [
        'draf'                 => ['class' => 'badge-secondary', 'label' => 'Draf'],
        'menunggu_peninjauan'  => ['class' => 'badge-warning',   'label' => 'Menunggu Review Admin'],
        'perlu_perbaikan'      => ['class' => 'badge-danger',    'label' => 'Perlu Perbaikan Data'],
        'ditolak'              => ['class' => 'badge-danger',    'label' => 'Ditolak'],
        'dipublikasikan'       => ['class' => 'badge-success',   'label' => 'Terverifikasi (Siap Dibantu)'],
        'dalam_komitmen'       => ['class' => 'badge-info',      'label' => 'Sedang Diproses Donatur'],
        'menunggu_pengambilan' => ['class' => 'badge-primary',   'label' => 'Paket Tiba di Posyandu'],
        'dispute'              => ['class' => 'badge-danger',    'label' => 'Kendala / Dispute'],
        'selesai'              => ['class' => 'badge-success',   'label' => 'Selesai Diterima'],
        'kedaluwarsa_hpl'      => ['class' => 'badge-dark',      'label' => 'Kedaluwarsa (Lewat HPL)'],
    ];

    $info = $badges[$status] ?? ['class' => 'badge-secondary', 'label' => ucfirst($status)];
    return '<span class="badge ' . $info['class'] . '">' . htmlspecialchars($info['label']) . '</span>';
}

function format_datetime_id($datetime_str) {
    if (!$datetime_str) return '-';
    $time = strtotime($datetime_str);
    return date('d M Y, H:i', $time) . ' WIB';
}

function render_need_progress_tracker($status) {
    $stages = [
        1 => 'Verifikasi KIA',
        2 => 'Katalog Terbuka',
        3 => 'Diproses Donatur',
        4 => 'Tiba di Posyandu',
        5 => 'Selesai Diterima',
    ];

    $current = 1;
    if ($status === 'menunggu_peninjauan' || $status === 'draf' || $status === 'perlu_perbaikan') $current = 1;
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
        $html .= '<div class="timeline-dot">' . ($stepNum < $current ? '✓' : $stepNum) . '</div>';
        $html .= '<span class="timeline-label">' . htmlspecialchars($stageLabel) . '</span>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}
