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

        <figure class="p-hero"><img alt="CampusBay homepage: headline, Browse and Start selling buttons, the Digital, Physical and Requests doors, and Bayo the mascot waving" decoding="async" src="image/assets/campusbay/hero.png"/></figure>

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
            <span>An independent marketplace for students and the people around them. List a textbook, sell your source code or notes, or post what you are looking for, and the buyer messages you straight on WhatsApp. No fees, no middleman. I designed and built the whole product on my own: the Next.js app, the database, the admin panel, the live update channel, the brand and its mascot, and an Android app, all running on Cloudflare's free tier.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Founder &amp; Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">Next.js, Cloudflare Workers, D1</span></span><span class="p-meta-item"><span class="p-meta-k">Languages</span><span class="p-meta-v">EN, MS, ID</span></span></div><a href="https://campusbay.store" target="_blank" rel="noopener" class="ext-link">campusbay.store<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p>Students already buy and sell to each other all the time, just in the worst possible places: a group chat where a listing scrolls away in an hour, a story that disappears in a day, a marketplace built for cars and furniture. <strong>CampusBay</strong> is a small, focused place for it. Two kinds of things are listed, <b>digital</b> (source code, templates, notes, design assets) and <b>physical</b> (books, electronics, room items), plus a <b>request board</b> where people post what they need with a budget and let sellers come to them.</p>
<p class="p-text">The biggest decision was what to leave out. Earlier revisions had in-app chat, phone verification by SMS, contact reveal requests, a protected download library and notifications. Revision 6 removed all of it. Every deal now happens on <b>WhatsApp</b>, the app everyone already has open, and CampusBay never touches the money. That cut the product down to what it is actually for, and made it cheap enough to run on Cloudflare's Workers Free plan.</p>
<p class="p-text">It is independent on purpose: not affiliated with any university, with no student check. Any Google account can sign in, and campus is an optional, self-declared profile label that grants nothing.</p>
        </div>
        <br>

        <h3>02 How It Works</h3>
        <div class="blog-content-body">
<figure class="rf-figure-lg"><img alt="Three small scenes: a listing card, the WhatsApp chat it opens, and the finished deal" decoding="async" loading="lazy" src="image/assets/campusbay/how-it-works.png"/><figcaption class="img-caption">The flow in three scenes, as it appears on the homepage</figcaption></figure>
<ul>
<li><b>List or request</b>: a seller posts an item in about a minute (photos, price, category, condition), or a buyer posts what they need with an optional budget. Requests stay open for 30 days.</li>
<li><b>Chat on WhatsApp</b>: "Chat on WhatsApp" is not a <code class="inline">wa.me</code> link. It goes to <code class="inline">/go/wa/listing/&lt;id&gt;</code>, which requires sign in, refuses suspended members and cross-site navigation, rate limits, records the click, and only then redirects with a message prefilled with the item's name. The seller's number is <b>never rendered into any page</b>, and an end-to-end test asserts it.</li>
<li><b>Deal your way</b>: meet on campus, or for a digital item the seller saves a private link (Drive, GitHub) on the listing and presses <b>Paid, give access</b> for a buyer who opened a chat. The database itself enforces who can grant what.</li>
</ul>
        </div>
        <br>

        <h3>03 Architecture</h3>
        <div class="blog-content-body">
<p class="p-text">The whole product is one Cloudflare Worker. Next.js 16 (App Router, React 19) is compiled into it with the OpenNext adapter, and a thin custom Worker entry sits in front of Next to handle the things that should never pay for a full render.</p>
<div class="project-tree">Browser / Android app (TWA)
   │
   ▼
cloudflare/worker.ts                 <span class="pt-comment"># custom entry, runs before Next</span>
   ├── /api/live  ──► LiveHub        <span class="pt-comment"># Durable Object, hibernating WebSockets</span>
   ├── /api/pulse ──► edge cache     <span class="pt-comment"># change hash, no Next start-up</span>
   ├── visitor pages ──► edge cache  <span class="pt-comment"># HTML + RSC, keyed on language and pulse</span>
   ├── search brake, scanner probes  <span class="pt-comment"># 429 / 404 before Next runs</span>
   └── everything else ──► OpenNext (Next.js 16)
                              ├── services/       <span class="pt-comment"># business rules and authorization</span>
                              ├── db/repositories <span class="pt-comment"># Drizzle ORM</span>
                              └── D1 (SQLite)     <span class="pt-comment"># users, listings, photos, audit log</span></div>
