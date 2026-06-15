/* ── HAMBURGER MENU ─────────────────────── */
(function () {
    function initHamburger() {
        const btn     = document.getElementById('hamburger-btn');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (!btn || !sidebar || !overlay) return;

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('visible');
            btn.classList.add('open');
            btn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('visible');
            btn.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        btn.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });

        overlay.addEventListener('click', closeSidebar);

        // Close when a nav link is tapped (mobile UX)
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    setTimeout(closeSidebar, 50);
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHamburger);
    } else {
        initHamburger();
    }
})();

/* ── SKILLS TABS ────────────────────────── */
(function () {
    function initSkillsTabs() {
        const skillTabs       = document.querySelectorAll('.skills-tab');
        const skillCategories = document.querySelectorAll('.skill-category');

        if (!skillTabs.length) return;

        function setActiveSkillTab(selectedTab) {
            skillTabs.forEach(tab => {
                tab.classList.toggle('active', tab === selectedTab);
            });

            const targetCategory = selectedTab.dataset.tab;
            skillCategories.forEach(category => {
                category.classList.toggle('active', category.dataset.category === targetCategory);
            });
        }

        skillTabs.forEach(tab => {
            tab.addEventListener('click', () => setActiveSkillTab(tab));
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSkillsTabs);
    } else {
        initSkillsTabs();
    }
})();

/* ── SKILLS TAB NAV (home page) ─────────── */
(function () {
    function initSkillTabNav() {
        const skillTabBtns   = document.querySelectorAll('.skill-tab-btn');
        const skillTabPanels = document.querySelectorAll('.skill-tab-panel');

        if (!skillTabBtns.length) return;

        skillTabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                skillTabBtns.forEach(b => b.classList.remove('active'));
                skillTabPanels.forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                const target = btn.dataset.tab;
                document.querySelector(`.skill-tab-panel[data-panel="${target}"]`)?.classList.add('active');
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSkillTabNav);
    } else {
        initSkillTabNav();
    }
})();

/* ── LOCATION SWITCHER ──────────────────── */
const locations = {
    kk13: {
        src: 'https://maps.google.com/maps?q=3.1202772,101.6398835&z=17&output=embed',
        label: 'KK13 · Kuala Lumpur, Malaysia'
    },
    pkb: {
        src: 'https://maps.google.com/maps?q=0.5070677,101.4477793&z=12&output=embed',
        label: 'Pekanbaru, Riau, Indonesia'
    }
};

/* ── LOCATION TOGGLE ────────────────────── */
let currentLocation = 'kk13';

function toggleLocation() {
    currentLocation = currentLocation === 'kk13' ? 'pkb' : 'kk13';

    const iframe      = document.getElementById('map-iframe');
    const labelText   = document.getElementById('map-label-text');
    const track       = document.getElementById('loc-toggle-track');
    const leftLabel   = document.getElementById('loc-label-left');
    const rightLabel  = document.getElementById('loc-label-right');

    // FIX: guard all required elements, not just iframe
    if (!iframe || !track || !leftLabel || !rightLabel) return;

    iframe.src = locations[currentLocation].src;
    if (labelText) labelText.textContent = locations[currentLocation].label;

    if (currentLocation === 'pkb') {
        track.classList.add('toggled');
        leftLabel.style.color  = '#9ca3af';
        rightLabel.style.color = '#111827';
    } else {
        track.classList.remove('toggled');
        leftLabel.style.color  = '#111827';
        rightLabel.style.color = '#9ca3af';
    }
}

/* ── PREFETCH INTERNAL LINKS ────────────── */
function prefetchInternalLinks() {
    const internalUrls = Array.from(document.querySelectorAll('a[href]'))
        .map(link => {
            try {
                return new URL(link.href, location.href);
            } catch {
                return null;
            }
        })
        .filter(url =>
            url &&
            url.origin === location.origin &&
            url.pathname !== location.pathname &&
            !url.hash &&
            url.protocol.startsWith('http')
        )
        .map(url => url.href);

    [...new Set(internalUrls)].forEach(href => {
        if (!document.querySelector(`link[rel="prefetch"][href="${href}"]`)) {
            const prefetchLink = document.createElement('link');
            prefetchLink.rel  = 'prefetch';
            prefetchLink.as   = 'document';
            prefetchLink.href = href;
            document.head.appendChild(prefetchLink);
        }
    });
}

document.addEventListener('DOMContentLoaded', prefetchInternalLinks);

