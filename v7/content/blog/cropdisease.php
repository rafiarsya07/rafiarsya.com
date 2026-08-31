<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">Machine Learning</span><span class="badge blog-badge badge-green">Agriculture</span><span class="badge blog-badge badge-purple">Python</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Crop Disease Detector</h1>
        <br>
        <span>Building an AI that identifies plant diseases from a single leaf photo, the problem, the process, and the lessons learned.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; ~22 min</span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>Why I Built This</h3>
        <div class="blog-content-body">
<p>It started with a simple question: how can a farmer with a smartphone tell if their crop has a disease before it spreads to the entire field?</p>
                            <p>Plant diseases are responsible for significant agricultural losses worldwide. Early detection is critical, but most farmers don't have access to agronomists or lab testing. A mobile-friendly AI that can identify diseases from a <mark class="hl">single photo</mark> could genuinely help.</p>
                            What if you could just take a photo of a leaf and instantly know what's wrong with your crop?
                            <p>That's the problem I set out to solve, building a deep learning model that classifies <mark class="hl">plant diseases</mark> from leaf images, deployed as a live web app anyone can access.</p>
        </div>
        <br>
        <h3>Input and Output</h3>
        <div class="blog-content-body">
<img class="blog-img" alt="What the app returns for the diseased sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-diseased.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> What the app returns for the diseased sample<img class="blog-img" alt="And for the healthy one" decoding="async" loading="lazy" src="image/assets/cropdisease/result-healthy.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> And for the healthy one<img class="blog-img" alt="Class distribution across the training set" decoding="async" loading="lazy" src="image/assets/cropdisease/dataset-blog.jpeg"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> Class distribution across the training set<img class="blog-img" alt="Training and validation curves" decoding="async" loading="lazy" src="image/assets/cropdisease/graphic-blog.jpeg"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> Training and validation curves<img class="blog-img" alt="How a photo becomes a prediction, end to end" decoding="async" loading="lazy" src="image/assets/cropdisease/infographic-blog.png"/><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a2 2 0 0 0-2.83 0L3 21"/></svg> How a photo becomes a prediction, end to end
        </div>
        <br>
    <br>
</div>