<ul>
<li><b>Layers enforced by lint</b>: <code class="inline">app/</code> is thin routing, <code class="inline">components/</code> is presentational only, <code class="inline">services/</code> holds the rules, <code class="inline">db/repositories/</code> is the only code that queries. ESLint rules make a component importing the database a build failure, not a code review comment.</li>
<li><b>Authorization in the database too</b>: D1 has no row level security, so the rules are written twice, as capability checks in <code class="inline">services/</code> and as triggers and constraints in the migrations (a delivery link only on a digital listing, a grant only from the real seller to someone who opened a chat, an append-only admin log).</li>
<li><b>Sign in with Google only</b>, through Better Auth. Admins come from an <code class="inline">ADMIN_EMAILS</code> secret and are re-checked on every request, so removing someone takes effect immediately.</li>
<li><b>Photos are compressed in the browser</b> to about 350 KB of WebP before upload, one at a time so a low-end phone does not run out of memory.</li>
</ul>
        </div>
        <br>

        <h3>04 Live Updates Without a Refresh</h3>
        <div class="blog-content-body">
<p class="p-text">A marketplace feels dead if a new listing only shows up when you reload. CampusBay pushes changes instead:</p>
<ul>
<li><b>LiveHub</b>, a Durable Object, holds every open tab as a hibernating WebSocket, so idle sockets cost nothing. After every public write the server rings it, and it sends <code class="inline">{"t":"changed"}</code> to everyone. The message carries no data at all: it is a doorbell, not a feed.</li>
<li>On a ring the page calls <code class="inline">router.refresh()</code>: server components re-render in place with scroll and form state kept. Near the top of the page it updates quietly; further down it shows a "New posts" pill instead, so content never jumps under the reader. It never refreshes on a form or while an input has focus.</li>
<li>A polled <code class="inline">/api/pulse</code> hash is the safety net when the socket is down. It also carries the build id, so a phone that kept the app open for days notices a new deploy and reloads into it at a safe moment rather than failing on files the new build no longer has.</li>
<li>Tested in <code class="inline">wrangler dev</code>: a new listing appeared on an open page in under a second. LiveHub rings at most once every 3 seconds, so a burst of writes cannot become a flood.</li>
</ul>
        </div>
        <br>

        <h3>05 Living on the Free Plan</h3>
        <div class="blog-content-body">
<p class="p-text">The Workers Free plan allows 100,000 requests a day and about 10 ms of CPU per request. After the first real traffic produced error 1102 ("Worker exceeded resource limits"), most of the later work was making each request cheaper:</p>
<ul>
<li><b>Visitors skip authentication entirely</b>: without a session cookie the request is answered as a visitor without loading the auth library, and one Better Auth instance is reused per isolate.</li>
<li><b>An edge page cache for visitors</b>: public pages are served from <code class="inline">caches.default</code> without starting Next. The key includes the language cookie, the RSC headers and the live pulse version, so a new listing still produces a fresh page. The CSP nonce is swapped for a fresh one on every hit.</li>
<li><b>No prefetch</b>: a <code class="inline">Link</code> wrapper turns off Next's automatic prefetching, which was sending dozens of <code class="inline">?_rsc=</code> requests per page view.</li>
<li><b>Cheap rejections</b>: scanner probes (<code class="inline">/.env</code>, <code class="inline">wp-*</code>, <code class="inline">*.php</code>) get a cached 404 at the Worker edge, and search is limited to 30 queries a minute per IP in memory, never in D1.</li>
<li><b>Translations left the HTML</b>: the three dictionaries ship once in the client bundle instead of about 23 KB of strings serialised into every page.</li>
</ul>
        </div>
        <br>

        <h3>06 Search in Three Languages</h3>
        <div class="blog-content-body">
<p class="p-text">Students here type in English, Malay and Indonesian, often in the same sentence. Search is pure, unit-tested TypeScript in <code class="inline">lib/search-kit/</code>:</p>
<ul>
<li><b>About 65 synonym groups</b> across EN, MS and ID: "kamera" finds "Camera", "hp" finds phones, "meja" finds "desk". Short words must start a word, so "tas" (bag) does not match "status".</li>
<li><b>Did you mean</b>: when nothing matches, the closest known word is tried with one or two typos allowed by length, so "kamra" shows the results for "kamera".</li>
<li><b>Autocomplete with no request per keystroke</b>: the header search loads a small, edge-cached index once on focus and matches in the browser. It is an accessible ARIA combobox, and still a plain form without JavaScript.</li>
<li>Input is normalised (NFKC, control, zero-width and bidi characters removed, at most 5 words) and every query is parameterised with LIKE wildcards escaped. The test suite includes an injection string.</li>
</ul>
        </div>
        <br>

        <h3>07 Moderation &amp; Admin Panel</h3>
        <div class="blog-content-body">
