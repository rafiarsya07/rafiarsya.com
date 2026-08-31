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
                <span class="badge blog-badge badge-green">MediaPipe</span>
                <span class="badge blog-badge badge-purple">OpenCV</span>
                <span class="badge blog-badge badge-orange">Computer Vision</span>
                <span class="badge blog-badge badge-neutral">Real-Time</span>
                <span class="badge blog-badge badge-blue">Machine Learning</span>
            </div>
            <h1>HandGesture</h1>
            <br>
            <span>Draw on screen with just your index finger, real-time hand landmark detection, gesture classification, and canvas rendering from a live webcam feed. No hardware required.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Completed</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2024</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Language</span><span class="p-meta-v">Python 3</span></span><span class="p-meta-item"><span class="p-meta-k">Category</span><span class="p-meta-v">Computer Vision</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p><strong>HandGesture</strong> turns your webcam into a drawing canvas. Raise your index finger to draw; hover over on-screen buttons to switch colours, start, stop, or clear. No mouse, stylus, or touchscreen, just a camera and your hand.</p>
<p>Built in <strong><mark class="hl">Python</mark></strong> using <strong><mark class="hl">OpenCV</mark></strong> for video capture and canvas compositing, and <strong><mark class="hl">MediaPipe Hands</mark></strong> for multi-hand 21-landmark detection. The system can track up to 4 hands simultaneously at <mark class="hl">30+ FPS</mark>, all on a standard laptop CPU, no GPU required.</p>

<strong>What I learned:</strong> Every physical hand posture produces a unique spatial relationship between 21 detected joint coordinates. A simple rule-based classifier on those coordinates is enough to reliably distinguish "drawing mode" from "idle mode" in real time.
        </div>
        <br>
        <h3>02 How It Works</h3>
        <div class="blog-content-body">
1
Video Capture &amp; Preprocessing
OpenCV opens the default webcam, reads frames in a loop, mirrors the image horizontally (so movement feels natural), and converts from BGR → RGB colour space for MediaPipe processing.

2
21-Point Landmark Detection
MediaPipe Hands processes each RGB frame and returns normalised (x, y, z) coordinates for 21 keypoints per hand, wrist (0), MCP joints (1,5,9,13,17), PIP joints (2,6,10,14,18), DIP joints (3,7,11,15,19), and fingertips (4,8,12,16,20).

3
Gesture Classification (Rule-Based)
A geometric classifier checks the y-coordinates of each finger's tip vs. its proximal knuckle (MCP). If only the index fingertip (landmark 8) is above its MCP (landmark 5) while all other tips are below theirs → drawing mode active.

4
Canvas Drawing
When in drawing mode, the app tracks the index fingertip pixel position (landmark 8 × frame dimensions) and calls <code class="inline">cv2.line()</code> between the current and previous position onto a persistent canvas layer.

5
Button Hit-Testing &amp; Overlay
On-screen buttons are fixed pixel regions. Each frame, if the fingertip coordinate falls within a button's bounding box, the action fires. The canvas layer is composited onto the live frame using <code class="inline"><mark class="hl">cv2.addWeighted</mark>()</code> and displayed in real time.

<button class="p-acc-trigger"><span class="p-acc-num">1</span><span class="p-acc-title">Video Capture &amp; Preprocessing</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">OpenCV opens the default webcam, reads frames in a loop, mirrors the image horizontally (so movement feels natural), and converts from BGR → RGB colour space for MediaPipe processing.</p>

<button class="p-acc-trigger"><span class="p-acc-num">2</span><span class="p-acc-title">21-Point Landmark Detection</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">MediaPipe Hands processes each RGB frame and returns normalised (x, y, z) coordinates for 21 keypoints per hand, wrist, MCP joints, PIP joints, DIP joints, and fingertips.</p>

<button class="p-acc-trigger"><span class="p-acc-num">3</span><span class="p-acc-title">Gesture Classification (Rule-Based)</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">A geometric classifier checks the y-coordinates of each finger's tip vs. its proximal knuckle (MCP). If only the index fingertip is above its MCP while all others are below → drawing mode.</p>

