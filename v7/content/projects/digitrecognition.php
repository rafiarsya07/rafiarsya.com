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
                <span class="badge blog-badge badge-green">NumPy only</span>
                <span class="badge blog-badge badge-purple">CNN from scratch</span>
                <span class="badge blog-badge badge-orange">Flask</span>
                <span class="badge blog-badge badge-neutral">MNIST</span>
            </div>
            <h1>AI Digit Recognizer</h1>
            <br>
            <span>Draw a digit in the browser and a convolutional network recognises it, written entirely in NumPy, with no PyTorch or TensorFlow anywhere in the stack. Every convolution, pooling layer, backward pass and optimiser step is hand-written. 99.12% accuracy on the real MNIST test set, with an animated visualizer that shows how the decision was reached, down to the pixel.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Complete</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Test accuracy</span><span class="p-meta-v">99.12% on MNIST</span></span></div>
            <a href="https://github.com/rafiarsya07/ai-digit-recognizer" target="_blank" rel="noopener" class="ext-link">View on GitHub<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Rule</h3>
        <div class="blog-content-body">
<p>One constraint shaped the whole project: no deep learning framework. NumPy for array maths, and nothing else. Not because frameworks are bad, but because <code class="inline">model.fit()</code> teaches you the API rather than the idea, and the parts a framework hides are exactly the parts worth understanding.</p>
<p>So the repository contains a working <code class="inline">im2col</code> convolution, its <code class="inline">col2im</code> gradient, max-pool forward and backward with index routing, dropout, softmax cross-entropy, and Adam. Every gradient was checked against numerical differentiation before training was allowed to start. A hand-written backward pass that is subtly wrong still trains, just badly, and that failure is almost impossible to diagnose after the fact.</p>
        </div>
        <br>
        <h3>02 Architecture</h3>
        <div class="blog-content-body">
<pre class="p-math-formula">Input 1 x 28 x 28
  -&gt; Conv(8 filters, 3x3, pad 1)  -&gt; ReLU -&gt; MaxPool 2x2   ->  8 x 14 x 14
  -&gt; Conv(16 filters, 3x3, pad 1) -&gt; ReLU -&gt; MaxPool 2x2   -&gt; 16 x  7 x  7
  -&gt; Flatten (784)
  -&gt; Dense 128 -&gt; ReLU -&gt; Dropout 0.2
  -&gt; Dense  64 -&gt; ReLU -&gt; Dropout 0.2
  -&gt; Dense  10 -&gt; Softmax</pre>
<p>Trained on the real MNIST set: 60,000 training and 10,000 test images, parsed by hand from the original IDX binary format rather than loaded from a helper library. Augmentation applies a random shift of up to two pixels and a rotation of up to twelve degrees on every sample.</p>
        </div>
        <br>
        <h3>03 Why a CNN, Not Just an MLP</h3>
        <div class="blog-content-body">
<p>The first working version was a plain multi-layer perceptron, 784&rarr;256&rarr;128&rarr;10, and it reached 98.64% on the test set. On typed and centred digits it looked finished. On real handwriting it was not, specifically on cursive nines with a long looping tail, which it read as a 3 or a 5 with confidence.</p>
<p>The reason is structural, not a matter of training longer. An MLP sees the image as 784 independent numbers with no notion that two pixels are adjacent, so a loop drawn slightly higher is, as far as the network is concerned, a completely different input. A convolution's filters slide, which means the same learned stroke detector fires wherever the stroke appears, and that translation tolerance is precisely what handwriting demands.</p>
<pre class="p-math-formula">                             MLP            CNN
                             784-256-128-10

Overall test accuracy        98.64%         99.12%
Digit 9 accuracy             96.0%          98.3%
True 9 predicted as 3        10 times        0 times
True 9 predicted as 4        12 times       10 times</pre>
<p>The MLP is still in the repository under <code class="inline">src/network.py</code> and <code class="inline">src/train.py</code>. Keeping the weaker version is deliberate: the comparison is the point, and the simpler model is the better place to start reading.</p>
        </div>
        <br>
        <h3>04 Making It Fast Enough to Train on a Laptop</h3>
        <div class="blog-content-body">
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">im2col: Convolution as One Matrix Multiply</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Idea</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula"># naive: four nested Python loops, one per output pixel
for n in batch:
  for f in filters:
    for y in out_h:
      for x in out_w:
        out[n,f,y,x] = sum(window(n,y,x) * W[f])

# im2col: lay every sliding window out as a row, once
cols = im2col(x)          # (windows, C*kh*kw)  -- a VIEW, no copy
out  = cols @ W_flat.T    # one matmul does the whole layer
out  = out.reshape(...)   # back to (N, F, H, W)

# backward
dW   = dout_flat.T @ cols
dx   = col2im(dout_flat @ W_flat)   # scatter-add overlaps back</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">A convolution is a dot product between a filter and a patch, repeated across the image. Written literally in Python that is four nested loops, and Python loop overhead dominates the arithmetic so completely that a single epoch becomes unusable. The interpreter, not the maths, is the bottleneck.</p><p class="p-math-desc"><code class="inline">im2col</code> reshapes the problem instead of speeding up the loop. Every sliding window is laid out as one row of a matrix, so all of them together become a single matmul, which NumPy hands to a BLAS routine written in C. Crucially the rearrangement uses stride tricks, so the window matrix is a view over the original array rather than a copy, so overlapping windows share memory instead of duplicating it, which matters because with 3&times;3 filters and stride 1 nearly every pixel appears in nine windows.</p><p class="p-math-desc">The backward pass is the same trick reversed. Gradients arrive per window, and <code class="inline">col2im</code> scatter-adds them back to the pixels they came from. Adds, not assigns, because a pixel that contributed to nine windows must accumulate nine gradients. Getting that wrong is the classic silent CNN bug: training still runs, loss still falls, accuracy just quietly plateaus lower than it should.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">layer 1: 1 x 28 x 28 input, 8 filters of 3x3, pad 1

