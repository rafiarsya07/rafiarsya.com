# Portfolio v7: PHP app-shell

Rebuilt to follow the structure and visual language of rafidaffa.com,
filled with Muhammad Rafi Arsya's own content. Nothing outside `v7/`
was touched; the v4 static site in the repo root still works.

## How it works

`index.php` (and one entry file per page) renders the shell server-side:
`conf.php` → `sidebar.php` → `content/<page>.php`. From then on the
sidebar never re-renders. `main.js` intercepts nav clicks, fetches only
`content/<page>.php`, swaps it into `#main-content`, caches the HTML in a
`Map`, and calls `history.pushState`. Back and forward are handled by
`popstate`, and a revisit is served from cache with no second request.

Per-page behaviour lives in `js/<page>.js` and is loaded on demand:
`homefunc`, `coursefunc`, `contactfunc`, `blogfunc`, and `projectfunc`
(shared by every project page).

`.htaccess` rewrites `/resume` to `/resume.php`, so URLs stay extensionless.
Every route's entry file stays flat at the project root (URLs never
change) and just `include()`s its content fragment from a subfolder —
see Layout below.

## Layout

```
v7/
  index.php  blog.php  resume.php  course.php  contact.php  project.php
  <project entry files>.php    (one per project, all at root — these are the URLs)
  sidebar.php  conf.php.htaccess
  main.css  main.js  icon.js
  content/
    pages/            site-level fragments: home, resume, contact, course, blog
    projects/          one fragment per project (incl. project.php, the "All Projects" grid)
    blog/              the actual blog post write-ups, fetched by js/blog.js
  js/                 per-page scripts
  data/               courses.json · projects.json · blog.json
  image/
    assets/<project>/ screenshots & media, grouped per project
    cert/              certificate scans (course.php)
  icon/  skills/  resources/
```

`main.js`'s `PAGE_CONTENT_DIR` map (and the matching logic in
`build-static.py`) is what resolves a page id to `pages/` or
`projects/` — add a new page id there if you add a new site-level
page; anything else defaults to `projects/`.

## Data

Content is data, not markup, wherever it repeats:

- `data/courses.json`: 33 entries (12 UM subjects, 18 courses, 3 awards).
  `js/course.js` renders and filters them. Replaces the reference's call
  to an external API with a local file.
- `data/projects.json`: the 13 projects, used to build the grid.
- `data/blog.json`: the post index; `content/blog.php` reads it in PHP.

Adding a course or a post is a JSON edit, not an HTML edit.

## Deploying

**This needs PHP hosting.** Cloudflare Pages serves static files only and
will hand visitors the raw PHP source. Any shared host with PHP 8 and
`mod_rewrite` works, as do Hostinger, Niagahoster, Railway and Fly.io.
Upload the contents of `v7/` to the web root and confirm `.htaccess` is
being read.

Bootstrap 5.3.3 comes from jsDelivr, as in the reference. To drop that
dependency, put `bootstrap.min.css` and `bootstrap.bundle.min.js` in
`vendor/` and point the `<link>` and `<script>` in each entry file there.

jQuery and the unpkg SVG loader were removed: nothing used jQuery, and
the SVG loader is now ~20 lines at the bottom of `main.js`.

## Still to add

- Cover images for ThoughtLog, snip, Arena Duel, Reminder Me, Steam
  Market Intelligence, CSA Study App and Resume Match. Until they exist
  each card shows an initials tile, which is also what the v4 site did.
- Issuer logos `icon/udemy.png`, `icon/freecodecamp.png`,
  `icon/dicoding.png`, `icon/other.png`. Same fallback applies.

## Carried over from the v4 write-ups

The tabbed formula blocks (Query / Explained / Worked Example) and the
sample-query SQL console both work. Their markup is preserved verbatim by
the converter, styled in `main.css`, and wired up in `js/project.js`;
the console's query result sets live in `js/console.js`.

Title-and-description pairs (features, engineering decisions, use cases,
architecture rows) are converted into real lists, and tech-stack pills
into badges, so nothing collapses into a run-on paragraph.

Still not carried over: the SVG charts and the pipeline diagram, which
each need their own script.

## House style

No en or em dashes anywhere in the copy. Where the v4 text used one it is
now a comma, a colon, or a new sentence, and date ranges read as
"Since 2025" or "2022 to 2025". The only remaining hyphens are minus
signs inside formulas and code, which have to stay.

## Checked

All 19 pages were rendered against a real PHP server at 1440×900 and
390×844: every page returns 200, no page scrolls horizontally, there are
no JavaScript errors, and no text renders below 11px. Navigation was
tested end to end: fragment fetch, URL update, back button, sidebar
sync, and cache hit on revisit.
