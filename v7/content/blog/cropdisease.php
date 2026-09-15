<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">Machine Learning</span><span class="badge blog-badge badge-green">Agriculture</span><span class="badge blog-badge badge-purple">Python</span><span class="badge blog-badge badge-neutral">Transfer Learning</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>Crop Disease Detector</h1>
        <br>
        <span>An AI that names a plant disease from one leaf photo. The dataset, the two-phase training, the numbers it reaches, and the limits it does not get to hide.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; ~18 min</span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Why I Built This</h3>
        <div class="blog-content-body">
<p>It started with one question. How does a farmer with a smartphone and no agronomist nearby find out a crop is sick, early enough to do something about it?</p>
<p>The FAO puts the cost of plant diseases at over 220 billion dollars a year. Invasive insects add at least 70 billion more. Up to 40 percent of global crop production is lost to pests annually.</p>
<p>Most of that loss is preventable. The bottleneck is rarely the treatment, it is the diagnosis. And diagnosis is where access is unequal. Lab tests and extension officers are not evenly spread, but cameras are. <mark class="hl">If a phone photo could name what is wrong, the expensive step stops being expensive.</mark></p>
<p>So that is what I built. A model that classifies <span class="markgreen">plant disease</span> from a leaf image, wrapped in a web app anyone can open. No install, no account, free.</p>
<p>First question though. Does this need machine learning at all? Plenty of things called AI are a lookup table in a costume. This is not one of them, and the joke below is the shortest way to explain why.</p>
<figure class="rf-figure"><img class="blog-img" alt="Tweet joking that an AI is built from a long chain of if and else if statements" decoding="async" loading="lazy" src="image/assets/cropdisease/meme-if-else-ai.jpg"/><figcaption class="img-caption"><b>The joke</b>, posted by <a href="https://twitter.com/VishalMalvi_" target="_blank" rel="noopener">@VishalMalvi_</a>. Funny because it is what everyone assumes. Useful here because it is the approach that fails.</figcaption></figure>
<p>Try writing that if statement. A leaf has late blight when it has a brown patch? So does drought stress. So does sunscald. So does a bruise from handling.</p>
<p>Fine, a brown patch with a yellow halo. Now photograph the same lesion at dusk, slightly out of focus, and the halo reads as pale green because the white balance drifted.</p>
<p>Every threshold you pick is a threshold on pixel values. <span class="markblue">Pixel values move with the light, the camera, the angle and the age of the leaf.</span></p>
<p>That is the real difference. A rule based program needs you to know the separating numbers in advance. A network works them out from labelled examples, including the ones nobody would think to write down.</p>
        </div>
        <br>
        <h3>02 The Dataset, and What It Is Not</h3>
        <div class="blog-content-body">
<p>The model is trained on PlantVillage, the standard public dataset for this task. The 2015 release from Hughes and Salath&eacute; holds <span class="markblue">54,306 labelled leaf photos, 14 crop species, 26 diseases, 38 classes</span> once you count healthy leaves separately.</p>
<p>The copy most people actually download is a Kaggle mirror. It augments the same photos up to roughly 87,000 training images across those same 38 classes. Same source material, more copies of it.</p>
<p>Size is not the interesting part though. <mark class="hl">This is a laboratory dataset.</mark> Every leaf is detached, laid flat on an even background, and shot under controlled light.</p>
<p>That is nothing like a photo taken in a field at midday, with a shadow across half the leaf and three other plants in frame. Any accuracy number from this data is an accuracy number on <i>that kind of picture</i>, and saying so up front is cheaper than letting a percentage imply more than it should.</p>
<p>This caveat is not mine, either. Mohanty, Hughes and Salath&eacute; trained to 99.35 percent on a held out split in 2016, then said plainly that accuracy drops a long way on images shot under different conditions. <span class="marksalmon">A held out split from the same photo shoot tests whether the model learned the shoot.</span></p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Class distribution across the training set" decoding="async" loading="lazy" src="image/assets/cropdisease/dataset-blog.jpeg"/><figcaption class="img-caption"><b>Dataset</b>: class distribution across the training set</figcaption></figure>
</div>
<p>The distribution is uneven. That is normal, and it is why I care about macro-averaged metrics later instead of plain accuracy.</p>
<p>Here is the problem in one line. Say one class holds 15 percent of the images and another holds under 1 percent. A model that ignores the small class completely still loses less than a point of overall accuracy. A rounding error in the headline, a total failure for whoever grows that crop.</p>
<p>The split is stratified for the same reason, so every class keeps its proportion on both sides. Shuffle without stratifying and a rare class can end up with a handful of validation images. Its recall then swings wildly between runs, and the macro average stops meaning anything.</p>
        </div>
        <br>
        <h3>03 Why MobileNetV2</h3>
        <div class="blog-content-body">
