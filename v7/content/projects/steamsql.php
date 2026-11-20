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

        <figure class="p-hero"><img alt="Steam Market Intelligence report with a live SQL chart" decoding="async" src="image/assets/steamsql/cover.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">SQLite</span>
                <span class="badge blog-badge badge-green">sql.js (WASM)</span>
                <span class="badge blog-badge badge-purple">Window Functions</span>
                <span class="badge blog-badge badge-orange">Recursive CTEs</span>
                <span class="badge blog-badge badge-neutral">Static Hosting</span>
            </div>
            <h1>Steam Market Intelligence</h1>
            <br>
            <span>A SQL analytics dashboard that runs a real SQLite database in the browser through WebAssembly, querying 1,400 games live. No backend.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Dataset</span><span class="p-meta-v">1,400 Games</span></span><span class="p-meta-item"><span class="p-meta-k">Engine</span><span class="p-meta-v">SQLite / WASM</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Every chart on the page is a real SQL query that runs in your browser when the page loads. There is also a console to write your own queries.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>SQLite in the browser</b>: sql.js (WebAssembly) loads the whole database client side</li>
<li><b>Real SQL</b>: window functions, CTEs, self-joins and rolling calculations</li>
<li><b>Useful questions</b>: best-rated genres, price versus reviews, hidden gems</li>
<li><b>Free to host</b>: a static site with nothing to keep running</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
<div class="rf-livegroup">
<figure class="rf-figure-lg"><img alt="Chart of average positive rating by genre" decoding="async" loading="lazy" src="image/assets/steamsql/genres.jpg"/><figcaption class="img-caption">Which genres earn the best reviews</figcaption></figure>
</div>
<div class="p-console">
<div class="p-console-tabs" role="tablist">
<button class="p-console-tab active" data-q="top">Top-Rated Games</button>
<button class="p-console-tab" data-q="genre">Genre × Price</button>
<button class="p-console-tab" data-q="year">Releases / Year</button>
<button class="p-console-tab" data-q="rank">RANK() / Genre</button>
<button class="p-console-tab" data-q="schema">Schema</button>
</div>
<div class="p-console-body">
<div class="p-console-sql-wrap">
<div class="p-console-sql-label">QUERY</div>
<pre class="p-console-sql" id="console-sql">SELECT name, developer, positive_ratings, negative_ratings,
       ROUND(1.0*positive_ratings/(positive_ratings+negative_ratings), 3) AS rating
FROM games_deduped
WHERE (positive_ratings+negative_ratings) &gt;= 100
ORDER BY rating DESC
LIMIT 5;</pre>
</div>
<button class="p-console-run" id="console-run">
<svg viewbox="0 0 24 24"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                        Run query
                                    </button>
<div class="p-console-result" id="console-result">
<div class="p-console-result-meta" id="console-meta">,  click Run query to execute, </div>
<div class="p-table-scroll"><table class="p-data-table" id="console-table"><thead></thead><tbody></tbody></table></div>
</div>
</div>
</div>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">SQLite</span>
<span class="badge blog-badge badge-neutral">sql.js (WASM)</span>
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">JavaScript</span>
<span class="badge blog-badge badge-neutral">Window Functions</span>
<span class="badge blog-badge badge-neutral">Recursive CTEs</span>
<span class="badge blog-badge badge-neutral">Cloudflare Pages</span>
</div>
</div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://steam.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
<span class="p-link-btn-label">Live Dashboard</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07/steam-sql-analytics" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
<span class="p-link-btn-label">GitHub</span>
</a>
<a class="p-link-btn" href="https://blog.rafiarsya.com/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8z"></path></svg>
<span class="p-link-btn-label">Read Blog Post</span>
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
