/* ==========================================================================
   fv-message.js — Message セクション（楽しんで働ける場を創る。）の動き（新卒・中途）

   2 つのモード:
   A. 画面固定モード（.message--fixed。新卒 = demo と同じく Message の直後が About）
      デモ（デモ/NI_TOP.html「セクション1」）と同じ構造・同じ動き。Message は通常のフローに置かず（position: fixed）、
      スクロール量は FV の余白（150vh）だけ。About のピンは余白の直後から始まる（demo と同じ margin-top -100vh - 50px）。
      動きは 3 層の合成（demo の entry / rise / s1w と同じ）:
      1. 出現（entry）: 進行度 0.24〜0.35（慣性つき p、easeOutCubic。SP は 0.20〜0.31）で、画面下（+60px）から定位置へ塊のままヌルっと上がる。
         定位置 = 見出しが画面上端から 28.77%（demo の s1-heading の top）
      2. せり上がり（rise）: 定位置で文章の下端が画面下から 160px 以上はみ出るとき（低い画面）、はみ出し + 160px ぶんを
         進行度 0.28〜0.52（慣性なしの生値 pT、線形）で持ち上げる
      3. 半速で流す（s1w）: スクロール量が About 開始位置の 52% を超えたら、超えたぶんの 0.5 倍だけ上へ動かす
         （通常スクロールの半分の速さで抜けていく）。About の切り替えゾーンの終わり（開始 + 1.3 ゾーン）で打ち切り
      About に完全に覆われたら非表示
   B. フローモード（中途 = Message の後に Openings などが続くので固定にできない。新卒 SP もこちら: 2026-09-15）
      1 の出現だけ同じ。0.35 で見出しが 28.77% に来るよう上マージンを JS で決め、以降は通常スクロールで 1:1 に上がる
   - どちらも上がり切るまでボタンは押せない（k > 0.6 で有効）
   - 追従ヘッダー（.header の is-fixed）はここで付ける: 出現が半分（k > 0.5）を過ぎたら付け、FV に戻れば外す
     （「FV が終わって Have Fun! のセクションに来たタイミング」。common.js の FV 通過判定は使わない）
   進行度は fv-scroll.js（ロゴ・コピー・写真と共用）。About の位置は fv-about.js（window.__fvAbout.G）。
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

const ENTRY_START = 0.24, ENTRY_LEN = 0.11;   /* demo: u = (p - 0.24) / 0.11、easeOutCubic */
/* SP は開始だけ 0.20 に早める（上がる速さは同じ）。SP は Have Fun! が Message と一緒に動くので、demo の 0.24 だと
   コピーが消えてから Message が来るまでロゴしかない空白が長い。0.16 だとコピー・写真と重なる（2026-09-15 指示） */
const ENTRY_START_SP = 0.20;   /* 2026-09-17: SP の Insight のワイプは元の 3 倍の距離（fv-copy.js の WIPE_SLOW_SP）に伸ばしたが、Have Fun! の登場はここのまま（遅らせると間が空く。文字同士は重ならない） */
const SP_MQ = window.matchMedia('(max-width: 767px)');
const entryStart = () => (SP_MQ.matches ? ENTRY_START_SP : ENTRY_START);
const HEAD_TOP = 0.2877;                      /* demo: s1-heading の top（画面高さ比） */
const EXTRA = 60;                             /* 出現前に画面下端からさらに下に隠しておく余白 (px) */
const RISE_START = 0.28, RISE_LEN = 0.24;     /* demo: U = (pT - s1RiseStart(0.28)) / 0.24 */
const RISE_EXTRA = 160;                       /* demo: s1RiseExtra */
const FREE_FROM = 0.52, RATE = 0.5;           /* demo: Y0 = G.start * 0.52、rate 0.5 */
const ZONE = 0.6, ZONE_CAP = 1.3;             /* demo: G.len = 0.6 画面、打ち切り G.start + 1.3 * G.len */
const HEADER_AT = 0.5;                        /* 出現がここまで進んだら追従ヘッダーを出す */
const HF_WIPE_TOP = 0.92;                     /* SP: Have Fun! のワイプが始まる画面位置（上端が画面高のこの比率）。fv-havefun.js と同じ値 */

