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
            <span>The money tracker I use every day. I spend in Ringgit, but part of my money is still in Rupiah back home. RafiFinance keeps both in one place, and a Telegram bot does most of the typing for me.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Live, in daily use</span></span><span class="p-meta-item"><span class="p-meta-k">Started</span><span class="p-meta-v">June 2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Version</span><span class="p-meta-v">v6.3</span></span></div><a href="https://finance.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">finance.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 Why I Built It</h3>
        <div class="blog-content-body">
<p class="p-text">I'm an Indonesian student at Universiti Malaya. Most days I pay with Touch 'n Go or Maybank. Money from home arrives in BCA, in Rupiah. I also have a student MRT card with its own balance and an expiry date.</p>
<p class="p-text">Most finance apps assume one currency. Sending Rupiah from BCA so it arrives as Ringgit in Maybank doesn't fit that model, so the totals stop matching the banks.</p>
<p class="p-text">So I wrote my own. <mark class="hl">The app is still one HTML file, with no framework and no build step.</mark></p>
        </div>
        <br>

        <h3>02 How It Grew</h3>
        <div class="blog-content-body">
<table>
<thead><tr><th>When</th><th>Version</th><th>What changed</th></tr></thead>
<tbody>
<tr><td>Jun 2026</td><td>v4</td><td>First version I shipped. Budgets, saving goals, bills and a health score, all in Rupiah. Also packaged as an Android app.</td></tr>
<tr><td>1 Jul 2026</td><td>fix</td><td>The app still opened on June. I had hardcoded the current month. Fixed it that day and bumped the service worker cache so phones picked up the update.</td></tr>
<tr><td>Sep 2026</td><td>v6</td><td>Wallets, each with its own currency. Ringgit and Rupiah side by side, live exchange rates, transit cards. Old v4 and v5 data migrates as Rupiah.</td></tr>
<tr><td>Oct 2026</td><td>v6.3</td><td>A small server at home. Sync between devices, bank notifications turned into transactions, and the Telegram bot.</td></tr>
</tbody>
</table>
        </div>
        <br>

        <h3>03 The App</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Screens from the current build. The numbers are demo data, not my accounts.</p>
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
<p class="p-text">A few details I care about. Amounts are never shortened, so it says <code class="inline">Rp 1,250,000</code>, not "1.2jt". Every wallet keeps its own currency, and only totals get converted. Exchange rates come straight from the phone, with two backup sources if the first one fails, and the last rate stays for offline use.</p>
        </div>
        <br>

        <h3>04 How It's Wired</h3>
        <div class="blog-content-body">
<p class="p-text">The app works on its own. Without the server, nothing leaves the phone. The server is an extra that runs on a mini PC at home.</p>
<div class="project-tree">finance.rafiarsya.com      <span class="pt-comment"># index.html on Cloudflare Pages</span>
   └── sync ──► finance-api.rafiarsya.com
                  └── Cloudflare Tunnel ──► mini PC
                        ├── sync     <span class="pt-comment"># three way merge</span>
                        ├── ingest   <span class="pt-comment"># bank notifications</span>
                        ├── bot      <span class="pt-comment"># Telegram, long polling</span>
                        └── SQLite   <span class="pt-comment"># backup every night</span></div>
<p class="p-text">The server has zero npm packages. It is Node 22 with its built in HTTP server and <code class="inline">node:sqlite</code>. It only listens on localhost, so the tunnel is the only way in. The bot polls Telegram from inside, so no port is open on my router.</p>
<p class="p-text">There are two tokens. The app token can do everything. The token on my phone's automation can only post notifications. Twenty wrong tokens in ten minutes and that IP is blocked for ten minutes.</p>
        </div>
        <br>

        <h3>05 The Telegram Bot</h3>
        <div class="blog-content-body">
