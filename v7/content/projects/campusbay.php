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

        <figure class="p-hero"><picture><source media="(max-width: 600px)" srcset="image/assets/campusbay/hero-mobile.png"><img alt="CampusBay homepage: headline, Browse and Start selling buttons, the Digital, Physical and Requests doors, and Bayo the mascot waving" decoding="async" src="image/assets/campusbay/hero.png"/></picture></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Next.js 16</span>
                <span class="badge blog-badge badge-purple">TypeScript</span>
                <span class="badge blog-badge badge-orange">Cloudflare Workers</span>
                <span class="badge blog-badge badge-green">D1 (SQLite)</span>
                <span class="badge blog-badge badge-secondary">Durable Objects</span>
                <span class="badge blog-badge badge-neutral">Tailwind v4</span>
            </div>
            <h1>CampusBay</h1>
            <br>
            <span>A marketplace for students to sell textbooks, notes and code, or post what they need. Buyers message sellers on WhatsApp. No fees, no middleman. Designed, built and run solo.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Founder &amp; Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">Next.js, Cloudflare Workers, D1</span></span><span class="p-meta-item"><span class="p-meta-k">Languages</span><span class="p-meta-v">EN, MS, ID</span></span></div><a href="https://campusbay.store" target="_blank" rel="noopener" class="ext-link">campusbay.store<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Students already buy and sell to each other, just in group chats where a listing is gone in an hour. CampusBay gives them one place for it: digital items, physical items, and a request board. Every deal moves to WhatsApp, and CampusBay never touches the money.</p>
<figure class="rf-figure-lg"><img alt="Three scenes: a listing card, the WhatsApp chat it opens, and the finished deal" decoding="async" loading="lazy" src="image/assets/campusbay/how-it-works.png"/><figcaption class="img-caption">List, chat on WhatsApp, deal your way</figcaption></figure>
        </div>
        <br>

        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Instant updates</b>: new listings appear on every open page in under a second, pushed through a Durable Object over WebSockets.</li>
<li><b>Private contact</b>: a seller's WhatsApp number is never shown on any page. Chats open through a guarded, rate-limited redirect.</li>
<li><b>Runs on the free plan</b>: edge caching for visitors and a lighter request path keep it inside Cloudflare's Workers Free limits.</li>
<li><b>Search in three languages</b>: English, Malay and Indonesian synonyms, typo correction and instant suggestions.</li>
<li><b>Moderation</b>: an admin panel for reports, suspensions, appeals and maintenance mode, with an audit log.</li>
<li><b>Tested and shipped</b>: unit and Playwright tests in CI, plus an Android app built on the same site.</li>
</ul>
        </div>
        <br>

        <h3>03 Screens</h3>
        <div class="blog-content-body">
<div class="rf-livegroup">
<figure class="rf-figure-lg"><img alt="Latest listings and the request board" decoding="async" loading="lazy" src="image/assets/campusbay/home-listings.png"/><figcaption class="img-caption">Latest listings and what people are looking for</figcaption></figure>
<figure class="rf-figure-lg"><img alt="A listing page with price, seller and the Chat on WhatsApp button" decoding="async" loading="lazy" src="image/assets/campusbay/listing.png"/><figcaption class="img-caption">A listing, one button away from WhatsApp</figcaption></figure>
<figure class="rf-figure-lg"><img alt="CampusBay homepage in dark mode" decoding="async" loading="lazy" src="image/assets/campusbay/home-dark.png"/><figcaption class="img-caption">Dark mode</figcaption></figure>
</div>
<div class="rf-livegroup">
<p class="rf-livegroup-title">Admin</p>
<figure class="rf-figure-lg"><img alt="Admin overview with counts and 14-day charts" decoding="async" loading="lazy" src="image/assets/campusbay/admin-overview.png"/><figcaption class="img-caption">Overview with 14-day charts</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Admin reports with take down and suspend actions" decoding="async" loading="lazy" src="image/assets/campusbay/admin-reports.png"/><figcaption class="img-caption">Reports: take down, suspend, or both in one click</figcaption></figure>
</div>
<div class="rf-livegroup">
<p class="rf-livegroup-title">On a phone</p>
<div class="cb-phones">
<figure><img alt="CampusBay homepage on a phone" decoding="async" loading="lazy" src="image/assets/campusbay/phone-home.png"/><figcaption><b>Home</b>Live counts and the three doors</figcaption></figure>
<figure><img alt="Browse page on a phone with filters and listing cards" decoding="async" loading="lazy" src="image/assets/campusbay/phone-browse.png"/><figcaption><b>Browse</b>Kind tabs, category and sort</figcaption></figure>
<figure><img alt="A listing page on a phone with the WhatsApp button" decoding="async" loading="lazy" src="image/assets/campusbay/phone-listing.png"/><figcaption><b>Listing</b>Price, seller and WhatsApp</figcaption></figure>
<figure><img alt="Request board on a phone" decoding="async" loading="lazy" src="image/assets/campusbay/phone-requests.png"/><figcaption><b>Requests</b>What people are looking for</figcaption></figure>
</div>
</div>
        </div>
        <br>

        <h3>04 Brand &amp; Bayo</h3>
        <div class="blog-content-body">