<p>The backbone was chosen by the deployment target, not the leaderboard. This had to run on free hosting, on a CPU, and answer in a couple of seconds.</p>
<p>That rules out most of the architectures that would score a fraction of a percent higher. <mark class="hl">Their cost is paid on every request, forever, by a machine with no GPU.</mark></p>
<p>MobileNetV2 came out of Google in 2018. The paper reports <span class="markgreen">72.0 percent top-1 on ImageNet, 3.4 million parameters, 300 million multiply-adds</span> at 224 by 224, and 75 milliseconds per image on a 2017 phone CPU. Those numbers made the decision for me.</p>
<p>Most of that saving comes from one idea: <span class="markblue">depthwise separable convolution</span>. A normal convolution slides a filter that spans every input channel at once, so its cost multiplies kernel area by input channels by output channels. The depthwise separable version splits that into two cheap steps. First a spatial filter on each channel alone, then a 1 by 1 convolution that only mixes channels.</p>
<figure class="rf-diagram">
<svg viewBox="0 0 600 300" role="img" aria-label="Diagram comparing the parameter count of a standard convolution with a depthwise separable convolution">
  <text x="24" y="32" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.2" fill="#9ca3af">STANDARD CONVOLUTION</text>
  <rect x="24" y="48" width="62" height="58" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="55" y="82" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">in 32</text>
  <line x1="92" y1="77" x2="112" y2="77" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M112 72 L120 77 L112 82 Z" fill="#c9ccd1"/>
  <rect x="126" y="48" width="196" height="58" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="224" y="72" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="13" fill="#2f6fb3">3 x 3 x 32 x 64</text>
  <text x="224" y="92" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#8aa4bf">one filter spans every channel</text>
  <line x1="328" y1="77" x2="348" y2="77" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M348 72 L356 77 L348 82 Z" fill="#c9ccd1"/>
  <rect x="362" y="48" width="62" height="58" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="393" y="82" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">out 64</text>
  <text x="444" y="72" font-family="system-ui, sans-serif" font-size="17" font-weight="700" fill="#404040">18,432</text>
  <text x="444" y="90" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">weights</text>

  <line x1="24" y1="132" x2="576" y2="132" stroke="#f1f3f6" stroke-width="1"/>

  <text x="24" y="164" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.2" fill="#9ca3af">DEPTHWISE SEPARABLE</text>
  <rect x="24" y="180" width="62" height="58" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="55" y="214" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">in 32</text>
  <line x1="92" y1="209" x2="112" y2="209" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M112 204 L120 209 L112 214 Z" fill="#c9ccd1"/>
  <rect x="126" y="180" width="92" height="58" rx="8" fill="#eef7ef" stroke="#cfe8d3" stroke-width="1"/>
  <text x="172" y="205" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f7a45">3 x 3 x 32</text>
  <text x="172" y="224" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#7ea98c">per channel</text>
  <line x1="224" y1="209" x2="240" y2="209" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M240 204 L248 209 L240 214 Z" fill="#c9ccd1"/>
  <rect x="254" y="180" width="120" height="58" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="314" y="205" text-anchor="middle" font-family="Consolas, Menlo, monospace" font-size="12" fill="#2f6fb3">1 x 1 x 32 x 64</text>
  <text x="314" y="224" text-anchor="middle" font-family="system-ui, sans-serif" font-size="11" fill="#8aa4bf">mixes channels</text>
  <line x1="380" y1="209" x2="396" y2="209" stroke="#c9ccd1" stroke-width="1.5"/>
  <path d="M396 204 L404 209 L396 214 Z" fill="#c9ccd1"/>
  <rect x="410" y="180" width="62" height="58" rx="8" fill="#f7f8fa" stroke="#e5e7eb" stroke-width="1"/>
  <text x="441" y="214" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#404040">out 64</text>
  <text x="490" y="198" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">288 + 2,048</text>
  <text x="490" y="220" font-family="system-ui, sans-serif" font-size="17" font-weight="700" fill="#2f7a45">2,336</text>
  <text x="490" y="236" font-family="system-ui, sans-serif" font-size="11" fill="#9ca3af">weights</text>
  <text x="24" y="272" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">Same input shape, same output shape, about eight times fewer weights and multiply-adds.</text>
