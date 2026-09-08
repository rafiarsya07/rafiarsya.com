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
                <span class="badge blog-badge badge-blue">TensorFlow</span>
                <span class="badge blog-badge badge-green">MobileNetV2</span>
                <span class="badge blog-badge badge-purple">Transfer Learning</span>
                <span class="badge blog-badge badge-orange">PlantVillage Dataset</span>
                <span class="badge blog-badge badge-neutral">Gradio</span>
                <span class="badge blog-badge badge-blue">Hugging Face</span>
            </div>
            <h1>Crop Disease Detector</h1>
            <br>
            <span>An AI model that identifies plant diseases from a single leaf photo. MobileNetV2 + Transfer Learning trained on 87,000+ images across 38 disease classes. ~97% accuracy. Live on Hugging Face Spaces, free to use.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed, Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Model</span><span class="p-meta-v">MobileNetV2</span></span><span class="p-meta-item"><span class="p-meta-k">Accuracy</span><span class="p-meta-v">~97%</span></span><span class="p-meta-item"><span class="p-meta-k">Classes</span><span class="p-meta-v">38 disease types</span></span><span class="p-meta-item"><span class="p-meta-k">Dataset</span><span class="p-meta-v">87K+ images</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p class="p-text">Crop Disease Detector reads a leaf photo and tells you what's wrong with the plant. Upload a photo and the model names which of <strong>38 disease conditions</strong> it's likely showing, in seconds, for free.</p>
<p class="p-text">MobileNetV2 was chosen for efficiency, near-ResNet accuracy at a fraction of the compute, which is what makes free-tier deployment viable. The model is trained on the PlantVillage dataset: 87,000+ high-quality images of healthy and diseased leaves across 14 crop types.</p>

<strong>The motivation:</strong> Crop disease is estimated to cost agriculture over $220 billion a year globally. Most of that loss is preventable with early detection, but access to diagnosis tools is extremely unequal. This was my attempt at making one more accessible.
        </div>
        <br>
        <h3>02 In Practice</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">What the model actually sees, and what it returns. The two leaf samples below are the kind of input a farmer would photograph; the result screens are the app's output for each.</p><figure class="rf-figure"><img class="blog-img" alt="Input sample with visible disease symptoms" decoding="async" loading="lazy" src="image/assets/cropdisease/daun-2.jpg"/><figcaption class="img-caption"><b>Diseased leaf</b>: Input sample with visible disease symptoms</figcaption></figure><figure class="rf-figure"><img class="blog-img" alt="Input sample from an unaffected plant" decoding="async" loading="lazy" src="image/assets/cropdisease/daun.jpg"/><figcaption class="img-caption"><b>Healthy leaf</b>: Input sample from an unaffected plant</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification and confidence returned for the diseased sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-diseased.png"/><figcaption class="img-caption"><b>Prediction</b>: Classification and confidence returned for the diseased sample</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification returned for the healthy sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-healthy.png"/><figcaption class="img-caption"><b>Prediction</b>: Classification returned for the healthy sample</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Class distribution across the training set" decoding="async" loading="lazy" src="image/assets/cropdisease/dataset-blog.jpeg"/><figcaption class="img-caption"><b>Dataset</b>: Class distribution across the training set</figcaption></figure><figure class="rf-figure rf-crop"><img class="blog-img" alt="Training and validation curves" decoding="async" loading="lazy" src="image/assets/cropdisease/graphic-blog.jpeg"/><figcaption class="img-caption"><b>Training</b>: Training and validation curves</figcaption></figure>
        </div>
        <br>
        <h3>03 Model Architecture &amp; Training Math</h3>
        <div class="blog-content-body">
<p><strong><mark class="hl">MobileNetV2</mark></strong> uses depthwise separable convolutions to drastically reduce parameter count while preserving feature extraction power. Transfer Learning from ImageNet weights means we start with powerful low-level feature detectors (edges, textures) already learned.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Depthwise Separable Convolution vs Standard</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">Standard Conv     = K × K × C_in × C_out
Depthwise Sep     = K × K × C_in          ← depthwise
                  + 1 × 1 × C_in × C_out  ← pointwise</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">Rather than one filter across all channels, MobileNetV2 splits the work: a per-channel spatial filter (depthwise), then a 1×1 channel mixer (pointwise). That's <strong>~8: 9× fewer multiply-adds</strong> for the same output shape, why it runs fast on a phone CPU.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">3×3 conv, 32 channels in → 64 channels out:

  Standard:  3 × 3 × 32 × 64  = 18,432 params
  DepthSep:  3 × 3 × 32       =    288  (depthwise)
           + 1 × 1 × 32 × 64  =  2,048  (pointwise)
           =                     2,336  total  (≈8× fewer)</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Transfer Learning Fine-Tuning Strategy</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">Phase 1, Feature Extraction
  Freeze all MobileNetV2 layers
  Train only top head  |  epochs=10, LR=1e-3

