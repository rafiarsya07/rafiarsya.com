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

        <figure class="p-hero"><img alt="snip screenshot" decoding="async" src="image/assets/snip/cover.jpg"/></figure>

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
            <span>A URL shortener with click analytics, built on AWS Lambda, API Gateway and DynamoDB as infrastructure as code. My AWS Developer Associate study, put into practice.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">Lambda, DynamoDB</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Paste a long link, get a short code. Every visit redirects and records the click, so you can see total clicks, clicks per day and where they came from.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Three small functions</b>: create, redirect and stats, each a Lambda behind one HTTP API</li>
<li><b>One atomic write</b>: a click updates the total, today and the referrer in a single DynamoDB update</li>
<li><b>Least privilege</b>: each function can touch only what it needs</li>
<li><b>Infrastructure as code</b>: the whole stack is defined and deployed with AWS SAM</li>
</ul>
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
        <br>
        <div class="text-center text-silent text14">
            &#169; MUHAMMAD RAFI ARSYA
        </div>
        <br>
    </div>
</div>