</svg>
<figcaption class="img-caption"><b>Depthwise separable convolution</b>: one expensive operation replaced by two cheap ones</figcaption>
</figure>
<div class="p-code-label">the arithmetic that makes it cheap</div>
<pre class="p-code">Standard conv  = K x K x C_in x C_out
Depthwise sep  = K x K x C_in           (depthwise, spatial)
               + 1 x 1 x C_in x C_out   (pointwise, channel mixing)

3x3 conv, 32 channels in, 64 channels out:
  Standard:  3 x 3 x 32 x 64  = 18,432 parameters
  DepthSep:  3 x 3 x 32       =    288
           + 1 x 1 x 32 x 64  =  2,048
           =                     2,336  (about 8x fewer)</pre>
<p>For a 3 by 3 kernel that lands around eight to nine times cheaper. It holds at every layer, so the saving compounds through the whole network instead of showing up once.</p>
<p>V2 adds two more ideas. Inverted residuals move the skip connection to the narrow ends of a block, so the tensor held in memory is the small one. Linear bottlenecks drop the activation on each block's final projection, because ReLU on a low dimensional tensor throws away information you cannot get back. Neither changes how you use the model. Both are why V2 keeps its accuracy at that size.</p>
        </div>
        <br>
        <h3>04 Two-Phase Transfer Learning</h3>
        <div class="blog-content-body">
<p>Training from scratch on tens of thousands of images would take a long time and end up worse. ImageNet weights already know edges, textures and colour gradients, which is most of what separates a lesion from healthy tissue. <mark class="hl">The job is to teach the last part, not the whole thing.</mark></p>
<p>That happens in two phases. Doing it in one phase is the mistake I made first.</p>
<figure class="rf-diagram">
<svg viewBox="0 0 600 300" role="img" aria-label="Diagram of the two phase training schedule showing which layers are frozen in each phase">
  <text x="24" y="30" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">PHASE 1 &#183; FEATURE EXTRACTION &#183; 10 EPOCHS, LR 1e-3</text>
  <rect x="24" y="44" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="68" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 1</text>
  <rect x="120" y="44" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="164" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 2</text>
  <rect x="216" y="44" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="260" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 3</text>
  <rect x="312" y="44" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="356" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 4</text>
  <rect x="408" y="44" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="452" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">top 30</text>
  <rect x="504" y="44" width="72" height="48" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="540" y="73" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#2f6fb3">head</text>
  <text x="24" y="114" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">The head starts from random weights, so nothing behind it is allowed to move yet.</text>

  <line x1="24" y1="136" x2="576" y2="136" stroke="#f1f3f6" stroke-width="1"/>

  <text x="24" y="168" font-family="system-ui, sans-serif" font-size="11" letter-spacing="1.1" fill="#9ca3af">PHASE 2 &#183; FINE-TUNING &#183; 20 EPOCHS, LR 1e-4</text>
  <rect x="24" y="182" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="68" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 1</text>
  <rect x="120" y="182" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="164" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 2</text>
  <rect x="216" y="182" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="260" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 3</text>
  <rect x="312" y="182" width="88" height="48" rx="8" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="356" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#9ca3af">base 4</text>
  <rect x="408" y="182" width="88" height="48" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="452" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#2f6fb3">top 30</text>
  <rect x="504" y="182" width="72" height="48" rx="8" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="540" y="211" text-anchor="middle" font-family="system-ui, sans-serif" font-size="12" fill="#2f6fb3">head</text>
  <text x="24" y="252" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">Only the most task-specific layers move, and they move ten times slower.</text>

  <rect x="24" y="270" width="12" height="12" rx="3" fill="#f1f3f6" stroke="#e5e7eb" stroke-width="1"/>
  <text x="44" y="280" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">frozen</text>
  <rect x="104" y="270" width="12" height="12" rx="3" fill="#eef5fd" stroke="#cfe2f7" stroke-width="1"/>
  <text x="124" y="280" font-family="system-ui, sans-serif" font-size="12" fill="#6b7280">training</text>
