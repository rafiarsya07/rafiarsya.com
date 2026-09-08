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

        <figure class="p-hero"><img alt="SENARA 2026 homepage hero with the Instellar X Senara banner" decoding="async" src="image/assets/senara/live-home-hero.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-orange">HTML5</span>
                <span class="badge blog-badge badge-blue">CSS3</span>
                <span class="badge blog-badge badge-secondary">JavaScript</span>
                <span class="badge blog-badge badge-purple">Bootstrap 5</span>
                <span class="badge blog-badge badge-neutral">Static Site</span>
                <span class="badge blog-badge badge-green">WebP Pipeline</span>
            </div>
            <h1>SENARA Creative Artfest 2026</h1>
            <br>
            <span>SENARA is the student art exhibition organised by PPI Malaysia. For 2026 the event runs as a collaboration with Instellar, so the existing site needed a full visual refresh, two new sections, and a set of pages that did not exist before. I did not rebuild the site from scratch: I re-themed it and extended it on top of the 2025 codebase.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">In progress</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Head of Website Division, PPI Malaysia</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">HTML, CSS, JavaScript</span></span></div><a href="https://senara.ppimalaysia.id/" target="_blank" rel="noopener" class="ext-link">SENARA Creative Artfest<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>SENARA Creative Artfest</strong> is the first student art exhibition organised by PPI Malaysia, showing contemporary work by young artists from Indonesia and Malaysia. The 2026 edition is a collaboration with <strong>Instellar</strong>, which is why the whole site carries an <em>Instellar X Senara</em> identity this year.</p>
<p class="p-text">The brief was a theme update rather than a rewrite. The 2025 site is a plain static build in HTML, CSS, and JavaScript with Bootstrap 5 from a CDN, and it already worked. What it needed was the new artwork wired in properly, an About page rebuilt around the new programme line-up, and a whole Online Exhibition section that did not exist in 2025.</p>
<p class="p-text"><strong>What I worked on:</strong> the responsive hero system, the About page rebuild, the Online Exhibition hub with its four category pages and artwork detail views, the shared navigation, and the asset pipeline that turns Figma exports into the WebP files the site actually ships.</p>
        </div>
        <br>

        <h3>02 Technical Approach</h3>
        <div class="blog-content-body">
<p class="p-text">Most of the interesting work was geometry. The designs arrive as flat Figma exports at fixed sizes, and a browser is not a fixed size, so the gap between the two is where the engineering sits.</p>
<ul>
<li><b>Hero variants chosen by screen shape, not width</b>: the 2026 banner is a single 16:9 artwork, which cannot fill a phone screen without either cropping the illustration or leaving it stranded in empty space. The hero now picks one of seven variants through <code class="inline">max-aspect-ratio</code> media queries instead of <code class="inline">max-width</code>, so the artwork is matched to the shape of the viewport. Each variant's own ratio equals the bottom of the range it serves, which guarantees the sides are never cropped and only background is ever trimmed.</li>
<li><b>Background extension instead of cropping</b>: the wide variants are built by extending the ikat sky upward and the floor downward. The sky is mirrored from the top strip of the artwork with its amplitude decaying to zero, so the pattern continues and the tiling seam dissolves rather than repeating visibly.</li>
<li><b>Layer recomposition for portrait</b>: for phones the designer later supplied a dedicated portrait artboard, and it replaced an earlier version where I had matted the logo out of the landscape banner with background subtraction, inpainted the hole, and re-stacked it above the characters.</li>
<li><b>Measure the mockup, then convert to vw</b>: the Figma canvases are 2560px representing a 1280 CSS design, so every measurement divides by 12.8 to become a <code class="inline">vw</code> value. Button widths, type sizes, and section padding are all derived that way rather than eyeballed, which is what keeps the built page matching the mockup at any window size.</li>
<li><b>Text lifted out of flattened images</b>: the About programme bands originally shipped as two flat 16:9 images with their titles baked in, which made the type unreadable on a phone. The bands are now CSS two-tone blocks with the title lockups as separate transparent assets, positioned by percentages measured off the mockup, so the wordmarks scale independently of the band.</li>
<li><b>Artwork navigation without a backend</b>: the exhibition is static, so the previous and next arrows on an artwork page read <code class="inline">?cat=</code> and <code class="inline">?i=</code> from the query string, retarget the breadcrumb, and disable themselves at either end of the category.</li>
<li><b>Buttons as CSS, not images</b>: the category buttons were handed over as eighteen PNGs covering every label in an outline and a filled state. They are one CSS class instead, so they stay sharp at any size, transition smoothly on hover, and take a new label without another export.</li>
</ul>
        </div>
        <br>

        <h3>03 Typography &amp; Colour</h3>
        <div class="blog-content-body">
