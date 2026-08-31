function homefunc() {
    /* ---- blob: organic morphing avatar frame ---- */
    var blob = document.querySelector(".blob");
    if (blob) {
        var morph = function () {
            var r = function () { return 30 + Math.random() * 40; };
            blob.style.borderRadius =
                r() + "% " + r() + "% " + r() + "% " + r() + "% / " +
                r() + "% " + r() + "% " + r() + "% " + r() + "%";
        };
        morph();
        if (!window.__blobTimer) window.__blobTimer = setInterval(morph, 3000);
    }

    /* ---- skills tabs ---- */
    var tabs = document.querySelectorAll(".menu-item-content");
    document.querySelectorAll(".horizontal > .menu-item").forEach(function (item) {
        item.addEventListener("click", function () {
            var strip = item.parentElement;
            strip.querySelectorAll(".menu-item").forEach(function (i) { i.classList.remove("active"); });
            item.classList.add("active");
            tabs.forEach(function (box) {
                box.querySelectorAll(":scope > div").forEach(function (panel) {
                    panel.classList.toggle("hidden", panel.id !== item.id + "-content");
                });
            });
        });
    });

    /* ---- based toggle: current city / home city ----
       Only the map query and the label change; the map stays locked. */
    var sw = document.querySelector(".toogle-switch");
    if (sw && !sw.dataset.bound) {
        sw.dataset.bound = "1";
        var PLACES = {
            current: { q: "Petaling Jaya, Selangor, Malaysia", label: "Petaling Jaya, Selangor, Malaysia" },
            main:    { q: "Pekanbaru, Riau, Indonesia",        label: "Pekanbaru, Riau, Indonesia" }
        };
        var frame = document.getElementById("based-map");
        var label = document.getElementById("based-label");
        var currentText = document.getElementById("current-text");
        var mainText = document.getElementById("main-text");

        sw.addEventListener("click", function () {
            var next = sw.getAttribute("data-active") === "current" ? "main" : "current";
            sw.setAttribute("data-active", next);
            var place = PLACES[next];
            if (frame) {
                frame.src = "https://maps.google.com/maps?q=" +
                    encodeURIComponent(place.q) + "&z=12&output=embed";
            }
            if (label) label.textContent = place.label;
            if (currentText) currentText.classList.toggle("inactive", next !== "current");
            if (mainText) mainText.classList.toggle("inactive", next !== "main");
        });
    }
}
