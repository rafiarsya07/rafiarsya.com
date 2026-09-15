<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-purple">Node.js</span><span class="badge blog-badge badge-blue">Express</span><span class="badge blog-badge badge-green">PostgreSQL</span><span class="badge blog-badge badge-neutral">Self-Hosting</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Nalar: Building My Own Blog CMS From Scratch</h1>
        <br>
        <span>No WordPress, no Ghost, no static-site generator. A full-stack blog with its own CMS: Markdown with live preview, scheduled posts, tags, full-text search and real authentication, running on a mini PC under my desk.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; ~15 min</span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <div class="blog-content-body">
<figure class="rf-figure-lg"><img alt="Nalar home page, the post feed beside the author sidebar" decoding="async" src="image/assets/nalar/live-home.jpg"/><figcaption class="img-caption">Nalar as it looks today, live at blog.rafiarsya.com</figcaption></figure>
        </div>
        <br>
        <h3>01 Why Not Just Install WordPress</h3>
        <div class="blog-content-body">
<p>Honest answer: I wanted to write about my projects, and I had never built the kind of thing I was about to write about.</p>
<p>A blog looks simple from outside. You type, you press publish, a page appears. Underneath there is a schema, an auth boundary, a status model, a scheduler, a search index and a deployment story. <mark class="hl">Every one of those is something I wanted to understand by building, not by configuring.</mark></p>
<p>Off-the-shelf platforms hand you those parts already solved and hidden. WordPress would have taken an afternoon and taught me nothing. Ghost is beautiful, and I would have spent the time learning its admin panel instead of learning how an admin panel is made.</p>
<p>A static-site generator would have been cheapest of all. It also skips the half of the problem I was interested in: what happens when content lives in a database and a server has to decide who may change it.</p>
<p class="p-callout">So the rule was: nothing off the shelf for anything that is the actual product. Express and Postgres are infrastructure, so they are allowed. The CMS on top of them had to be mine.</p>
<p>That rule costs something, and pretending otherwise would be dishonest. A platform gives you spam filtering, image optimisation, a plugin ecosystem, an editor other people have already tested, and security patches you never think about. Build it yourself and all of that is either missing or your problem.</p>
<p>What you get back is that <span class="markblue">every behaviour in the system is one you chose</span>. When something breaks, the explanation is in code you wrote, not in a settings page you have not found yet.</p>
<p>For a product with users that trade is usually the wrong way round. For a personal blog whose main job is teaching me something, it is the entire point.</p>
<p>The result is <mark class="hl">Nalar</mark>, live at <code class="inline">blog.rafiarsya.com</code>. A blog for readers and a private CMS for me, both halves the same Express app.</p>
        </div>
        <br>
        <h3>02 What It Actually Does</h3>
        <div class="blog-content-body">
<p>From the reader's side it is an ordinary blog. A feed of posts, tag filtering, search, related posts, reading time and view counts. No account, no cookie banner, nothing to sign up for.</p>
<p>From my side it is an editor and a dashboard. I write in Markdown with a live preview beside the text. A post can be saved as a draft, published now, or scheduled, and the server publishes it without me being there. The dashboard counts drafts, scheduled posts, published posts and total views.</p>
<ul>
<li><b>Markdown with live preview</b>: rendered on the client with <code class="inline">marked</code>, so there is no save, refresh and check loop while writing.</li>
<li><b>Three post statuses</b>: draft, scheduled and published, and only the last one is visible to anybody not logged in.</li>
<li><b>Tags</b>: a Postgres array column, used for filtering and for related posts.</li>
<li><b>Full-text search</b>: matched by the database, not by looping over posts in Node.</li>
<li><b>Real authentication</b>: bcrypt hashing, a signed JWT in an httpOnly cookie, and a guard on every route that can change data.</li>
</ul>
<p>Reading that list back, the feature that took longest is the one that sounds smallest. <span class="marksalmon">Scheduling is two words in a feature list and a concurrency problem in the code.</span> Section 05 is about why.</p>
        </div>
        <br>
        <h3>03 The Data Model</h3>
        <div class="blog-content-body">
