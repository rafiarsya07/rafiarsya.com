<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-purple">Node.js</span><span class="badge blog-badge badge-blue">Express</span><span class="badge blog-badge badge-green">PostgreSQL</span><span class="badge blog-badge badge-neutral">Self-Hosting</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Nalar: Building My Own Blog CMS From Scratch</h1>
        <br>
        <span>No WordPress, no Ghost, no static-site generator. I built a full-stack blog with its own CMS: Markdown with live preview, scheduled posts, tags, full-text search and real authentication, running on a mini PC under my desk.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; ~18 min</span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <div class="blog-content-body">
<figure class="rf-figure-lg"><img alt="Nalar home page, the post feed beside the author sidebar" decoding="async" src="image/assets/nalar/live-home.jpg"/><figcaption class="img-caption">Nalar as it looks today, live at blog.rafiarsya.com</figcaption></figure>
        </div>
        <br>
        <h3>01 Why Not Just Install WordPress</h3>
        <div class="blog-content-body">
<p>The honest answer is that I wanted to write about my projects, and I realised I had never built the kind of thing I was about to write about. A blog looks simple from the outside. You type, you press publish, a page appears. Underneath there is a schema, an auth boundary, a status model, a scheduler, a search index and a deployment story, and every one of those is a thing I wanted to understand by building rather than by configuring.</p>
<p>Every off-the-shelf platform hands you those parts already solved and hidden. WordPress would have taken an afternoon and taught me nothing. Ghost is beautiful and I would have spent the time learning its admin panel instead of learning how an admin panel is made. A static-site generator would have been the cheapest option of all, and it would have skipped the entire half of the problem I was interested in: what happens when content lives in a database and a server has to decide who is allowed to change it.</p>
<p class="p-callout">So the rule I set was: nothing off the shelf for anything that is the actual product. Express and Postgres are infrastructure, so they are allowed. The CMS on top of them had to be mine.</p>
<p>The result is <mark class="hl">Nalar</mark>, live at <code class="inline">blog.rafiarsya.com</code>. It is a personal blog for readers and a private CMS for me, and both halves are the same Express app.</p>
        </div>
        <br>
        <h3>02 What It Actually Does</h3>
        <div class="blog-content-body">
<p>From the reader's side it is an ordinary blog: a feed of posts, tag filtering, search, related posts, reading-time estimates and view counts. No account, no cookie banner, nothing to sign up for.</p>
<p>From my side it is an editor and a dashboard. I write in Markdown with a live preview rendering beside the text as I type. A post can be saved as a draft, published immediately, or scheduled for a time in the future, at which point the server publishes it without me being there. The dashboard counts drafts, scheduled posts, published posts and total views.</p>
<ul>
<li><b>Markdown with live preview</b>: rendered on the client with <code class="inline">marked</code>, so there is no save, refresh and check loop while writing.</li>
<li><b>Three post statuses</b>: draft, scheduled and published, with only the last one visible to anybody who is not logged in.</li>
<li><b>Tags</b>: stored as a Postgres array column, used for filtering and for finding related posts.</li>
<li><b>Full-text search</b>: matched by the database rather than by looping over posts in Node.</li>
<li><b>Real authentication</b>: bcrypt hashing, a signed JWT in an httpOnly cookie, and a middleware guard on every route that can change data.</li>
</ul>
        </div>
        <br>
        <h3>03 The Data Model</h3>
        <div class="blog-content-body">
<p>Almost everything interesting about the app is decided by one table. A post carries its content, its status, the time it is meant to go live, its tags, and a search vector the database maintains for itself.</p>
<div class="p-code-label">posts, the table the whole app turns on</div>
<pre class="p-code">id           serial primary key
title        text not null
slug         text unique not null
content      text not null          -- markdown, rendered on read
excerpt      text
cover_image  text
tags         text[]                 -- array column, not a join table
status       text not null          -- 'draft' | 'scheduled' | 'published'
publish_at   timestamptz            -- only meaningful when scheduled
created_at   timestamptz default now()
views        integer default 0
search_vec   tsvector generated always as (
               to_tsvector('english', title || ' ' || content)
             ) stored</pre>
