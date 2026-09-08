<div class="sticky-top d-flex align-items-center">
    <div class="burger-icon">
        <button type="button" class="btn btn-main d-flex justify-content-between align-items-center"
            onclick="burgerToogle()">
            <menu-icon class="burger-icon-data"></menu-icon>
        </button>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="mdcontent">

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Accessibility</span>
                <span class="badge blog-badge badge-green">WCAG 2.1 AA</span>
                <span class="badge blog-badge badge-purple">HCI Course</span>
                <span class="badge blog-badge badge-orange">Python + OpenCV</span>
                <span class="badge blog-badge badge-neutral">Figma</span>
                <span class="badge blog-badge badge-blue">Screen Reader</span>
            </div>
            <h1>NASE Accessibility</h1>
            <br>
            <span>A full accessibility audit and redesign of the NASE platform for visually impaired users. 23 issues found, categorised by WCAG 2.1 severity, with redesigned components and an AI-powered contrast analysis pipeline.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2025</span></span><span class="p-meta-item"><span class="p-meta-k">Context</span><span class="p-meta-v">HCI Course, UM</span></span><span class="p-meta-item"><span class="p-meta-k">Standard</span><span class="p-meta-v">WCAG 2.1 AA</span></span></div><a href="https://hci.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">hci.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>NASE Accessibility</strong> started as an HCI course project, but quickly became something more personal. I audited the NASE platform, a digital tool used by visually impaired students in Malaysia.</p>
<p>The goal: find every barrier that prevents a visually impaired user from navigating the platform independently, categorise each issue by WCAG 2.1 severity, and produce a redesigned prototype that passes AA compliance.</p>

<strong>What I realised doing this:</strong> Accessibility failures aren't abstract. A missing ARIA label means a screen reader says "button" with no context. Low contrast means the text literally disappears. This project was about making a real platform actually usable.
        </div>
        <br>
        <h3>02 Interface</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The NASE site after the accessibility pass. The persistent toolbar in the header carries the controls that do the work: text resizing, contrast modes, and spacing adjustments that hold across every page.</p><figure class="rf-figure rf-crop"><img class="blog-img" alt="About page in high-contrast mode with the toolbar pinned to the header" decoding="async" loading="lazy" src="image/assets/nase/about-us.png"/><figcaption class="img-caption"><b>About</b>: About page in high-contrast mode with the toolbar pinned to the header</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Committee table, a dense data view that had to stay readable at 200% zoom" decoding="async" loading="lazy" src="image/assets/nase/our-team.png"/><figcaption class="img-caption"><b>Our team</b>: Committee table, a dense data view that had to stay readable at 200% zoom</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Membership call to action" decoding="async" loading="lazy" src="image/assets/nase/membership.png"/><figcaption class="img-caption"><b>Membership</b>: Membership call to action</figcaption></figure><figure class="rf-figure rf-crop rf-portrait"><img class="blog-img" alt="Application tiers, fees and downloadable forms" decoding="async" loading="lazy" src="image/assets/nase/membership2.png"/><figcaption class="img-caption"><b>Apply</b>: Application tiers, fees and downloadable forms</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Contact page, labelled fields and visible focus order" decoding="async" loading="lazy" src="image/assets/nase/contact-us.png"/><figcaption class="img-caption"><b>Contact</b>: Contact page, labelled fields and visible focus order</figcaption></figure><figure class="rf-figure"><video controls="" loop="" playsinline="" preload="metadata" src="image/assets/nase/nase-demo.mp4"></video><figcaption class="img-caption"><b>Demo</b>: The accessibility toolbar in use across the site</figcaption></figure>
        </div>
        <br>
        <h3>03 Accessibility Audit, Issues Found</h3>
        <div class="blog-content-body">
<p><strong><mark class="hl">23 issues</mark></strong> identified across 5 pages of the NASE platform, categorised by WCAG 2.1 severity:</p>

● High Severity
Missing ARIA labels on interactive controls, screen readers announce "button" with no context. Affected: 6 buttons across 3 pages.

● High Severity
No keyboard focus indicators. Keyboard-only users cannot see which element is focused. Tab order undefined on form pages.

● Medium Severity
Contrast ratio of 2.4:1 on primary text (WCAG requires <mark class="hl">4.5:1</mark> for AA). Body text on light backgrounds fails on Contact and About pages.

● Medium Severity
Images missing <code class="inline">alt</code> attributes. 14 decorative images and 3 informational images lack alt text, screen readers skip or misread them.

● Low Severity
Form inputs missing associated <code class="inline">&lt;label&gt;</code> elements, screen readers read placeholder text only, which disappears on input focus.

