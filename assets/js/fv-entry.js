/* ==========================================================================
   fv-entry.js — Entry セクションの登場（新卒）

   デモ（デモ/NI_TOP.html「Entry/Footerの上下境界にAboutと同型のバースイープ」）の Entry 側と同じ動き:
   - .entry を .entry-pin で包む。ピンの margin-top = gap(200px) − ex、padding-top = ex、min-height = Entry の高さ
     （ex = min(Entry の高さ, 画面高)）。直前セクションの下端が画面下端から gap ぶん上がった時点でゾーン開始
   - ゾーン中（z 0〜0.995）は Entry を画面固定（下端合わせ。Entry が画面より高ければ上端合わせ）にし、
     About と同じ縦バー（buildBars、96 段階）が下からせり上がって Entry を覆い出す
   - z = 1 で固定位置とフロー位置が一致するので、固定を解除して通常フローへ（継ぎ目なし）
   demo の Footer 下敷きリビールは未移植。SP（〜767px）は動かない（通常フロー）。
   ========================================================================== */
import { buildBars } from './fv-about.js?v=202609181000';

const GAP = 200;      /* 直前セクションとの呼吸（px） */
const STEPS = 96;

function init() {
  /* SP（〜767px）はスイープなし（Entry は通常フロー。2026-09-15 指示）。判定は読み込み時のみ */
  if (window.matchMedia('(max-width: 767px)').matches) return;
  /* 切り替えの一時停止スイッチ: <body data-sweep="off"> なら PC でもスイープなし（fv-about.js と同じ。components.css が呼吸の 200px を代わりに付ける） */
  if (document.body.dataset.sweep === 'off') return;
  const ent = document.querySelector('.entry');
  const pin = document.querySelector('.entry-pin');
  if (!ent || !pin) return;
  const canPath = !!(window.CSS && CSS.supports && CSS.supports('clip-path', 'path("M0 0h1v1z")'));
  let fixed = false, lastE = '';

  function geo() {
    const vh = window.innerHeight, H = ent.offsetHeight;
    const Heff = Math.min(H, vh);
    const ex = Math.round(Heff);
    return { vh, H, Heff, ex, topFix: vh - Heff };
  }
  function fit() {
    if (fixed) unfix();
    ent.style.clipPath = ''; ent.style.webkitClipPath = ''; lastE = '';
    const g = geo();
    pin.style.marginTop = (GAP - g.ex) + 'px';
    pin.style.paddingTop = g.ex + 'px';
    pin.style.boxSizing = 'content-box';
    pin.style.minHeight = g.H + 'px';
  }
  function unfix() {
    fixed = false;
    ent.style.position = ''; ent.style.top = ''; ent.style.left = ''; ent.style.width = ''; ent.style.zIndex = ''; ent.style.margin = '';
  }
  function putE(key, val) {
    if (lastE === key) return;
    lastE = key;
    ent.style.clipPath = val; ent.style.webkitClipPath = val;
  }

  function frame() {
    const g = geo();
    const rp = pin.getBoundingClientRect();
    /* z: 固定位置（topFix）とフロー位置（rp.top + ex）が z=1 で一致するように取る */
    const z = (g.topFix - (rp.top + g.ex)) / Math.max(1, g.ex) + 1;
    if (z >= 0 && z < 0.995) {
      if (!fixed) {
        const rr = ent.getBoundingClientRect();
        ent.style.margin = '0'; ent.style.position = 'fixed'; ent.style.top = g.topFix + 'px';
        ent.style.left = Math.round(rr.left) + 'px'; ent.style.width = Math.round(rr.width) + 'px'; ent.style.zIndex = '3';
        fixed = true;
      }
      if (!canPath) { putE('f', 'none'); ent.style.opacity = Math.max(0.005, z).toFixed(3); return; }
      let st = Math.ceil(Math.max(0.005, z) * STEPS); if (st > STEPS - 1) st = STEPS - 1;
      const d = buildBars(st / STEPS, ent.offsetWidth, g.Heff);
      putE('s' + st, d ? 'path("' + d + '")' : 'path("M0 0z")');
    } else {
      if (fixed) unfix();
      if (!canPath) { ent.style.opacity = z < 0 ? '0' : ''; putE('1', 'none'); return; }
      if (z < 0) putE('0', 'path("M0 0z")');
      else putE('1', 'none');
    }
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
  window.addEventListener('resize', fit);
  window.addEventListener('load', fit);
  fit();
  frame();
  sync();

  window.__fvEntry = { frame, fit, geo, get fixed() { return fixed; } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