<button class="p-acc-trigger"><span class="p-acc-num">4</span><span class="p-acc-title">Canvas Drawing</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">When in drawing mode, the app tracks the index fingertip pixel position and calls <code style="font-family:monospace;font-size:11px;background:#f3f4f6;padding:1px 5px;border-radius:3px;">cv2.line()</code> between the current and previous position onto a persistent canvas layer.</p>

<button class="p-acc-trigger"><span class="p-acc-num">5</span><span class="p-acc-title">Button Hit-Testing &amp; Overlay</span><svg class="p-acc-chevron" viewbox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
<p class="p-acc-desc">On-screen buttons are fixed pixel regions. Each frame, if the fingertip coordinate falls within a button's bounding box, the action fires. The canvas layer is composited onto the live frame using cv2.addWeighted() and displayed in real time.</p>
        </div>
        <br>
        <h3>03 Processing Pipeline</h3>
        <div class="blog-content-body">
Webcam Frame
BGR · 640×480

→

Preprocess
Flip + BGR→RGB
Mirror image

→

Detect
MediaPipe Hands
21 landmarks/hand

→

Classify
Gesture Check
Rule-based logic

→

Render
Canvas Overlay
<mark class="hl">cv2.addWeighted</mark>

→

Output
Display Window
imshow · 30+ FPS

<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>swipe to explore the full pipeline<svg viewbox="0 0 24 24"><path d="M9 18l-6-6 6-6M15 6l6 6-6 6"></path></svg>
        </div>
        <br>
        <h3>04 The Math &amp; Gesture Logic</h3>
        <div class="blog-content-body">
<p>MediaPipe returns normalised landmark coordinates in the range [0.0, 1.0]. To convert to pixel coordinates on the actual frame:</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Coordinate Denormalisation</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">pixel_x = landmark.x × frame_width
pixel_y = landmark.y × frame_height</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Where <code class="inline">landmark.x</code> and <code class="inline">landmark.y</code> are values from MediaPipe in range [0,1]. Multiplying by frame dimensions gives pixel coordinates, so the same tracking code works identically on a 640×480 or 1920×1080 webcam, the model never needs to know the resolution.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Webcam frame: 640 × 480
landmark.x = 0.512   landmark.y = 0.347

pixel_x = 0.512 × 640  = 327.68  →  328 px
pixel_y = 0.347 × 480  = 166.56  →  167 px

# Same landmark, 1920×1080 frame:
pixel_x = 0.512 × 1920 = 983.04  →  983 px
pixel_y = 0.347 × 1080 = 374.76  →  375 px</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Drawing Gesture Classifier</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">is_drawing = (tip_y[INDEX]   &lt; mcp_y[INDEX]   AND   # index finger up
    tip_y[MIDDLE]  &gt; mcp_y[MIDDLE]  AND   # middle finger down
    tip_y[RING]    &gt; mcp_y[RING]    AND   # ring finger down
    tip_y[PINKY]   &gt; mcp_y[PINKY]         # pinky down
)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Since MediaPipe's y-axis is top-down (y=0 at top), a fingertip <strong>above</strong> its knuckle means <code class="inline">tip_y &lt; mcp_y</code>. That gives a binary classifier which fires only on the drawing pose, index extended, all other fingers curled. No machine learning; pure landmark geometry, checked every frame.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Hand landmarks (normalised, from MediaPipe)
tip_y[INDEX]  = 0.31   mcp_y[INDEX]  = 0.52   → 0.31 &lt; 0.52  ✓ UP
tip_y[MIDDLE] = 0.58   mcp_y[MIDDLE] = 0.54   → 0.58 &gt; 0.54  ✓ DOWN
tip_y[RING]   = 0.61   mcp_y[RING]   = 0.55   → 0.61 &gt; 0.55  ✓ DOWN
tip_y[PINKY]  = 0.63   mcp_y[PINKY]  = 0.56   → 0.63 &gt; 0.56  ✓ DOWN

→ all 4 conditions true → is_drawing = True</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">03</span><span class="p-math-title">Button Hit Test (AABB)</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Formula</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">is_hitting_button = (btn.x1 &lt;= finger_x &lt;= btn.x2  AND
    btn.y1 &lt;= finger_y &lt;= btn.y2
)</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Each on-screen button is an axis-aligned bounding box (AABB), the simplest possible collision test, borrowed straight from 2D game physics. The fingertip's pixel coordinate is checked against every button rectangle each frame, no click event, no debounce beyond a short hold-to-confirm, just geometry re-evaluated 30 times a second.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># "Clear Canvas" button region:
btn = { x1: 500, y1: 20, x2: 620, y2: 70 }