<p>Almost everything interesting about this app is decided by one table. A post carries its content, its status, when it should go live, its tags, and a search vector the database keeps up to date itself.</p>
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
<p>Two choices there are worth defending.</p>
<p>First, tags are an array column, not a tags table with a join table between. For a personal blog with a few dozen posts, a join table means three tables and two joins to answer something <code class="inline">WHERE 'postgres' = ANY(tags)</code> answers directly. A multi-author product with tag management screens would get the normalised version. This is not that.</p>
<p>The cost is real and worth naming. Renaming a tag everywhere is an array update instead of one row. Nothing stops me typing <code class="inline">postgres</code> in one post and <code class="inline">Postgres</code> in another. <span class="marksalmon">Both are cheap to live with at this size and expensive at a larger one.</span> That is what makes it a decision rather than a shortcut.</p>
<p>Second, <code class="inline">search_vec</code> is a generated stored column. Postgres computes it on every insert and update and keeps it in sync forever. <mark class="hl">No code path in the app can forget to reindex a post after an edit.</mark> The bug where search results go stale simply does not exist.</p>
<p>A stored generated column is written to disk like a normal one, so it costs a little space and a little write time. In exchange you never think about it again. The alternative most tutorials show is a trigger, which is more code doing the same job somewhere easier to forget.</p>
        </div>
        <br>
        <h3>04 Public Reads, Private Writes</h3>
        <div class="blog-content-body">
<p>One decision makes a single app work as both a public site and a private CMS: where the auth boundary sits. Not around a folder. Not around an admin subdomain. <mark class="hl">Around the verbs.</mark></p>
<figure class="rf-diagram">
<svg viewBox="0 0 600 230" role="img" aria-label="Diagram showing public read routes on one side of a requireAuth boundary and authenticated write routes on the other">
  <text x="24" y="30" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">ANYONE</text>
  <rect x="24" y="42" width="230" height="42" rx="8" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="40" y="68" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f7a45">GET /api/posts</text>
  <rect x="24" y="92" width="230" height="42" rx="8" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="40" y="118" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f7a45">GET /api/posts/:slug</text>
  <text x="24" y="160" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">Published rows only. The filter is</text>
  <text x="24" y="178" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">in the query, not in the front end.</text>

  <line x1="300" y1="24" x2="300" y2="206" stroke="#c9ccd1" stroke-width="1.5" stroke-dasharray="5 5"/>
  <rect x="252" y="104" width="96" height="26" rx="13" fill="#ffffff" stroke="#c9ccd1" stroke-width="1"/>
  <text x="300" y="121" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#6b7280">requireAuth</text>

  <text x="370" y="30" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">SIGNED IN, ONE ACCOUNT</text>
  <rect x="346" y="42" width="230" height="42" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="362" y="68" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f6fb3">POST /api/posts</text>
  <rect x="346" y="92" width="230" height="42" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="362" y="118" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f6fb3">PUT /api/posts/:id</text>
  <text x="346" y="160" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">JWT in an httpOnly cookie, so no</text>
  <text x="346" y="178" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">script on the page can read it.</text>

  <text x="24" y="212" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">One guard, one place to get right.</text>
</svg>
<figcaption class="img-caption"><b>The auth boundary</b>: drawn around the verbs, not around a folder</figcaption>
</figure>
<div class="p-code-label">the whole authorisation model, in four routes</div>
<pre class="p-code">GET  /api/posts        public       published posts only, newest first
GET  /api/posts/:slug  public       one post, and bump its view counter
POST /api/posts        requireAuth  create as draft, scheduled or published
PUT  /api/posts/:id    requireAuth  edit content, or flip status and publish</pre>
<p>A reader never touches a route that can change data. A writer signs in once and gets the editor, the dashboard and every mutating endpoint. There is exactly one guard, <code class="inline">requireAuth</code>, so there is exactly one piece of code to get right.</p>
<p>The read routes are also where filtering happens. <code class="inline">GET /api/posts</code> does not return everything and let the front end hide drafts. It returns published posts only.</p>
<p>Give the front end that job and every new client leaks unpublished writing. Every RSS feed. Every accidental curl of the API. <span class="marksalmon">Filtering in the browser is not a security control, it is a display preference that looks like one.</span></p>
<p>Passwords are hashed with bcrypt, never stored or logged any other way. Bcrypt matters here rather than a plain hash because it is deliberately slow, and its cost factor can be raised as hardware gets faster. That was the whole point of the 1999 paper. A fast hash like SHA-256 is the wrong tool for passwords precisely because it is fast.</p>
<p>The JWT lives in an httpOnly cookie, not in localStorage, so an injected script cannot read it. That is the difference between a cross-site scripting bug being a bad day and being a stolen session.</p>
<p>All SQL sits in one file, <code class="inline">server/db.js</code>, parameterized only. There is nowhere in the codebase a string gets concatenated into a statement.</p>
        </div>
        <br>
        <h3>05 The One Query That Makes Scheduling Work</h3>
        <div class="blog-content-body">