<p class="p-text">Most of my entries don't go through the app anymore. They go through a private bot that only replies to my own chat.</p>
<figure class="rf-figure-lg"><img alt="The RafiFinance bot in Telegram: a backup file sent after /backup, a Rp 106,875 food payment recorded automatically with Batal, Kategori and Dompet buttons, and a BRI payment picked up from a notification" decoding="async" loading="lazy" src="image/assets/rafifinance/tg-bot.png"/><figcaption class="img-caption">The real bot. My balance line is blurred.</figcaption></figure>
<p class="p-text">To log something, I just type it the way I would say it. Amount, what it was, and the wallet. <code class="inline">rb</code> and <code class="inline">jt</code> work for Rupiah. If I leave the wallet out, it uses my default one.</p>
<table>
<thead><tr><th>I type</th><th>It records</th></tr></thead>
<tbody>
<tr><td><code class="inline">makan 12 tng</code></td><td>RM 12 out, Makan, Touch 'n Go</td></tr>
<tr><td><code class="inline">25rb bakso tunai rp</code></td><td>Rp 25,000 out, Rupiah cash</td></tr>
<tr><td><code class="inline">kiriman 2jt bca</code></td><td>Rp 2,000,000 in, Kiriman Ortu, BCA</td></tr>
<tr><td><code class="inline">topup tng 50 dari maybank</code></td><td>RM 50 moved from Maybank to TNG</td></tr>
<tr><td><code class="inline">tf 1jt bca ke maybank jadi 230</code></td><td>Rp 1,000,000 out of BCA, RM 230 into Maybank</td></tr>
</tbody>
</table>
<p class="p-text">And these are the commands.</p>
<table>
<thead><tr><th>Command</th><th>What it does</th></tr></thead>
<tbody>
<tr><td><code class="inline">/aman</code></td><td>How much I can still spend today, and how long the money lasts</td></tr>
<tr><td><code class="inline">/saldo</code></td><td>Balance of every wallet</td></tr>
<tr><td><code class="inline">/saldo bca 1.250.000</code></td><td>Sets a wallet to what the bank app shows. The gap is logged as an adjustment, not as spending</td></tr>
<tr><td><code class="inline">/hariini</code></td><td>Everything recorded today</td></tr>
<tr><td><code class="inline">/bulan</code></td><td>This month so far</td></tr>
<tr><td><code class="inline">/minggu</code></td><td>Last 7 days, compared with the week before</td></tr>
<tr><td><code class="inline">/inbox</code></td><td>Notifications still waiting for me to confirm</td></tr>
<tr><td><code class="inline">/batal</code></td><td>Undo the last thing the bot recorded</td></tr>
<tr><td><code class="inline">/otomatis on</code></td><td>Save clear notifications straight away instead of asking. New merchants and top ups still go to the inbox</td></tr>
<tr><td><code class="inline">/nama</code></td><td>My name as it appears on my bank accounts, so a transfer to myself is not counted as income</td></tr>
<tr><td><code class="inline">/default tng</code></td><td>Wallet used when I don't name one</td></tr>
<tr><td><code class="inline">/tes</code></td><td>Runs a fake bank notification through the parser. Nothing gets saved</td></tr>
<tr><td><code class="inline">/backup</code></td><td>Sends the whole database as a JSON file I can restore in the app</td></tr>
<tr><td><code class="inline">/help</code></td><td>The cheat sheet</td></tr>
</tbody>
</table>
<p class="p-text">It also messages me on its own. At 08:00 I get today's safe amount, bills due in the next three days and a warning if the MRT card is low. At 21:30 I get a recap of the day. On Sunday at 20:00 I get the week. If a budget crosses 80% or 100%, it tells me right then. A JSON backup lands in the chat every night at 03:00, in case the mini PC's disk dies.</p>
        </div>
        <br>

        <h3>06 Bank Notifications Become Transactions</h3>
        <div class="blog-content-body">
<p class="p-text">My banks don't offer an API to students. But every payment already pops up a notification on my phone. MacroDroid catches it and posts the text to the server. The two bottom messages in the bot screenshot above came in this way.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">One Notification</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Steps</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">1  MacroDroid posts it      app, title, text
2  drop the noise           OTP, TAC, login, promo, no amount,
                            same text again within 3 minutes
