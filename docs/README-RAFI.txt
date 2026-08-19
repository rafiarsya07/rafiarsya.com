════════════════════════════════════════════════════════════
  RAFI — Intelligence Core  ·  integration notes
════════════════════════════════════════════════════════════

WHAT THIS IS
  A floating avatar (bottom-right of every page) that opens a
  LIVE AI mind — real reasoning, LaTeX math, and web search —
  replacing the old keyword voice assistant.

  Click the avatar → it ignites → "I'm awake. How can I help you?"


─── FILES (where everything lives) ─────────────────────────────
  Unfinished Portfolio/
   ├─ rafi-core.css      ← NEW  · the widget styles
   ├─ rafi-core.js       ← NEW  · the widget + brain
   ├─ README-RAFI.txt    ← this file
   ├─ assets/rafi_avatar.mp4   · avatar reused by the widget
   ├─ va-assistant.css / .js   · OLD assistant (kept, now UNUSED)
   └─ *.html, projects/*.html  · all 26 pages now load rafi-core


─── WHAT CHANGED IN THE PAGES ──────────────────────────────────
  On every HTML page the two include lines were swapped:
     va-assistant.css  →  rafi-core.css
     va-assistant.js   →  rafi-core.js
  (project pages keep the "../" prefix automatically.)
  va-interactive.* (your per-page project widgets) was NOT touched.

  To revert: swap those two names back. The old files are intact.


─── THE BRAIN: canvas vs your live site ────────────────────────
  The widget POSTs to the constant RAFI_API at the top of
  rafi-core.js (default: https://api.anthropic.com/v1/messages).

  • Inside the Claude canvas → it just works (key is injected).
  • On rafiarsya.com → the browser CANNOT call Anthropic directly
    (no API key in the browser + CORS). You need a tiny proxy that
    holds the key server-side. You already run everything on
    Cloudflare, so a Worker is the easiest path:


─── 1-FILE CLOUDFLARE WORKER PROXY ─────────────────────────────
  Create a Worker (e.g. rafi-brain), paste this, add a secret
  named ANTHROPIC_API_KEY, deploy:

    export default {
      async fetch(req, env) {
        if (req.method === "OPTIONS") return cors(new Response(null, { status: 204 }));
        if (req.method !== "POST")    return cors(new Response("POST only", { status: 405 }));
        const body = await req.text();
        const r = await fetch("https://api.anthropic.com/v1/messages", {
          method: "POST",
          headers: {
            "content-type": "application/json",
            "x-api-key": env.ANTHROPIC_API_KEY,
            "anthropic-version": "2023-06-01"
          },
          body
        });
        return cors(new Response(r.body, r));
      }
    };
    function cors(res) {
      res.headers.set("Access-Control-Allow-Origin", "https://rafiarsya.com"); // or "*"
      res.headers.set("Access-Control-Allow-Headers", "content-type");
      res.headers.set("Access-Control-Allow-Methods", "POST, OPTIONS");
      return res;
    }

  Then in rafi-core.js set:
        var RAFI_API = "https://rafi-brain.<your-subdomain>.workers.dev";

  (Optional: route it under your domain via a Worker route, e.g.
   rafiarsya.com/api/rafi, and set RAFI_API = "/api/rafi".)


─── DEPENDENCIES ───────────────────────────────────────────────
  rafi-core.js self-loads KaTeX + marked from cdnjs at runtime.
  No build step, no npm. If offline, it degrades to plain text.


─── KNOBS (top of rafi-core.js) ────────────────────────────────
  RAFI_API   — where the brain lives
  MODEL      — claude-sonnet-4-6 (change if you like)
  SYSTEM     — RAFI's persona / instructions
  max_tokens — answer length cap (currently 4000)
════════════════════════════════════════════════════════════


─── v2 ADDITIONS ───────────────────────────────────────────────
  • Avatar + voice waveform in the panel header (like the old assistant).
  • Voice OUT: RAFI speaks each reply (browser SpeechSynthesis); the
    waveform animates while it talks. Toggle with the speaker button.
  • Voice IN: mic button in the composer (Web Speech API). Hidden if
    the browser doesn't support it.
  • EN / ID button: switches the language for both speaking & the mic.
  • Follow-up chips now appear after EVERY answer (RAFI proposes 3
    next questions itself). Click one to ask it instantly.
  Note: voice features need a browser that allows speech APIs and,
  for the mic, microphone permission + https (or localhost).
