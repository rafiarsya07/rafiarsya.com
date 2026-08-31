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
                <span class="badge blog-badge badge-blue">Vanilla JS</span>
                <span class="badge blog-badge badge-green">Single HTML File</span>
                <span class="badge blog-badge badge-purple">Procedural Question Generation</span>
                <span class="badge blog-badge badge-orange">Lucide Icons</span>
                <span class="badge blog-badge badge-neutral">Cloudflare Pages</span>
            </div>
            <h1>CSA Study App</h1>
            <br>
            <span>A self-contained exam prep tool for WRES1201 (Computer Systems Architecture). Topic guide, formula reference, MCQ drills, and interactive visualizers for cache mapping, Hamming codes, and arithmetic shifts, with every number re-randomized on each reload so it never gets stale.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed, Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Type</span><span class="p-meta-v">Study Tool, Course Prep</span></span><span class="p-meta-item"><span class="p-meta-k">File Size</span><span class="p-meta-v">1 HTML file</span></span></div><a href="https://csastudy.rafiarsya.com" target="_blank" rel="noopener" class="hrefnocolor">csastudy.rafiarsya.com &#8599;</a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>CSA Study App</strong> was built during finals week for WRES1201, Computer Systems Architecture, after I realized the questions I actually needed practice on (instruction mix, CPI, cache addressing, Hamming codes, disk timing) weren't well covered by any existing revision material.</p>
<p class="p-text">Same constraint as RafiFinance: one HTML file, no dependencies beyond a CDN icon set. Every numeric question, instruction counts, clock rates, cache sizes, RPMs, is generated with randomised values each page load, so practising twice never means memorising the same answer.</p>

<strong>Built to be shared, not just used.</strong> Once it worked for me, I put it on its own subdomain and sent it to classmates, no install, no signup, just open the link and start drilling.
                                
<p>Covers T1 through T10 of the syllabus, with topics outside the final exam scope (T1, T7, T9) clearly tagged so revision time goes where it actually counts.</p>
        </div>
        <br>
        <h3>02 Features</h3>
        <div class="blog-content-body">
<ul><li><b>Formula Reference</b>: Every formula in the syllabus, when to use it, what each variable means, and a worked example with real numbers.</li>
<li><b>Challenge Drills</b>: Theory and applied questions across every topic. Numbers and answer order re-roll on every refresh, so the same question never looks identical twice.</li>
<li><b>MCQ Concept Drill</b>: Multiple-choice theory + applied questions with options that shuffle on every reload, built so you can't pattern-match the answer position.</li>
<li><b>Shift Visualizer</b>: Interactive bit-shift visualization for logical/arithmetic shifts, see exactly which bits move where and what falls off the end.</li>
<li><b>Hamming Code Tool</b>: Generates a random data word, walks through parity-bit placement and the even-parity XOR calculation for each position step by step.</li>
<li><b>Cache Mapper</b>: Splits a binary memory address into tag, line, and offset for direct-mapped / set-associative caches, with the bit math shown explicitly.</li>
<li><b>Smart Calculator</b>: Enter whatever the question already gives you, CPI, clock rate, instruction count, disk RPM, and get every derived value at once, no need to remember which formula comes first.</li></ul>
        </div>
        <br>
        <h3>03 Topics Covered</h3>
        <div class="blog-content-body">
<p>The syllabus spans ten topic blocks. Topics tagged <strong>not-in-final</strong> are kept in the app for completeness but hidden by default with a "Focus Mode" toggle:</p>

<ul><li><b>T3: Bus &amp; Data Transfer</b>: Transfer rate from bus width, clock speed, and bus cycles, with the bit-to-byte conversion that trips most people up.</li>
<li><b>T4: Cache Memory</b>: Address splitting (tag / line / offset), cache sizing, line and set counts, and miss-time calculation.</li>
<li><b>T5: Error Correction</b>: Hamming code parity-bit calculation using even-parity XOR across covered bit positions.</li>
<li><b>T6: Secondary Storage</b>: Seek time, rotational latency, transfer time per sector, disk capacity, and RAID 0/1/3/4/5/6 capacity multipliers.</li>
<li><b>T8: Instruction Sets</b>: Addressing modes and instruction format rules, drilled as randomized name-the-rule questions.</li>
<li><b>T10: Pipelining</b>: Pipelined execution time, fill/drain cycles, and per-stage time with latch overhead included.</li>
<li><b>T1, T7, T9: Not in Final</b>: Kept in the app and tagged accordingly, but hidden by default in Focus Mode so revision stays scoped to what's actually examined.</li></ul>
        </div>
        <br>
        <h3>04 Why Randomized Numbers</h3>
        <div class="blog-content-body">
<p>Most revision PDFs reuse the same five worked examples everyone has already memorised. Generating the values at runtime means the formula gets tested, not the specific numbers.</p>