<p>A scheduled post sits in the table with <code class="inline">status = 'scheduled'</code> and a <code class="inline">publish_at</code> in the future, invisible to readers. Something has to notice when its time arrives.</p>
<figure class="rf-diagram">
<svg viewBox="0 0 600 214" role="img" aria-label="State machine diagram of a post moving from draft to scheduled to published">
  <rect x="24" y="82" width="124" height="56" rx="10" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="86" y="108" text-anchor="middle" font-family="system-ui, sans-serif" font-size="14" font-weight="600" fill="#404040">draft</text>
  <text x="86" y="126" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">private</text>

  <text x="193" y="101" text-anchor="middle" font-family="system-ui, sans-serif" font-size="10" fill="#9ca3af">set publish_at</text>
  <line x1="154" y1="112" x2="226" y2="112" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M226 107 L234 112 L226 117 Z" fill="#c9ccd1"/>

  <rect x="238" y="82" width="124" height="56" rx="10" fill="#fdf6ec" stroke="#f0e0c8" stroke-width="1"/>
  <text x="300" y="108" text-anchor="middle" font-family="system-ui, sans-serif" font-size="14" font-weight="600" fill="#8a6d3b">scheduled</text>
  <text x="300" y="126" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#b99b6b">still private</text>

  <text x="407" y="101" text-anchor="middle" font-family="system-ui, sans-serif" font-size="10" fill="#9ca3af">the sweep</text>
  <line x1="368" y1="112" x2="440" y2="112" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M440 107 L448 112 L440 117 Z" fill="#c9ccd1"/>

  <rect x="452" y="82" width="124" height="56" rx="10" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="514" y="108" text-anchor="middle" font-family="system-ui, sans-serif" font-size="14" font-weight="600" fill="#2f7a45">published</text>
  <text x="514" y="126" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#7ea98c">readers see it</text>

  <path d="M86 82 C 86 34, 514 34, 514 74" fill="none" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M509 74 L514 82 L519 74 Z" fill="#c9ccd1"/>
  <text x="300" y="38" text-anchor="middle" font-family="system-ui, sans-serif" font-size="10" fill="#9ca3af">publish now</text>

  <text x="24" y="180" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">The sweep runs once a minute and once at startup. It is a single UPDATE, so two</text>
  <text x="24" y="198" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">ticks racing each other cannot both publish the same post.</text>
</svg>
<figcaption class="img-caption"><b>Three states</b>: only the last one is visible to anybody who is not signed in</figcaption>
</figure>
<p>The obvious version is a loop. Select the posts that are due, then update each one. That version is wrong, and it only breaks occasionally, which is the worst kind of wrong.</p>
<p>Between the select and the update, a second tick or a restarted server can read the same rows and publish them again.</p>
<div class="p-code-label">scheduler.js, once a minute and once at startup</div>
<pre class="p-code">UPDATE posts
   SET status     = 'published',
       created_at = NOW()
 WHERE status     = 'scheduled'
   AND publish_at &lt;= NOW()
RETURNING id, title, slug;</pre>
<p>Finding and flipping happen in one statement. Postgres locks the matching rows, changes them, and <code class="inline">RETURNING</code> hands back exactly what changed so the server can log it. Two ticks cannot both win, because by the time the second one checks the <code class="inline">WHERE</code> clause those rows are no longer scheduled.</p>
<p>The general lesson is worth keeping. <mark class="hl">A read followed by a write is two decisions with a gap between them, and anything can happen in the gap.</mark> Retries, locks and flags make the gap narrower. One statement makes it not exist.</p>
<p>Resetting <code class="inline">created_at</code> to <code class="inline">NOW()</code> is a small thing readers notice. The post appears at the top of the feed when it went live, not when I started drafting it two weeks earlier.</p>
<p>Running the same query once at startup covers the other hole. Anything that came due while the machine was rebooting publishes the moment it comes back, instead of waiting a tick or being skipped.</p>
        </div>
        <br>
        <h3>06 Search Belongs in the Database</h3>
        <div class="blog-content-body">
