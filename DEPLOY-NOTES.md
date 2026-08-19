# rafiarsya.com — chart fix + cleanup

## What changed
- **`js/va-interactive.js`** — rewrote the chart engine. It no longer loads Chart.js
  from `cdn.jsdelivr.net`. Charts are now drawn as **native inline SVG**, so they
  always render (online or offline, campus WiFi included). No more
  "Chart is loading or unavailable offline."
- Four distinct chart types so pages don't look identical:
  - **bar** — gradient columns + gridlines + hover tooltip (project 1,3,5,8,11,12)
  - **line** — smooth area fill + hover crosshair (project 4)
  - **doughnut** — arcs + center total + legend/percentages (project 2,13,14)
  - **radar** — rings + spokes + axis labels (project 10)
- Nothing else on the pages was touched. Blog charts already used the
  dependency-free `rafichart.js`, so they were fine.

## Deploy
Static site, no build step. From the project root:

```
npx wrangler pages deploy . --project-name=rafiarsya-com
```

### ⚠️ Heads-up on your repo state
In the snapshot you sent, `pages/`, `css/`, and `js/` are **untracked** in git,
while the OLD flat files (`blog.html`, `contact.html`, `projects/`, root `*.css`/`*.js`)
are the ones git tracks. So:
- If you deploy with **`wrangler pages deploy .`** (direct upload) → the fix ships fine.
- If rafiarsya.com deploys via **GitHub push** → you must `git add pages css js assets`
  first, or the new structure (and this fix) won't reach the server.

## Optional cleanup ("hal2 ga guna")
These root files are the OLD flat version — orphaned, not linked from `index.html`
(which points at `pages/`), and some have broken `../*.css` paths. Removing them
makes the deploy clean. Run from the project root only after you've confirmed your
live site uses the `pages/` structure (it does — index links there):

```bash
# stale duplicate HTML (superseded by pages/)
rm -f blog.html blog-campusbay.html blog-cropdisease.html blog-csastudy.html \
      blog-nase.html blog-papermind.html blog-rafifinance.html blog-sqlsteam.html \
      contact.html course.html resume.html
# stale flat-structure assets (superseded by css/ and js/)
rm -f rafi-core.css rafi-core.js rafichart.css rafichart.js script.js styles.css \
      va-assistant.css va-assistant.js va-interactive.css va-interactive.js
# stale project pages (superseded by pages/projects/)
rm -rf projects
# build cache — never deploy this
rm -rf .wrangler
```

The `rafiarsya-build/` folder in the zip is already the clean version (canonical
files only, fix applied) if you'd rather just deploy that directly.

## Not done (separate, optional)
- Math formulas (KaTeX) still load from the same CDN on a few project pages. They
  degrade to readable plain text if the CDN is blocked, so nothing looks broken —
  but if you want them bulletproof too, that's a separate self-host job.
- `index.html` hotlinks ~30 tech-stack logos from external CDNs (devicon, wikimedia,
  someone else's `rafidaffa.com`). Those can break independently of you. Worth
  self-hosting the logos into `assets/` at some point.