windows      28 * 28          = 784 per image
row length   1 * 3 * 3        =   9
cols         (784, 9)         as a stride view, zero copies
W_flat       (8, 9)

one matmul   (784, 9) @ (9, 8)  ->  (784, 8)
reshape      ->  8 x 28 x 28   ->  pool  ->  8 x 14 x 14

result: ~35 seconds per epoch on a laptop CPU
        instead of minutes per epoch in pure Python loops</pre></div></div></div></div></div>
<p>Training checkpoints after every epoch and can resume from any of them, so a ten-epoch run can be done in chunks rather than as one long process that loses everything if it is interrupted:</p>
<pre class="p-math-formula">python -m src.train_cnn --epochs 3 --start-epoch 0
python -m src.train_cnn --epochs 3 --start-epoch 3 --resume
python -m src.train_cnn --epochs 4 --start-epoch 6 --resume</pre>
        </div>
        <br>
        <h3>05 The Step Most Demos Skip</h3>
        <div class="blog-content-body">
<p>A model trained on MNIST and served a raw canvas drawing performs far worse than its test accuracy suggests, and the reason is not the model. MNIST digits are not raw scans: each one is size-normalised to fit a 20&times;20 box and then positioned so its <em>centre of mass</em> sits at the centre of a 28&times;28 field. A drawn digit that skips that transform is, statistically, not the kind of input the network was trained on.</p>
<p>So the same preprocessing runs on every drawing before inference:</p>
<ul>
<li>Crop to the bounding box of the ink, discarding empty canvas.</li>
<li>Scale the longest side to 20 pixels, preserving aspect ratio, so a large and a small 7 become the same size.</li>
<li>Paste into a 28&times;28 field, offset so the centre of mass lands dead centre, not the bounding box centre, which is a different point for an asymmetric digit like 1 or 7.</li>
</ul>
<p>The side panel in the UI shows the actual 28&times;28 array the network receives after this transform, which makes a wrong prediction diagnosable: usually the input looks wrong before the answer does.</p>
        </div>
        <br>
        <h3>06 Watching the Network Think</h3>
        <div class="blog-content-body">
<p>Confidence bars tell you what the network decided. The visualizer is there to show <em>why</em>, in four phases:</p>
<ul>
<li><b>Per-pixel importance scan</b>: a saliency heatmap lights up brightest-first, showing which pixels moved the decision.</li>
<li><b>Input to Hidden 128</b>: signal lines flow into the first dense layer after the conv and pool stack, with active neurons lighting up.</li>
<li><b>Hidden 128 to Hidden 64</b>: the signal propagates deeper.</li>
<li><b>Output</b>: probability bars settle across the ten classes.</li>
</ul>
<p>The saliency map is not decoration. It backpropagates a gradient from the winning class logit all the way through the dense and convolutional layers to the input, giving <code class="inline">&part;z<sub>class</sub> / &part;x<sub>i</sub></code> for every pixel: how much that pixel influenced this particular decision. Multiplied by the input and normalised, it drives the scanning animation. A forward pass costs one to two milliseconds on CPU, so this all runs in real time.</p>
        </div>
        <br>
        <h3>07 Project Structure</h3>
        <div class="blog-content-body">
<div class="project-tree">ai-digit-recognizer/
├── app.py               <span class="pt-comment"># Flask + Waitress, UI and /api/predict</span>
├── download_data.py     <span class="pt-comment"># fetches MNIST (11 MB)</span>
├── run_tests.py         <span class="pt-comment"># end-to-end smoke tests</span>
├── <span class="pt-dir">src/</span>
│   ├── mnist.py         <span class="pt-comment"># IDX binary format parser</span>
│   ├── cnn.py           <span class="pt-comment"># conv, pool, dense, backprop, Adam, saliency</span>
│   ├── train_cnn.py     <span class="pt-comment"># training loop with --resume checkpoints</span>
│   ├── evaluate_cnn.py  <span class="pt-comment"># confusion matrix, per-class accuracy</span>
│   ├── network.py       <span class="pt-comment"># legacy MLP, kept for comparison</span>
│   └── augment.py
├── <span class="pt-dir">model/</span>
│   ├── mnist_cnn.npz    <span class="pt-comment"># trained CNN weights, shipped in the repo</span>
│   └── mnist_mlp.npz
└── <span class="pt-dir">static/</span>
    └── index.html       <span class="pt-comment"># canvas + animated visualizer</span></div>
<p>Weights are committed, so <code class="inline">pip install -r requirements.txt</code> and <code class="inline">python app.py</code> is enough to run it. Downloading MNIST is only needed to retrain or re-evaluate. The server is Waitress rather than Flask's development server, which is noticeably more stable on Windows, falling back to the dev server if Waitress is not installed.</p>
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
