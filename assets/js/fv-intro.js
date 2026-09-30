/* ==========================================================================
   fv-intro.js — 訪問時のイントロ: FV の青いフレーム（目型の穴）が閉じた状態から開く（新卒・中途）

   デモ（デモ/NI_TOP.html「サイト訪問時イントロ」）のタイミングで、元からある FV フレーム
   （.page-bg__frame、右上・左下）の目型の穴を開く。デモは別の青いオーバーレイにレンズ形の穴を開けるが、
   ここでは既存のフレームで表現する（二重にならない。色もフレームのグラデのまま）。
   - html.is-intro（head のインラインスクリプトが付ける）で JS が動くまで穴は閉じたまま（全面フレーム色）
   - 180ms 待って穴が中央から縦に開く（820ms、easeOut 3.2 乗）。開き方の式は common.js のメニューと同じ
     （横は 0.81→1.0、縦は 0→1）。開き具合は window.__fvEyeK（0〜1）で common.js の applyEye に渡す
   - 開き切る前（180 + 820×0.55 ms）にヘッダーとハンバーガーを 0.5s で出す
   - ロゴが下から入るタイミング（fv-scroll.js の introK: 770ms 後）はデモと同じで、この時計と一致する
   ========================================================================== */
const HOLD = 180, EYE_D = 820, EASE = 3.2;
const HEADER_AT = HOLD + EYE_D * 0.55;
const END_AT = HOLD + EYE_D;

function init() {
  const root = document.documentElement;
  const eyes = document.querySelectorAll('.js-eye-frame .js-menu-eye');
  const skip = window.matchMedia('(prefers-reduced-motion: reduce)').matches
    || /[?&](nointro|capture|menu)/.test(window.location.search)
    || !eyes.length || typeof window.__applyEye !== 'function';
  if (skip) {
    root.classList.remove('is-intro');
    window.__fvEyeK = undefined;
    return;
  }

  const hd = [...document.querySelectorAll('.header, .header__menu-btn')];
  for (const el of hd) { el.style.opacity = '0'; el.style.transition = 'opacity .5s ease'; }

  /* 閉じた状態（k=0）で穴を出してから開く。is-intro を外すのは k を反映した後（開く前の一瞬に開き切りが見えないように）。
     拡大率は念のため測り直す */
  window.__fvEyeK = 0;
  if (typeof window.__fitMenuFrames === 'function') window.__fitMenuFrames();
  window.__applyEye();
  root.classList.remove('is-intro');

  let T0 = null, shown = false, done = false;
  function step(now) {
    if (done) return true;
    if (T0 === null) T0 = now;
    const t = now - T0;
    const eu = Math.max(0, Math.min(1, (t - HOLD) / EYE_D));
    window.__fvEyeK = 1 - Math.pow(1 - eu, EASE);
    window.__applyEye();
    if (t > HEADER_AT && !shown) {
      shown = true;
      for (const el of hd) el.style.opacity = '';
    }
    if (t >= END_AT) {
      done = true;
      window.__fvEyeK = undefined;   /* 以降は常に開き切り（リサイズ時の再計算も通常どおり） */
      window.__applyEye();
      for (const el of hd) { el.style.opacity = ''; el.style.transition = ''; }
      return true;
    }
    return false;
  }
  (function tick(now) {
    if (!step(now)) requestAnimationFrame(tick);
  })(performance.now());

  window.__fvIntro = { step, get done() { return done; } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