<p>The first version of search was a filter in JavaScript. Fetch the posts, lowercase everything, check whether the query appears in the title or body. Six lines, worked fine, and it was going to break the moment there were more posts than fit comfortably in memory.</p>
<p>It was also wrong in a way that had nothing to do with size. <span class="marksalmon">Substring matching does not understand language.</span> A search for "deploying" misses a post that says "deployment". A search for "run" matches "running", "runtime" and "brunt".</p>
<p>Postgres full text search fixes both, because it does not store the text. It stores lexemes.</p>
<figure class="rf-diagram">
<svg viewBox="0 0 600 256" role="img" aria-label="Diagram of the full text search pipeline from post text through to_tsvector and a GIN index, and from a query through websearch_to_tsquery to a ranked match">
  <text x="24" y="28" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">ON WRITE, AUTOMATICALLY</text>
  <rect x="24" y="40" width="164" height="48" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="106" y="62" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">title and content</text>
  <text x="106" y="79" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">raw markdown</text>
  <line x1="194" y1="64" x2="210" y2="64" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M210 59 L218 64 L210 69 Z" fill="#c9ccd1"/>
  <rect x="224" y="40" width="164" height="48" rx="8" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="306" y="62" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#2f7a45">to_tsvector('english')</text>
  <text x="306" y="79" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#7ea98c">stems and drops stop words</text>
  <line x1="394" y1="64" x2="410" y2="64" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M410 59 L418 64 L410 69 Z" fill="#c9ccd1"/>
  <rect x="424" y="40" width="152" height="48" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="500" y="62" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#404040">search_vec</text>
  <text x="500" y="79" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">stored, plus a GIN index</text>

  <text x="24" y="120" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">"Deploying the blog" becomes</text>
  <rect x="216" y="106" width="76" height="22" rx="11" fill="#ffffff" stroke="#e5e7eb" stroke-width="1"/>
  <text x="254" y="121" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#6b7280">'deploy'</text>
  <rect x="300" y="106" width="62" height="22" rx="11" fill="#ffffff" stroke="#e5e7eb" stroke-width="1"/>
  <text x="331" y="121" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#6b7280">'blog'</text>
  <text x="372" y="121" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">so "deployment" finds it too</text>

  <line x1="24" y1="146" x2="576" y2="146" stroke="#f1f3f6" stroke-width="1"/>

  <text x="24" y="174" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">ON SEARCH</text>
  <rect x="24" y="186" width="164" height="48" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="106" y="216" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">what the reader typed</text>
  <line x1="194" y1="210" x2="210" y2="210" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M210 205 L218 210 L210 215 Z" fill="#c9ccd1"/>
  <rect x="224" y="186" width="164" height="48" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="306" y="209" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#2f6fb3">websearch_to_tsquery</text>
  <text x="306" y="226" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#8aa4bf">same stemming, same rules</text>
  <line x1="394" y1="210" x2="410" y2="210" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M410 205 L418 210 L410 215 Z" fill="#c9ccd1"/>
  <rect x="424" y="186" width="152" height="48" rx="8" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="500" y="209" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="11" fill="#2f7a45">@@ then ts_rank</text>
  <text x="500" y="226" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#7ea98c">match, then order by relevance</text>
</svg>
<figcaption class="img-caption"><b>Full text search</b>: the same stemmer runs on the post and on the query, which is why they meet</figcaption>
</figure>
<p>A <code class="inline">tsvector</code> is the document reduced to word stems with their positions, with stop words like "the" and "of" dropped. The same transformation runs on the query. <mark class="hl">That is why "deploying" and "deployment" meet in the middle: both reduce to <code class="inline">deploy</code>.</mark></p>
<p>The GIN index over that column is built for this exact shape of lookup. It maps each lexeme to the rows containing it, so a search reads an index instead of every row.</p>
<div class="p-code-label">what the search endpoint runs</div>
<pre class="p-code">SELECT id, title, slug, excerpt,
       ts_rank(search_vec, websearch_to_tsquery('english', $1)) AS rank
  FROM posts
 WHERE status = 'published'
   AND search_vec @@ websearch_to_tsquery('english', $1)
 ORDER BY rank DESC
 LIMIT 20;</pre>
