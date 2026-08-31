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
                <span class="badge blog-badge badge-blue">React 18</span>
                <span class="badge blog-badge badge-green">Vite</span>
                <span class="badge blog-badge badge-purple">PWA</span>
                <span class="badge blog-badge badge-orange">Service Worker</span>
                <span class="badge blog-badge badge-neutral">Android TWA</span>
                <span class="badge blog-badge badge-blue">Capacitor</span>
                <span class="badge blog-badge badge-green">localStorage</span>
            </div>
            <h1>Reminder Me</h1>
            <br>
            <span>A personal “companion agent” for daily life as a student, habits, focus sessions, tasks, exams, prayer times, health, and journalling, all in one offline-first app. Built as an installable PWA and wrapped as a real Android APK via a Trusted Web Activity. No backend, no account, no cloud, everything lives on the device.</span>
            <br>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Working</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Solo Developer</span></span><span class="p-meta-item"><span class="p-meta-k">Platform</span><span class="p-meta-v">PWA + Android APK</span></span><span class="p-meta-item"><span class="p-meta-k">Data</span><span class="p-meta-v">On-device only</span></span></div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 Project Overview</h3>
        <div class="blog-content-body">
<p class="p-text">Pendamping (Indonesian for “companion”) is one place that knows my day: habits, a focus/Pomodoro timer, tasks and deadlines, a calendar, exam countdowns, streaks, a health log, a journal, and prayer times. The home screen then surfaces the one or two things that deserve attention right now.</p>
<p class="p-text">It's built around my life: the app runs on Malaysia time (<code class="inline">Asia/Kuala_Lumpur</code>) regardless of the device clock, the copy is Indonesian, and the defaults reflect a student's day. The home tab reads the time-of-day phase, morning, afternoon, evening, late night, and reorders its nudges accordingly.</p>

<strong>No backend, on purpose.</strong> There is no server, no account, and no cloud sync. Every habit tick, task, journal entry, and Pomodoro count is stored in the browser's <code class="inline">localStorage</code> on the device. That makes it private by default, instant to load, and fully usable offline, and it's the constraint that made the offline-first and packaging work the interesting part.
        </div>
        <br>
        <h3>02 What's Inside</h3>
        <div class="blog-content-body">
<p>The app is organized into tabs, with the five most-used pinned to a bottom bar and the rest tucked under a “More” menu, phone-shaped navigation, not desktop.</p>

<strong>Hari ini (Today)</strong>, the dashboard: today's habits with a streak counter, a rotating motivational line, and a smart “focus list” that bubbles up overdue tasks and near exams.<br/>
<strong>Fokus (Focus)</strong>, a Pomodoro timer with a distraction-free focus mode; completed sessions feed straight into progress.<br/>
<strong>Tugas (Tasks)</strong>, to-dos with priority and deadlines; late and due-soon items get flagged.<br/>
<strong>Kalender (Calendar)</strong>, events alongside exam dates.<br/>
<strong>Ujian (Exams)</strong>, courses and exams with a live days-until countdown that drives the home-screen nudges.<br/>
<strong>Progress</strong>, current and best streak, weekly habit completion, and Pomodoro totals.<br/>
<strong>Kesehatan (Health)</strong> &amp; <strong>Jurnal (Journal)</strong>, water/sleep style logging and short daily notes.<br/>
<strong>Atur (Settings)</strong>, edit prayer times, the daily schedule template, and export <em>all</em> data to JSON.
        </div>
        <br>
        <h3>03 The Smart Focus List</h3>
        <div class="blog-content-body">
<p class="p-text">Rather than dumping everything, the home screen scores each candidate nudge by urgency (high/medium/low) and current phase, then shows the most important first. An exam two days out outranks an unchecked habit; an overdue task outranks an exam a week away.</p>

<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Home-Screen Priority Logic</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Rules</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">HIGH    overdue tasks            -&gt; "do or reschedule now"
HIGH    exam in &lt;= 2 days        -&gt; "review key points, no cramming"
MEDIUM  tasks due &lt;= 2 days      -&gt; "chip away today"
MEDIUM  exam in 3..7 days        -&gt; "start studying gradually"
MEDIUM  high-priority tasks      -&gt; "N priority tasks waiting"
LOW     habits left (daytime)    -&gt; "N habits not checked yet"
LOW     weekly target (morning)  -&gt; surface this week's goal