<p>Two decisions there are worth defending. Tags are an array column rather than a tags table with a join table between them. For a personal blog with a few dozen posts, a join table is three tables and two joins to answer a question that <code class="inline">WHERE 'postgres' = ANY(tags)</code> answers directly. If this were a multi-author product with tag management screens I would normalise it. It is not, so I did not.</p>
<p>The second is <code class="inline">search_vec</code> being a generated stored column. The database computes it on every write and keeps it in sync forever, so there is no code path anywhere in the app that can forget to reindex a post after an edit. The class of bug where search results go stale simply does not exist.</p>
        </div>
        <br>
        <h3>04 Public Reads, Private Writes</h3>
        <div class="blog-content-body">
<p>The single design decision that makes one app serve as both a public site and a private CMS is where the auth boundary sits. It is not around a folder or an admin subdomain. It is around the verbs.</p>
<div class="p-code-label">the whole authorisation model, in four routes</div>
<pre class="p-code">GET  /api/posts        public       published posts only, newest first
GET  /api/posts/:slug  public       one post, and bump its view counter
POST /api/posts        requireAuth  create as draft, scheduled or published
PUT  /api/posts/:id    requireAuth  edit content, or flip status and publish</pre>
<p>A reader never touches a route that can change data. A writer authenticates once and gets the editor, the dashboard and every mutating endpoint. There is exactly one guard, <code class="inline">requireAuth</code>, and it is the only thing standing between the two worlds, which means there is exactly one piece of code to get right.</p>
<p>The read routes are also where the filtering happens. <code class="inline">GET /api/posts</code> does not return everything and let the front-end hide drafts. It returns published posts only. If the front-end had that responsibility, then every new client, every RSS feed, every accidental curl of the API would leak unpublished writing.</p>
<p>Passwords are hashed with bcrypt and never stored or logged in any other form. The JWT goes into an httpOnly cookie rather than localStorage, so a script on the page cannot read it. All SQL lives in one file, <code class="inline">server/db.js</code>, with parameterized queries only, so there is no place in the codebase where a string gets concatenated into a statement.</p>
        </div>
        <br>
        <h3>05 The One Query That Makes Scheduling Work</h3>
        <div class="blog-content-body">
<p>Scheduled publishing sounds like a feature and turns out to be a concurrency problem. A scheduled post sits in the table with <code class="inline">status = 'scheduled'</code> and a <code class="inline">publish_at</code> in the future, invisible to readers. Something has to notice when its time arrives.</p>
<p>The obvious implementation is a loop: select the posts that are due, then update each one. That version is wrong, and it is wrong in a way that only shows up occasionally, which is the worst kind of wrong. Between the select and the update, a second scheduler tick or a server that restarted can read the same rows and publish them a second time.</p>
<div class="p-code-label">scheduler.js, once a minute and once at startup</div>
<pre class="p-code">UPDATE posts
   SET status     = 'published',
       created_at = NOW()
 WHERE status     = 'scheduled'
   AND publish_at &lt;= NOW()
RETURNING id, title, slug;</pre>
<p>Finding and flipping happen in one statement. Postgres locks the matching rows, changes them, and <code class="inline">RETURNING</code> hands back exactly what changed so the server can log it. Two ticks racing each other cannot both win, because the second one no longer matches <code class="inline">status = 'scheduled'</code>.</p>
<p>Resetting <code class="inline">created_at</code> to <code class="inline">NOW()</code> is a small thing that matters to readers: the post appears at the top of the feed at the moment it went live, not at the moment I started drafting it two weeks earlier. And running the identical query once at startup means anything that came due while the machine was rebooting gets published the instant it comes back, instead of waiting for the next tick or being silently skipped.</p>
        </div>
        <br>
        <h3>06 Search Belongs in the Database</h3>
        <div class="blog-content-body">
<p>The first version of search was a filter in JavaScript. Fetch the posts, lowercase everything, check whether the query string appears in the title or the body. It worked, it took about six lines, and it was going to be wrong the moment there were more posts than fit comfortably in memory.</p>
<p>The replacement is the generated <code class="inline">tsvector</code> column with a GIN index on it. Postgres does the stemming, so a search for "deploying" finds a post that says "deployment". It ranks results by relevance rather than by whether the string happened to appear. The work happens next to the data instead of after a full table read, and it stays fast as the post count grows.</p>
<div class="p-code-label">what the search endpoint runs</div>
<pre class="p-code">SELECT id, title, slug, excerpt,
       ts_rank(search_vec, websearch_to_tsquery('english', $1)) AS rank
  FROM posts
 WHERE status = 'published'
   AND search_vec @@ websearch_to_tsquery('english', $1)
 ORDER BY rank DESC
 LIMIT 20;</pre>
