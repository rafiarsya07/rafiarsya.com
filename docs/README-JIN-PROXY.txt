════════════════════════════════════════════════════════════
  JIN — PROXY SETUP  ·  fixing "Failed to fetch"  (baca pelan2)
════════════════════════════════════════════════════════════

KENAPA "Failed to fetch" MUNCUL
  JIN nyambung ke "otaknya" lewat internet — dia ngirim
  pertanyaan ke model Claude di server Anthropic, terus nampilin
  jawabannya. Itu artinya:

  • Di Claude canvas  → jalan langsung (kunci API disuntik otomatis).
  • Di situs LIVE lo  → browser GAK BOLEH manggil api.anthropic.com
    langsung. Dua alasan:
       1) Kunci API gak boleh ditaruh di kode browser (nanti dicuri).
       2) Anthropic blokir panggilan langsung dari browser (CORS).

  Solusinya: PROXY kecil di server yang nyimpen kunci API. Browser
  manggil proxy lo → proxy yang manggil Anthropic → balikin jawaban.
  Lo jalanin semuanya di Cloudflare, jadi Worker = paling gampang.

  PENTING: JIN "pengetahuannya semua" itu DATANG dari model Claude
  lewat proxy ini. JIN sendiri GAK punya dataset di folder lo, dan
  pengetahuan AI gak bisa di-download ke dalam file. Begitu proxy
  jalan, JIN langsung bisa jawab apa aja.


─── LANGKAH 1: PUNYA API KEY ──────────────────────────────────
  1. Masuk ke  https://console.anthropic.com
  2. Bikin akun / login, isi billing (ada free credit buat coba).
  3. Buka "API Keys" → "Create Key" → COPY kuncinya (sk-ant-...).
     Simpan baik2, jangan ditaruh di kode browser / GitHub publik.


─── LANGKAH 2: BIKIN CLOUDFLARE WORKER ────────────────────────
  1. Masuk  https://dash.cloudflare.com  → menu "Workers & Pages".
  2. "Create" → "Create Worker" → kasih nama, misal: jin-brain
  3. "Deploy" dulu (biar jadi), terus "Edit code".
  4. HAPUS semua kode contoh, GANTI dengan isi worker.js di bawah.
  5. "Deploy".


─── LANGKAH 3: SIMPAN API KEY SEBAGAI SECRET ──────────────────
  Di halaman Worker → Settings → "Variables and Secrets"
   → "Add" → tipe: Secret
   → Name (HARUS persis):  ANTHROPIC_API_KEY
   → Value: paste kunci sk-ant-... lo
   → Save / Deploy.

  (Jangan taruh kunci langsung di kode. Pakai Secret biar aman.)


─── LANGKAH 4: ARAHKAN JIN KE PROXY ───────────────────────────
  URL Worker lo kira2 begini:
     https://jin-brain.<subdomain-lo>.workers.dev

  Buka rafi-core.js, baris paling atas, ganti:
     var JIN_API = "https://api.anthropic.com/v1/messages";
  jadi:
     var JIN_API = "https://jin-brain.<subdomain-lo>.workers.dev";

  Simpan, upload ulang ke situs. Selesai — JIN bakal nyaut beneran,
  gak ada lagi "Failed to fetch".

  (Opsional rapi: route Worker di bawah domain lo, misal
   rafiarsya.com/api/jin, terus set JIN_API = "/api/jin".)


─── LANGKAH 5: KUNCI CORS KE DOMAIN LO (disarankan) ───────────
  Di worker.js, ganti baris:
     res.headers.set("Access-Control-Allow-Origin", "*");
  jadi domain lo doang biar gak dipakai orang lain:
     res.headers.set("Access-Control-Allow-Origin", "https://rafiarsya.com");


════════════════════════════════════════════════════════════
  worker.js  — COPY SEMUA INI KE WORKER LO
════════════════════════════════════════════════════════════

export default {
  async fetch(req, env) {
    // preflight
    if (req.method === "OPTIONS") return cors(new Response(null, { status: 204 }));
    if (req.method !== "POST")    return cors(new Response("POST only", { status: 405 }));

    const body = await req.text();

    const r = await fetch("https://api.anthropic.com/v1/messages", {
      method: "POST",
      headers: {
        "content-type": "application/json",
        "x-api-key": env.ANTHROPIC_API_KEY,
        "anthropic-version": "2023-06-01"
      },
      body
    });

    // teruskan balasan apa adanya (termasuk error dari Anthropic)
    return cors(new Response(r.body, r));
  }
};

function cors(res) {
  // ganti "*" jadi "https://rafiarsya.com" buat lebih aman
  res.headers.set("Access-Control-Allow-Origin", "*");
  res.headers.set("Access-Control-Allow-Headers", "content-type");
  res.headers.set("Access-Control-Allow-Methods", "POST, OPTIONS");
  return res;
}

════════════════════════════════════════════════════════════
  CEK & TROUBLESHOOT
════════════════════════════════════════════════════════════
  • Masih "Failed to fetch"
      - URL JIN_API salah / typo → cek lagi.
      - Worker belum di-deploy → deploy ulang.
      - CORS: kalau lo set ke domain spesifik, pastikan PERSIS sama
        (https, tanpa trailing slash).
  • "HTTP 401"  → secret ANTHROPIC_API_KEY salah/kosong.
  • "HTTP 400"  → body request aneh; jarang, biasanya dari edit kode.
  • "HTTP 429"  → kena rate limit / kuota; cek billing di console.
  • Buka tab Network di browser (F12) buat liat status aslinya.

────────────────────────────────────────────────────────────
  KNOBS (atas rafi-core.js)
    JIN_API    — alamat proxy (default Anthropic; ganti ke Worker)
    MODEL      — claude-sonnet-4-6
    SYSTEM     — persona JIN + blok ABOUT_RAFI (isi bio lo di sana)
    ABOUT_RAFI — fakta tentang Rafi; isi CV/bio lo, JIN baca ini
    max_tokens — panjang jawaban (4000)
════════════════════════════════════════════════════════════