function entryK() {
  const u = Math.max(0, Math.min(1, (fv.p - entryStart()) / ENTRY_LEN));
  return 1 - Math.pow(1 - u, 3);
}

/* ---------- A. 画面固定モード ---------- */
function initFixed(msg) {
  const head = msg.querySelector('.message__title') || msg;
  const body = msg.querySelector('.message__body') || msg;
  const btn = msg.querySelector('a, button');
  const pin = document.querySelector('.about-pin');
  const aboutEl = document.querySelector('.about');

  let G = { restTy: 0, travel: 0, lift: 0 };
  function layout() {
    const H = window.innerHeight;
    msg.style.transform = 'none';
    const mr = msg.getBoundingClientRect();
    const headTop = head.getBoundingClientRect().top - mr.top;
    const restTy = HEAD_TOP * H - headTop;
    /* 出現の移動量: 見える部分（Have Fun! が隠れている新卒は本文の塊）の上端が画面下 + EXTRA から定位置へ */
    let blockTop = Infinity;
    for (const el of msg.children) {
      if (getComputedStyle(el).visibility === 'hidden') continue;
      blockTop = Math.min(blockTop, el.getBoundingClientRect().top - mr.top);
    }
    if (!isFinite(blockTop)) blockTop = 0;
    const travel = Math.max(0, H - (restTy + blockTop)) + EXTRA;
    const bodyBottom = restTy + (body.getBoundingClientRect().bottom - mr.top);
    const lift = Math.max(0, bodyBottom - H + RISE_EXTRA);
    G = { restTy, travel, lift };
    msg.style.transform = '';
    lastT = '';   /* 測定で transform を消したので、次のフレームで同じ値でも必ず書き直す */
  }
  function aboutGeo() {
    const A = window.__fvAbout && window.__fvAbout.G;
    if (A && A.start > 0) return { start: A.start, len: A.len };
    const H = window.innerHeight;
    return { start: pin ? pin.offsetTop : H * 0.5, len: Math.max(1, Math.round(H * ZONE)) };
  }

  let lastT = '', lastV = '';
  function frame() {
    fv.tick(performance.now());
    const k = entryK();
    let ty = G.restTy + (1 - k) * G.travel;                                   /* 1. 出現 */
    const U = Math.max(0, Math.min(1, (fv.pT - RISE_START) / RISE_LEN));
    ty -= G.lift * U;                                                          /* 2. せり上がり（低い画面のみ） */
    const a = aboutGeo();
    const y = Math.min(window.pageYOffset, a.start + ZONE_CAP * a.len);
    ty -= RATE * Math.max(0, y - a.start * FREE_FROM);                         /* 3. 半速で流す */
    const t = 'translateY(' + ty.toFixed(1) + 'px)';
    if (t !== lastT) { lastT = t; msg.style.transform = t; }
    /* About に完全に覆われたら非表示。fv-about.js が動かない SP は、通常フローの About の上端が画面上端を越えたら */
    const covered = window.__fvAbout ? window.__fvAbout.prog >= 1 : !!(aboutEl && aboutEl.getBoundingClientRect().top <= 0);
    const v = (covered || k <= 0) ? 'hidden' : '';
    if (v !== lastV) { lastV = v; msg.style.visibility = v; }
    if (btn) btn.style.pointerEvents = k > 0.6 ? '' : 'none';
  }
  return { frame, layout, get G() { return G; }, mode: 'fixed' };
}

