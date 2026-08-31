function blogfunc() {
    var container = document.getElementById("blog-container");
    if (!container) return;
    var cache = {};

    function render(id, html) {
        container.classList.remove("idle");
        container.innerHTML =
            '<div class="d-flex justify-content-center">' + html + "</div>";
        container.scrollTop = 0;
        if (typeof projectfunc === "function") projectfunc();
    }

    window.blogActive = function (button) {
        var id = button.getAttribute("data-id");
        document.querySelectorAll("#blogmenu").forEach(function (b) { b.classList.remove("active"); });
        button.classList.add("active");

        if (cache[id]) { render(id, cache[id]); return; }

        container.classList.remove("idle");
        container.innerHTML = '<div class="page-loading"><span class="page-spinner"></span></div>';

        fetch("content/blog/" + id + ".php")
            .then(function (r) {
                if (!r.ok) throw new Error(r.status);
                return r.text();
            })
            .then(function (html) { cache[id] = html; render(id, html); })
            .catch(function () {
                container.innerHTML =
                    '<div class="blog-empty"><p><b>That post could not be loaded.</b></p></div>';
            });
    };
}