3  read it                  amount, currency, in or out, merchant
4  pick the wallet          from the app that sent it
5  guess the category       from what I saved last time
6  match transfers          out of one bank, into another,
                            same amount, within 15 minutes
7  inbox + Telegram         I tap Simpan, or fix it first</pre></div></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">TNG eWallet
"You have paid RM9.50 to ZUS COFFEE."

  type      expense
  amount    RM 9.50
  wallet    Touch 'n Go eWallet
  desc      ZUS COFFEE
  category  Jajan &amp; Kopi     (saved like this before)</pre></div></div></div></div></div>
<p class="p-text">Step 6 matters more than it looks. When I move money from Mandiri to BCA, Livin' tells me it left and myBCA tells me it arrived. Without matching, that is one fake expense and one fake income. With it, they become a single transfer.</p>
<p class="p-text">It reads MAE, Touch 'n Go, myBCA, Livin', BRImo, ShopeePay and Grab, because those are what I use. When a notification includes a balance, the bot compares it with the app and offers to fix the difference.</p>
        </div>
        <br>

        <h3>07 Sync Between Devices</h3>
        <div class="blog-content-body">
<p class="p-text">My phone, my laptop and the bot all write to the same data. If the last one to save simply won, I would lose entries. So the server compares three copies: what the device saw last time, what it sends now, and what the server has.</p>
<table>
<thead><tr><th>If an item was</th><th>Then</th></tr></thead>
<tbody>
<tr><td>changed on one side</td><td>that change is kept</td></tr>
<tr><td>changed on both sides</td><td>the device syncing now wins</td></tr>
<tr><td>deleted on one side, untouched on the other</td><td>it is deleted</td></tr>
<tr><td>deleted on one side, edited on the other</td><td>the edit is kept</td></tr>
</tbody>
</table>
<p class="p-text">This happens per item, so two new transactions from two devices never fight. The app syncs 2.5 seconds after a change and once a minute while it is open. Offline edits wait until there is signal. The server keeps the last 300 revisions.</p>
        </div>
        <br>

        <h3>08 The Two Numbers I Look At</h3>
        <div class="blog-content-body">
<p class="p-text">The first is what <code class="inline">/aman</code> shows every morning.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Safe to Spend Today</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Why</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">fromBalance = (daily wallets − unpaid bills this month) ÷ days left
fromBudget  = budget left this month ÷ days left

safeToday   = min(fromBalance, fromBudget) − spent today</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Rent and phone bills come out of the balance first, so they never look like free money. Taking the smaller of the two numbers stops a fresh transfer from home from feeling like permission to spend more. If I go over, the next days get a smaller amount on their own.</p></div></div></div></div>
<p class="p-text">The second is the health score on the Report page.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">03</span><span class="p-math-title">Health Score</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Demo Month</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">saving rate   up to 35   full marks at 30% of income saved
budget        up to 25   share of categories within budget
emergency     up to 20   full marks at 6 months of expenses
goals         up to 10   6 for progress, 4 for a deposit this month
bills         up to 10   minus 4 for every overdue bill

score = sum of the five, out of 100</pre></div></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">saved 40% of RM 1,200     35
6 of 6 budgets kept       25
2.8 months of expenses     9
goals 35%, deposit made    6
no overdue bills          10
                         ───
                          85   Sangat sehat</pre></div></div></div></div></div>
        </div>
        <br>

        <h3>09 What It Can't Do</h3>
        <div class="blog-content-body">
<p class="p-text">It can't read my bank. A balance is the opening amount plus everything recorded. If a notification never arrives, the number drifts. Once a week I check <code class="inline">/saldo</code> against the bank apps and fix any gap.</p>
<p class="p-text">Catching notifications needs Android. iPhones don't let one app read another app's notifications, so on iOS it is the app and the bot only.</p>
<p class="p-text">The parser only knows the seven apps above. A new bank needs a few real notification texts before it can be added.</p>
<p class="p-text">And it is built for one person. One token, one Telegram chat, no sign up. That is on purpose, but it means nobody else can use my server.</p>
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
<span class="badge blog-badge badge-neutral">Cloudflare Tunnel</span>
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
