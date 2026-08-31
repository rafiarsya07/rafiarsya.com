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
            <span>A server-authoritative real-time multiplayer duel. Two players connect from different devices, lock in a secret action every round, and the server resolves the outcome fairly and deterministically. No database, no accounts, no AI, just the hard parts: state machines, race conditions, and cheat-proof multiplayer architecture.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Backend</span><span class="p-meta-v">In-memory, Socket.IO</span></span><span class="p-meta-item"><span class="p-meta-k">Persistence</span><span class="p-meta-v">None (by design)</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p class="p-text">Two players on separate devices pick an action each round: Attack, Defend, or Special, simultaneously and blind. The server waits for both, resolves the clash from a fixed matchup table, applies damage, and broadcasts to both screens at once. First to drop the opponent to zero HP wins.</p>
<p class="p-text">I didn't build this to make a game, the interesting problems live underneath it: where state lives, who decides outcomes, what happens when both players act at once, and what happens when one disconnects mid-round. Those are real-time system-design questions, so I built the smallest project that forces me to solve them rather than talk about them.</p>

<strong>The one rule that shapes everything:</strong> the client never decides anything. It sends <em>intents</em> (“I choose Attack”), never <em>results</em> (“I won”). The server is the single source of truth. A modified client can lie about what it picked, but it can never declare itself the winner, because it isn't the one doing the math. This is the same principle every real online game runs on.
        </div>
        <br>
        <h3>02 Server-Authoritative Architecture</h3>
        <div class="blog-content-body">
<p>All game state lives in the backend, in memory, in a single <code class="inline">Map</code> of active matches, nothing is persisted to disk or a database. Each match is a small object that owns its own HP, cooldowns, current phase, and the two players' submitted-but-not-yet-revealed actions for the round.</p>

<strong>Round lifecycle</strong><br/>
<code class="inline">create</code> → Player A makes a room, gets a 5-char code; Player B joins with it. No login.<br/>
<code class="inline">countdown</code> → once both are in, a synchronized 3-second countdown plays on both clients.<br/>
<code class="inline">selecting</code> → 5-second window; each player privately submits an action. The opponent only sees “locked in”.<br/>
<code class="inline">resolving</code> → the instant both submit (or the timer expires), the server runs the matchup table, applies damage, updates cooldowns, and emits the result to both at once.<br/>
<code class="inline">ended</code> → HP hits 0, or a 30-round safety cap (highest HP wins; tie is a draw).
                                
<p class="p-text">The round timer runs on the server in the socket layer, not in either client. Clients render a countdown for feel, but the authoritative clock, the one that defaults a silent player to Defend, is the server's. Closing a tab can't freeze the other player's match.</p>
        </div>
        <br>
        <h3>03 Simultaneous Action Resolution</h3>
        <div class="blog-content-body">
<p class="p-text">Both players choose simultaneously and blind, so the server can't resolve until it holds both submissions, or the timer fires. “Wait for both, or time out, then resolve exactly once” is a real concurrency problem: two socket events racing toward one resolution that must fire a single time, never zero, never twice.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">3×3 Action Matchup Table</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Table</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">Attack   vs Attack    -&gt; both take 12   (trade)
Attack   vs Defend    -&gt; defender blocks; attacker takes 6 (counter)
Attack   vs Special   -&gt; Attack deals 18, Special deals 30 (both land)
Defend   vs Defend    -&gt; nothing happens
Defend   vs Special   -&gt; Special breaks through for 10
Special  vs Special   -&gt; both take 15   (reduced trade)

Special has a 3-round cooldown, enforced server-side via
isActionAvailable(), a client cannot submit Special while
on cooldown; the server silently rejects the submission.</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">The table is symmetric and deterministic: the same two actions always produce the same result, with no hidden randomness, so two clients fed the same pair of inputs will always agree with the server. <code class="inline">Defend</code> hard-counters <code class="inline">Attack</code> (block + counter damage) but is useless against <code class="inline">Special</code>; <code class="inline">Special</code> hits hardest but is gated by a cooldown so it can't be spammed. The cooldown is the resource-management layer, and crucially it's checked on the server in <code class="inline">isActionAvailable()</code>, not just greyed out in the UI. Hiding a button in the client is cosmetics; rejecting the submission on the server is the actual rule.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Round 4, both players at 60 HP
# Player A submits Special (off cooldown), Player B submits Attack

server holds:  { A: "special", B: "attack" }   # both arrived -&gt; resolve once
matchup:       Attack vs Special  -&gt;  Attack 18, Special 30

after:   A.hp = 60 - 18 = 42
         B.hp = 60 - 30 = 30
         A.specialCooldown = 3   # locked for the next 3 rounds
         broadcast { aHp:42, bHp:30, aAction:"special", bAction:"attack" }

# If B had simply closed the tab instead of submitting:
#   the 5s server timer fires, B defaults to Defend, round still resolves.</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 Engineering Decisions</h3>
        <div class="blog-content-body">
<ul><li><b>Resolve once, or time out</b>: The server resolves the instant both actions are in, OR when the 5s timer expires, whichever comes first, and guards against resolving the same round twice when the second submission and the timeout race each other.</li>
<li><b>Disconnect grace period</b>: A dropped connection doesn't instantly kill the match. There's a grace window before teardown, so a brief network blip doesn't rob the other player of a game, a real production concern for any persistent-connection system.</li>
<li><b>Rendering decoupled from logic</b>: Fighters are pure SVG/CSS, with poses driven by game state, zero image assets. Swapping in real sprites would touch only <code class="inline">Fighter.jsx</code> with no backend changes, because presentation and game rules never mix.</li></ul>
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
        <div class="d-flex">
            <a href="/project" class="btn btn-main button-border d-flex align-items-center">
                <span class="menu-icon"><back-icon class="menu-icon-data"></back-icon></span>
                <span>All Projects</span>
            </a>
        </div>
        <br><br>
    </div>
</div>
