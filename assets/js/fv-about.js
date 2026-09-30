/* ==========================================================================
   fv-about.js — About セクションの固定と「モザイク」切り替え（新卒・中途）

   デモ（デモ/NI_TOP.html「メッセージ節 → About キューブ・ディゾルブ」）と同じ動き:
   - .about-pin（Message の最後の 1 画面に重ねて始まる。高さ 210vh + 50px）の中で .about が sticky で 1 画面に固定
   - 開示（zone1）: pin の先頭から 0.6 画面ぶんのスクロールを z とし、z 0.85〜1.25 で
     縦バー 8 本（幅 + 80px オーバースキャン）が下からランダムな順にせり上がって About を覆い出す。
     clip-path: path(...) を 256 段階に量子化してキャッシュ（デモの buildPath "bars" 原文）
   - 抜け（zone2）: pin の終端 0.35 画面手前から、About より下（.after-about）を画面固定（.is-fixlock）にして
     同じ縦バーで About を覆い、終端で固定を解除して通常フローへ（境界で位置が一致するので継ぎ目なし）。
     覆う側の先頭に固定背景のクローン（白 + 波の動画 + 青ベール）を敷いて、縦バーの中から About が透けないようにする
     （demo の #fvbgfix）。抜け終わったら About を非表示にし、クローンは外す（以降は本来の固定背景が透ける）
   - 中身（.about__inner）は上下中央。画面が低くて入り切らないときは縮小して収める
   - ロゴ / Have Fun! の見える範囲は「バーの前線」で切る（coverTop()。ni-logo.js / fv-havefun.js が参照）
   - SP（〜767px）は動かない（About は通常フロー。2026-09-15 指示「about us と entry の切り替えアニメーションを SP ではなくす」）
   ========================================================================== */

const CFG = { bars: 8, topband: 0.25, dur: 0.30, lead: 0.85, span: 0.40, zone: 0.6, zone2: 0.35, lead2: 0.10, span2: 0.90, steps: 256 };

function hash(cx, cy) { const v = Math.sin(cx * 127.1 + cy * 311.7) * 43758.5453; return v - Math.floor(v); }
const eio = (u) => (u < 0.5 ? 4 * u * u * u : 1 - Math.pow(-2 * u + 2, 3) / 2);   /* easeInOutCubic */

/* 縦バー分割: 塊（ベース前線）がイーズイン/アウトでせり上がり、動きの差は上端の帯（画面高の 25%）だけ。
   各バーはランダムな順番で帯の中を先行 surge（easeOutCubic）し、上端がリズミカルに波打つ。終端は必ず全面被覆。決定論 */
export function buildBars(prog, W, H) {
  const N = CFG.bars, WO = W + 80, T = CFG.topband, dur = CFG.dur;
  const B = eio(prog) * (1 + T) - T;
  const ord = []; for (let k = 0; k < N; k++) ord.push(k);
  ord.sort((a, b) => hash(a, 17) - hash(b, 17));
  const rank = []; for (let k = 0; k < N; k++) rank[ord[k]] = k;
  let d = '';
  for (let i = 0; i < N; i++) {
    const s = N > 1 ? rank[i] * (1 - dur) / (N - 1) : 0;
    let u = (prog - s) / dur; u = u < 0 ? 0 : (u > 1 ? 1 : u);
    const E = 1 - Math.pow(1 - u, 3);
    let hh = B + T * E; hh = hh < 0 ? 0 : (hh > 1 ? 1 : hh);
    if (hh <= 0.002) continue;
    const x1 = Math.round(-40 + WO * i / N), x2 = Math.round(-40 + WO * (i + 1) / N);
    const ht = Math.round(H * hh);
    d += 'M' + x1 + ' ' + (H - ht) + 'h' + (x2 - x1) + 'v' + ht + 'h-' + (x2 - x1) + 'z';
  }
  return d;
}
/* ベース前線の高さ（0=下端, 1=上端）。ロゴなどの「覆われた範囲」の目安 */
function frontOf(prog) {
  const B = eio(prog) * (1 + CFG.topband) - CFG.topband;
  return B < 0 ? 0 : (B > 1 ? 1 : B);
}