<p class="p-text">Running a marketplace means dealing with scams, so moderation was built as a first-class part of the product rather than a database console.</p>
<div class="rf-livegroup">
<figure class="rf-figure-lg"><img alt="Admin Overview: member, listing, request and report counts with 14-day charts" decoding="async" loading="lazy" src="image/assets/campusbay/admin-overview.png"/><figcaption class="img-caption">Overview: members, listings, WhatsApp chats and open reports, with 14-day charts</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Admin Reports page: reported listings and a reported user, each with Take down, Suspend and Take down plus suspend actions" decoding="async" loading="lazy" src="image/assets/campusbay/admin-reports.png"/><figcaption class="img-caption">Reports: take a listing down, suspend its owner, or both in one click</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Admin Site settings: maintenance mode switch and announcement banner" decoding="async" loading="lazy" src="image/assets/campusbay/admin-site.png"/><figcaption class="img-caption">Site settings: the maintenance switch and the announcement banner, live without a deploy</figcaption></figure>
</div>
<ul>
<li><b>Overview, Users, Listings, Requests, Reports, Activity, Ratings, Appeals and Site settings</b>, with 14-day charts and the most contacted items.</li>
<li><b>One-click actions on a report</b> read the target and owner from the report row itself (the form only sends the report id), refuse to suspend an admin, write an audit row per step, and close every other open report the action answers.</li>
<li><b>Suspension</b> signs the member out everywhere (a trigger deletes their sessions) and hides everything they posted. A suspended member can file an appeal; accepting it restores the account.</li>
<li><b>Maintenance mode</b> shows a maintenance screen to everyone but admins, while keeping sign in and the admin panel reachable.</li>
</ul>
        </div>
        <br>

        <h3>08 Security</h3>
        <div class="blog-content-body">
<p class="p-text">The design started from a written threat model (39 threats, each with a mitigation and a residual risk), and each revision ended with a security pass. Some of what that caught:</p>
<ul>
<li><b>A data leak through layouts</b>: in the App Router a layout and its page render in parallel. The admin layout turned visitors away, but the admin page still ran and its data was serialised into the response. Every admin page now guards itself, and a smoke test asserts no admin data reaches a visitor.</li>
<li><b>An open redirect</b>: <code class="inline">?next=/\t/evil.example</code> became <code class="inline">//evil.example</code> in the browser. All redirects now go through one tested <code class="inline">safePath()</code>.</li>
<li><b>A SQL scoping bug</b>: inside a correlated subquery, Drizzle wrote a bare <code class="inline">"id"</code> that SQLite bound to the inner table. A profile always showed 0 listings, and the photo limit on edit could be bypassed. Fixed with a helper that names the outer table, plus a regression test.</li>
<li><b>Write ceilings</b>: every member write shares an hourly limit, WhatsApp hand-offs are limited per hour and per day, and a strict CSP with nonces is set on every response.</li>
</ul>
        </div>
        <br>

        <h3>09 Brand &amp; Bayo</h3>
        <div class="blog-content-body">
<p class="p-text">The identity is red, white and charcoal. The red is <code class="inline">#D22730</code>, chosen over the more obvious <code class="inline">#E53935</code> because that one measures 4.23:1 against white and fails WCAG AA for text. The logo is a "B" with an upward arrow, traced to vector paths so it follows light and dark mode.</p>
<p class="p-text">The mascot is <b>Bayo</b>, the "B" given arms and a pair of sneakers. Each pose has one job in the interface: empty states, success moments, the help page and the 404, so a blank screen still tells you what to do next.</p>
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

        <h3>10 Live Preview</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Screens from the current build (captured at 2x), live at <a class="ext-link" href="https://campusbay.store" target="_blank" rel="noopener">campusbay.store<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>. Listings shown are test data.</p>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Homepage</p>
