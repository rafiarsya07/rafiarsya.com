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
                <span class="badge blog-badge badge-blue">React + Vite</span>
                <span class="badge blog-badge badge-green">Node.js + Express</span>
                <span class="badge blog-badge badge-purple">pdfjs-dist</span>
                <span class="badge blog-badge badge-orange">Tailwind</span>
                <span class="badge blog-badge badge-neutral">Zero AI / Zero Cost</span>
            </div>
            <h1>Resume Match</h1>
            <br>
            <span>An algorithmic resume-to-job scoring engine, upload a resume PDF and a job description, get a fit score with a full breakdown of matched skills, missing skills, and extra value. No AI model, no API key, no database, pure tokenization, synonym canonicalization, and weighted scoring.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed, Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Type</span><span class="p-meta-v">Algorithm Engine, Full Stack</span></span><span class="p-meta-item"><span class="p-meta-k">Cost</span><span class="p-meta-v">$0, No API Calls</span></span></div><a href="https://resumematch.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">resumematch.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>Resume Match</strong> answers a question every job applicant has: "how well does my resume actually fit this listing?", without sending a single byte to an AI API. Upload a resume PDF and a job description (pasted or PDF), and the engine returns an overall fit score plus a category breakdown.</p>
<p>The deliberate design choice was <strong><mark class="hl">no AI, no LLM calls</mark></strong>: every score comes from deterministic logic: tokenization, a hand-built synonym dictionary, section-aware weighting, and regex-based experience/education extraction. The same category of system real ATS tools used before deep learning got cheap.</p>

<strong>Every number is explainable.</strong> Because nothing routes through a black-box model, every point of the score traces back to a specific rule you can read in the source, which makes the project a genuine talking point for technical interviews, not just an API wrapper.
                                
<p>Stateless by design: nothing gets persisted, no database, no accounts. Upload, analyze, get the breakdown, done.</p>
        </div>
        <br>
        <h3>02 How the Algorithm Works</h3>
        <div class="blog-content-body">
<ul><li><b>2. Canonicalize</b>: Each token is matched against a hand-built synonym dictionary, "Reactjs", "react.js", and "React" all collapse to one canonical term, so phrasing differences don't break the match.</li>
<li><b>3. Split by Importance</b>: The job description is split at the first "nice to have"-style header. Everything before is a hard requirement; everything after is weighted lower in the final score.</li>
<li><b>4. Weighted Scoring</b>: Required skill match, nice-to-have match, experience match, and education match are combined into one overall percentage, each skill weighted by how often it's mentioned in the listing.</li>
<li><b>5. Experience &amp; Education Extraction</b>: Regex detects phrases like "3+ years" or "minimum 2 tahun" in the job text, and date ranges like "Since 2022" in the resume, merging overlapping ranges so concurrent roles don't inflate the total.</li>
<li><b>PDF Text Extraction</b>: Both resume and job description PDFs are parsed server-side with pdfjs-dist, no manual copy-pasting required for either input.</li></ul>
        </div>
        <br>
        <h3>03 Scoring Formula</h3>
        <div class="blog-content-body">
<p>The overall score is a weighted composite of four independently-calculated signals:</p>

<pre style="background:#0f172a;color:#e2e8f0;border-radius:10px;padding:16px 18px;font-family: 'JetBrains Mono', 'Segoe UI Symbol','Apple Symbols','Noto Sans Symbols 2','DejaVu Sans','Arial Unicode MS', monospace;font-size:12.5px;overflow-x:auto;line-height:1.7;">overallScore = requiredSkillMatch    × 0.55
             + niceToHaveSkillMatch  × 0.15
             + experienceMatch       × 0.20
             + educationMatch        × 0.10</pre>
<p style="margin-top:12px;">Skill match percentages aren't a flat count, a skill mentioned three times in the listing pulls more weight toward the score than one mentioned once, since the algorithm treats repetition as a proxy for importance.</p>
        </div>
        <br>
        <h3>3b The Math Behind the Match</h3>
        <div class="blog-content-body">
<p class="p-text">Each of the four signals in <code class="inline">overallScore</code> is itself a non-trivial computation. This section formalises the engine as it actually runs: weighted set similarity over a canonicalised term space, not a keyword count.</p>

<p><strong>1. Weighted skill coverage.</strong> Let <span class="katex-inline">R</span> be the set of required skills extracted from the job listing and <span class="katex-inline">M \subseteq R</span> the subset matched in the resume. Each skill <span class="katex-inline">t</span> carries a weight <span class="katex-inline">w_t</span> equal to its mention frequency in the listing, repetition is treated as a proxy for importance. The required-skill match is the weighted coverage ratio:</p>
<div class="p-math-block">
<div class="p-math-label">Frequency-weighted coverage</div>
<div class="katex-display-src">\text{requiredSkillMatch} = \frac{\displaystyle\sum_{t \in M} w_t}{\displaystyle\sum_{t \in R} w_t}, \qquad w_t = \text{count}(t \mid \text{listing})</div>
</div>
<p>This is why one skill mentioned three times moves the needle more than one mentioned once: the denominator and numerator are both mass over weights, not cardinalities of sets.</p>