Sorted HIGH -&gt; MEDIUM -&gt; LOW, then shown top-first.
Phase (morning / afternoon / evening / late) gates the LOW nudges
so it won't nag about habits at midnight.</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Each rule produces a nudge tagged with a level and the tab it links to, so tapping a nudge jumps straight to the relevant screen. Time-of-day is computed in <strong>Malaysia time</strong>, not the device's, so the phase logic is stable no matter where the phone thinks it is. The low-priority nudges are gated by phase, an unchecked-habit reminder only appears during the day, never in the late-night window, which keeps the home screen calm instead of guilt-tripping. The whole thing is deterministic and rule-based: no model, no scoring black box, just a small ordered list of <code class="inline">if</code> conditions that's easy to reason about and tweak.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example"># Tuesday, 09:40 MYT (phase = "pagi"/morning)
state:  1 task overdue
        Computer Architecture exam in 2 days
        3 of 5 habits still unchecked

builds:  HIGH   "1 task past deadline, do or reschedule now"   -&gt; Tugas
         HIGH   "Computer Architecture in 2 days, review now"  -&gt; Ujian
         LOW    "3 habits not checked yet today"                -&gt; Hari ini

home shows the two HIGH nudges first; the habit reminder
sits below. At 23:30 (phase = "larut"/late) the habit
nudge is suppressed entirely.</pre></div></div></div></div></div>
        </div>
        <br>
        <h3>04 Offline-First &amp; Packaging</h3>
        <div class="blog-content-body">
<p>Getting one React app to install cleanly on a phone, both as a browser PWA <em>and</em> as a real APK from a single codebase, was the part that taught me the most.</p>

<ul><li><b>Real Android APK via TWA</b>: Wrapped as a <strong>Trusted Web Activity</strong>, a signed, installable APK that runs the same web app full-screen with no browser chrome, verified against the live domain through Digital Asset Links.</li>
<li><b>Smart install banner</b>: An in-app banner offers the APK download only to Android users who haven't already installed it, it checks the user agent and standalone display-mode, and remembers a dismissal for the session.</li>
<li><b>MYT everywhere, ID copy</b>: All date keys, clocks, and phase logic are pinned to Asia/Kuala_Lumpur, so streaks and “today” never drift with the device clock. The interface is fully in Indonesian.</li></ul>
        </div>
        <br>
        <h3>05 Data Ownership</h3>
        <div class="blog-content-body">
<p>Because there's no server, the user owns their data outright, and I made that explicit rather than implicit.</p>

<strong>Everything is local, everything is exportable.</strong> Habits, logs, tasks, exams, courses, events, journal entries, and Pomodoro totals all persist in <code class="inline">localStorage</code>. Settings includes a one-tap <strong>“Export all data (JSON)”</strong>, so the data is portable and backup-able even with no cloud behind it. Nothing is collected, nothing leaves the device unless the user chooses to export it.
                                
<p>The tradeoff is honest: no cross-device sync, and clearing browser storage clears the data. For a private, single-user companion app that's the right call, zero infrastructure, zero cost, instant load, and complete privacy.</p>
        </div>
        <br>
        <h3>06 Use Cases</h3>
        <div class="blog-content-body">
<ul><li><b>Daily Habit Streaks</b>: Check off habits each day and watch the streak build, the simplest, stickiest reason to open the app every morning.</li>
<li><b>Exam Crunch Planning</b>: Add an exam and the countdown drives escalating home-screen nudges, from “start gradually” at a week out to “review now” at two days.</li>
<li><b>Focused Study Sessions</b>: Run a Pomodoro in distraction-free focus mode; finished sessions roll into the weekly progress view.</li>
<li><b>A Private Pocket Companion</b>: Installed to the home screen, working offline, holding everything from prayer times to a journal, with data that never leaves the phone.</li></ul>
        </div>
        <br>
        <h3>Tech Stack</h3>
        <div class="blog-content-body">
<div class="tech-stack">
<span class="badge blog-badge badge-neutral">React 18</span>
<span class="badge blog-badge badge-neutral">Vite</span>
<span class="badge blog-badge badge-neutral">lucide-react</span>
<span class="badge blog-badge badge-neutral">vite-plugin-pwa</span>
<span class="badge blog-badge badge-neutral">Workbox</span>
<span class="badge blog-badge badge-neutral">Service Worker</span>
<span class="badge blog-badge badge-neutral">Web App Manifest</span>
<span class="badge blog-badge badge-neutral">Android TWA</span>
<span class="badge blog-badge badge-neutral">Capacitor</span>
<span class="badge blog-badge badge-neutral">Gradle</span>
<span class="badge blog-badge badge-neutral">localStorage</span>
</div>
        </div>
        <br>
        <h3>Links</h3>
        <div class="blog-content-body">
<a class="p-link-btn" href="https://partner.rafiarsya.com" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
<span class="p-link-btn-label">partner.rafiarsya.com</span>
</a>
<a class="p-link-btn" href="https://github.com/rafiarsya07/Reminder-Rafi" rel="noopener noreferrer" target="_blank">
<svg viewbox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
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
        <br><br>
    </div>
</div>
