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
                <span class="badge blog-badge badge-blue">SQLite</span>
                <span class="badge blog-badge badge-green">sql.js (WASM)</span>
                <span class="badge blog-badge badge-purple">Window Functions</span>
                <span class="badge blog-badge badge-orange">Recursive CTEs</span>
                <span class="badge blog-badge badge-neutral">Static Hosting</span>
            </div>
            <h1>Steam Market Intelligence</h1>
            <br>
            <span>A live, in-browser SQL analytics dashboard, real SQLite compiled to WebAssembly, querying a 1,400-title game-market dataset on every page load. No backend, no precomputed export, just a database and a query engine running on the visitor&#x27;s machine.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Dataset</span><span class="p-meta-v">1,400 Games</span></span><span class="p-meta-item"><span class="p-meta-k">Engine</span><span class="p-meta-v">SQLite / WASM</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p class="p-text">This started as a SQL case study: a synthetic but statistically realistic game-market dataset and seven <code class="inline">.sql</code> files covering window functions, recursive CTEs, self-joins, and rolling calculations. The first version worked, but the dashboard was static HTML reading pre-exported JSON. It looked like a live analytics tool. It wasn't.</p>
<p class="p-text">So I rebuilt it to ship two files: <code class="inline">index.html</code> and the raw <code class="inline">steam_games.db</code>, running SQLite compiled to WebAssembly (sql.js) in the browser. Nothing is precomputed; every number on the page came from a query that just ran on your machine.</p>

<strong>The part I'm most happy with:</strong> a live SQL console at the bottom of the page, wired straight to the same <code class="inline">db.exec()</code> call the rest of the dashboard uses. You can run the sample queries or write your own <code class="inline">SELECT</code> against the real database, not a styled mockup of a terminal.
                                
<p>The dataset covers <strong>1,400 deduplicated game listings</strong> across a <strong>17-year release window (2008 to 2024)</strong>, joined against a genre bridge table for category-level analysis.</p>
        </div>
        <br>
        <h3>03 Which Genres Earn the Best Reception?</h3>
        <div class="blog-content-body">
<p>Average positive-rating ratio per genre, joined across the many-to-many game↔genre bridge table, <code class="inline">JOIN games_deduped → game_genres, GROUP BY genre_name</code>. <strong>Adventure</strong> and <strong>Sandbox</strong> titles edge out the rest, though the spread across all 15 genres is tight (65: 70%).</p>

<button class="p-sort-btn active" data-sort="rating">Sort by Rating</button>
<button class="p-sort-btn" data-sort="price">Sort by Avg. Price</button>
<button class="p-sort-btn" data-sort="count">Sort by Game Count</button>

Adventure

69.9%

Sandbox

69.8%

Indie

69.3%

Puzzle

69.0%

Visual Novel

68.4%

Strategy

68.2%

RPG

68.1%

Action

68.0%

Shooter

67.7%

Sports

67.5%

Horror

67.2%

Casual

66.6%

Racing

66.3%

Platformer

66.2%

Simulation

64.9%
        </div>
        <br>
        <h3>04 Does a Higher Price Mean a Better-Reviewed Game?</h3>
        <div class="blog-content-body">
<p>Games are bucketed by price tier with a <code class="inline">CASE WHEN</code> expression, then averaged for rating ratio, <code class="inline">GROUP BY</code> the derived bucket, not a stored column.</p>

<span class="p-gbar-bar-val">66.8%</span>
Free
n=105

<span class="p-gbar-bar-val">66.5%</span>
Budget<br/>&lt;$10
n=812

<span class="p-gbar-bar-val">67.3%</span>
Mid<br/>$10: 30
n=303

<span class="p-gbar-bar-val">77.2%</span>
Premium<br/>$30: 60
n=131

<span class="p-gbar-bar-val">73.6%</span>
AAA<br/>$60+
n=49

<strong>Insight, computed live from the dataset:</strong> the relationship isn't linear. Budget and Mid tiers sit flat around 66: 67%, but <strong>Premium ($30: 60) jumps to 77.2%</strong>: the highest of any bucket, beating even AAA ($60+, 73.6%). Crossing the $30 floor correlates with a real quality jump; going past $60 doesn't add more on top of that. The dataset has far fewer Premium/AAA titles (131 and 49) than Budget (812), so this is a real but lower-confidence signal.
        </div>
        <br>
        <h3>05 Hidden Gems &amp; Consistent Studios</h3>
        <div class="blog-content-body">
<p>Two queries built for a publishing-deal use case: titles with excellent ratings but low visibility (a subquery + <code class="inline">HAVING</code> filter), and developers who are reliably good across 3+ releases rather than one lucky hit.</p>

Hidden gems: rating ≥ 85%, under 5,000 owners