# Fingertip at frame coordinate (560, 45):
500 &lt;= 560 &lt;= 620   →  True
 20 &lt;=  45 &lt;=  70   →  True

→ is_hitting_button = True  →  canvas.clear()</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>05 Key Features</h3>
        <div class="blog-content-body">
<ul><li><b>4-Color Brush System</b>: Blue, Green, Red, and Pink brushes selectable by hovering your fingertip over on-screen buttons. Color switches instantly, no pause in drawing required.</li>
<li><b>Multi-Hand Tracking (up to 4)</b>: MediaPipe processes up to 4 simultaneous hands in a single frame, enabling collaborative multi-finger drawing or left/right hand switching mid-session.</li>
<li><b>Gesture-Only Controls</b>: Start/Stop drawing and Clear canvas are all triggered by fingertip bounding-box collision with on-screen button regions, zero keyboard/mouse interaction required.</li></ul>
        </div>
        <br>
        <h3>06 Use Cases</h3>
        <div class="blog-content-body">
<ul><li><b>Touchless Digital Art</b>: Sketch and paint on screen without any physical input device, useful for hygiene-sensitive or hardware-constrained environments.</li>
<li><b>Interactive Presentations</b>: Draw annotations on slides or whiteboards in real time during a live lecture or webinar without touching a keyboard.</li>
<li><b>Assistive Technology</b>: Enables users with limited hand mobility to interact with digital interfaces using only gross motor movements captured by webcam.</li>
<li><b>Gesture-Based Games</b>: Foundation for building gesture-controlled mini-games, interactive installations, or educational drawing apps for children.</li></ul>
        </div>
        <br>
        <h3>07 Video Demonstration</h3>
        <div class="blog-content-body">
<p>MediaPipe detecting 21 hand landmarks in real time, the index-finger drawing engine tracing strokes on the canvas overlay, and gesture-based button interactions, all at 30+ FPS directly from a standard webcam.</p>

<figure class="rf-figure">
<video controls="" loop="" playsinline="" preload="metadata" src="image/assets/handgesture/demo_handgesture.mp4"></video>
<figcaption class="img-caption"><b>Demo</b>: Landmark tracking, the drawing engine, and gesture buttons running live at 30+ FPS</figcaption>
</figure>
        </div>
        <br>
        <h3>08 Controls Reference</h3>
        <div class="blog-content-body">
<table class="p-ctrl-table">
<thead>
<tr>
<th>Control</th>
<th>Trigger</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<tr>
<td><span class="p-ctrl-badge">START</span></td>
<td style="color:var(--muted);font-size:12px;">Fingertip hover</td>
<td>Enable drawing mode, fingertip traces strokes</td>
</tr>
<tr>
<td><span class="p-ctrl-badge">STOP</span></td>
<td style="color:var(--muted);font-size:12px;">Fingertip hover</td>
<td>Disable drawing, tracking stays active, no strokes</td>
</tr>
<tr>
<td><span class="p-ctrl-badge">CLEAR</span></td>
<td style="color:var(--muted);font-size:12px;">Fingertip hover</td>
<td>Wipe entire canvas clean</td>
</tr>
<tr>
<td><span class="p-ctrl-badge">COLOR</span></td>
<td style="color:var(--muted);font-size:12px;">Hover color button</td>
<td>Switch brush: Blue / Green / Red / Pink</td>
</tr>
<tr>
<td><span class="p-ctrl-badge">Q</span></td>
<td style="color:var(--muted);font-size:12px;">Keyboard</td>
<td>Quit the application</td>
</tr>
</tbody>
</table>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Python 3</span>
<span class="badge blog-badge badge-neutral">MediaPipe</span>
<span class="badge blog-badge badge-neutral">OpenCV</span>
<span class="badge blog-badge badge-neutral">NumPy</span>
<span class="badge blog-badge badge-neutral">Webcam API</span>
<span class="badge blog-badge badge-neutral"><mark class="hl">cv2.addWeighted</mark></span>
</div>
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