<p><strong>2. Why not plain Jaccard?</strong> A flat set-overlap score would treat every term as equally important. The engine instead uses a <em>weighted</em> generalization of Jaccard similarity, which collapses to the classic form only when all weights are equal:</p>
<div class="p-math-block">
<div class="p-math-label">Weighted Jaccard (term importance preserved)</div>
<div class="katex-display-src">J_w(R, P) = \frac{\displaystyle\sum_{t} \min(w_t^{R},\, w_t^{P})}{\displaystyle\sum_{t} \max(w_t^{R},\, w_t^{P})} \;\xrightarrow[w \equiv 1]{}\; \frac{|R \cap P|}{|R \cup P|}</div>
</div>
<p>Here <span class="katex-inline">P</span> is the candidate (resume) term profile. The canonicalization step matters mathematically: by mapping <code class="inline">react.js</code>, <code class="inline">Reactjs</code>, and <code class="inline">React</code> to one term, it prevents the denominator from being inflated by synonym duplicates, without it, <span class="katex-inline">J_w</span> systematically under-reports true overlap.</p>

<p><strong>3. TF-IDF intuition for importance weighting.</strong> Mention-frequency weighting is a deliberate simplification of full TF-IDF. The general term weight that motivates the design is:</p>
<div class="p-math-block">
<div class="p-math-label">TF-IDF term weight</div>
<div class="katex-display-src">\text{tfidf}(t, d) = \underbrace{\frac{f_{t,d}}{\sum_{t'} f_{t',d}}}_{\text{term frequency}} \times \underbrace{\log\!\frac{N}{1 + |\{d: t \in d\}|}}_{\text{inverse document frequency}}</div>
</div>
<p>Because a single job listing is one document, IDF degenerates to a constant per run, so the engine keeps only the TF component, formally justifying the "count = weight" rule rather than treating it as an arbitrary heuristic.</p>

<p><strong>4. Experience matching, interval union, not naive sum.</strong> Date ranges in a resume overlap (concurrent roles), so summing durations double-counts time. The engine merges intervals first, then measures total covered span. Given raw ranges <span class="katex-inline">\{[a_i, b_i]\}</span>:</p>

Sort by start, then merge any pair that overlaps or touches into a single interval:
<div class="p-math-block"><div class="katex-display-src">[a_i, b_i] \cup [a_j, b_j] = [\min(a_i,a_j),\, \max(b_i,b_j)] \quad \text{if } a_j \le b_i</div></div>

Total experience is the measure of the disjoint union of merged intervals \mathcal{U}:
<div class="p-math-block"><div class="katex-display-src">Y_{\text{total}} = \sum_{[a,b]\in\mathcal{U}} (b - a)</div></div>

The experience signal saturates at the requirement Y_{req}, exceeding it can't push the score past 1:
<div class="p-math-block"><div class="katex-display-src">\text{experienceMatch} = \min\!\left(1,\ \frac{Y_{\text{total}}}{Y_{\text{req}}}\right)</div></div>

<p><strong>5. The composite as a convex combination.</strong> The four signals are blended with weights that form a partition of unity, which guarantees the output is always a valid percentage in <span class="katex-inline">[0, 1]</span> regardless of the inputs:</p>
<div class="p-math-block">
<div class="p-math-label">Convex blend of normalized signals</div>
<div class="katex-display-src">\text{score} = \sum_{k} \alpha_k\, s_k, \qquad \sum_k \alpha_k = 1,\quad \alpha_k \ge 0,\quad s_k \in [0,1]</div>
</div>
<div class="p-math-block">
<div class="p-math-label">Instantiated weights</div>
<div class="katex-display-src">\boldsymbol{\alpha} = (0.55,\ 0.15,\ 0.20,\ 0.10) \;\Rightarrow\; \textstyle\sum \alpha_k = 1.00</div>
</div>

<strong>Why convexity is the safety net.</strong> Because each <span class="katex-inline">s_k \in [0,1]</span> and the weights sum to one, the result is a weighted average, it can never exceed any individual signal's ceiling, so a perfect skills match can't paper over zero experience beyond the share its weight allows.
        </div>
        <br>
        <h3>04 Why "No AI" Was the Point</h3>
        <div class="blog-content-body">
<p>It would have been faster to wrap an LLM call and prompt it to "compare this resume to this job." That's not what this project demonstrates. The goal was to build the kind of deterministic, rule-based system that shows actual algorithm design, the weights, the edge cases, the synonym dictionary, are things I designed and can defend, not a prompt I wrote.</p>

<strong>Zero ongoing cost, by construction.</strong> No API keys, no per-request billing, no rate limits to worry about. The entire engine runs on plain JavaScript logic that's auditable line by line.
        </div>
        <br>
        <h3>05 Multi-Language Support</h3>
        <div class="blog-content-body">
<p>The stopword and synonym dictionaries are structured so a new language needs no change to the matching logic, add a language key with its stopword list and localised variants. Tokenisation is language-agnostic; dictionary coverage is strongest for English, Indonesian, and Malay.</p>
        </div>
        <br>
        <h3>App Modules</h3>
        <div class="blog-content-body">
<span>Tokenizer / Keyword Extractor</span><span>100%</span>

<span>Synonym Canonicalization</span><span>100%</span>

<span>Matching Engine / Scoring</span><span>100%</span>

<span>PDF Extraction (pdfjs-dist)</span><span>100%</span>

<span>React Frontend / Score Ring</span><span>100%</span>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">React</span>
<span class="badge blog-badge badge-neutral">Vite</span>
<span class="badge blog-badge badge-neutral">Tailwind</span>
<span class="badge blog-badge badge-neutral">Node.js</span>
<span class="badge blog-badge badge-neutral">Express</span>
<span class="badge blog-badge badge-neutral">Multer</span>
<span class="badge blog-badge badge-neutral">pdfjs-dist</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://resumematch.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">resumematch.rafiarsya.com</span>
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