<p><code class="inline">websearch_to_tsquery</code> is the parser worth knowing. It takes the syntax people already type into search boxes: quoted phrases, <code class="inline">or</code>, a leading minus to exclude a word. More importantly it does not throw on input it cannot parse, which the stricter <code class="inline">to_tsquery</code> does. <span class="markblue">For a public search box, that is the difference between a bad query and a 500.</span></p>
<p>Then <code class="inline">@@</code> asks whether the document matches, and <code class="inline">ts_rank</code> scores how well. Filtering and ranking both happen next to the data, and the endpoint returns twenty rows instead of the whole table.</p>
<p>The same instinct shows up in the view counter. Reading a post runs <code class="inline">UPDATE posts SET views = views + 1</code> rather than reading the number, adding one in Node, and writing it back. Two readers arriving together both get counted, because the addition happens inside the database. Same lesson as the scheduler, in three words instead of five lines.</p>
        </div>
        <br>
        <h3>07 No Framework on the Front End</h3>
        <div class="blog-content-body">
<p>The reader, the dashboard and the Markdown editor are one vanilla JavaScript page. No React, no bundler, no build step, nothing to compile before deploying.</p>
<p>Deliberate trade, and both sides are real. I gave up component structure and the ecosystem around it. I got a deploy that is copying a file, a page that loads instantly on a slow connection, and no chance a toolchain upgrade breaks the site while I am not looking. <span class="markblue">On a mini PC I maintain in my spare time, a build pipeline is a liability, not an asset.</span></p>
<p>Where the absence is genuinely felt is state. There are three or four pieces of it on the dashboard: the current filter, the open post, the editor contents, the preview. Keeping them in sync is manual. With four that is fine. At twenty it would not be, and the right answer then is to adopt a framework, not to reinvent a worse one.</p>
<p>The editor is the part I use most and the part nobody else sees. It renders Markdown live beside the text as I type. Sounds trivial, and it is the difference between writing and not writing.</p>
<p>The rest is small. Post status is a three-state machine. The dashboard counts each bucket plus total views. Reading time comes from a word count. Related posts come from shared tags. <mark class="hl">None of it is clever, and all of it is the difference between a database with text in it and something I want to open.</mark></p>
        </div>
        <br>
        <h3>08 Where It Runs</h3>
        <div class="blog-content-body">
<p>Nalar needs Node and PostgreSQL and nothing else. It runs on a Linux mini PC on my desk, the same machine that hosts my other projects, kept alive across crashes and reboots by PM2.</p>
<p>Instead of opening a port on my router or renting a VPS, the site reaches the internet through a <span class="markblue">Cloudflare Tunnel</span>. The model is outbound only. A small daemon on the mini PC dials out to Cloudflare and holds that connection open, and Cloudflare routes public requests back down it.</p>
<p>So the firewall can allow those outbound connections and block every inbound one. No port forwarded, no public IP pointing at my house. TLS terminates at Cloudflare's edge.</p>
<p>That is why I would pick this over port forwarding again. With a forwarded port the machine is addressable from the internet, and its exposure is whatever is listening on that port. <mark class="hl">With a tunnel there is nothing to address.</mark></p>
<p>It costs effectively nothing per month, which matters when you are a student. That was not the main reason though. Self-hosting is the part of software I had the least practice at, and a site that has to stay up is the only way to get that practice.</p>
        </div>
        <br>
        <h3>09 What I Would Do Differently</h3>
        <div class="blog-content-body">
