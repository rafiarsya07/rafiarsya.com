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

        <figure class="p-hero"><img alt="llmclassification screenshot" decoding="async" src="image/assets/llmclassification/cover.jpg"/></figure>
        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Python</span>
                <span class="badge blog-badge badge-green">scikit-learn</span>
                <span class="badge blog-badge badge-purple">pandas</span>
                <span class="badge blog-badge badge-orange">TF-IDF</span>
                <span class="badge blog-badge badge-neutral">Learning Exercise</span>
            </div>
            <h1>LLM Response Preference Baseline</h1>
            <br>
            <span>Given a prompt and two chatbot answers, predict which one a person preferred. A TF-IDF and logistic regression baseline, built end to end.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Baseline, on placeholder data</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo</span></span><span class="p-meta-item"><span class="p-meta-k">Scope</span><span class="p-meta-v">Pipeline, not a competitive score</span></span></div>
            <a href="https://github.com/rafiarsya07/llm-classification" target="_blank" rel="noopener" class="ext-link">View on GitHub<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">A first, honest baseline for a preference prediction task: three outcomes (A wins, B wins, tie), scored by log loss. It runs on a small stand-in dataset so the pipeline could be built before the full download.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Clear framing</b>: prompt plus each answer becomes one document per side</li>
<li><b>Baseline model</b>: TF-IDF word and bigram features with logistic regression</li>
<li><b>Proper validation</b>: a stratified split and log loss, the competition metric</li>
<li><b>Next steps</b>: sentence embeddings, length features, then a small transformer</li>
</ul>
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
