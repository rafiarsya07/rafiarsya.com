/* ============================================================
   SITE POLISH — lightbox for .rf-shot figures.

   Delegated from document so it also picks up figures that are
   injected later (the blog reader clones its posts in at click
   time). Shadow roots are registered explicitly via
   window.rfBindLightbox(root) since events from a closed tree
   don't reach here with a usable target.
   ============================================================ */
(function () {
  'use strict';
  if (window.__RF_LIGHTBOX__) return;
  window.__RF_LIGHTBOX__ = true;

  var box, imgEl, capEl, group = [], index = 0;

  function build() {
    if (box) return;
    box = document.createElement('div');
    box.className = 'rf-lb';
    box.setAttribute('role', 'dialog');
    box.setAttribute('aria-modal', 'true');
    box.setAttribute('aria-label', 'Image viewer');
    box.innerHTML =
      '<button class="rf-lb-close" type="button" aria-label="Close">&times;</button>' +
      '<button class="rf-lb-nav rf-lb-prev" type="button" aria-label="Previous">&#8249;</button>' +
      '<img alt="">' +
      '<button class="rf-lb-nav rf-lb-next" type="button" aria-label="Next">&#8250;</button>' +
      '<div class="rf-lb-cap"></div>';
    document.body.appendChild(box);

    imgEl = box.querySelector('img');
    capEl = box.querySelector('.rf-lb-cap');

    box.querySelector('.rf-lb-close').addEventListener('click', close);
    box.querySelector('.rf-lb-prev').addEventListener('click', function (e) {
      e.stopPropagation(); step(-1);
    });
    box.querySelector('.rf-lb-next').addEventListener('click', function (e) {
      e.stopPropagation(); step(1);
    });
    box.addEventListener('click', function (e) {
      if (e.target === box) close();
    });
  }

  function show(i) {
    index = (i + group.length) % group.length;
    var item = group[index];
    imgEl.src = item.src;
    imgEl.alt = item.alt || '';
    capEl.textContent = item.cap || '';
    var many = group.length > 1;
    box.querySelector('.rf-lb-prev').style.display = many ? '' : 'none';
    box.querySelector('.rf-lb-next').style.display = many ? '' : 'none';
  }

  function step(d) { if (group.length) show(index + d); }

  function close() {
    if (!box) return;
    box.classList.remove('open');
    document.body.classList.remove('rf-lb-open');
    imgEl.src = '';
  }

  /* Two markups feed the lightbox: .rf-shot figures on the project
     pages, and the blog's own .blog-img-wrap. Both resolve to "an
     img with a caption next to it". */
  var SHOT = '.rf-shot, .blog-img-wrap';
  var ALL = '.rf-shot img, .blog-img-wrap img';

  function captionOf(im) {
    var fig = im.closest('.rf-figure') || im.closest('.blog-img-wrap');
    var cap = fig && fig.querySelector('.rf-cap, .blog-img-caption');
    if (!cap) return im.alt;
    /* The caption is <b>Label</b><span>Text</span>; textContent would
       run them together ("HomeLanding page"). Join the parts instead. */
    var parts = [];
    Array.prototype.forEach.call(cap.children, function (c) {
      var t = c.textContent.trim();
      if (t) parts.push(t);
    });
    if (!parts.length) parts.push(cap.textContent.trim());
    return parts.join(' — ');
  }

  /* Collect every shot in the same gallery so arrows work. */
  function open(shot, root) {
    build();
    var scope = shot.closest('.rf-grid') || shot.closest('.rf-media') ||
                shot.closest('.blog-img-2col') || shot.closest('.blog-section') || root;
    var shots = scope ? scope.querySelectorAll(ALL) : [shot.querySelector('img')];

    group = [];
    var start = 0;
    Array.prototype.forEach.call(shots, function (im, i) {
      group.push({
        src: im.currentSrc || im.src,
        alt: im.alt,
        cap: captionOf(im)
      });
      if (shot.contains(im)) start = i;
    });

    if (!group.length) return;
    show(start);
    box.classList.add('open');
    document.body.classList.add('rf-lb-open');
    box.querySelector('.rf-lb-close').focus();
  }

  function handler(root) {
    return function (e) {
      var shot = e.target.closest && e.target.closest(SHOT);
      if (!shot || !shot.querySelector('img')) return;
      e.preventDefault();
      open(shot, root);
    };
  }

  document.addEventListener('click', handler(document));

  /* Blog reader mounts posts inside a shadow root — bind there too. */
  window.rfBindLightbox = function (root) {
    if (!root || root.__rfBound) return;
    root.__rfBound = true;
    root.addEventListener('click', handler(root));
  };

  document.addEventListener('keydown', function (e) {
    if (!box || !box.classList.contains('open')) return;
    if (e.key === 'Escape') close();
    else if (e.key === 'ArrowLeft') step(-1);
    else if (e.key === 'ArrowRight') step(1);
  });

  /* Pause any other playing video when one starts — several project
     pages now carry two or three demo clips in the same column. */
  document.addEventListener('play', function (e) {
    if (e.target.tagName !== 'VIDEO') return;
    document.querySelectorAll('video').forEach(function (v) {
      if (v !== e.target && !v.paused) v.pause();
    });
  }, true);
})();
