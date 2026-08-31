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
                <span class="badge blog-badge badge-blue">Next.js 16</span>
                <span class="badge blog-badge badge-green">React 19</span>
                <span class="badge blog-badge badge-purple">TypeScript</span>
                <span class="badge blog-badge badge-orange">Tailwind CSS v4</span>
                <span class="badge blog-badge badge-neutral">Static Export</span>
                <span class="badge blog-badge badge-blue">Sharp</span>
            </div>
            <h1>IDFEST 2026 Website</h1>
            <br>
            <span>The official website for IDFEST 2026, an Indonesian cultural festival organized by PPI Universiti Malaya. A collaborative build translating Figma designs into a fast, static Next.js frontend across the home timeline, Art Exhibition, and Musical Theater sections.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Website Development Committee</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">Next.js, Tailwind CSS</span></span></div><a href="https://idfest.ppiunimalaya.id/" target="_blank" rel="noopener" class="ext-link">IDFEST 2026<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
            <div class="contributors-byline">
<a class="contributor-chip" href="https://www.linkedin.com/in/ilhamsetiabudi/" target="_blank" rel="noopener noreferrer">
<img class="contributor-chip-avatar" src="image/assets/idfest/contributor-ilham.png" alt="Ilham Narendra Setiabudi" loading="lazy" decoding="async">
<span class="contributor-chip-name">Ilham Narendra Setiabudi</span>
</a>
<a class="contributor-chip" href="https://www.linkedin.com/in/fathirraja/" target="_blank" rel="noopener noreferrer">
<img class="contributor-chip-avatar" src="image/assets/idfest/contributor-fathir.png" alt="Ahmad Fathir" loading="lazy" decoding="async">
<span class="contributor-chip-name">Ahmad Fathir</span>
</a>
            </div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>IDFEST</strong> is an international event at Universiti Malaya showcasing Indonesian heritage, and I'm on the Website Development Committee building its official site alongside a small team, turning Figma designs into production-ready pages.</p>
<p class="p-text">The site is built on <strong>Next.js 16</strong> with static export, so the whole thing ships as pre-rendered HTML: no server runtime needed at request time, fast first paint, and simple hosting.</p>

<strong>My focus:</strong> homepage sections, the animated timeline, hero responsiveness across breakpoints, and shared navigation and mascot animation components reused across the Art Exhibition and Musical Theater pages.
        </div>
        <br>
        <h3>02 Technical Approach</h3>
        <div class="blog-content-body">
<ul><li><b>Static export</b>: <code class="inline">next.config.ts</code> is set to <code class="inline">output: 'export'</code>, with images unoptimized since there's no server-side image loader in the static build.</li>
<li><b>Component-driven sections</b>: Reusable mascot components with peek and sleep animation states, shared across pages rather than duplicated per section.</li>
<li><b>Responsive-first</b>: Hero and timeline sections are built and tuned separately for mobile and desktop, including a fix for a parallax scroll bug and a background seam at the hero's edge.</li>
<li><b>Collaborative workflow</b>: Built on branches and merged through Pull Requests rather than pushed directly, with typical review back-and-forth on layout and animation details.</li></ul>
        </div>
        <br>
        <h3>03 Live Preview</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">A closer look at every main section, live at <a class="ext-link" href="https://idfest.ppiunimalaya.id/" target="_blank" rel="noopener">idfest.ppiunimalaya.id<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>.</p>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Home</p>
