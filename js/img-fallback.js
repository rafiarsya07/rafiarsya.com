/* ══════════════════════════════════════════════════════════════════════
   img-fallback.js
   index.html hotlinks ~47 tech-stack logos from third-party CDNs
   (gstatic image cache, simpleicons, wikimedia, someone else's domain).
   Any of those can 404, expire, or be blocked on a restricted network —
   and the page then paints a broken-image icon and the icon grid jumps.

   This swaps any failed image for a monogram tile built from its alt
   text, so the layout stays intact and the skill is still readable.
   Handles images that failed BEFORE this script ran, too.
   ══════════════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    function monogram(text) {
        var words = String(text || '?')
            .replace(/[^\w\s.+#/-]/g, ' ')
            .trim()
            .split(/[\s/-]+/)
            .filter(Boolean);
        if (!words.length) return '?';
        if (words.length === 1) return words[0].slice(0, 2);
        return (words[0][0] + words[1][0]);
    }

    function replace(img) {
        if (img.dataset.fallbackApplied) return;

        // Entry logos already have their own inline onerror handler.
        if (img.closest('.entry-logo')) return;

        // Placeholder <img> with no src yet (e.g. #lightbox-img, populated by
        // JS on open). These report naturalWidth === 0 but have NOT failed —
        // replacing them would destroy an element other scripts reference.
        var src = img.getAttribute('src');
        if (!src) return;

        // Anything another script looks up by id must stay in the DOM.
        if (img.id) return;

        img.dataset.fallbackApplied = '1';

        var tile = document.createElement('div');
        tile.className = 'icon-fallback';
        tile.textContent = monogram(img.getAttribute('alt'));
        tile.title = img.getAttribute('alt') || '';
        if (img.parentNode) img.parentNode.replaceChild(tile, img);
    }

    function scan() {
        var imgs = document.querySelectorAll('img');
        for (var i = 0; i < imgs.length; i++) {
            var img = imgs[i];
            // already finished loading and came back empty => it failed
            if (img.complete && img.naturalWidth === 0) {
                replace(img);
            } else if (!img.dataset.fallbackBound) {
                img.dataset.fallbackBound = '1';
                img.addEventListener('error', function () { replace(this); });
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', scan);
    } else {
        scan();
    }
    // lazy-loaded images resolve later; re-check once everything settles
    window.addEventListener('load', scan);
})();
