<div class="blog-content">
    <div class="blog-content-header">
        <div><span class="badge blog-badge badge-blue">Education</span><span class="badge blog-badge badge-green">Single-File</span><span class="badge blog-badge badge-purple">Vanilla JS</span><span class="badge blog-badge badge-orange">2026</span></div>
        <h1>CSA Study App: Exam Prep That Tests Method, Not Memory</h1>
        <br>
        <span>A single-file revision tool for Computer Systems Architecture where every number regenerates on each load: so you drill the formula, not the answer. Now used by ~70 students from the UM Indonesian 2025 cohort to prepare for the CSA exam.</span>
        <br>
        <span style="font-weight: lighter">2026 &middot; </span>
    </div>
    <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>The Problem</h3>
        <div class="blog-content-body">
<p>Revising for the Computer Systems Architecture exam (WRES1201) meant grinding through the same five worked examples everyone in the cohort already had. There's a subtle trap in that: you stop learning the <em>method</em> and start recognizing the <em>answer</em>. You see "clock rate 2GHz, CPI 1.5" and your brain autocompletes the result, not because you understand it, but because you've seen that exact problem twenty times.</p>
                            <p>Then the exam gives you 2.4GHz and CPI 1.8, and the memorized answer is worthless. You needed to know the formula. You only knew the example.</p>
                            Same constraint I used for RafiFinance: one HTML file, zero backend, zero dependencies beyond a CDN icon set. Open the link, pick a topic, drill. No login, no install, no data collected. But the real idea is deeper than the constraint, it’s that the questions should never repeat.
                            <p>So I made every numeric question <strong>generated at runtime with randomized values.</strong> Refresh the page and the instruction counts, clock speeds, cache sizes, and RPM values are all different. The app holds the <em>formula</em> and rolls fresh inputs into it each time, which means the only way to answer is to actually understand the underlying relationship.</p>
                            <p>Over the next sessions I'll walk through the procedural generation engine, then the genuinely hard math it tests, CPU performance, Amdahl's Law, pipelining, cache addressing, Hamming codes, and disk/RAID, and finally how it ended up helping a whole cohort of ~70 students.</p>
        </div>
        <br>
        <h3>The Math It Tests</h3>
        <div class="blog-content-body">
<p>Take the CPU performance topic as an example. Every question boils down to one relationship: how long a program actually takes to run.</p>
                            <p>The formula is:</p>
                            \[ T = IC \times CPI \times T_{clock} \]
                            <p>Where:</p>
                            <ul class="math-where">
                                <li>\(IC\) is the <strong>instruction count</strong>, how many instructions the program executes</li>
                                <li>\(CPI\) is <strong>cycles per instruction</strong>, the average clock cycles each instruction takes</li>
                                <li>\(T_{clock}\) is the <strong>clock cycle time</strong>, how long a single clock tick lasts</li>
                            </ul>
                            <p>These three numbers are all the app randomizes on every reload. If the result comes out <span class="math-tag pos">lower</span>, the program got faster; if it comes out <span class="math-tag neg">higher</span>, something in the pipeline or clock rate made it slower. Memorizing "2GHz and CPI 1.5" doesn't help once the numbers change, only the formula does.</p>
        </div>
        <br>
    <br>
</div>
