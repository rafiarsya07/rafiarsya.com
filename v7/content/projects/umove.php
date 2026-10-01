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

        <figure class="p-hero"><img alt="UMOVE homepage: Anything on campus, delivered, next to a live board of requests waiting for a runner" decoding="async" src="image/assets/umove/hero.png"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">React 19</span>
                <span class="badge blog-badge badge-purple">TypeScript</span>
                <span class="badge blog-badge badge-green">Hono</span>
                <span class="badge blog-badge badge-orange">PostgreSQL</span>
                <span class="badge blog-badge badge-secondary">Docker</span>
                <span class="badge blog-badge badge-neutral">Cloudflare</span>
            </div>
            <h1>UMOVE</h1>
            <br>
            <span>Post what you need on campus and a verified student runner brings it over. Built for Universiti Malaya, in English, Malay and Indonesian.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Launching soon</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">React, Hono, PostgreSQL</span></span></div><a href="https://umove.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">umove.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Late at night on campus, getting food, printing or a parcel from the other side of UM is a hassle. UMOVE lets a student post the errand with a delivery fee from RM1, and another student who is already nearby takes it. They chat on WhatsApp, and the customer pays the runner on delivery.</p>
<figure class="rf-figure-lg"><img alt="How it works in three steps: post a request, a runner takes it, pay on delivery and rate" decoding="async" loading="lazy" src="image/assets/umove/how-it-works.png"/><figcaption class="img-caption">Post, get matched, pay on delivery</figcaption></figure>
        </div>
        <br>

        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Live board</b>: new requests appear for every runner the moment they are posted, over Server-Sent Events.</li>
<li><b>Verified runners</b>: students apply with a short form and a photo, and an admin approves them before they can take orders.</li>
<li><b>Built-in safety</b>: a word filter in three languages holds suspicious requests for review, plus no-show reports and ratings.</li>
<li><b>No money handling</b>: payment goes straight to the runner on delivery, so UMOVE never holds anyone's money.</li>
<li><b>Hardened self-hosting</b>: API and database on a mini PC behind Cloudflare Tunnel, with no open ports and automatic backups and updates.</li>
</ul>
        </div>
        <br>

        <h3>03 Screens</h3>
        <div class="blog-content-body">
<div class="rf-livegroup">
<figure class="rf-figure-lg"><img alt="Requests board with open requests and their delivery fees" decoding="async" loading="lazy" src="image/assets/umove/requests.png"/><figcaption class="img-caption">The request board, updating live</figcaption></figure>
<figure class="rf-figure-lg"><img alt="A request on its way, with progress steps and the runner's card and WhatsApp button" decoding="async" loading="lazy" src="image/assets/umove/request-detail.png"/><figcaption class="img-caption">Tracking a request, from waiting to delivered</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Become a runner page" decoding="async" loading="lazy" src="image/assets/umove/runner.png"/><figcaption class="img-caption">Runner sign-up</figcaption></figure>
</div>
<div class="rf-livegroup">
<p class="rf-livegroup-title">Admin</p>
<figure class="rf-figure-lg"><img alt="Admin overview with live counts" decoding="async" loading="lazy" src="image/assets/umove/admin-overview.png"/><figcaption class="img-caption">Overview, updating live</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Admin list of every request with status filters" decoding="async" loading="lazy" src="image/assets/umove/admin-requests.png"/><figcaption class="img-caption">Every request, with held ones waiting for review</figcaption></figure>
</div>
<div class="rf-livegroup">
<p class="rf-livegroup-title">On a phone</p>
<div class="cb-phones">
<figure><img alt="UMOVE homepage on a phone" decoding="async" loading="lazy" src="image/assets/umove/phone-home.png"/><figcaption><b>Home</b>Live requests at a glance</figcaption></figure>
<figure><img alt="Requests board on a phone" decoding="async" loading="lazy" src="image/assets/umove/phone-requests.png"/><figcaption><b>Requests</b>What students need now</figcaption></figure>
<figure><img alt="Posting a new request on a phone" decoding="async" loading="lazy" src="image/assets/umove/phone-new.png"/><figcaption><b>Post</b>Pick-up, drop-off, fee</figcaption></figure>
<figure><img alt="A request on its way on a phone" decoding="async" loading="lazy" src="image/assets/umove/phone-detail.png"/><figcaption><b>Track</b>From runner found to delivered</figcaption></figure>
</div>
</div>
        </div>
        <br>

        <h3>04 Architecture</h3>
        <div class="blog-content-body">
<div class="project-tree">umove.rafiarsya.com
   ├── web       <span class="pt-comment"># React 19 + Vite on Cloudflare Workers</span>
   └── /api/* ──► Cloudflare Tunnel ──► mini PC (Docker)
                    ├── app  <span class="pt-comment"># Node + Hono API, Google sign-in, live stream</span>
                    └── db   <span class="pt-comment"># PostgreSQL, no internet access</span></div>
        </div>
        <br>

        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">React 19</span>
<span class="badge blog-badge badge-neutral">TypeScript</span>
<span class="badge blog-badge badge-neutral">Vite</span>
<span class="badge blog-badge badge-neutral">Tailwind CSS v4</span>
<span class="badge blog-badge badge-neutral">Node.js</span>
<span class="badge blog-badge badge-neutral">Hono</span>
<span class="badge blog-badge badge-neutral">PostgreSQL</span>
<span class="badge blog-badge badge-neutral">Zod</span>
<span class="badge blog-badge badge-neutral">Server-Sent Events</span>
<span class="badge blog-badge badge-neutral">Docker Compose</span>
<span class="badge blog-badge badge-neutral">Cloudflare Workers</span>
<span class="badge blog-badge badge-neutral">Cloudflare Tunnel</span>
</div>
        </div>
        <br>

        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://umove.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">umove.rafiarsya.com</span>
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