<figure class="rf-figure-lg"><img alt="Latest listings grid and the People are looking for request cards" decoding="async" loading="lazy" src="image/assets/campusbay/home-listings.png"/><figcaption class="img-caption">Latest listings, then the request board: a listing is its photo, price, title and category</figcaption></figure>
<figure class="rf-figure-lg"><img alt="How it works steps, the FAQ list and the sell banner" decoding="async" loading="lazy" src="image/assets/campusbay/home-how-faq.png"/><figcaption class="img-caption">How it works, a short FAQ, and the sell banner</figcaption></figure>
<figure class="rf-figure-lg"><img alt="CampusBay homepage in dark mode" decoding="async" loading="lazy" src="image/assets/campusbay/home-dark.png"/><figcaption class="img-caption">Dark mode, from the same design tokens</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Listing</p>
<figure class="rf-figure-lg"><img alt="A listing page: photo, price, condition, Chat on WhatsApp button, seller card and safety tips" decoding="async" loading="lazy" src="image/assets/campusbay/listing.png"/><figcaption class="img-caption">A listing: price, seller, safety tips, and the one button that matters, Chat on WhatsApp</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Members</p>
<figure class="rf-figure-lg"><img alt="A seller's public profile with their listings" decoding="async" loading="lazy" src="image/assets/campusbay/profile.png"/><figcaption class="img-caption">Public profile: name, campus, bio and listings</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Settings page with profile, WhatsApp number, language and theme" decoding="async" loading="lazy" src="image/assets/campusbay/settings.png"/><figcaption class="img-caption">Settings: profile and WhatsApp, language and appearance, marketplace rules</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">On a phone</p>
<p class="rf-media-lead">The site is responsive from 320px up, installable as a PWA, and packaged as a signed Android app with Bubblewrap (a Trusted Web Activity), so the app gets every deploy with no new APK.</p>
<div class="cb-phones">
<figure><img alt="CampusBay homepage on a phone" decoding="async" loading="lazy" src="image/assets/campusbay/phone-home.png"/><figcaption><b>Home</b>Live counts and the three doors</figcaption></figure>
<figure><img alt="Browse page on a phone with filters and listing cards" decoding="async" loading="lazy" src="image/assets/campusbay/phone-browse.png"/><figcaption><b>Browse</b>Kind tabs, category and sort</figcaption></figure>
<figure><img alt="A listing page on a phone with the WhatsApp button" decoding="async" loading="lazy" src="image/assets/campusbay/phone-listing.png"/><figcaption><b>Listing</b>Price, seller and WhatsApp</figcaption></figure>
<figure><img alt="Request board on a phone" decoding="async" loading="lazy" src="image/assets/campusbay/phone-requests.png"/><figcaption><b>Requests</b>What people are looking for</figcaption></figure>
</div>
</div>
        </div>
        <br>

        <h3>11 Testing &amp; Delivery</h3>
        <div class="blog-content-body">
<ul>
<li><b>Unit and authorization tests</b> on Node's own test runner: search, synonyms and fuzzy matching, the page cache key, safe redirects, WhatsApp hand-off, digital delivery, listing freshness, i18n, and a capability matrix of who can do what.</li>
<li><b>Browser flows with Playwright</b> against the real Workers runtime (<code class="inline">workerd</code>), including the assertion that a seller's phone number never appears in any page.</li>
<li><b>CI on GitHub Actions</b>: typecheck (strict, with <code class="inline">noUncheckedIndexedAccess</code>), lint, tests and a scan that fails the build if sensitive values reach logs or the client bundle.</li>
<li><b>Migrations are additive</b> and run before each deploy, so users, listings and the admin log survive every release.</li>
</ul>
<div class="project-tree">CampusBay/
├── <span class="pt-dir">app/</span>             <span class="pt-comment"># routes: explore, listing, requests, u, dashboard, admin, go</span>
├── <span class="pt-dir">cloudflare/</span>      <span class="pt-comment"># worker.ts, live-hub.ts, page-cache.ts, limiter.ts</span>
├── <span class="pt-dir">components/</span>      <span class="pt-comment"># presentational only: ui, brand, home, admin, settings</span>
├── <span class="pt-dir">services/</span>        <span class="pt-comment"># actor, guard, capabilities, site settings</span>
├── <span class="pt-dir">db/</span>
│   ├── schema.ts
│   ├── <span class="pt-dir">migrations/</span>   <span class="pt-comment"># 0000 to 0007, D1 / SQLite</span>
│   └── <span class="pt-dir">repositories/</span> <span class="pt-comment"># the only code that queries</span>
├── <span class="pt-dir">lib/</span>             <span class="pt-comment"># auth, search-kit, i18n, pwa, security</span>
├── <span class="pt-dir">locales/</span>         <span class="pt-comment"># en.json, ms.json, id.json</span>
├── <span class="pt-dir">tests/</span>           <span class="pt-comment"># unit, authz, e2e (Playwright)</span>
└── wrangler.jsonc   <span class="pt-comment"># dev and production, custom domain only</span></div>
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
