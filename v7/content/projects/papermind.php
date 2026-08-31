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
            <span>A local RAG-powered academic paper analyzer. Upload any PDF, ask questions, get structured summaries, running 100% privately on self-hosted hardware. Zero cloud, zero cost, zero data leakage.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">In Development</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Approach</span><span class="p-meta-v">RAG, Local LLM</span></span></div><a href="https://papermind.rafiarsya.com" target="_blank" rel="noopener" class="ext-link">papermind.rafiarsya.com<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>PaperMind</strong> started as a frustration. I kept feeding papers to ChatGPT and getting confidently wrong answers. So I built something that actually reads the paper first, then answers from it.</p>
<p class="p-text">PaperMind reads the PDF first: it splits the text into overlapping chunks, embeds each with <strong>nomic-embed-text</strong>, and stores them in ChromaDB. A question retrieves the most relevant chunks and sends them as grounded context to <strong>phi3:mini</strong> on local Ollama. The model answers strictly from the paper.</p>

<strong>Why not just use ChatGPT?</strong> Because your research shouldn't leave your machine. Unpublished papers, draft findings, confidential data, PaperMind processes everything locally. The model runs on the same mini PC as this website.
        </div>
        <br>
        <h3>02 Interface</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Both halves of the tool running against a real PDF. Nothing here leaves the machine: the retrieval index and the model both sit locally, so the same screens work with no network at all.</p><figure class="rf-figure rf-crop"><img class="blog-img" alt="Asking questions against an indexed paper" decoding="async" loading="lazy" src="image/assets/papermind/chat-pages-rag.png"/><figcaption class="img-caption"><b>Chat</b>: Asking questions against an indexed paper</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Section-by-section summarization view" decoding="async" loading="lazy" src="image/assets/papermind/summarize-pages-rag.png"/><figcaption class="img-caption"><b>Summarize</b>: Section-by-section summarization view</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="A generated summary with its source passages" decoding="async" loading="lazy" src="image/assets/papermind/answer-summarize.png"/><figcaption class="img-caption"><b>Output</b>: A generated summary with its source passages</figcaption></figure><figure class="rf-figure"><img class="blog-img" alt="How a question is rendered" decoding="async" loading="lazy" src="image/assets/papermind/chat-asking-bubble.png"/><figcaption class="img-caption"><b>Question</b>: How a question is rendered</figcaption></figure><figure class="rf-figure"><img class="blog-img" alt="How a retrieved answer is rendered" decoding="async" loading="lazy" src="image/assets/papermind/chat-answer-bubble.png"/><figcaption class="img-caption"><b>Answer</b>: How a retrieved answer is rendered</figcaption></figure><figure class="rf-figure"><video controls="" loop="" playsinline="" preload="metadata" src="image/assets/papermind/doc-chat-rag.mp4"></video><figcaption class="img-caption"><b>Chat demo</b>: Loading a PDF and querying it</figcaption></figure><figure class="rf-figure"><video controls="" loop="" playsinline="" preload="metadata" src="image/assets/papermind/doc-summarize-rag.mp4"></video><figcaption class="img-caption"><b>Summary demo</b>: Summarizing a full paper</figcaption></figure>
        </div>
        <br>
        <h3>03 How RAG Works, The Math</h3>
        <div class="blog-content-body">
<p>RAG has two phases: <strong>indexing</strong> (done once per PDF) and <strong>retrieval + generation</strong> (done per query). Here's the actual math:</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Phase 1: PDF Indexing</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">1. Extract text from PDF (PyPDF2 / pdfplumber)
2. Split into overlapping chunks:
   chunk_size    = 500 tokens
   chunk_overlap = 50 tokens

3. For each chunk c_i:
   embedding_i = nomic-embed-text(c_i)
   -- embedding_i is a 768-dim float vector

4. Store in ChromaDB:
   collection.add(documents = [c_i],
     embeddings = [embedding_i],
     ids = [f"doc_{paper_id}_chunk_{i}"]
   )</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">Overlap stops context being split at a boundary, without the <strong>50-token overlap</strong>, a sentence describing a key result could be cut between two chunks and become unretrievable. Each chunk maps to a dense vector in <strong>768-dimensional</strong> space, where similar ideas land close together regardless of wording.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># A 12-page paper, ~9,400 tokens of body text

chunks = split(text, size=500, overlap=50)
→ 21 overlapping chunks produced

# Chunk 7 (positions 2850 to 3350 tokens):
embedding_7 = nomic-embed-text(chunk_7)
→ [0.0123, -0.0871, 0.1442...]  (768 floats)

