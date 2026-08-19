/* ============================================================
   RAFI VOICE ASSISTANT  (course.html)  v2
   - English + Bahasa Indonesia
   - Mic input (Web Speech API) + typed fallback + suggestion chips
   - Text-to-speech with live word-by-word highlight
   - Animated speaking waveform
   - Detailed knowledge base about Rafi (projects, certs, skills...)
   ============================================================ */
(function () {
  'use strict';

  /* base path for assets (works from / and /projects/) */
  var VA_BASE = (function () {
    var s = document.currentScript && document.currentScript.src;
    if (s) { return s.slice(0, s.lastIndexOf('/') + 1); }
    return (location.pathname.indexOf('/projects/') !== -1) ? '../' : '';
  })();
  var AVATAR = VA_BASE + 'assets/rafi_avatar.mp4';

  /* ---------- KNOWLEDGE BASE (all real, from the portfolio) ---------- */
  const KB = {
    name: 'Muhammad Rafi Arsya',
    email: 'rafiarsya.work@gmail.com',
    github: 'github.com/rafiarsya07',
    linkedin: 'linkedin.com/in/rafi-arsya-557335394',
    instagram: 'instagram.com/rarsya.03',

    projects: [
      { name: 'snip', kw: ['snip', 'url shortener', 'shortener', 'short link', 'serverless', 'lambda', 'pemendek', 'tautan'],
        en: 'snip is a serverless URL shortener built entirely on AWS with no traditional server to manage. A user pastes a long link, the API generates a short code, stores the mapping, and redirects anyone who visits the short link to the original. It runs on API Gateway and Lambda with DynamoDB for storage, deployed as infrastructure-as-code, so it scales to zero when idle and costs almost nothing to run.',
        id: 'snip adalah pemendek URL serverless yang dibangun sepenuhnya di AWS tanpa server tradisional untuk diurus. Pengguna menempel tautan panjang, API membuat kode pendek, menyimpan pemetaannya, lalu mengarahkan siapa pun yang membuka tautan pendek ke alamat aslinya. Berjalan di API Gateway dan Lambda dengan DynamoDB sebagai penyimpanan, di-deploy sebagai infrastructure-as-code, jadi menyusut ke nol saat menganggur dan hampir tanpa biaya.' },
      { name: 'HandGesture', kw: ['handgesture', 'hand gesture', 'gesture', 'webcam', 'draw'],
        en: 'HandGesture turns your webcam into a drawing canvas: raise your index finger and draw on screen, no mouse, stylus or touchscreen. It is built in Python with OpenCV for video capture and MediaPipe Hands for 21-landmark detection, tracking up to four hands at over 30 frames per second on a normal laptop CPU.',
        id: 'HandGesture mengubah webcam jadi kanvas gambar: angkat jari telunjuk dan menggambar di layar, tanpa mouse, stylus, atau layar sentuh. Dibuat dengan Python, OpenCV untuk menangkap video, dan MediaPipe Hands untuk deteksi 21 titik tangan, melacak hingga empat tangan di atas 30 frame per detik di CPU laptop biasa.' },
      { name: 'CampusBay', kw: ['campusbay', 'campus bay', 'marketplace', 'store'],
        en: 'CampusBay is a production-grade peer-to-peer student marketplace Rafi is building solo. Registration is gated to institutional emails verified by a six-digit OTP, so every user is a real student. It has real-time chat, Stripe payments, an escrow-style order state machine, flash sales, a wallet system and AI support. Built with React, Node.js, PostgreSQL, Redis, Socket.IO and Docker, and live at campusbay.store.',
        id: 'CampusBay adalah marketplace mahasiswa peer-to-peer kelas produksi yang dibangun Rafi sendiri. Pendaftaran dibatasi untuk email kampus yang diverifikasi lewat OTP enam digit, jadi setiap pengguna adalah mahasiswa asli. Ada chat real-time, pembayaran Stripe, alur pesanan bergaya escrow, flash sale, sistem dompet, dan dukungan AI. Dibuat dengan React, Node.js, PostgreSQL, Redis, Socket.IO, dan Docker, serta sudah live di campusbay.store.' },
      { name: 'Crop Disease Detector', kw: ['crop', 'disease', 'plant', 'leaf', 'tanaman', 'daun', 'penyakit'],
        en: 'Crop Disease Detector is an AI that looks at a single leaf photo and identifies which of 38 disease conditions a plant likely has. It uses MobileNetV2 with transfer learning, trained on the PlantVillage dataset of over 87,000 images across 14 crop types, reaching about 97 percent accuracy. It is live and free on Hugging Face Spaces.',
        id: 'Crop Disease Detector adalah AI yang melihat satu foto daun dan menentukan salah satu dari 38 kondisi penyakit tanaman. Menggunakan MobileNetV2 dengan transfer learning, dilatih pada dataset PlantVillage berisi lebih dari 87.000 gambar dari 14 jenis tanaman, dengan akurasi sekitar 97 persen. Sudah live dan gratis di Hugging Face Spaces.' },
      { name: 'PaperMind', kw: ['papermind', 'paper mind', 'rag', 'pdf', 'paper'],
        en: 'PaperMind started from a frustration: ChatGPT giving confidently wrong answers about research papers. So Rafi built a local RAG tool that actually reads the PDF first. It splits the paper into overlapping chunks, embeds them with nomic-embed-text, stores them in ChromaDB, and answers strictly from the document. It runs fully privately on self-hosted hardware with FastAPI, Ollama and React.',
        id: 'PaperMind lahir dari rasa frustrasi: ChatGPT memberi jawaban yang salah dengan percaya diri soal paper penelitian. Maka Rafi membuat alat RAG lokal yang benar-benar membaca PDF dulu. Paper dipecah jadi potongan yang tumpang tindih, di-embed dengan nomic-embed-text, disimpan di ChromaDB, dan dijawab khusus dari dokumen itu. Berjalan sepenuhnya privat di perangkat sendiri dengan FastAPI, Ollama, dan React.' },
      { name: 'NASE Accessibility', kw: ['nase', 'accessibility', 'aksesibilitas', 'wcag', 'disabled', 'impaired'],
        en: 'NASE Accessibility began as an HCI course project and became personal. Rafi audited the NASE platform used by visually impaired students in Malaysia, found 23 issues categorised by WCAG 2.1 severity, redesigned the components, and built an AI-powered contrast analysis pipeline with Python and OpenCV.',
        id: 'NASE Accessibility berawal dari proyek mata kuliah HCI lalu jadi personal. Rafi mengaudit platform NASE yang dipakai mahasiswa tunanetra di Malaysia, menemukan 23 masalah yang dikategorikan menurut tingkat WCAG 2.1, mendesain ulang komponennya, dan membuat pipeline analisis kontras berbasis AI dengan Python dan OpenCV.' },
      { name: 'RafiFinance', kw: ['rafifinance', 'finance', 'keuangan', 'money', 'budget', 'tracker'],
        en: 'RafiFinance is a personal finance tracker Rafi built as a single HTML file, with no server, database or framework. It handles transactions, budgets, saving goals, a financial health score and a six-month analysis, and works offline as a PWA using vanilla JavaScript and localStorage.',
        id: 'RafiFinance adalah pelacak keuangan pribadi yang dibuat Rafi sebagai satu file HTML, tanpa server, database, atau framework. Menangani transaksi, anggaran, target tabungan, skor kesehatan finansial, dan analisis enam bulan, serta bisa jalan offline sebagai PWA dengan JavaScript murni dan localStorage.' },
      { name: 'BriskWalk', kw: ['briskwalk', 'brisk walk', 'charity', 'walk', 'event', 'registration', 'ppi'],
        en: 'BriskWalk is the event registration platform Rafi designed and built for PPI Malaysia\u2019s annual charity walk: a single-page, mobile-first form where participants sign up, pay the fee and upload documents. Designed in Figma and built with vanilla HTML, CSS and JavaScript, with client-side image compression and a Google Sheets backend.',
        id: 'BriskWalk adalah platform pendaftaran acara yang Rafi desain dan bangun untuk jalan amal tahunan PPI Malaysia: form satu halaman, mobile-first, tempat peserta mendaftar, membayar biaya, dan mengunggah dokumen. Didesain di Figma dan dibuat dengan HTML, CSS, dan JavaScript murni, dengan kompresi gambar di sisi klien dan backend Google Sheets.' },
      { name: 'Steam Market', kw: ['steam', 'sql', 'sqlite', 'wasm', 'dashboard', 'analytics'],
        en: 'Steam Market Intelligence is a live in-browser SQL analytics dashboard. It runs real SQLite compiled to WebAssembly, querying a 1,400-title game-market dataset on every page load, entirely on the visitor\u2019s machine, with no backend and no precomputed export. It showcases window functions, recursive CTEs and rolling calculations.',
        id: 'Steam Market Intelligence adalah dashboard analitik SQL langsung di browser. Menjalankan SQLite asli yang dikompilasi ke WebAssembly, mengkueri dataset pasar game berisi 1.400 judul setiap halaman dimuat, sepenuhnya di mesin pengunjung, tanpa backend dan tanpa ekspor pra-hitung. Menampilkan window function, recursive CTE, dan kalkulasi bergulir.' },
      { name: 'CSA Study App', kw: ['csa', 'study', 'exam', 'wres1201', 'architecture', 'belajar', 'ujian'],
        en: 'CSA Study App is a self-contained exam prep tool for Computer Systems Architecture, built during finals week. It has topic guides, a formula reference, MCQ drills and interactive visualizers for cache mapping, Hamming codes and arithmetic shifts, with every number re-randomized on each reload so it never goes stale.',
        id: 'CSA Study App adalah alat persiapan ujian mandiri untuk Computer Systems Architecture, dibuat saat minggu ujian. Ada panduan topik, referensi rumus, latihan soal pilihan ganda, dan visualizer interaktif untuk cache mapping, kode Hamming, dan arithmetic shift, dengan setiap angka diacak ulang tiap reload supaya tidak basi.' },
      { name: 'Resume Match', kw: ['resume', 'match', 'scoring', 'job', 'cv', 'lamaran'],
        en: 'Resume Match answers how well a resume fits a job listing, without sending any data to an AI API. Upload a resume PDF and a job description and the engine returns a fit score with matched, missing and extra skills, using pure tokenization, synonym canonicalization and weighted scoring. Built with React, Node.js and pdfjs-dist.',
        id: 'Resume Match menjawab seberapa cocok sebuah resume dengan lowongan, tanpa mengirim data apa pun ke API AI. Unggah PDF resume dan deskripsi pekerjaan, lalu mesinnya memberi skor kecocokan beserta skill yang cocok, yang kurang, dan nilai tambah, memakai tokenisasi murni, kanonikalisasi sinonim, dan pembobotan. Dibuat dengan React, Node.js, dan pdfjs-dist.' },
      { name: 'Arena Duel', kw: ['arena', 'duel', 'arenaduel', 'multiplayer', 'real-time', 'realtime', 'game', 'socket', 'websocket', '1v1', 'fighting'],
        en: 'Arena Duel is a server-authoritative real-time 1v1 multiplayer game. Two players on different devices each pick a secret action every round \u2014 Attack, Defend or Special \u2014 and the server waits for both, or a timeout, then resolves the clash exactly once from a fixed 3x3 matchup table, applies damage and cooldowns, and broadcasts the result to both screens at the same time. The client only sends intents, never results, so it is impossible to fake a win from a modified client. All game state lives in memory with no database, and it handles concurrency, disconnects and a per-round timer entirely on the server. Built with Node.js, Express, Socket.IO and a React front end.',
        id: 'Arena Duel adalah game multiplayer 1v1 real-time yang otoritasnya ada di server. Dua pemain di perangkat berbeda memilih aksi rahasia tiap ronde \u2014 Attack, Defend, atau Special \u2014 dan server menunggu keduanya, atau timeout, lalu menyelesaikan bentrokan tepat satu kali dari tabel matchup 3x3, menerapkan damage dan cooldown, dan menyiarkan hasilnya ke kedua layar bersamaan. Klien hanya mengirim niat aksi, bukan hasil, jadi mustahil memalsukan kemenangan dari klien yang dimodifikasi. Seluruh state game ada di memori tanpa database, dan menangani konkurensi, disconnect, serta timer per ronde sepenuhnya di server. Dibuat dengan Node.js, Express, Socket.IO, dan front end React.' },
      { name: 'Reminder Me', kw: ['reminder', 'reminder me', 'pendamping', 'companion', 'habit', 'kebiasaan', 'pomodoro', 'focus', 'fokus', 'pwa', 'apk', 'twa', 'productivity', 'produktivitas'],
        en: 'Reminder Me, called Pendamping, is an offline-first personal companion app for student life. It brings habits with streaks, a Pomodoro focus timer, tasks, a calendar, exams with a countdown, progress tracking, health logging, a journal and prayer times into one place, and its home screen uses deterministic priority logic \u2014 ranked by urgency and time of day in Malaysia time \u2014 to surface only the one or two things that matter right now. It ships as both an installable PWA and a signed Android APK wrapped through a Trusted Web Activity, all from one codebase. There is no backend and no account: every byte of data stays on the device in localStorage, with a one-tap full JSON export. Built with React 18 and Vite.',
        id: 'Reminder Me, yang disebut Pendamping, adalah aplikasi pendamping pribadi offline-first untuk kehidupan mahasiswa. Menggabungkan kebiasaan dengan streak, timer fokus Pomodoro, tugas, kalender, ujian dengan hitung mundur, pelacakan progress, catatan kesehatan, jurnal, dan jadwal salat dalam satu tempat, dan layar utamanya memakai logika prioritas deterministik \u2014 diurutkan berdasarkan urgensi dan waktu hari dalam zona waktu Malaysia \u2014 untuk memunculkan hanya satu atau dua hal yang penting saat ini. Dirilis sebagai PWA yang bisa diinstal sekaligus APK Android bertanda tangan yang dibungkus lewat Trusted Web Activity, semuanya dari satu basis kode. Tidak ada backend dan tidak ada akun: setiap data tetap di perangkat dalam localStorage, dengan ekspor JSON lengkap sekali ketuk. Dibuat dengan React 18 dan Vite.' }
    ],

    certificates: [
      { t: 'AWS Certified Developer Associate (DVA-C02)', p: 'Udemy', g: 'cloud' },
      { t: 'AWS Certified AI Practitioner (AIF-C01)', p: 'Udemy', g: 'cloud' },
      { t: 'Docker for the Absolute Beginner (DevOps)', p: 'Udemy', g: 'devops' },
      { t: 'Legacy JavaScript Algorithms and Data Structures', p: 'freeCodeCamp', g: 'js' },
      { t: 'Complete Full Stack Web Development Bootcamp \u2013 AI Integrated', p: 'Udemy', g: 'fullstack' },
      { t: 'The Complete Full-Stack Web Development Bootcamp', p: 'Udemy', g: 'fullstack' },
      { t: 'The Complete JavaScript Course 2025: From Zero to Expert', p: 'Udemy', g: 'js' },
      { t: 'React JS Bootcamp (Netflix, YouTube clones + 3 projects)', p: 'Udemy', g: 'react' },
      { t: 'Build Responsive Real-World Websites with HTML and CSS', p: 'Udemy', g: 'web' },
      { t: 'Build 30 Web Projects with HTML, CSS, and JavaScript', p: 'Udemy', g: 'web' },
      { t: '50 Projects in 50 Days \u2013 HTML, CSS & JavaScript', p: 'Udemy', g: 'web' },
      { t: 'From Java Dev to AI Engineer: Spring AI Fast Track', p: 'Udemy', g: 'ai' },
      { t: 'Learn Game Development with JavaScript', p: 'Udemy', g: 'js' },
      { t: 'SQL for Data Analysis: Advanced SQL Querying Techniques', p: 'Udemy', g: 'data' },
      { t: 'Creating a Responsive HTML Email', p: 'Udemy', g: 'web' },
      { t: 'Spec-Driven Development dengan Kiro', p: 'Dicoding', g: 'ai' },
      { t: 'Belajar Dasar Cloud dan Gen AI di AWS', p: 'Dicoding', g: 'cloud' },
      { t: 'KIOS Mental Health 2026', p: 'Other', g: 'other' },
      { t: 'IELTS Academic \u2013 Band 5.5 (CEFR B2)', p: 'Other', g: 'english' }
    ],

    skills: {
      Frontend: ['React', 'Next.js', 'TypeScript', 'JavaScript (ES6+)', 'HTML5', 'CSS3', 'Tailwind CSS', 'Vite', 'TanStack React Query'],
      Backend: ['Node.js', 'Express.js', 'FastAPI', 'PostgreSQL', 'MySQL', 'Redis', 'REST APIs', 'JWT', 'Sequelize ORM', 'Socket.IO', 'Java'],
      'AI / ML': ['Python', 'TensorFlow', 'Keras', 'PyTorch', 'OpenCV', 'MediaPipe', 'NumPy'],
      DevOps: ['Docker', 'Docker Compose', 'NGINX', 'Linux', 'Git', 'GitHub', 'Cloudflare', 'AWS'],
      Design: ['Figma', 'Canva']
    },

    experience: {
      en: 'Rafi was Head of Website Division at PPI Malaysia, leading the team that develops and maintains the official PPI Malaysia website. He was also Head of Department for the Art Exhibition at IDFEST, PPI University of Malaya, managing it end to end to showcase Indonesian culture. And he volunteered in the Transportation Team and Field Committee for LARAS in 2026.',
      id: 'Rafi adalah Head of Website Division di PPI Malaysia, memimpin tim yang mengembangkan dan memelihara website resmi PPI Malaysia. Ia juga Head of Department untuk Art Exhibition di IDFEST, PPI University of Malaya, mengelolanya dari awal sampai akhir untuk menampilkan budaya Indonesia. Ia juga jadi relawan di Tim Transportasi dan Field Committee untuk LARAS pada 2026.'
    },
    education: {
      en: 'Rafi is studying a Bachelor of Computer Science with a Software Engineering specialization at the University of Malaya, Malaysia.',
      id: 'Rafi sedang menempuh S1 Ilmu Komputer dengan spesialisasi Rekayasa Perangkat Lunak di University of Malaya, Malaysia.'
    },
    who: {
      en: 'Rafi is a Bachelor of Computer Science student specialising in Software Engineering at the University of Malaya. He focuses on software engineering and full-stack development, and enjoys building systems that solve real problems. His interest in web development started in school.',
      id: 'Rafi adalah mahasiswa S1 Ilmu Komputer jurusan Rekayasa Perangkat Lunak di University of Malaya. Ia fokus pada rekayasa perangkat lunak dan pengembangan full-stack, dan senang membangun sistem yang menyelesaikan masalah nyata. Minatnya pada web development dimulai sejak sekolah.'
    },
    location: {
      en: 'Rafi is an Indonesian student based in Kuala Lumpur, Malaysia, where he studies at the University of Malaya. He works comfortably with remote teams across time zones.',
      id: 'Rafi adalah mahasiswa asal Indonesia yang berbasis di Kuala Lumpur, Malaysia, tempat ia kuliah di University of Malaya. Ia terbiasa bekerja dengan tim remote lintas zona waktu.'
    },
    interests: {
      en: 'Outside coursework, Rafi likes building side projects that scratch a real itch \u2014 a finance tracker, a study app during finals week, an offline companion app for his own daily routine. He is drawn to AI and machine learning, clean system design, and shipping things that actually run rather than staying as ideas.',
      id: 'Di luar perkuliahan, Rafi senang membuat side project yang menjawab kebutuhan nyata \u2014 pelacak keuangan, aplikasi belajar saat minggu ujian, aplikasi pendamping offline untuk rutinitasnya sendiri. Ia tertarik pada AI dan machine learning, desain sistem yang rapi, dan merilis hal yang benar-benar jalan, bukan sekadar ide.'
    },
    philosophy: {
      en: 'Rafi likes to build the hard part for real instead of faking it: server-authoritative game logic, RAG that actually reads the document, marketplace flows with real payment and escrow states. He cares about owning the data, keeping things private where it matters, and writing systems simple enough to reason about end to end.',
      id: 'Rafi suka membangun bagian yang sulitnya secara nyata, bukan pura-pura: logika game yang otoritasnya di server, RAG yang benar-benar membaca dokumen, alur marketplace dengan pembayaran dan status escrow asli. Ia peduli pada kepemilikan data, menjaga privasi di tempat yang penting, dan menulis sistem yang cukup sederhana untuk dipahami dari ujung ke ujung.'
    },
    whyHire: {
      en: 'Rafi ships end to end and solo: he has taken projects from Figma design to deployed production, handled both front end and back end, and is comfortable across web, AI/ML and serverless. He learns fast, holds AWS Developer and AI Practitioner certifications, and led a real team as Head of Website Division at PPI Malaysia.',
      id: 'Rafi mengerjakan dari awal sampai akhir dan secara mandiri: ia membawa proyek dari desain Figma sampai produksi yang ter-deploy, menangani front end dan back end, dan nyaman di web, AI/ML, maupun serverless. Ia cepat belajar, punya sertifikasi AWS Developer dan AI Practitioner, dan memimpin tim nyata sebagai Head of Website Division di PPI Malaysia.'
    },
    availability: {
      en: 'Rafi is open to internships, freelance work and collaborations in software engineering, full-stack and AI. The fastest way to reach him is email at rafiarsya.work@gmail.com, or through GitHub and LinkedIn.',
      id: 'Rafi terbuka untuk magang, kerja freelance, dan kolaborasi di software engineering, full-stack, dan AI. Cara tercepat menghubunginya adalah lewat email di rafiarsya.work@gmail.com, atau lewat GitHub dan LinkedIn.'
    },
    funfacts: {
      en: 'A few things about Rafi: he built a whole personal finance app as a single HTML file with no framework, he made a study app during his own finals week, and several of his projects run with no backend at all, on purpose, to keep them private and basically free to host.',
      id: 'Beberapa hal soal Rafi: ia membuat seluruh aplikasi keuangan pribadi sebagai satu file HTML tanpa framework, ia membuat aplikasi belajar saat minggu ujiannya sendiri, dan beberapa proyeknya sengaja jalan tanpa backend sama sekali supaya tetap privat dan nyaris gratis untuk di-host.'
    }
  };

  /* ---------- LANGUAGES: English + Indonesian ---------- */
  const LANGS = [
    { code: 'en-US', label: 'English', flag: '\uD83C\uDDEC\uD83C\uDDE7' },
    { code: 'id-ID', label: 'Bahasa Indonesia', flag: '\uD83C\uDDEE\uD83C\uDDE9' }
  ];

  const UI = {
    'en-US': {
      title: 'Ask Rafi\u2019s Assistant',
      hi: 'Hi! Ask me anything about Rafi.',
      listen: 'Listening\u2026', think: 'One moment\u2026', speaking: 'Speaking\u2026',
      ph: 'Type your question\u2026',
      greet: 'Hi! I\u2019m Rafi\u2019s assistant. You can ask about his projects, skills, education, experience, certificates, or how to contact him. Try one of these:',
      nomatch: 'I can tell you about Rafi. Try one of these:',
      chips: ['Who is Rafi?', 'His projects', 'His skills', 'Why hire Rafi?', 'How to contact']
    },
    'id-ID': {
      title: 'Tanya Asisten Rafi',
      hi: 'Hai! Tanya apa saja tentang Rafi.',
      listen: 'Mendengarkan\u2026', think: 'Sebentar\u2026', speaking: 'Berbicara\u2026',
      ph: 'Ketik pertanyaan Anda\u2026',
      greet: 'Hai! Saya asisten Rafi. Kamu bisa tanya soal proyek, keahlian, pendidikan, pengalaman, sertifikat, atau cara menghubunginya. Coba salah satu di bawah:',
      nomatch: 'Saya bisa cerita soal Rafi. Coba salah satu di bawah:',
      chips: ['Siapa Rafi?', 'Proyeknya', 'Keahliannya', 'Kenapa rekrut Rafi?', 'Cara kontak']
    }
  };

  let activeLang = 'en-US';
  function L() { return activeLang === 'id-ID' ? 'id' : 'en'; }

  /* ---------- ANSWER BUILDERS ---------- */
  function answerProjects() {
    const names = KB.projects.map(function (p) { return p.name; }).join(', ');
    return activeLang === 'id-ID'
      ? 'Rafi punya ' + KB.projects.length + ' proyek utama: ' + names + '. Tanya nama salah satunya untuk detailnya.'
      : 'Rafi has ' + KB.projects.length + ' featured projects: ' + names + '. Ask about any one by name for the details.';
  }
  function answerSkills() {
    const g = Object.keys(KB.skills).map(function (k) {
      return k + ': ' + KB.skills[k].slice(0, 6).join(', ');
    }).join('. ');
    return (activeLang === 'id-ID' ? 'Keahlian utama Rafi. ' : 'Rafi\u2019s main skills. ') + g + '.';
  }
  function answerCerts() {
    const total = KB.certificates.length;
    const list = KB.certificates.slice(0, 8).map(function (c) { return c.t; }).join('; ');
    return activeLang === 'id-ID'
      ? 'Rafi punya ' + total + ' sertifikat dari Udemy, freeCodeCamp, Dicoding, dan AWS. Di antaranya: ' + list + ', dan lainnya termasuk IELTS Academic band 5.5.'
      : 'Rafi has ' + total + ' certificates from Udemy, freeCodeCamp, Dicoding and AWS. They include: ' + list + ', plus others including an IELTS Academic band 5.5.';
  }
  function answerContact() {
    return activeLang === 'id-ID'
      ? 'Kamu bisa menghubungi Rafi lewat email di ' + KB.email + ', di GitHub ' + KB.github + ', atau di LinkedIn.'
      : 'You can reach Rafi by email at ' + KB.email + ', on GitHub at ' + KB.github + ', or on LinkedIn.';
  }

  /* ---------- SMALL TALK (natural, but always loops back to Rafi) ---------- */
  function pick(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

  function timeGreeting() {
    var h = new Date().getHours();
    if (activeLang === 'id-ID') {
      var part = h < 11 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 19 ? 'Selamat sore' : 'Selamat malam';
      return part + '! Saya asisten Rafi. Mau tahu soal proyek, keahlian, atau cara menghubunginya?';
    }
    var p = h < 12 ? 'Good morning' : h < 18 ? 'Good afternoon' : 'Good evening';
    return p + '! I\u2019m Rafi\u2019s assistant. Want to hear about his projects, skills, or how to reach him?';
  }
  function answerThanks() {
    return activeLang === 'id-ID'
      ? pick(['Sama-sama! Ada lagi yang mau ditanyakan soal Rafi?',
              'Dengan senang hati. Mau lihat proyek Rafi yang lain?',
              'Siap! Kalau mau, saya bisa cerita soal keahlian atau pengalaman Rafi.'])
      : pick(['You\u2019re welcome! Anything else about Rafi?',
              'Happy to help. Want to see more of Rafi\u2019s projects?',
              'Anytime! I can also tell you about Rafi\u2019s skills or experience.']);
  }
  function answerHowAreYou() {
    return activeLang === 'id-ID'
      ? 'Saya cuma asisten kecil di portofolio Rafi, jadi selalu siap, ha! Tapi lebih seru ngomongin Rafi. Mau mulai dari proyek atau keahliannya?'
      : 'I\u2019m just a little assistant living in Rafi\u2019s portfolio, so always ready! But Rafi is the interesting one. Want to start with his projects or his skills?';
  }
  function answerWhoAreYou() {
    return activeLang === 'id-ID'
      ? 'Saya asisten virtual di portofolio Rafi. Tugas saya menjawab apa pun soal Rafi \u2014 proyek, keahlian, pendidikan, pengalaman, sertifikat, dan cara menghubunginya. Coba tanya, misalnya, \u201cproyek Rafi\u201d.'
      : 'I\u2019m the virtual assistant on Rafi\u2019s portfolio. My job is to answer anything about Rafi \u2014 his projects, skills, education, experience, certificates and how to reach him. Try asking, say, \u201cRafi\u2019s projects\u201d.';
  }
  function answerRafiDoing() {
    return activeLang === 'id-ID'
      ? 'Rafi sedang kuliah S1 Ilmu Komputer di University of Malaya sambil terus membangun proyek \u2014 dari marketplace mahasiswa sampai aplikasi pendamping offline. Mau saya ceritakan salah satu?'
      : 'Rafi is doing his Computer Science degree at the University of Malaya while constantly building projects \u2014 from a student marketplace to an offline companion app. Want me to walk you through one?';
  }
  function answerJoke() {
    return activeLang === 'id-ID'
      ? pick(['Kenapa Rafi suka proyek tanpa backend? Biar nggak ada server yang bisa ngambek tengah malam. Tapi serius, mau lihat salah satu proyeknya?',
              'Rafi bilang bug itu fitur yang belum didokumentasikan. Ngomong-ngomong, mau tahu proyek favoritnya?'])
      : pick(['Why does Rafi love no-backend projects? So no server can crash at 3am. But seriously \u2014 want to see one of them?',
              'Rafi says a bug is just an undocumented feature. Anyway, want to hear about his favourite project?']);
  }
  function findProject(q) {
    const ql = q.toLowerCase();
    return KB.projects.find(function (p) {
      return p.kw.some(function (k) { return ql.indexOf(k) !== -1; });
    });
  }

  /* ---------- INTENT ROUTER ---------- */
  function route(qRaw) {
    const q = qRaw.toLowerCase().trim();
    const lang = L();
    const has = function (arr) { return arr.some(function (w) { return q.indexOf(w) !== -1; }); };
    const firstWord = q.split(/\s+/)[0];
    const isWord = function (arr) { return arr.indexOf(firstWord) !== -1 || arr.indexOf(q) !== -1; };

    /* --- small talk first, so it feels natural --- */
    // thanks
    if (has(['thank', 'thanks', 'thx', 'terima kasih', 'makasih', 'mksh', 'thank you'])) return answerThanks();
    // greetings (time-aware)
    var greetWords = ['hi', 'hii', 'hiii', 'hello', 'helo', 'hey', 'heyy', 'halo', 'hai', 'haii',
      'yo', 'sup', 'hola', 'assalamualaikum', 'pagi', 'siang', 'sore', 'malam'];
    if (isWord(greetWords) || has(['good morning', 'good afternoon', 'good evening', 'good night',
      'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'])) {
      return timeGreeting();
    }
    // how are you
    if (has(['how are you', 'how r u', 'how are u', 'apa kabar', 'gimana kabar', 'kabarnya', "what's up", 'whats up', 'wassup'])) return answerHowAreYou();
    // who/what are you (the assistant itself)
    if (has(['who are you', 'what are you', 'are you a bot', 'are you ai', 'are you real', 'your name',
      'siapa kamu', 'kamu siapa', 'kamu bot', 'kamu ai', 'kamu robot', 'namamu', 'nama kamu'])) return answerWhoAreYou();
    // what is rafi doing now
    if (has(['what is rafi doing', "what's rafi doing", 'rafi doing now', 'rafi sekarang', 'rafi lagi ngapain', 'rafi sedang apa', 'lagi ngapain'])) return answerRafiDoing();
    // joke / fun
    if (has(['joke', 'funny', 'make me laugh', 'lelucon', 'lucu', 'becanda', 'candaan', 'humor'])) return answerJoke();
    // help / menu / what can you do
    if (has(['help', 'menu', 'what can you do', 'what can i ask', 'apa yang bisa', 'bisa apa', 'bantuan', 'tolong'])) {
      return { greet: true, text: UI[activeLang].greet };
    }

    /* --- a specific project always wins next --- */
    const proj = findProject(qRaw);
    if (proj) return proj[lang];

    /* --- expanded Rafi knowledge --- */
    if (has(['where', 'location', 'based', 'live', 'lives', 'country', 'city', 'remote', 'dimana', 'di mana', 'tinggal', 'lokasi', 'negara', 'kota'])) return KB.location[lang];
    if (has(['why hire', 'why should', 'hire rafi', 'why rafi', 'strength', 'good at', 'kenapa rekrut', 'kenapa pilih', 'kelebihan', 'kenapa rafi'])) return KB.whyHire[lang];
    if (has(['available', 'availability', 'hiring', 'internship', 'freelance', 'open to', 'looking for work', 'tersedia', 'magang', 'lowongan', 'terbuka', 'cari kerja'])) return KB.availability[lang];
    if (has(['interest', 'hobby', 'hobbies', 'like to', 'passion', 'enjoy', 'free time', 'minat', 'hobi', 'suka', 'waktu luang', 'gemar'])) return KB.interests[lang];
    if (has(['philosophy', 'approach', 'how does he build', 'how he build', 'mindset', 'principle', 'filosofi', 'pendekatan', 'cara membangun', 'prinsip', 'cara kerja'])) return KB.philosophy[lang];
    if (has(['fun fact', 'fun facts', 'interesting', 'surprising', 'cool thing', 'fakta menarik', 'fakta unik', 'unik', 'menarik'])) return KB.funfacts[lang];

    /* --- core categories --- */
    if (has(['project', 'projek', 'proyek', 'portfolio', 'build', 'built', 'bikin', 'buat', 'karya'])) return answerProjects();
    if (has(['skill', 'kemahiran', 'keahlian', 'tech', 'stack', 'language', 'programming', 'bahasa pemrograman', 'kemampuan'])) return answerSkills();
    if (has(['experience', 'pengalaman', 'work', 'kerja', 'job', 'leader', 'led', 'ppi', 'organization', 'organisasi', 'volunteer', 'relawan'])) return KB.experience[lang];
    if (has(['education', 'study', 'studi', 'belajar', 'university', 'universiti', 'universitas', 'degree', 'major', 'pendidikan', 'kuliah', 'jurusan'])) return KB.education[lang];
    if (has(['certificate', 'cert', 'sijil', 'sertifikat', 'course', 'kursus', 'ielts', 'aws'])) return answerCerts();
    if (has(['contact', 'email', 'reach', 'hubungi', 'kontak', 'github', 'linkedin', 'instagram'])) return answerContact();
    if (has(['who', 'siapa', 'about', 'tentang', 'introduce', 'profile', 'rafi', 'profil'])) return KB.who[lang];

    return { greet: true, text: UI[activeLang].nomatch };
  }

  /* ---------- PAGE CONTEXT (works on every page) ---------- */
  function detectPage() {
    var path = (location.pathname || '').toLowerCase();
    var file = path.split('/').pop() || 'index.html';
    if (file === '' || file === 'index.html') return 'home';
    if (file === 'course.html') return 'course';
    if (file === 'resume.html') return 'resume';
    if (file === 'contact.html') return 'contact';
    if (file === 'blog.html') return 'blogindex';
    if (file.indexOf('blog-') === 0) return 'blogpost';
    if (file === 'projects.html') return 'projectindex';
    if (file.indexOf('project') === 0) return 'projectpage';
    return 'home';
  }
  // map a specific project/blog page to a KB project (by keyword in title)
  function pageProject() {
    var hay = ((document.title || '') + ' ' + (location.pathname || '')).toLowerCase();
    // also scan first heading text
    var h = document.querySelector('.p-hero-title, .blog-title, h1');
    if (h) hay += ' ' + h.textContent.toLowerCase();
    return KB.projects.find(function (p) {
      return p.kw.some(function (k) { return hay.indexOf(k) !== -1; });
    }) || null;
  }

  var PAGE = detectPage();

  // context intro + chips per page, per language
  function pageContext() {
    var en = activeLang === 'en-US';
    var proj = pageProject();
    switch (PAGE) {
      case 'course':
        return en
          ? { intro: 'You\u2019re on Rafi\u2019s Courses & Certificates page. Want to know what he has been learning?', chips: ['His certificates', 'His skills', 'AWS certifications', 'Who is Rafi?'] }
          : { intro: 'Kamu di halaman Kursus & Sertifikat Rafi. Mau tahu apa saja yang sudah ia pelajari?', chips: ['Sertifikatnya', 'Keahliannya', 'Sertifikat AWS', 'Siapa Rafi?'] };
      case 'resume':
        return en
          ? { intro: 'This is Rafi\u2019s resume. Want a quick summary?', chips: ['His experience', 'His education', 'His skills', 'How to contact'] }
          : { intro: 'Ini resume Rafi. Mau ringkasan singkat?', chips: ['Pengalamannya', 'Pendidikannya', 'Keahliannya', 'Cara kontak'] };
      case 'contact':
        return en
          ? { intro: 'Want to get in touch with Rafi? I can help.', chips: ['How to contact', 'His email', 'His GitHub', 'Who is Rafi?'] }
          : { intro: 'Mau menghubungi Rafi? Saya bantu.', chips: ['Cara kontak', 'Emailnya', 'GitHub-nya', 'Siapa Rafi?'] };
      case 'projectindex':
      case 'blogindex':
        return en
          ? { intro: 'Looking at Rafi\u2019s projects. Curious about any of them?', chips: ['His projects', 'CampusBay', 'PaperMind', 'His skills'] }
          : { intro: 'Sedang melihat proyek Rafi. Penasaran salah satunya?', chips: ['Proyeknya', 'CampusBay', 'PaperMind', 'Keahliannya'] };
      case 'projectpage':
      case 'blogpost':
        if (proj) {
          return en
            ? { intro: 'You\u2019re reading about ' + proj.name + '. Want the quick version?', chips: ['About ' + proj.name, 'His other projects', 'His skills', 'Who is Rafi?'] }
            : { intro: 'Kamu sedang membaca tentang ' + proj.name + '. Mau versi singkatnya?', chips: ['Tentang ' + proj.name, 'Proyek lainnya', 'Keahliannya', 'Siapa Rafi?'] };
        }
        return en
          ? { intro: 'Curious about this project? Ask me anything.', chips: ['His projects', 'His skills', 'Who is Rafi?', 'How to contact'] }
          : { intro: 'Penasaran dengan proyek ini? Tanya saja.', chips: ['Proyeknya', 'Keahliannya', 'Siapa Rafi?', 'Cara kontak'] };
      default: // home
        return en
          ? { intro: UI['en-US'].greet, chips: UI['en-US'].chips }
          : { intro: UI['id-ID'].greet, chips: UI['id-ID'].chips };
    }
  }

  /* ---------- BUILD UI ---------- */
  const root = document.createElement('div');
  root.id = 'va-root';
  root.innerHTML =
    '<button id="va-fab" aria-label="Voice assistant">' +
      '<video src="' + AVATAR + '" autoplay loop muted playsinline></video>' +
    '</button>' +
    '<div id="va-teaser" role="button" tabindex="0" aria-label="Open assistant">' +
      '<span id="va-teaser-text"></span>' +
      '<button id="va-teaser-x" aria-label="Dismiss">\u2715</button>' +
    '</div>' +
    '<div id="va-panel" role="dialog" aria-label="Ask about Rafi">' +
      '<div id="va-head">' +
        '<div id="va-head-l">' +
          '<span id="va-av"><video src="' + AVATAR + '" autoplay loop muted playsinline></video>' +
            '<span id="va-wave" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>' +
          '</span>' +
          '<div><div id="va-title">Ask Rafi\u2019s Assistant</div><div id="va-status">Hi! Ask me anything about Rafi.</div></div>' +
        '</div>' +
        '<button id="va-x" aria-label="Close">\u2715</button>' +
      '</div>' +
      '<div id="va-lang-wrap">' +
        '<button id="va-lang-btn" type="button" aria-haspopup="listbox" aria-expanded="false">' +
          '<span id="va-lang-flag"></span><span id="va-lang-text"></span>' +
          '<svg id="va-lang-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>' +
        '</button>' +
      '</div>' +
      '<div id="va-log"></div>' +
      '<div id="va-row">' +
        '<input id="va-text" type="text" autocomplete="off" />' +
        '<button id="va-mic" aria-label="Speak"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v6a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="18" x2="12" y2="22"/></svg></button>' +
        '<button id="va-send" aria-label="Send"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></button>' +
      '</div>' +
    '</div>';
  document.body.appendChild(root);

  /* language list lives at root level (sibling of #va-panel), never
     nested inside an overflow:hidden/transformed ancestor, so it can
     never get visually clipped no matter where the trigger button sits. */
  const langList = document.createElement('ul');
  langList.id = 'va-lang-list';
  langList.setAttribute('role', 'listbox');
  LANGS.forEach(function (l) {
    const li = document.createElement('li');
    li.setAttribute('role', 'option');
    li.dataset.code = l.code;
    li.innerHTML = '<span>' + l.flag + '</span><span>' + l.label + '</span>';
    langList.appendChild(li);
  });
  root.appendChild(langList);

  const langBtn = root.querySelector('#va-lang-btn');
  const langFlag = root.querySelector('#va-lang-flag');
  const langText = root.querySelector('#va-lang-text');

  function setLangButtonDisplay() {
    const cur = LANGS.find(function (l) { return l.code === activeLang; }) || LANGS[0];
    langFlag.textContent = cur.flag;
    langText.textContent = cur.label;
    langList.querySelectorAll('li').forEach(function (li) {
      li.classList.toggle('active', li.dataset.code === activeLang);
    });
  }
  setLangButtonDisplay();

  function positionLangList() {
    const r = langBtn.getBoundingClientRect();
    langList.style.left = Math.round(r.left) + 'px';
    langList.style.top = Math.round(r.bottom + 6) + 'px';
    langList.style.minWidth = Math.round(r.width) + 'px';
  }
  function openLangList() {
    positionLangList();
    langList.classList.add('open');
    langBtn.setAttribute('aria-expanded', 'true');
  }
  function closeLangList() {
    langList.classList.remove('open');
    langBtn.setAttribute('aria-expanded', 'false');
  }
  langBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    if (langList.classList.contains('open')) closeLangList(); else openLangList();
  });
  langList.addEventListener('click', function (e) {
    const li = e.target.closest('li');
    if (!li) return;
    activeLang = li.dataset.code;
    setLangButtonDisplay();
    applyLang();
    const c = log.querySelector('.va-chips'); if (c) c.remove();
    closeLangList();
  });
  document.addEventListener('click', function (e) {
    if (!langList.contains(e.target) && e.target !== langBtn) closeLangList();
  });
  window.addEventListener('resize', function () {
    if (langList.classList.contains('open')) positionLangList();
  });

  const fab = root.querySelector('#va-fab');
  const panel = root.querySelector('#va-panel');
  const statusEl = root.querySelector('#va-status');
  const avatarWrap = root.querySelector('#va-av');
  const log = root.querySelector('#va-log');
  const txt = root.querySelector('#va-text');
  const micBtn = root.querySelector('#va-mic');
  const sendBtn = root.querySelector('#va-send');

  function applyLang() {
    txt.placeholder = UI[activeLang].ph;
    statusEl.textContent = UI[activeLang].hi;
    root.querySelector('#va-title').textContent = UI[activeLang].title;
  }
  applyLang();

  function openPanel() {
    panel.classList.add('open');
    fab.classList.add('hidden');
    welcome();
    setTimeout(function () { txt.focus(); }, 120);
  }
  function closePanel() {
    panel.classList.remove('open');
    fab.classList.remove('hidden');
    stopSpeak();
    closeLangList();
    if (recog && recognizing) recog.stop();
  }
  fab.addEventListener('click', openPanel);
  root.querySelector('#va-x').addEventListener('click', closePanel);


  function addBubble(who, text) {
    const b = document.createElement('div');
    b.className = 'va-b va-' + who;
    b.textContent = text;
    log.appendChild(b);
    log.scrollTop = log.scrollHeight;
    return b;
  }
  function addChips(list) {
    const old = log.querySelector('.va-chips'); if (old) old.remove();
    const wrap = document.createElement('div');
    wrap.className = 'va-chips';
    (list || UI[activeLang].chips || []).forEach(function (label) {
      const c = document.createElement('button');
      c.className = 'va-chip'; c.type = 'button'; c.textContent = label;
      c.addEventListener('click', function () { handle(label); });
      wrap.appendChild(c);
    });
    log.appendChild(wrap);
    log.scrollTop = log.scrollHeight;
  }

  /* ---------- TEXT TO SPEECH + word highlight + waveform ---------- */
  let voices = [];
  function loadVoices() { voices = window.speechSynthesis ? speechSynthesis.getVoices() : []; }
  if (window.speechSynthesis) { loadVoices(); speechSynthesis.onvoiceschanged = loadVoices; }

  /* Prefer a firm, deeper MALE voice for each language.
     Web Speech only exposes whatever voices the user's OS/browser ships,
     so we rank by known male voice names, then fall back gracefully. */
  var MALE_HINTS = {
    en: ['google uk english male', 'microsoft guy', 'microsoft david', 'microsoft mark',
         'daniel', 'alex', 'fred', 'arthur', 'oliver', 'aaron', 'rishi', 'male'],
    id: ['microsoft ardi', 'ardi', 'damar', 'google bahasa indonesia', 'male']
  };
  var FEMALE_HINTS = ['female', 'zira', 'susan', 'samantha', 'victoria', 'karen',
                      'moira', 'tessa', 'fiona', 'gadis', 'google us english'];

  function scoreVoice(v, lang) {
    if (!v || !v.lang) return -999;
    var base = lang.split('-')[0];
    var n = (v.name || '').toLowerCase();
    var score = 0;
    if (v.lang.toLowerCase() === lang.toLowerCase()) score += 40;      // exact locale
    else if (v.lang.toLowerCase().indexOf(base) === 0) score += 20;    // same language
    else return -999;                                                  // wrong language
    var hints = MALE_HINTS[base] || MALE_HINTS.en;
    for (var i = 0; i < hints.length; i++) {
      if (n.indexOf(hints[i]) !== -1) { score += (hints.length - i) + 15; break; }
    }
    for (var j = 0; j < FEMALE_HINTS.length; j++) {
      if (n.indexOf(FEMALE_HINTS[j]) !== -1) { score -= 30; break; }    // avoid female
    }
    if (v.localService) score += 3;                                    // crisper offline voice
    return score;
  }

  function bestVoice(lang) {
    if (!voices.length) loadVoices();
    if (!voices.length) return null;
    var best = null, bestScore = -1000;
    for (var i = 0; i < voices.length; i++) {
      var s = scoreVoice(voices[i], lang);
      if (s > bestScore) { bestScore = s; best = voices[i]; }
    }
    return best;
  }
  function setSpeaking(on) {
    if (on) { avatarWrap.classList.add('va-talking'); statusEl.textContent = UI[activeLang].speaking; }
    else { avatarWrap.classList.remove('va-talking'); statusEl.textContent = UI[activeLang].hi; }
  }
  function stopSpeak() {
    if (window.speechSynthesis) speechSynthesis.cancel();
    setSpeaking(false);
    // clear any leftover highlight
    const hl = log.querySelector('.va-hl'); if (hl) clearHighlight(hl);
  }

  // wrap a bubble's text into per-word spans for highlighting
  function prepareHighlight(bubble, text) {
    bubble.textContent = '';
    bubble.classList.add('va-hl');
    const words = text.split(/(\s+)/); // keep spaces
    const map = []; // [{el, start, end}]
    let idx = 0;
    words.forEach(function (w) {
      if (/^\s+$/.test(w)) { bubble.appendChild(document.createTextNode(w)); idx += w.length; return; }
      const s = document.createElement('span');
      s.className = 'va-w'; s.textContent = w;
      bubble.appendChild(s);
      map.push({ el: s, start: idx, end: idx + w.length });
      idx += w.length;
    });
    return map;
  }
  function clearHighlight(bubble) {
    bubble.classList.remove('va-hl');
    bubble.querySelectorAll('.va-w').forEach(function (s) { s.classList.remove('on'); });
  }

  function speak(text, bubble) {
    if (!window.speechSynthesis) { setSpeaking(false); return; }
    stopSpeak();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = activeLang;
    const v = bestVoice(activeLang); if (v) u.voice = v;
    u.rate = 0.98; u.pitch = 0.82;  /* slightly slower + lower = firmer, more assertive */

    const map = prepareHighlight(bubble, text);
    let last = null;
    u.onstart = function () { setSpeaking(true); };
    u.onboundary = function (e) {
      if (e.name && e.name !== 'word' && e.name !== '') return;
      const ci = e.charIndex || 0;
      const hit = map.find(function (m) { return ci >= m.start && ci < m.end; });
      if (hit) {
        if (last) last.classList.remove('on');
        hit.el.classList.add('on');
        last = hit.el;
        hit.el.scrollIntoView({ block: 'nearest' });
      }
    };
    const finish = function () {
      setSpeaking(false);
      if (last) last.classList.remove('on');
      clearHighlight(bubble);
    };
    u.onend = finish; u.onerror = finish;
    speechSynthesis.speak(u);
  }

  /* ---------- HANDLE A QUESTION ---------- */
  function handle(question) {
    const q = (question || '').trim();
    if (!q) return;
    const oldChips = log.querySelector('.va-chips'); if (oldChips) oldChips.remove();
    addBubble('user', q);
    statusEl.textContent = UI[activeLang].think;
    const ans = route(q);
    const text = (ans && typeof ans === 'object') ? ans.text : ans;
    const bubble = addBubble('bot', text);
    if (ans && typeof ans === 'object' && ans.greet) addChips();
    speak(text, bubble);
  }

  let welcomed = false;
  function welcome() {
    if (welcomed) return; welcomed = true;
    const ctx = pageContext();
    addBubble('bot', ctx.intro);
    addChips(ctx.chips);
  }

  sendBtn.addEventListener('click', function () { const q = txt.value; txt.value = ''; handle(q); });
  txt.addEventListener('keydown', function (e) { if (e.key === 'Enter') { const q = txt.value; txt.value = ''; handle(q); } });

  /* ---------- IDLE TEASER BUBBLE (once, ~5s after load) ---------- */
  const teaser = root.querySelector('#va-teaser');
  const teaserText = root.querySelector('#va-teaser-text');
  function teaserMessage() {
    var en = activeLang === 'en-US';
    var proj = pageProject();
    switch (PAGE) {
      case 'course':
        return en ? 'Want to know what Rafi has been learning? \uD83D\uDC4B' : 'Mau tahu Rafi belajar apa saja? \uD83D\uDC4B';
      case 'resume':
        return en ? 'Curious about Rafi\u2019s background? Ask me!' : 'Penasaran latar belakang Rafi? Tanya aku!';
      case 'contact':
        return en ? 'Want to reach Rafi? I can help \uD83D\uDC4B' : 'Mau menghubungi Rafi? Aku bantu \uD83D\uDC4B';
      case 'projectpage':
      case 'blogpost':
        if (proj) return en ? 'Want the quick story behind ' + proj.name + '?' : 'Mau cerita singkat soal ' + proj.name + '?';
        return en ? 'Curious about this project? Ask me!' : 'Penasaran dengan proyek ini? Tanya aku!';
      case 'projectindex':
      case 'blogindex':
        return en ? 'Curious about any of Rafi\u2019s projects?' : 'Penasaran sama proyek-proyek Rafi?';
      default:
        return en ? 'Hi! Want to get to know Rafi? \uD83D\uDC4B' : 'Hai! Mau kenalan sama Rafi? \uD83D\uDC4B';
    }
  }
  let teaserShown = false, teaserTimer = null;
  function showTeaser() {
    if (teaserShown) return;
    if (panel.classList.contains('open')) return; // don't show if already chatting
    teaserShown = true;
    teaserText.textContent = teaserMessage();
    teaser.classList.add('show');
    // auto-hide after a while if ignored
    setTimeout(function () { teaser.classList.remove('show'); }, 12000);
  }
  function hideTeaser() { teaser.classList.remove('show'); teaserShown = true; if (teaserTimer) clearTimeout(teaserTimer); }
  teaser.addEventListener('click', function (e) {
    if (e.target && e.target.id === 'va-teaser-x') { hideTeaser(); e.stopPropagation(); return; }
    hideTeaser(); openPanel();
  });
  teaser.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { hideTeaser(); openPanel(); } });
  teaserTimer = setTimeout(showTeaser, 5000);

  // idle "breathing" pulse on the FAB until first interaction
  fab.classList.add('va-idle');
  fab.addEventListener('click', function () { fab.classList.remove('va-idle'); hideTeaser(); }, { once: true });


  // mobile: stop speaking cleanly when the tab goes to background
  document.addEventListener('visibilitychange', function () {
    if (document.hidden && window.speechSynthesis) { speechSynthesis.cancel(); if (typeof setSpeaking === 'function') setSpeaking(false); }
  });

  /* ---------- SPEECH TO TEXT (mic) ---------- */
  let recognizing = false, recog = null;
  const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
  if (!SR) {
    micBtn.disabled = true;
    micBtn.title = 'Voice input is not supported in this browser. Please type instead.';
    micBtn.classList.add('va-disabled');
  } else {
    micBtn.addEventListener('click', function () {
      if (recognizing) { recog.stop(); return; }
      stopSpeak();
      recog = new SR();
      recog.lang = activeLang;
      recog.interimResults = false; recog.maxAlternatives = 1;
      recog.onstart = function () { recognizing = true; micBtn.classList.add('va-rec'); statusEl.textContent = UI[activeLang].listen; };
      recog.onerror = function () { recognizing = false; micBtn.classList.remove('va-rec'); statusEl.textContent = UI[activeLang].hi; };
      recog.onend = function () { recognizing = false; micBtn.classList.remove('va-rec'); };
      recog.onresult = function (ev) { handle(ev.results[0][0].transcript); };
      try { recog.start(); } catch (e) {}
    });
  }
})();
