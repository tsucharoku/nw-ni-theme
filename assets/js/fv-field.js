/* ==========================================================================
   fv-field.js — ロゴまわりの「点と線」（新卒・中途）

   デモ（デモ/NI_TOP.html「背景の点と線」、F.field*）をそのまま移植したもの。
   - 青い点がロゴのまわり（ロゴの高さ × spread の楕円）をゆらゆら漂い、近い点同士が細い線でつながる（scatter）
   - ロゴの前面の角にも点を置く（corner。押し出し形状の輪郭頂点から間隔をあけて選ぶ）。mode "both" で両方
   - FV を出るとフェードアウト（進行度 0.20〜0.27。FV コピーと同じカーブ）
   - 画面サイズの 2D canvas に描き、固定背景（.page-bg、動画の上）に置く。同じ canvas を ni-logo.js の
     背景合成にも重ねるので、ガラス越しでも点が屈折して見える（デモの __bgfx）
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

/* デモの F と同値 */
const P = {
  fieldOn: true, fieldDots: 11, fieldDotSize: 0.0025, fieldDotColor: '#006ce0',
  fieldLinkColor: '#004cff', fieldLinkDist: 0.205, fieldLinkOpacity: 0.16, fieldLinkWidth: 1,
  fieldSpeed: 0.35, fieldSpread: 1.9, fieldOpacity: 0.6, fieldDotGlow: 0,
  fieldMode: 'both'   /* scatter | corner | both */
};

const ss = (x) => (x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x));
function rgb(c) {
  c = (c || '#006ce0').replace('#', '');
  if (c.length === 3) c = c[0] + c[0] + c[1] + c[1] + c[2] + c[2];
  return parseInt(c.substr(0, 2), 16) + ',' + parseInt(c.substr(2, 2), 16) + ',' + parseInt(c.substr(4, 2), 16);
}

