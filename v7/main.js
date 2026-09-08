/* =========================================================
   main.js: the app shell
   The sidebar is rendered once and never re-rendered. Clicking
   a nav item fetches only that page's content fragment, swaps it
   into #main-content, caches it, and updates the URL. Back and
   forward work through popstate.
   ========================================================= */

/* ---------- pages that have a per-page init function ---------- */
var PAGE_SCRIPTS = {
    home: "home",
    course: "course",
    contact: "contact",
    blog: "blog"
};

/* every project page shares one script */
var PROJECT_PAGES = [
    "nalar", "papermind", "snip", "cropdisease", "arenaduel",
    "reminderme", "handgesture", "rafifinance", "nase", "briskwalk",
    "steamsql", "csastudy", "resumematch",
    "aievaldashboard", "pricetracker", "digitrecognition",
    "largenumber", "llmclassification", "idfest", "senara"
];

/* content/ is split into pages/ (site-level) and projects/ (case
   studies); this maps a page id to the subfolder its fragment lives
   in so the URL slugs above never have to change. */
var PAGE_CONTENT_DIR = {
    home: "pages", resume: "pages", contact: "pages", course: "pages", blog: "pages"
};
function contentPathFor(id) {
    var dir = PAGE_CONTENT_DIR[id] || "projects";
    return "content/" + dir + "/" + id + ".php";
}

/* ---------- sidebar drawer (mobile) ---------- */
function burgerToogle() {
    document.querySelector(".side-navbar").classList.toggle("show");
}

document.addEventListener("click", function (event) {
    if (event.target.closest(".burger-icon")) return;
    var navbar = document.querySelector(".side-navbar");
    if (!navbar) return;
    if (navbar.classList.contains("show") && window.innerWidth <= 1024) {
        if (!navbar.contains(event.target)) navbar.classList.remove("show");
    }
});

/* ---------- name in the sidebar shrinks to fit ---------- */
function adjustNameToFit(containerId) {
    var container = document.getElementById(containerId);
    if (!container) return;
    var fullName = container.getAttribute("data");
    var words = fullName.split(" ");
    container.textContent = fullName;
    while (container.scrollWidth > container.clientWidth && words.length > 1) {
        words.pop();
        container.textContent = words.join(" ");
    }
    if (container.scrollWidth > container.clientWidth) container.textContent = "";
}

function onresize() {
    var navbar = document.querySelector(".side-navbar");
    var webnameMobile = document.querySelector(".webname-mobile");
    if (!navbar || !webnameMobile) return;
    if (window.innerWidth > 1024) {
        navbar.classList.remove("show");
        navbar.style.transform = "translateX(0)";
        navbar.style.opacity = "1";
        webnameMobile.style.display = "none";
    } else {
        navbar.style.transform = "";
        navbar.style.opacity = "";
        webnameMobile.style.display = "block";
    }
}

adjustNameToFit("limit-word");
window.addEventListener("resize", function () { adjustNameToFit("limit-word"); });
window.addEventListener("resize", onresize);

/* ---------- fragment cache + script loader ---------- */
var pageCache = new Map();
var loadedScripts = {};

function loadScript(src, callback) {
    if (loadedScripts[src]) { callback(); return; }
    var script = document.createElement("script");
    script.src = src;
    script.onload = function () { loadedScripts[src] = true; callback(); };
    script.onerror = function () { console.warn("could not load", src); callback(); };
    document.head.appendChild(script);
}

/* which script + init function does this page need? */
function scriptFor(id) {
    if (PAGE_SCRIPTS[id]) return { file: PAGE_SCRIPTS[id], fn: PAGE_SCRIPTS[id] + "func" };
    if (PROJECT_PAGES.indexOf(id) !== -1) return { file: "project", fn: "projectfunc" };
    return null;
}