<p>The same instinct shows up in the view counter. Reading a post increments its count with <code class="inline">UPDATE posts SET views = views + 1</code> rather than reading the number, adding one in Node and writing it back. Two readers arriving at the same moment both get counted, because the addition happens inside the database rather than in two racing copies of a number.</p>
        </div>
        <br>
        <h3>07 No Framework on the Front End</h3>
        <div class="blog-content-body">
<p>The reader, the dashboard and the Markdown editor are one vanilla JavaScript page. No React, no bundler, no build step, nothing to compile before deploying.</p>
<p>This was a deliberate trade and it is worth being honest about both sides. What I gave up is component structure and the ecosystem that comes with it. What I got is a deploy that consists of copying a file, a page that loads instantly on a cheap connection, and zero chance that a toolchain upgrade breaks the site while I am not looking. On a mini PC I maintain in my spare time, a build pipeline is a liability rather than an asset.</p>
<p>The editor is the part I use most and the part nobody else sees. It renders Markdown live beside the text as I type, which sounds trivial and is the difference between writing and not writing. Post status is a small state machine with three states, and the dashboard is a count of each bucket plus total views. Reading time comes from a word count. Related posts come from shared tags. None of it is clever, and all of it is the difference between a database with text in it and something I actually want to open.</p>
        </div>
        <br>
        <h3>08 Where It Runs</h3>
        <div class="blog-content-body">
<p>Nalar needs Node and PostgreSQL and nothing else. It runs on a Linux mini PC on my desk, the same machine that hosts my other projects, kept alive across crashes and reboots by PM2.</p>
<p>Instead of opening a port on my router or renting a VPS, the site reaches the internet through a Cloudflare Tunnel. Cloudflare holds the public endpoint and the tunnel dials outward from the mini PC, so there is no inbound port and no exposed public IP anywhere in the setup. TLS terminates at Cloudflare's edge. The machine at home is never directly addressable from the internet, which is the security property I actually wanted and the reason I would pick this over port forwarding again.</p>
<p>It costs effectively nothing to run per month, which matters when you are a student, but that was not the main reason. Self-hosting is the part of software I had the least practice at, and a site that has to stay up is the only way to get that practice.</p>
        </div>
        <br>
        <h3>09 What I Would Do Differently</h3>
        <div class="blog-content-body">
<ul>
<li><b>Render Markdown once, on write, not on every read</b>: right now the client renders the Markdown each time a post is opened. Storing the rendered HTML alongside the source at write time would cut the work per read to zero and make the reader page lighter. The reason I have not is that it introduces a second source of truth that can drift, so it needs doing carefully rather than quickly.</li>
<li><b>Move the scheduler out of process</b>: the publishing job runs inside the same Node process as the web server. That is fine for one machine and one writer. The moment there are two instances, both of them tick, and while the atomic update means nothing gets published twice, the design is leaning on a safety net instead of being correct by structure.</li>
<li><b>Add a real backup story</b>: the database lives on one disk in one machine in one room. A nightly dump pushed off site is an hour of work that I keep deferring, and it is the single most likely thing to hurt.</li>
<li><b>Write tests around the auth guard</b>: it is the one piece of code where a mistake is not a bug but a leak, and it is currently verified by me remembering to check it.</li>
</ul>
<p>The thing I would not change is the scope. Building the small version of a CMS taught me more about schemas, auth boundaries and background jobs than a year of configuring someone else's would have. The blog exists so I can write about what I build, and building the blog turned out to be the first thing worth writing about.</p>
        </div>
        <br>
        <div class="d-flex">
            <a href="https://blog.rafiarsya.com" target="_blank" rel="noopener" class="btn btn-main button-border d-flex align-items-center">
                <span>Read the full blog<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
            </a>
        </div>
        <br><br>
</div>
