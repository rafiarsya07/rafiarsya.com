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

        <figure class="p-hero"><img alt="Arena Duel waiting room and two players mid-round" decoding="async" src="image/assets/arenaduel/cover.jpg"/></figure>

        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Node.js</span>
                <span class="badge blog-badge badge-green">Socket.IO</span>
                <span class="badge blog-badge badge-purple">Express</span>
                <span class="badge blog-badge badge-orange">React</span>
                <span class="badge blog-badge badge-neutral">Vite</span>
                <span class="badge blog-badge badge-blue">Tailwind</span>
                <span class="badge blog-badge badge-green">State Machine</span>
            </div>
            <h1>Arena Duel</h1>
            <br>
            <span>A real-time multiplayer duel. Both players lock in a secret move each round and the server decides, so neither side can cheat.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">In-memory, Socket.IO</span></span><span class="p-meta-item"><span class="p-meta-k">Persistence</span><span class="p-meta-v">None (by design)</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Idea</h3>
        <div class="blog-content-body">
<p class="p-text">Two players on different devices choose Attack, Defend or Special at the same time. The server waits for both, resolves the clash and updates both screens at once. First to zero HP loses.</p>
        </div>
        <br>
        <h3>02 Highlights</h3>
        <div class="blog-content-body">
<ul>
<li><b>Server decides</b>: all game state lives on the server, clients only send moves</li>
<li><b>Fair timing</b>: a round resolves when both moves are in or after 5 seconds, never twice</li>
<li><b>Survives drops</b>: a short grace period before a disconnected player forfeits</li>
<li><b>No image assets</b>: fighters are pure SVG and CSS, posed by game state</li>
</ul>
        </div>
        <br>
        <h3>03 Screens</h3>
        <div class="blog-content-body">
<div class="rf-livegroup">
<p class="rf-livegroup-title">On a phone</p>
<div class="cb-phones">
<figure><img alt="Lobby on a phone" decoding="async" loading="lazy" src="image/assets/arenaduel/phone-lobby.png"/><figcaption><b>Lobby</b>Create or join a room</figcaption></figure>
<figure><img alt="Waiting room on a phone" decoding="async" loading="lazy" src="image/assets/arenaduel/phone-wait.png"/><figcaption><b>Waiting</b>Share the room code</figcaption></figure>
<figure><img alt="A round in progress on a phone" decoding="async" loading="lazy" src="image/assets/arenaduel/phone-round.png"/><figcaption><b>Round</b>Pick a move in time</figcaption></figure>
<figure><img alt="Round result on a phone" decoding="async" loading="lazy" src="image/assets/arenaduel/phone-round2.png"/><figcaption><b>Result</b>Both moves revealed</figcaption></figure>
</div>
</div>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">Node.js</span>
<span class="badge blog-badge badge-neutral">Express</span>
<span class="badge blog-badge badge-neutral">Socket.IO</span>
<span class="badge blog-badge badge-neutral">React</span>
<span class="badge blog-badge badge-neutral">Vite</span>
<span class="badge blog-badge badge-neutral">Tailwind CSS</span>
<span class="badge blog-badge badge-neutral">In-memory state</span>
<span class="badge blog-badge badge-neutral">SVG / CSS</span>
<span class="badge blog-badge badge-neutral">WebSockets</span>
</div>
</div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://arena.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">arena.rafiarsya.com</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07?tab=repositories" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"></path></svg>
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
        <br>
        <div class="text-center text-silent text14">
            &#169; MUHAMMAD RAFI ARSYA
        </div>
        <br>
    </div>
</div>