<strong>The drill never repeats.</strong> Closing the tab and reopening it gives a fresh set of values for every question type, you can practice the same topic dozens of times without the answer becoming familiar by memory instead of method.
                                
<p>The MCQ section goes a step further: answer order shuffles independently of the question values, so guessing by position never works either.</p>
        </div>
        <br>
        <h3>4b Under the Hood, The Hard Math</h3>
        <div class="blog-content-body">
<p>The "By the Numbers" tiles hide a lot of formula work. This section unpacks the heavier derivations the app evaluates live, the ones students most often get wrong because they collapse several conversions into one step. Every quantity below is recomputed on each page load against freshly randomized inputs.</p>

<p><strong>1. CPU performance, from instruction mix to wall-clock time.</strong> Given an instruction mix where class <em>i</em> occurs with frequency <span class="katex-inline">f_i</span> and costs <span class="katex-inline">c_i</span> cycles, the effective cycles-per-instruction is the frequency-weighted mean, and execution time folds in the clock period:</p>
<div class="p-math-block">
<div class="p-math-label">Effective CPI &amp; execution time</div>
<div class="katex-display-src">\text{CPI}_{\text{eff}} = \sum_{i=1}^{n} f_i\, c_i, \qquad T_{\text{exec}} = \frac{I \times \text{CPI}_{\text{eff}}}{f_{\text{clk}}} = I \times \text{CPI}_{\text{eff}} \times t_{\text{cycle}}</div>
</div>
<table class="p-vartable">
<tr><td>I</td><td>total instruction count (dynamic, not static)</td></tr>
<tr><td>f_i, c_i</td><td>relative frequency and cycle cost of instruction class i, with \sum f_i = 1</td></tr>
<tr><td>f_clk</td><td>clock frequency in Hz; t_cycle = 1/f_clk</td></tr>
</table>
<p>From here MIPS is a derived rate, <span class="katex-inline">\text{MIPS} = \dfrac{f_{\text{clk}}}{\text{CPI}_{\text{eff}} \times 10^{6}}</span>, which is exactly where unit errors creep in, the <span class="katex-inline">10^{6}</span> is per <em>million</em> instructions, not the SI mega-prefix on the clock.</p>

<p><strong>2. Amdahl's Law, the ceiling on speedup.</strong> When only a fraction <span class="katex-inline">p</span> of a workload is accelerated by a factor <span class="katex-inline">s</span>, the overall speedup is bounded, and the bound is brutal:</p>
<div class="p-math-block">
<div class="p-math-label">Speedup with a hard asymptote</div>
<div class="katex-display-src">S(s) = \frac{1}{(1-p) + \dfrac{p}{s}} \quad\xrightarrow[s\to\infty]{}\quad S_{\max} = \frac{1}{1-p}</div>
</div>
<p>The app uses this to make a point students miss: if <span class="katex-inline">p = 0.9</span>, no amount of hardware ever beats a <span class="katex-inline">10\times</span> speedup, because the serial <span class="katex-inline">10\%</span> dominates in the limit.</p>

<p><strong>3. Pipelining, throughput vs. latency with latch overhead.</strong> A <span class="katex-inline">k</span>-stage pipeline does not divide time by <span class="katex-inline">k</span>. The clock is pinned to the slowest stage <em>plus</em> register-latch delay, and the pipe must fill before the first result emerges. For <span class="katex-inline">N</span> instructions:</p>
<div class="p-math-block">
<div class="p-math-label">Cycle time, total time, and limiting speedup</div>
<div class="katex-display-src">\tau = \max_j(\tau_j) + \tau_{\text{latch}}, \qquad T_{\text{pipe}} = \big(k + (N-1)\big)\,\tau, \qquad S = \frac{N \cdot k\,\tau_{\text{unpipe}}}{\big(k+N-1\big)\tau} \xrightarrow[N\to\infty]{} k</div>
</div>

<strong>Why the ideal is never reached.</strong> The <span class="katex-inline">(k-1)</span> fill cycles and the per-stage latch delay <span class="katex-inline">\tau_{\text{latch}}</span> both tax throughput, so realized speedup sits strictly below the <span class="katex-inline">k\times</span> asymptote for any finite instruction stream.
                                

<p><strong>4. Cache address arithmetic, derived bitfields, not guessed.</strong> For a <span class="katex-inline">2^m</span>-byte address space, block size <span class="katex-inline">B = 2^b</span> bytes, and a set-associative cache holding <span class="katex-inline">S = 2^s</span> sets, the address splits into three exact bitfields:</p>
<div class="p-math-block">
<div class="p-math-label">Tag / index / offset partition</div>
<div class="katex-display-src">\underbrace{m - s - b}_{\text{tag bits}} \;\Vert\; \underbrace{s}_{\text{index bits}} \;\Vert\; \underbrace{b}_{\text{offset bits}}, \qquad S = \frac{C}{B \times A}</div>
</div>
<p>where <span class="katex-inline">C</span> is total cache capacity and <span class="katex-inline">A</span> is associativity. Average memory access time then composes the hierarchy recursively:</p>
<div class="p-math-block">
<div class="p-math-label">AMAT</div>
<div class="katex-display-src">\text{AMAT} = t_{\text{hit}} + m_{\text{rate}} \times t_{\text{penalty}}</div>
</div>

