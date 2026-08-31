<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">SQL</span><span class="badge blog-badge badge-green">SQLite/WASM</span><span class="badge blog-badge badge-purple">Data Analysis</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Taking My SQL Portfolio Project From Static Export to a Live, In-Browser Database</h1>
        <br>
        <span>The dashboard looked like a live analytics tool. It wasn&#x27;t one. So I rebuilt it to run real SQLite, compiled to WebAssembly, directly in the visitor&#x27;s browser, no backend, no precomputed export.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; </span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>The Project I Already Had</h3>
        <div class="blog-content-body">
<p>A while back I built a "Steam Market Intelligence" case study to put the advanced-SQL techniques I'd just learned, window functions, recursive CTEs, self-joins, rolling calculations, to work on something more interesting than another tutorial dataset. The result: a synthetic, statistically-realistic game-market dataset, seven <code style="background:#F0F0ED;padding:2px 5px;border-radius:3px;font-size:13px;">.sql</code> files walking through the full curriculum, and a dashboard summarizing the findings.</p>
                            <p>The first version worked. It had charts, it had numbers, it looked like a finished product.</p>
                            It bugged me a little: the dashboard was just static HTML reading from a <mark class="hl-bg">dashboard_data.json</mark> file I'd exported ahead of time. The "SQL project" had already finished running by the time anyone opened the page. It <mark class="hl">looked</mark> like a live analytics tool. It <mark class="hl">wasn't</mark> one.
                            <p>That distinction matters more than it sounds. Anyone can screenshot a query result and style it nicely. Showing that the queries actually run, in front of the person looking at it, is a completely different claim.</p>
        </div>
        <br>
    <br>
</div>