function runPageScript(id) {
    var spec = scriptFor(id);
    if (!spec) return;
    var run = function () {
        if (typeof window[spec.fn] === "function") {
            try { window[spec.fn](); } catch (e) { console.error(spec.fn, e); }
        }
    };
    if (typeof window[spec.fn] === "function") run();
    else loadScript("js/" + spec.file + ".js", run);
}

/* ---------- navigation ---------- */
function setActive(button) {
    var id = button.getAttribute("data-id");
    var state = window.history.state;
    if (state && state.pageId === id) return;

    document.querySelectorAll("#menu").forEach(function (b) { b.classList.remove("active"); });
    button.classList.add("active");

    loadContent(id);
    window.history.pushState({ pageId: id }, "", id === "home" ? "/" : "/" + id);

    /* on mobile the drawer sits over the page : close it once you've picked */
    if (window.innerWidth <= 1024) {
        document.querySelector(".side-navbar").classList.remove("show");
    }
}

function syncSidebar(id) {
    document.querySelectorAll("#menu").forEach(function (b) {
        b.classList.toggle("active", b.getAttribute("data-id") === id);
    });
}

function loadContent(id) {
    var host = document.getElementById("main-content");

    if (pageCache.has(id)) {
        host.innerHTML = pageCache.get(id);
        host.scrollTop = 0;
        runPageScript(id);
        return;
    }

    host.innerHTML =
        '<div class="page-loading"><span class="page-spinner"></span></div>';

    fetch(contentPathFor(id))
        .then(function (r) {
            if (!r.ok) throw new Error(r.status + " " + r.statusText);
            return r.text();
        })
        .then(function (data) {
            pageCache.set(id, data);
            host.innerHTML = data;
            host.scrollTop = 0;
            runPageScript(id);
        })
        .catch(function (err) {
            host.innerHTML =
                '<div class="page-loading"><div class="text-center">' +
                "<p><b>That page could not be loaded.</b></p>" +
                '<p class="text-silent">' + err.message + "</p>" +
                '<a href="/" class="btn btn-main button-border">Back home</a>' +
                "</div></div>";
        });
}

/* ---------- history ---------- */
window.addEventListener("popstate", function (event) {
    var id = (event.state && event.state.pageId) ||
        (window.location.pathname.replace(/^\/|\.php$/g, "") || "home");
    loadContent(id);
    syncSidebar(id);
});

/* ---------- first paint ---------- */
document.addEventListener("DOMContentLoaded", function () {
    var path = window.location.pathname;
    var id = (path === "/" || path === "/index.php") ?
        "home" :
        path.split("/").pop().replace(".php", "") || "home";

    /* the server already rendered this page, so only run its script */
    runPageScript(id);
    pageCache.set(id, document.getElementById("main-content").innerHTML);
    window.history.replaceState({ pageId: id }, "", id === "home" ? "/" : "/" + id);
    onresize();
});

/* ---------- inline SVG loader ----------
   Replaces <svg data-src="…"> with the file's own markup, so the
   social icons do not depend on a third-party script.            */
(function () {
    var cache = {};
    function swap(el) {
        var src = el.getAttribute("data-src");
        if (!src || el.dataset.svgDone) return;
        el.dataset.svgDone = "1";
        var apply = function (markup) {
            var doc = new DOMParser().parseFromString(markup, "image/svg+xml");
            var svg = doc.querySelector("svg");
            if (!svg) return;
            Array.prototype.forEach.call(el.attributes, function (a) {
                if (a.name !== "data-src") svg.setAttribute(a.name, a.value);
            });
            el.replaceWith(svg);
        };
        if (cache[src]) { apply(cache[src]); return; }
        fetch(src).then(function (r) { return r.text(); })
            .then(function (t) { cache[src] = t; apply(t); })
            .catch(function () {});
    }
    function scan() { document.querySelectorAll("svg[data-src]").forEach(swap); }
    if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", scan);
    else scan();
    new MutationObserver(scan).observe(document.documentElement, { childList: true, subtree: true });
})();
