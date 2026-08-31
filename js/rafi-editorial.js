/* ============================================================
   rafi-editorial.js
   Sidebar drawer · skill tabs · location toggle · scroll reveal
   Replaces script.js + the inline handlers for the editorial build.
   ============================================================ */
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── SIDEBAR DRAWER ─────────────────────────────────── */
    function initDrawer() {
        var sidebar = document.querySelector('.sidebar');
        var overlay = document.getElementById('sidebar-overlay');
        var openBtn = document.getElementById('hamburger-btn');
        var closeBtn = document.getElementById('sidebar-close-btn');
        if (!sidebar) return;

        function open() {
            sidebar.classList.add('open');
            if (overlay) overlay.classList.add('open');
            if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
        function close() {
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('open');
            if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', open);
        if (closeBtn) closeBtn.addEventListener('click', close);
        if (overlay) overlay.addEventListener('click', close);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) close();
        });

        // Close after tapping a link on mobile
        sidebar.addEventListener('click', function (e) {
            if (e.target.closest('a') && window.innerWidth <= 900) close();
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 900) close();
        });
    }

    /* ── SKILL TABS ─────────────────────────────────────── */
    function initSkillTabs() {
        var btns = document.querySelectorAll('.skill-tab-btn');
        var panels = document.querySelectorAll('.skill-tab-panel');
        if (!btns.length) return;

        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                btns.forEach(function (b) {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                panels.forEach(function (p) { p.classList.remove('active'); });

                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                var target = document.querySelector(
                    '.skill-tab-panel[data-panel="' + btn.dataset.tab + '"]'
                );
                if (target) target.classList.add('active');
            });
        });
    }

    /* ── LOCATION TOGGLE ────────────────────────────────── */
    var locations = {
        kl: {
            src: 'https://maps.google.com/maps?q=Kuala+Lumpur,+Malaysia&z=11&output=embed',
            label: 'Kuala Lumpur, Malaysia'
        },
        pkb: {
            src: 'https://maps.google.com/maps?q=0.5070677,101.4477793&z=12&output=embed',
            label: 'Pekanbaru, Riau, Indonesia'
        }
    };
    var currentLocation = 'kl';

    function toggleLocation() {
        currentLocation = currentLocation === 'kl' ? 'pkb' : 'kl';

        var iframe = document.getElementById('map-iframe');
        var labelText = document.getElementById('map-label-text');
        var track = document.getElementById('loc-toggle-track');
        var left = document.getElementById('loc-label-left');
        var right = document.getElementById('loc-label-right');
        if (!iframe || !track || !left || !right) return;

        iframe.src = locations[currentLocation].src;
        if (labelText) labelText.textContent = locations[currentLocation].label;

        var isSecondary = currentLocation === 'pkb';
        track.classList.toggle('toggled', isSecondary);
        left.style.color = isSecondary ? 'var(--ink-3)' : 'var(--ink)';
        right.style.color = isSecondary ? 'var(--ink)' : 'var(--ink-3)';
    }
    window.toggleLocation = toggleLocation;

    function initLocationToggle() {
        var wrap = document.querySelector('.loc-toggle-wrap');
        if (!wrap) return;
        wrap.setAttribute('role', 'switch');
        wrap.setAttribute('tabindex', '0');
        wrap.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleLocation();
            }
        });
    }

    /* ── SCROLL REVEAL + MARKER SWEEP ───────────────────── */
    function initReveal() {
        var items = document.querySelectorAll('.reveal');
        if (!items.length) return;

        if (reduced || !('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('is-in'); });
            return;
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                io.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

        items.forEach(function (el) { io.observe(el); });
    }

    /* ── SCROLL PROGRESS ────────────────────────────────── */
    function initProgress() {
        var bar = document.getElementById('rafi-bar');
        if (!bar) return;
        var ticking = false;

        function update() {
            var doc = document.documentElement;
            var max = doc.scrollHeight - doc.clientHeight;
            var pct = max > 0 ? (window.scrollY / max) * 100 : 0;
            bar.style.width = pct + '%';
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }, { passive: true });

        update();
    }

    /* ── BROKEN IMAGE FALLBACK ──────────────────────────── */
    function initImageFallback() {
        document.querySelectorAll('.entry-logo img').forEach(function (img) {
            img.addEventListener('error', function () {
                var wrap = img.parentElement;
                if (!wrap) return;
                var initials = (img.getAttribute('alt') || '?')
                    .split(/\s+/).map(function (w) { return w[0]; })
                    .join('').slice(0, 3).toUpperCase();
                var box = document.createElement('div');
                box.className = 'entry-logo-text';
                box.textContent = initials;
                wrap.replaceWith(box);
            });
        });
    }

    function boot() {
        initDrawer();
        initSkillTabs();
        initLocationToggle();
        initReveal();
        initProgress();
        initImageFallback();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
