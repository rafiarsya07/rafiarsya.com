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
                <span class="badge blog-badge badge-blue">React</span>
                <span class="badge blog-badge badge-purple">Vite</span>
                <span class="badge blog-badge badge-green">Node.js</span>
                <span class="badge blog-badge badge-orange">Express</span>
                <span class="badge blog-badge badge-neutral">Supabase</span>
                <span class="badge blog-badge badge-blue">Claude API</span>
            </div>
            <h1>AI Eval Dashboard</h1>
            <br>
            <span>A test harness for AI output. You write question and expected-answer pairs, pick a model, and hit Run. The dashboard then asks the model every question, has Claude grade each answer as correct, partial, incorrect or hallucinated, and reports accuracy, latency and cost per run.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">In Development</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Stack</span><span class="p-meta-v">React, Vite, Tailwind, Recharts</span></span></div>
            <a href="https://github.com/rafiarsya07/ai-eval-dashboard" target="_blank" rel="noopener" class="ext-link">View on GitHub<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Why Grading By Hand Breaks</h3>
        <div class="blog-content-body">
<p>Change a prompt and you want to know whether the model got better or worse. The usual answer is to eyeball twenty responses, decide they look fine, and ship. That does not survive contact with a second prompt change: you cannot remember what the old answers looked like, so every comparison is against a memory rather than a record.</p>
<p>The obvious automation, string equality against an expected answer, fails immediately. "Kuala Lumpur is the capital of Malaysia" and "The capital is KL" are the same answer and share almost no characters. Grading has to happen at the level of meaning, which is exactly the thing a language model can do and a string comparison cannot.</p>
<p>So the tool uses a second model call as the grader. That is the LLM-as-judge pattern, and it is the same core idea behind eval tooling like Langfuse and Braintrust.</p>
        </div>
        <br>
        <h3>02 The Judge</h3>
        <div class="blog-content-body">
<p>Every test case costs two API calls: one to get the answer being evaluated, one to grade it. The grader is deliberately given a rigid output format so the reply can be parsed rather than interpreted.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">The Grading Prompt</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Prompt</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">You are an objective grader evaluating an AI's answer
against an expected answer.

Question:           {question}
Expected answer:    {expected}
AI's actual answer: {actual}

Grade using ONE of these verdicts:
- "correct"      matches in meaning, even if worded differently
- "partial"      partially correct, missing key info or minor errors
- "incorrect"    wrong, or contradicts the expected answer
- "hallucinated" confident claims not supported by the expected
                 answer and not reasonably inferable

Respond in this exact format, nothing else:
VERDICT: &lt;one word&gt;
REASON: &lt;one short sentence&gt;</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The four verdicts exist because "wrong" is not one failure mode. An answer that is merely incomplete is a different problem from one that confidently invents a fact, and lumping them together hides the distinction that actually matters when you are deciding whether a model is safe to put in front of users. <code class="inline">hallucinated</code> is defined narrowly, as unsupported <em>and</em> not reasonably inferable, so a correct answer that adds harmless context does not get flagged.</p><p class="p-math-desc">The fixed <code class="inline">VERDICT:</code> / <code class="inline">REASON:</code> shape is parsed with two regexes and falls back to <code class="inline">unknown</code> rather than throwing, so one oddly formatted grader reply cannot take down a whole run. Grading itself runs on Haiku regardless of which model is being evaluated: comparing two short texts is a much easier job than answering the question was, and paying for a frontier model to do it would double the cost of every run for no gain.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">test case
  question: "What year did Malaysia gain independence?"
  expected: "Malaysia gained independence in 1957."

call 1 -> model under test
  actual:  "Malaysia became independent from Britain on
            31 August 1957, a date now celebrated as
            Hari Merdeka."
  latency: 1,180 ms   in 14 tok   out 31 tok

call 2 -> judge (haiku)
  VERDICT: correct
  REASON:  States 1957, matching the expected answer, with
           accurate supporting detail.

stored -> verdict "correct", latency 1180, cost $0.000094</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>03 What Gets Measured</h3>
        <div class="blog-content-body">
