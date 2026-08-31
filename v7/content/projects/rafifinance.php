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
                <span class="badge blog-badge badge-blue">Vanilla JS</span>
                <span class="badge blog-badge badge-green">Single HTML File</span>
                <span class="badge blog-badge badge-purple">PWA</span>
                <span class="badge blog-badge badge-orange">localStorage</span>
                <span class="badge blog-badge badge-neutral">Service Worker</span>
                <span class="badge blog-badge badge-blue">Cloudflare Pages</span>
            </div>
            <h1>RafiFinance</h1>
            <br>
            <span>A complete personal finance tracker built as a single HTML file. No server, no database, no framework. Transactions, budgets, saving goals, health score, 6-month analysis, works offline as a PWA.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed, Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Type</span><span class="p-meta-v">Personal Tool, v4</span></span><span class="p-meta-item"><span class="p-meta-k">File Size</span><span class="p-meta-v">1 HTML file</span></span></div><a href="https://finance.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">finance.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>RafiFinance v4</strong> is a finance tracker I built because every other option was either too complicated, required an account, or did something weird with my data. So I made my own, in a single HTML file.</p>
<p class="p-text">So I built my own under one constraint: a single HTML file, no npm, no build step, no server, no framework. Data stays on the device in localStorage under <code class="inline">rfv4</code>, exportable as JSON at any time.</p>

<strong>The single-file constraint made me better at JavaScript.</strong> When you can't hide behind imports and abstractions, you actually have to know what you're doing. Every feature had to earn its place, nothing's in there by accident.
                                
<p>Deployed on <strong>Cloudflare Pages</strong> at finance.rafiarsya.com, free hosting, global CDN, automatic HTTPS, zero config. The PWA service worker is generated as a Blob URL at runtime, so even the offline capability requires no external files.</p>
        </div>
        <br>
        <h3>02 Screens</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The whole app is one HTML file, installed to the home screen as a PWA. These are the screens I actually use day to day.</p><figure class="rf-figure rf-phone"><img class="blog-img" alt="Dashboard" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance1.png"/><figcaption class="img-caption"><b>Home</b>: Dashboard</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Transaction entry" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance2.png"/><figcaption class="img-caption"><b>Add</b>: Transaction entry</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Category breakdown" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance3.png"/><figcaption class="img-caption"><b>Categories</b>: Category breakdown</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Spending over time" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance4.png"/><figcaption class="img-caption"><b>Trends</b>: Spending over time</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Financial health score" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance5.png"/><figcaption class="img-caption"><b>Score</b>: Financial health score</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Budget targets" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance6.png"/><figcaption class="img-caption"><b>Budgets</b>: Budget targets</figcaption></figure><figure class="rf-figure rf-phone"><img class="blog-img" alt="Settings and data export" decoding="async" loading="lazy" src="image/assets/rafifinance/foto-finance7.png"/><figcaption class="img-caption"><b>Settings</b>: Settings and data export</figcaption></figure>
        </div>
        <br>
        <h3>03 Features</h3>
        <div class="blog-content-body">
<ul><li><b>Budget Tracking</b>: Set monthly budgets per category with visual progress bars. Over-budget alerts and spend rate indicators. Resets automatically each month.</li>
<li><b>Saving Goals with Smart Estimation</b>: Set a target amount and a deadline date. The app calculates the required monthly savings to hit the goal on time, and tracks progress in real time as you add transactions.</li>
<li><b>Recurring Reminders</b>: Set browser notifications for bills, subscriptions, and recurring payments. Configurable frequency (daily, weekly, monthly). Uses the Notifications API, works offline.</li>
<li><b>6-Month Trend Analysis</b>: Visual income vs expense comparison across 6 months. Spending breakdown by category. Identifies which months were over-budget and by how much.</li>
<li><b>Financial Health Score (0:100)</b>: A real-time composite score based on savings rate, budget adherence, and goal progress. Updates live as you add data, no manual calculation needed.</li></ul>
        </div>
        <br>
        <h3>04 Financial Health Score, The Math</h3>
        <div class="blog-content-body">
