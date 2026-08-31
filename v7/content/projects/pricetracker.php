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
                <span class="badge blog-badge badge-blue">Chrome Extension</span>
                <span class="badge blog-badge badge-purple">Manifest V3</span>
                <span class="badge blog-badge badge-orange">JavaScript</span>
                <span class="badge blog-badge badge-green">Service Worker</span>
                <span class="badge blog-badge badge-neutral">No Backend</span>
            </div>
            <h1>PriceWatch</h1>
            <br>
            <span>A Chrome extension that tracks the price of any product on any website. You click the price on the page once; it re-checks every three hours in the background and sends a notification when the price drops. No scraping API, no server, no account.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Runtime cost</span><span class="p-meta-v">$0, entirely in-browser</span></span></div>
            <a href="https://github.com/rafiarsya07/price-tracker-extension" target="_blank" rel="noopener" class="hrefnocolor">View on GitHub &#8599;</a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Constraint</h3>
        <div class="blog-content-body">
<p>Every price tracker that works across arbitrary shops solves the same problem the same way: a paid scraping service fetches the page, a backend stores the history, a cron job runs the comparison. That is three recurring bills and a server to keep alive, for a tool one person uses.</p>
<p>An extension gets to cheat. It already lives inside a browser that can render any page, it already has storage, and Chrome ships a scheduler and a notification system as APIs. So the whole thing collapses into an extension with no backend at all &mdash; and the design constraint becomes: never need anything Chrome does not already provide.</p>
        </div>
        <br>
        <h3>02 Picking the Price</h3>
        <div class="blog-content-body">
<p>The hard part of universal price tracking is that there is no universal price selector. Shopee, Lazada and Amazon each mark up a price differently, and any of them can change it next week. Guessing is a losing game, so the extension does not guess: it asks.</p>
<p>Click <em>Track price on this page</em>, and the cursor becomes a crosshair. Hovering outlines whatever element is under it; clicking picks that element as the price. The user knows which number on the page is the price, and that one click is worth more than any heuristic.</p>
<p>The text of the picked element is then run through a regex that recognises the formats worth handling:</p>
<pre class="p-math-formula">/(?:rp|idr|\$|usd|myr|rm)?\s?[\d]{1,3}(?:[.,]\d{3})*(?:[.,]\d{2})?/i

  Rp 150.000     Rp150,000      150000        (IDR)
  RM 45.90       MYR 45.90                    (MYR)
  $29.99         USD 29.99                    (USD)</pre>
<p>Separators are stripped to a plain number for comparison, and the currency is detected from the same text so the popup can display it back correctly rather than showing a bare integer.</p>
        </div>
        <br>
        <h3>03 Remembering Where the Price Was</h3>
        <div class="blog-content-body">
<p>Picking the element once is easy. Finding the same element three hours later, in a freshly loaded page, is the actual engineering problem &mdash; and it is why the extension stores a selector rather than a coordinate.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Building a Stable Selector Path</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Algorithm</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">path = []
node = clicked element

while node is an element and not &lt;html&gt;:
        selector = node.tagName.toLowerCase()

        if node has classes:
                selector += "." + classes.map(CSS.escape).join(".")

        # disambiguate against same-tag siblings
        index = position among siblings of the same tag
        if more than one such sibling:
                selector += ":nth-of-type(" + index + ")"

        path.unshift(selector)
        node = node.parentElement

stored selector = path.join(" &gt; ")</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The path is built from the clicked element upwards, so the most specific part is decided first. Classes are included because they usually carry the site's own meaning &mdash; <code class="inline">.product-price</code> survives a layout tweak that moves the element around. They are run through <code class="inline">CSS.escape</code> first, since utility frameworks emit class names full of characters that are illegal in a raw selector.</p><p class="p-math-desc"><code class="inline">:nth-of-type</code> is added only when there is more than one sibling of the same tag. Adding it unconditionally would make the selector brittle for no benefit: a <code class="inline">&lt;span&gt;</code> that is the only span in its parent is already unambiguous, and pinning it to position 1 just means it breaks the moment the site adds a second span above it.</p><p class="p-math-desc">This is a deliberate trade. A paid scraping API would parse the page structurally and be more robust; a selector path costs nothing and works on the large majority of shops. Where it loses, it loses visibly &mdash; the re-check finds nothing and the product stops updating, rather than quietly reporting a wrong number.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">clicked:  &lt;span class="price-now"&gt;Rp 150.000&lt;/span&gt;

