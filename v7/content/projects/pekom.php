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

        <figure class="p-hero"><img alt="PEKOM website About page hero: the PEKOM wordmark over The computer science society of Universiti Malaya" decoding="async" src="image/assets/pekom/about-hero.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-secondary">Next.js 16</span>
                <span class="badge blog-badge badge-blue">React 19</span>
                <span class="badge blog-badge badge-green">Tailwind CSS v4</span>
                <span class="badge blog-badge badge-purple">TypeScript</span>
                <span class="badge blog-badge badge-orange">Static Generation</span>
                <span class="badge blog-badge badge-neutral">EN / BM / 中文</span>
            </div>
            <h1>PEKOM UM Website</h1>
            <br>
            <span>The new official website of PEKOM, the Computer Science Society of Universiti Malaya, for the 26/27 session. Events, news, gallery, members, merch, partners and recruitment in one place, in three languages.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">In progress</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Technical Executive Committee, PEKOM</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">Next.js, React, Tailwind CSS</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>

        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>PEKOM</strong> (Persatuan Komputer Universiti Malaya) is the student society of the <a class="ext-link" href="https://fsktm.um.edu.my/" target="_blank" rel="noopener">Faculty of Computer Science &amp; Information Technology<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>. It runs Code Fest, Mental Health Week, IS 101 and UMHackathon, and every session it needs one place where students can find all of that.</p>
<p class="p-text">The 26/27 committee wanted a website that a fresher, a sponsor and a returning member can all use in a few clicks. <mark class="hl">Find the next event, register, read the news, see who runs the society, order merch, or apply to join a division.</mark> The site also has to be easy for the next committee to keep up to date, because the people who build it will not be the people who maintain it next year.</p>
<p class="p-text"><strong>What I worked on:</strong> <mark class="hl">I built the site myself, from the first Next.js and Tailwind scaffold to every page so far.</mark> Every code commit and pull request in the repository is mine. That covers the home page, the events list and event pages, About, Members, Gallery, News, Partners, Merch, Recruitment and Join, plus the shared navigation, the language switch and the photo viewer. The committee supplies the content: event details, photos, member lists and forms.</p>
<p class="p-text">The site is still in progress. It is not public yet, and some links (membership form, merch order form, WhatsApp) are waiting on the committee. Every screenshot on this page comes from a local production build.</p>
        </div>
        <br>

        <h3>02 Technical Approach</h3>
        <div class="blog-content-body">
<p class="p-text">Two things shaped most of the decisions. The content changes every week, and the people changing it are students on a committee, not developers.</p>
<ul>
<li><b>Content is data, not markup</b>: events, news, members, departments, partners, merch and outside links each live in their own typed file under <code class="inline">src/lib/</code>. A committee member updates an event date or marks a shirt as sold out by editing one field, without touching a component. The README maps each kind of change to the file it lives in.</li>
<li><b>Fully static output</b>: all 29 routes are prerendered at build time. The 19 event pages come from <code class="inline">generateStaticParams</code> over the events file, with per page metadata from <code class="inline">generateMetadata</code>, so the site can be served as plain files with nothing running on a server.</li>
<li><b>One event model drives every view</b>: each event carries a status (past, ongoing or upcoming), dates, venue and optional form links. The home page, the events tabs, the event page and the Recruitment page all read the same record. A <code class="inline">tbc</code> flag swaps the date for a small TBC mark with a hover note, and Add to Calendar builds a Google Calendar link straight from the event data.</li>
<li><b>Three languages without a library</b>: the menu, footer, buttons and main headings are in English, Bahasa Malaysia and 中文. A typed dictionary and a React context hold the strings, the choice is saved in <code class="inline">localStorage</code>, and the page's <code class="inline">lang</code> attribute switches with it (<code class="inline">zh-Hans</code> for Mandarin).</li>
<li><b>No dead buttons</b>: forms the committee has not created yet are stored as <code class="inline">null</code>. The site then shows an "opens soon" state, or falls back to an email with the subject and body already filled in, instead of a button that goes nowhere. Pasting the real link in later turns every button that uses it on at once.</li>
<li><b>Merch orders through a pre-filled Google Form</b>: "I want this" opens the order form with the item already selected, using the form's pre-filled link format. Setting <code class="inline">status: "Sold out"</code> greys the button out so nobody can order it.</li>
<li><b>A photo viewer that plays like a story</b>: the shared lightbox shows progress bars along the top and advances on its own. Tap right or left to move, hold to pause, swipe down or press Escape to close. On a laptop, the arrow keys step and Space pauses.</li>
<li><b>Photos keep their shape</b>: a generated table records the width to height ratio of every photo, so the layout reserves the right space before an image loads. Posters and slides are listed separately and shown whole instead of being cropped like photos.</li>
<li><b>Motion that steps aside</b>: Lenis smooth scroll, line by line headline reveals, parallax and the footer reveal are all switched off under <code class="inline">prefers-reduced-motion</code>, so the page stays usable for anyone who turns motion off.</li>
</ul>
<p class="p-text">The repository is private to the society. Even with one developer, it runs like a team project so the next committee can pick it up: <code class="inline">main</code> is protected, every change goes in through a pull request, and the README sets house rules such as never publishing matric or phone numbers from the committee list.</p>
        </div>
        <br>

        <h3>03 Typography &amp; Colour</h3>
        <div class="blog-content-body">
