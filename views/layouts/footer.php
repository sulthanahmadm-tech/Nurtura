    </main>
    <footer style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 64px 0 48px 0; margin-top: 60px;">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 36px; margin-bottom: 40px;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22v-9"/>
                        <path d="M12 13c-3-2-6-1-7 2 3 1 6 0 7-2z"/>
                        <path d="M12 13c3-3 6-2 7 1-3 2-6 0-7-1z"/>
                    </svg>
                    <span style="font-size: 1.15rem; font-weight: 700; color: #0f172a;"><?= APP_NAME ?></span>
                </div>
                <p style="font-size: 0.92rem; color: #64748b; line-height: 1.6; margin: 0;">
                    Platform solidaritas pencegahan stunting melalui intervensi paket pangan bergizi riil dan sistem drop-point terverifikasi pada jaringan Posyandu dan Bidan Desa.
                </p>
            </div>

            <div>
                <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #0f172a; display: block; margin-bottom: 12px;">
                    Standar Klinis & Akuntabilitas
                </span>
                <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                    Penetapan prioritas penerima didasarkan pada rujukan resmi lembar catatan Buku KIA dan ambang batas lingkar lengan atas (LILA &lt; 23,5 cm) Kementerian Kesehatan RI.
                </p>
            </div>

            <div>
                <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #0f172a; display: block; margin-bottom: 12px;">
                    Pengembang Proyek
                </span>
                <p style="font-size: 0.88rem; color: #64748b; line-height: 1.6; margin: 0;">
                    Dikembangkan oleh <strong>S-Tech Tim Gensoed Novices</strong><br>
                    Sub-tema: <em>Nutrition & Household Security</em><br>
                    Sistem 100% mandiri, bebas transaksi tunai, dan siap audit.
                </p>
            </div>
        </div>

        <div class="container" style="padding-top: 24px; border-top: 1px solid #e2e8f0; text-align: center;">
            <p style="font-size: 0.82rem; color: #64748b; margin: 0;">
                &copy; <?= date('Y') ?> Nurtura Platform. Seluruh hak cipta dilindungi. Nurtura bukan pengganti konsultasi medis tatap muka.
            </p>
        </div>
    </footer>

    <!-- Global Website Confirmation Modal (Pengganti confirm() Browser) -->
    <div id="nurtura-global-confirm-modal" class="nurtura-modal-backdrop" onclick="closeGlobalConfirmModal()" role="dialog" aria-modal="true" style="display: none;">
        <div class="nurtura-modal-card" onclick="event.stopPropagation()">
            <div style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 4px;">
                Konfirmasi Tindakan
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 10px 0;">
                Pastikan Keputusan Anda
            </h3>
            <p id="nurtura-global-confirm-msg" style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin: 0 0 22px 0;"></p>
            <div style="display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" onclick="closeGlobalConfirmModal()" class="btn-ghost-clean" style="padding: 10px 20px;">
                    Batal
                </button>
                <button type="button" id="nurtura-global-confirm-ok" class="btn-lime" style="padding: 10px 22px;">
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
