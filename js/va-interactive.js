/* ============================================================
   VA-INTERACTIVE  —  per-page interactive chart + widget + refs
   Driven by window.VA_PAGE_DATA defined inline on each page.
   Renders into <div id="va-interactive"></div>.
   Chart.js loaded on demand from CDN.
   ============================================================ */
(function () {
  'use strict';
  var DATA = window.VA_PAGE_DATA;
  var mount = document.getElementById('va-interactive');
  if (!DATA || !mount) return;

  /* ---- read theme from page CSS variables ---- */
  function cssVar(name, fallback) {
    var v = window.getComputedStyle(document.documentElement).getPropertyValue(name);
    if (!v) v = window.getComputedStyle(document.body).getPropertyValue(name);
    return (v && v.trim()) || fallback;
  }
  var THEME = {};
  function readTheme() {
    THEME.hi = cssVar('--hi', '#111827');
    THEME.body = cssVar('--body', '#374151');
    THEME.sub = cssVar('--sub', '#6b7280');
    THEME.muted = cssVar('--muted', '#9ca3af');
    THEME.line = cssVar('--line', '#e5e7eb');
    THEME.bg2 = cssVar('--bg2', '#ffffff');
  }

  function toRGB(c) {
    c = (c || '').trim();
    if (c[0] === '#') {
      if (c.length === 4) c = '#' + c[1] + c[1] + c[2] + c[2] + c[3] + c[3];
      var n = parseInt(c.slice(1), 16);
      return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
    }
    var m = c.match(/\d+/g);
    return m ? [+m[0], +m[1], +m[2]] : [17, 24, 39];
  }
  function rgba(c, a) { var r = toRGB(c); return 'rgba(' + r[0] + ',' + r[1] + ',' + r[2] + ',' + a + ')'; }
  function mix(c, t, amt) { var a = toRGB(c), b = toRGB(t); return 'rgb(' + a.map(function (v, i) { return Math.round(v + (b[i] - v) * amt); }).join(',') + ')'; }

  // cohesive monochrome-accent palette derived from the page heading colour
  function palette(n) {
    var base = THEME.hi || '#111827';
    var stops = [base, mix(base, THEME.muted, 0.45), mix(base, THEME.muted, 0.7), mix(base, THEME.bg2, 0.55), mix(base, THEME.muted, 0.25), mix(base, THEME.bg2, 0.3)];
    var out = []; for (var i = 0; i < n; i++) out.push(stops[i % stops.length]);
    return out;
  }

  /* ---- element helpers ---- */
  function el(tag, cls, html) { var e = document.createElement(tag); if (cls) e.className = cls; if (html != null) e.innerHTML = html; return e; }

  /* ============ CHART RENDERER (dependency-free inline SVG) ============
     Renders bar / line / doughnut / pie / radar as native SVG — no CDN,
     always renders online or offline. Each type has its own distinct look,
     scroll-triggered animation, and hover tooltip.
     ==================================================================== */
  var SVGNS = 'http://www.w3.org/2000/svg';
  function svel(tag, attrs) {
    var e = document.createElementNS(SVGNS, tag);
    if (attrs) for (var k in attrs) e.setAttribute(k, attrs[k]);
    return e;
  }
  function fmtNum(v) {
    if (v == null || isNaN(v)) return '' + v;
    if (Math.abs(v) >= 1000) return v.toLocaleString();
    return (Math.round(v * 100) / 100) + '';
  }
  function niceMax(m) {
    if (m <= 0) return 1;
    var pow = Math.pow(10, Math.floor(Math.log10(m)));
    var n = m / pow;
    var step = n <= 1 ? 1 : n <= 2 ? 2 : n <= 5 ? 5 : 10;
    return step * pow;
  }
  // shared tooltip attached to a wrap element. Callers pass viewBox coords;
  // helper converts to pixels using the current SVG scale.
  function mkTip(wrap, vbW) {
    var tip = el('div', 'vai-svg-tip');
    tip.style.cssText = 'position:absolute;pointer-events:none;opacity:0;transform:translate(-50%,-118%);transition:opacity .12s;background:' +
      THEME.hi + ';color:' + THEME.bg2 + ';padding:7px 11px;border-radius:8px;font:600 12.5px/1.3 "IBM Plex Sans",sans-serif;white-space:nowrap;z-index:5;box-shadow:0 6px 20px rgba(0,0,0,.16)';
    wrap.appendChild(tip);
    return {
      show: function (html, vbx, vby) {
        tip.innerHTML = html; tip.style.opacity = '1';
        var scale = wrap.clientWidth / vbW;
        var x = vbx * scale, y = vby * scale;
        var wr = wrap.getBoundingClientRect();
        tip.style.left = Math.max(4, Math.min(wr.width - 4, x)) + 'px';
        tip.style.top = y + 'px';
      },
      hide: function () { tip.style.opacity = '0'; }
    };
  }
  function whenVisible(node, cb) {
    if (!('IntersectionObserver' in window)) { cb(); return; }
    var seen = false;
    var io = new IntersectionObserver(function (ents) {
      ents.forEach(function (e) { if (e.isIntersecting && !seen) { seen = true; cb(); io.disconnect(); } });
    }, { threshold: 0.2 });
    io.observe(node);
  }

  function renderChart(cfg, host) {
    readTheme();
    var card = el('div', 'vai-card');
    card.appendChild(el('div', 'vai-title', cfg.title || 'Data'));
    if (cfg.desc) card.appendChild(el('div', 'vai-desc', cfg.desc));
    var wrap = el('div', 'vai-canvas-wrap');
    wrap.style.height = 'auto';  // let inline-SVG define height via aspect ratio (no clipping)
    card.appendChild(wrap); host.appendChild(card);

    var type = cfg.type || 'bar';
    try {
      if (type === 'bar') barSVG(cfg, wrap);
      else if (type === 'line') lineSVG(cfg, wrap);
      else if (type === 'pie' || type === 'doughnut') pieSVG(cfg, wrap, type === 'doughnut');
      else if (type === 'radar') radarSVG(cfg, wrap);
      else barSVG(cfg, wrap);
    } catch (err) {
      wrap.innerHTML = '<div class="vai-fallback">' + (cfg.labels || []).map(function (l, i) {
        var d = (cfg.datasets && cfg.datasets[0] && cfg.datasets[0].data[i]);
        return l + (d != null ? ': ' + d : '');
      }).join(' · ') + '</div>';
    }
  }

  /* ---- multi-series legend chip row ---- */
  function legendRow(card, entries) {
    if (entries.length < 2) return;
    var row = el('div');
    row.style.cssText = 'display:flex;flex-wrap:wrap;gap:8px 18px;margin-bottom:14px';
    entries.forEach(function (e) {
      var it = el('div');
      it.style.cssText = 'display:inline-flex;align-items:center;gap:7px;font:500 12.5px "IBM Plex Sans",sans-serif;color:' + THEME.body;
      var sw = el('span'); sw.style.cssText = 'width:11px;height:11px;border-radius:3px;background:' + e.color;
      it.appendChild(sw); it.appendChild(document.createTextNode(e.label));
      row.appendChild(it);
    });
    return row;
  }

  /* ================= BAR (vertical, grouped, gradient) ================= */
  function barSVG(cfg, wrap) {
    var W = 720, H = 260, PL = 44, PR = 14, PT = 16, PB = 34;
    var labels = cfg.labels || [], sets = cfg.datasets || [];
    var cols = palette(sets.length);
    var flat = []; sets.forEach(function (s) { (s.data || []).forEach(function (v) { flat.push(v); }); });
    var dmax = cfg.yMax != null ? cfg.yMax : niceMax(Math.max.apply(null, flat.concat([1])));
    var dmin = cfg.yMin != null ? cfg.yMin : Math.min(0, Math.min.apply(null, flat.concat([0])));
    var PW = W - PL - PR, PH = H - PT - PB;
    var yAt = function (v) { return PT + (1 - (v - dmin) / (dmax - dmin || 1)) * PH; };

    // legend for multi-series
    var lg = legendRow(wrap.parentNode, sets.map(function (s, i) { return { label: s.label || 'Series ' + (i + 1), color: cols[i] }; }));
    if (lg) wrap.parentNode.insertBefore(lg, wrap);

    var svg = svel('svg', { viewBox: '0 0 ' + W + ' ' + H, preserveAspectRatio: 'xMidYMid meet', style: 'display:block;width:100%;height:auto' });
    var defs = svel('defs', {});
    sets.forEach(function (s, i) {
      var g = svel('linearGradient', { id: 'bg' + i + '-' + Math.random().toString(36).slice(2, 6), x1: 0, y1: 0, x2: 0, y2: 1 });
      g.setAttribute('data-i', i);
      var a = svel('stop', { offset: '0%', 'stop-color': cols[i], 'stop-opacity': '0.95' });
      var b = svel('stop', { offset: '100%', 'stop-color': cols[i], 'stop-opacity': '0.5' });
      g.appendChild(a); g.appendChild(b); defs.appendChild(g); s._gid = g.id;
    });
    svg.appendChild(defs);

    // gridlines + y ticks
    for (var t = 0; t <= 4; t++) {
      var gv = dmin + (dmax - dmin) * t / 4, gy = yAt(gv);
      svg.appendChild(svel('line', { x1: PL, x2: PL + PW, y1: gy.toFixed(1), y2: gy.toFixed(1), stroke: rgba(THEME.line, 0.9), 'stroke-width': 1 }));
      var tx = svel('text', { x: PL - 8, y: (gy + 3.5).toFixed(1), 'text-anchor': 'end', fill: THEME.sub, 'font-family': "'IBM Plex Mono',monospace", 'font-size': 10 });
      tx.textContent = fmtNum(gv); svg.appendChild(tx);
    }

    var n = labels.length, groupW = PW / n, innerN = sets.length;
    var bw = Math.min(52, (groupW * 0.62) / innerN);
    var bars = [];
    var tip = mkTip(wrap, W);
    labels.forEach(function (lab, li) {
      var gx = PL + groupW * li + groupW / 2;
      var totalW = bw * innerN + (innerN - 1) * 4;
      var x0 = gx - totalW / 2;
      sets.forEach(function (s, si) {
        var v = (s.data || [])[li] || 0;
        var y = yAt(v), h0 = yAt(dmin), bh = Math.max(0, h0 - y);
        var bx = x0 + si * (bw + 4);
        var r = svel('rect', { x: bx.toFixed(1), y: (h0).toFixed(1), width: bw.toFixed(1), height: 0, rx: 5, fill: 'url(#' + s._gid + ')' });
        r.style.cursor = 'pointer';
        (function (val, label, series, rectEl, ty, th) {
          rectEl.addEventListener('pointerenter', function () {
            rectEl.setAttribute('opacity', '0.82');
            tip.show((innerN > 1 ? series + ' · ' : '') + '<b>' + fmtNum(val) + '</b>' + (cfg.unit ? ' ' + cfg.unit : ''),
              bx + bw / 2, y - 6);
          });
          rectEl.addEventListener('pointerleave', function () { rectEl.setAttribute('opacity', '1'); tip.hide(); });
        })(v, lab, s.label || '', r, y, bh);
        bars.push({ r: r, y: y, h: bh });
        svg.appendChild(r);
      });
      var xl = svel('text', { x: gx.toFixed(1), y: H - 14, 'text-anchor': 'middle', fill: THEME.body, 'font-family': "'IBM Plex Sans',sans-serif", 'font-size': 11 });
      xl.textContent = lab; svg.appendChild(xl);
    });
    wrap.appendChild(svg);
    whenVisible(wrap, function () {
      bars.forEach(function (b, i) {
        b.r.style.transition = 'y .7s cubic-bezier(.34,1.2,.4,1) ' + (i * 0.04) + 's, height .7s cubic-bezier(.34,1.2,.4,1) ' + (i * 0.04) + 's';
        requestAnimationFrame(function () { b.r.setAttribute('y', b.y.toFixed(1)); b.r.setAttribute('height', b.h.toFixed(1)); });
      });
    });
  }

  /* ================= LINE (area, smooth, hover crosshair) ================= */
  function lineSVG(cfg, wrap) {
    var W = 720, H = 260, PL = 44, PR = 16, PT = 16, PB = 34;
    var labels = cfg.labels || [], sets = cfg.datasets || [];
    var cols = palette(sets.length);
    var flat = []; sets.forEach(function (s) { (s.data || []).forEach(function (v) { flat.push(v); }); });
    var dmax = cfg.yMax != null ? cfg.yMax : niceMax(Math.max.apply(null, flat.concat([1])));
    var dmin = cfg.yMin != null ? cfg.yMin : Math.min.apply(null, flat.concat([0]));
    if (dmin === dmax) dmax = dmin + 1;
    var PW = W - PL - PR, PH = H - PT - PB;
    var n = labels.length;
    var xAt = function (i) { return PL + (n <= 1 ? PW / 2 : i / (n - 1) * PW); };
    var yAt = function (v) { return PT + (1 - (v - dmin) / (dmax - dmin || 1)) * PH; };

    var lg = legendRow(wrap.parentNode, sets.map(function (s, i) { return { label: s.label || 'Series ' + (i + 1), color: cols[i] }; }));
    if (lg) wrap.parentNode.insertBefore(lg, wrap);

    var svg = svel('svg', { viewBox: '0 0 ' + W + ' ' + H, preserveAspectRatio: 'xMidYMid meet', style: 'display:block;width:100%;height:auto' });
    var defs = svel('defs', {}); svg.appendChild(defs);
    for (var t = 0; t <= 4; t++) {
      var gv = dmin + (dmax - dmin) * t / 4, gy = yAt(gv);
      svg.appendChild(svel('line', { x1: PL, x2: PL + PW, y1: gy.toFixed(1), y2: gy.toFixed(1), stroke: rgba(THEME.line, 0.9), 'stroke-width': 1 }));
      var tx = svel('text', { x: PL - 8, y: (gy + 3.5).toFixed(1), 'text-anchor': 'end', fill: THEME.sub, 'font-family': "'IBM Plex Mono',monospace", 'font-size': 10 });
      tx.textContent = fmtNum(gv); svg.appendChild(tx);
    }
    // x labels (thin out if many)
    var everyX = n > 8 ? Math.ceil(n / 6) : 1;
    labels.forEach(function (lab, i) {
      if (i % everyX !== 0 && i !== n - 1) return;
      var xl = svel('text', { x: xAt(i).toFixed(1), y: H - 14, 'text-anchor': 'middle', fill: THEME.body, 'font-family': "'IBM Plex Sans',sans-serif", 'font-size': 11 });
      xl.textContent = lab; svg.appendChild(xl);
    });

    var paths = [];
    sets.forEach(function (s, si) {
      var c = cols[si], data = s.data || [];
      var gid = 'lg' + si + '-' + Math.random().toString(36).slice(2, 6);
      var grad = svel('linearGradient', { id: gid, x1: 0, y1: 0, x2: 0, y2: 1 });
      grad.appendChild(svel('stop', { offset: '0%', 'stop-color': c, 'stop-opacity': si === 0 ? '0.20' : '0.10' }));
      grad.appendChild(svel('stop', { offset: '100%', 'stop-color': c, 'stop-opacity': '0' }));
      defs.appendChild(grad);
      var dLine = '', dArea = 'M' + xAt(0).toFixed(1) + ' ' + (PT + PH);
      data.forEach(function (v, i) { var x = xAt(i), y = yAt(v); dLine += (i ? 'L' : 'M') + x.toFixed(1) + ' ' + y.toFixed(1); dArea += 'L' + x.toFixed(1) + ' ' + y.toFixed(1); });
      dArea += 'L' + xAt(data.length - 1).toFixed(1) + ' ' + (PT + PH) + 'Z';
      if (si === 0) svg.appendChild(svel('path', { d: dArea, fill: 'url(#' + gid + ')' }));
      var p = svel('path', { d: dLine, fill: 'none', stroke: c, 'stroke-width': 2.6, 'stroke-linejoin': 'round', 'stroke-linecap': 'round' });
      svg.appendChild(p); paths.push(p);
      data.forEach(function (v, i) {
        var dot = svel('circle', { cx: xAt(i).toFixed(1), cy: yAt(v).toFixed(1), r: 0, fill: THEME.bg2, stroke: c, 'stroke-width': 2.2 });
        svg.appendChild(dot);
        whenVisible(wrap, function () { dot.style.transition = 'r .4s ease ' + (0.5 + i * 0.03) + 's'; requestAnimationFrame(function () { dot.setAttribute('r', 3.6); }); });
      });
    });
    // hover crosshair + tooltip
    var tip = mkTip(wrap, W);
    var cross = svel('line', { y1: PT, y2: PT + PH, stroke: rgba(THEME.sub, 0.5), 'stroke-width': 1, 'stroke-dasharray': '3 3', opacity: 0 });
    svg.appendChild(cross);
    var hit = svel('rect', { x: PL, y: PT, width: PW, height: PH, fill: 'transparent' });
    hit.style.cursor = 'crosshair';
    hit.addEventListener('pointermove', function (e) {
      var r = svg.getBoundingClientRect(), vx = (e.clientX - r.left) / r.width * W;
      var i = Math.round((vx - PL) / (PW / (n - 1 || 1))); i = Math.max(0, Math.min(n - 1, i));
      cross.setAttribute('x1', xAt(i)); cross.setAttribute('x2', xAt(i)); cross.setAttribute('opacity', 1);
      var rows = sets.map(function (s) { return '<span style="opacity:.75">' + (s.label || '') + '</span> <b>' + fmtNum((s.data || [])[i]) + '</b>'; }).join('<br>');
      tip.show('<span style="opacity:.65;font-weight:500">' + labels[i] + '</span><br>' + rows, xAt(i), yAt(Math.max.apply(null, sets.map(function (s) { return (s.data || []).filter(function(x){return x!=null;}).length?(s.data||[])[i]:0; }))) - 6);
    });
    hit.addEventListener('pointerleave', function () { cross.setAttribute('opacity', 0); tip.hide(); });
    svg.appendChild(hit);
    wrap.appendChild(svg);
    whenVisible(wrap, function () {
      paths.forEach(function (p) {
        var L = p.getTotalLength();
        p.style.strokeDasharray = L; p.style.strokeDashoffset = L; p.style.transition = 'none';
        requestAnimationFrame(function () { p.style.transition = 'stroke-dashoffset 1s cubic-bezier(.4,0,.2,1)'; p.style.strokeDashoffset = 0; });
      });
    });
  }

  /* ================= PIE / DOUGHNUT ================= */
  function pieSVG(cfg, wrap, doughnut) {
    var W = 720, H = 260, cx = 150, cy = H / 2, R = 96, r0 = doughnut ? 56 : 0;
    var labels = cfg.labels || [], data = (cfg.datasets && cfg.datasets[0] && cfg.datasets[0].data) || [];
    var cols = palette(labels.length);
    var total = data.reduce(function (a, b) { return a + b; }, 0) || 1;
    var svg = svel('svg', { viewBox: '0 0 ' + W + ' ' + H, preserveAspectRatio: 'xMidYMid meet', style: 'display:block;width:100%;height:auto' });
    var g = svel('g', { transform: 'translate(' + cx + ' ' + cy + ')' });
    var gAnim = svel('g', {});               // inner group carries the entrance animation
    g.appendChild(gAnim); svg.appendChild(g);
    var tip = mkTip(wrap, W);
    var ang = -Math.PI / 2, segs = [];
    function arc(a0, a1) {
      var large = (a1 - a0) > Math.PI ? 1 : 0;
      var x0 = Math.cos(a0) * R, y0 = Math.sin(a0) * R, x1 = Math.cos(a1) * R, y1 = Math.sin(a1) * R;
      if (!doughnut) return 'M0 0 L' + x0.toFixed(2) + ' ' + y0.toFixed(2) + ' A' + R + ' ' + R + ' 0 ' + large + ' 1 ' + x1.toFixed(2) + ' ' + y1.toFixed(2) + ' Z';
      var ix0 = Math.cos(a0) * r0, iy0 = Math.sin(a0) * r0, ix1 = Math.cos(a1) * r0, iy1 = Math.sin(a1) * r0;
      return 'M' + x0.toFixed(2) + ' ' + y0.toFixed(2) + ' A' + R + ' ' + R + ' 0 ' + large + ' 1 ' + x1.toFixed(2) + ' ' + y1.toFixed(2) +
        ' L' + ix1.toFixed(2) + ' ' + iy1.toFixed(2) + ' A' + r0 + ' ' + r0 + ' 0 ' + large + ' 0 ' + ix0.toFixed(2) + ' ' + iy0.toFixed(2) + ' Z';
    }
    data.forEach(function (v, i) {
      var frac = v / total, a1 = ang + frac * Math.PI * 2;
      var p = svel('path', { d: arc(ang, a1), fill: cols[i], stroke: THEME.bg2, 'stroke-width': 2.5 });
      p.style.cursor = 'pointer'; p.style.transformOrigin = '0 0'; p.style.transition = 'opacity .15s';
      var mid = (ang + a1) / 2;
      (function (val, lab, mang) {
        p.addEventListener('pointerenter', function () {
          p.setAttribute('opacity', '0.82');
          tip.show(lab + ' · <b>' + fmtNum(val) + '</b> <span style="opacity:.7">(' + (frac * 100).toFixed(1) + '%)</span>',
            cx + Math.cos(mang) * R * 0.7, cy + Math.sin(mang) * R * 0.7 - 6);
        });
        p.addEventListener('pointerleave', function () { p.setAttribute('opacity', '1'); tip.hide(); });
      })(v, labels[i] || '', mid);
      gAnim.appendChild(p); segs.push(p);
      ang = a1;
    });
    if (doughnut) {
      var big = svel('text', { x: 0, y: -2, 'text-anchor': 'middle', fill: THEME.hi, 'font-family': "'IBM Plex Sans',sans-serif", 'font-size': 22, 'font-weight': 700 });
      big.textContent = fmtNum(total); gAnim.appendChild(big);
      var sub = svel('text', { x: 0, y: 16, 'text-anchor': 'middle', fill: THEME.sub, 'font-family': "'IBM Plex Mono',monospace", 'font-size': 10, 'letter-spacing': '.1em' });
      sub.textContent = (cfg.centerLabel || 'TOTAL').toUpperCase(); gAnim.appendChild(sub);
    }
    // legend on the right
    var lx = 300, ly = cy - (labels.length * 24) / 2 + 12;
    labels.forEach(function (lab, i) {
      var y = ly + i * 24;
      svg.appendChild(svel('rect', { x: lx, y: y - 9, width: 12, height: 12, rx: 3, fill: cols[i] }));
      var t = svel('text', { x: lx + 20, y: y + 1, fill: THEME.body, 'font-family': "'IBM Plex Sans',sans-serif", 'font-size': 12.5 });
      t.textContent = lab; svg.appendChild(t);
      var pv = svel('text', { x: W - 14, y: y + 1, 'text-anchor': 'end', fill: THEME.sub, 'font-family': "'IBM Plex Mono',monospace", 'font-size': 11.5 });
      pv.textContent = (data[i] / total * 100).toFixed(0) + '%'; svg.appendChild(pv);
    });
    wrap.appendChild(svg);
    whenVisible(wrap, function () {
      gAnim.style.transformOrigin = '0px 0px';   // arcs are centered at the group origin
      gAnim.style.transform = 'scale(.55) rotate(-22deg)'; gAnim.style.opacity = '0';
      gAnim.style.transition = 'transform .8s cubic-bezier(.34,1.3,.5,1), opacity .5s';
      requestAnimationFrame(function () { gAnim.style.transform = 'scale(1) rotate(0)'; gAnim.style.opacity = '1'; });
    });
  }

  /* ================= RADAR ================= */
  function radarSVG(cfg, wrap) {
    var W = 720, H = 260, cx = W / 2, cy = H / 2 + 4, R = 96;
    var labels = cfg.labels || [], sets = cfg.datasets || [];
    var cols = palette(sets.length);
    var flat = []; sets.forEach(function (s) { (s.data || []).forEach(function (v) { flat.push(v); }); });
    var dmax = cfg.yMax != null ? cfg.yMax : niceMax(Math.max.apply(null, flat.concat([1])));
    var n = labels.length;
    var ptAt = function (i, v) { var a = -Math.PI / 2 + i / n * Math.PI * 2, rr = v / dmax * R; return [cx + Math.cos(a) * rr, cy + Math.sin(a) * rr]; };
    var svg = svel('svg', { viewBox: '0 0 ' + W + ' ' + H, preserveAspectRatio: 'xMidYMid meet', style: 'display:block;width:100%;height:auto' });
    // rings
    for (var ring = 1; ring <= 4; ring++) {
      var pts = '';
      for (var i = 0; i < n; i++) { var p = ptAt(i, dmax * ring / 4); pts += p[0].toFixed(1) + ',' + p[1].toFixed(1) + ' '; }
      svg.appendChild(svel('polygon', { points: pts, fill: 'none', stroke: rgba(THEME.line, ring === 4 ? 1 : 0.7), 'stroke-width': 1 }));
    }
    // spokes + axis labels
    for (var j = 0; j < n; j++) {
      var edge = ptAt(j, dmax);
      svg.appendChild(svel('line', { x1: cx, y1: cy, x2: edge[0].toFixed(1), y2: edge[1].toFixed(1), stroke: rgba(THEME.line, 0.7), 'stroke-width': 1 }));
      var a = -Math.PI / 2 + j / n * Math.PI * 2;
      var lx = cx + Math.cos(a) * (R + 20), ly = cy + Math.sin(a) * (R + 20);
      var anchor = Math.abs(Math.cos(a)) < 0.3 ? 'middle' : (Math.cos(a) > 0 ? 'start' : 'end');
      var t = svel('text', { x: lx.toFixed(1), y: (ly + 3).toFixed(1), 'text-anchor': anchor, fill: THEME.body, 'font-family': "'IBM Plex Sans',sans-serif", 'font-size': 11 });
      t.textContent = labels[j]; svg.appendChild(t);
    }
    var lg = legendRow(wrap.parentNode, sets.map(function (s, i) { return { label: s.label || 'Series ' + (i + 1), color: cols[i] }; }));
    if (lg) wrap.parentNode.insertBefore(lg, wrap);
    var tip = mkTip(wrap, W);
    var polys = [];
    sets.forEach(function (s, si) {
      var c = cols[si], pts = '';
      (s.data || []).forEach(function (v, i) { var p = ptAt(i, v); pts += p[0].toFixed(1) + ',' + p[1].toFixed(1) + ' '; });
      var poly = svel('polygon', { points: pts, fill: rgba(c, si === 0 ? 0.16 : 0.10), stroke: c, 'stroke-width': 2.2, 'stroke-linejoin': 'round' });
      svg.appendChild(poly); polys.push(poly);
      (s.data || []).forEach(function (v, i) {
        var p = ptAt(i, v);
        var dot = svel('circle', { cx: p[0].toFixed(1), cy: p[1].toFixed(1), r: 3.4, fill: c });
        dot.style.cursor = 'pointer';
        (function (val, lab) {
          dot.addEventListener('pointerenter', function () { tip.show(lab + ' · <b>' + fmtNum(val) + '</b>', p[0], p[1] - 6); });
          dot.addEventListener('pointerleave', function () { tip.hide(); });
        })(v, labels[i]);
        svg.appendChild(dot);
      });
    });
    wrap.appendChild(svg);
    whenVisible(wrap, function () {
      polys.forEach(function (poly) {
        poly.style.transformOrigin = cx + 'px ' + cy + 'px'; poly.style.transform = 'scale(0)';
        poly.style.transition = 'transform .8s cubic-bezier(.34,1.3,.5,1)';
        requestAnimationFrame(function () { poly.style.transform = 'scale(1)'; });
      });
    });
  }

  /* ============ REFERENCES RENDERER ============ */
  function renderRefs(refs, host) {
    if (!refs || !refs.length) return;
    var card = el('div', 'vai-card');
    card.appendChild(el('div', 'vai-title', 'References & Sources'));
    var ul = el('ul', 'vai-refs');
    refs.forEach(function (r) {
      var li = document.createElement('li');
      var a = document.createElement('a');
      a.href = r.url; a.target = '_blank'; a.rel = 'noopener noreferrer';
      a.textContent = r.title;
      li.appendChild(a);
      if (r.note) { var s = el('span', 'vai-ref-note', ' — ' + r.note); li.appendChild(s); }
      ul.appendChild(li);
    });
    card.appendChild(ul);
    host.appendChild(card);
  }

  /* ============ INTERACTIVE WIDGETS ============ */
  function renderWidget(w, host) {
    if (!w || !w.type || !WIDGETS[w.type]) return;
    var card = el('div', 'vai-card vai-widget');
    card.appendChild(el('div', 'vai-title', w.title || 'Try it yourself'));
    if (w.desc) card.appendChild(el('div', 'vai-desc', w.desc));
    var body = el('div', 'vai-widget-body');
    card.appendChild(body); host.appendChild(card);
    WIDGETS[w.type](body, w);
  }

  var WIDGETS = {
    /* 1. Live contrast checker (NASE accessibility) */
    contrast: function (host, w) {
      host.innerHTML =
        '<div class="vai-cc-row"><label>Text <input type="color" class="vai-cc-fg" value="#777777"></label>' +
        '<label>Background <input type="color" class="vai-cc-bg" value="#0f1117"></label></div>' +
        '<div class="vai-cc-preview">Sample text — readable?</div>' +
        '<div class="vai-cc-out"></div>';
      var fg = host.querySelector('.vai-cc-fg'), bg = host.querySelector('.vai-cc-bg');
      var prev = host.querySelector('.vai-cc-preview'), out = host.querySelector('.vai-cc-out');
      function lum(hex) {
        var n = parseInt(hex.slice(1), 16), r = (n >> 16) & 255, g = (n >> 8) & 255, b = n & 255;
        var a = [r, g, b].map(function (v) { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); });
        return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
      }
      function upd() {
        var l1 = lum(fg.value), l2 = lum(bg.value);
        var ratio = (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
        prev.style.color = fg.value; prev.style.background = bg.value;
        var r = ratio.toFixed(2);
        var aa = ratio >= 4.5, aaa = ratio >= 7;
        out.innerHTML = 'Contrast ratio: <b>' + r + ':1</b> &nbsp; ' +
          '<span class="' + (aa ? 'vai-pass' : 'vai-fail') + '">WCAG AA ' + (aa ? 'PASS' : 'FAIL') + '</span> ' +
          '<span class="' + (aaa ? 'vai-pass' : 'vai-fail') + '">AAA ' + (aaa ? 'PASS' : 'FAIL') + '</span>';
      }
      fg.addEventListener('input', upd); bg.addEventListener('input', upd); upd();
    },

    /* 2. Confidence simulator (Crop disease) */
    slider: function (host, w) {
      var items = w.items || [];
      host.innerHTML = '<input type="range" min="0" max="100" value="50" class="vai-slider"><div class="vai-slider-out"></div>';
      var sl = host.querySelector('.vai-slider'), out = host.querySelector('.vai-slider-out');
      function upd() {
        var v = +sl.value;
        var rows = items.map(function (it) {
          var conf = Math.max(0, Math.min(100, it.base + (v - 50) * it.slope));
          return '<div class="vai-bar-row"><span>' + it.label + '</span>' +
            '<span class="vai-bar"><i style="width:' + conf.toFixed(0) + '%"></i></span>' +
            '<b>' + conf.toFixed(0) + '%</b></div>';
        }).join('');
        out.innerHTML = '<div class="vai-slider-label">' + (w.axis || 'Input quality') + ': ' + v + '%</div>' + rows;
      }
      sl.addEventListener('input', upd); upd();
    },

    /* 3. Step-through state machine (CampusBay order flow / PaperMind pipeline) */
    steps: function (host, w) {
      var steps = w.steps || [];
      var i = 0;
      host.innerHTML = '<div class="vai-steps"></div><div class="vai-step-detail"></div>' +
        '<div class="vai-step-nav"><button class="vai-btn vai-prev">‹ Prev</button>' +
        '<span class="vai-step-count"></span><button class="vai-btn vai-next">Next ›</button></div>';
      var bar = host.querySelector('.vai-steps'), detail = host.querySelector('.vai-step-detail'), count = host.querySelector('.vai-step-count');
      bar.innerHTML = steps.map(function (s, idx) { return '<span class="vai-step" data-i="' + idx + '">' + (idx + 1) + '</span>'; }).join('');
      function upd() {
        bar.querySelectorAll('.vai-step').forEach(function (e, idx) { e.classList.toggle('on', idx <= i); e.classList.toggle('cur', idx === i); });
        detail.innerHTML = '<b>' + steps[i].title + '</b><p>' + steps[i].body + '</p>';
        count.textContent = (i + 1) + ' / ' + steps.length;
        host.querySelector('.vai-prev').disabled = i === 0;
        host.querySelector('.vai-next').disabled = i === steps.length - 1;
      }
      host.querySelector('.vai-prev').addEventListener('click', function () { if (i > 0) { i--; upd(); } });
      host.querySelector('.vai-next').addEventListener('click', function () { if (i < steps.length - 1) { i++; upd(); } });
      bar.addEventListener('click', function (e) { var t = e.target.closest('.vai-step'); if (t) { i = +t.dataset.i; upd(); } });
      upd();
    },

    /* 4. Live filter table (Steam market SQL-style) */
    filter: function (host, w) {
      var rows = w.rows || [], cols = w.columns || [];
      host.innerHTML = '<input type="text" class="vai-filter-in" placeholder="' + (w.placeholder || 'Type to filter…') + '">' +
        '<div class="vai-filter-meta"></div><div class="vai-table-wrap"><table class="vai-table"><thead><tr>' +
        cols.map(function (c) { return '<th>' + c + '</th>'; }).join('') + '</tr></thead><tbody></tbody></table></div>';
      var inp = host.querySelector('.vai-filter-in'), tb = host.querySelector('tbody'), meta = host.querySelector('.vai-filter-meta');
      function draw() {
        var q = inp.value.toLowerCase();
        var filtered = rows.filter(function (r) { return r.join(' ').toLowerCase().indexOf(q) !== -1; });
        tb.innerHTML = filtered.slice(0, 50).map(function (r) { return '<tr>' + r.map(function (c) { return '<td>' + c + '</td>'; }).join('') + '</tr>'; }).join('');
        meta.textContent = filtered.length + ' of ' + rows.length + ' rows';
      }
      inp.addEventListener('input', draw); draw();
    },

    /* 5. Keyword matcher (Resume Match) */
    matcher: function (host, w) {
      var skills = w.skills || [];
      host.innerHTML = '<textarea class="vai-ta" placeholder="' + (w.placeholder || 'Paste a job description…') + '">' + (w.sample || '') + '</textarea>' +
        '<button class="vai-btn vai-match-go">Score it</button><div class="vai-match-out"></div>';
      var ta = host.querySelector('.vai-ta'), out = host.querySelector('.vai-match-out');
      function run() {
        var txt = ta.value.toLowerCase();
        var matched = skills.filter(function (s) { return s.aliases.some(function (a) { return txt.indexOf(a) !== -1; }); });
        var score = Math.round(matched.length / skills.length * 100);
        out.innerHTML = '<div class="vai-score">Match score: <b>' + score + '%</b></div>' +
          '<div class="vai-chips-row">' + skills.map(function (s) {
            var hit = matched.indexOf(s) !== -1;
            return '<span class="vai-chip-tag ' + (hit ? 'hit' : 'miss') + '">' + (hit ? '✓ ' : '○ ') + s.name + '</span>';
          }).join('') + '</div>';
      }
      host.querySelector('.vai-match-go').addEventListener('click', run); run();
    },

    /* 6. Canvas zone tracker (HandGesture demo) */
    zones: function (host, w) {
      var zones = w.zones || ['Idle', 'Draw', 'Erase', 'Clear'];
      host.innerHTML = '<div class="vai-zone-hint">Move your cursor (or finger) across the box. It maps your horizontal position to a gesture zone, the same idea as the index-finger tracker in the app.</div>' +
        '<div class="vai-zone-box"><span class="vai-zone-label">\u2014</span>' +
        '<div class="vai-zone-grid">' + zones.map(function (z) { return '<div class="vai-zone-cell">' + z + '</div>'; }).join('') + '</div>' +
        '<span class="vai-zone-dot" style="left:50%;top:50%"></span></div>';
      var box = host.querySelector('.vai-zone-box'), dot = host.querySelector('.vai-zone-dot'), lab = host.querySelector('.vai-zone-label');
      function pos(e) {
        var r = box.getBoundingClientRect();
        var cx = (e.touches ? e.touches[0].clientX : e.clientX) - r.left;
        var cy = (e.touches ? e.touches[0].clientY : e.clientY) - r.top;
        cx = Math.max(0, Math.min(r.width, cx)); cy = Math.max(0, Math.min(r.height, cy));
        dot.style.left = cx + 'px'; dot.style.top = cy + 'px';
        var zi = Math.min(zones.length - 1, Math.floor(cx / r.width * zones.length));
        lab.textContent = zones[zi];
      }
      box.addEventListener('mousemove', pos);
      box.addEventListener('touchmove', function (e) { pos(e); e.preventDefault(); }, { passive: false });
    }
  };

  /* ============ BUILD ============ */
  readTheme();
  if (DATA.chart) renderChart(DATA.chart, mount);
  if (DATA.widget) renderWidget(DATA.widget, mount);
  if (DATA.references) renderRefs(DATA.references, mount);
})();
