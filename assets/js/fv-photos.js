/* ==========================================================================
   fv-photos.js — FV の写真 4 枚（新卒 TOP）

   デモ（デモ/NI_TOP.html「FV写真をWebGLシーンに平面配置」）をそのまま移植したもの。
   - 現在は PC / SP とも DOM の <img> を transform で動かす（2026-09-17。負荷対策）。WebGL の板は DOM_PC = false で PC だけ戻せる
   - WebGL 版: 3D ロゴと同じ canvas（ni-logo.js）に板として置く（z = 1.5、ロゴより手前）。ただし composer（ACES トーンマップ）を
     通すと <img> より暗く沈むので、上描き用の overlayScene に入れて描画の最後にトーンマップなしで重ねる（2026-09-17）
   - 浮遊: 写真ごとに周期の違う sin / cos でゆらゆら揺れる（振幅は画面高さの 1.0% / 1.4%）
   - スクロールで消える（PC）: 進行度 0.08〜0.36 で上へ 2 画面ぶん抜けながら左右に散り（(i-1) 方向）、
     傾いて画面外へ。フェードはしない。抜け切ったら描画停止
   - スクロールで消える（SP、2026-09-17）: スクロール量の SPEED_SP 倍（1.2）で上がる。指よりちょい速い程度で、1:1 で上がってくる
     Have Fun! の少し先を行く。散り・傾きは 1 画面ぶん上がるまでに済ませ、写真ごとに画面上端から抜けたら非表示
   - 位置・大きさ（PC）はデモの値（画面幅・高さに対する比率）。写真の縦横比は画像そのまま
   - 位置・大きさ（SP、〜767px）は Figma 470:2672（SP の Hero 375×667）に合わせる。CSS の .hero__photo--1〜4（beginner.css、
     Figma の Mask group の位置・大きさを .hero__stage 比で書いたもの）の画面上の矩形をそのまま板の位置・大きさにする
     （2026-09-14 指示「SP FV の写真の位置・大きさをデザインに合わせて」。どの写真がどこかはデザインと違っていてよい）。
     矩形はリサイズ時だけ測り直す
   - 角丸: DOM の写真の border-radius（--radius = Figma の rx 4px）と同じ角丸をシェーダで付ける
     （デモは PNG に約 8px を焼き込んでいたが、見た目はデザインが正）

   デモは写真 3 枚→4 枚の新デザインで p0（左）p1（右上）p2（下）p3（右下）の順。
   静的ページの hero_photo_01〜04 は 01=右上 02=下 03=右下 04=左 なので、その対応で並べる。
   DOM の .hero__photo は板ができたら隠す（.hero.is-photos-fx）。WebGL が使えなければ DOM のまま。
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

const ZP = 1.5;
/* デモの PHOTOS（cx / cy = 中心、w / h = 画面幅・高さに対する比率）と、対応する DOM 写真 */
const PHOTOS = [
  { sel: '.hero__photo--4', cx: 0.072, cy: 0.513, w: 0.0731, h: 0.1697 },   /* 左 */
  { sel: '.hero__photo--1', cx: 0.748, cy: 0.283, w: 0.1211, h: 0.2804 },   /* 右上 */
  { sel: '.hero__photo--2', cx: 0.289, cy: 0.838, w: 0.0665, h: 0.1542 },   /* 下 */
  { sel: '.hero__photo--3', cx: 0.911, cy: 0.608, w: 0.0905, h: 0.2100 }    /* 右下 */
];
const ASPECT_FIX = 1.875;   /* デモの w/h は 1440x768 基準なので、縦横比に戻す係数 */
const SP_MQ = window.matchMedia('(max-width: 767px)');
/* PC も DOM の <img> で動かすか（2026-09-17）。false に戻すと従来どおり WebGL の板（overlayScene）。
   URL の ?photos=gl で一時的に WebGL に戻せる（見比べ用） */
