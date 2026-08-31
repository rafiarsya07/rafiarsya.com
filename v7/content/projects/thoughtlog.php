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
                <span class="badge blog-badge badge-blue">Node.js</span>
                <span class="badge blog-badge badge-green">Express</span>
                <span class="badge blog-badge badge-purple">PostgreSQL</span>
                <span class="badge blog-badge badge-orange">JWT Auth</span>
                <span class="badge blog-badge badge-neutral">Markdown</span>
                <span class="badge blog-badge badge-blue">Background Jobs</span>
                <span class="badge blog-badge badge-green">Docker</span>
                <span class="badge blog-badge badge-purple">Cloudflare Tunnel</span>
            </div>
            <h1>ThoughtLog</h1>
            <br>
            <span>A full-stack personal blog with a CMS I built from scratch, no WordPress, no Ghost, no static-site generator. Write in Markdown with live preview, save drafts, schedule posts to publish themselves, and browse by tag. Reading is public; writing sits behind real authentication. It runs on a mini PC under my desk and reaches the internet through a Cloudflare Tunnel at blog.rafiarsya.com.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">Express, PostgreSQL</span></span><span class="p-meta-item"><span class="p-meta-k">Hosting</span><span class="p-meta-v">Self-Hosted + Tunnel</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p class="p-text">ThoughtLog is a personal blog with its own CMS, built end to end without an off-the-shelf platform. Write in Markdown with live preview beside the editor, then publish immediately, save a draft, or schedule it and let the server publish on its own. Readers get a tag cloud, full-text search, related posts, and reading-time estimates. Everything behind the writing, the editor, the dashboard, the scheduler, is locked behind a login.</p>
<p class="p-text">I wanted somewhere to write up the engineering decisions behind my other projects without learning someone else’s admin panel. Building the CMS myself meant designing what a blog platform hides: a REST API with a clean public/authenticated split, real authentication, a post-status state machine, and a background job that publishes what’s due every minute.</p>

<strong>Where it runs:</strong> ThoughtLog is <mark class="hl">live right now</mark> at <code class="inline">blog.rafiarsya.com</code>. It runs on a Linux mini PC at home, kept alive with PM2, and exposed to the internet through a <strong>Cloudflare Tunnel</strong>, no inbound ports opened, no public IP, no cloud bill. The same self-hosting setup I use across my projects.
        </div>
        <br>
        <h3>02 Architecture</h3>
        <div class="blog-content-body">
<p class="p-text">A single Express app splits routes in two: public reads anyone can hit, and authenticated writes behind middleware. A reader never touches a route that can change data; a writer authenticates once and gets the editor, dashboard, and every mutating endpoint.</p>

<strong>Request lifecycle</strong><br/>
<code class="inline">GET /api/posts</code> → <strong>public</strong>, returns published posts only, newest first, with tags and reading time.<br/>
<code class="inline">GET /api/posts/:slug</code> → <strong>public</strong>, returns one post and atomically bumps its view counter.<br/>
<code class="inline">POST /api/posts</code> → <strong>requireAuth</strong>, creates a post as draft, scheduled, or published.<br/>
<code class="inline">PUT /api/posts/:id</code> → <strong>requireAuth</strong>, edits content or flips status and re-publishes.
                                
<p>All SQL lives in exactly one file: <code class="inline">server/db.js</code>, so the rest of the app never writes a query inline. Authentication helpers (<code class="inline">bcrypt</code> hashing, JWT signing, the <code class="inline">requireAuth</code> guard) live in <code class="inline">auth.js</code>, and the timed-publishing job lives in <code class="inline">scheduler.js</code>. Each file has one job, which is the whole point.</p>
        </div>
        <br>
        <h3>03 The Query That Makes Scheduling Work</h3>
        <div class="blog-content-body">
<p class="p-text">Scheduled publishing is really one careful query on a timer. A scheduled post sits with <code class="inline">status = 'scheduled'</code> and a <code class="inline">publish_at</code> timestamp, hidden from readers. Once a minute the scheduler flips anything whose time has passed, in a single statement, so two ticks can never publish the same post twice.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Atomic Scheduled-Publish Sweep</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Query</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">-- runs every minute, and once at startup
UPDATE posts
   SET status     = 'published',
       created_at = NOW()
 WHERE status     = 'scheduled'
   AND publish_at &lt;= NOW()
RETURNING id, title, slug;</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The trick is doing the find and the flip as <strong>one</strong> statement. A naive version reads the due posts, then loops and updates each one, but between the read and the write a second scheduler tick (or a server restart) can grab the same rows and publish them again. Here the <code class="inline">WHERE</code> filter and the <code class="inline">SET</code> happen inside a single atomic <code class="inline">UPDATE</code>: Postgres locks the matching rows, flips them, and <code class="inline">RETURNING</code> hands back exactly what changed so I can log it. I reset <code class="inline">created_at</code> to <code class="inline">NOW()</code> so the post appears at the top of the feed at its real publish moment, not the moment it was drafted. The identical query runs once at startup, so anything that came due while the server was off gets caught immediately.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># A post scheduled for 09:00, server checks at 09:00:30

