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

    // 2. Countdown Timer 48 Jam untuk Donatur (Anti-Slop & Dinamis)
    const timerElements = document.querySelectorAll('.countdown-timer');
    timerElements.forEach(function (el) {
        const expiresAtStr = el.getAttribute('data-expires');
        if (!expiresAtStr) return;

        const targetTime = new Date(expiresAtStr).getTime();
        const parentPill = el.closest('.countdown-pill');
        const progressBar = el.closest('.card')?.querySelector('.countdown-progress-bar');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance <= 0) {
                el.innerHTML = "Waktu Habis (Auto-Release)";
                if (parentPill) {
                    parentPill.classList.add('urgent');
                    parentPill.style.background = '#fee2e2';
                    parentPill.style.color = '#991b1b';
                }
                if (progressBar) progressBar.style.width = '0%';
                return;
            }

            const total48HoursMs = 48 * 60 * 60 * 1000;
            const remainingRatio = Math.max(0, Math.min(100, (distance / total48HoursMs) * 100));
            if (progressBar) {
                progressBar.style.width = remainingRatio + '%';
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Ubah visual ke mode urgent jika tersisa < 6 jam
            if (hours < 6 && parentPill) {
                parentPill.classList.add('urgent');
            }

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
function openProofModal(needId) {
        const modal = document.getElementById(
            'proof-modal-' + needId
        );

        const image = document.getElementById(
            'proof-image-' + needId
        );

        const loading = document.getElementById(
            'proof-loading-' + needId
        );

        if (!modal || !image || !loading) return;

        modal.style.display = 'flex';
        image.style.display = 'none';
        loading.textContent = 'Memuat foto bukti bantuan...';
        loading.style.display = 'block';

        image.onload = function () {
            image.style.display = 'block';
            loading.style.display = 'none';
        };

        image.onerror = function () {
            image.style.display = 'none';
            loading.textContent =
                'Foto bukti tidak ditemukan atau gagal dimuat.';
            loading.style.display = 'block';
        };

        image.src =
            'index.php?action=view-proof&need_id=' +
            encodeURIComponent(needId);
    }

    function closeProofModal(needId) {
        const modal = document.getElementById(
            'proof-modal-' + needId
        );

        if (modal) {
            modal.style.display = 'none';
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.proof-modal').forEach(
                function (modal) {
                    modal.style.display = 'none';
                }
            );
            closeKiaInspector();
        }
    });

    // 4. Modal Inspeksi Buku KIA (Zoom & Rotate untuk Admin)
    let currentZoom = 1;
    let currentRotation = 0;

    window.openKiaInspector = function (src, title) {
        const modal = document.getElementById('kia-inspector-modal');
        const img = document.getElementById('kia-inspect-img');
        const titleEl = document.getElementById('kia-inspect-title');
        if (!modal || !img) return;

        currentZoom = 1;
        currentRotation = 0;
        img.src = src;
        img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
        if (titleEl) titleEl.textContent = title || 'Inspeksi Lembar Buku KIA';

        modal.style.display = 'flex';
    };

    window.closeKiaInspector = function () {
        const modal = document.getElementById('kia-inspector-modal');
        if (modal) modal.style.display = 'none';
    };

    window.zoomKia = function (delta) {
        currentZoom = Math.min(3, Math.max(0.5, currentZoom + delta));
        const img = document.getElementById('kia-inspect-img');
        if (img) img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
    };

    window.rotateKia = function () {
        currentRotation = (currentRotation + 90) % 360;
        const img = document.getElementById('kia-inspect-img');
        if (img) img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
    };

    window.resetKia = function () {
        currentZoom = 1;
        currentRotation = 0;
        const img = document.getElementById('kia-inspect-img');
        if (img) img.style.transform = `scale(1) rotate(0deg)`;
    };

    // 5. Live Image Preview Helper (Dropzone)
    window.previewSelectedImage = function (input, previewId, containerId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        const container = document.getElementById(containerId);

        if (file && preview && container) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    };
