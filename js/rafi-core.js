/* ============================================================
   JIN — Intelligence Core  (floating avatar widget)   v3
   A mind summoned by name. Glassy panel · Lucide icons ·
   wake-word gate ("JIN") · heavy mathematics (LaTeX + spoken
   equations) · bilingual EN/ID · voice (speak + mic) · web search.
   Self-loads deps. Pairs with rafi-core.css

   ── WHERE THE BRAIN LIVES ──────────────────────────────────
   The widget POSTs to JIN_API below.
   • Inside the Claude canvas  -> api.anthropic.com works as-is.
   • On your live site the browser cannot call Anthropic directly.
     Deploy the proxy in README-RAFI.txt and set:
         JIN_API = "https://your-worker.workers.dev"
   ============================================================ */
(function () {
  'use strict';
  if (window.__JIN_CORE__) return;
  window.__JIN_CORE__ = true;

  /* ── CONFIG ── */
  var JIN_API = "https://jin-brain.arsyarafi51.workers.dev";   // <- change to your proxy for the live site
  var MODEL   = "claude-sonnet-4-6";

  var BASE = (function () {
    var s = document.currentScript && document.currentScript.src;
    if (s) { var d = s.slice(0, s.lastIndexOf('/') + 1); return d.replace(/\/js\/$/, '/'); }
    return location.pathname.indexOf('/projects/') !== -1 ? '../' : '';
  })();
  var AVATAR = BASE + 'assets/rafi_avatar.mp4';

  var root;

  /* ── deps (KaTeX + marked + Lucide) ── */
  function loadCss(h){var l=document.createElement('link');l.rel='stylesheet';l.href=h;document.head.appendChild(l);}
  function loadJs(s){return new Promise(function(res,rej){var x=document.createElement('script');x.src=s;x.onload=res;x.onerror=rej;document.head.appendChild(x);});}
  var DEPS=(function(){
    loadCss('https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.9/katex.min.css');
    return loadJs('https://cdnjs.cloudflare.com/ajax/libs/marked/12.0.0/marked.min.js')
      .then(function(){return loadJs('https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.9/katex.min.js');})
      .then(function(){return loadJs('https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.9/contrib/auto-render.min.js');})
      .catch(function(){});
  })();
  // Lucide (separate, non-blocking) + inline fallback below
  loadJs('https://cdnjs.cloudflare.com/ajax/libs/lucide/0.456.0/lucide.min.js')
    .then(function(){ paintIcons(); }).catch(function(){ paintIcons(); });

  /* ── inline Lucide SVG fallback (MIT) — guarantees icons render ── */
  var ICONS = {
    'volume-2':'<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/>',
    'volume-x':'<path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><line x1="22" x2="16" y1="9" y2="15"/><line x1="16" x2="22" y1="9" y2="15"/>',
    'x':'<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
    'mic':'<path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/>',
    'arrow-up':'<path d="m5 12 7-7 7 7"/><path d="M12 19V5"/>',
    'languages':'<path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/>',
    'sparkles':'<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
    'moon':'<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>'
  };
  function paintIcons(){
    var scope = root || document;
    if (window.lucide && window.lucide.createIcons){
      try{ window.lucide.createIcons(); }catch(_){}
    }
    setTimeout(function(){
      (root||document).querySelectorAll('#jin-root [data-lucide]').forEach(function(el){
        if(el.querySelector('svg')) return;
        var name=el.getAttribute('data-lucide'), sz=el.getAttribute('data-sz')||16;
        if(ICONS[name]) el.innerHTML='<svg width="'+sz+'" height="'+sz+'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'+ICONS[name]+'</svg>';
      });
    }, 60);
  }

  /* ── ABOUT RAFI ─────────────────────────────────────────────── */
  var ABOUT_RAFI =
    "Full name: Muhammad Rafi Arsya. Goes by Rafi.\n" +
    "Currently: Computer Science (Software Engineering) student at Universiti Malaya (UM), Kuala Lumpur, Malaysia. Started 2025, ongoing.\n" +
    "Based: Kolej Kediaman Ke-13, Universiti Malaya, Kuala Lumpur, Malaysia. Originally from Kampar, Riau, Indonesia.\n\n" +

    "ABOUT:\n" +
    "Software Engineering student with hands-on experience building scalable, containerized full-stack applications. Proficient in React, Node.js, and modern state management, with practical expertise in Docker Compose, Nginx reverse proxying, and self-hosted Linux infrastructure. Proven track record in engineering real-time communication systems and integrating AI/ML technologies to solve practical real-world problems.\n\n" +

    "EDUCATION:\n" +
    "- Bachelor of Computer Science (Software Engineering), Universiti Malaya, Malaysia, 2025–present. Focus: software architecture, data structures, systems engineering.\n" +
    "- Senior High School International Program, ICBS, Riau, Indonesia, 2022–2025. English-medium instruction, student leadership.\n\n" +

    "SKILLS:\n" +
    "- Frontend: HTML5, CSS3, JavaScript (ES6+), TypeScript, React, Next.js, Tailwind CSS, Vite, TanStack, React Query\n" +
    "- Backend: Python, Express.js, REST APIs, Java, Node.js, Socket.IO, Redis, FastAPI, Sequelize ORM, PostgreSQL, MySQL, JWT, Nodemailer\n" +
    "- AI/ML: TensorFlow, Keras, PyTorch, NumPy, OpenCV, MediaPipe\n" +
    "- DevOps: Docker, Docker Compose, AWS, Cloudflare, NGINX, Git, GitHub, Ubuntu, Linux\n" +
    "- Design: Figma, Canva, VS Code, Kiro\n\n" +

    "PROJECTS:\n" +
    "1. CampusBay — Campus Marketplace (2026, ongoing)\n" +
    "   Full-stack containerized marketplace (5-service stack) with React 18, Node.js, PostgreSQL, Docker Compose. Real-time chat via Socket.io (typing indicators, live order tracking). JWT Dual-Token + Redis Blacklist auth. Nginx reverse proxy with SSL, Stripe Checkout payments.\n\n" +
    "2. HandGesture — Real-Time Drawing App (2025)\n" +
    "   Real-time hand gesture drawing app using MediaPipe and OpenCV. Draws on screen by raising only index finger via webcam. Detects 21 hand landmarks per hand, up to 4 simultaneous hands. Gesture-based controls for color switching, canvas clear, draw mode toggle.\n\n" +
    "3. Crop Disease Detector (2026)\n" +
    "   Image classification web app detecting plant diseases from leaf photos across 38 categories (PlantVillage dataset, 54K+ images). Transfer learning with MobileNetV2. Deployed on Hugging Face Spaces with real-time prediction and top-3 confidence scores.\n\n" +
    "4. BriskWalk — Event Registration Platform (2026)\n" +
    "   Responsive single-page registration app for a community walking event. Client-side image compression via Canvas API (auto-resize, WebP). Google Apps Script backend storing data in Google Sheets and Google Drive.\n\n" +
    "5. NASE Accessibility Tool (ongoing)\n" +
    "   Accessible bilingual SPA for Malaysia's National Association of Special Education. Web Speech API for text-to-speech with real-time paragraph highlighting. i18n supporting 4 languages (EN/BM/ID/ZH), multi-theme toggle, WCAG accessibility standards, ARIA labels, keyboard navigation.\n\n" +
    "6. PaperMind — AI Research Assistant\n" +
    "   AI-powered tool to help users understand and interact with research papers.\n\n" +
    "7. snip — Screenshot/snippet tool\n" +
    "   Personal productivity tool for capturing and managing snippets.\n\n" +

    "ORGANIZATIONS & EXPERIENCE:\n" +
    "- Head of Website Division, Data and Information System Bureau — PPI Malaysia (Indonesian Students Association in Malaysia). Led full responsibility for the official PPI Malaysia website: development, maintenance, continuous improvement.\n" +
    "- Head of Department, Art Exhibition – IDFEST, PPI Universiti Malaya. Directed the Art Exhibition for an international cultural event showcasing Indonesian heritage at UM. Managed concept development, curation, and coordination.\n" +
    "- Volunteer, LARAS 2026 — Transportation Team & Field Committee, PPI Malaysia. Coordinated logistics, transport schedules, on-ground participant management, and end-to-end event operations.\n\n" +

    "CERTIFICATIONS & COURSES:\n" +
    "- IELTS Academic Band 5.5 (CEFR B2), British Council/IDP, Jun 2025, valid until Jun 2027\n" +
    "- AWS Certified Developer Associate (DVA-C02), Udemy, Jun 2026, 31.5 hrs\n" +
    "- AWS Certified AI Practitioner (AIF-C01), Udemy, May 2026, 10.5 hrs\n" +
    "- Complete Full Stack Web Development Bootcamp (AI Integrated), Udemy, Dec 2025, 62.5 hrs\n" +
    "- The Complete Full-Stack Web Development Bootcamp, Udemy, Jan 2026, 62 hrs\n" +
    "- The Complete JavaScript Course 2025, Udemy, Dec 2025, 71 hrs\n" +
    "- Docker for the Absolute Beginner – DevOps, Udemy, Jun 2026, 3 hrs\n" +
    "- SQL for Data Analysis: Advanced SQL Querying, Udemy, Jun 2026, 8.5 hrs\n" +
    "- freeCodeCamp Legacy JavaScript Algorithms and Data Structures V7, May 2026, 300 hrs\n" +
    "- From Java Dev to AI Engineer: Spring AI Fast Track, Udemy, Dec 2025, 14 hrs\n" +
    "- Spec-Driven Development dengan Kiro, Dicoding, May 2026\n" +
    "- Belajar Dasar Cloud dan Gen AI di AWS, Dicoding, May 2026\n\n" +

    "CONTACT:\n" +
    "- Email: rafiarsya.work@gmail.com\n" +
    "- WhatsApp: +60 17-941 5768\n" +
    "- Website: rafiarsya.com\n" +
    "- GitHub: github.com/rafiarsya (implied from portfolio)\n" +
    "- LinkedIn: linked from portfolio\n" +
    "- Instagram: linked from portfolio\n";

  /* ── JIN's mind ── */
  var SYSTEM = "You are JIN \u2014 an AI assistant built into Muhammad Rafi Arsya's portfolio website. Your primary purpose is to help visitors learn about Rafi \u2014 his background, skills, projects, education, and experience \u2014 and to answer any general questions they might have.\n\n" +
    "LANGUAGE: Always respond in English only, regardless of what language the visitor writes in. Keep your tone warm, friendly, and helpful \u2014 like a knowledgeable guide to Rafi's work.\n\n" +
    "PRIMARY ROLE \u2014 helping visitors know Rafi:\n" +
    "- When visitors ask about Rafi (his skills, projects, background, contact, experience, education, etc.), answer thoroughly and enthusiastically using the ABOUT RAFI data below.\n" +
    "- Speak about Rafi in third person (e.g. 'Rafi is a...', 'He built...', 'You can reach him at...').\n" +
    "- If a visitor asks something about Rafi that isn\u2019t in the data, say you don\u2019t have that specific info and suggest they contact him directly.\n\n" +
    "SECONDARY ROLE \u2014 general knowledge assistant:\n" +
    "- You can also answer general questions about anything: science, tech, history, coding help, current events, etc.\n" +
    "- Use math/LaTeX ONLY when genuinely needed (math/science/technical questions). Never force formulas into casual questions.\n" +
    "- When recency matters, say you may not have the latest info and suggest they verify.\n" +
    "- Be concise by default; expand when the topic deserves it.\n\n" +
    "ABOUT RAFI \u2014 use these facts when answering questions about him:\n" + ABOUT_RAFI + "\n" +
    "IMPORTANT \u2014 at the very END of every reply, output one line exactly:\n" +
    "[[FOLLOWUPS]] question one | question two | question three\n" +
    "Give 3 short English questions a visitor is likely to ask next, each under ~6 words. Do not explain this line \u2014 just append it.";

  var history = [];

  /* ── UI ── */
  root = document.createElement('div');
  root.id = 'jin-root';
  root.innerHTML =
    '<button id="jin-fab" aria-label="Summon JIN"><video src="'+AVATAR+'" autoplay loop muted playsinline></video><span class="jn-spark"></span></button>' +
    '<div id="jin-teaser" role="button" tabindex="0"><span>Call <b>JIN</b> \u2014 ask me anything about Rafi or anything else.</span><button id="jin-teaser-x" aria-label="Dismiss" data-lucide="x" data-sz="13"></button></div>' +
    '<div id="jin-panel" class="dormant" role="dialog" aria-label="JIN intelligence">' +
      '<div id="jin-flash"></div>' +
      '<div id="jin-head">' +
        '<span id="jin-av"><video src="'+AVATAR+'" autoplay loop muted playsinline></video>' +
          '<span id="jin-wave" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span></span>' +
        '<div id="jin-id"><span id="jin-name">JIN</span>' +
          '<span id="jin-status"><span class="jn-dot"></span><span id="jin-status-t">Dormant</span></span></div>' +
        '<div id="jin-tools">' +
          '<button id="jin-mute" class="jn-tbtn on" title="Voice on/off" aria-label="Toggle voice" data-lucide="volume-2"></button>' +
          '<button id="jin-x" class="jn-tbtn" aria-label="Close" data-lucide="x" data-sz="17"></button>' +
        '</div>' +
      '</div>' +
      '<div id="jin-thread"></div>' +
      '<div id="jin-comp"><div class="box">' +
          '<textarea id="jin-ask" rows="1" placeholder="Type JIN to wake me\u2026"></textarea>' +
          '<button id="jin-mic" class="jn-cbtn" aria-label="Speak" data-lucide="mic"></button>' +
          '<button id="jin-send" class="jn-cbtn" aria-label="Send" disabled data-lucide="arrow-up" data-sz="17"></button>' +
      '</div><div id="jin-note">Asleep \u2014 call my name to begin</div></div>' +
    '</div>';
  document.body.appendChild(root);
  paintIcons();

  function q(s){return root.querySelector(s);}
  var fab=q('#jin-fab'), teaser=q('#jin-teaser'), teaserX=q('#jin-teaser-x'),
      panel=q('#jin-panel'), flash=q('#jin-flash'), av=q('#jin-av'),
      statusEl=q('#jin-status'), statusT=q('#jin-status-t'), thread=q('#jin-thread'),
      ask=q('#jin-ask'), send=q('#jin-send'), mic=q('#jin-mic'),
      muteBtn=q('#jin-mute'), note=q('#jin-note');

  /* ── teaser ── */
  var teaserDone=false;
  setTimeout(function(){if(!teaserDone&&!panel.classList.contains('open'))teaser.classList.add('show');},2600);
  setTimeout(function(){teaser.classList.remove('show');},11000);
  function killTeaser(){teaserDone=true;teaser.classList.remove('show');}
  teaserX.addEventListener('click',function(e){e.stopPropagation();killTeaser();});
  teaser.addEventListener('click',open);

  /* ── voice settings (English only) ── */
  var voiceOn=true;
  muteBtn.addEventListener('click',function(){
    voiceOn=!voiceOn;
    muteBtn.classList.toggle('on',voiceOn);
    muteBtn.classList.toggle('off',!voiceOn);
    muteBtn.setAttribute('data-lucide', voiceOn?'volume-2':'volume-x');
    muteBtn.innerHTML=''; paintIcons();
    if(!voiceOn){ stopSpeak(); }
  });

  /* ── VOICE ENGINE (English only) ────────────────────────────── */
  var _voiceCache = [];
  function getVoices(){
    if(_voiceCache.length) return _voiceCache;
    _voiceCache = window.speechSynthesis ? (window.speechSynthesis.getVoices()||[]) : [];
    return _voiceCache;
  }
  if(window.speechSynthesis){
    try{ speechSynthesis.getVoices(); }catch(_){}
    window.speechSynthesis.onvoiceschanged = function(){ _voiceCache=[]; getVoices(); };
  }

  // Pick the best English voice available
  var EN_PREF = [
    function(v){ return /Google US English/i.test(v.name); },
    function(v){ return /Google.*English.*US/i.test(v.name); },
    function(v){ return /Samantha|Karen|Daniel|Moira|Fiona/i.test(v.name) && v.lang.startsWith('en'); },
    function(v){ return v.lang==='en-US' && /Google/i.test(v.name); },
    function(v){ return v.lang==='en-US'; },
    function(v){ return v.lang && v.lang.startsWith('en'); }
  ];
  function pickVoice(){
    var vs = getVoices();
    for(var i=0;i<EN_PREF.length;i++){
      var f = vs.filter(EN_PREF[i]);
      if(f.length) return f[0];
    }
    return null;
  }

  function speak(text){
    if(!voiceOn || !window.speechSynthesis) return;
    var clean = toSpeech(text); if(!clean) return;
    try{ speechSynthesis.cancel(); }catch(_){}
    var u = new SpeechSynthesisUtterance(clean);
    u.lang='en-US'; u.rate=1.05; u.pitch=1.0;
    function doSpeak(){
      u.onstart=function(){ av.classList.add('speaking'); };
      u.onend=u.onerror=function(){ av.classList.remove('speaking'); };
      try{ speechSynthesis.speak(u); }catch(_){ av.classList.remove('speaking'); }
    }
    var v = pickVoice();
    if(v){ u.voice=v; doSpeak(); }
    else{
      var a=0, t=setInterval(function(){
        a++; var v2=pickVoice();
        if(v2||a>6){ clearInterval(t); if(v2) u.voice=v2; doSpeak(); }
      },100);
    }
  }

  function mathToWords(s){
    var t=s;
    for(var k=0;k<3;k++) t=t.replace(/\\d?frac\s*\{([^{}]+)\}\s*\{([^{}]+)\}/g,' ($1) over ($2) ');
    t=t.replace(/\\sqrt\s*\[\s*3\s*\]\s*\{([^{}]+)\}/g,' cube root of $1 ');
    t=t.replace(/\\sqrt\s*\{([^{}]+)\}/g,' square root of $1 ');
    t=t.replace(/\^\s*\{?\s*2\s*\}?/g,' squared').replace(/\^\s*\{?\s*3\s*\}?/g,' cubed');
    t=t.replace(/\^\s*\{([^{}]+)\}/g,' to the power of $1 ').replace(/\^\s*([0-9a-zA-Z])/g,' to the power of $1 ');
    t=t.replace(/_\s*\{([^{}]+)\}/g,' sub $1 ').replace(/_\s*([0-9a-zA-Z])/g,' sub $1 ');
    t=t.replace(/\\sum/g,' the sum of ').replace(/\\prod/g,' the product of ').replace(/\\int/g,' the integral of ');
    t=t.replace(/\\approx/g,' approximately equals ').replace(/\\neq/g,' not equal to ')
       .replace(/\\leq|\\le/g,' less than or equal to ').replace(/\\geq|\\ge/g,' greater than or equal to ')
       .replace(/\\times/g,' times ').replace(/\\cdot/g,' dot ').replace(/\\pm/g,' plus or minus ')
       .replace(/\\to|\\rightarrow|\\mapsto/g,' to ').replace(/\\in/g,' in ')
       .replace(/\\forall/g,' for all ').replace(/\\exists/g,' there exists ')
       .replace(/\\infty/g,' infinity ').replace(/\\partial/g,' partial ').replace(/\\nabla/g,' del ');
    t=t.replace(/\\pi/g,' pi ').replace(/\\theta/g,' theta ').replace(/\\alpha/g,' alpha ')
       .replace(/\\beta/g,' beta ').replace(/\\gamma/g,' gamma ').replace(/\\lambda/g,' lambda ')
       .replace(/\\mu/g,' mu ').replace(/\\sigma/g,' sigma ').replace(/\\delta/g,' delta ');
    t=t.replace(/=/g,' equals ').replace(/\\left|\\right|\\,|\\;|\\!|\\quad|\\qquad|\\displaystyle/g,' ')
       .replace(/\\[a-zA-Z]+/g,' ').replace(/[{}\\]/g,' ');
    return t;
  }
  function toSpeech(md){
    return md
      .replace(/\[\[FOLLOWUPS\]\][\s\S]*$/i,'')
      .replace(/```[\s\S]*?```/g,'. (code block) ')
      .replace(/\$\$([\s\S]*?)\$\$/g,function(_,m){ return '. '+mathToWords(m)+' . '; })
      .replace(/\\\[([\s\S]*?)\\\]/g,function(_,m){ return '. '+mathToWords(m)+' . '; })
      .replace(/\$([^$\n]+)\$/g,function(_,m){ return ' '+mathToWords(m)+' '; })
      .replace(/\\\(([^\n]*?)\\\)/g,function(_,m){ return ' '+mathToWords(m)+' '; })
      .replace(/[#>*_`~|]/g,' ').replace(/\[(.*?)\]\(.*?\)/g,'$1')
      .replace(/\s+/g,' ').trim();
  }

  /* ── mic (English speech-to-text, auto-submit) ── */
  var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
  var rec=null, listening=false;
  if(!SR){ mic.style.display='none'; }
  mic.addEventListener('click',function(){
    if(!SR) return;
    if(listening){ try{rec.stop();}catch(_){} return; }
    try{
      rec=new SR(); rec.lang='en-US'; rec.interimResults=true; rec.continuous=false;
      var gotFinal=false;
      rec.onstart=function(){listening=true;gotFinal=false;mic.classList.add('on');};
      rec.onend=function(){
        listening=false;mic.classList.remove('on');
        if(gotFinal && ask.value.trim()) submit();
      };
      rec.onerror=function(e){
        listening=false;mic.classList.remove('on');
        // If wrong language, don't fail silently
        if(e.error==='no-speech'||e.error==='audio-capture') ask.value='';
      };
      rec.onresult=function(e){
        var t='';
        for(var i=0;i<e.results.length;i++){
          t+=e.results[i][0].transcript;
          if(e.results[i].isFinal) gotFinal=true;
        }
        ask.value=t; ask.dispatchEvent(new Event('input'));
      };
      rec.start();
    }catch(_){ listening=false; mic.classList.remove('on'); }
  });

  /* ── open / close ── (opening no longer auto-greets; the wake word does) */
  function open(){
    killTeaser(); panel.classList.add('open'); fab.classList.add('jn-hidden');
    if(!awake) sleepingHint(true);
    setTimeout(function(){ask.focus();},320);
  }
  function close(){
    panel.classList.remove('open'); fab.classList.remove('jn-hidden');
    stopSpeak();
    if(listening){try{rec.stop();}catch(_){}}
  }
  fab.addEventListener('click',open);
  q('#jin-x').addEventListener('click',close);
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&panel.classList.contains('open'))close();});

  /* ── render helpers ── */
  function escapeHtml(s){return s.replace(/[&<>"']/g,function(c){return{'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];});}
  function renderRich(el,text){
    if(window.marked){try{el.innerHTML=window.marked.parse(text,{breaks:true});}catch(_){el.textContent=text;}}
    else{el.innerHTML='<p>'+escapeHtml(text).replace(/\n/g,'<br>')+'</p>';}
    if(window.renderMathInElement){try{window.renderMathInElement(el,{delimiters:[
      {left:'$$',right:'$$',display:true},{left:'$',right:'$',display:false},
      {left:'\\[',right:'\\]',display:true},{left:'\\(',right:'\\)',display:false}
    ],throwOnError:false});}catch(_){}}
    thread.scrollTop=thread.scrollHeight;
  }

  /* ── read-along TTS: karaoke highlight + blur unread, reads to the end ── */
  function wrapWords(root){
    var spans=[]; var SKIP={CODE:1,PRE:1,SCRIPT:1,STYLE:1};
    function walk(node){
      if(node.nodeType===3){
        var p=node.parentNode; if(!p) return;
        if(SKIP[p.nodeName]) return;
        if(p.classList && (p.classList.contains('katex')||p.classList.contains('katex-display'))) return;
        var txt=node.nodeValue; if(!/\S/.test(txt)) return;
        var frag=document.createDocumentFragment();
        txt.split(/(\s+)/).forEach(function(part){
          if(part==='') return;
          if(/^\s+$/.test(part)){ frag.appendChild(document.createTextNode(part)); }
          else { var s=document.createElement('span'); s.className='jn-rw'; s.textContent=part; frag.appendChild(s); spans.push(s); }
        });
        p.replaceChild(frag,node);
      } else if(node.nodeType===1){
        if(SKIP[node.nodeName]) return;
        if(node.classList && node.classList.contains('katex')) return;
        Array.prototype.slice.call(node.childNodes).forEach(walk);
      }
    }
    walk(root); return spans;
  }
  function chunkSpeech(s){
    var out=[], parts=s.match(/[^.!?\n]+[.!?\n]*\s*/g)||[s], buf='';
    parts.forEach(function(p){
      if((buf+p).length>200 && buf){ out.push(buf.trim()); buf=p; } else buf+=p;
    });
    if(buf.trim()) out.push(buf.trim());
    return out.filter(Boolean);
  }
  var _along=null;
  function revealAll(state){
    if(!state) return;
    state.bubble.classList.remove('jn-reading');
    state.spans.forEach(function(s){ s.classList.remove('reading'); s.classList.add('read'); });
  }
  function stopSpeak(){
    try{ if(window.speechSynthesis) speechSynthesis.cancel(); }catch(_){}
    av.classList.remove('speaking');
    if(_along){ revealAll(_along); _along=null; }
  }
  function speakAlong(bubble, spans, md){
    if(!voiceOn || !window.speechSynthesis || !spans.length) return;
    stopSpeak();
    var clean=toSpeech(md); if(!clean) return;
    var state={bubble:bubble, spans:spans}; _along=state;
    bubble.classList.add('jn-reading');
    spans.forEach(function(s){ s.classList.remove('reading','read'); });
    var chunks=chunkSpeech(clean), ci=0, wi=0;
    function paint(i){
      if(i>=spans.length) i=spans.length-1; if(i<0) i=0;
      for(var k=0;k<spans.length;k++){
        var c=spans[k].classList;
        if(k<i){ c.add('read'); c.remove('reading'); }
        else if(k===i){ c.add('reading'); c.remove('read'); }
        else { c.remove('reading','read'); }
      }
      var cur=spans[i];
      if(cur && cur.scrollIntoView){ try{ cur.scrollIntoView({block:'nearest',inline:'nearest'}); }catch(_){} }
    }
    /* safety: if speech never actually starts, don't leave the text blurred */
    var started=false;
    setTimeout(function(){ if(_along===state && !started) revealAll(state); }, 1600);
    function next(){
      if(_along!==state) return;
      if(ci>=chunks.length){ revealAll(state); av.classList.remove('speaking'); if(_along===state)_along=null; return; }
      var u=new SpeechSynthesisUtterance(chunks[ci]);
      u.lang='en-US'; u.rate=1.05; u.pitch=1.0;
      var v=pickVoice(); if(v) u.voice=v;
      var baseWi=wi;
      var chunkWords=(chunks[ci].match(/\S+/g)||[]).length;
      var endWi=Math.min(baseWi+chunkWords, spans.length);
      var perWord=Math.max(150, Math.round(360/(u.rate||1)));
      var lastAdvance=0, timer=null;
      function advance(){ if(wi<endWi){ paint(wi); wi++; lastAdvance=Date.now(); } }
      function tick(){
        if(_along!==state || wi>=endWi){ if(timer){clearInterval(timer);timer=null;} return; }
        /* boundary-driven if events arrive; otherwise this timer keeps the highlight moving */
        if(Date.now()-lastAdvance >= perWord*0.9) advance();
      }
      u.onstart=function(){
        started=true; av.classList.add('speaking');
        advance();                                   /* light the first word right away */
        timer=setInterval(tick, Math.max(70, Math.round(perWord/2)));
      };
      u.onboundary=function(e){
        if(_along!==state) return;
        if(e.name && e.name!=='word') return;
        advance();                                   /* accurate when supported */
      };
      u.onend=function(){ if(timer)clearInterval(timer); wi=endWi; ci++; next(); };
      u.onerror=function(){ if(timer)clearInterval(timer); wi=endWi; ci++; next(); };
      try{ speechSynthesis.speak(u); }catch(_){ if(timer)clearInterval(timer); wi=endWi; ci++; next(); }
    }
    next();
  }
  function renderSpeak(bubble, md){
    renderRich(bubble, md);
    var spans=wrapWords(bubble);
    speakAlong(bubble, spans, md);
  }
  function addMsg(role,html){
    var m=document.createElement('div');
    m.className='jn-msg '+(role==='user'?'user':'ai');
    m.innerHTML='<div class="jn-who">'+(role==='user'?'YOU':'J')+'</div><div class="jn-bubble"></div>';
    m.querySelector('.jn-bubble').innerHTML=html;
    thread.appendChild(m); thread.scrollTop=thread.scrollHeight;
    return m.querySelector('.jn-bubble');
  }
  function showChips(list,labeled){
    if(!list||!list.length) return;
    var wrap=document.createElement('div'); wrap.className='jn-chips';
    if(labeled){var lb=document.createElement('div');lb.className='jn-chips-label';lb.textContent='Ask next';wrap.appendChild(lb);}
    list.forEach(function(qtext){
      var c=document.createElement('button'); c.className='jn-chip'; c.textContent=qtext;
      c.onclick=function(){ ask.value=qtext; ask.dispatchEvent(new Event('input')); submit(); };
      wrap.appendChild(c);
    });
    thread.appendChild(wrap); thread.scrollTop=thread.scrollHeight;
  }

  function splitReply(reply){
    var i=reply.search(/\[\[FOLLOWUPS\]\]/i);
    if(i===-1) return {answer:reply.trim(), follow:[]};
    var answer=reply.slice(0,i).trim();
    var rest=reply.slice(i).replace(/\[\[FOLLOWUPS\]\]/i,'').trim();
    var follow=rest.split('|').map(function(s){return s.trim();}).filter(Boolean).slice(0,3);
    return {answer:answer, follow:follow};
  }

  /* ============================================================
     WAKE-WORD GATE
     JIN stays dormant. The composer is reused: while asleep, any
     submitted text is tested against the wake word. Only "JIN"
     (with optional greeting/punctuation) ignites it. On wake JIN
     greets with "How can I help you?" and then accepts prompts.
     ============================================================ */
  var awake=false;
  var WAKE=/^\s*(?:hey|hi|hello|halo|hai|oi|woi|yo|ok(?:ay)?|eh)?[\s,]*jin[\s!?.…]*$/i;

  function sleepingHint(silent){
    note.textContent = 'Asleep \u2014 call my name to begin';
    if(silent) return;
    var prev=root.querySelector('.jn-nudge'); if(prev) prev.remove();
    var n=document.createElement('div'); n.className='jn-nudge';
    n.textContent = 'JIN is still dreaming\u2026 type \u201cJIN\u201d to summon me.';
    thread.appendChild(n); thread.scrollTop=thread.scrollHeight;
    setTimeout(function(){ n.classList.add('fade'); },2400);
    setTimeout(function(){ if(n.parentNode) n.remove(); },3000);
  }

  function ignite(){
    awake=true;
    panel.classList.remove('dormant'); panel.classList.add('awake');
    statusT.textContent = 'Online';
    ask.placeholder = 'Ask me anything\u2026';
    note.textContent = 'live reasoning \u00b7 verify anything that matters';
    flash.classList.add('fire');
    setTimeout(greet,420);
  }

  function greet(){
    DEPS.then(function(){
      var b=addMsg('ai','');
      renderSpeak(b,"**You called.** \u26a1\n\nI\u2019m JIN \u2014 Rafi\u2019s AI assistant. **How can I help you?** Ask me anything about Rafi \u2014 his projects, skills, background, or how to get in touch. I can also answer general questions about anything.");
      showChips(['Who is Rafi?','What are his skills?','Show me his projects','How to contact Rafi?'], true);
    });
  }

  function setBusy(b){
    av.classList.toggle('think',b);
    statusEl.classList.toggle('busy',b);
    statusT.textContent = b ? 'Thinking' : 'Online';
    send.disabled=b||!ask.value.trim();
  }

  /* ── call brain ── */
  async function callBrain(){
    var res=await fetch(JIN_API,{method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({model:MODEL,max_tokens:4000,system:SYSTEM,messages:history,
        tools:[{type:'web_search_20250305',name:'web_search'}]})});
    if(!res.ok){var t=await res.text().catch(function(){return '';});throw new Error('HTTP '+res.status+(t?(' \u2014 '+t.slice(0,140)):''));}
    var data=await res.json();
    var out=(data.content||[]).filter(function(x){return x.type==='text';}).map(function(x){return x.text;}).join('\n').trim();
    return out||'\u2026my thought finished empty. Ask me again?';
  }

  var pending=false;
  async function submit(){
    var qy=ask.value.trim(); if(!qy||pending) return;

    /* ── wake gate: if asleep, the only thing that matters is the name ── */
    if(!awake){
      ask.value=''; ask.style.height='auto'; ask.dispatchEvent(new Event('input'));
      if(WAKE.test(qy)){ ignite(); }
      else { sleepingHint(false); }
      return;
    }

    pending=true;
    addMsg('user',escapeHtml(qy));
    history.push({role:'user',content:qy});
    ask.value='';ask.style.height='auto';ask.dispatchEvent(new Event('input'));
    setBusy(true);
    var tEl=addMsg('ai','<div class="jn-think"><span></span><span></span><span></span></div>');
    try{
      await DEPS;
      var reply=await callBrain();
      var parts=splitReply(reply);
      history.push({role:'assistant',content:parts.answer});
      renderSpeak(tEl,parts.answer);
      showChips(parts.follow.length?parts.follow:['Go deeper','Give an example','Why does that matter?'], true);
    }catch(err){
      renderRich(tEl,"**My link to the deep store flickered.**\n\n`"+escapeHtml(String(err.message||err))+"`\n\nIf this is the live site, the browser can\u2019t reach Anthropic directly \u2014 deploy the proxy in `README-RAFI.txt` and point `JIN_API` at it.");
    }finally{ pending=false; setBusy(false); ask.focus(); }
  }

  ask.addEventListener('input',function(){
    ask.style.height='auto'; ask.style.height=Math.min(ask.scrollHeight,120)+'px';
    if(!pending) send.disabled=!ask.value.trim();
  });
  ask.addEventListener('keydown',function(e){if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();submit();}});
  send.addEventListener('click',submit);
})();
