    </main>

    <footer class="site-footer">
        <div class="container site-footer-grid">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.625rem; margin-bottom: 0.625rem;">
                    <span class="brand-mark" aria-hidden="true" style="width: 1.875rem; height: 1.875rem;">
                        <svg class="brand-mark-svg" style="width: 1.375rem; height: 1.375rem;" viewBox="0 0 256 256" fill="none">
                            <circle cx="67" cy="58" r="18" fill="#19496B"/>
                            <circle cx="189" cy="58" r="18" fill="#19496B"/>
                            <path d="M 48 85 C 31 91 22 114 24 142 C 27 179 59 211 106 212 C 146 213 177 190 192 156 C 194 151 190 150 186 155 C 167 178 139 190 110 187 C 86 184 71 171 67 154 C 78 164 93 169 111 171 C 118 172 122 168 122 163 C 122 158 117 155 110 153 C 87 146 72 127 69 101 C 67 88 58 81 48 85 Z" fill="#19496B"/>
                            <path d="M 208 85 C 198 81 189 88 187 101 C 184 127 169 146 146 153 C 139 155 134 158 134 163 C 134 168 138 172 145 171 C 164 169 180 163 190 152 C 183 180 159 203 125 216 C 119 218 121 221 128 220 C 185 214 229 178 232 142 C 234 114 225 91 208 85 Z" fill="#19496B"/>
                            <circle cx="128" cy="96" r="13.5" fill="#376386"/>
                            <path d="M 94 102 C 90 98 85 101 88 107 C 94 120 105 131 114 139 C 117 142 118 147 119 151 C 120 155 124 157 128 157 C 132 157 136 155 137 151 C 138 147 139 142 142 139 C 151 131 162 120 168 107 C 171 101 166 98 162 102 C 153 112 141 122 128 122 C 115 122 103 112 94 102 Z" fill="#376386"/>
                        </svg>
                    </span>
                    <span style="font-family: var(--font-display); font-size: 1.15rem; font-weight: 700; color: var(--text-main);"><?= APP_NAME ?></span>
                </div>
                <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                    Platform solidaritas pencegahan stunting melalui intervensi paket pangan bergizi riil dan sistem drop-point terverifikasi pada jaringan Posyandu dan Bidan Desa.
                </p>
            </div>

            <div>
                <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.625rem;">
                    Standar Klinis &amp; Akuntabilitas
                </span>
                <p style="font-size: 0.86rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                    Penetapan prioritas penerima didasarkan pada rujukan resmi lembar catatan Buku KIA dan ambang batas lingkar lengan atas (LILA &lt; 23,5 cm) Kementerian Kesehatan RI.
                </p>
            </div>

            <div>
                <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 0.625rem;">
                    Pengembang Proyek
                </span>
                <p style="font-size: 0.86rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
                    Dikembangkan oleh <strong>S-Tech Tim Gensoed Novices</strong><br>
                    Sub-tema: <em>Nutrition &amp; Household Security</em><br>
                    Sistem 100% mandiri, bebas transaksi tunai, dan siap audit.
                </p>
            </div>
        </div>

        <div class="container" style="padding-top: 1.25rem; text-align: center;">
            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                &copy; <?= date('Y') ?> Nurtura Platform. Seluruh hak cipta dilindungi. Nurtura bukan pengganti konsultasi medis tatap muka.
            </p>
        </div>
    </footer>

    <!-- Global Website Confirmation Bottom-Sheet / Modal (Pengganti confirm() Browser) -->
    <div id="nurtura-global-confirm-modal" class="nurtura-modal-backdrop" onclick="closeGlobalConfirmModal()" role="dialog" aria-modal="true" style="display: none;">
        <div class="nurtura-modal-card" onclick="event.stopPropagation()">
            <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--primary); margin-bottom: 0.375rem;">
                Konfirmasi Tindakan
            </div>
            <h3 style="font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.625rem 0;">
                Pastikan Keputusan Anda
            </h3>
            <p id="nurtura-global-confirm-msg" style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin: 0 0 1.375rem 0;"></p>
            <div style="display: flex; gap: 0.625rem; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" onclick="closeGlobalConfirmModal()" class="btn-ghost-clean btn-sm" style="padding: 0.5625rem 1.25rem;">
                    Batal
                </button>
                <button type="button" id="nurtura-global-confirm-ok" class="btn-cerulean btn-sm" style="padding: 0.5625rem 1.375rem;">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- Global Toast Notification -->
    <div id="nurtura-toast" class="nurtura-toast" role="status" aria-live="polite"></div>

    <script src="assets/js/medical_charts.js?v=<?= filemtime(__DIR__ . '/../../public/assets/js/medical_charts.js') ?>"></script>
    <script src="assets/js/main.js?v=<?= filemtime(__DIR__ . '/../../public/assets/js/main.js') ?>"></script>
</body>
</html>
