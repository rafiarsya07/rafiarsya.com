/* =========================================================
   blog.js: the reader

   A post is fetched once, cached, and rendered whole. It reads
   as one continuous page, top to bottom, with no page turns.

   What gets added around the fetched fragment:
     - on a phone, a way back to the post list, because the post
       covers the list at that width
     - a card at the end pointing at the next post
     - the site footer line
   ========================================================= */
function blogfunc() {
    var container = document.getElementById("blog-container");
    if (!container) return;

    var cache = {};
    var currentId = null;

    /* ---------- render a whole post ---------- */
    function renderPost(html) {
        var holder = document.createElement("div");
        holder.innerHTML = html;
        var source = holder.querySelector(".blog-content") || holder;

        var wrap = document.createElement("div");
        wrap.className = "d-flex justify-content-center";

        var article = document.createElement("div");
        article.className = "blog-content";

        article.appendChild(buildBackButton());
        Array.prototype.slice.call(source.childNodes).forEach(function (node) {
            article.appendChild(node.cloneNode(true));
        });

        var next = buildReadNext();
        if (next) article.appendChild(next);
        article.appendChild(buildFooter());

        wrap.appendChild(article);

        container.classList.remove("idle");
        container.innerHTML = "";
        container.appendChild(wrap);
        container.scrollTop = 0;

        if (typeof projectfunc === "function") projectfunc();
    }

    function buildBackButton() {
        var back = document.createElement("button");
        back.type = "button";
        back.className = "blog-back-mobile";
        back.innerHTML = '<span class="blog-chevron">&lsaquo;</span><span>All posts</span>';
        back.addEventListener("click", closePost);
        return back;
    }

    /* ---------- the next post in the list ---------- */
    function buildReadNext() {
        var buttons = Array.prototype.slice.call(document.querySelectorAll("#blogmenu"));
        if (buttons.length < 2) return null;

        var at = -1;
        buttons.forEach(function (b, i) {
            if (b.getAttribute("data-id") === currentId) at = i;
        });
        if (at === -1) return null;
        var target = buttons[(at + 1) % buttons.length];

        var badge = target.querySelector(".badge");
        var titleEl = target.querySelector(".blog-card-title");
        var dateEl = target.querySelector(".blog-card-date");

        var title = titleEl ? titleEl.textContent.trim() : "";
        var date = dateEl ? dateEl.textContent.trim() : "";

        /* a list card without the newer markup still has to work */
        if (!title) {
            Array.prototype.slice.call(target.childNodes).forEach(function (n) {
                if (n.nodeType === 3 && n.textContent.trim()) title += n.textContent.trim() + " ";
            });
            title = title.trim();
            var spans = target.querySelectorAll("span");
            if (!date && spans.length) date = spans[spans.length - 1].textContent.trim();
        }
        if (!title) return null;

        var box = document.createElement("div");
        box.className = "blog-readnext";
        box.innerHTML = '<div class="blog-readnext-kicker">Read next</div>';

        var card = document.createElement("button");
        card.type = "button";
        card.className = "blog-readnext-card";
        card.innerHTML =
            (badge ? badge.outerHTML : "") +
            '<span class="blog-readnext-title">' + title + "</span>" +
            '<span class="blog-readnext-date">' + date + "</span>" +
            '<span class="blog-chevron">&rsaquo;</span>';
        card.addEventListener("click", function () { window.blogActive(target); });

        box.appendChild(card);
        return box;
    }

    function buildFooter() {
        var footer = document.createElement("div");
        footer.className = "text-center text-silent text14 blog-footer";
        footer.innerHTML = "&#169; MUHAMMAD RAFI ARSYA";
        return footer;
    }

    function closePost() {
        document.querySelectorAll("#blogmenu").forEach(function (b) { b.classList.remove("active"); });
        currentId = null;
        container.classList.add("idle");
        container.innerHTML =
            '<div class="blog-empty">' +
            '<blog-icon style="--iconsize:34px;--iconcolor:#c9ccd1"></blog-icon>' +
            '<p style="margin-top:12px"><b>Select a post</b></p>' +
            '<p class="text14">Pick something from the list to read it here</p>' +
            "</div>";
    }

    window.blogActive = function (button) {
        var id = button.getAttribute("data-id");
        document.querySelectorAll("#blogmenu").forEach(function (b) { b.classList.remove("active"); });
        button.classList.add("active");
        currentId = id;

        if (cache[id]) { renderPost(cache[id]); return; }

        container.classList.remove("idle");
        container.innerHTML = '<div class="page-loading"><span class="page-spinner"></span></div>';

        fetch("content/blog/" + id + ".php")
            .then(function (r) {
                if (!r.ok) throw new Error(r.status);
                return r.text();
            })
            .then(function (html) { cache[id] = html; renderPost(html); })
            .catch(function () {
                container.innerHTML =
                    '<div class="blog-empty"><p><b>That post could not be loaded.</b></p></div>';
            });
    };
}