/* ---------- B. フローモード ---------- */
function initFlow(msg) {
  const spacer = document.querySelector('[data-fv-scroll]');
  const head = msg.querySelector('.message__title') || msg;
  const btn = msg.querySelector('a, button');
  let ty = 0;
  /* 上マージン: 上がり切る進行度（出現開始 + ENTRY_LEN）のスクロール量で、見出しが画面上端から HEAD_TOP に来る位置 */
  function layout() {
    if (!spacer) return;
    msg.style.marginTop = '';
    msg.style.transform = '';
    ty = 0;
    const H = window.innerHeight;
    const headOffset = head.getBoundingClientRect().top - msg.getBoundingClientRect().top;
    const spacerBottom = spacer.offsetTop + spacer.offsetHeight;
    /* Message 上端の文書座標。PC / 中途: 上がり切る進行度で見出しが 28.77%。
       SP: 出現アニメなし（2026-09-17。JS でスクロールを追う transform は iOS で 1 コマ遅れて跳ねる）で 1:1 に上がる。
       開始位置は「コピー（Insight）が消え切る進行度 ENTRY_START_SP のスクロール量で、Have Fun! の上端が画面の HF_WIPE_TOP に来る」
       ところ（fv-havefun.js の SP のワイプ開始位置と同じ値）。以前の「画面下端 + 60」だと Insight が消えてから Have Fun! が出るまで間が空いた */
    let wantTop;
    if (SP_MQ.matches) {
      const hf = msg.querySelector('.message__havefun');
      const hfOff = hf ? hf.getBoundingClientRect().top - msg.getBoundingClientRect().top : 0;
      wantTop = fv.scrollAt(ENTRY_START_SP) + HF_WIPE_TOP * H - hfOff;
    } else {
      wantTop = fv.scrollAt(entryStart() + ENTRY_LEN) + HEAD_TOP * H - headOffset;
    }
    msg.style.marginTop = Math.min(0, Math.round(wantTop - spacerBottom)) + 'px';
    fv.read();
  }
  function frame() {
    fv.tick(performance.now());
    const H = window.innerHeight;
    const k = SP_MQ.matches ? 1 : entryK();   /* SP は出現アニメなし（1:1）。追従ヘッダーは従来どおり entryK（進行度）で */
    const naturalTop = msg.getBoundingClientRect().top - ty;   /* 変形なしの位置 */
    const travel = Math.max(0, H - naturalTop) + EXTRA;
    ty = (1 - k) * travel;
    msg.style.transform = ty > 0.5 ? 'translateY(' + ty.toFixed(1) + 'px)' : '';
    if (btn) btn.style.pointerEvents = k > 0.6 ? '' : 'none';
  }
  return { frame, layout, mode: 'flow' };
}

function init() {
  const msg = document.querySelector('.message');
  if (!msg) return;
  /* 新卒 SP（〜767px）は画面固定にせずフローモード（出現だけ同じで、あとは 1:1 でスクロール。About がそのまま後に続く。
     2026-09-15 指示「Message も普通にスクロールして上がっていくように」）。CSS 側は components.css の SP 上書き */
  const useFixed = msg.classList.contains('message--fixed') && !SP_MQ.matches;
  const api = useFixed ? initFixed(msg) : initFlow(msg);

  /* 追従ヘッダー: Message の出現に合わせる（common.js の FV 通過判定を無効化） */
  const header = document.querySelector('.js-header');
  let fixed = null;
  if (header) header.dataset.fixedBy = 'message';
  function syncHeader() {
    if (!header) return;
    const want = entryK() > HEADER_AT;
    if (want !== fixed) { fixed = want; header.classList.toggle('is-fixed', want); }
  }

  let running = false;
  function loop() {
    if (!running) return;
    requestAnimationFrame(loop);
    api.frame();
    syncHeader();
  }
  function sync() {
    const want = !document.hidden;
    if (want && !running) { running = true; requestAnimationFrame(loop); }
    else if (!want) running = false;
  }
  document.addEventListener('visibilitychange', sync);
  window.addEventListener('resize', () => { api.layout(); api.frame(); });
  window.addEventListener('load', () => { api.layout(); api.frame(); });
  api.layout();
  api.frame();
  syncHeader();
  sync();

  api.syncHeader = syncHeader;   /* 確認用: Browser ペイン非表示で rAF が止まっている時に手で呼ぶ */
  window.__fvMessage = api;
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