</svg>
<figcaption class="img-caption"><b>The schedule</b>: what is allowed to change, and when</figcaption>
</figure>
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
<p>Phase 1 exists because the head starts random. Unfreeze everything on epoch one and the large gradients coming out of that random head flow straight back into the pretrained layers and damage them.</p>
<p>What you see is a model that trains fine and then settles somewhere worse than it should. <span class="marksalmon">The useful representation got overwritten before the head had anything sensible to say.</span> Freezing the base first lets the head catch up. The official TensorFlow guide prescribes the same order, for the same reason.</p>
<p>Phase 2 then moves only the top thirty layers, ten times slower. A convolutional network is a hierarchy. Early layers see edges and colour transitions, which look the same on a leaf as on a cat. Later layers see compound shapes and textures, which do not. <mark class="hl">The task lives in the top layers, so that is the part worth adapting.</mark></p>
<p>The learning rate drop matters as much as the unfreezing. 1e-3 is a step size for weights that started random. On weights that are already close to right, steps that big overshoot and undo the pretraining. 1e-4 moves them without wrecking them.</p>
<p>One detail people miss here. Batch normalisation layers do not behave like the rest when you unfreeze them. In Keras, making a model trainable also flips its BatchNorm layers back into training mode. They then update their running statistics from your much smaller dataset, which can undo the calibration inherited from ImageNet. Keep BatchNorm in inference mode while fine-tuning, and check rather than assume.</p>
<p>The augmentation is not decoration either. Real photos are rotated, off centre, over exposed and at the wrong distance. Flips, rotations, zooms and contrast shifts are the cheapest way to rehearse that. They also act as regularisation, because the model never sees the same image twice, so memorising individual photos stops paying.</p>
        </div>
        <br>
        <h3>05 The Loss, and Why It Is Cross-Entropy</h3>
        <div class="blog-content-body">
<p>The last layer produces 38 raw scores, one per class. A softmax turns them into a probability distribution: every value between 0 and 1, all 38 summing to 1.</p>
<p>That is the shape the loss wants, and also the shape the interface wants. <span class="markblue">A confidence bar means nothing unless the numbers behind it are comparable.</span></p>
<p>The loss is categorical cross-entropy. It looks at the probability given to the correct class, and only that one, then charges the negative logarithm of it.</p>
<div class="p-code-label">what the loss rewards</div>
<pre class="p-code">Loss = -sum( y_i * log(p_i) )  over i in 1..38

Model was right and sure:
  true       = class 2, "Tomato Blight"
  predicted  = [0.01, 0.02, 0.93, 0.01, ...]
  loss       = -log(0.93) = 0.073

Model was right and unsure:
  predicted  = [0.10, 0.30, 0.40, 0.05, ...]
  loss       = -log(0.40) = 0.916</pre>
<p>Both of those pick the right class. Only one of them is a good answer. <mark class="hl">Cross-entropy punishes hedging</mark>, which is what you want here. A diagnosis at 40 percent is not something a farmer should act on, and the training signal should say so.</p>
<p>The logarithm is where the loss gets its teeth. Giving the true class 1 percent costs about 4.6. Giving it 0.01 percent costs about 9.2. Confident mistakes hurt far more than uncertain ones, which is the right incentive for a model whose output reads as advice.</p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Training and validation curves" decoding="async" loading="lazy" src="image/assets/cropdisease/graphic-blog.jpeg"/><figcaption class="img-caption"><b>Training</b>: accuracy and loss across both phases</figcaption></figure>
</div>
<p>The step in the middle of the curves is phase 2 starting. What to look for is validation tracking training closely. If they separate, with training loss still falling while validation loss turns back up, the model is memorising. The fix is more augmentation or fewer unfrozen layers. A small gap is normal. A widening one is the signal to stop.</p>
        </div>
        <br>
        <h3>06 The Numbers</h3>
        <div class="blog-content-body">