collection.add(documents=[chunk_7],
  embeddings=[embedding_7],
  ids=["doc_42_chunk_7"]
)
→ stored, ready for retrieval</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Phase 2: Query Retrieval (Cosine Similarity)</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">1. Embed the user's question:
   q_embedding = nomic-embed-text(query)

2. Compute cosine similarity to all chunks:
   similarity(q, c_i) = (q · c_i) / (|q| × |c_i|)

   -- dot product of vectors / product of magnitudes
   -- returns value in [-1, 1], higher = more similar

3. Retrieve top-k chunks by similarity:
   top_chunks = sort(chunks, by=similarity, desc=True)[:5]

4. Build grounded prompt:
   prompt = f"""
   Context from the paper:
   {join(top_chunks)}

   Question: {query}
   Answer strictly based on the context above:
   """

5. Send to phi3:mini via Ollama</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">ChromaDB uses an approximate nearest-neighbour index (HNSW) so retrieval stays fast even across thousands of chunks. The LLM sees only the retrieved context, it cannot access information outside those 5 chunks, which eliminates hallucination by construction rather than by prompting the model to "please be accurate." If the paper genuinely doesn't contain the answer, the top-5 chunks will simply have low similarity scores and the model says so.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Query: "What dataset did the paper use for training?"
q_embedding = nomic-embed-text(query)
→ [0.0091, -0.0654, 0.1308...]

similarity(q, chunk_3)  = 0.81  ← discusses dataset, high match
similarity(q, chunk_7)  = 0.74  ← mentions preprocessing steps
similarity(q, chunk_12) = 0.69  ← results table, some overlap
similarity(q, chunk_1)  = 0.22  ← abstract, low match
similarity(q, chunk_19) = 0.11  ← references section, irrelevant

top_5 = [chunk_3, chunk_7, chunk_12, chunk_9, chunk_15]
→ sent to phi3:mini as grounding context</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 System Architecture</h3>
        <div class="blog-content-body">
<ul><li><b>React 18 + Vite (Frontend)</b>: Port 5173 → nginx on port 3001</li>
<li><b>FastAPI (Backend)</b>: PDF ingestion · chunk pipeline · query endpoint · streaming</li>
<li><b>ChromaDB (Vector Store)</b>: <mark class="hl">768-dim</mark> embeddings · HNSW index · per-paper collections</li>
<li><b>Ollama (Local LLM Runtime)</b>: phi3:mini model · nomic-embed-text · CPU inference on mini PC</li>
<li><b>Docker Compose + nginx</b>: 3 containers: frontend · backend · nginx</li>
<li><b>Cloudflare Tunnel</b>: papermind.rafiarsya.com → localhost:3001 · http2 protocol</li></ul>
        </div>
        <br>
        <h3>05 Key Features</h3>
        <div class="blog-content-body">
<ul><li><b>Structured Auto-Summary</b>: One-click structured summary: main topic, objectives, methodology, key findings, conclusions, all extracted from the actual paper, not generated from prior knowledge.</li>
<li><b>100% Local: Zero Cloud Dependency</b>: phi3:mini runs on-device via Ollama. No OpenAI API key. No per-token cost. No data leaves the machine. Everything runs on a Linux mini PC 24/7.</li>
<li><b>Multi-Paper Library</b>: Upload and manage multiple PDFs simultaneously. Each paper gets its own isolated ChromaDB collection, no cross-paper contamination during retrieval.</li></ul>
        </div>
        <br>
        <h3>06 Processing Pipeline</h3>
        <div class="blog-content-body">
PDF File
Any academic PDF

→

Extract
Text Extraction
PyPDF2

→

Chunk
500-token Chunks
50-token overlap

→

Embed
nomic-embed-text
<mark class="hl">768-dim</mark> vectors

→

Store
ChromaDB
HNSW index

→

Retrieve
Top-5 by Cosine
Semantic search

→

Generate
phi3:mini
Grounded answer

<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>swipe to explore the full pipeline<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>
        </div>
        <br>
        <h3>07 Use Cases</h3>
        <div class="blog-content-body">
<ul><li><b>Research Students</b>: Upload a 40-page paper and get structured answers in seconds. Perfect for literature reviews and research comprehension.</li>
<li><b>Private Research</b>: Unpublished papers, confidential datasets, NDA-covered work, everything stays on your machine, never leaves.</li>
<li><b>Zero-Cost AI</b>: Local inference means unlimited queries, no API bills, no rate limits, no subscription. A one-time hardware investment.</li>
<li><b>Paper Comparison</b>: Upload multiple related papers, query each independently, and compare methodologies and findings side-by-side.</li></ul>
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
        <br><br>
    </div>
</div>