<p>The health score is a <strong>weighted composite</strong> of three independent signals about your financial habits:</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Health Score Formula</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">score = (savingsRate × 0.4)
      + (budgetAdherence × 0.35)
      + (goalProgress × 0.25)

-- savingsRate (0: 100):
   savings    = totalIncome - totalExpenses
   rate       = savings / totalIncome × 100
   normalized = clamp(rate / 20 × 100, 0, 100)
   -- saving 20% of income = 100 points

-- budgetAdherence (0: 100):
   for each category with a budget:
     adherence_i = clamp(1 - overspend_i/budget_i, 0, 1)
   budgetAdherence = mean(adherence_i) × 100

-- goalProgress (0: 100):
   for each saving goal:
     progress_i = saved_i / target_i
   goalProgress = mean(progress_i) × 100

score = clamp(score, 0, 100)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The weights reflect real priorities. Savings rate carries the most (<strong>40%</strong>) because a buffer is the foundation. Budget adherence (<strong>35%</strong>) prevents spending creep. Goal progress (<strong>25%</strong>) weighs least, having no active goal shouldn't tank an otherwise healthy score.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Monthly income RM 3,000, expenses RM 2,400
savings = 3000 to 2400 = 600
rate = 600/3000 × 100 = 20%
savingsRate (normalized) = clamp(20/20 × 100) = 100

# Budgets: Food RM400 (spent 380), Transport RM150 (spent 165)
adherence_food      = clamp(1 - 0/400, 0, 1)   = 1.00
adherence_transport = clamp(1 - 15/150, 0, 1)  = 0.90
budgetAdherence = mean(1.00, 0.90) × 100 = 95

# One goal: 1200/5000 saved
goalProgress = (1200/5000) × 100 = 24

score = 100×0.4 + 95×0.35 + 24×0.25
      = 40 + 33.25 + 6
      = 79.25  →  79 / 100</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Saving Goal: Monthly Target Calculation</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">monthsRemaining = (deadline.year - today.year) × 12
                + (deadline.month - today.month)

monthlyRequired = (targetAmount - savedSoFar) / monthsRemaining</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The calculation updates live as transactions land. Overshoot one month and the next target drops; fall behind and the remaining months absorb a slightly higher target. It always shows the shortest path to the goal, not a plan fixed once and forgotten.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Goal: Save RM 5,000 for a laptop
savedSoFar  = RM 1,200
deadline    = 8 months from today

monthlyRequired = (5000 to 1200) / 8
                = 3800 / 8
                = RM 475 / month

# After month 1, saved an extra RM 600 (RM 1,075 total):
monthsRemaining = 7
monthlyRequired = (5000 to 1075) / 7
                = RM 560.71 / month  ← recalculated automatically</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>05 Single-File Architecture &amp; PWA</h3>
        <div class="blog-content-body">
<p>The entire app, HTML structure, ~800 lines of CSS, ~1800 lines of vanilla JavaScript, lives in <strong><mark class="hl">one HTML file</mark></strong>. All state is managed with a single global object persisted to localStorage:</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">03</span><span class="p-math-title">localStorage Schema (key: <mark class="hl">rfv4</mark>)</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">{
  "transactions": [
    { "id": "t_1710000000000",
      "type": "expense",         // "income" | "expense"
      "amount": 45.50,
      "category": "Food",
      "date": "2026-06-01",
      "note": "Lunch at cafe"
    }
  ],
  "budgets": {
    "Food": 400,
    "Transport": 150,
    "Entertainment": 100
  },
  "goals": [
    { "id": "g_1",
      "title": "New Laptop",
      "target": 5000,
      "deadline": "2026-12-01",
      "saved": 1200
    }
  ],
  "reminders": [... ],
  "settings": { "currency": "MYR", "theme": "dark" }
}</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">The whole state serialises to one JSON string, export is <code class="inline">JSON.stringify(state)</code>, import is <code class="inline">JSON.parse(fileContent)</code>. One-line backup and restore, no server round-trip, no account. The data never leaves the device unless you export it.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Export button click:
const blob = new Blob([JSON.stringify(state, null, 2)],
  { type: 'application/json' }
);
// → downloads "rafifinance-backup-2026-06-19.json"