<p class="p-text">Red, white and charcoal, with Bayo the mascot. Each pose has one job in the app: empty states, success moments, help and the 404.</p>
<div class="cb-bayo-grid">
<figure><img alt="Bayo waving" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/waving.png"/><figcaption>Waving<span>Homepage hero</span></figcaption></figure>
<figure><img alt="Bayo with a magnifying glass" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/searching.png"/><figcaption>Searching<span>No results, 404</span></figcaption></figure>
<figure><img alt="Bayo holding a book and a phone" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/shelf.png"/><figcaption>Shelf<span>Nothing listed yet</span></figcaption></figure>
<figure><img alt="Bayo holding documents" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/documents.png"/><figcaption>Documents<span>Digital empty, maintenance</span></figcaption></figure>
<figure><img alt="Bayo with a map pin and a desk lamp" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/meetup.png"/><figcaption>Meetup<span>Physical empty</span></figcaption></figure>
<figure><img alt="Bayo presenting a download file" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/download.png"/><figcaption>Download<span>Purchases empty</span></figcaption></figure>
<figure><img alt="Bayo holding a phone with chat bubbles" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/messages.png"/><figcaption>Messages<span>Posting gate, Help</span></figcaption></figure>
<figure><img alt="Bayo holding a phone with a check mark" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/phone-verified.png"/><figcaption>All set<span>Setup finished</span></figcaption></figure>
<figure><img alt="Bayo celebrating with a ticket" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/celebrating.png"/><figcaption>Celebrating<span>Listing is live</span></figcaption></figure>
<figure><img alt="Bayo holding a red flag" decoding="async" loading="lazy" src="image/assets/campusbay/bayo/report.png"/><figcaption>Report<span>Thanks for reporting</span></figcaption></figure>
</div>
        </div>
        <br>

        <h3>05 Architecture</h3>
        <div class="blog-content-body">
<div class="project-tree">campusbay.store
   └── Cloudflare Worker
         ├── /api/live   ──► Durable Object  <span class="pt-comment"># WebSocket push</span>
         ├── visitor pages ──► edge cache
         └── Next.js 16 (OpenNext)
               └── D1 (SQLite) via Drizzle  <span class="pt-comment"># listings, users, audit log</span></div>
        </div>
        <br>

        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Next.js 16</span>
<span class="badge blog-badge badge-neutral">React 19</span>
<span class="badge blog-badge badge-neutral">TypeScript</span>
<span class="badge blog-badge badge-neutral">Tailwind CSS v4</span>
<span class="badge blog-badge badge-neutral">Cloudflare Workers</span>
<span class="badge blog-badge badge-neutral">OpenNext</span>
<span class="badge blog-badge badge-neutral">Cloudflare D1</span>
<span class="badge blog-badge badge-neutral">Durable Objects</span>
<span class="badge blog-badge badge-neutral">Drizzle ORM</span>
<span class="badge blog-badge badge-neutral">Better Auth</span>
<span class="badge blog-badge badge-neutral">Zod</span>
<span class="badge blog-badge badge-neutral">Playwright</span>
<span class="badge blog-badge badge-neutral">GitHub Actions</span>
<span class="badge blog-badge badge-neutral">PWA / TWA</span>
</div>
        </div>
        <br>

        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://campusbay.store" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">campusbay.store</span>
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