<ul>
<li><b>Render Markdown once, on write, not on every read</b>: the client renders it each time a post opens. Storing the rendered HTML beside the source at write time would cut that to zero. I have not, because it adds a second source of truth that can drift, so it needs doing carefully rather than quickly.</li>
<li><b>Move the scheduler out of process</b>: the publishing job runs inside the same Node process as the web server. Fine for one machine and one writer. With two instances both of them tick, and while the atomic update means nothing publishes twice, the design leans on a safety net instead of being correct by structure.</li>
<li><b>Add a real backup story</b>: the database lives on one disk, in one machine, in one room. A nightly dump pushed off site is an hour of work I keep deferring, and it is the single most likely thing to hurt.</li>
<li><b>Write tests around the auth guard</b>: it is the one place where a mistake is not a bug but a leak, and right now it is verified by me remembering to check it.</li>
</ul>
<p>What I would not change is the scope. Building the small version of a CMS taught me more about schemas, auth boundaries and background jobs than a year of configuring someone else's would have. <mark class="hl">The blog exists so I can write about what I build, and building the blog turned out to be the first thing worth writing about.</mark></p>
        </div>
        <br>
        <h3>10 References</h3>
        <div class="blog-content-body">
<ol class="blog-refs">
<li>PostgreSQL. <i>Full Text Search.</i> <span class="ref-src">tsvector, tsquery, the @@ operator and ts_rank.</span> <a href="https://www.postgresql.org/docs/current/textsearch-intro.html" target="_blank" rel="noopener">postgresql.org/docs/current/textsearch-intro.html</a></li>
<li>PostgreSQL. <i>Text Search Functions and Operators.</i> <span class="ref-src">websearch_to_tsquery and why it does not raise on bad input.</span> <a href="https://www.postgresql.org/docs/current/functions-textsearch.html" target="_blank" rel="noopener">postgresql.org/docs/current/functions-textsearch.html</a></li>
<li>PostgreSQL. <i>Generated Columns.</i> <span class="ref-src">Stored generated columns, computed on write.</span> <a href="https://www.postgresql.org/docs/current/ddl-generated-columns.html" target="_blank" rel="noopener">postgresql.org/docs/current/ddl-generated-columns.html</a></li>
<li>PostgreSQL. <i>GIN Indexes.</i> <a href="https://www.postgresql.org/docs/current/gin-intro.html" target="_blank" rel="noopener">postgresql.org/docs/current/gin-intro.html</a></li>
<li>PostgreSQL. <i>UPDATE.</i> <span class="ref-src">The RETURNING clause used by the scheduler sweep.</span> <a href="https://www.postgresql.org/docs/current/sql-update.html" target="_blank" rel="noopener">postgresql.org/docs/current/sql-update.html</a></li>
<li>Jones, M., Bradley, J. and Sakimura, N. (2015). <i>RFC 7519: JSON Web Token (JWT).</i> <a href="https://www.rfc-editor.org/rfc/rfc7519" target="_blank" rel="noopener">rfc-editor.org/rfc/rfc7519</a></li>
<li>Provos, N. and Mazi&egrave;res, D. (1999). <i>A Future-Adaptable Password Scheme.</i> USENIX Annual Technical Conference, FREENIX Track. <span class="ref-src">The bcrypt paper.</span> <a href="https://www.usenix.org/legacy/events/usenix99/full_papers/provos/provos.pdf" target="_blank" rel="noopener">usenix.org</a></li>
<li>OWASP. <i>Cross Site Scripting Prevention Cheat Sheet.</i> <span class="ref-src">Why a session token belongs in an httpOnly cookie.</span> <a href="https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html" target="_blank" rel="noopener">cheatsheetseries.owasp.org</a></li>
<li>Cloudflare. <i>Cloudflare Tunnel.</i> <span class="ref-src">The outbound only connection model.</span> <a href="https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/" target="_blank" rel="noopener">developers.cloudflare.com</a></li>
<li>PM2. <i>Process Management Quick Start.</i> <a href="https://pm2.keymetrics.io/docs/usage/quick-start/" target="_blank" rel="noopener">pm2.keymetrics.io</a></li>
<li>marked. <i>Markdown parser and compiler.</i> <a href="https://marked.js.org/" target="_blank" rel="noopener">marked.js.org</a></li>
</ol>
        </div>
        <br>
        <div class="d-flex">
            <a href="https://blog.rafiarsya.com" target="_blank" rel="noopener" class="btn btn-main button-border d-flex align-items-center">
                <span>Read the full blog<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
            </a>
        </div>
        <br><br>
</div>
