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
                <span class="badge blog-badge badge-blue">Python</span>
                <span class="badge blog-badge badge-green">scikit-learn</span>
                <span class="badge blog-badge badge-purple">pandas</span>
                <span class="badge blog-badge badge-orange">TF-IDF</span>
                <span class="badge blog-badge badge-neutral">Learning Exercise</span>
            </div>
            <h1>LLM Response Preference Baseline</h1>
            <br>
            <span>An end-to-end Kaggle-style pipeline for the Chatbot Arena preference task: given a prompt and two chatbot responses, predict which one a human preferred. This is the baseline pass &mdash; TF-IDF features and logistic regression, run on a small synthetic stand-in dataset to get the whole loop working before touching the real thing.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Baseline, on placeholder data</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo</span></span><span class="p-meta-item"><span class="p-meta-k">Scope</span><span class="p-meta-v">Pipeline, not a competitive score</span></span></div>
            <a href="https://github.com/rafiarsya07/llm-classification" target="_blank" rel="noopener" class="ext-link">View on GitHub<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 What This Is, And What It Is Not</h3>
        <div class="blog-content-body">
<p>Worth stating up front, because the framing changes what the numbers mean: <b>this ran on synthetic placeholder data, not the real Chatbot Arena dataset.</b> The competition data is roughly 57,000 real conversations; the CSVs in this repository are 300 training rows and 80 test rows that I generated as a stand-in so the pipeline could be built and debugged without waiting on the full download.</p>
<p>The responses in that stand-in are drawn from six fixed templates with a random number appended:</p>
<pre class="p-math-formula">"I can help with that. Here's what you need to know. 282"
"I'll break this down step by step for better understanding. 229"
"Here's a clear and detailed explanation covering the key points."
"Sure, here's a concise answer to your question. 510"
"Based on available information, here is my response."
"This is a fascinating topic, let me explain."</pre>
<p>Which response "won" was assigned without reference to the text. So there is no signal in the features to learn from, by construction. What this project demonstrates is the pipeline &mdash; loading, EDA, feature engineering, a train/validation split, a fitted baseline, and a correctly formatted submission file. What it does not demonstrate is a model that predicts human preference, and the score below should be read accordingly.</p>
        </div>
        <br>
        <h3>02 The Task</h3>
        <div class="blog-content-body">
<p>Each row is one prompt shown to two models, with the two responses and a three-way outcome: model A preferred, model B preferred, or a tie. The target is a probability distribution over those three classes, scored by multi-class log loss &mdash; so the metric punishes confident wrong answers much harder than uncertain ones, and a well-calibrated model that says "I don't know" beats an overconfident one.</p>
<pre class="p-math-formula">columns   id, model_a, model_b, prompt, response_a, response_b,
          winner_model_a, winner_model_b, winner_tie

train     300 rows      A wins 124   B wins 122   tie 54
test       80 rows</pre>
        </div>
        <br>
        <h3>03 Features and Model</h3>
        <div class="blog-content-body">
<p>Prompt and response are concatenated per side, so each row produces two documents that carry the question's context alongside the answer being judged. Both are vectorised with the <em>same fitted</em> TF-IDF vocabulary and stacked horizontally, giving the classifier a symmetric view of A and B in one feature vector.</p>
<pre class="p-math-formula">text_a = prompt + " " + response_a
text_b = prompt + " " + response_b

vec = TfidfVectorizer(max_features=3000, ngram_range=(1,2))
X_a = vec.fit_transform(train.text_a)
X_b = vec.transform(train.text_b)        # transform, not fit_transform
X   = hstack([X_a, X_b])                 # shared vocabulary, both sides

label = 0 if A wins,  1 if B wins,  2 if tie

LogisticRegression(max_iter=1000)
train_test_split(test_size=0.2, stratify=y, random_state=42)</pre>
<p>Two details are deliberate. <code class="inline">transform</code> rather than <code class="inline">fit_transform</code> on side B keeps both sides in one shared vocabulary &mdash; fitting twice would put column <em>k</em> of A and column <em>k</em> of B on different words and make the halves incomparable. And the split is stratified, because ties are only 18% of the data and an unstratified 20% slice can easily under-represent them.</p>
        </div>
        <br>
        <h3>04 Reading the Result Honestly</h3>
        <div class="blog-content-body">
<p>Validation log loss came out at <b>1.2190</b>. The useful thing about that number is the comparison it invites:</p>
<pre class="p-math-formula">always predict uniform  (1/3, 1/3, 1/3)     log loss  1.0986
always predict the class priors             log loss  1.0397
TF-IDF + logistic regression                log loss  1.2190</pre>
<p>The model is <em>worse than guessing</em>. That is the correct outcome, and it is the most informative thing in the notebook: given features with no relationship to the label, logistic regression still finds patterns in the training split, becomes confident about them, and gets punished on validation for exactly that confidence. A model that had scored well here would have meant a leak in how I built the placeholder data, not a good model.</p>
<p>Which is the reason to run a baseline on scaffolding data first. The pipeline is verified &mdash; features line up, the split is honest, log loss is computed against the right labels, the submission has the right shape and columns that sum to one per row &mdash; and none of that verification was confounded by an interesting result.</p>
        </div>
        <br>
        <h3>05 What Comes Next</h3>
        <div class="blog-content-body">
<p>In order, on the real dataset:</p>
<ul>
<li><b>Run this same notebook unchanged on the real data first.</b> The baseline number on real data is the only reference point that makes every later improvement measurable.</li>
<li><b>Replace TF-IDF with sentence embeddings.</b> Bag-of-ngrams cannot see that two differently worded answers say the same thing, and semantic closeness to the prompt is likely to matter far more than vocabulary overlap.</li>
<li><b>Add structural features.</b> Response length, the length difference between A and B, and text similarity between the two responses &mdash; length alone is a known strong signal in preference data, and it costs nothing to compute.</li>
<li><b>Fine-tune a small transformer</b> such as DeBERTa for direct three-way classification, once there is a baseline worth beating.</li>
<li><b>Ensemble</b> only at the end, when there are several honest models to combine.</li>
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
