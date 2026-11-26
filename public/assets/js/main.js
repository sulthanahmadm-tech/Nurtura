/**
 * Nurtura Main JavaScript
 * Handles Countdown Timer, Role Toggles, Mobile Drawer, Responsive Accordions & Modals
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
        const cardParent = el.closest('.card, .card-modern, .card-dark-3d, .card-clean');
        const progressBar = cardParent ? cardParent.querySelector('.countdown-progress-bar') : null;

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance <= 0) {
                el.innerHTML = 'Waktu Habis (Auto-Release)';
                if (parentPill) {
                    parentPill.classList.add('urgent');
                    parentPill.style.color = '#A83836';
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

            if (hours < 6 && parentPill) {
                parentPill.classList.add('urgent');
            }

            el.innerHTML = `${hours}j ${minutes}m ${seconds}d tersisa`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });

    // 3. Mobile Navigation Drawer Controller
    const mobileToggleBtn = document.getElementById('mobile-nav-toggle');
    const mobileCloseBtn = document.getElementById('mobile-nav-close');
    const mobileDrawer = document.getElementById('mobile-nav-drawer');
    const mobileBackdrop = document.getElementById('mobile-nav-backdrop');

    window.openMobileDrawer = function () {
        if (!mobileDrawer || !mobileBackdrop) return;
        mobileBackdrop.classList.add('is-open');
        mobileDrawer.classList.add('is-open');
        mobileDrawer.setAttribute('aria-hidden', 'false');
        if (mobileToggleBtn) mobileToggleBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    };

    window.closeMobileDrawer = function () {
        if (!mobileDrawer || !mobileBackdrop) return;
        mobileBackdrop.classList.remove('is-open');
        mobileDrawer.classList.remove('is-open');
        mobileDrawer.setAttribute('aria-hidden', 'true');
        if (mobileToggleBtn) mobileToggleBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    };

    if (mobileToggleBtn) {
        mobileToggleBtn.addEventListener('click', function () {
            const isOpen = mobileDrawer && mobileDrawer.classList.contains('is-open');
            if (isOpen) window.closeMobileDrawer();
            else window.openMobileDrawer();
        });
    }
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', window.closeMobileDrawer);
    }
    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', window.closeMobileDrawer);
    }
    if (mobileDrawer) {
        mobileDrawer.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', window.closeMobileDrawer);
        });
    }

    // 4. Responsive Information Accordions (<details data-mobile-collapse>)
    const mobileMedia = window.matchMedia('(max-width: 48rem)');
    function syncMobileAccordions() {
        const collapsibleCards = document.querySelectorAll('details[data-mobile-collapse]');
        const isMobile = mobileMedia.matches;
        collapsibleCards.forEach(function (detailsEl, index) {
            if (isMobile) {
                if (!detailsEl.hasAttribute('data-user-toggled')) {
                    const keepFirst = detailsEl.getAttribute('data-mobile-default-open') === 'true' && index === 0;
                    detailsEl.open = keepFirst;
                }
            } else {
                detailsEl.open = true;
            }
        });
        if (!isMobile && typeof window.closeMobileDrawer === 'function') {
            window.closeMobileDrawer();
        }
    }

    document.querySelectorAll('details[data-mobile-collapse] summary').forEach(function (summaryEl) {
        summaryEl.addEventListener('click', function (e) {
            if (!mobileMedia.matches) {
                e.preventDefault();
            } else {
                const detailsEl = summaryEl.closest('details');
                if (detailsEl) detailsEl.setAttribute('data-user-toggled', '1');
            }
        });
    });

    if (typeof mobileMedia.addEventListener === 'function') {
        mobileMedia.addEventListener('change', syncMobileAccordions);
    }
    syncMobileAccordions();

    // 5. Konfirmasi Dialog Aksi Krusial (Website Bottom-Sheet / Modal, bukan browser confirm)
    let pendingConfirmCallback = null;

    window.openGlobalConfirmModal = function (message, onConfirm) {
        const modal = document.getElementById('nurtura-global-confirm-modal');
        const msgEl = document.getElementById('nurtura-global-confirm-msg');
        if (!modal || !msgEl) {
            if (confirm(message)) onConfirm();
            return;
        }
        msgEl.textContent = message;
        pendingConfirmCallback = onConfirm;
        modal.style.display = 'flex';
        requestAnimationFrame(() => modal.classList.add('is-open'));
    };

    window.closeGlobalConfirmModal = function () {
        const modal = document.getElementById('nurtura-global-confirm-modal');
        if (modal) {
            modal.classList.remove('is-open');
            setTimeout(() => { modal.style.display = 'none'; }, 180);
        }
        pendingConfirmCallback = null;
    };

    const globalConfirmOkBtn = document.getElementById('nurtura-global-confirm-ok');
    if (globalConfirmOkBtn) {
        globalConfirmOkBtn.addEventListener('click', function () {
            const cb = pendingConfirmCallback;
            window.closeGlobalConfirmModal();
            if (typeof cb === 'function') cb();
        });
    }

    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (btn.dataset.confirmed === '1') {
                delete btn.dataset.confirmed;
                return;
            }
            e.preventDefault();
            const message = btn.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            window.openGlobalConfirmModal(message, function () {
                if (btn.tagName === 'A' && btn.href) {
                    window.location.href = btn.href;
                } else if (btn.form) {
                    if (btn.name) {
                        let hidden = btn.form.querySelector('input[type="hidden"][data-temp-submit="1"]');
                        if (!hidden) {
                            hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.setAttribute('data-temp-submit', '1');
                            btn.form.appendChild(hidden);
                        }
                        hidden.name = btn.name;
                        hidden.value = btn.value || '';
                    }
                    btn.form.submit();
                } else {
                    btn.dataset.confirmed = '1';
                    btn.click();
                }
            });
        });
    });

    // 6. Helper Toast Notification Global
    let toastTimer = null;
    window.showNurturaToast = function (message) {
        const toast = document.getElementById('nurtura-toast');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('is-shown');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('is-shown');
        }, 2600);
    };

    // 7. Reveal Engine (IntersectionObserver)
    const revealEls = document.querySelectorAll('[data-motion="reveal"]');
    if (revealEls.length > 0) {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.getAttribute('data-delay') || '0', 10);
                        setTimeout(() => {
                            entry.target.classList.add('is-revealed');
                        }, delay);
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.05, rootMargin: '0px 0px 40px 0px' });

            revealEls.forEach(el => observer.observe(el));
        } else {
            revealEls.forEach(el => el.classList.add('is-revealed'));
        }
    }

    // 8. Smooth Scroll Parallax Engine (Desktop Only, Mobile Reset)
    const parallaxEls = document.querySelectorAll('[data-parallax]');
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (parallaxEls.length > 0 && !prefersReducedMotion) {
        let ticking = false;
        function updateParallax() {
            if (mobileMedia.matches) {
                parallaxEls.forEach(el => { el.style.transform = 'none'; });
                ticking = false;
                return;
            }
            parallaxEls.forEach(el => {
                const speed = parseFloat(el.getAttribute('data-parallax') || '0.06');
                const rect = el.getBoundingClientRect();
                const offset = (rect.top + rect.height / 2 - window.innerHeight / 2) * speed;
                const clamped = Math.max(-28, Math.min(28, offset));
                el.style.transform = `translate3d(0, ${clamped.toFixed(2)}px, 0)`;
            });
            ticking = false;
        }
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }, { passive: true });
        updateParallax();
    }

    // 9. Drawer Parallax Stack (Desktop Only, Mobile Stacks Cleanly)
    const drawerWrapper = document.querySelector('.parallax-drawer-wrapper');
    const drawerBottom = document.querySelector('.parallax-drawer-bottom');
    if (drawerWrapper && drawerBottom && !prefersReducedMotion) {
        let drawerTicking = false;
        function updateDrawerParallax() {
            if (mobileMedia.matches) {
                drawerBottom.style.transform = 'none';
                drawerBottom.style.opacity = '1';
                drawerTicking = false;
                return;
            }
            const rect = drawerWrapper.getBoundingClientRect();
            const vh = window.innerHeight;
            const startY = vh * 0.92;
            const endY = vh * 0.36;
            let progress = (startY - rect.top) / (startY - endY);
            progress = Math.max(0, Math.min(1, progress));
            const eased = 1 - Math.pow(1 - progress, 3);
            const translateYPercent = (1 - eased) * -88;
            const opacity = 0.12 + eased * 0.88;
            drawerBottom.style.transform = `translate3d(0, ${translateYPercent.toFixed(2)}%, 0)`;
            drawerBottom.style.opacity = opacity.toFixed(3);
            drawerTicking = false;
        }
        window.addEventListener('scroll', () => {
            if (!drawerTicking) {
                window.requestAnimationFrame(updateDrawerParallax);
                drawerTicking = true;
            }
        }, { passive: true });
        updateDrawerParallax();
    }
});

// Modal Bukti Serah Terima Global
window.openProofModal = function (needId) {
    const modal = document.getElementById('proof-modal-global') || document.getElementById('proof-modal-' + needId);
    const image = document.getElementById('proof-image-global') || document.getElementById('proof-image-' + needId);
    const loading = document.getElementById('proof-loading-global') || document.getElementById('proof-loading-' + needId);
    if (!modal || !image || !loading) return;

    modal.classList.add('active');
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
        loading.textContent = 'Foto bukti bantuan belum tersedia atau gagal dimuat.';
        loading.style.display = 'block';
    };

    image.src = 'index.php?action=view-proof&need_id=' + encodeURIComponent(needId);
};

window.closeProofModal = function (needId) {
    const modal = document.getElementById('proof-modal-global') || document.getElementById('proof-modal-' + needId);
    if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
    }
};

// Escape Key Global Closing
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.proof-modal').forEach(function (modal) {
            modal.classList.remove('active');
            modal.style.display = 'none';
        });
        if (typeof window.closeKiaInspector === 'function') window.closeKiaInspector();
        if (typeof window.closeGlobalConfirmModal === 'function') window.closeGlobalConfirmModal();
        if (typeof window.closeMobileDrawer === 'function') window.closeMobileDrawer();
        if (typeof window.closeClinicalFactModal === 'function') window.closeClinicalFactModal();
        if (typeof window.closeIbuHamilDonateModal === 'function') window.closeIbuHamilDonateModal();
        if (typeof window.closeDisputeConfirmModal === 'function') window.closeDisputeConfirmModal();
    }
});

// Modal Inspeksi Buku KIA (Zoom & Rotate untuk Admin)
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

// Live Image Preview Helper (Dropzone)
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
