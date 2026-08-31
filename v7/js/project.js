/* =========================================================
   project.js, behaviour shared by every project page.
   Runs on first paint and again whenever the app shell swaps
   a project page into #main-content.
   ========================================================= */
function projectfunc() {

    /* ---- tabbed formula / query blocks ---- */
    document.querySelectorAll(".p-math-block").forEach(function (block) {
        if (block.dataset.bound) return;
        block.dataset.bound = "1";

        var tabs = block.querySelectorAll(".p-math-tab");
        var panels = block.querySelectorAll(".p-math-panel");
        if (!tabs.length || !panels.length) return;

        tabs.forEach(function (tab) {
            tab.addEventListener("click", function () {
                var name = tab.getAttribute("data-tab");
                tabs.forEach(function (t) { t.classList.toggle("active", t === tab); });
                panels.forEach(function (p) {
                    p.classList.toggle("active", p.getAttribute("data-panel") === name);
                });
            });
        });
    });

    /* a block with tabs but no panel marked active would render blank */
    document.querySelectorAll(".p-math-block").forEach(function (block) {
        var panels = block.querySelectorAll(".p-math-panel");
        if (panels.length && !block.querySelector(".p-math-panel.active")) {
            panels[0].classList.add("active");
        }
    });

    /* ---- the SQL console, when this page has one ---- */
    if (document.getElementById("console-run")) {
        if (typeof consolefunc === "function") consolefunc();
        else {
            var s = document.createElement("script");
            s.src = "js/console.js";
            s.onload = function () {
                if (typeof consolefunc === "function") consolefunc();
            };
            document.head.appendChild(s);
        }
    }

    /* ---- click a screenshot to see it full size ---- */
    document.querySelectorAll(".blog-img, .blog-main-img, .rf-figure img, .rf-figure-lg img").forEach(function (img) {
        if (img.dataset.zoomBound) return;
        img.dataset.zoomBound = "1";
        img.style.cursor = "zoom-in";
        img.addEventListener("click", function () {
            var overlay = document.createElement("div");
            overlay.className = "img-lightbox";
            overlay.innerHTML = '<img src="' + img.src + '" alt="">';
            overlay.addEventListener("click", function () { overlay.remove(); });
            document.addEventListener("keydown", function esc(e) {
                if (e.key === "Escape") { overlay.remove(); document.removeEventListener("keydown", esc); }
            });
            document.body.appendChild(overlay);
        });
    });
}
