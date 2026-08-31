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
                <span class="badge blog-badge badge-blue">AWS Lambda</span>
                <span class="badge blog-badge badge-green">DynamoDB</span>
                <span class="badge blog-badge badge-purple">API Gateway</span>
                <span class="badge blog-badge badge-orange">AWS SAM</span>
                <span class="badge blog-badge badge-neutral">IAM least-privilege</span>
                <span class="badge blog-badge badge-blue">Node.js</span>
                <span class="badge blog-badge badge-green">Docker</span>
            </div>
            <h1>Snip URL Shortener</h1>
            <br>
            <span>A serverless URL shortener with click analytics. Three AWS Lambda functions behind API Gateway, a single DynamoDB table, all described as infrastructure-as-code with AWS SAM. Built to turn an AWS Developer Associate (DVA-C02) certificate into something real, deployable, and honest about where it actually runs today.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">Lambda, DynamoDB</span></span><span class="p-meta-item"><span class="p-meta-k">Hosting</span><span class="p-meta-v">Local + Tunnel</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>snip</strong> takes a long link and returns a short code. Opening that code redirects the visitor and records the click, total clicks, clicks per day, and the referring site. A small web page creates links and reads the stats.</p>
<p>The <strong>AWS Developer Associate (DVA-C02)</strong> curriculum explains how the services fit together, but coursework alone does not prove that I can wire them into a working system. So I picked the smallest project that genuinely exercises that knowledge: <strong>Lambda, DynamoDB, API Gateway, IAM, and infrastructure-as-code with SAM</strong>, and built it end to end.</p>

<strong>Being upfront about hosting:</strong> snip is <mark class="hl">not deployed on AWS yet</mark>. My AWS account is stuck on payment verification (an Indonesian debit card that AWS won’t authorise), so right now snip runs <strong>locally on Docker</strong> and is exposed to the internet through <strong>Cloudflare Tunnel</strong> at <code class="inline">snip.rafiarsya.com</code>. The code is written against real AWS services and is <strong>deploy-ready</strong>, one <code class="inline">sam deploy</code> ships it to the cloud with zero code changes. I’d rather show a working thing and say exactly where it runs than fake an AWS URL.
        </div>
        <br>
        <h3>02 Architecture</h3>
        <div class="blog-content-body">
<p class="p-text">Three single-purpose Lambda functions sit behind one HTTP API. I split them rather than writing one router so each gets only the IAM permissions it needs: create writes but can't read, stats reads but can't write, redirect does both and nothing else.</p>

<strong>Request lifecycle</strong><br/>
<code class="inline">POST /api/links</code> → <strong>CreateLinkFunction</strong>, validates the URL, generates a random 6-char code, writes the item to DynamoDB (<code class="inline">PutItem</code>).<br/>
<code class="inline">GET /{code}</code> → <strong>RedirectFunction</strong>, looks the code up (<code class="inline">GetItem</code>), bumps the counters (<code class="inline">UpdateItem</code>), returns a <strong>302</strong> to the real URL.<br/>
<code class="inline">GET /api/links/{code}</code> → <strong>StatsFunction</strong>, reads the item and returns the analytics as JSON.
                                
<p>The whole stack, the DynamoDB table, the three functions, the HTTP API, and a scoped IAM role per function, lives in one <code class="inline">template.yaml</code>. Nothing is clicked together by hand in a console; the infrastructure is the file, and the file is version-controlled.</p>
        </div>
        <br>
        <h3>03 The One Write That Took the Longest</h3>
        <div class="blog-content-body">
<p>Every click has to do three things in a single, atomic DynamoDB update: increment the total, increment <em>today’s</em> bucket, and increment the count for the referring site. The total is easy. The two map-keys were the part I got wrong a few times before it clicked.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">DynamoDB Atomic Click Update</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Expression</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">UpdateExpression:
  SET lastClickedAt =:now,
      clicksByDay.#day = if_not_exists(clicksByDay.#day,:zero) +:one,
      referrers.#ref  = if_not_exists(referrers.#ref,:zero) +:one
  ADD clicks:one

ExpressionAttributeNames:  { "#day": "2026-06-25", "#ref": "github.com" }
ExpressionAttributeValues: { ":one": 1, ":zero": 0, ":now": "<iso timestamp="">" }</iso></pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">Two gotchas. A date like <code class="inline">2026-06-25</code> or a hostname like <code class="inline">github.com</code> isn’t a valid raw attribute path, so both pass as placeholders through <code class="inline">ExpressionAttributeNames</code>. And you can’t add 1 to a map key that doesn’t exist, the first click of any day or referrer would fail. if_not_exists(path,:zero) +:one seeds the key at 0 the first time and increments it every time after. The total counter uses ADD instead, which is DynamoDB’s built-in atomic increment and never needs seeding. SET and ADD are combined in one expression so the whole thing is a single atomic write.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Someone opens snip.rafiarsya.com/aZ3kQ9, referred from github.com