<div class="p-code-label">validation results</div>
<pre class="p-code">Accuracy    ~97.2%        Top-5 accuracy  ~99.8%
Precision   ~96.9%        Recall          ~97.1%
F1 score    ~97.0%        (all macro averaged)</pre>
<p>The number I actually care about is the <span class="markgreen">macro-averaged F1 of about 97 percent</span>.</p>
<p>Macro averaging scores each class on its own, then takes a plain mean. A class with 300 images counts as much as one with 3,000. Plain accuracy pools everything together, so the big classes drown out the rest. A model that is great at common conditions and hopeless at rare ones looks fine on one measure and bad on the other, and <mark class="hl">the rare ones are the whole point</mark>.</p>
<p>Macro sitting close to plain accuracy is the evidence that performance is spread out. If accuracy were 97 and macro F1 were 80, the honest reading would be that a few classes carry the model while others are close to broken.</p>
<p>Precision and recall answer different questions, and they fail in different directions here. Precision asks how many of the leaves called blight really were blight. Recall asks how many of the real blight cases got caught.</p>
<p>A miss means a disease goes untreated. A false alarm means somebody sprays a healthy field, which costs money and damages soil. F1 is the harmonic mean of the two, which stops a model buying a good score in one by wrecking the other.</p>
<p>Top-5 accuracy near 99.8 percent is useful for a different reason. Even when the first guess is wrong, the right answer is almost always in the short list. So the app shows the <span class="markblue">top three predictions with confidences</span> rather than one confident label. The interface is built on that number, not the headline one.</p>
        </div>
        <br>
        <h3>07 What the App Actually Does</h3>
        <div class="blog-content-body">
<p>The path from photo to answer is short. Decode the upload, resize to 224 by 224 to match what the backbone was trained on, normalise it. MobileNetV2 turns that into a feature vector. A dense head with a softmax turns the vector into 38 probabilities. The app sorts them and shows the top few.</p>
<p class="p-callout">Leaf photo, any size, any format, then resize and normalise to 224 by 224, then the MobileNetV2 backbone for feature extraction, then a dense plus softmax head for 38 classes, then the label and its confidence.</p>
<p>The resize is where accuracy quietly leaks in the field. Scale a photo of a whole plant down to 224 pixels square and each lesion is a few pixels across. <mark class="hl">A few pixels is not enough for any model.</mark></p>
<p>What the model wants is one leaf filling most of the frame, the same framing the training photos used. Telling people that works better than any amount of extra training.</p>
<div class="blog-content-body">
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Input sample with visible disease symptoms" decoding="async" loading="lazy" src="image/assets/cropdisease/daun-2.jpg"/><figcaption class="img-caption"><b>Diseased leaf</b>: the kind of input a farmer would photograph</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Input sample from an unaffected plant" decoding="async" loading="lazy" src="image/assets/cropdisease/daun.jpg"/><figcaption class="img-caption"><b>Healthy leaf</b>: the control case</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification and confidence returned for the diseased sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-diseased.png"/><figcaption class="img-caption"><b>Prediction</b>: what the app returns for the diseased sample</figcaption></figure>
<figure class="rf-figure rf-crop"><img class="blog-img" alt="Classification returned for the healthy sample" decoding="async" loading="lazy" src="image/assets/cropdisease/result-healthy.png"/><figcaption class="img-caption"><b>Prediction</b>: and for the healthy one</figcaption></figure>
</div>
<p>The front end is Streamlit. Not what I would pick for a product, exactly right for getting a model in front of people in an afternoon. It runs on Hugging Face Spaces and is free to use.</p>
        </div>
        <br>
        <h3>08 What This Model Cannot Do</h3>
        <div class="blog-content-body">
<p>A 97 percent number invites more trust than it has earned. Here is the fine print I would want if I were the farmer.</p>
<ul>
<li><b>It only knows 38 things</b>: this is a closed set classifier, and the softmax always sums to one across the classes it knows. Show it a disease outside the training set, a pest, a nutrient deficiency or a photo of a hand, and it cannot say "I do not know". It returns the closest thing it does know, confidently. A threshold and an explicit unknown bucket are the obvious next step.</li>
<li><b>Confidence is not probability</b>: modern networks are poorly calibrated and usually overconfident. A reported 95 percent does not mean right 95 times out of 100. Calibrate against a held out set, or present the numbers as a ranking rather than as odds.</li>
<li><b>Field photos are harder than lab photos</b>: shadows, other plants in frame, motion blur, mixed symptoms on one leaf. Field accuracy is lower than the validation number. Honest deployment means measuring that, not assuming it.</li>
<li><b>It names, it does not treat</b>: the output is a classification. Which treatment, what dose, at what stage, is agronomy. The model has no opinion worth listening to.</li>
<li><b>Severity is invisible to it</b>: early and late stages of the same disease look different and need different responses. Here they share one label.</li>
</ul>
<p>If I extend this, the order is: confidence thresholding with a real "not sure" answer, then a field-condition dataset to fine-tune on, then severity as a separate output head.</p>
        </div>
        <br>
        <h3>09 What I Took Away</h3>
        <div class="blog-content-body">