<p><strong>5. Hamming SEC code, the parity inequality.</strong> To correct any single-bit error over <span class="katex-inline">d</span> data bits, the number of parity bits <span class="katex-inline">r</span> must satisfy the redundancy inequality, because the <span class="katex-inline">r</span> check bits must address every one of the <span class="katex-inline">d+r</span> code positions <em>plus</em> the no-error syndrome:</p>
<div class="p-math-block">
<div class="p-math-label">Minimum parity bits</div>
<div class="katex-display-src">2^{r} \;\geq\; d + r + 1</div>
</div>
<p>Each parity bit <span class="katex-inline">p_k</span> (sitting at position <span class="katex-inline">2^{k}</span>) covers exactly the positions whose binary index has bit <span class="katex-inline">k</span> set, and is fixed by even parity:</p>
<div class="p-math-block">
<div class="p-math-label">Even-parity assignment via XOR</div>
<div class="katex-display-src">p_k = \bigoplus_{\substack{j\,:\,\lfloor j/2^{k}\rfloor \bmod 2 = 1}} b_j</div>
</div>
<p>On read, the syndrome <span class="katex-inline">\mathbf{s} = H\mathbf{r}^{\mathsf{T}}</span> is the XOR of all parity checks; if non-zero, its <em>value read as a binary number is the 1-indexed position of the flipped bit</em>, which is why the app can point straight at the error.</p>

<p><strong>6. Disk access time, three independent latencies plus capacity.</strong> A single sector read is the sum of seek, half-a-rotation average rotational latency, and transfer time; rotational figures come from RPM, so a unit conversion is unavoidable:</p>

Average rotational latency is half the rotation period, derived from revolutions per minute:
<div class="p-math-block"><div class="katex-display-src">t_{\text{rot}} = \frac{1}{2}\cdot\frac{60}{\text{RPM}}\ \text{seconds}</div></div>

Transfer time for one sector is its fraction of a full track, read in one rotation:
<div class="p-math-block"><div class="katex-display-src">t_{\text{xfer}} = \frac{1}{\text{sectors per track}}\cdot\frac{60}{\text{RPM}}</div></div>

Total access time and raw capacity then assemble cleanly:
<div class="p-math-block"><div class="katex-display-src">t_{\text{access}} = t_{\text{seek}} + t_{\text{rot}} + t_{\text{xfer}}, \quad \text{Cap} = \text{surfaces}\times\text{tracks}\times\text{sectors}\times\text{bytes}_{\text{sector}}</div></div>

<p>RAID then applies a usable-capacity multiplier on top: <span class="katex-inline">N\!-\!1</span> drives of <span class="katex-inline">N</span> for RAID 5, <span class="katex-inline">N\!-\!2</span> for RAID 6, and <span class="katex-inline">N/2</span> for mirrored RAID 1.</p>
        </div>
        <br>
        <h3>05 Built for Sharing</h3>
        <div class="blog-content-body">
<ul><li><b>One Link, No Install</b>: Just open csastudy.rafiarsya.com, no account, no app store, works on any phone or laptop with a browser.</li>
<li><b>Shared with Classmates</b>: Built originally for personal revision, then handed off to coursemates for WRES1201 finals prep.</li>
<li><b>No Data Collected</b>: No login, no analytics dashboard, no stored answers, just open it and drill.</li>
<li><b>Exam-Scoped</b>: Focus Mode hides non-final topics so study time goes straight to what's actually tested.</li></ul>
        </div>
        <br>
        <h3>App Sections</h3>
        <div class="blog-content-body">
<span>Topic Guide</span><span>100%</span>

<span>Formula Reference</span><span>100%</span>

<span>Challenge Drills</span><span>100%</span>

<span>MCQ Concept Drill</span><span>100%</span>

<span>Shift Visualizer</span><span>100%</span>

<span>Hamming Code Tool</span><span>100%</span>

<span>Cache Mapper</span><span>100%</span>

<span>Smart Calculator</span><span>100%</span>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Vanilla JS</span>
<span class="badge blog-badge badge-neutral">HTML5</span>
<span class="badge blog-badge badge-neutral">CSS3</span>
<span class="badge blog-badge badge-neutral">Procedural Generation</span>
<span class="badge blog-badge badge-neutral">Lucide Icons CDN</span>
<span class="badge blog-badge badge-neutral">Cloudflare Pages</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://csastudy.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">csastudy.rafiarsya.com</span>
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
