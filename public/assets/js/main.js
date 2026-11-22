/**
 * Nurtura Main JavaScript
 * Handles Countdown Timer, Form Toggles & Confirmations
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Role Toggle pada Form Register
    const roleSelect = document.getElementById('role-select');
    const pregnantFields = document.getElementById('pregnant-mother-fields');

    if (roleSelect && pregnantFields) {
        function toggleFields() {
            if (roleSelect.value === 'ibu_hamil') {
                pregnantFields.style.display = 'block';
            } else {
                pregnantFields.style.display = 'none';
            }
        }
        roleSelect.addEventListener('change', toggleFields);
        toggleFields();
    }

    // 2. Countdown Timer 48 Jam untuk Donatur
    const timerElements = document.querySelectorAll('.countdown-timer');
    timerElements.forEach(function (el) {
        const expiresAtStr = el.getAttribute('data-expires');
        if (!expiresAtStr) return;

        const targetTime = new Date(expiresAtStr).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance < 0) {
                el.innerHTML = "WAKTU HABIS (Auto-Release)";
                el.style.color = "#dc2626";
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            el.innerHTML = `${hours}j ${minutes}m ${seconds}d tersisa`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });

    // 3. Konfirmasi Dialog Aksi Krusial
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const message = btn.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
