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

        <figure class="p-hero"><img alt="PaperMind answering questions about an uploaded paper" decoding="async" src="image/assets/papermind/chat-pages-rag.png"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">RAG</span>
                <span class="badge blog-badge badge-green">LLM</span>
                <span class="badge blog-badge badge-purple">React + Vite</span>
                <span class="badge blog-badge badge-orange">FastAPI</span>
                <span class="badge blog-badge badge-neutral">ChromaDB</span>
                <span class="badge blog-badge badge-blue">Ollama</span>
                <span class="badge blog-badge badge-green">phi3:mini</span>
                <span class="badge blog-badge badge-purple">Docker Compose</span>
            </div>
            <h1>PaperMind</h1>
            <br>
            <span>Upload a research paper, ask questions and get answers and summaries grounded in the text. Runs fully on local models: no API costs, no data leaving the machine.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">In Development</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Approach</span><span class="p-meta-v">RAG, Local LLM</span></span></div><a href="https://papermind.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">papermind.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Chatbots answer confidently about papers they have not read. PaperMind reads the paper first, then answers only from it, using retrieval augmented generation.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Grounded answers</b>: relevant passages are retrieved before the model answers</li>
<li><b>One-click summary</b>: topic, objectives, method, findings and conclusions</li>
<li><b>Paper library</b>: each PDF gets its own collection, so answers never mix papers</li>
<li><b>Private by design</b>: local LLM and embeddings through Ollama</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
<figure class="rf-figure rf-crop"><img alt="Section-by-section summarization view" class="blog-img" decoding="async" loading="lazy" src="image/assets/papermind/summarize-pages-rag.png"/><figcaption class="img-caption"><b>Summarize</b>: Section-by-section summarization view</figcaption></figure>
<figure class="rf-figure rf-crop rf-portrait"><img alt="A generated summary with its source passages" class="blog-img" decoding="async" loading="lazy" src="image/assets/papermind/answer-summarize.png"/><figcaption class="img-caption"><b>Output</b>: A generated summary with its source passages</figcaption></figure>
<figure class="rf-figure rf-portrait"><img alt="How a question is rendered" class="blog-img" decoding="async" loading="lazy" src="image/assets/papermind/chat-asking-bubble.png"/><figcaption class="img-caption"><b>Question</b>: How a question is rendered</figcaption></figure>
<figure class="rf-figure"><img alt="How a retrieved answer is rendered" class="blog-img" decoding="async" loading="lazy" src="image/assets/papermind/chat-answer-bubble.png"/><figcaption class="img-caption"><b>Answer</b>: How a retrieved answer is rendered</figcaption></figure>
<figure class="rf-figure"><video controls="" loop="" playsinline="" preload="metadata" src="image/assets/papermind/doc-chat-rag.mp4"></video><figcaption class="img-caption"><b>Chat demo</b>: Loading a PDF and querying it</figcaption></figure>
<figure class="rf-figure"><video controls="" loop="" playsinline="" preload="metadata" src="image/assets/papermind/doc-summarize-rag.mp4"></video><figcaption class="img-caption"><b>Summary demo</b>: Summarizing a full paper</figcaption></figure>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">React 18</span>
<span class="badge blog-badge badge-neutral">Vite</span>
<span class="badge blog-badge badge-neutral">FastAPI</span>
<span class="badge blog-badge badge-neutral">ChromaDB</span>
<span class="badge blog-badge badge-neutral">Ollama</span>
<span class="badge blog-badge badge-neutral">phi3:mini</span>
<span class="badge blog-badge badge-neutral">nomic-embed</span>
<span class="badge blog-badge badge-neutral">PyPDF2</span>
<span class="badge blog-badge badge-neutral">Docker</span>
<span class="badge blog-badge badge-neutral">nginx</span>
<span class="badge blog-badge badge-neutral">Cloudflare</span>
</div>
</div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://papermind.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">papermind.rafiarsya.com</span>
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
        <br>
        <div class="text-center text-silent text14">
            &#169; MUHAMMAD RAFI ARSYA
        </div>
        <br>
    </div>
</div>