function init() {
  const bg = document.querySelector('.page-bg');
  if (!bg) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bfield\b/.test(window.location.search)) return;   /* ?off=field でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const cv = document.createElement('canvas');
  cv.className = 'page-bg__field';
  cv.setAttribute('aria-hidden', 'true');
  const ctx = cv.getContext('2d');
  const video = bg.querySelector('.page-bg__video');
  if (video && video.nextSibling) bg.insertBefore(cv, video.nextSibling); else bg.appendChild(cv);

  let dots = [], n0 = -1, t0 = null;
  function mkDots(n) {
    dots = [];
    const g = Math.PI * (3 - Math.sqrt(5));
    for (let i = 0; i < n; i++) {
      dots.push({ rr: Math.sqrt((i + 0.5) / Math.max(1, n)), a: i * g,
        ph: (i * 1.73) % 6.2832, sp: 0.55 + ((i * 13) % 9) / 12, dy: ((i * 7) % 5) / 5 - 0.5 });
    }
    n0 = n;
  }

  /* 前面キャップの輪郭頂点＝ロゴの角。ExtrudeGeometry は輪郭点しか持たない */
  let cUuid = '', cIdx = null, tmpV = null;
  function contour(g) {
    if (cUuid === g.uuid && cIdx) return cIdx;
    const p = g.attributes.position, n = p.count;
    let zmax = -1e9;
    for (let i = 0; i < n; i++) { const z = p.getZ(i); if (z > zmax) zmax = z; }
    const eps = 1e-4, seen = {}, list = [];
    for (let i = 0; i < n; i++) {
      if (p.getZ(i) < zmax - eps) continue;
      const k = Math.round(p.getX(i) * 2000) + '_' + Math.round(p.getY(i) * 2000);
      if (seen[k]) continue;
      seen[k] = 1; list.push(i);
    }
    cIdx = list; cUuid = g.uuid;
    return list;
  }

  function draw(ts, L) {
    const R = L.logoRect();
    if (!R || !R.W || !R.H) return;
    if (cv.width !== R.W || cv.height !== R.H) { cv.width = R.W; cv.height = R.H; }
    ctx.clearRect(0, 0, R.W, R.H);
    /* FV を出るとフェードアウト（FV コピーと同じカーブ） */
    const fade = 1 - ss((fv.p - 0.2) / 0.07);
    if (!P.fieldOn || P.fieldOpacity <= 0 || P.fieldDots < 1 || fade <= 0.01) return;
    if (t0 === null) t0 = ts;
    const T = (ts - t0) / 1000 * P.fieldSpeed;
    const n = Math.round(P.fieldDots);
    if (n !== n0) mkDots(n);
    const mode = P.fieldMode || 'both';
    const Rad = R.hpx * P.fieldSpread * 0.5, px = [], py = [];
    let sN = 0;
    if (mode !== 'corner') {
      for (const d of dots) {
        px.push(R.cx + Math.cos(d.a + T * 0.28 * d.sp + d.ph) * Rad * d.rr);
        py.push(R.cy + Math.sin(d.a * 1.3 + T * 0.23 * d.sp + d.ph) * Rad * d.rr * 0.72 + d.dy * Rad * 0.12);
      }
      sN = px.length;
    }
    /* ロゴの角 */
    const m = L.frontMesh, cam = L.camera;
    if (m && cam && mode !== 'scatter') {
      const list = contour(m.geometry);
      if (list.length) {
        m.updateMatrixWorld();
        if (!tmpV) tmpV = m.position.clone();
        const pa = m.geometry.attributes.position;
        const hx = [], hy = [];
        for (const idx of list) {
          tmpV.set(pa.getX(idx), pa.getY(idx), pa.getZ(idx));
          tmpV.applyMatrix4(m.matrixWorld); tmpV.project(cam);
          const X = (tmpV.x + 1) / 2 * R.W, Y = (1 - tmpV.y) / 2 * R.H;
          if (!isFinite(X) || !isFinite(Y)) continue;
          hx.push(X); hy.push(Y);
        }
        if (hx.length) {
          const K = Math.max(3, Math.round(n || 12));
          let sel = [], minD = R.hpx * 0.75 / Math.sqrt(K), tries = 0;
          while (tries < 5) {
            sel = [];
            for (let w = 0; w < hx.length && sel.length < K; w++) {
              let ok = true;
              for (let z = 0; z < sel.length; z++) {
                const ddx = hx[w] - hx[sel[z]], ddy = hy[w] - hy[sel[z]];
                if (ddx * ddx + ddy * ddy < minD * minD) { ok = false; break; }
              }
              if (ok) sel.push(w);
            }
            if (sel.length >= K * 0.8) break;
            minD *= 0.6; tries++;
          }
          for (const w2 of sel) { px.push(hx[w2]); py.push(hy[w2]); }
        }
      }
    }
    ctx.save();
    ctx.globalAlpha = P.fieldOpacity * fade;
    /* 線（漂う点同士） */
    const LD = R.H * P.fieldLinkDist, lc = rgb(P.fieldLinkColor);
    ctx.lineWidth = P.fieldLinkWidth;
    for (let a = 0; a < sN; a++) for (let b = a + 1; b < sN; b++) {
      const dx2 = px[a] - px[b], dy2 = py[a] - py[b], dd = Math.sqrt(dx2 * dx2 + dy2 * dy2);
      if (dd > LD) continue;
      ctx.strokeStyle = 'rgba(' + lc + ',' + (P.fieldLinkOpacity * (1 - dd / LD)).toFixed(3) + ')';
      ctx.beginPath(); ctx.moveTo(px[a], py[a]); ctx.lineTo(px[b], py[b]); ctx.stroke();
    }
    /* 点 */
    const dc = rgb(P.fieldDotColor), rr = Math.max(1, R.H * P.fieldDotSize);
    const gl = P.fieldDotGlow || 0;
    for (let k = 0; k < px.length; k++) {
      if (gl > 0) {
        const go = rr * (1 + gl * 3);
        const gr = ctx.createRadialGradient(px[k], py[k], rr, px[k], py[k], go);
        gr.addColorStop(0, 'rgba(' + dc + ',' + (0.5 * gl).toFixed(3) + ')');
        gr.addColorStop(1, 'rgba(' + dc + ',0)');
        ctx.fillStyle = gr; ctx.beginPath(); ctx.arc(px[k], py[k], go, 0, 6.2832); ctx.fill();
      }
      ctx.fillStyle = 'rgba(' + dc + ',1)';
      ctx.beginPath(); ctx.arc(px[k], py[k], rr, 0, 6.2832); ctx.fill();
    }
    ctx.restore();
  }

  /* ni-logo.js のシーンができるのを待って登録（ロゴの描画直前に描き、背景合成にも重ねてもらう） */
  (function wait() {
    const L = window.__niLogo;
    if (L && L.logoRect && L.hooks && L.bgLayers) {
      L.hooks.push(() => draw(performance.now(), L));
      L.bgLayers.push(cv);
      window.__fvField = { P, canvas: cv, draw: () => draw(performance.now(), L) };
      return;
    }
    setTimeout(wait, 50);
  })();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
