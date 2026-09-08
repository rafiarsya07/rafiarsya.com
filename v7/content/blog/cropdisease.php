<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">Machine Learning</span><span class="badge blog-badge badge-green">Agriculture</span><span class="badge blog-badge badge-purple">Python</span><span class="badge blog-badge badge-neutral">Transfer Learning</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Crop Disease Detector</h1>
        <br>
        <span>Building an AI that identifies plant diseases from a single leaf photo: the problem, the dataset, the two-phase training, the numbers it actually reaches, and the honest limits of what a model like this can claim.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; ~22 min</span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Why I Built This</h3>
        <div class="blog-content-body">
<p>It started with a simple question. How does a farmer with a smartphone and no agronomist nearby find out that a crop is sick, early enough to do something about it?</p>
<p>Plant disease is estimated to cost agriculture over 220 billion dollars a year worldwide, and a large share of that loss is preventable. The bottleneck is rarely the treatment. It is the diagnosis, and diagnosis is exactly where access is unequal: lab testing and extension officers are not evenly distributed, but cameras are. If a phone photo of a leaf could return a name for what is wrong, the diagnosis step stops being the expensive part.</p>
<p>So that is what I set out to build: a deep learning model that classifies <mark class="hl">plant disease</mark> from a leaf image, wrapped in a web app anybody can open for free, with no install and no account.</p>
        </div>
        <br>
        <h3>02 The Dataset, and What It Is Not</h3>
        <div class="blog-content-body">
<p>The model is trained on PlantVillage: roughly 87,000 labelled images of healthy and diseased leaves, covering 14 crop types and 38 conditions. It is the standard public dataset for this task, it is well labelled, and it is large enough to train on seriously.</p>
<p>It is also, and this matters, a laboratory dataset. The leaves are detached, laid on an even background, and photographed under controlled light. That is very different from a photo taken in a field at midday with a shadow across half the leaf and three other plants in frame. Any accuracy number from this dataset is an accuracy number on that kind of picture, and I would rather say so up front than let a headline percentage imply more than it should.</p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Class distribution across the training set" decoding="async" loading="lazy" src="image/assets/cropdisease/dataset-blog.jpeg"/><figcaption class="img-caption"><b>Dataset</b>: class distribution across the training set</figcaption></figure>
</div>
<p>The distribution is uneven, which is normal and which is the reason I care about macro-averaged metrics later rather than plain accuracy. A model can score well on overall accuracy purely by being good at the largest classes, and be useless on the rare disease that a farmer most needs named.</p>
        </div>
        <br>
        <h3>03 Why MobileNetV2</h3>
        <div class="blog-content-body">
<p>The backbone choice was made by the deployment target, not by the leaderboard. This had to run on free-tier hosting and return an answer in a couple of seconds, which rules out the heavy architectures that would score a fraction of a percent higher.</p>
<p>MobileNetV2 gets close to ResNet-class accuracy at a small fraction of the compute, and the reason is depthwise separable convolution. A standard convolution slides one filter across every input channel at once. MobileNetV2 splits that into two cheaper steps: a per-channel spatial filter, then a 1 by 1 convolution that mixes channels.</p>
<div class="p-code-label">the arithmetic that makes it cheap</div>
<pre class="p-code">Standard conv  = K x K x C_in x C_out
Depthwise sep  = K x K x C_in           (depthwise, spatial)
               + 1 x 1 x C_in x C_out   (pointwise, channel mixing)

3x3 conv, 32 channels in, 64 channels out:
  Standard:  3 x 3 x 32 x 64  = 18,432 parameters
  DepthSep:  3 x 3 x 32       =    288
           + 1 x 1 x 32 x 64  =  2,048
           =                     2,336  (about 8x fewer)</pre>
<p>Roughly eight to nine times fewer multiply-adds for the same output shape. That is the whole reason this runs acceptably on a CPU instance instead of needing a GPU it would never get.</p>
        </div>
        <br>
        <h3>04 Two-Phase Transfer Learning</h3>
        <div class="blog-content-body">