<table class="p-data-table">
<thead><tr><th>Game</th><th>Developer</th><th>Price</th><th style="text-align:right;">Rating</th></tr></thead>
<tbody>
<tr><td><strong>Lost Wasteland</strong></td><td class="p-dev-name">Quiet Harbor Games</td><td class="num">$4.99</td><td class="num"><span class="p-rating-pill">98.9%</span></td></tr>
<tr><td><strong>Radiant Empire: Throne</strong></td><td class="p-dev-name">Nova Forge Studios</td><td class="num">$4.99</td><td class="num"><span class="p-rating-pill">98.9%</span></td></tr>
<tr><td><strong>Hollow Throne: Throne</strong></td><td class="p-dev-name">Frostbyte Collective</td><td class="num">$4.99</td><td class="num"><span class="p-rating-pill">98.9%</span></td></tr>
<tr><td><strong>Forgotten Sanctuary: Area</strong></td><td class="p-dev-name">Echo Chamber Games</td><td class="num">$2.99</td><td class="num"><span class="p-rating-pill">98.8%</span></td></tr>
<tr><td><strong>Drifting Voyage: Rift</strong></td><td class="p-dev-name">Solar Anvil</td><td class="num">$0.99</td><td class="num"><span class="p-rating-pill">98.8%</span></td></tr>
</tbody>
</table>

Most consistent studios: 3+ releases, ranked by avg. rating

<table class="p-data-table">
<thead><tr><th>Studio</th><th style="text-align:right;">Titles</th><th style="text-align:right;">Avg. Rating</th></tr></thead>
<tbody>
<tr><td><strong>Mega Pulse Studios</strong></td><td class="num">59</td><td class="num"><span class="p-rating-pill">77.0%</span></td></tr>
<tr><td><strong>Solar Anvil</strong></td><td class="num">69</td><td class="num"><span class="p-rating-pill">70.5%</span></td></tr>
<tr><td><strong>NeonByte</strong></td><td class="num">66</td><td class="num"><span class="p-rating-pill">70.5%</span></td></tr>
<tr><td><strong>Lonewolf Dev</strong></td><td class="num">64</td><td class="num"><span class="p-rating-pill">69.4%</span></td></tr>
<tr><td><strong>Stardust Pictures</strong></td><td class="num">69</td><td class="num"><span class="p-rating-pill">69.1%</span></td></tr>
</tbody>
</table>
        </div>
        <br>
        <h3>06 The Math, SQL Techniques Applied</h3>
        <div class="blog-content-body">
<p>Four formulas power every chart on this page. Each tab below breaks down the formula, what it means, and a worked example using real rows from this exact dataset.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Cumulative Running Total</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">SELECT yr, releases,
       SUM(releases) OVER (ORDER BY yr
         ROWS UNBOUNDED PRECEDING
       ) AS cumulative
FROM yearly_counts</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">A window function re-evaluates <code class="inline">SUM()</code> per row, over rows up to the current one (<code class="inline">ROWS UNBOUNDED PRECEDING</code>). Unlike <code class="inline">GROUP BY</code>, it keeps one row per year while exposing the running total, exactly what the line chart plots.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">yr     releases   cumulative
2008      87           87
2009      69          156
2010      85          241
2011      84          325
2012      72          397
2013     101          498   ← single best year
2024      88         1400   ← final total</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Positive-Rating Ratio</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">rating = positive_ratings
       / (positive_ratings + negative_ratings)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">SQLite does integer division by default, so the numerator is cast with <code class="inline">1.0*</code> to force a float result. Every "average rating" on this page, per genre, per price bucket, per studio, is the <code class="inline">AVG()</code> of this ratio computed per game, not a single global ratio, so one outlier game can't dominate a genre's number.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">Game: "Lost Wasteland"
positive_ratings = 369   negative_ratings = 4

rating = 1.0 × 369 / (369 + 4)
       = 369 / 373
       = 0.989  →  98.9%</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">03</span><span class="p-math-title">RANK() Within Partition</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">WITH ranked AS (SELECT genre_name, name,
    RANK() OVER (PARTITION BY genre_name
      ORDER BY positive_ratings DESC
    ) AS rnk
  FROM games_deduped d
  JOIN game_genres g ON g.app_id = d.app_id
)
SELECT * FROM ranked WHERE rnk &lt;= 3</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text"><code class="inline">PARTITION BY</code> resets the ranking counter per genre, so each genre gets its own top-3 rather than one global list dominated by the largest genre. SQLite has no <code class="inline">QUALIFY</code>, so the window function is wrapped in a CTE and filtered in an outer query.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">genre_name   name                    rnk
Adventure    "Sunken Citadel"          1
Adventure    "Velvet Horizon"          2
Adventure    "Glass Meridian"          3
Shooter      "Iron Vanguard"           1
Shooter      "Crimson Drift"           2
Shooter      "Static Hollow"           3
→ filtered from ALL ranked rows down to rnk &lt;= 3 per genre</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">04</span><span class="p-math-title">Recursive CTE: Genre Hierarchy</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">WITH RECURSIVE ancestry(genre_id, path, depth) AS (SELECT genre_id, genre_name, 0
  FROM genres WHERE parent_genre IS NULL
  UNION ALL
  SELECT g.genre_id, a.path || ' → ' || g.genre_name, a.depth+1
  FROM genres g
  JOIN ancestry a ON g.parent_genre = a.path
)
SELECT * FROM ancestry ORDER BY depth</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">The genres table is self-referencing, every row's <code class="inline">parent_genre</code> points at another row in the same table. A recursive CTE starts at the root (<code class="inline">parent_genre IS NULL</code>) and <code class="inline">UNION ALL</code>s each level down until no children remain, building the ancestry path as it goes.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">depth 0:  Games
depth 1:  Games → Action
depth 1:  Games → Adventure
depth 1:  Games → Strategy
depth 2:  Games → Action → Shooter
depth 2:  Games → Action → Platformer
depth 2:  Games → Adventure → RPG
depth 2:  Games → Strategy → Simulation
depth 3:  Games → Strategy → Simulation → Sandbox</pre></div></div></div></div></div>
The genre tree this query walks

