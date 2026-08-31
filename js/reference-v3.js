(function () {
  'use strict';

  var covers = {
    'ThoughtLog': null,
    'Snip URL Shortener': null,
    'PaperMind': '../../assets/chat-pages-rag.png',
    'Arena Duel': null,
    'Reminder Me — Pendamping': null,
    'HandGesture': '../../assets/cover-handgesture.jpg',
    'Crop Disease Detector': '../../assets/result-diseased.png',
    'RafiFinance': '../../assets/foto-finance1.png',
    'NASE Accessibility': '../../assets/cover-nase.jpg',
    'BriskWalk Registration': '../../assets/briswalk_form.png',
    'Steam Market Intelligence': null,
    'CSA Study App': null,
    'Resume Match': null
  };

  function initials(name) {
    return name.split(/\s+/).filter(Boolean).map(function (word) { return word[0]; }).join('').replace(/[^A-Z0-9]/gi, '').slice(0, 3).toUpperCase();
  }

  function enhanceProjectCards() {
    var cards = document.querySelectorAll('.ap-card');
    if (!cards.length) return;

    cards.forEach(function (card) {
      var nameEl = card.querySelector('.ap-card-name');
      var inner = card.querySelector('.ap-card-inner');
      if (!nameEl || !inner || inner.querySelector('.ap-card-media')) return;

      var name = nameEl.textContent.trim();
      var media = document.createElement('div');
      media.className = 'ap-card-media';

      if (covers[name]) {
        var image = document.createElement('img');
        image.src = covers[name];
        image.alt = name + ' project documentation';
        image.loading = 'lazy';
        image.decoding = 'async';
        media.appendChild(image);
      } else {
        media.classList.add('placeholder');
        var label = document.createElement('span');
        label.textContent = initials(name);
        media.appendChild(label);
      }
      inner.insertBefore(media, inner.firstChild);

      if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

      var frame = 0;
      card.addEventListener('mousemove', function (event) {
        if (frame) cancelAnimationFrame(frame);
        frame = requestAnimationFrame(function () {
          var rect = card.getBoundingClientRect();
          var x = Math.max(0, Math.min(rect.width, event.clientX - rect.left));
          var y = Math.max(0, Math.min(rect.height, event.clientY - rect.top));
          var rotateY = ((x / rect.width) - .5) * 4.2;
          var rotateX = (.5 - (y / rect.height)) * 3.4;
          card.style.setProperty('--mx', x + 'px');
          card.style.setProperty('--my', y + 'px');
          card.style.setProperty('--rx', rotateX.toFixed(2) + 'deg');
          card.style.setProperty('--ry', rotateY.toFixed(2) + 'deg');
        });
      });
      card.addEventListener('mouseleave', function () {
        if (frame) cancelAnimationFrame(frame);
        card.style.setProperty('--rx', '0deg');
        card.style.setProperty('--ry', '0deg');
      });
    });
  }

  function revealSections() {
    var items = document.querySelectorAll('.home-section, .entry-item, .ap-section, .project-main section, .cert-card, .cv-section, .contact-card');
    if (!items.length) return;
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      items.forEach(function (item) { item.classList.add('rf-visible'); });
      return;
    }
    items.forEach(function (item) { item.classList.add('rf-reveal'); });
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('rf-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: .08, rootMargin: '0px 0px -24px' });
    items.forEach(function (item) { observer.observe(item); });
  }

  function markCurrentPage() {
    var here = location.pathname.split('/').pop() || 'index.html';
    var matched = false;
    document.querySelectorAll('.sidebar a[href]').forEach(function (link) {
      var href = link.getAttribute('href').split('#')[0].split('?')[0];
      if (href.split('/').pop() === here) {
        link.setAttribute('aria-current', 'page');
        matched = true;
      }
    });
    if (!matched && /^project\d+\.html$/.test(here)) {
      var archive = Array.from(document.querySelectorAll('.sidebar a[href]')).find(function (link) {
        return link.getAttribute('href').split('#')[0].split('?')[0].split('/').pop() === 'projects.html';
      });
      if (archive) archive.setAttribute('aria-current', 'page');
    }
  }

  function localSkillFallbacks() {
    document.querySelectorAll('.skill-icon-item img').forEach(function (img) {
      img.addEventListener('error', function () {
        img.style.display = 'none';
        var item = img.closest('.skill-icon-item');
        if (item && !item.querySelector('.rf-skill-fallback')) {
          var fallback = document.createElement('strong');
          fallback.className = 'rf-skill-fallback';
          fallback.textContent = initials(img.alt || 'Skill').slice(0, 2);
          fallback.style.cssText = 'display:grid;place-items:center;width:28px;height:28px;border-radius:7px;background:#eceef1;color:#60646b;font-size:10px';
          item.insertBefore(fallback, item.firstChild);
        }
      }, { once: true });
    });
  }

  function boot() {
    markCurrentPage();
    enhanceProjectCards();
    revealSections();
    localSkillFallbacks();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