before:  { code:"aZ3kQ9", clicks:46,
           clicksByDay:{ "2026-06-24":46 },
           referrers:{ "github.com":40, "direct":6 } }

# RedirectFunction runs the update above with
#   #day = "2026-06-25"   #ref = "github.com"

after:   { code:"aZ3kQ9", clicks:47,
           clicksByDay:{ "2026-06-24":46, "2026-06-25":1 },   # new day seeded at 0, +1
           referrers:{ "github.com":41, "direct":6 },          # existing key, +1
           lastClickedAt:"2026-06-25T09:12:04Z" }</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 Engineering Decisions</h3>
        <div class="blog-content-body">
<ul><li><b>Least-privilege IAM, per function</b>: Each Lambda gets an inline policy scoped to exactly the actions it needs on exactly one table ARN. The first deploy failed with <code class="inline">AccessDenied</code> on <code class="inline">UpdateItem</code> because I’d only granted <code class="inline">GetItem</code>, annoying for two minutes, but it forced me to actually map what each function touches.</li>
<li><b>CORS handled at the API, not in code</b>: The web page couldn’t POST until the HTTP API answered the browser’s preflight <code class="inline">OPTIONS</code> request. Configuring CORS on the API Gateway resource itself keeps the Lambda handlers clean, they only ever deal with the real request.</li>
<li><b>arm64 + on-demand billing</b>: The functions target arm64 (Graviton), which is a little cheaper than x86, and the table is on-demand so there’s nothing to pay for while it sits idle. Cost-awareness baked in from the start, the whole thing is designed to live inside the free tier.</li></ul>
        </div>
        <br>
        <h3>05 Where It Actually Runs (Today)</h3>
        <div class="blog-content-body">
<p>I want to be precise about this, because it’s the honest part. snip is written for AWS, but it isn’t on AWS yet, my account is blocked on card verification. Instead of faking it, I made the same code run anywhere.</p>
<p class="p-text">One shared module holds the DynamoDB logic; both the Lambda handlers and a small local server import it. With an environment variable pointing at a local endpoint it talks to DynamoDB Local in Docker; on Lambda that variable is unset, so the SDK uses the function’s IAM role and the real service. What I test locally is what would run in the cloud.</p>

<strong>The live demo you can click</strong> is that local server, exposed through <strong>Cloudflare Tunnel</strong> at <code class="inline">snip.rafiarsya.com</code>, the same tunnelling setup I use for my other self-hosted projects. It runs while my machine is up; for a quick check it’s genuinely live. The moment AWS verifies my card, <code class="inline">sam deploy</code> moves the identical code to Lambda + DynamoDB with no edits, and it becomes 24/7 cloud-hosted.
        </div>
        <br>
        <h3>06 Use Cases &amp; Impact</h3>
        <div class="blog-content-body">
<ul><li><b>Cleaner Link Sharing</b>: Long, ugly URLs become short, shareable codes, for a bio, a slide, or a message where the full link would look messy.</li>
<li><b>Campaign Tracking</b>: Per-link click counts, daily trends, and referrer breakdown show which channel a click actually came from, the same job a marketing team uses a paid shortener for.</li>
<li><b>QR &amp; Print</b>: A short code fits a QR or a printed handout far better than a 90-character URL, and still resolves to the original destination.</li>
<li><b>A Real DVA-C02 Artefact</b>: Most of all: proof, for anyone reading my CV, that the AWS certificate maps onto a stack I’ve actually wired together, not just an exam I passed.</li></ul>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">AWS Lambda</span>
<span class="badge blog-badge badge-neutral">DynamoDB</span>
<span class="badge blog-badge badge-neutral">API Gateway</span>
<span class="badge blog-badge badge-neutral">AWS SAM</span>
<span class="badge blog-badge badge-neutral">IAM</span>
<span class="badge blog-badge badge-neutral">CloudWatch</span>
<span class="badge blog-badge badge-neutral">Node.js</span>
<span class="badge blog-badge badge-neutral">Express</span>
<span class="badge blog-badge badge-neutral">Docker</span>
<span class="badge blog-badge badge-neutral">DynamoDB Local</span>
<span class="badge blog-badge badge-neutral">Cloudflare Tunnel</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://snip.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">snip.rafiarsya.com</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07/Snip---Serverless-URL-Shortener" rel="noopener noreferrer" target="_blank">
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
