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
                <span class="badge blog-badge badge-blue">Figma</span>
                <span class="badge blog-badge badge-green">Vanilla JS</span>
                <span class="badge blog-badge badge-purple">Canvas API</span>
                <span class="badge blog-badge badge-orange">Google Apps Script</span>
                <span class="badge blog-badge badge-neutral">Mobile-First</span>
            </div>
            <h1>BriskWalk</h1>
            <br>
            <span>Event registration platform for PPI Malaysia&#x27;s annual community charity walk. Designed in Figma, built with vanilla HTML/CSS/JS, multi-step form, client-side image compression, and a Google Sheets backend.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Designer &amp; Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Organizer</span><span class="p-meta-v">PPI Malaysia</span></span><span class="p-meta-item"><span class="p-meta-k">Venue</span><span class="p-meta-v">Dataran Putrajaya</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>BriskWalk</strong> is the event registration platform I designed and built for PPI Malaysia's annual community charity walk, a single-page, mobile-first form that participants fill out on their phones to sign up, pay the registration fee, and upload proof of payment, all in one flow.</p>
<p class="p-text">I designed the UI in Figma, then built it in vanilla HTML, CSS, and JavaScript, no framework, because the form does one job: collect a participant's details fast on a phone, on a slow connection, at a crowded booth.</p>

<strong>The detail that mattered most:</strong> payment proof screenshots from phone cameras can be 4-8MB each. Uploading dozens of those over campus Wi-Fi would have been painfully slow, so the image compression pipeline became the most important piece of engineering in the whole project.
                                
<p>Registration ran from <strong>13 March: 3 May 2026</strong> for the walk held at <strong>Dataran Putrajaya on 10 May 2026</strong>, with a flat RM15 registration fee redeemable for food and beverages at the event booth.</p>
        </div>
        <br>
        <h3>02 Interface</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">The registration form as participants saw it, plus the event identity it was built around.</p><figure class="rf-figure rf-crop"><img class="blog-img" alt="Participant registration form with client-side image compression" decoding="async" loading="lazy" src="image/assets/briskwalk/briswalk_form.png"/><figcaption class="img-caption"><b>Registration</b>: Participant registration form with client-side image compression</figcaption></figure><figure class="rf-figure"><img class="blog-img" alt="Event identity" decoding="async" loading="lazy" src="image/assets/briskwalk/logo_briswalk.png"/><figcaption class="img-caption"><b>BriskWalk</b>: Event identity</figcaption></figure>
        </div>
        <br>
        <h3>03 Image Compression Pipeline</h3>
        <div class="blog-content-body">
<p>Every participant uploads a payment proof screenshot before submitting. Rather than send the raw file straight to the backend, the form compresses it client-side using the <strong>Canvas API</strong> before upload:</p>

1
Read &amp; decode
The uploaded image is read via <code class="inline">FileReader</code> and drawn onto an off-screen <code class="inline">&lt;canvas&gt;</code> element.

2
Auto-resize
Images wider than 1400px are downscaled to fit, since a payment screenshot never needs to be larger than that to stay legible.

3
Re-encode to WebP
The canvas exports to <strong><mark class="hl">WebP at 78% quality</mark></strong> via <code class="inline">canvas.toBlob()</code>, typically cutting file size by 70-90% versus the original camera screenshot.

4
Upload
The compressed blob is sent to the backend, keeping every submission fast even on weak mobile data.

<button class="p-acc-trigger"><span class="p-acc-num">1</span><span class="p-acc-title">Read &amp; decode</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">The uploaded image is read via <code class="inline">FileReader</code> and drawn onto an off-screen <code class="inline">&lt;canvas&gt;</code> element.</p>

<button class="p-acc-trigger"><span class="p-acc-num">2</span><span class="p-acc-title">Auto-resize</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">Images wider than 1400px are downscaled to fit, since a payment screenshot never needs to be larger than that to stay legible.</p>

<button class="p-acc-trigger"><span class="p-acc-num">3</span><span class="p-acc-title">Re-encode to WebP</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">The canvas exports to <strong><mark class="hl">WebP at 78% quality</mark></strong> via <code class="inline">canvas.toBlob()</code>, typically cutting file size by 70-90% versus the original camera screenshot.</p>

<button class="p-acc-trigger"><span class="p-acc-num">4</span><span class="p-acc-title">Upload</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">The compressed blob is sent to the backend, keeping every submission fast even on weak mobile data.</p>
        </div>
        <br>
        <h3>04 Backend &amp; Data Flow</h3>
        <div class="blog-content-body">
<p>There's no traditional server here, the whole backend runs on <strong>Google Apps Script</strong>, deployed as a web app endpoint that the registration form posts to directly.</p>
<ul style="margin:8px 0 0 18px; color:var(--body); line-height:1.8;">
<ul><li>Participant details (name, university, WhatsApp number) are appended as a new row in a <strong>Google Sheet</strong>, giving the PPI Malaysia organizing team a live, shareable spreadsheet of registrations with zero extra tooling.</li>
<li>The compressed payment proof image is uploaded straight into a <strong>Google Drive</strong> folder, named and linked back to its corresponding sheet row.</li>
<li>This kept the entire project free to run and easy for non-technical committee members to check and verify payments without needing a dashboard or login.</li></ul>
        </div>
        <br>
        <h3>05 Form Design</h3>
        <div class="blog-content-body">
<p>The layout is split into two stacked sections so the form never feels overwhelming on a small screen: participant details first (name, university, WhatsApp number), then payment second (QR code, bank transfer details, and the upload field).</p>

<ul><li><b>Event meta at a glance</b>: Registration window, venue, and event date sit right under the logo so participants don't have to scroll or guess.</li>
<li><b>Built-in QR payment</b>: A QR code and bank details are shown inline, so participants can pay without leaving the page or switching apps.</li>
<li><b>One-tap upload</b>: The proof-of-payment field opens the phone's camera roll directly, no extra steps between paying and submitting.</li>
<li><b>Single submit action</b>: One "Register" button at the bottom handles validation and submission for the whole form in one go.</li></ul>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Figma</span>
<span class="badge blog-badge badge-neutral">Vanilla JS</span>
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">Canvas API</span>
<span class="badge blog-badge badge-neutral">WebP</span>
<span class="badge blog-badge badge-neutral">Google Apps Script</span>
<span class="badge blog-badge badge-neutral">Google Sheets</span>
<span class="badge blog-badge badge-neutral">Google Drive</span>
</div>
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
