<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-purple">Node.js</span><span class="badge blog-badge badge-blue">Express</span><span class="badge blog-badge badge-green">PostgreSQL</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>ThoughtLog: Building My Own Blog CMS From Scratch</h1>
        <br>
        <span>No WordPress, no Ghost, no static-site generator. I built a full-stack blog with its own CMS: Markdown with live preview, scheduled posts, tags, and real authentication, self-hosted on a mini PC under my desk.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; </span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>Why Not Just Use WordPress</h3>
        <div class="blog-content-body">
<p>Every off-the-shelf CMS comes with plugins, themes, and infrastructure I'd never actually use. I wanted something small enough to understand completely: my own database schema, my own auth, my own editor. ThoughtLog is the result, a personal blog platform built entirely from scratch on Node.js and Express, with PostgreSQL doing the storage.</p>
        </div>
        <br>
        <h3>Writing and Publishing</h3>
        <div class="blog-content-body">
<p>Posts are written in Markdown with a live preview pane, saved as drafts, and can be scheduled to publish themselves at a set time via a background job. Everything is organised and browsable by tag. Reading is public for anyone who visits, but writing sits behind real JWT-based authentication, no admin panel left wide open.</p>
        </div>
        <br>
        <h3>Where It Runs</h3>
        <div class="blog-content-body">
<p>ThoughtLog runs on a mini PC under my desk and reaches the internet through a Cloudflare Tunnel, no VPS, no managed database, no monthly hosting bill. It's the same instinct behind most of my other projects: understand the whole stack by owning every layer of it.</p>
        </div>
        <br>
        <div class="d-flex">
            <a href="https://blog.rafiarsya.com" target="_blank" rel="noopener" class="btn btn-main button-border d-flex align-items-center">
                <span>Read the full blog &#8599;</span>
            </a>
        </div>
        <br><br>
</div>