Phase 2, Fine-Tuning  
  Unfreeze top 30 MobileNetV2 layers
  Retrain with low LR  |  epochs=20, LR=1e-4

Augmentation: RandomFlip · RandomRotation(0.2)
              RandomZoom(0.1) · RandomContrast(0.1)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Two-phase training is a standard trick with pretrained models. <strong>Phase 1</strong> warms up the new classification head without touching the ImageNet weights (so you don't immediately destroy what was learned). <strong>Phase 2</strong> uses a tiny learning rate to gently nudge the upper layers toward leaf disease patterns, aggressive updates here would cause "catastrophic forgetting."</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># TensorFlow / Keras pseudocode

# Phase 1
base_model.trainable = False
model.compile(optimizer=Adam(1e-3)...)
model.fit(train_ds, epochs=10)

# Phase 2  
for layer in base_model.layers[-30:]:
    layer.trainable = True
model.compile(optimizer=Adam(1e-4)...)
model.fit(train_ds, epochs=20)</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">03</span><span class="p-math-title">Loss Function &amp; Final Metrics</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">Loss = Categorical Cross-Entropy
     = −Σ y_i × log(ŷ_i)  for i in 1..38 classes

Validation Results
  Accuracy   ~97.2%     Top-5 Acc  ~99.8%
  Precision  ~96.9%     Recall     ~97.1%
  F1-Score   ~97.0%     (all macro avg)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-text">Cross-entropy penalises confidence in the wrong class: 80% confidence on Healthy when the label is Tomato Blight scores a high loss. That pushes the network toward being right <em>and</em> confident. The <strong>macro-average F1 of 97%</strong> means consistent performance across rare and common classes, not just the easy majority.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Concrete example for one prediction:
true_label   = [0, 0, 1, 0...]  # class 2 = "Tomato Blight"
predicted    = [0.01, 0.02, 0.93, 0.01...]

loss = −log(0.93) = 0.073   ← low, model was right

# If model was uncertain:
predicted    = [0.10, 0.30, 0.40, 0.05...]
loss = −log(0.40) = 0.916   ← higher penalty</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 Processing Pipeline</h3>
        <div class="blog-content-body">
Leaf Photo
Any format

→

Preprocess
Resize + Normalize
224×224 px

→

Backbone
MobileNetV2
Feature extraction

→

Head
Dense + Softmax
38-class output

→

Output
Disease Class
+ confidence %

<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>swipe to explore the full pipeline<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>
        </div>
        <br>
        <h3>05 Disease Classes (38 Total)</h3>
        <div class="blog-content-body">
<p>The model covers <strong>14 crop types</strong> and <strong>38 disease conditions</strong> including healthy states. A sample of the classes:</p>

Apple, Apple Scab
Apple, Black Rot
Apple, Cedar Rust
Corn, Gray Leaf Spot
Corn, Common Rust
Grape, Black Rot
Potato, Early Blight
Potato, Late Blight
Tomato, Leaf Mold
Tomato, Mosaic Virus
Tomato, Blight
Strawberry, Leaf Scorch

<p style="font-size:12.5px;color:var(--muted);">+ 26 more classes across rice, wheat, pepper, peach, cherry, orange, and soybean. All classes include a "Healthy" baseline.</p>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Python 3</span>
<span class="badge blog-badge badge-neutral">TensorFlow</span>
<span class="badge blog-badge badge-neutral">Keras</span>
<span class="badge blog-badge badge-neutral">MobileNetV2</span>
<span class="badge blog-badge badge-neutral">Gradio</span>
<span class="badge blog-badge badge-neutral">NumPy</span>
<span class="badge blog-badge badge-neutral">Pillow</span>
<span class="badge blog-badge badge-neutral">HF Spaces</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://huggingface.co/spaces/rafiarsya/crop-disease-detector" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
<span class="p-link-btn-label">Try on Hugging Face</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07?tab=repositories" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
<span class="p-link-btn-label">GitHub</span>
</a>
<a class="p-link-btn" href="https://blog.rafiarsya.com/" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path></svg>
<span class="p-link-btn-label">Read Blog Post</span>
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
