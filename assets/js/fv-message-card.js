/* ==========================================================================
   fv-message-card.js — 中途 Message（紺のカード）の紺をロゴの奥に敷き、ガラスの NI ロゴが紺を屈折しながらカードの上に透けて見えるようにする

   Figma（419:2031）ではカードの右側にロゴの画像が薄く敷かれている。ここでは実物の 3D ロゴ（ni-logo.js、画面固定 canvas で
   本文の下に描かれる）をそのまま使う: カードの DOM 側は背景を透明にし（.is-card-fx）、同じ矩形の紺の角丸「板」（.message-card-fx）を
   ロゴ canvas の直前（重なり順はロゴの下・波背景の上）に置く。
   板は body 直下の position: absolute（文書座標）の DOM 要素なので、ブラウザのネイティブスクロールでカードの文字と完全に同期する
   （以前は画面固定 canvas を rAF で追従させていたため、文字より 1〜2 フレーム遅れて見えた。2026-09-13 に DOM 化）。
   ロゴ自身は ni-logo.js が毎フレーム位置を計算するので、カードと一緒に動く区間では速いスクロール時にロゴだけ少し遅れる（許容）。
   「Have Fun!」は Figma（ロゴ画像が文字の上）に合わせて板の中に DOM の文字として置き、カード側の DOM は隠す（レイアウトは残す）ので、
   ロゴの奥でガラス越しに屈折する。フォント・字間・skew はカード側の computed style をそのまま写す。
   MESSAGE / 見出し / 本文はカード側の DOM のまま（本文 .page-main はロゴより上）なのでロゴの手前に残る。
   ロゴの屈折用: 同じ紺 + Have Fun! を画面には出さない canvas に描き、ロゴの背景板の層（bgLayers, afterVeil）に板の画面上の矩形で渡す
   （fv-havefun.js と同じ仕組み）。ガラス越しには屈折した紺と Have Fun! が見える。
   - 板の位置・大きさはカードの文書座標（getBoundingClientRect + scroll）。ロゴのフレームから毎回見て、変わったときだけ書く
     （スクロールでは変わらない。リサイズ・フォント確定・画像読み込みでレイアウトが動いたときだけ）
   - 角丸は CSS の border-radius をそのまま読む
   - ロゴが無い（WebGL 不可 / 動き抑制 / ?nowebgl）ときは何もしない = カード側の DOM の紺のまま
   - SP（〜767px）も何もしない（Figma の SP にはカード上のロゴが無い。ロゴはカードの紺に隠れる。2026-09-15）
   ========================================================================== */
const COLOR = '#1b3071';   /* career.css の .message--card と同じ */

