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

        <figure class="p-hero"><img alt="RafiFinance on three phones: the monthly report, the home screen with Ringgit and Rupiah wallets, and the inbox of transactions read from bank notifications" decoding="async" src="image/assets/rafifinance/hero.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Vanilla JS</span>
                <span class="badge blog-badge badge-purple">PWA</span>
                <span class="badge blog-badge badge-green">Node.js</span>
                <span class="badge blog-badge badge-orange">SQLite</span>
                <span class="badge blog-badge badge-secondary">Telegram Bot</span>
                <span class="badge blog-badge badge-neutral">Cloudflare</span>
            </div>
            <h1>RafiFinance</h1>
            <br>
            <span>The money tracker I use every day. I spend in Ringgit, but part of my money is still in Rupiah back home.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Live, in daily use</span></span><span class="p-meta-item"><span class="p-meta-k">Started</span><span class="p-meta-v">June 2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Version</span><span class="p-meta-v">v6.3</span></span></div><a href="https://finance.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">finance.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">I pay in Ringgit in Malaysia while money from home arrives in Rupiah. RafiFinance keeps both in one place and shows what I can actually spend.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Two currencies</b>: Ringgit and Rupiah side by side, converted to one total</li>
<li><b>Telegram bot</b>: log a purchase with a quick message</li>
<li><b>Bank notifications</b>: payment alerts turn into transactions automatically</li>
<li><b>Synced everywhere</b>: phone, laptop and the bot share the same data</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
<div class="rf-livegroup">
<div class="cb-phones">
<figure><img alt="Home screen with the total balance in Ringgit, the Rupiah equivalent, and balance per wallet" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-home.png"/><figcaption><b>Home</b>All wallets, one total</figcaption></figure>
<figure><img alt="Transaction list grouped by day with search and filters" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-tx.png"/><figcaption><b>Transactions</b>Grouped by day</figcaption></figure>
<figure><img alt="Transfer of Rp 1,000,000 from BCA to Maybank, with RM 227.53 received" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-transfer.png"/><figcaption><b>Transfer</b>Rp out, RM in</figcaption></figure>
<figure><img alt="UM student MRT card with balance, concession expiry and a low balance reminder" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-card.png"/><figcaption><b>MRT card</b>Balance and expiry</figcaption></figure>
</div>
</div>
<div class="rf-livegroup">
<div class="cb-phones">
<figure><img alt="Monthly budget with a progress bar per category and a daily allowance" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-plan.png"/><figcaption><b>Budget</b>Per category</figcaption></figure>
<figure><img alt="Monthly report with a donut chart of spending by category" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-report.png"/><figcaption><b>Report</b>Where it went</figcaption></figure>
<figure><img alt="Health score of 85 with five factors" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-score.png"/><figcaption><b>Score</b>Out of 100</figcaption></figure>
<figure><img alt="Inbox of transactions read from bank notifications, each with confirm and dismiss buttons" decoding="async" loading="lazy" src="image/assets/rafifinance/phone-inbox.png"/><figcaption><b>Inbox</b>Waiting for a tap</figcaption></figure>
</div>
</div>
<figure class="rf-figure-lg"><img alt="The RafiFinance bot in Telegram: a backup file sent after /backup, a Rp 106,875 food payment recorded automatically with Batal, Kategori and Dompet buttons, and a BRI payment picked up from a notification" decoding="async" loading="lazy" src="image/assets/rafifinance/tg-bot.png"/><figcaption class="img-caption">The real bot. My balance line is blurred.</figcaption></figure>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Vanilla JavaScript</span>
<span class="badge blog-badge badge-neutral">PWA</span>
<span class="badge blog-badge badge-neutral">Service Worker</span>
<span class="badge blog-badge badge-neutral">localStorage</span>
<span class="badge blog-badge badge-neutral">SVG charts</span>
<span class="badge blog-badge badge-neutral">Android TWA</span>
<span class="badge blog-badge badge-neutral">Node.js 22</span>
<span class="badge blog-badge badge-neutral">node:sqlite</span>
<span class="badge blog-badge badge-neutral">Telegram Bot API</span>
<span class="badge blog-badge badge-neutral">MacroDroid</span>
<span class="badge blog-badge badge-neutral">Docker Compose</span>
<span class="badge blog-badge badge-neutral">Cloudflare Pages</span>
</div>
</div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://finance.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">finance.rafiarsya.com</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07/rafifinance" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
<span class="p-link-btn-label">GitHub</span>
</a>
</div>
        <br>

        <div class="d-flex">
            <a href="/project" class="btn btn-main button-border d-flex align-items-center">
                <span class="menu-icon"><back-icon class="menu-icon-data"></back-icon></span>
                <span>All Projects</span>
            </a>
        </div>
        <br>
        <div class="text-center text-silent text14">
            &#169; MUHAMMAD RAFI ARSYA
        </div>
        <br>
    </div>
</div>