walking up
  span.price-now                 (only span in its parent -&gt; no nth)
  div.product-summary
  section:nth-of-type(2)         (three sibling sections -&gt; pinned)
  main
  body

stored
  "body &gt; main &gt; section:nth-of-type(2) &gt;
   div.product-summary &gt; span.price-now"

three hours later
  document.querySelector(stored)  -&gt; same element
  extractPriceFromText(el.textContent) -&gt; 150000</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 The Background Loop</h3>
        <div class="blog-content-body">
<p>A Manifest V3 service worker cannot hold a <code class="inline">setInterval</code> &mdash; Chrome tears it down when it is idle, which is the whole point of the V3 model. Scheduling therefore has to be handed to <code class="inline">chrome.alarms</code>, which wakes the worker back up on its own timetable:</p>
<pre class="p-math-formula">const CHECK_INTERVAL_MINUTES = 180;   // three hours

chrome.alarms.get('priceCheck', alarm =&gt; {
    if (!alarm) chrome.alarms.create('priceCheck',
                    { periodInMinutes: CHECK_INTERVAL_MINUTES });
});</pre>
<p>The alarm is created only if it does not already exist, so a browser restart or an extension reload does not stack duplicate schedules on top of each other.</p>
<p>When it fires, each tracked product is opened in a background tab, the content script reads the stored selector, and the price comes back to the worker. Every reading is appended to a <code class="inline">history</code> array on the product &mdash; capped at 100 entries, oldest shifted off, because storage that only ever grows is a bug on a long enough timeline. If the new price is lower than the stored one, <code class="inline">chrome.notifications</code> fires; clicking the notification opens the product page directly, since a price-drop alert you have to go hunting for is worth very little.</p>
<p>The popup also has a manual refresh, which runs the same check immediately &mdash; useful because otherwise testing the notification path means waiting three hours.</p>
        </div>
        <br>
        <h3>05 Why It Costs Nothing</h3>
        <div class="blog-content-body">
<p>Every moving part maps onto something already in the browser:</p>
<ul>
<li><b>Storage</b> &mdash; <code class="inline">chrome.storage.local</code>. No database, no account, and the data never leaves the machine.</li>
<li><b>Scheduling</b> &mdash; <code class="inline">chrome.alarms</code>. No cron host.</li>
<li><b>Notifications</b> &mdash; <code class="inline">chrome.notifications</code>. No push service.</li>
<li><b>Fetching</b> &mdash; a background tab renders the real page, so JavaScript-rendered prices work without a headless browser service.</li>
</ul>
<p>The permissions are the honest cost of that design. <code class="inline">&lt;all_urls&gt;</code> is required because "any product on any website" cannot be enumerated in advance &mdash; which is a real thing to declare rather than gloss over, and the reason the extension is loaded unpacked rather than published.</p>
        </div>
        <br>
        <h3>06 Project Structure</h3>
        <div class="blog-content-body">
<div class="project-tree">price-tracker-extension/
├── manifest.json     <span class="pt-comment"># Manifest V3 config, permissions</span>
├── background.js     <span class="pt-comment"># service worker: storage, alarms, notifications</span>
├── content.js        <span class="pt-comment"># pick mode, price regex, selector builder</span>
├── content.css       <span class="pt-comment"># hover outline + toast on the page</span>
├── popup.html        <span class="pt-comment"># tracked list, current / lowest / change</span>
├── popup.js
├── popup.css
└── <span class="pt-dir">icons/</span>            <span class="pt-comment"># 16 / 48 / 128 px</span></div>
        </div>
        <br>
        <h3>07 Honest Limits</h3>
        <div class="blog-content-body">
<ul>
<li><b>Selector drift.</b> Sites that randomise or heavily obfuscate their markup between visits will eventually lose the price element. That is the structural trade-off of selector-based tracking against a paid scraping API, not a bug to be patched away.</li>
<li><b>Bot defences.</b> Some shops block automated tab loads. A product that consistently fails to re-check needs a different extraction strategy for that site.</li>
<li><b>Currency detection is heuristic.</b> It reads symbols out of the same text as the price, so an ambiguous listing can be misread. A manual currency override is the obvious fix.</li>
<li><b>Alerts on any drop.</b> There is no target price yet, so a one-cent move notifies exactly like a real sale. Target thresholds and a history sparkline from the stored <code class="inline">history</code> array are the next two features.</li>
</ul>
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
