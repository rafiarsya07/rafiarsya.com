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

        <figure class="p-hero"><img alt="MarketPulse ETL dashboard: price chart, volatility ranking, and max drawdown tables" decoding="async" src="image/assets/marketpulse/hero.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Python</span>
                <span class="badge blog-badge badge-green">PostgreSQL</span>
                <span class="badge blog-badge badge-purple">FastAPI</span>
                <span class="badge blog-badge badge-orange">Chart.js</span>
                <span class="badge blog-badge badge-neutral">SQL Window Functions</span>
                <span class="badge blog-badge badge-blue">CoinGecko API</span>
            </div>
            <h1>MarketPulse ETL</h1>
            <br>
            <span>A small but real ETL pipeline: pulls daily cryptocurrency market data for the top 25 coins from a public API, loads it into PostgreSQL, and answers analytical questions with pure SQL, window functions, CTEs, ranking, running aggregates. A FastAPI layer exposes the SQL views as JSON, and a plain HTML/Chart.js dashboard visualizes them.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">PostgreSQL, FastAPI</span></span><span class="p-meta-item"><span class="p-meta-k">Hosting</span><span class="p-meta-v">Local</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>MarketPulse</strong> is an ETL pipeline built to practice the part of data work that tutorials usually skip: what happens after the data lands. No ORM, no pandas-does-the-analysis-instead-of-SQL shortcuts, the SQL is the point.</p>
<p class="p-text">The pipeline pulls the top 25 coins by market cap plus 90 days of daily history each from <strong>CoinGecko's public API</strong>, transforms and aligns the timestamps, and performs an <strong>idempotent upsert</strong> into PostgreSQL keyed on <code class="inline">(coin_id, price_date)</code>, so re-running the pipeline never creates duplicates and a run that dies halfway can just be re-run safely.</p>

<strong>My focus:</strong> the extract/transform/load logic itself, five analytical SQL views (moving average, daily returns, volatility ranking, max drawdown, top movers), a thin FastAPI layer to serve them, and a Chart.js dashboard on top.
        </div>
        <br>
        <h3>02 Technical Approach</h3>
        <div class="blog-content-body">
<ul><li><b>Idempotent load</b>: every run upserts on <code class="inline">(coin_id, price_date)</code> and logs itself to an <code class="inline">etl_runs</code> audit table (start/end time, rows touched, error message if any), so the pipeline is auditable instead of a black box.</li>
<li><b>Rate-limit handling</b>: CoinGecko's free tier is strict. The client retries automatically on a 429 with exponential backoff, and supports an optional free Demo API key for a dedicated quota instead of sharing the public IP pool.</li>
<li><b>Incremental refresh</b>: on a re-run, each coin is checked by its most recent stored date rather than a row count, so a coin gets a full 90-day backfill only once; after that, only the missing days are fetched.</li>
<li><b>Analysis in SQL</b>: five views in <code class="inline">analytics/queries.sql</code>, 7-day moving average, daily returns, volatility ranking by return standard deviation, max drawdown, and top movers, all as window functions and CTEs. FastAPI reads the views directly with no business logic duplicated in Python.</li></ul>
        </div>
        <br>
        <h3>03 Live Preview</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The dashboard reading straight off the five SQL views, for all 25 coins after a full backfill.</p>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Analytics</p>
<figure class="rf-figure-lg"><img alt="Volatility ranking by return standard deviation, and max drawdown percentage per coin" decoding="async" loading="lazy" src="image/assets/marketpulse/live-volatility-drawdown.png"/><figcaption class="img-caption">Volatility rank (return stddev) and max drawdown, computed entirely in SQL</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Top movers table ranking all 25 coins by 7-day percent change" decoding="async" loading="lazy" src="image/assets/marketpulse/live-top-movers.png"/><figcaption class="img-caption">Top movers (7D), start price vs. end price across all 25 coins</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Pipeline</p>
<figure class="rf-figure-lg"><img alt="ETL run log showing status, coins processed, and rows upserted per run" decoding="async" loading="lazy" src="image/assets/marketpulse/live-run-log.png"/><figcaption class="img-caption">ETL run log: every run is logged with its status, coin count, and row count</figcaption></figure>
</div>

        </div>
        <br>
        <h3>04 Project Structure</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Extract/transform/load kept separate from analysis and serving.</p>
<div class="project-tree">marketpulse-etl/
├── <span class="pt-dir">etl/</span>               <span class="pt-comment"># coingecko.py, db.py, pipeline.py</span>
├── <span class="pt-dir">analytics/</span>          <span class="pt-comment"># queries.sql, 5 SQL views</span>
├── <span class="pt-dir">api/</span>                <span class="pt-comment"># app.py, FastAPI reading the views</span>
├── <span class="pt-dir">dashboard/</span>          <span class="pt-comment"># index.html, Chart.js</span>
├── schema.sql        <span class="pt-comment"># coins, daily_prices, etl_runs</span>
└── requirements.txt
</div>
        </div>
        <br>
        <h3>05 What I'd Improve</h3>
        <div class="blog-content-body">
<ul><li>Schedule the pipeline with cron / Task Scheduler for a genuine daily-refresh dashboard instead of a manual run.</li>
<li>Add a small test suite around the transform step (timestamp alignment, partial-day dropping) rather than relying on manual verification.</li>
<li>Move off the shared free-tier IP pool permanently with a dedicated CoinGecko Demo API key baked into deployment, not just local runs.</li></ul>
        </div>

    </div>
</div>
