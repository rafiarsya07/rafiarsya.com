function coursefunc() {
    /* ---- tabs ---- */
    var menuItems = document.querySelectorAll(".course-item");
    var sections = document.querySelectorAll(".menu-item-contentv2 > div");

    sections.forEach(function (s) {
        if (s.id !== "allcourse-content") s.classList.add("hidden");
    });
    menuItems.forEach(function (item) {
        item.addEventListener("click", function () {
            menuItems.forEach(function (m) { m.classList.remove("active"); });
            item.classList.add("active");
            sections.forEach(function (s) { s.classList.add("hidden"); });
            var target = document.getElementById(item.id + "-content");
            if (target) target.classList.remove("hidden");
        });
    });

    /* ---- data ---- */
    function tags(str) {
        if (!str) return "";
        return str.split(", ").map(function (t) {
            return '<span class="badge course-badge badge-neutral">' + t + "</span>";
        }).join("");
    }

    function status(text) {
        if (text === "Ongoing" || text === "Completed") return '<span class="badge course-date badge-green">' + text + "</span>";
        return '<span class="badge course-date badge-neutral">' + text + "</span>";
    }

    /* issuer logo, falling back to a monogram tile when we have no icon file */
    function issuerMark(course) {
        var initials = (course.issuer_name || course.issuer || "?")
            .split(/\s+/).map(function (w) { return w[0]; }).join("")
            .replace(/[^A-Za-z0-9]/g, "").slice(0, 2).toUpperCase();
        return '<img src="icon/' + course.issuer + '.png" alt="' + course.issuer_name + '" class="course-image" ' +
            'onerror="this.outerHTML=\'<span class=&quot;course-image course-mono&quot;>' + initials + '</span>\'" />';
    }

    function card(course, showStatus) {
        /* certificates ship a scan; university subjects do not */
        var shot = course.img
            ? '<div class="cert-shot"><img src="' + course.img + '" alt="' + course.title +
              '" loading="lazy" onerror="this.closest(\'.cert-shot\').remove()"></div>'
            : "";
        return '' +
            '<div class="col-12 col-sm-6 col-lg-4">' +
            '  <div class="course-card' + (shot ? " has-shot" : "") + ' d-flex align-content-between flex-wrap">' +
            shot +
            '    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between w100">' +
            issuerMark(course) +
            (showStatus ? status(course.subtitle) : "") +
            '    </div>' +
            '    <div>' +
            '      <div class="course-source">' + course.issuer_name +
            (showStatus ? "" : ' <span class="course-date">' + course.subtitle + "</span>") +
            '      </div>' +
            '      <div class="course-title">' + course.title + "</div>" +
            '      <div class="tech-stack">' + tags(course.tags) + "</div>" +
            '    </div>' +
            '  </div>' +
            "</div>";
    }

    fetch("data/courses.json")
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var sorted = data.sort(function (a, b) { return a.priority - b.priority; });
            var put = function (id, list, showStatus) {
                var el = document.getElementById(id);
                if (el) el.innerHTML = list.map(function (c) { return card(c, showStatus); }).join("");
            };
            put("course-container", sorted, true);
            put("uni-container", sorted.filter(function (c) { return c.type === "1"; }), false);
            put("othercourse-container", sorted.filter(function (c) { return c.type === "2"; }), false);
            put("doc-container", sorted.filter(function (c) { return c.type === "3"; }), false);
            bindCertZoom();
        })
        .catch(function (e) { console.error("course data:", e); });

    /* ---- click a certificate scan to see it full size ---- */
    function bindCertZoom() {
        document.querySelectorAll(".cert-shot img").forEach(function (img) {
            if (img.dataset.zoomBound) return;
            img.dataset.zoomBound = "1";
            img.addEventListener("click", function () {
                var overlay = document.createElement("div");
                overlay.className = "img-lightbox";
                overlay.innerHTML = '<img src="' + img.src + '" alt="' + img.alt + '">';
                overlay.addEventListener("click", function () { overlay.remove(); });
                document.addEventListener("keydown", function esc(e) {
                    if (e.key === "Escape") { overlay.remove(); document.removeEventListener("keydown", esc); }
                });
                document.body.appendChild(overlay);
            });
        });
    }
}