<p class="p-text">The look follows the society's branding moodboard: clean and corporate, with type doing the work instead of decoration.</p>
<ul>
<li><b>Poppins</b> for headings, in weights 400 to 800, loaded through <code class="inline">next/font</code>.</li>
<li><b>Lato</b> for body copy, including italics, also through <code class="inline">next/font</code>.</li>
<li><b>Big type as layout</b>: page titles such as Events, Gallery and Merch run at display size across the top, and the footer carries an oversized PEKOM2026 wordmark.</li>
</ul>
<p class="p-text">The palette is five colours from the moodboard, kept in <code class="inline">globals.css</code>:</p>
<div class="project-tree">Pure White   #F9F9FB   <span class="pt-comment"># page ground</span>
Nero         #232323   <span class="pt-comment"># text, dark sections, footer</span>
Green Buoy   #31AAB7   <span class="pt-comment"># primary accent, buttons, Events band</span>
Meridian     #7AC7B4   <span class="pt-comment"># secondary accent, recruitment band</span>
Smokey       #C4C4C4   <span class="pt-comment"># muted text, placeholders</span></div>
        </div>
        <br>

        <h3>04 Build Preview</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Each shot is one whole section, captured from a local production build at 1440 pixels wide with motion turned off, so nothing is caught halfway through an animation. The site is not public yet, so some dates still read TBC and some photos are from last session.</p>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Home</p>
<figure class="rf-figure-lg"><img alt="Home page hero, A computer society driven by purpose" decoding="async" loading="lazy" src="image/assets/pekom/home-hero.jpg"/><figcaption class="img-caption">The home hero, which plays a background video on tablets and larger screens</figcaption></figure>
<figure class="rf-figure-lg"><img alt="New here? Start here, with three ways into PEKOM" decoding="async" loading="lazy" src="image/assets/pekom/home-start.jpg"/><figcaption class="img-caption">"New here? Start here": three ways in, each a couple of clicks away</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Upcoming Events list on the home page" decoding="async" loading="lazy" src="image/assets/pekom/home-upcoming.jpg"/><figcaption class="img-caption">Upcoming events, read straight from the events file, with TBC dates marked</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Quick Stats cards: 113 people, 15 teams, 7 divisions" decoding="async" loading="lazy" src="image/assets/pekom/home-stats.jpg"/><figcaption class="img-caption">Quick Stats from Code Fest 2025 and the committee</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Events</p>
<figure class="rf-figure-lg"><img alt="Events list with Coming up, Open now and Behind us tabs" decoding="async" loading="lazy" src="image/assets/pekom/events-list.jpg"/><figcaption class="img-caption">Events split into Coming up, Open now and Behind us</figcaption></figure>
<figure class="rf-figure-lg"><img alt="PEKOM Onboarding 26/27 event page header with a calendar date card" decoding="async" loading="lazy" src="image/assets/pekom/event-header.jpg"/><figcaption class="img-caption">An event page header, with the date as a small calendar card</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Event summary beside the At a glance ticket card" decoding="async" loading="lazy" src="image/assets/pekom/event-glance.jpg"/><figcaption class="img-caption">The At a glance ticket card, with Add to calendar and the form buttons</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Photos section with a stack of event photos" decoding="async" loading="lazy" src="image/assets/pekom/event-photos.jpg"/><figcaption class="img-caption">The event's photos as a stack that opens in the story viewer</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">About and Members</p>
<figure class="rf-figure-lg"><img alt="Community, Skills, Careers section with four pillars" decoding="async" loading="lazy" src="image/assets/pekom/about-pillars.jpg"/><figcaption class="img-caption">Three words, one society, and the four things PEKOM works on</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Our home section about the Faculty of Computer Science and Information Technology" decoding="async" loading="lazy" src="image/assets/pekom/about-faculty.jpg"/><figcaption class="img-caption">Our home: the faculty PEKOM belongs to</figcaption></figure>
<figure class="rf-figure-lg"><img alt="One committee, seven divisions, with the High Committee card open" decoding="async" loading="lazy" src="image/assets/pekom/about-divisions.jpg"/><figcaption class="img-caption">One committee, seven divisions: hover a division to see what it does</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Members page header, Behind PEKOM 26/27" decoding="async" loading="lazy" src="image/assets/pekom/members-hero.jpg"/><figcaption class="img-caption">The Members page, which opens onto a searchable committee tree</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Gallery and News</p>
<figure class="rf-figure-lg"><img alt="Gallery header with one round thumbnail per event" decoding="async" loading="lazy" src="image/assets/pekom/gallery-header.jpg"/><figcaption class="img-caption">Gallery header, one bubble per event album</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Gallery albums grid" decoding="async" loading="lazy" src="image/assets/pekom/gallery-albums.jpg"/><figcaption class="img-caption">The albums, each opening in the story style photo viewer</figcaption></figure>
<figure class="rf-figure-lg"><img alt="News page with the featured story" decoding="async" loading="lazy" src="image/assets/pekom/news-featured.jpg"/><figcaption class="img-caption">News, led by the featured story</figcaption></figure>
</div>

