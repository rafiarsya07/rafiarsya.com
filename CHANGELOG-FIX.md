# Portfolio fix — what changed

## 1. Justified body text, site-wide
New shared stylesheet `css/site-polish.css`, linked last on all 27 pages
(index + pages/ + pages/projects/).

Justification is applied only to running prose — bio paragraphs, entry
descriptions, project body copy, blog body text. Headings, captions,
tables, code blocks and UI labels stay left-aligned; justifying short
strings is what makes justified layouts look broken.

Two details that matter:
- `hyphens: auto` is on. English prose justified in a narrow column
  without hyphenation opens rivers of white space.
- Below 560px it falls back to ragged right. Phone-width columns are too
  narrow for justification to look deliberate.

## 2. Assets wired into project pages
Roughly 30 files in `assets/` were unused. They now appear as a new
section `02` on each page, with the sections below renumbered:

| Page | Project | Media |
|---|---|---|
| project1 | HandGesture | existing demo video, re-wrapped in the shared component |
| project2 | CampusBay | 6 screenshots + demo video + architecture PDF |
| project3 | NASE Accessibility | 5 screenshots + demo video |
| project4 | Crop Disease Detector | 2 leaf samples, 2 result screens, dataset + training charts, pipeline infographic |
| project5 | PaperMind | 3 screenshots, 2 chat bubbles, 2 demo videos |
| project6 | RafiFinance | all 7 phone screens |
| project7 | BriskWalk | registration form + event logo |

## 3. Assets wired into the blog
Each post exists twice — as a `<template>` in `blog.html` (cloned into a
shadow root by the desktop reader) and as a standalone page. Both copies
were updated for: campusbay, papermind, rafifinance, nase, cropdisease.

Blog media deliberately reuses the existing `.blog-img-wrap` /
`.blog-img-2col` / `.blog-video-wrap` classes rather than the new
component, because shadow roots don't inherit external stylesheets and
those classes are already defined inside every post's own `<style>`.

## 4. Blog reader was unreadable — fixed
The reader injected `max-width: none !important` onto `.blog-content`
and its children, so on a 1440px screen the text ran to roughly 1000px
per line. Sessions are now capped at 760px (measured: 741px actual)
while images may still run to 900px, since screenshots read better wide.

## 5. Dead icon markup replaced
`blog.html` referenced 56 Lucide icons via `<i data-lucide="...">`, but
Lucide is never loaded on any blog page — every one rendered as an empty
element. Replaced with inline SVG.

## 6. New shared component
`css/site-polish.css` + `js/site-polish.js` provide one figure / gallery
/ lightbox used across all project pages:
- click or keyboard-activate any screenshot to enlarge
- arrow keys and on-screen arrows move within a gallery, Escape closes
- the reader's shadow root is registered explicitly via
  `window.rfBindLightbox()`, since clicks inside a shadow tree don't
  surface a usable target to the document listener
- starting one video pauses any other that is playing

## 7. Folder cleanup
The archive contained `Unfinished Portfolio/Unfinished Portfolio/` (a
16 July snapshot) and `rafiarsya.com/` (only `.git` plus empty folders).
Both removed, along with `.git` and `.wrangler` caches.

## Verified
All 27 pages: no broken image references, no JS errors, no horizontal
overflow at 390px width.

## One thing to check
`assets/full_figma.png` is a Figma board whose project I could not
confirm from the file itself. I placed it in CampusBay (project2,
"Design board"). If it belongs to NASE instead, it's a one-line move.
