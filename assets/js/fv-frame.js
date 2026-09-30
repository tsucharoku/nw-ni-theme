/* ==========================================================================
   fv-frame.js — FV の青いフレーム（右上・左下の角）がスクロールで画面外へ逃げる

   デモ（デモ/NI_TOP.html「スクロールでコーナー(fream/目)を開いて画面外へ逃がす」）と同じ。
   フェードではなく、フレーム全体を中心から拡大して目型の穴を広げ、角を画面外へ押し出す。
   scale = 1 + k * 3.2、k = ez((p - 0.02) / 0.30)（p は fv-scroll.js の進行度、慣性つき）。
   対象は .page-bg__frame（PC / SP の目型 SVG。common.js が viewBox と目型の拡大率を面倒みる）。
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

const ez = (x) => (x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x));

function init() {
  const frames = [...document.querySelectorAll('.page-bg__frame')];
  if (!frames.length) return;
  /* ?off=frame で青いフレーム（右上・左下の角）を層ごと消す（実機の切り分け用。SVG の固定レイヤー自体の負荷も見るため display: none。2026-09-17） */
  if (/[?&]off=[^&]*\bframe\b/.test(window.location.search)) {
    const layer = document.querySelector('.fv-frame-layer');
    if (layer) layer.style.display = 'none';
    return;
  }
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  for (const el of frames) {
    el.style.transformOrigin = '50% 50%';
    el.style.willChange = 'transform';
  }
  /* 角が画面外へ逃げ切ったら（k = 1、4.2 倍）層ごと非表示にする（2026-09-17）。
     逃げ切った後も画面固定で残していたため、マスク付き SVG を 4.2 倍に拡大した層（3 倍画面で約 4700x10000px）を
     iOS がページ全体のスクロール中ずっと合成し続け、新卒 SP の慣性スクロールがカクつく主因になっていた（?off=frame で解消を確認）。
     FV に戻れば再表示。見た目は変わらない（逃げ切った後は元々何も見えていない） */
  const layer = document.querySelector('.fv-frame-layer');

  /* 拡大中はビットマップで（2026-09-17）: iOS はマスク付き SVG の拡大率が変わるたびにその大きさでベクターを描き直すので、
     1 → 4.2 倍に拡大していく間ずっと重かった（新卒 SP のフリック中のカクつきの主因）。イントロ完了後に表示中の SVG を画面解像度で
     canvas に写しておき、拡大が始まったら SVG を隠して canvas を拡大する（GPU の縮尺だけで描き直しなし）。
     静止中（拡大率 1）は SVG のまま（くっきり）。逃げ切ったら（k = 1）層ごと非表示。リサイズ時は撮り直し */
  const snap = document.createElement('canvas');
  snap.className = 'page-bg__frame-snap';
  snap.setAttribute('aria-hidden', 'true');
  snap.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;transform-origin:50% 50%;pointer-events:none;display:none;';
  (layer || frames[0].parentNode).appendChild(snap);
  let snapReady = false, snapBusy = false, snapKey = '';
  function visibleFrame() { return frames.find((el) => el.getBoundingClientRect().width > 0) || null; }
  function prepareSnap() {
    const el = visibleFrame();
    if (!el || snapBusy) return;
    const r = el.getBoundingClientRect();
    const dpr = Math.min(3, window.devicePixelRatio || 1);
    const key = Math.round(r.width) + 'x' + Math.round(r.height) + '@' + dpr + ':' + (el.getAttribute('viewBox') || '');
    if (key === snapKey) return;
    snapBusy = true;
    const clone = el.cloneNode(true);
    clone.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    clone.setAttribute('width', String(Math.round(r.width)));
    clone.setAttribute('height', String(Math.round(r.height)));
    clone.removeAttribute('style'); clone.removeAttribute('class');
    const blob = new Blob([new XMLSerializer().serializeToString(clone)], { type: 'image/svg+xml' });
    const url = URL.createObjectURL(blob);
    const img = new Image();
    img.onload = () => {
      try {
        snap.width = Math.round(r.width * dpr); snap.height = Math.round(r.height * dpr);
        const c = snap.getContext('2d');
        c.clearRect(0, 0, snap.width, snap.height);
        c.drawImage(img, 0, 0, snap.width, snap.height);
        snapReady = true; snapKey = key;
      } catch (e) { snapReady = false; }
      URL.revokeObjectURL(url); snapBusy = false;
    };
    img.onerror = () => { URL.revokeObjectURL(url); snapBusy = false; };
    img.src = url;
  }
  let resizeT = 0;
  window.addEventListener('resize', () => { clearTimeout(resizeT); resizeT = setTimeout(() => { snapReady = false; snapKey = ''; prepareSnap(); }, 200); });

  let last = '', hidden = false, mode = 'svg';   /* mode: 'svg' | 'snap' */
  let running = false;
  function frame() {
    fv.tick(performance.now());
    const k = ez((fv.p - 0.02) / 0.30);
    const gone = k >= 0.999;
    if (gone !== hidden) {
      hidden = gone;
      if (layer) layer.style.visibility = gone ? 'hidden' : '';
      else for (const el of frames) el.style.visibility = gone ? 'hidden' : '';
    }
    if (gone) return;   /* 非表示中は transform も触らない */
    if (!snapReady && window.__fvEyeK === undefined) prepareSnap();   /* イントロで目型の穴が開き切ってから撮る（fv-intro.js: 開き切ると __fvEyeK は undefined。イントロなしのページも undefined） */
    const useSnap = k > 0 && snapReady;
    const want = useSnap ? 'snap' : 'svg';
    if (want !== mode) {
      mode = want;
      snap.style.display = useSnap ? 'block' : 'none';
      for (const el of frames) el.style.visibility = useSnap ? 'hidden' : '';
      if (!useSnap) for (const el of frames) el.style.transform = 'scale(1)';
      last = '';
    }
    const tr = 'scale(' + (1 + k * 3.2).toFixed(3) + ')';
    if (tr === last) return;
    last = tr;
    if (useSnap) snap.style.transform = tr;
    else for (const el of frames) el.style.transform = tr;
  }
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
  sync();
  window.__fvFrame = { frame };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