const DOM_PC = true;
/* SP の写真の上がる速さ（スクロール 1px あたり px。1 = 指と同じ）。2026-09-17: 以前は進行度 0.08〜0.36（SP では約 140px のスクロール）で
   2 画面ぶん上がっていて、指の 9 倍前後の速さで消えていた。指よりちょい速いくらいにして、Have Fun! の上がりに合わせる。PC は従来どおり */
const SPEED_SP = 1.2;

function init() {
  const hero = document.querySelector('.hero[data-anim="fv"]');
  if (!hero) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bphotos\b/.test(window.location.search)) return;   /* ?off=photos でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  /* WebGL に載せず DOM の <img> のまま動かす（2026-09-17。SP は必ず、PC は DOM_PC が true のとき）:
     SP はロゴの canvas を負荷対策で 1 倍解像度にしたため、同じ canvas に描く写真が 3 倍画面で粗くなった。
     DOM なら画面解像度でくっきり、動きは同じ式で transform を書く（青いフレームと同じ方式）。PC も揃えて WebGL の描画を減らす。
     重なりは Hero 内の z-index 1（コピーの 2 より下、Hero 自体がロゴ canvas より上）で、従来の「ロゴの前・コピーの後ろ」と同じ。
     WebGL 版と違い、写真はガラスのロゴに映り込まない（overlayScene に移した時点で映り込みは既になかった） */
  const useDom = SP_MQ.matches || (DOM_PC && !/[?&]photos=gl\b/.test(window.location.search));
  if (useDom) {
    const els = PHOTOS.map((p) => hero.querySelector(p.sel)).filter(Boolean);
    if (!els.length) return;
    for (const el of els) el.style.willChange = 'transform';
    /* PC の位置・大きさはデモの値（ビューポート比）なので、CSS の .hero__photo--N（Figma 比）ではなく
       JS で .hero__stage 相対の px に直して当てる（WebGL 版の geoOf と同じ換算）。SP は CSS のまま。リサイズ時に測り直す */
    const stage = hero.querySelector('.hero__stage') || hero;
    function placePc() {
      const W = document.documentElement.clientWidth, H = window.innerHeight;
      const sr = stage.getBoundingClientRect();
      els.forEach((el, i) => {
        const p = PHOTOS[i];
        const hPx = p.h * H, wPx = hPx * (p.w / p.h) * ASPECT_FIX;
        el.style.left = (p.cx * W - wPx / 2 - sr.left).toFixed(1) + 'px';
        el.style.top = (p.cy * H - hPx / 2 - sr.top).toFixed(1) + 'px';
        el.style.width = wPx.toFixed(1) + 'px';
        el.style.height = hPx.toFixed(1) + 'px';
      });
    }
    function placeSp() { for (const el of els) { el.style.left = el.style.top = el.style.width = el.style.height = ''; } }
    let placed = null;
    let goneAt = null;   /* 写真ごとの「画面上端から抜け切る移動量」（SP。下で測る） */
    function place() {
      const sp = SP_MQ.matches;
      if (sp) { if (placed !== 'sp') placeSp(); } else placePc();
      placed = sp ? 'sp' : 'pc';
      goneAt = null;
    }
    place();
    window.addEventListener('resize', place);
    new ResizeObserver(place).observe(stage);
    let lastGone = null;
    /* SP: スクロール量（px）に慣性をかけた値。進行度 p は演出区間（約 180px）で頭打ちなので使わず、
       余白 [data-fv-scroll] の位置から直接取る。慣性の係数はほかの演出と同じ fv.inertia() */
    let sm = null, smLast = -1;
    function smoothScroll(now) {
      const raw = fv.ref ? Math.max(0, -fv.ref.getBoundingClientRect().top) : Math.max(0, window.scrollY);
      if (sm === null) { sm = raw; smLast = now; return sm; }
      const dt = Math.max(0, Math.min(100, now - smLast));
      smLast = now;
      sm += (raw - sm) * (1 - Math.pow(1 - fv.inertia(), dt / (1000 / 60)));
      return sm;
    }
    /* 写真ごとの「画面上端から抜け切る移動量」（transform なしの矩形の下端 + 揺れ・回転ぶんの余裕）。リサイズ時に測り直す */
    function measureGone() {
      const H = window.innerHeight;
      goneAt = els.map((el) => {
        const tf = el.style.transform; el.style.transform = '';
        const r = el.getBoundingClientRect(); el.style.transform = tf;
        return r.bottom + r.height * 0.5 + 0.014 * H;
      });
    }
    function updateDom() {
      const now = performance.now();
      fv.tick(now);
      const H = window.innerHeight, W = document.documentElement.clientWidth;
      const sp = SP_MQ.matches;
      let ex, up, gone;
      if (sp) {
        /* SP: 指の SPEED_SP 倍で上がる。散り・傾きは 1 画面ぶん上がるまでに済ませる */
        if (!goneAt) measureGone();
        up = SPEED_SP * smoothScroll(now);
        ex = Math.min(1, up / H);
        gone = null;   /* 写真ごとに判定 */
      } else {
        const pp = fv.p;
        ex = pp <= 0.08 ? 0 : Math.min(1, (pp - 0.08) / 0.28);
        gone = ex >= 0.995;
        ex = ex * ex;
        up = ex * H * 2.0;
      }
      const t = now / 1000;
      els.forEach((el, i) => {
        /* update() と同じ式（three の y 上向きを CSS の y 下向きに、回転は向きを反転） */
        const fx = Math.sin(t * (0.50 + i * 0.13) + i * 2.1) * 0.010 * H;
        const fy = Math.cos(t * (0.42 + i * 0.11) + i * 1.3) * 0.014 * H;
        const dx = (i - 1) * ex * W * 0.12 + fx;
        const dy = -(up + fy);
        const rot = -ex * (i - 1) * 0.45;
        el.style.transform = 'translate(' + dx.toFixed(1) + 'px,' + dy.toFixed(1) + 'px) rotate(' + rot.toFixed(3) + 'rad)';
        if (sp) { const g = up > goneAt[i]; if (el.__gone !== g) { el.__gone = g; el.style.visibility = g ? 'hidden' : ''; } }
      });
      if (!sp && gone !== lastGone) { lastGone = gone; for (const el of els) el.style.visibility = gone ? 'hidden' : ''; }
    }
    let running = false;
    function loop() { if (!running) return; requestAnimationFrame(loop); updateDom(); }
    function sync() { const want = !document.hidden; if (want && !running) { running = true; requestAnimationFrame(loop); } else if (!want) running = false; }
    document.addEventListener('visibilitychange', sync);
    updateDom();
    sync();
    window.__fvPhotos = { mode: 'dom', update: updateDom };
    return;
  }

  let planes = null;

  function build(L) {
    const THREE = L.THREE;
    planes = [];
    PHOTOS.forEach((p, i) => {
      const img = hero.querySelector(p.sel);
      if (!img) return;
      const tex = new THREE.TextureLoader().load(img.currentSrc || img.src);
      tex.colorSpace = THREE.SRGBColorSpace;
      /* 色は <img> と同じにしたいので composer（ACES）を通さない上描き層（L.overlayScene）に置く。
         depthTest も切る（composer の後に描くので深度バッファは当てにしない。順番は renderOrder） */
      const mat = new THREE.MeshBasicMaterial({ map: tex, transparent: true, depthWrite: false, depthTest: false, toneMapped: false });
      /* 角丸: 板の高さを 1 とした座標で角丸矩形の距離関数を取り、外側を透明にする（縁は 1px ぶんアンチエイリアス） */
      const uAspect = { value: 1 }, uRadius = { value: 0 };
      mat.onBeforeCompile = (sh) => {
        sh.uniforms.uAspect = uAspect;
        sh.uniforms.uRadius = uRadius;
        sh.fragmentShader = sh.fragmentShader
          .replace('#include <common>', '#include <common>\nuniform float uAspect;\nuniform float uRadius;')
          .replace('#include <map_fragment>', `#include <map_fragment>
  {
    vec2 hs = vec2(uAspect, 1.0) * 0.5;
    vec2 q = abs((vMapUv - 0.5) * vec2(uAspect, 1.0)) - (hs - uRadius);
    float d = length(max(q, 0.0)) - uRadius;
    float aa = fwidth(d);
    diffuseColor.a *= 1.0 - smoothstep(-aa, aa, d);
  }`);
      };
      const m = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), mat);
      m.renderOrder = 200 + i;
      m.userData.ph = p;
      m.userData.img = img;
      m.userData.i = i;
      m.userData.uAspect = uAspect;
      m.userData.uRadius = uRadius;
      m.userData.radiusPx = parseFloat(window.getComputedStyle(img).borderTopLeftRadius) || 0;
      (L.overlayScene || L.scene).add(m);
      planes.push(m);
    });
    hero.classList.add('is-photos-fx');
  }

  /* 板の矩形（画面幅・高さに対する比率。cx / cy = 中心、w / h = 大きさ）。
     PC はデモの値、SP は DOM の .hero__photo の矩形（= Figma の SP 配置）。SP の矩形はリサイズ時だけ測り直す */
  let domDirty = true;
  function geoOf(m, L) {
    const p = m.userData.ph;
    if (!SP_MQ.matches) return { cx: p.cx, cy: p.cy, w: p.h * (p.w / p.h * ASPECT_FIX) * (L.viewSize.H / L.viewSize.W), h: p.h };
    if (domDirty || !m.userData.geo) {
      const r = m.userData.img.getBoundingClientRect();
      const W = Math.max(1, L.viewSize.W), H = Math.max(1, L.viewSize.H);
      m.userData.geo = { cx: (r.left + r.width / 2) / W, cy: (r.top + r.height / 2) / H, w: r.width / W, h: r.height / H };
    }
    return m.userData.geo;
  }

  function update(L) {
    const cam = L.camera;
    const vh = 2 * Math.tan(35 * Math.PI / 180 / 2) * (cam.position.z - ZP), vw = vh * cam.aspect;
    const pp = fv.p;
    let ex = pp <= 0.08 ? 0 : Math.min(1, (pp - 0.08) / 0.28);
    const gone = ex >= 0.995;
    ex = ex * ex;
    const up = ex * vh * 2.0;
    const t = performance.now() / 1000;
    for (const m of planes) {
      const p = geoOf(m, L), i = m.userData.i;
      const fx = Math.sin(t * (0.50 + i * 0.13) + i * 2.1) * 0.010 * vh;
      const fy = Math.cos(t * (0.42 + i * 0.11) + i * 1.3) * 0.014 * vh;
      m.position.set((p.cx - 0.5) * vw + (i - 1) * ex * vw * 0.12 + fx, (0.5 - p.cy) * vh + up + fy, ZP);
      m.rotation.z = ex * (i - 1) * 0.45;
      const ph = p.h * vh, pw = p.w * vw;
      m.scale.set(pw, ph, 1);
      /* 角丸の大きさ: CSS の px を「板の高さ = 1」に換算（板の画面上の高さ = p.h * 画面高さ px） */
      m.userData.uAspect.value = pw / ph;
      m.userData.uRadius.value = Math.min(0.5, m.userData.radiusPx / Math.max(1, p.h * L.viewSize.H));
      m.visible = !gone;   /* 画面外へ抜けきったら描画停止（フェードはしない） */
    }
    domDirty = false;
  }
  new ResizeObserver(() => { domDirty = true; }).observe(hero);
  SP_MQ.addEventListener('change', () => { domDirty = true; });

  /* ni-logo.js のシーンができるのを待って登録 */
  (function wait() {
    const L = window.__niLogo;
    if (L && L.scene && L.hooks) {
      build(L);
      L.hooks.push(() => update(L));
      window.__fvPhotos = { planes, update: () => update(L) };
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
