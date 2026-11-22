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