before:  { id:42, title:"Self-hosting on a mini PC",
           status:"scheduled",
           publish_at:"2026-06-27T09:00:00Z",
           created_at:"2026-06-25T22:10:00Z" }   # hidden from readers

# scheduler tick runs the UPDATE above at 09:00:30

after:   { id:42, title:"Self-hosting on a mini PC",
           status:"published",                    # now public
           publish_at:"2026-06-27T09:00:00Z",
           created_at:"2026-06-27T09:00:30Z" }    # bumped to publish time
# RETURNING -&gt; log: "published #42: Self-hosting on a mini PC"</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 Engineering Decisions</h3>
        <div class="blog-content-body">
<ul><li><b>Full-text search in the database, not in JS</b>: Search runs on a generated Postgres <code class="inline">tsvector</code> column with a GIN index, so a query is matched by the database instead of looping over every post in Node. It stays fast as the post count grows and ranks results by relevance for free.</li>
<li><b>An atomic view counter</b>: Reading a post bumps its view count with a single <code class="inline">UPDATE... SET views = views + 1</code> rather than read-then-write, so concurrent readers never clobber each other’s increments and no view is silently lost.</li>
<li><b>No framework, no build step on the front-end</b>: The entire reader, dashboard, and Markdown editor live in one vanilla-JS page, no React, no bundler, nothing to compile. It loads instantly, deploys by copying a file, and there’s zero build pipeline to break on a mini PC.</li></ul>
        </div>
        <br>
        <h3>05 The Writing Experience</h3>
        <div class="blog-content-body">
<p class="p-text">The part I cared most about is the one only I see: writing. The editor renders Markdown live beside the text as I type, using <code class="inline">marked</code> on the client, so there’s no save-refresh-check loop. Each post carries tags, an optional cover image, and a status.</p>
<p class="p-text">Status is a small state machine, draft, scheduled, or published, and the dashboard counts each bucket plus total views. Drafts and scheduled posts stay invisible to readers; only the scheduler or an explicit publish makes a post public. Reading time comes from word count, related posts from shared tags.</p>

<strong>Public reads, private writes.</strong> Anyone can read the blog with no account at all. Logging in is only for writing, the editor, the dashboard, and every mutating endpoint sit behind <code class="inline">requireAuth</code>. That single split is what lets the same app be both a public site and a private CMS.
        </div>
        <br>
        <h3>06 Where It Actually Runs</h3>
        <div class="blog-content-body">
<p>ThoughtLog needs Node and PostgreSQL, and that’s it. It runs on a Linux mini PC sitting on my desk, the same machine that hosts my other projects, kept alive across reboots and crashes with <strong>PM2</strong>.</p>
<p class="p-text">Instead of opening a router port or paying for a VPS, the site reaches the internet through a Cloudflare Tunnel. Cloudflare holds the public endpoint and the tunnel dials out from the mini PC, no inbound port, no exposed public IP. TLS terminates at Cloudflare’s edge.</p>

<strong>It’s live now</strong> at <code class="inline">blog.rafiarsya.com</code>, a real full-stack app with a real database, running on hardware I own for effectively zero monthly cost. Self-hosting was a deliberate choice: it’s the cheapest way to run a stateful Node + Postgres app full-time, and it’s the DevOps muscle I actually want to build.
        </div>
        <br>
        <h3>07 What It Demonstrates</h3>
        <div class="blog-content-body">
<ul><li><b>REST API Design</b>: A clean split of public reads and authenticated writes, with one middleware guard doing the gatekeeping, the shape of a real backend, not a toy.</li>
<li><b>Real Authentication</b>: bcrypt password hashing, a signed JWT in an httpOnly cookie, and server-side route guards, the actual moving parts of login, not a hard-coded password.</li>
<li><b>PostgreSQL in Depth</b>: A real schema with parameterized queries, a generated tsvector + GIN index for search, an atomic view counter, and array columns for tags.</li>
<li><b>Background Jobs &amp; DevOps</b>: An in-process scheduler publishing due posts every minute, plus the full self-hosting story: PM2, Docker, and a Cloudflare Tunnel keeping it live.</li></ul>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Node.js</span>
<span class="badge blog-badge badge-neutral">Express</span>
<span class="badge blog-badge badge-neutral">PostgreSQL</span>
<span class="badge blog-badge badge-neutral">pg</span>
<span class="badge blog-badge badge-neutral">bcryptjs</span>
<span class="badge blog-badge badge-neutral">jsonwebtoken</span>
<span class="badge blog-badge badge-neutral">marked</span>
<span class="badge blog-badge badge-neutral">Vanilla JS</span>
<span class="badge blog-badge badge-neutral">PM2</span>
<span class="badge blog-badge badge-neutral">Docker</span>
<span class="badge blog-badge badge-neutral">Cloudflare Tunnel</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://blog.rafiarsya.com/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">blog.rafiarsya.com</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07/thoughtlog" rel="noopener noreferrer" target="_blank">
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