<div class="rf-livegroup">
<p class="rf-livegroup-title">Partners, Merch and Recruitment</p>
<figure class="rf-figure-lg"><img alt="Partners header with a scrolling row of partner names" decoding="async" loading="lazy" src="image/assets/pekom/partners-header.jpg"/><figcaption class="img-caption">Partners, with past sponsors running in a marquee</figcaption></figure>
<figure class="rf-figure-lg"><img alt="PEKOM 26/27 merch collection with four items" decoding="async" loading="lazy" src="image/assets/pekom/merch-collection.jpg"/><figcaption class="img-caption">The 26/27 merch collection, ordered through a pre-filled form</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Seven divisions, one committee, with the Data Analyst division open" decoding="async" loading="lazy" src="image/assets/pekom/recruitment-divisions.jpg"/><figcaption class="img-caption">Recruitment: each division with its own apply button</figcaption></figure>
<figure class="rf-figure-lg"><img alt="Tell us about you application form" decoding="async" loading="lazy" src="image/assets/pekom/recruitment-form.jpg"/><figcaption class="img-caption">The application form, which sends a filled in email until the official form is ready</figcaption></figure>
</div>
        </div>
        <br>

        <h3>05 Project Structure</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Next.js App Router. Pages stay thin, and most of what changes lives in <code class="inline">src/lib/</code>.</p>
<div class="project-tree">PEKOM-Website/
├── <span class="pt-dir">src/</span>
│   ├── <span class="pt-dir">app/</span>
│   │   ├── layout.tsx            <span class="pt-comment"># fonts, navbar, footer, language provider</span>
│   │   ├── page.tsx              <span class="pt-comment"># home</span>
│   │   ├── globals.css           <span class="pt-comment"># palette, type, animations</span>
│   │   ├── <span class="pt-dir">events/</span>
│   │   │   ├── page.tsx
│   │   │   └── <span class="pt-dir">[slug]/</span>page.tsx   <span class="pt-comment"># 19 static event pages</span>
│   │   ├── about/  gallery/  news/  members/
│   │   └── merch/  partners/  recruitment/  join/
│   ├── <span class="pt-dir">components/</span>           <span class="pt-comment"># 34 shared pieces: Navbar, Lightbox, TextReveal, ...</span>
│   │   └── <span class="pt-dir">pages/</span>            <span class="pt-comment"># one component per page</span>
│   └── <span class="pt-dir">lib/</span>
│       ├── events.ts             <span class="pt-comment"># events, status, TBC, calendar links</span>
│       ├── news.ts
│       ├── members.ts            <span class="pt-comment"># committee and members tree</span>
│       ├── about.ts  involve.ts  merch.ts
│       ├── links.ts              <span class="pt-comment"># outside links, null until provided</span>
│       ├── i18n.tsx              <span class="pt-comment"># EN, BM, 中文</span>
│       └── photo-ratios.ts       <span class="pt-comment"># generated, one ratio per photo</span>
└── <span class="pt-dir">public/</span>
    ├── <span class="pt-dir">photos/</span>               <span class="pt-comment"># WebP event photos</span>
    ├── <span class="pt-dir">videos/</span>               <span class="pt-comment"># hero loop, MP4 and WebM</span>
    └── <span class="pt-dir">partners/</span>             <span class="pt-comment"># partner logos</span></div>
        </div>
        <br>

        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Next.js 16</span>
<span class="badge blog-badge badge-neutral">React 19</span>
<span class="badge blog-badge badge-neutral">TypeScript</span>
<span class="badge blog-badge badge-neutral">Tailwind CSS v4</span>
<span class="badge blog-badge badge-neutral">Lenis</span>
<span class="badge blog-badge badge-neutral">Lucide</span>
<span class="badge blog-badge badge-neutral">next/font</span>
<span class="badge blog-badge badge-neutral">Google Analytics 4</span>
<span class="badge blog-badge badge-neutral">GitHub Pull Requests</span>
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