<p>The verdict is the headline, but a run records three things per test case, because accuracy alone is not a decision:</p>
<ul>
<li><b>Verdict</b> and the grader's one-line reason, so a bad score can be inspected rather than just trusted.</li>
<li><b>Latency</b>, measured around the answering call only. The grading call is a property of the harness, not of the model being judged, so folding it in would inflate every number.</li>
<li><b>Cost</b>, derived from the <code class="inline">usage</code> block the API returns with each response: input tokens and output tokens priced per model rather than estimated from character counts.</li>
</ul>
<p>A run aggregates those into accuracy percentage, a verdict breakdown, average latency and total spend, which is what makes two runs comparable. Results stream into the detail page as each case finishes rather than appearing all at once, because two sequential API calls per case means a twenty-case run takes a few minutes and a blank screen for that long reads as broken.</p>
        </div>
        <br>
        <h3>04 Data Model</h3>
        <div class="blog-content-body">
<p>Three tables in Postgres, on Supabase's free tier:</p>
<pre class="p-math-formula">test_cases     id, question, expected_answer, created_at

eval_runs      id, model, status, total_cases,
               correct_count, partial_count,
               incorrect_count, hallucinated_count,
               error_count, total_cost_usd,
               avg_latency_ms, created_at, completed_at

eval_results   id, eval_run_id -&gt; eval_runs,
               test_case_id -&gt; test_cases,
               actual_answer, verdict, grading_reason,
               latency_ms, input_tokens, output_tokens,
               cost_usd, error, created_at</pre>
<p>Test cases are separate from results on purpose: the same case can be replayed against a new model or a new prompt, and the point of the tool is comparing those runs against each other. <code class="inline">eval_results</code> cascades on delete from <code class="inline">eval_runs</code>, so discarding a bad run does not leave orphan rows, and two indexes, results by run id and runs by creation date, keep the two queries the dashboard actually makes off a sequential scan.</p>
<p><code class="inline">error</code> is a first-class verdict rather than a thrown exception. A test case whose API call fails is recorded with <code class="inline">verdict: 'error'</code> and the message, and the run continues; one rate-limit response does not discard the nineteen cases that already succeeded.</p>
        </div>
        <br>
        <h3>05 How It Is Built</h3>
        <div class="blog-content-body">
<ul>
<li><b>Frontend</b>: React with Vite and Tailwind, Recharts for the verdict breakdown. Three pages: test cases, run history, run detail.</li>
<li><b>Backend</b>: Node.js and Express, split into config, services, controllers and routes. All the interesting logic lives in <code class="inline">evalService.js</code>; the controllers only move data.</li>
<li><b>Database</b>: Supabase, reached from the backend with the service-role key. The anon key would not be enough, and putting a service-role key in the browser would hand every visitor write access to the tables. The backend exists partly to keep that key server-side.</li>
<li><b>Hosting</b>: Cloudflare Pages for the frontend, Render for the backend, both free tier. Render's free instances sleep when idle and take roughly thirty seconds to wake, which is a real cost for a demo link and an acceptable one for a portfolio project.</li>
</ul>
        </div>
        <br>
        <h3>06 Project Structure</h3>
        <div class="blog-content-body">
<div class="project-tree">ai-eval-dashboard/
├── supabase_schema.sql     <span class="pt-comment"># 3 tables + indexes + seed cases</span>
├── <span class="pt-dir">backend/</span>
│   └── src/
│       ├── config/         <span class="pt-comment"># Supabase + Anthropic clients, pricing</span>
│       ├── services/       <span class="pt-comment"># evalService.js: answer, grade, run</span>
│       ├── controllers/    <span class="pt-comment"># request handlers</span>
│       ├── routes/         <span class="pt-comment"># Express routes</span>
│       └── server.js
└── <span class="pt-dir">frontend/</span>
    └── src/
        ├── components/     <span class="pt-comment"># Layout, VerdictBadge</span>
        ├── pages/          <span class="pt-comment"># TestCases, RunsList, RunDetail</span>
        ├── lib/api.js      <span class="pt-comment"># fetch wrapper</span>
        └── App.jsx</div>
        </div>
        <br>
        <h3>07 Honest Limits</h3>
        <div class="blog-content-body">
<ul>
<li><b>The judge is a model, so the judge can be wrong.</b> Its verdicts are evidence, not ground truth, which is why every result stores the grader's reason next to it, so a suspicious score can be read rather than argued with.</li>
<li><b>Grading is only as good as the expected answer.</b> A vague expected answer produces vague verdicts, and the tool cannot tell you that your test case was the problem.</li>
<li><b>No side-by-side model comparison yet.</b> Two runs can be read next to each other, but there is no diff view, and no regression view for re-running the same cases after a prompt change. Both are the obvious next things to build.</li>
<li><b>Bulk import is half-finished.</b> The <code class="inline">/test-cases/bulk</code> endpoint accepts arrays already; the frontend has no CSV upload wired to it.</li>
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