<p class="p-text">Three typefaces, each with a clear job.</p>
<ul>
<li><b>Sarina</b>, self-hosted from <code class="inline">assets/font/Sarina-Regular.ttf</code>, for the display headings carried over from the 2025 identity.</li>
<li><b>System UI stack</b> for body copy, so the running text renders natively and costs nothing to load.</li>
<li><b>Playfair Display</b> for the Online Exhibition artwork titles, standing in for the serif in the mockups until the designer confirms the original face.</li>
<li><b>Wordmarks stay as artwork</b>: the ONLINE EXHIBITION lockup and the four programme titles are transparent WebP exports rather than live text, because they are drawn type rather than a font.</li>
</ul>
<p class="p-text">The palette is carried in CSS custom properties in <code class="inline">main.css</code>:</p>
<div class="project-tree">--yellow   #F9DB4A   <span class="pt-comment"># home and About ground</span>
--pink     #E0628E   <span class="pt-comment"># step dividers, accents</span>
--blue     #3478ED   <span class="pt-comment"># What is SENARA panel, buttons</span>
--whiteish #FFF9F2   <span class="pt-comment"># cards</span>
#FAD50B              <span class="pt-comment"># Online Exhibition ground</span>
#4D2224              <span class="pt-comment"># Online Exhibition ink</span>
#D6B839              <span class="pt-comment"># upper half of a programme band</span>
#440E0E              <span class="pt-comment"># gallery wall frame</span></div>
        </div>
        <br>

        <h3>04 Live Preview</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The site as it stands, live at <a class="ext-link" href="https://senara.ppimalaysia.id/" target="_blank" rel="noopener">senara.ppimalaysia.id<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>. Copy for the 2026 programmes is still with the committee, so some blocks carry placeholder text.</p>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Home</p>
<figure class="rf-figure-lg"><img alt="What is SENARA Creative Artfest section with the 2026 mascot poster" decoding="async" loading="lazy" src="image/assets/senara/live-home-about.jpg"/><figcaption class="img-caption">"What is SENARA" panel, with the 2026 mascot poster</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">About</p>
<figure class="rf-figure-lg"><img alt="About page gallery wall hero in its framed box" decoding="async" loading="lazy" src="image/assets/senara/live-about-hero.jpg"/><figcaption class="img-caption">Gallery wall hero, framed the way the 2025 page framed its board</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Fashion Show and Swaradhana programme band" decoding="async" loading="lazy" src="image/assets/senara/live-about-bands.jpg"/><figcaption class="img-caption">Programme bands, rebuilt so the wordmarks scale on their own</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Online Exhibition</p>
<figure class="rf-figure-lg"><img alt="Online Exhibition hero with the two mascots peeking behind a pink step band" decoding="async" loading="lazy" src="image/assets/senara/live-online-hero.jpg"/><figcaption class="img-caption">Hero, with both mascots peeking from behind the step band</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Four gold frames with the category buttons underneath" decoding="async" loading="lazy" src="image/assets/senara/live-online-frames.jpg"/><figcaption class="img-caption">Category frames and their buttons, sized straight from the mockup</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Digital Art category page with a grid of artwork cards" decoding="async" loading="lazy" src="image/assets/senara/live-category-grid.jpg"/><figcaption class="img-caption">A category page: title, breadcrumb, and the artwork grid</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Artwork detail page with title, author, year and description" decoding="async" loading="lazy" src="image/assets/senara/live-artwork-detail.jpg"/><figcaption class="img-caption">Artwork detail, with previous and next walking the category</figcaption></figure>
</div>
        </div>
        <br>

        <h3>05 Design Mockups</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The Figma work the build was measured against, section by section. The hero is the banner at the top of this page.</p>