● Low Severity
Heading hierarchy skips levels (H1 → H4). Screen reader navigation by headings produces a confusing jump in structure.
        </div>
        <br>
        <h3>04 WCAG 2.1 Criteria Addressed</h3>
        <div class="blog-content-body">
1.1.1
Non-text Content, all images given descriptive alt text or marked <code class="inline">role="presentation"</code>
PASS

1.3.1
Info and Relationships, semantic HTML5 elements used throughout, ARIA landmark roles added
PASS

1.4.3
Contrast (Minimum), text contrast raised to ≥<mark class="hl">4.5:1</mark> everywhere via AI contrast pipeline
PASS

2.1.1
Keyboard, all controls reachable and operable via keyboard only, focus order logical
PASS

2.4.3
Focus Order, tab order follows visual reading flow left→right top→bottom
PASS

4.1.2
Name, Role, Value, all interactive elements have accessible names via aria-label or visible text
PASS
        </div>
        <br>
        <h3>05 AI-Powered Contrast Analysis Pipeline</h3>
        <div class="blog-content-body">
<p>Manual contrast checking is slow. I built a Python pipeline using <strong>OpenCV and TensorFlow</strong> to automatically detect text regions, extract foreground/background colours, and calculate contrast ratios across every page screenshot.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">WCAG Contrast Ratio Formula</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">L = 0.2126 × R + 0.7152 × G + 0.0722 × B
    (where R, G, B are linearised sRGB channels in [0, 1])

contrast_ratio = (L1 + 0.05) / (L2 + 0.05)
                  (L1 = lighter color, L2 = darker color)

WCAG AA  requires ratio ≥ 4.5:1   (normal text)
WCAG AAA requires ratio ≥ 7:1     (normal text)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The 0.2126 / 0.7152 / 0.0722 weights aren't arbitrary, they come from the relative luminance the human eye perceives per channel, with green contributing far more to perceived brightness than blue. The "+0.05" offset in the ratio formula accounts for ambient screen glow so the formula never divides by something close to zero on a true black background. Run against every text/background pair on the site, this is what decided which color combinations were usable before a single line of the design was finalised.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Body text #374151 on background #FFFFFF

R,G,B (linearised) for #374151 ≈ 0.035, 0.054, 0.075
L1 = 0.2126(0.035) + 0.7152(0.054) + 0.0722(0.075)
   ≈ 0.052

R,G,B (linearised) for #FFFFFF = 1, 1, 1
L2 = 1.0

contrast_ratio = (1.0 + 0.05) / (0.052 + 0.05)
               ≈ 10.3: 1

→ passes WCAG AAA (≥ 7:1) for normal text</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>06 Design Principles Applied</h3>
        <div class="blog-content-body">
<ul><li><b>Operable: Full keyboard navigability</b>: Every interactive element is keyboard reachable. Visible focus outlines on all controls. Tab order follows the visual reading flow. No keyboard traps.</li>
<li><b>Understandable: Consistent, labeled UI</b>: All form inputs have visible labels. Error messages explain what is wrong and how to fix it. Navigation is consistent across all redesigned pages.</li>
<li><b>Reliable: Semantic HTML + ARIA</b>: All redesigned pages use semantic HTML5. Interactive elements have explicit ARIA roles. Tested with NVDA screen reader and keyboard-only navigation.</li></ul>
        </div>
        <br>
        <h3>07 Use Cases &amp; Impact</h3>
        <div class="blog-content-body">
<ul><li><b>Screen Reader Users</b>: NVDA/VoiceOver can now navigate the platform with meaningful announcements at every interactive element.</li>
<li><b>Keyboard-Only Navigation</b>: Users who cannot use a mouse can tab through every control with visible focus and logical ordering.</li>
<li><b>Low Vision Users</b>: <mark class="hl">4.5:1</mark>+ contrast on all text means content is readable even with visual impairments or in bright environments.</li>
<li><b>Mobile Accessibility</b>: Redesigned components tested with iOS VoiceOver, touch targets meet minimum 44×44px requirements.</li></ul>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">JavaScript</span>
<span class="badge blog-badge badge-neutral">ARIA</span>
<span class="badge blog-badge badge-neutral">Python</span>
<span class="badge blog-badge badge-neutral">OpenCV</span>
<span class="badge blog-badge badge-neutral">TensorFlow</span>
<span class="badge blog-badge badge-neutral">Figma</span>
<span class="badge blog-badge badge-neutral">NVDA</span>
<span class="badge blog-badge badge-neutral">WCAG 2.1</span>
</div>
        </div>
        <br>
        <div class="d-flex">
            <a href="/project" class="btn btn-main button-border d-flex align-items-center">
                <span class="menu-icon"><back-icon class="menu-icon-data"></back-icon></span>
                <span>All Projects</span>
            </a>
        </div>
        <br><br>
    </div>
</div>