<p>The architecture choice was the easy part. The two-phase schedule mattered more than the backbone. My first attempt unfroze everything at once and settled at a worse plateau, which taught me what damaging a pretrained representation looks like from the inside instead of on a slide.</p>
<p>Second lesson: <mark class="hl">the dataset decides the ceiling.</mark> No amount of architecture search fixes the fact that every training photo was taken on a table. The highest value work left here is not a better model. It is a few thousand photos taken in a real field, in real light.</p>
<p>Third was about framing. It is tempting to write "97 percent accurate" and stop. The useful sentence is "97 percent macro-averaged F1 on laboratory photographs of 38 known conditions". That one says what the model can do <i>and</i> where it breaks, and only the second kind of claim is worth anything to somebody deciding whether to spray a field.</p>
        </div>
        <br>
        <h3>10 References</h3>
        <div class="blog-content-body">
<ol class="blog-refs">
<li>Hughes, D. P. and Salath&eacute;, M. (2015). <i>An open access repository of images on plant health to enable the development of mobile disease diagnostics.</i> arXiv:1511.08060. <a href="https://arxiv.org/abs/1511.08060" target="_blank" rel="noopener">arxiv.org/abs/1511.08060</a></li>
<li>Mohanty, S. P., Hughes, D. P. and Salath&eacute;, M. (2016). <i>Using Deep Learning for Image-Based Plant Disease Detection.</i> Frontiers in Plant Science 7:1419. <a href="https://doi.org/10.3389/fpls.2016.01419" target="_blank" rel="noopener">doi.org/10.3389/fpls.2016.01419</a></li>
<li>Sandler, M., Howard, A., Zhu, M., Zhmoginov, A. and Chen, L. C. (2018). <i>MobileNetV2: Inverted Residuals and Linear Bottlenecks.</i> CVPR 2018, arXiv:1801.04381. <a href="https://arxiv.org/abs/1801.04381" target="_blank" rel="noopener">arxiv.org/abs/1801.04381</a></li>
<li>Howard, A. G. and others (2017). <i>MobileNets: Efficient Convolutional Neural Networks for Mobile Vision Applications.</i> arXiv:1704.04861. <a href="https://arxiv.org/abs/1704.04861" target="_blank" rel="noopener">arxiv.org/abs/1704.04861</a></li>
<li>Guo, C., Pleiss, G., Sun, Y. and Weinberger, K. Q. (2017). <i>On Calibration of Modern Neural Networks.</i> ICML 2017, arXiv:1706.04599. <a href="https://arxiv.org/abs/1706.04599" target="_blank" rel="noopener">arxiv.org/abs/1706.04599</a></li>
<li>TensorFlow. <i>Transfer learning and fine-tuning.</i> <a href="https://www.tensorflow.org/tutorials/images/transfer_learning" target="_blank" rel="noopener">tensorflow.org/tutorials/images/transfer_learning</a></li>
<li>FAO (2021). <i>Climate change fans spread of pests and threatens plants and crops.</i> <span class="ref-src">Source of the 220 billion dollar and 40 percent figures.</span> <a href="https://www.fao.org/newsroom/detail/Climate-change-fans-spread-of-pests-and-threatens-plants-and-crops-new-FAO-study/en" target="_blank" rel="noopener">fao.org</a></li>
<li>TensorFlow Datasets. <i>plant_village.</i> <span class="ref-src">54,303 images across 38 classes as distributed.</span> <a href="https://www.tensorflow.org/datasets/catalog/plant_village" target="_blank" rel="noopener">tensorflow.org/datasets/catalog/plant_village</a></li>
<li>Kaggle. <i>New Plant Diseases Dataset.</i> <span class="ref-src">The augmented redistribution, roughly 87,000 images.</span> <a href="https://www.kaggle.com/datasets/vipoooool/new-plant-diseases-dataset" target="_blank" rel="noopener">kaggle.com</a></li>
<li>Meme in section 01 posted by Vishal, <a href="https://twitter.com/VishalMalvi_" target="_blank" rel="noopener">@VishalMalvi_</a>, reproduced here with attribution.</li>
</ol>
        </div>
        <br>
        <div class="d-flex">
            <a href="https://huggingface.co/spaces/rafiarsya/crop-disease-detector" target="_blank" rel="noopener" class="btn btn-main button-border d-flex align-items-center">
                <span>Try it on Hugging Face<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
            </a>
        </div>
        <br><br>
</div>
