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
            <span>A daily ETL pipeline that loads market data for the top 25 coins into PostgreSQL, analyses it in SQL and charts the results.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">PostgreSQL, FastAPI</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Most tutorials stop once the data is loaded. MarketPulse is about what comes after: a pipeline you can re-run safely, and analysis written in SQL rather than pandas.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Safe to re-run</b>: every run upserts by coin and date, so nothing is duplicated</li>
<li><b>Audited</b>: each run logs its timing, rows touched and errors</li>
<li><b>Polite to the API</b>: automatic retry with backoff when the free tier rate limits</li>
<li><b>Analysis in SQL</b>: moving averages, daily returns, volatility and drawdown as views</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
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
