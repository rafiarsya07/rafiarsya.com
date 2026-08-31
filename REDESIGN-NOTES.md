# Portfolio v4 — light editorial redesign

Full redesign of all 26 pages onto one design system. Content, links,
assets and page-specific interactivity are unchanged.

## Files

| File | Role |
|---|---|
| `css/rafi-editorial.css` | Design tokens, app shell, sidebar, home page |
| `css/rafi-editorial-pages.css` | Resume, course, blog, projects, contact + the fix layers below |
| `js/rafi-editorial.js` | Home page: drawer, skill tabs, location toggle, scroll reveal |

Kept and still wired up: `js/rafi-core.js` (JIN assistant),
`js/site-polish.js` (image lightbox), `js/reference-v3.js`,
`js/rafichart.js`, `js/va-interactive.js`, `js/img-fallback.js`, and
every inline script (accordions, math tabs, cert lightbox, contact form).

`css/styles.css`, `css/project-clean.css`, `css/site-polish.css` and
`js/script.js` are superseded, but are still loaded by the two hidden
CampusBay pages (`pages/blog-campusbay.html`,
`pages/projects/project2.html`) — don't delete them until those pages go.

## Design tokens

```
paper   #FCFCFB      ink     #17191C      rule    #E3E3DE
paper-2 #F5F5F2      ink-2   #4A4E54      accent  #1B4D8F
paper-3 #EFEFEB      ink-3   #8A9096      marker  #FCE7A0
```

Type: **Newsreader** (serif — names, titles) · **Instrument Sans**
(body) · **JetBrains Mono** (labels, dates, buttons, tags).

## Notes

- Section labels move into the left margin and go sticky at ≥1280px.
- Highlights (`<mark>`) render as a marker stroke. Inside a `.reveal`
  block they sweep in on scroll; everywhere else they show immediately.
- Colour-variant classes (`blog-tag.purple`, `blog-callout.amber`,
  `badge-udemy`, …) still work — they now all render in the one
  neutral treatment rather than six competing colours.
- `prefers-reduced-motion` and print styles are covered.

---

# Fix pass — Aug 2026

Audited all 26 pages rendered at 1440px and 390px. No broken asset
paths and no JavaScript errors were found; every problem was in the
CSS. Six changes, five of them in the shared stylesheet so they land
on every page at once.

## 1 · Legibility floor

Labels were set at 9 / 9.5 / 10 / 10.5px across the system — small
enough that hierarchy stopped reading and pages looked dense rather
than quiet. Raised to a floor of 11px, with the uppercase letterspaced
mono labels at 12px (12.5px under 720px) because they read smaller
than their px value. 55 declarations across four stylesheets, plus the
JIN widget in `rafi-core.css`.

## 2 · Touch targets

Sidebar links, back links, tab buttons, the certificate links and the
JIN teaser dismiss button all sat under 32px tall on mobile. Given a
40px floor under 720px (34px for the dismiss button and the CV contact
row). Inline `<code>` is sized in `em`, so inside a caption it fell to
9.7px — now floored with `max(.88em, 12px)`.

## 3 · The marker stroke

`<mark>` was drawn at `background-size: 100% 44%` anchored at 86%,
which clipped the letters through their middle and read as a
strike-through. Now `100% 80%` anchored at the bottom of the inline
box, so it sits behind the whole word like a highlighter.

## 4 · Project card footers

`.ap-card-cta` carried both an SVG arrow in the markup and an `::after`
arrow in CSS, so every card showed "Project Details → →". Dropped the
pseudo-element and animate the real SVG instead. The CTA is now
`nowrap` and the tech-stack line truncates, so "Project Details" no
longer breaks onto a second line (it did in 6 of 13 cards).

## 5 · Blog index rewritten

`pages/blog.html` was 398KB: every post was embedded twice over — once
as a standalone page, once as a `<template>` injected into a shadow
root by an in-place reader. The shadow root blocked the editorial CSS,
so a post read in the panel looked like a different site than the same
post opened on its own. Three of the six posts (PaperMind, Steam
Market Intelligence, CSA Study App) had templates but no entry in the
list, so they shipped to every visitor while being unreachable.

Replaced with a plain post index that links to the standalone pages,
which already carry the design system. **398KB → 24KB**, all six posts
listed, and there is now one copy of each post to maintain.

## 6 · Contact page

Carried an 11.5KB inline `<style>` block of pre-v4 CSS — hardcoded
hex colours, 12px rounded boxes, `font-weight: 800`, blue and green
icon tiles. It loaded after the stylesheets and so won every conflict,
which is why the page looked unlike the rest of the site. Removed; the
editorial rules for `.contact-*` were already in
`rafi-editorial-pages.css` and simply took over. **39KB → 27KB**.

## Checked and left alone

- **`project5` horizontal scroll.** `.p-pipeline` is 1158px wide inside
  a 346px scroller — that is the intended swipe-to-explore diagram, and
  `body { overflow-x: clip }` means the page itself never moves.
  `scrollWidth` reports 443 but `window.scrollX` stays 0.
- **Inline `<a>` under 32px** in project3 / 6 / 9 prose — these are
  links inside running text; a 40px box would break the line rhythm.
- **The 10px readout in the RafiFinance mock** (project6) is part of a
  reproduction of the app's own UI, not site chrome.
- **The two CampusBay pages** are hidden (noindex + redirect) and still
  on the pre-v4 stack. Migrating them buys nothing while they stay
  hidden, but it is what stops `styles.css` and friends being deleted.