# Import on a new device:
const state = JSON.parse(fileContent);
localStorage.setItem('rfv4', JSON.stringify(state));
location.reload();
// → all transactions, budgets, goals restored instantly</pre></div></div></div></div></div>

<p>The <strong>PWA manifest is embedded inline</strong> as a <code class="inline">data:</code> URL. The <strong>service worker is generated from a Blob URL</strong> at runtime, no external <code class="inline">sw.js</code> file. Everything self-contained:</p>

<span class="p-pwa-step-num">1</span>

Manifest injected inline
<code class="inline">&lt;link rel="manifest" href="data:application/json,{...}"&gt;</code>, the manifest JSON is encoded directly into the HTML, no separate file needed.

<span class="p-pwa-step-num">2</span>

Service Worker from Blob
SW code is defined as a JS string, converted to a <code class="inline">Blob</code>, then registered via <code class="inline">URL.createObjectURL(blob)</code>, no separate sw.js file on the server.

<span class="p-pwa-step-num">3</span>

Cache-first offline strategy
On first load, the SW caches the HTML file. Subsequent loads serve from cache instantly. Works fully offline after the first visit.
        </div>
        <br>
        <h3>06 Design System</h3>
        <div class="blog-content-body">
Color Palette

Background
#080810

Card Surface
#1a1a2e

Accent (Purple)
#6c5ce7

Primary Text
#f5f5f5

Muted Text
#888888

Typography

RafiFinance
Inter · 700 · Headings

Transaction history, labels
Inter · 400 · Body

RM 1,234.56
JetBrains Mono · Numbers
        </div>
        <br>
        <h3>07 Use Cases</h3>
        <div class="blog-content-body">
<ul><li><b>Student Budgeting</b>: Track allowance, food, transport, and entertainment against monthly budgets. No account signup, works on any device.</li>
<li><b>Private: No Account</b>: Financial data never leaves your device. No signup, no cloud sync, no company storing your spending habits.</li>
<li><b>Installable PWA</b>: Install to your home screen on Android or iOS. Works offline after the first load. Feels like a native app.</li>
<li><b>Goal-Oriented Saving</b>: Set saving goals with deadlines and let the app tell you exactly how much to save each month to hit the target.</li></ul>
        </div>
        <br>
        <h3>Health Score Demo</h3>
        <div class="blog-content-body">
<svg class="p-score-ring" viewbox="0 0 80 80">
<circle cx="40" cy="40" r="32" stroke="var(--line2)"></circle>
<circle cx="40" cy="40" r="32" stroke="var(--acc)" stroke-dasharray="200.96" stroke-dashoffset="50.24" transform="rotate(-90 40 40)"></circle>
</svg>

75
Financial Health
Good · Keep saving

<span>Savings Rate</span><span style="color:var(--acc);">×0.40</span>

<span>Budget Adherence</span><span style="color:var(--acc);">×0.35</span>

<span>Goal Progress</span><span style="color:var(--acc);">×0.25</span>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Vanilla JS</span>
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">PWA</span>
<span class="badge blog-badge badge-neutral">localStorage</span>
<span class="badge blog-badge badge-neutral">Service Worker</span>
<span class="badge blog-badge badge-neutral">Notifications API</span>
<span class="badge blog-badge badge-neutral">Lucide Icons CDN</span>
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
<a class="p-link-btn" href="https://github.com/rafiarsya07?tab=repositories" rel="noopener noreferrer" target="_blank">
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
        <br><br>
    </div>
</div>