Games
Action <span class="p-tree-path">→ Shooter, Platformer</span>
Adventure <span class="p-tree-path">→ RPG, Visual Novel</span>
Strategy <span class="p-tree-path">→ Simulation → Sandbox</span>
Sports <span class="p-tree-path">→ Racing</span>
Indie <span class="p-tree-path">→ Casual, Puzzle</span>
Horror
        </div>
        <br>
        <h3>07 How a Page Load Becomes a Live Query</h3>
        <div class="blog-content-body">
<p>There's no backend and no build step that runs SQL ahead of time. Everything below happens fresh, in-browser, every time the page opens:</p>

1
Boot SQLite/WASM
<code class="inline">sql.js</code> loads and initializes a real SQLite engine compiled to WebAssembly, running entirely inside the page.

2
Load the database
The SQLite file is embedded directly in the page as base64, no separate <code class="inline">.db</code> fetch that can 404, just one self-contained file.

3
Run every query, timed
<strong><mark class="hl">Five analysis queries execute live on load</mark></strong>: cumulative release growth, genre breakdown, price-vs-rating, a "hidden gems" subquery, and consistent-studio aggregates, each with its execution time captured.

4
Render results live
Query output feeds straight into the charts. Edit a query, refresh, and the dashboard's behavior changes immediately, no rebuild, no export script.

<button class="p-acc-trigger"><span class="p-acc-num">1</span><span class="p-acc-title">Boot SQLite/WASM</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc"><code class="inline">sql.js</code> loads and initializes a real SQLite engine compiled to WebAssembly, running entirely inside the page.</p>

<button class="p-acc-trigger"><span class="p-acc-num">2</span><span class="p-acc-title">Load the database</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">The SQLite file is embedded directly in the page as base64, no separate <code class="inline">.db</code> fetch that can 404, just one self-contained file.</p>

<button class="p-acc-trigger"><span class="p-acc-num">3</span><span class="p-acc-title">Run every query, timed</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc"><strong><mark class="hl">Five analysis queries execute live on load</mark></strong>: cumulative release growth, genre breakdown, price-vs-rating, a "hidden gems" subquery, and consistent-studio aggregates, each with its execution time captured.</p>

<button class="p-acc-trigger"><span class="p-acc-num">4</span><span class="p-acc-title">Render results live</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">Query output feeds straight into the charts. Edit a query, refresh, and the dashboard's behavior changes immediately, no rebuild, no export script.</p>
        </div>
        <br>
        <h3>08 Live SQL Console</h3>
        <div class="blog-content-body">
<p>The bottom of the live page is a real query box wired to <code class="inline">db.exec()</code>, not a styled mockup. Below is an interactive walkthrough of the five sample queries it ships with, using the actual result sets they return against this dataset. Pick one and hit <strong>Run</strong>.</p>

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
        <h3>09 Why Client-Side Over a Backend</h3>
        <div class="blog-content-body">
<p>I deliberately didn't stand up a server to run these queries. Shipping the database file and running it client-side via WASM was a conscious trade-off, not a shortcut.</p>

<ul><li><b>Zero hosting cost</b>: It's a static site, deployable on Cloudflare Pages, Vercel, Netlify, or GitHub Pages with no compute to pay for.</li>
<li><b>No backend to keep alive</b>: Nothing to monitor, nothing that goes down at 3am, nothing to patch for security updates.</li>
<li><b>Genuinely live</b>: "Live" usually means "a server ran a query recently." Here it means the query runs on your machine, right now, in front of you.</li>
<li><b>Honest about its limits</b>: The dataset is under 200KB, so shipping the whole database is trivial. A bigger dataset would need a real backend, and that's fine to say outright.</li></ul>
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
        <br><br>
    </div>
</div>
