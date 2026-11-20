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

        <figure class="p-hero"><img alt="Crop Disease Detector result for a diseased leaf" decoding="async" src="image/assets/cropdisease/result-diseased.png"/></figure>

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
            <span>Upload a leaf photo and the model names the disease out of 38 classes. MobileNetV2 transfer learning, about 97% accuracy, free on Hugging Face Spaces.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed, Live</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Model</span><span class="p-meta-v">MobileNetV2</span></span><span class="p-meta-item"><span class="p-meta-k">Accuracy</span><span class="p-meta-v">~97%</span></span><span class="p-meta-item"><span class="p-meta-k">Classes</span><span class="p-meta-v">38 disease types</span></span><span class="p-meta-item"><span class="p-meta-k">Dataset</span><span class="p-meta-v">87K+ images</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">A farmer or gardener takes a photo of a sick leaf and gets a likely diagnosis in seconds, for free, from any browser.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Transfer learning</b>: MobileNetV2 pretrained on ImageNet, fine-tuned on plant leaf images</li>
<li><b>38 conditions</b>: healthy and diseased leaves across 14 crops, about 97% accuracy</li>
<li><b>Simple to use</b>: a Gradio interface: upload a photo, read the result</li>
<li><b>Free and public</b>: hosted on Hugging Face Spaces</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
<figure class="rf-figure"><img alt="Input sample with visible disease symptoms" class="blog-img" decoding="async" loading="lazy" src="image/assets/cropdisease/daun-2.jpg"/><figcaption class="img-caption"><b>Diseased leaf</b>: Input sample with visible disease symptoms</figcaption></figure>
<figure class="rf-figure"><img alt="Input sample from an unaffected plant" class="blog-img" decoding="async" loading="lazy" src="image/assets/cropdisease/daun.jpg"/><figcaption class="img-caption"><b>Healthy leaf</b>: Input sample from an unaffected plant</figcaption></figure>
<figure class="rf-figure rf-crop"><img alt="Classification returned for the healthy sample" class="blog-img" decoding="async" loading="lazy" src="image/assets/cropdisease/result-healthy.png"/><figcaption class="img-caption"><b>Prediction</b>: Classification returned for the healthy sample</figcaption></figure>
<figure class="rf-figure rf-crop"><img alt="Class distribution across the training set" class="blog-img" decoding="async" loading="lazy" src="image/assets/cropdisease/dataset-blog.jpeg"/><figcaption class="img-caption"><b>Dataset</b>: Class distribution across the training set</figcaption></figure>
<figure class="rf-figure rf-crop"><img alt="Training and validation curves" class="blog-img" decoding="async" loading="lazy" src="image/assets/cropdisease/graphic-blog.jpeg"/><figcaption class="img-caption"><b>Training</b>: Training and validation curves</figcaption></figure>
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
        <br>
        <div class="text-center text-silent text14">
            &#169; MUHAMMAD RAFI ARSYA
        </div>
        <br>
    </div>
</div>