/* ── CONTACT FORM ───────────────────────── */
(function () {
    /* Guard: only run on contact page */
    const form = document.getElementById('cf-form');
    if (!form) return;

    const FORMSUBMIT_URL = 'https://formsubmit.co/ajax/rafiarsya.work@gmail.com';

    const nameEl  = document.getElementById('cf-name');
    const emailEl = document.getElementById('cf-email');
    const subjEl  = document.getElementById('cf-subject');
    const msgEl   = document.getElementById('cf-message');
    const btn     = document.getElementById('cf-send-btn');
    const overlay = document.getElementById('cf-success-overlay');

    // FIX: guard all critical form elements before proceeding
    if (!nameEl || !emailEl || !subjEl || !msgEl || !btn || !overlay) return;

    // FIX: cache btn-label and btn-sending once instead of querying repeatedly
    const btnLabel   = btn.querySelector('.btn-label');
    const btnSending = btn.querySelector('.btn-sending');

    /* ── VALIDATION ── */
    function validate() {
        let ok = true;
        const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const checks = [
            { el: nameEl,  errId: 'err-name',    msg: 'Name is required.' },
            { el: emailEl, errId: 'err-email',   msg: 'Email is required.',
              extra: () => !emailRx.test(emailEl.value.trim()) ? 'Please enter a valid email.' : '' },
            { el: subjEl,  errId: 'err-subject', msg: 'Subject is required.' },
            { el: msgEl,   errId: 'err-message', msg: 'Message cannot be empty.' },
        ];

        checks.forEach(({ el, errId, msg, extra }) => {
            const errEl = document.getElementById(errId);
            if (!errEl) return;
            el.classList.remove('error');
            errEl.textContent = '';
            if (!el.value.trim()) {
                el.classList.add('error');
                errEl.textContent = msg;
                ok = false;
            } else if (extra) {
                const extraMsg = extra();
                if (extraMsg) {
                    el.classList.add('error');
                    errEl.textContent = extraMsg;
                    ok = false;
                }
            }
        });
        return ok;
    }

    /* ── CONFETTI ── */
    function spawnConfetti() {
        const container = document.getElementById('cf-confetti');
        if (!container) return;
        container.innerHTML = '';
        const colors = ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#a855f7', '#ec4899'];
        for (let i = 0; i < 18; i++) {
            const dot   = document.createElement('div');
            dot.className = 'cf-dot';
            const angle = (i / 18) * 360;
            const dist  = 38 + Math.random() * 28;
            const rad   = angle * Math.PI / 180;
            dot.style.setProperty('--tx', Math.cos(rad) * dist + 'px');
            dot.style.setProperty('--ty', Math.sin(rad) * dist + 'px');
            dot.style.background    = colors[i % colors.length];
            dot.style.animationDelay = (Math.random() * 0.2) + 's';
            container.appendChild(dot);
        }
    }

    /* ── SHOW SUCCESS ── */
    function showSuccess(name, email, subject) {
        spawnConfetti();
        const metaEl = document.getElementById('cf-success-meta');
        if (metaEl) {
            metaEl.innerHTML =
                `<span>To</span> rafiarsya.work@gmail.com<br>` +
                `<span>From</span> ${name} &lt;${email}&gt;<br>` +
                `<span>Subject</span> ${subject}`;
        }
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    /* ── RESET ── */
    window.resetContactForm = function () {
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        form.reset();
        btn.classList.remove('loading');
        if (btnLabel)   btnLabel.style.display   = 'inline-flex';
        if (btnSending) btnSending.style.display = 'none';
    };

    /* ── SUBMIT ── */
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!validate()) return;

        // Loading state
        btn.classList.add('loading');
        if (btnLabel)   btnLabel.style.display   = 'none';
        if (btnSending) btnSending.style.display = 'inline-flex';

        const payload = new FormData(form);
        payload.set('_replyto', emailEl.value.trim());

        try {
            const res = await fetch(FORMSUBMIT_URL, {
                method: 'POST',
                body: payload,
                headers: { 'Accept': 'application/json' }
            });

            if (!res.ok) {
                throw new Error('Network response ' + res.status);
            }

            const data = await res.json();

            if (data.success === 'true' || data.success === true) {
                showSuccess(nameEl.value.trim(), emailEl.value.trim(), subjEl.value.trim());
            } else {
                throw new Error('FormSubmit returned: ' + JSON.stringify(data));
            }
        } catch (err) {
            console.error('[FormSubmit]', err);
            btn.classList.remove('loading');
            if (btnLabel)   btnLabel.style.display   = 'inline-flex';
            if (btnSending) btnSending.style.display = 'none';
            alert('Oops! Something went wrong. Please email me directly at rafiarsya.work@gmail.com');
        }
    });

    /* ── ENTER KEY NAV ── */
    [nameEl, emailEl, subjEl].forEach((input, idx, arr) => {
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                (arr[idx + 1] || msgEl).focus();
            }
        });
    });

    /* ── CLOSE OVERLAY ON BG CLICK ── */
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) window.resetContactForm();
    });
})();