<p>Training from scratch on 87,000 images would take a long time and end up worse. Starting from ImageNet weights means the network already knows edges, textures and colour gradients, which is most of what distinguishes a lesion from a healthy surface. The job is to teach it the last part, not the whole thing.</p>
<p>That happens in two phases, and doing it in one phase is the mistake I made first.</p>
<div class="p-code-label">the schedule that worked</div>
<pre class="p-code">Phase 1, feature extraction
  freeze every MobileNetV2 layer
  train the new classification head only
  epochs = 10, learning rate = 1e-3

Phase 2, fine-tuning
  unfreeze the top 30 MobileNetV2 layers
  retrain with a much smaller step
  epochs = 20, learning rate = 1e-4

Augmentation throughout
  RandomFlip, RandomRotation(0.2),
  RandomZoom(0.1), RandomContrast(0.1)</pre>
<p>Phase 1 exists because the classification head starts with random weights. If you unfreeze everything on the first epoch, the enormous gradients coming out of that random head flow straight back into the pretrained layers and wreck the features you started from. This is catastrophic forgetting, and the symptom is a model that trains and then plateaus somewhere worse than it should. Freezing the base first lets the head become reasonable before it is allowed to influence anything else.</p>
<p>Phase 2 then nudges only the top thirty layers, at a learning rate ten times smaller. The upper layers hold the most task-specific features, so those are the ones worth adapting. The lower layers already detect edges perfectly well, and leaving them alone is both cheaper and safer.</p>
<p>The augmentation is not decoration. A real photo will be rotated, off centre, over exposed and at the wrong distance. Training on flips, rotations, zooms and contrast shifts is the cheapest available approximation of that, and it is the difference between a model that memorises the dataset and one that survives contact with a phone camera.</p>
        </div>
        <br>
        <h3>05 The Loss, and Why It Is Cross-Entropy</h3>
        <div class="blog-content-body">
<p>The model outputs a probability for each of the 38 classes, and the loss is categorical cross-entropy over those probabilities.</p>
<div class="p-code-label">what the loss rewards</div>
<pre class="p-code">Loss = -sum( y_i * log(p_i) )  over i in 1..38

Model was right and sure:
  true       = class 2, "Tomato Blight"
  predicted  = [0.01, 0.02, 0.93, 0.01, ...]
  loss       = -log(0.93) = 0.073

Model was right and unsure:
  predicted  = [0.10, 0.30, 0.40, 0.05, ...]
  loss       = -log(0.40) = 0.916</pre>
<p>Both of those predictions pick the correct class. Only one of them is a good answer. Cross-entropy penalises hedging, which is what you want here: a diagnosis at 40 percent confidence is not something a farmer should act on, and the training signal should say so.</p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Training and validation curves" decoding="async" loading="lazy" src="image/assets/cropdisease/graphic-blog.jpeg"/><figcaption class="img-caption"><b>Training</b>: accuracy and loss across both phases</figcaption></figure>
</div>
<p>The step in the middle of the curves is the moment phase 2 begins. Validation tracking training closely is the thing to look for: if the two separate, the model is memorising rather than learning, and the fix is more augmentation or fewer unfrozen layers.</p>
        </div>
        <br>
        <h3>06 The Numbers</h3>
        <div class="blog-content-body">
<div class="p-code-label">validation results</div>
<pre class="p-code">Accuracy    ~97.2%        Top-5 accuracy  ~99.8%
Precision   ~96.9%        Recall          ~97.1%
F1 score    ~97.0%        (all macro averaged)</pre>
<p>The number I actually care about is the macro-averaged F1 of about 97 percent. Macro averaging weights every class equally instead of by how many examples it has, so a model that is excellent at the common conditions and hopeless at the rare ones cannot hide behind a good overall accuracy. Getting the macro number close to the plain accuracy is the evidence that performance is spread across the classes rather than concentrated in the easy ones.</p>
<p>Top-5 accuracy of nearly 99.8 percent is useful for a different reason. Even when the model's first guess is wrong, the right answer is almost always in the short list, which means showing the top three predictions with their confidences is more honest and more useful than showing one confident label.</p>
        </div>
        <br>
        <h3>07 What the App Actually Does</h3>
        <div class="blog-content-body">