<div class="rf-livegroup">
<p class="rf-livegroup-title">About</p>
<figure class="rf-figure-lg"><img alt="About page mockup, gallery wall inside its dark frame" decoding="async" loading="lazy" src="image/assets/senara/mockup-about-wall.jpg"/><figcaption class="img-caption">Gallery wall, framed and hung under the navigation</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Fashion Show and Swaradhana programme bands in the mockup" decoding="async" loading="lazy" src="image/assets/senara/mockup-about-bands-1.jpg"/><figcaption class="img-caption">Programme bands: Fashion Show and Swaradhana</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Special Performance and Interactive Arts programme bands in the mockup" decoding="async" loading="lazy" src="image/assets/senara/mockup-about-bands-2.jpg"/><figcaption class="img-caption">Programme bands: Special Performance and Interactive Arts</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Online Exhibition</p>
<figure class="rf-figure-lg"><img alt="Online Exhibition mockup, title block with both mascots and the step band" decoding="async" loading="lazy" src="image/assets/senara/mockup-online-hero.jpg"/><figcaption class="img-caption">Hub title block, mascots either side of the step band</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Four gold frames and the category buttons in the mockup" decoding="async" loading="lazy" src="image/assets/senara/mockup-online-frames.jpg"/><figcaption class="img-caption">The four frames and their category buttons, the source of every width in the CSS</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Digital Art category page mockup with the artwork grid" decoding="async" loading="lazy" src="image/assets/senara/mockup-category.jpg"/><figcaption class="img-caption">Category page: title lockup, breadcrumb, and the first row of the grid</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Artwork Detail</p>
<figure class="rf-figure-lg"><img alt="Artwork detail mockup for a portrait piece" decoding="async" loading="lazy" src="image/assets/senara/mockup-artwork-portrait.jpg"/><figcaption class="img-caption">Portrait layout: artwork left, title and description right</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Artwork detail mockup for a landscape video piece" decoding="async" loading="lazy" src="image/assets/senara/mockup-artwork-landscape.jpg"/><figcaption class="img-caption">Landscape layout for videography, with the text under the frame</figcaption></figure>
</div>
        </div>
        <br>

        <h3>06 Project Structure</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Flat static site, no build step, deployed as plain files.</p>
<div class="project-tree">senara.ppimalaysia.id/
├── index.html                            <span class="pt-comment"># home</span>
├── about.html                            <span class="pt-comment"># programmes</span>
├── partnership.html
├── submission.html
├── <span class="pt-dir">online-exhibition.html</span>                 <span class="pt-comment"># hub, four category frames</span>
├── online-exhibition-digital-art.html
├── online-exhibition-photography.html    <span class="pt-comment"># masonry grid</span>
├── online-exhibition-videography.html
├── online-exhibition-fashion-design.html
├── online-exhibition-artwork.html        <span class="pt-comment"># portrait detail view</span>
├── online-exhibition-artwork-video.html  <span class="pt-comment"># landscape detail view</span>
└── <span class="pt-dir">assets/</span>
    ├── <span class="pt-dir">css/</span>    <span class="pt-comment"># main, index, about, submission, online</span>
    ├── <span class="pt-dir">js/</span>      <span class="pt-comment"># main.js, mascot.js</span>
    ├── <span class="pt-dir">font/</span>    <span class="pt-comment"># Sarina-Regular.ttf</span>
    └── <span class="pt-dir">img/</span>
        ├── mainImg/   <span class="pt-comment"># hero variants, posters</span>
        ├── about/     <span class="pt-comment"># wall, divider, band titles</span>
        ├── online/    <span class="pt-comment"># frames, mascots, wordmarks</span>
        ├── mascot/
        ├── logo/
        └── sponsor/</div>
        </div>
        <br>

        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">JavaScript</span>
<span class="badge blog-badge badge-neutral">Bootstrap 5</span>
<span class="badge blog-badge badge-neutral">WebP</span>
<span class="badge blog-badge badge-neutral">Google Fonts</span>
<span class="badge blog-badge badge-neutral">Cloudflare Pages</span>
</div>
        </div>
        <br>

        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://senara.ppimalaysia.id/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">senara.ppimalaysia.id</span>
</a>
<a class="p-link-btn" href="https://www.instagram.com/senaraartfest/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><rect height="20" rx="5" ry="5" width="20" x="2" y="2"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
<span class="p-link-btn-label">Instagram</span>
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