function init() {
  /* SP（〜767px）は固定もモザイクもなし（通常フロー。components.css の SP 上書き。2026-09-15 指示）。
     window.__fvAbout も作らないので、ni-logo.js / fv-havefun.js は About の上端で切り、fv-message.js は About の上端で Message を隠す。
     判定は読み込み時のみ（ブレイクポイントをまたぐリサイズは非対応） */
  if (window.matchMedia('(max-width: 767px)').matches) return;
  /* 切り替えの一時停止スイッチ: <body data-sweep="off"> なら PC でも SP と同じ通常フロー（components.css の同名の上書き）。
     戻すときは HTML の属性を消すだけ（2026-09-16、動きの確認のため） */
  if (document.body.dataset.sweep === 'off') return;
  const pin = document.querySelector('.about-pin');
  const sec = pin && pin.querySelector('.about');
  const secs = document.querySelector('.after-about');
  if (!pin || !sec) return;
  const inner = sec.querySelector('.about__inner');
  const canPath = !!(window.CSS && CSS.supports && CSS.supports('clip-path', 'path("M0 0h1v1z")'));
  const clamp = (v, a, b) => (v < a ? a : (v > b ? b : v));

  const G = { start: 0, len: 1, W: 1, H: 1, z2s: 0, z2e: 0, len2: 1 };
  const cache = new Map();
  let cacheDim = '';
  function measure() {
    const HH = window.innerHeight || 1;
    G.H = HH;
    G.W = sec.clientWidth || 1;
    G.start = pin.offsetTop;                                  /* About が天面に固定され始める点 */
    G.len = Math.max(1, Math.round(HH * CFG.zone));
    G.z2e = pin.offsetTop + pin.offsetHeight - HH;            /* zone2 終端 = 固定解除点（after-about のフロー位置が天面に一致） */
    G.len2 = Math.max(1, Math.round(HH * CFG.zone2));
    G.z2s = G.z2e - G.len2;
    const dim = G.W + 'x' + G.H;
    if (dim !== cacheDim) { cacheDim = dim; cache.clear(); }
    fitInner();
  }
  /* 中身が画面に入り切らないときは縮小（上下中央のまま） */
  function fitInner() {
    if (!inner) return;
    inner.style.transform = '';
    const need = inner.getBoundingClientRect().height;
    const room = (window.innerHeight || 1) - 48;
    const s = need > room ? room / need : 1;
    inner.style.transform = s < 1 ? 'scale(' + s.toFixed(4) + ')' : '';
  }
  function pathForStep(st) {
    if (cache.has(st)) return cache.get(st);
    const d = buildBars(st / CFG.steps, G.W, G.H);
    cache.set(st, d);
    return d;
  }

  let lastKey = '', lastKey2 = '', fixed2 = false;
  function setClip(el, key, val, which) {
    if (which === 1) { if (key === lastKey) return; lastKey = key; }
    else { if (key === lastKey2) return; lastKey2 = key; }
    el.style.clipPath = val; el.style.webkitClipPath = val;
  }
  /* 覆う側の背景クローン（白 + 波の動画 + 青ベール）。抜けの間だけ表示（CSS: .is-fixlock 中） */
  let bgClone = null, bgVideo = null;
  function ensureBgClone() {
    if (bgClone || !secs) return;
    bgClone = document.createElement('div');
    bgClone.className = 'after-about__bg';
    bgClone.setAttribute('aria-hidden', 'true');
    const src = document.querySelector('.page-bg__video');
    if (src) {
      bgVideo = src.cloneNode(true);
      bgVideo.removeAttribute('id');
      bgVideo.muted = true; bgVideo.loop = true; bgVideo.autoplay = true;
      bgVideo.setAttribute('playsinline', '');
      bgClone.appendChild(bgVideo);
    }
    secs.insertBefore(bgClone, secs.firstChild);
  }
  let sweep = false;
  function setSweep(on) {
    if (on === sweep) return;
    sweep = on;
    if (on) {
      ensureBgClone();
      const src = document.querySelector('.page-bg__video');
      if (bgVideo) {
        try { if (src && src.readyState >= 2) bgVideo.currentTime = src.currentTime; } catch (e) {}
        const pr = bgVideo.play(); if (pr && pr.catch) pr.catch(() => {});
      }
    } else if (bgVideo) {
      try { bgVideo.pause(); } catch (e) {}
    }
  }

  let prog = 0, prog2 = 0;
  function frame() {
    const y = window.pageYOffset;
    /* ---- zone1: About の開示 ---- */
    const z = (y - G.start) / Math.max(1, G.len);
    const zs = clamp(z, 0, 1.3);
    prog = clamp((zs - CFG.lead) / CFG.span, 0, 1);
    if (!canPath) {
      setClip(sec, 'f', 'none', 1);
      sec.style.opacity = prog.toFixed(3);
    } else {
      const st = Math.round(prog * CFG.steps);
      if (st <= 0) setClip(sec, '0', 'path("M0 0z")', 1);
      else if (st >= CFG.steps) setClip(sec, '1', 'none', 1);
      else { const d = pathForStep(st); setClip(sec, 's' + st, d ? 'path("' + d + '")' : 'path("M0 0z")', 1); }
    }
    /* ---- zone2: About → 次セクション（同じモザイク） ---- */
    if (!secs) return;
    const z2 = (y - G.z2s) / Math.max(1, G.len2);
    const zs2 = clamp(z2, 0, 1.3);
    const rel2 = 1 - 3 / G.len2;   /* 固定中は文書が縮み最大スクロール = z2e ちょうどになるので 3px 手前で解除 */
    setSweep(z2 > 0 && z2 < rel2);   /* 抜けの間だけ背景クローンの動画を回す */
    if (!fixed2 && z2 > 0 && z2 < rel2) { secs.classList.add('is-fixlock'); fixed2 = true; }
    else if (fixed2 && (z2 >= rel2 || z2 <= 0)) { secs.classList.remove('is-fixlock'); fixed2 = false; }
    /* 抜け終わったら About は非表示（透明なセクションの下から透けない）。戻れば再表示 */
    const hideAbout = z2 >= rel2;
    if ((sec.style.visibility === 'hidden') !== hideAbout) sec.style.visibility = hideAbout ? 'hidden' : '';
    prog2 = clamp((zs2 - CFG.lead2) / CFG.span2, 0, 1);
    if (z2 >= 1 || !canPath) { setClip(secs, '1', 'none', 2); return; }
    if (prog2 <= 0) { setClip(secs, '0', 'path("M0 0z")', 2); return; }
    const st2 = Math.round(prog2 * CFG.steps);
    if (st2 >= CFG.steps) { setClip(secs, '1', 'none', 2); return; }
    const d2 = pathForStep(st2);
    setClip(secs, 's' + st2, d2 ? 'path("' + d2 + '")' : 'path("M0 0z")', 2);
  }

  let running = false;
  function loop() {
    if (!running) return;
    requestAnimationFrame(loop);
    frame();
  }
  function sync() {
    const want = !document.hidden;
    if (want && !running) { running = true; requestAnimationFrame(loop); }
    else if (!want) running = false;
  }
  document.addEventListener('visibilitychange', sync);
  try {
    const ro = new ResizeObserver(measure);
    ro.observe(document.documentElement); ro.observe(sec); ro.observe(pin);
  } catch (e) { window.addEventListener('resize', measure); }
  window.addEventListener('load', measure);
  measure();
  frame();
  sync();

  /* ロゴ / Have Fun! 用: About（またはその次）に覆われていない範囲の下端（画面 px）。
     開示前 = 画面高、開示中 = バーの前線、開示後 = 0 */
  window.__fvAbout = {
    CFG, G, frame, measure,
    get prog() { return prog; },
    get prog2() { return prog2; },
    coverTop() {
      const H = window.innerHeight || 1;
      if (prog <= 0) return H;
      if (prog >= 1) return 0;
      return H * (1 - frontOf(prog));
    }
  };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