<p>The pipeline from photo to answer is short: the image is resized to 224 by 224 and normalised, the MobileNetV2 backbone extracts features, a dense head with a softmax turns those into 38 probabilities, and the app shows the top predictions with confidence.</p>
<p class="p-callout">Leaf photo, any size, any format, then resize and normalise to 224 by 224, then the MobileNetV2 backbone for feature extraction, then a dense plus softmax head for 38 classes, then the label and its confidence.</p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Input sample with visible disease symptoms" decoding="async" loading="lazy" src="image/assets/cropdisease/daun-2.jpg"/><figcaption class="img-caption"><b>Diseased leaf</b>: the kind of input a farmer would photograph</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Input sample from an unaffected plant" decoding="async" loading="lazy" src="image/assets/cropdisease/daun.jpg"/><figcaption class="img-caption"><b>Healthy leaf</b>: the control case</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification and confidence returned for the diseased sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-diseased.png"/><figcaption class="img-caption"><b>Prediction</b>: what the app returns for the diseased sample</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification returned for the healthy sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-healthy.png"/><figcaption class="img-caption"><b>Prediction</b>: and for the healthy one</figcaption></figure>
</div>
<p>The front end is Streamlit, which is not the choice I would make for a product but is exactly the right choice for getting a model in front of people in an afternoon. The whole thing is deployed on Hugging Face Spaces and is free to use.</p>
        </div>
        <br>
        <h3>08 What This Model Cannot Do</h3>
        <div class="blog-content-body">
<p>A 97 percent number invites more trust than it has earned, so here is the fine print I would want if I were the farmer.</p>
<ul>
<li><b>It only knows 38 things</b>: shown a disease outside the training set, it will not say "I do not know". It will confidently return the closest thing it does know. A confidence threshold and an explicit unknown bucket are the obvious next step.</li>
<li><b>Field photos are harder than lab photos</b>: PlantVillage leaves are detached and evenly lit. Real photos have shadows, other plants in frame, motion blur and mixed symptoms on one leaf. Accuracy in the field is lower than the validation number, and honest deployment means measuring that rather than assuming it.</li>
<li><b>It names, it does not treat</b>: the output is a classification. Which treatment is appropriate, at what dose, at what stage of infection, is agronomy, and the model has no opinion worth listening to.</li>
<li><b>Severity is invisible to it</b>: early and late stages of the same disease look different and need different responses, but they share one label here.</li>
</ul>
<p>If I extend this, the order is: confidence thresholding with a real "not sure" answer, then a second dataset of field-condition photos to fine-tune on, then severity as a separate output head.</p>
        </div>
        <br>
        <h3>09 What I Took Away</h3>
        <div class="blog-content-body">
<p>The technical lesson was that the architecture choice was the easy part, and that the two-phase schedule mattered more than the backbone. My first attempt unfroze everything at once, reached a worse plateau, and taught me what catastrophic forgetting looks like from the inside rather than in a lecture slide.</p>
<p>The other lesson was about framing. It is tempting to write "97 percent accurate" and stop. The more useful sentence is "97 percent macro-averaged F1 on laboratory photographs of 38 known conditions", because that one tells you both what the model can do and where it will fail, and only the second kind of claim is worth anything to somebody deciding whether to spray a field.</p>
        </div>
        <br>
        <div class="d-flex">
            <a href="https://huggingface.co/spaces/rafiarsya/crop-disease-detector" target="_blank" rel="noopener" class="btn btn-main button-border d-flex align-items-center">
                <span>Try it on Hugging Face<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
            </a>
        </div>
        <br><br>
</div>