function init() {
  /* SP（〜767px）は何もしない: Figma 474:8465 ではカードの上にロゴが無く、ロゴは Hero の下端（カード上端）で紺に隠れる。
     カードは DOM の紺のまま（ロゴ canvas より上）なので、Hero からはみ出したロゴの下側はカードに隠れる（2026-09-15 指示） */
  if (window.matchMedia('(max-width: 767px)').matches) return;
  const card = document.querySelector('.message--card');
  if (!card) return;

  const hf = card.querySelector('.message__havefun');

  /* 画面に出す板（DOM） */
  const plate = document.createElement('div');
  plate.className = 'message-card-fx';
  plate.setAttribute('aria-hidden', 'true');
  const hfClone = hf ? document.createElement('p') : null;
  if (hfClone) {
    hfClone.className = 'message-card-fx__havefun';
    hfClone.textContent = hf.textContent;
    plate.appendChild(hfClone);
  }

  /* ロゴの屈折用（画面には出さない） */
  const cv = document.createElement('canvas');
  const cx = cv.getContext('2d');
  let cw = 0, ch = 0, crad = -1;
  let doc = { top: -1, left: -1, w: 0, h: 0 };

  /* Have Fun! の位置・書式をカード側から写す。行の位置は transform を一時的に外して測る（矩形は transform 後の値になるため） */
  function layoutHavefun() {
    if (!hf || !hfClone) return;
    const prev = hf.style.transform;
    const cs = getComputedStyle(hf);
    const tf = cs.transform;
    hf.style.transform = 'none';
    const cr = card.getBoundingClientRect();
    const hr = hf.getBoundingClientRect();
    hf.style.transform = prev;
    const st = hfClone.style;
    st.left = (hr.left - cr.left) + 'px';
    st.top = (hr.top - cr.top) + 'px';
    st.width = hr.width + 'px';
    st.height = hr.height + 'px';
    st.font = cs.font;
    st.letterSpacing = cs.letterSpacing;
    st.lineHeight = cs.lineHeight;
    st.whiteSpace = cs.whiteSpace;
    st.color = cs.color;
    st.transform = tf;
    st.transformOrigin = cs.transformOrigin;
  }

  /* 屈折用 canvas に Have Fun! を描く（カード座標）。DOM の位置・フォント・skew をそのまま使う */
  function paintHavefun() {
    if (!hf || !hf.firstChild) return;
    const prev = hf.style.transform;
    const tf = getComputedStyle(hf).transform;   /* skew / scale の matrix（外す前に読む） */
    hf.style.transform = 'none';
    const cs = getComputedStyle(hf);
    const cr = card.getBoundingClientRect();
    const hr = hf.getBoundingClientRect();
    const node = hf.firstChild;
    const text = node.textContent;
    cx.save();
    cx.fillStyle = cs.color;
    cx.font = `${cs.fontStyle} ${cs.fontWeight} ${cs.fontSize} ${cs.fontFamily}`;
    if ('letterSpacing' in cx) cx.letterSpacing = cs.letterSpacing === 'normal' ? '0px' : cs.letterSpacing;
    cx.textBaseline = 'alphabetic';
    /* CSS の transform（skew / scale）をボックスの中心を原点にして掛ける */
    const m = /matrix\(([^)]+)\)/.exec(tf);
    const ox = hr.left - cr.left + hr.width / 2, oy = hr.top - cr.top + hr.height / 2;
    if (m) {
      const v = m[1].split(',').map(parseFloat);
      cx.translate(ox, oy);
      cx.transform(v[0], v[1], v[2], v[3], 0, 0);
      cx.translate(-ox, -oy);
    }
    const range = document.createRange();
    let start = 0, top = null;
    const flush = (end) => {
      const str = text.slice(start, end);
      if (!str.trim() || top === null) return;
      const asc = cx.measureText(str).fontBoundingBoxAscent || parseFloat(cs.fontSize) * 0.88;
      cx.fillText(str, top.left - cr.left, top.top - cr.top + asc);
    };
    for (let i = 0; i < text.length; i++) {
      range.setStart(node, i); range.setEnd(node, i + 1);
      const r = range.getClientRects()[0];
      if (!r || (r.width === 0 && r.height === 0)) continue;
      if (top && Math.abs(r.top - top.top) > 1) { flush(i); start = i; top = null; }
      if (!top) top = r;
    }
    flush(text.length);
    cx.restore();
    hf.style.transform = prev;
  }

  function paint(w, h, rad, dpr) {
    cv.width = Math.max(1, Math.round(w * dpr));
    cv.height = Math.max(1, Math.round(h * dpr));
    cx.setTransform(dpr, 0, 0, dpr, 0, 0);
    cx.clearRect(0, 0, w, h);
    cx.fillStyle = COLOR;
    cx.beginPath();
    const r = Math.min(rad, w / 2, h / 2);
    cx.moveTo(r, 0);
    cx.arcTo(w, 0, w, h, r);
    cx.arcTo(w, h, 0, h, r);
    cx.arcTo(0, h, 0, 0, r);
    cx.arcTo(0, 0, w, 0, r);
    cx.closePath();
    cx.fill();
    paintHavefun();
  }
  /* Web フォント確定後に描き直す（フォールバックフォントで描いた Have Fun! を置き換える） */
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(() => { crad = -1; });

  /* ロゴのフレームから毎回呼ばれる（描画の直前）。板の位置はレイアウトが変わったときだけ書く */
  function draw() {
    const b = card.getBoundingClientRect();
    const w = Math.round(b.width), h = Math.round(b.height);
    const top = Math.round((b.top + window.scrollY) * 10) / 10;
    const left = Math.round((b.left + window.scrollX) * 10) / 10;
    if (top !== doc.top || left !== doc.left || w !== doc.w || h !== doc.h) {
      doc = { top, left, w, h };
      plate.style.top = top + 'px';
      plate.style.left = left + 'px';
      plate.style.width = w + 'px';
      plate.style.height = h + 'px';
    }
    const rad = parseFloat(getComputedStyle(card).borderTopLeftRadius) || 0;
    if (w !== cw || h !== ch || rad !== crad) {
      cw = w; ch = h; crad = rad;
      plate.style.borderRadius = rad + 'px';
      layoutHavefun();
      paint(w, h, rad, Math.min(1.5, window.devicePixelRatio || 1));
    }
  }
  /* 屈折用: 板の画面上の矩形（ロゴの背景合成が同じフレームで読む） */
  function rect() {
    const b = plate.getBoundingClientRect();
    return { x: b.left, y: b.top, w: b.width, h: b.height };
  }

  function attach(L) {
    const lc = L.renderer && L.renderer.domElement;
    if (!lc || !lc.parentNode || !L.hooks || !L.bgLayers) return false;
    lc.parentNode.insertBefore(plate, lc);
    L.hooks.push(() => draw());
    L.bgLayers.push({ canvas: cv, afterVeil: true, rect });
    card.classList.add('is-card-fx');
    draw();
    return true;
  }

  /* ロゴ（ni-logo.js）は SVG 読み込み後に window.__niLogo を出すので、出てきたら組み込む（最大 10 秒待つ） */
  (function waitLogo(n) {
    const L = window.__niLogo;
    if (L && L.renderer) { attach(L); return; }
    if (n < 100) setTimeout(() => waitLogo(n + 1), 100);
  })(0);

  window.__fvMessageCard = { draw, plate, canvas: cv, get rect() { return rect(); } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
