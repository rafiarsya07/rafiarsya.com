/* =========================================================
   contact.js
   The form does not post anywhere. On submit it opens the
   visitor's own mail app with a message addressed straight to
   rafiarsya.work@gmail.com, so nothing passes through a
   third-party form service.
   ========================================================= */
var CONTACT_EMAIL = "rafiarsya.work@gmail.com";

function contactfunc() {
    var form = document.getElementById("contactForm");
    if (!form) return;

    /* textarea grows with its content */
    var area = document.getElementById("autoExpandTextarea");
    if (area) {
        var grow = function () {
            area.style.height = "auto";
            area.style.height = Math.min(area.scrollHeight, 320) + "px";
        };
        area.addEventListener("input", grow);
        grow();
    }

    var status = document.getElementById("contactStatus");
    var button = document.getElementById("submitContact");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        var name = form.querySelector("[name=name]").value.trim();
        var email = form.querySelector("[name=email]").value.trim();
        var message = form.querySelector("[name=message]").value.trim();

        if (!name || !email || !message) {
            status.textContent = "Please fill in your name, email and message.";
            return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            status.textContent = "That email address does not look right.";
            return;
        }

        var subject = "Portfolio message from " + name;
        var body = message + "\n\n" + name + "\n" + email;

        window.location.href = "mailto:" + CONTACT_EMAIL +
            "?subject=" + encodeURIComponent(subject) +
            "&body=" + encodeURIComponent(body);

        status.innerHTML = 'Opening your email app. If nothing happens, write to ' +
            '<a href="mailto:' + CONTACT_EMAIL + '" class="hrefnocolor"><b>' +
            CONTACT_EMAIL + "</b></a> directly.";
        button.textContent = "Sent to your email app";
    });
}
