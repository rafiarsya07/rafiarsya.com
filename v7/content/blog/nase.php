<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">Accessibility</span><span class="badge blog-badge badge-green">WCAG 2.1</span><span class="badge blog-badge badge-purple">Volunteering</span><span class="badge blog-badge badge-orange">2025</span></div>
        <h1>NASE: Building an Accessibility Tool for Real Users</h1>
        <br>
        <span>A bilingual, screen-reader-friendly web tool for Malaysia’s National Association of Special Education: now actively used by people with disabilities, referenced in NASE’s own journal, and validated by direct testimonials from the disabled users it was built for.</span>
        <br>
        <span style="font-weight: lighter">2025 &middot; </span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>Who It's For</h3>
        <div class="blog-content-body">
<p>This project was never for a portfolio. It was built for the <strong>National Association of Special Education (NASE)</strong> in Malaysia, and for an audience most of the web quietly forgets: people with visual impairments and other disabilities who rely on assistive technology to use a website at all.</p>
                            <p>That single fact rewrote every decision I would normally make on autopilot. When your real users navigate by keyboard, listen instead of read, and need high contrast just to perceive the screen, accessibility stops being a feature you sprinkle on at the end. It becomes the <em>entire specification</em>, the thing every other choice has to serve.</p>
                            The tool is now genuinely in use by people with disabilities, referenced in NASE’s journal, and has received direct testimonials from the disabled users it was built for. That’s the part I’m proudest of, not the code, but that real people who are usually designed around instead of designed for now rely on it.
                            <p>Over the next sessions I'll walk through how that audience shaped the build: the barriers I had to remove, how I engineered text-to-speech with synchronized highlighting, how four languages share one codebase, the high-contrast and scaling systems, keyboard and screen-reader support, what WCAG actually demanded in practice, and, most importantly, the real-world impact and what came back from the people who use it.</p>
        </div>
        <br>
        <h3>What Changed</h3>
        <div class="blog-content-body">
<img class="blog-img" alt="About page in high-contrast mode, toolbar pinned to the header" decoding="async" loading="lazy" src="image/assets/nase/about-us.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> About page in high-contrast mode, toolbar pinned to the header<img class="blog-img" alt="The committee table, dense data that still had to hold at 200% zoom" decoding="async" loading="lazy" src="image/assets/nase/our-team.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> The committee table, dense data that still had to hold at 200% zoom<img class="blog-img" alt="Membership tiers, fees and downloadable forms" decoding="async" loading="lazy" src="image/assets/nase/membership2.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> Membership tiers, fees and downloadable forms<img class="blog-img" alt="Contact page with labelled fields and a visible focus order" decoding="async" loading="lazy" src="image/assets/nase/contact-us.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> Contact page with labelled fields and a visible focus order<video controls="" loop="" playsinline="" preload="metadata" src="image/assets/nase/nase-demo.mp4"></video><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg> The accessibility toolbar in use across the site
        </div>
        <br>
    <br>
</div>