<figure class="rf-figure-lg"><img alt="IDFEST 2026 homepage hero section" decoding="async" loading="lazy" src="image/assets/idfest/live-home-hero.jpg"/><figcaption class="img-caption">Hero section with the festival mascot and coming-soon banner</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">About</p>
<figure class="rf-figure-lg"><img alt="About IDFEST 2026 page intro, with the what-is-IDFEST section" decoding="async" loading="lazy" src="image/assets/idfest/live-about-intro.jpg"/><figcaption class="img-caption">Intro banner and the "What is IDFEST?" section</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Event photo gallery strip and the Musical Theater / Art Exhibition cards" decoding="async" loading="lazy" src="image/assets/idfest/live-about-gallery-events.jpg"/><figcaption class="img-caption">Event gallery strip, plus the Musical Theater and Art Exhibition entry cards</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Our Team</p>
<figure class="rf-figure-lg"><img alt="Behind IDFEST 2026 team page, with the committee card grid" decoding="async" loading="lazy" src="image/assets/idfest/live-about-team.jpg"/><figcaption class="img-caption">Team page: group photo banner and the filterable committee grid</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Musical Theater</p>
<figure class="rf-figure-lg"><img alt="Musical Theater page hero banner" decoding="async" loading="lazy" src="image/assets/idfest/live-musical-hero.jpg"/><figcaption class="img-caption">Hero banner with the mascot guarding the stage entrance</figcaption></figure>
<figure class="rf-figure-lg"><img alt="About Musical Theater section with the recap video placeholder" decoding="async" loading="lazy" src="image/assets/idfest/live-musical-about.jpg"/><figcaption class="img-caption">Section intro and last year's recap video slot</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Meet the Main Characters, three story panels for Putri Tadampali, La Pasalama and La Magedda" decoding="async" loading="lazy" src="image/assets/idfest/live-musical-characters.jpg"/><figcaption class="img-caption">"Meet the Main Characters": Putri Tadampali, La Pasalama, and La Magedda</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Performers page with a filterable cast grid" decoding="async" loading="lazy" src="image/assets/idfest/live-musical-performers.jpg"/><figcaption class="img-caption">Performers page, filterable by cast, dancers, and role</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Art Exhibition</p>
<figure class="rf-figure-lg"><img alt="Art Exhibition page hero banner" decoding="async" loading="lazy" src="image/assets/idfest/live-art-hero.jpg"/><figcaption class="img-caption">Hero banner for the first-ever IDFEST Art Exhibition</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Art gallery submissions page, currently empty and awaiting entries" decoding="async" loading="lazy" src="image/assets/idfest/live-art-gallery.jpg"/><figcaption class="img-caption">Gallery submissions page, open and waiting for entries</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Partnership</p>
<figure class="rf-figure-lg"><img alt="Partnership page hero banner with sponsorship stats" decoding="async" loading="lazy" src="image/assets/idfest/live-partner-hero.jpg"/><figcaption class="img-caption">Hero banner and reach stats for prospective partners</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Become a Sponsor and Become a Media Partner cards" decoding="async" loading="lazy" src="image/assets/idfest/live-partner-opportunities.jpg"/><figcaption class="img-caption">Sponsor and media-partner opportunity cards</figcaption></figure>
</div>

        </div>
        <br>
        <h3>04 Project Structure</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Standard Next.js App Router layout, exported fully static.</p>
<div class="project-tree">idfest-web/
├── <span class="pt-dir">app/</span>              <span class="pt-comment"># pages, layouts, globals.css</span>
│   └── fonts/           <span class="pt-comment"># Pinecone-Regular.ttf</span>
├── <span class="pt-dir">components/</span>       <span class="pt-comment"># mascot, hero, timeline, shared UI</span>
├── <span class="pt-dir">public/idfest/</span>     <span class="pt-comment"># images & static assets</span>
├── <span class="pt-dir">scripts/</span>           <span class="pt-comment"># opt-images.mjs (Sharp)</span>
├── next.config.ts       <span class="pt-comment"># output: 'export'</span>
├── tsconfig.json
├── eslint.config.mjs
├── postcss.config.mjs
├── package.json
└── README.md</div>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Next.js 16</span>
<span class="badge blog-badge badge-neutral">React 19</span>
<span class="badge blog-badge badge-neutral">TypeScript</span>
<span class="badge blog-badge badge-neutral">Tailwind CSS v4</span>
<span class="badge blog-badge badge-neutral">Lucide React</span>
<span class="badge blog-badge badge-neutral">Sharp</span>
<span class="badge blog-badge badge-neutral">Turbopack</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://idfest.ppiunimalaya.id/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">idfest.ppiunimalaya.id</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07?tab=repositories" rel="noopener noreferrer" target="_blank">
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
