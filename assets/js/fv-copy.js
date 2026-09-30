/* ==========================================================================
   fv-copy.js — FV コピーの演出（新卒「ヒット商品の裏側に…」/ 中途「そのインサイトの…」）

   デモ（デモ/NI_TOP.html「コピーの屈折ガラスワイプ(案7)」）をそのまま移植したもの。
   - 文字の中を流れる光: 深いロイヤルブルーの面に 3 つの光源（水色・バイオレット・ミッドブルー）が交差する
     グラデを毎フレーム描き、文字の形（α マスク）でくり抜く。Insight の筆記体だけは別のより明るく速い光
   - 出現: イントロでロゴが入り始めたら、左→右へ手書き風に描かれる（850ms。デモの 1700ms から短縮）
   - スクロールで消える: ロゴが定位置へ動く間（進行度 0.06〜0.20）にガラス板が右から左へ通過し、
     屈折で文字を歪ませ、消え際に白く漂白し、青→水色の残像を残して消す（WebGL シェーダ、デモ原文）

   文字マスクの作り方（ページで分岐）:
   - 新卒 .hero__copy: SVG 画像（hero_txt.svg / hero_txt_sp.svg）から。全体 = レイヤー A、`#Vector_2`（Insight）= レイヤー B。
     配置は PC はデモと同じ（左 9.1% / 上 22% / 幅 62.639%、画面基準）、SP は CSS の位置
   - 中途 .hero__txt: DOM のテキストから。各行の位置（Range.getClientRects）に同じフォントで描いて
     マスクにするので、CSS の改行・文字間隔・フォントがそのまま反映される。配置は CSS の位置
   進行度とイントロの時計は fv-scroll.js（ロゴと共用）。
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

const PADX = 0.11, PADY = 0.50;         /* 残像・ぼかしがはみ出すぶんの余白（文字ボックスに対する比率） */
const WIPE_START = 0.06, WIPE_LEN = 0.14;   /* デモの値: 進行度 → ワイプ ez((p-0.06)/0.14)。SP の基準の長さにも使う */
const WIPE_LEN_PC = 0.28;   /* PC は区間を倍に（2026-09-18「Insight が消える動きを倍くらい遅く」。0.06〜0.34。spacer 250vh @768 で 142〜804px） */
/* SP（〜767px）は消える速さを元の 1/WIPE_SLOW_SP に（2026-09-17。PC は別途調整）。進行度 p は 0.36 から先が非線形（終端 tailPx に圧縮）で
   p の区間を伸ばしても比例して遅くならないので、SP はスクロール量（px）で測る: 開始は同じ p=0.06 の位置、長さは元の区間（p 0.06〜0.20 の px）× 倍率 */
const WIPE_SLOW_SP = 4;
const WIPE_START_SP = 0;   /* SP はスクロールし始めた瞬間から消え始める（PC の 0.06 = ロゴが動いてから、は使わない） */
const SP_MQ = window.matchMedia('(max-width: 767px)');
function wipeOf(p) {
  if (!SP_MQ.matches) return ez((p - WIPE_START) / WIPE_LEN_PC);
  const a = fv.scrollAt(WIPE_START_SP), len = (fv.scrollAt(WIPE_START + WIPE_LEN) - fv.scrollAt(WIPE_START)) * WIPE_SLOW_SP;
  return Math.max(0, Math.min(1, (fv.scrollAt(p) - a) / Math.max(1, len)));   /* SP は線形（smoothstep だと最初の 30px ほど動いて見えない） */
}
const REV_DUR = 850;                    /* 手書きドロー出現の長さ (ms)。デモは 1700 だが速くする指示で半分に */
const INSIGHT_GROUP = 'Vector_2';       /* SVG 内の Insight 筆記体グループ */
const DEMO_POS = { x: 0.091, y: 0.22, w: 0.62639 };   /* デモの配置（hero 幅・高さに対する比率） */
const MASK_SCALE = 3;                   /* マスクの解像度（CSS px に対する倍率）。3 倍画面（iPhone）で粗く見えないよう 2 → 3（2026-09-17） */

const ez = (x) => (x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x));

const VSH = 'attribute vec2 p;varying vec2 v;void main(){v=p*0.5+0.5;v.y=1.0-v.y;gl_Position=vec4(p,0.,1.);}';
const FSH = [
  'precision highp float;varying vec2 v;uniform sampler2D uT;uniform sampler2D uT2;uniform float uHasB;uniform float uW;uniform float uTm;uniform float uRev;uniform float uTA;uniform float uTB;',   /* highp: Apple GPU は mediump が本当に 16bit で、hsh(v*791.3) 等のノイズが壊れて縁が掠れる（2026-09-17） */
  '/* 光（2D の paintTriLights / paintTriLightsB と同じ式）: 各光は中心 (lx,ly)、半径 r*幅 の放射グラデ（中心で不透明→縁で透明）を source-over */',
  'uniform float uAsp;',
  'float rad(vec2 uv,float lx,float ly,float r){ vec2 d=vec2(uv.x-lx,(uv.y-ly)*uAsp); return clamp(1.0-length(d)/r,0.0,1.0); }',
  'vec3 lightA(vec2 uv,float t){ vec3 c=vec3(0.1059,0.1569,0.4706); float a;',   /* #1B2878 */
  '  a=rad(uv,mod(t*0.135,1.5)-0.25,0.42,0.52); c=mix(c,vec3(0.1255,0.5765,0.8275),a);',   /* #2093D3 */
  '  a=rad(uv,1.25-mod(t*0.100,1.5),0.25,0.42); c=mix(c,vec3(0.2902,0.2431,0.7098),a);',   /* #4A3EB5 */
  '  a=rad(uv,mod(t*0.088+0.5,1.5)-0.25,0.80,0.44); c=mix(c,vec3(0.1922,0.3373,0.7216),a); return c; }',   /* #3156B8 */
  'vec3 lightB(vec2 uv,float t){ vec3 c=vec3(0.0784,0.1333,0.4392); float a;',   /* #142270 */
  '  a=rad(uv,mod(t*0.22,1.5)-0.25,0.50,0.60); c=mix(c,vec3(0.1686,0.6902,0.9098),a);',   /* #2BB0E8 */
  '  a=rad(uv,1.25-mod(t*0.16,1.5),0.28,0.45); c=mix(c,vec3(0.4157,0.3647,0.8392),a);',   /* #6A5DD6 */
  '  a=rad(uv,mod(t*0.13+0.5,1.5)-0.25,0.78,0.45); c=mix(c,vec3(0.2745,0.4667,0.8784),a); return c; }',   /* #4677E0 */
  '/* マスク: uRect = 文字の矩形（canvas uv）。外は 0 */',
  'uniform vec4 uRect;',
  'float inRect(vec2 m){ return step(0.0,m.x)*step(m.x,1.0)*step(0.0,m.y)*step(m.y,1.0); }',
  'float mA(vec2 p){ vec2 m=(p-uRect.xy)/uRect.zw; return texture2D(uT,m).a*inRect(m); }',
  'float mB(vec2 p){ vec2 m=(p-uRect.xy)/uRect.zw; return texture2D(uT2,m).a*inRect(m)*uHasB; }',
  'float hsh(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}',
  'float vn(vec2 p){vec2 i=floor(p),f=fract(p);f=f*f*(3.-2.*f);',
  ' return mix(mix(hsh(i),hsh(i+vec2(1,0)),f.x),mix(hsh(i+vec2(0,1)),hsh(i+vec2(1,1)),f.x),f.y);}',
  'float fbm(vec2 p){return 0.6*vn(p)+0.3*vn(p*2.1+7.7)+0.1*vn(p*4.3+3.1);}',
  'void main(){',
  '  /* 案D: 素のガラス+消え際の白漂白+青→水色グラデの残像 */',
  '  float wob=0.10*fbm(vec2(v.y*2.4, uTm*0.25))-0.05;',
  '  float bx=1.18-uW*1.5;',
  '  float xx=v.x+(v.y-0.5)*0.08+wob;',
  '  float rel=(xx-bx)/0.13;',
  '  float ib=step(abs(rel),1.0);',
  '  float k=ib*(1.0-rel*rel);',
  '  vec2 uv2=v; uv2.x+=k*0.075; uv2.y+=k*0.02*fbm(v*5.0+uTm*0.2)-k*0.01;',
  '  /* 文字のアルファ（板の通過中だけ 7 タップでにじませる。k=0 なら全タップ同じ点なので 1 回）と、シェーダで計算する光（2D 焼き込みの置き換え。2026-09-17） */',
  '  float aAll=0.0, aIns=0.0;',
  '  if(k>0.0){ float jit=hsh(v*791.3)-0.5;',
  '  for(int i=0;i<7;i++){ float fi=(float(i)-3.0+jit)/3.0;',
  '    vec2 q=uv2+vec2(k*0.03,0.0)+vec2(fi*0.016*k, fi*0.004*k); aAll+=mA(q); aIns+=mB(q); }',
  '  aAll/=7.0; aIns/=7.0; } else { aAll=mA(v); aIns=mB(v); }',
  '  vec3 LA=lightA(uv2,uTA), LB=lightB(uv2,uTB);',
  '  float aG=aIns+aAll*(1.0-aIns);',                                   /* 層 B（Insight）を層 A（全体）の上に source-over */
  '  vec3 ink=(LB*aIns+LA*aAll*(1.0-aIns))/max(aG,1e-3);',
  '  float wl=smoothstep(0.02,0.42,rel)*(1.0-smoothstep(0.42,1.25,rel));',
  '  ink=mix(ink, vec3(0.985,1.0,1.0), wl);',
  '  float er=1.0-smoothstep(0.45,1.0,rel);',
  '  float gEnv=smoothstep(0.30,0.95,rel)*(1.0-smoothstep(1.76,3.2,rel));',
  '  float gRad=0.016+0.017*clamp(rel-0.30,0.0,2.4);',
  '  float aB=0.0;',
  '  if(gEnv>0.0){',   /* 残像の帯の中だけ 15 タップ。外は gEnv=0 で aGhost=0 になるので同値 */
  '  for(int ix=-2;ix<=2;ix++)for(int iy=-1;iy<=1;iy++){',
  '    vec2 jo=vec2(hsh(v*513.7+float(ix)),hsh(v*367.1+float(iy)))-0.5;',
  '    aB+=mA(v+vec2(float(ix)*gRad, float(iy)*gRad*1.6)+jo*gRad*0.9); }',
  '  aB/=15.0; }',
  '  float age=smoothstep(0.85,2.88,rel);',
  '  float aGhost=clamp(aB*1.35,0.0,1.0)*gEnv*0.62;',
  '  aGhost*=1.0-smoothstep(0.90,1.0,uW);',
  '  vec3 gC1=vec3(0.10,0.30,0.96), gC2=vec3(0.30,0.60,0.99), gC3=vec3(0.34,0.80,1.0);',
  '  vec3 ghostC = age<0.5 ? mix(gC1,gC2,age*2.0) : mix(gC2,gC3,age*2.0-1.0);',
  '  float hn=fbm(v*vec2(2.6,5.2)+vec2(uTm*0.07,3.1));',
  '  ghostC=mix(ghostC, vec3(ghostC.r*0.55, ghostC.g*1.02, min(ghostC.b*1.05,1.0)), hn*0.55);',
  '  float veil=k*0.055;',
  '  float a=aG*er;',
  '  float ab=a+aGhost*(1.0-a);',
  '  vec3 cb=(ink*a+ghostC*aGhost*(1.0-a))/max(ab,1e-4);',
  '  float aa=veil+ab*(1.0-veil);',
  '  vec3 col=(vec3(0.97,0.985,1.0)*veil+cb*ab*(1.0-veil))/max(aa,1e-4);',
  '  float rxr=v.x+(v.y-0.5)*0.12;',
  '  float redge=uRev*1.24-0.12;',
  '  float revM=1.0-smoothstep(redge-0.02,redge+0.02,rxr);',
  '  aa*=revM;',
  '  gl_FragColor=vec4(col*aa,aa);   /* 乗算済みアルファで出す（premultipliedAlpha: true と対） */',
  '}'
].join('\n');

/* 光（案3b: トリプル光源 / INSIGHT 用の明るい光）は 2026-09-17 にシェーダへ移植（FSH の lightA / lightB）。
   以前は毎フレーム 2D canvas に焼いて texImage2D で転送していて、iPhone ではその転送が最大の負荷だった */

/* ---------- マスク: SVG 画像から 2 枚（全体 / Insight の筆記体だけ） ---------- */
async function loadSvgMasks(url) {
  const text = await (await fetch(url)).text();
  const doc = new DOMParser().parseFromString(text, 'image/svg+xml');
  const root = doc.documentElement;
  root.removeAttribute('style');
  const toImage = (svgEl) => new Promise((resolve, reject) => {
    const blob = new Blob([new XMLSerializer().serializeToString(svgEl)], { type: 'image/svg+xml' });
    const u = URL.createObjectURL(blob);
    const im = new Image();
    im.onload = () => { URL.revokeObjectURL(u); resolve(im); };
    im.onerror = reject;
    im.src = u;
  });
  const all = await toImage(root);
  const ins = root.cloneNode(true);
  let found = false;
  for (const g of ins.querySelectorAll('g[id]')) {
    if (g.id === INSIGHT_GROUP) { found = true; continue; }
    if (g.querySelector('#' + INSIGHT_GROUP)) continue;   /* 親グループは残す */
    g.setAttribute('display', 'none');
  }
  const insight = found ? await toImage(ins) : null;
  const w = parseFloat(root.getAttribute('width')) || all.naturalWidth;
  const h = parseFloat(root.getAttribute('height')) || all.naturalHeight;
  return { all, insight, w, h };
}

/* ---------- マスク: DOM のテキストから（行ごとに同じフォントで描く） ----------
   box: マスクの原点・大きさ（画面座標 px）。文字は Range.getClientRects で行の位置を拾い、
   computed style のフォント・字間で fillText する。改行（<br> / 折り返し）はそのまま反映される */
function buildDomMask(root, box) {
  const c = document.createElement('canvas');
  c.width = Math.max(2, Math.round(box.w * MASK_SCALE));
  c.height = Math.max(2, Math.round(box.h * MASK_SCALE));
  const x = c.getContext('2d');
  x.scale(MASK_SCALE, MASK_SCALE);
  x.fillStyle = '#000';
  x.textBaseline = 'alphabetic';
  const range = document.createRange();
  const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
  let node;
  while ((node = walker.nextNode())) {
    const text = node.textContent;
    if (!text.trim()) continue;
    const el = node.parentElement;
    const cs = window.getComputedStyle(el);
    if (cs.display === 'none') continue;
    x.font = `${cs.fontStyle} ${cs.fontWeight} ${cs.fontSize} ${cs.fontFamily}`;
    if ('letterSpacing' in x) x.letterSpacing = cs.letterSpacing === 'normal' ? '0px' : cs.letterSpacing;
    let runStart = 0, runRect = null;
    const flush = (end) => {
      if (!runRect) return;
      const str = text.slice(runStart, end);
      const m = x.measureText(str);
      const asc = m.fontBoundingBoxAscent || parseFloat(cs.fontSize) * 0.88;
      x.fillText(str, runRect.left - box.x, runRect.top - box.y + asc);
    };
    for (let i = 0; i < text.length; i++) {
      range.setStart(node, i);
      range.setEnd(node, i + 1);
      const r = range.getClientRects()[0];
      if (!r || (r.width === 0 && r.height === 0)) continue;
      if (runRect && Math.abs(r.top - runRect.top) > 1) {   /* 行が変わった */
        flush(i);
        runStart = i;
        runRect = null;
      }
      if (!runRect) runRect = r;
    }
    flush(text.length);
  }
  return c;
}

function init() {
  const hero = document.querySelector('.hero[data-anim="fv"]');
  const copy = hero && hero.querySelector('.hero__copy, .hero__txt');
  if (!hero || !copy) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bcopy\b/.test(window.location.search)) return;   /* ?off=copy でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const imgs = [...copy.querySelectorAll('img')];
  const mode = imgs.length ? 'svg' : 'dom';

  const cv = document.createElement('canvas');
  cv.className = 'hero__copy-fx';
  cv.setAttribute('aria-hidden', 'true');
  /* premultipliedAlpha は true: WebKit（iOS / Mac Safari）は false の透明 canvas を正しく合成できず、文字の縁が白く出たり
     掠れて見える（2026-09-17 実機で確認。fv-blob.js と同じ対処）。シェーダ側で色にアルファを掛け、ブレンドは ONE / ONE_MINUS_SRC_ALPHA */
  const gl = cv.getContext('webgl', { premultipliedAlpha: true, alpha: true, antialias: false });
  if (!gl) return;
  /* 2D canvas（内部は乗算済み）を乗算済みのまま渡す。既定の逆乗算は WebKit で粗く、文字の縁が白くなる。シェーダは rgb/a で読む（乗算済み前提） */
  gl.pixelStorei(gl.UNPACK_PREMULTIPLY_ALPHA_WEBGL, true);

  function sh(t, src) {
    const o = gl.createShader(t); gl.shaderSource(o, src); gl.compileShader(o);
    if (!gl.getShaderParameter(o, gl.COMPILE_STATUS)) console.error(gl.getShaderInfoLog(o));
    return o;
  }
  const pr = gl.createProgram();
  gl.attachShader(pr, sh(gl.VERTEX_SHADER, VSH)); gl.attachShader(pr, sh(gl.FRAGMENT_SHADER, FSH));
  gl.linkProgram(pr); gl.useProgram(pr);
  const b = gl.createBuffer(); gl.bindBuffer(gl.ARRAY_BUFFER, b);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
  const lp = gl.getAttribLocation(pr, 'p'); gl.enableVertexAttribArray(lp);
  gl.vertexAttribPointer(lp, 2, gl.FLOAT, false, 0, 0);
  const uW = gl.getUniformLocation(pr, 'uW'), uTm = gl.getUniformLocation(pr, 'uTm');
  const uRev = gl.getUniformLocation(pr, 'uRev');
  const uTA = gl.getUniformLocation(pr, 'uTA'), uTB = gl.getUniformLocation(pr, 'uTB');
  const uAsp = gl.getUniformLocation(pr, 'uAsp'), uRect = gl.getUniformLocation(pr, 'uRect'), uHasB = gl.getUniformLocation(pr, 'uHasB');
  gl.uniform1i(gl.getUniformLocation(pr, 'uT'), 0);
  gl.uniform1i(gl.getUniformLocation(pr, 'uT2'), 1);
  gl.clearColor(0, 0, 0, 0); gl.enable(gl.BLEND); gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);

  /* マスクのテクスチャ 2 枚（全体 / Insight）。レイアウトが決まったとき（fit）に 1 回だけラスタライズして転送する。
     文字の矩形は canvas の中で余白（PADX / PADY）ぶん内側 = 固定の uRect */
  function makeTex(unit) {
    const t = gl.createTexture();
    gl.activeTexture(gl.TEXTURE0 + unit);
    gl.bindTexture(gl.TEXTURE_2D, t);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    return t;
  }
  const texA = makeTex(0), texB = makeTex(1);
  gl.uniform4f(uRect, PADX / (1 + 2 * PADX), PADY / (1 + 2 * PADY), 1 / (1 + 2 * PADX), 1 / (1 + 2 * PADY));
  const rasC = document.createElement('canvas'), ras = rasC.getContext('2d');
  let masks = null, ratio = 387 / 902;
  let activeImg = null, loading = null;
  let domBox = null;   /* dom モード: 文字ボックス（hero 座標 px） */
  let uploadedKey = '';

  function setMasks(m) {
    masks = m;
    ratio = m.h / m.w;
    uploadedKey = '';
  }
  /* マスクを表示サイズ × MASK_SCALE でラスタライズして転送（サイズかマスクが変わったときだけ） */
  function uploadMasks(tw, th) {
    if (!masks) return false;
    const w = Math.min(2048, Math.max(2, Math.round(tw * MASK_SCALE))), h = Math.max(2, Math.round(th * MASK_SCALE));
    const key = w + 'x' + h + ':' + (masks.insight ? 'b' : 'a');
    if (key === uploadedKey) return true;
    const put = (unit, t, src) => {
      rasC.width = w; rasC.height = h;
      ras.clearRect(0, 0, w, h);
      ras.drawImage(src, 0, 0, w, h);
      gl.activeTexture(gl.TEXTURE0 + unit);
      gl.bindTexture(gl.TEXTURE_2D, t);
      gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, rasC);
    };
    put(0, texA, masks.all);
    if (masks.insight) put(1, texB, masks.insight);
    gl.uniform1f(uHasB, masks.insight ? 1 : 0);
    uploadedKey = key;
    return true;
  }

  function visibleImg() {
    return imgs.find((im) => im.offsetParent !== null || window.getComputedStyle(im).display !== 'none') || imgs[0];
  }
  /* 要素の hero 内での位置（レイアウト値。fixed の hero は画面座標と同じ） */
  function offsetIn(el) {
    let x = 0, y = 0, e = el;
    while (e && e !== hero) { x += e.offsetLeft; y += e.offsetTop; e = e.offsetParent; }
    return { x, y, w: el.offsetWidth, h: el.offsetHeight };
  }

  function ensureMasks() {
    if (mode === 'svg') {
      const im = visibleImg();
      if (im === activeImg || loading) return;
      loading = loadSvgMasks(im.getAttribute('src')).then((m) => {
        setMasks(m); activeImg = im; loading = null;
        fit();
      }).catch((e) => { loading = null; console.warn('[fv-copy] マスク画像の読み込みに失敗', e); });
    } else {
      const box = offsetIn(copy);
      if (!box.w || !box.h) return;
      const hr = hero.getBoundingClientRect();
      const all = buildDomMask(copy, { x: hr.left + box.x, y: hr.top + box.y, w: box.w, h: box.h });
      setMasks({ all, insight: null, w: box.w, h: box.h });
      domBox = box;
    }
  }

  let baked = false;   /* マスク転送済み */

  /* 配置: 新卒 PC はデモの比率（hero 基準）、それ以外は要素の CSS 位置 */
  function fit() {
    const r = hero.getBoundingClientRect();
    if (!r.width || !r.height) return;
    let tw, th, L, T;
    if (mode === 'svg' && window.matchMedia('(min-width: 768px)').matches) {
      tw = DEMO_POS.w * r.width; th = tw * ratio;
      L = DEMO_POS.x * r.width; T = DEMO_POS.y * r.height;
    } else {
      const box = mode === 'svg' ? offsetIn(activeImg || visibleImg()) : (domBox || offsetIn(copy));
      tw = box.w; th = box.h; L = box.x; T = box.y;
    }
    const px = tw * PADX, py = th * PADY;
    cv.style.left = (L - px) + 'px'; cv.style.top = (T - py) + 'px';
    cv.style.width = (tw + 2 * px) + 'px'; cv.style.height = (th + 2 * py) + 'px';
    /* 解像度: SP は 3 倍まで（canvas が小さい）、PC は 2 倍まで。1.5 だと 3 倍画面でピクセルが見える（2026-09-17） */
    const dpr = Math.min(window.matchMedia('(max-width: 767px)').matches ? 3 : 2, window.devicePixelRatio || 1);
    cv.width = Math.round((tw + 2 * px) * dpr); cv.height = Math.round((th + 2 * py) * dpr);
    gl.viewport(0, 0, cv.width, cv.height);
    gl.uniform1f(uAsp, cv.height / Math.max(1, cv.width));   /* 光の放射は幅基準の半径なので、縦の距離を幅の比に直す */
    baked = uploadMasks(tw, th);
  }

  /* 手書きドロー出現(uRev): イントロでロゴが入り始めたら左→右で描く（5 秒待っても始まらなければ強制） */
  let revT0 = null;
  const revFB = performance.now();
  let shown = false;
  let running = false;

  function frame() {
    const now = performance.now();
    fv.tick(now);
    const p = fv.p;
    const w = wipeOf(p);   /* ロゴ移動中にコピーをワイプ */
    const t = now / 1000;
    if (mode === 'svg') ensureMasks();
    if (!baked) baked = uploadMasks(cv.clientWidth / (1 + 2 * PADX), cv.clientHeight / (1 + 2 * PADY));   /* マスクが後から読めたとき */
    if (!baked) {
      /* スクロール済みで再読み込みした時: 最初からワイプ完了なので焼き込まない。静的画像だけは隠す（見えていてはいけない） */
      if (w >= 0.999 && !shown) { shown = true; hero.classList.add('is-copy-fx'); }
      return;
    }
    gl.uniform1f(uW, w);
    gl.uniform1f(uTm, t);
    gl.uniform1f(uTA, t + p * 2.4);              /* 光 A の位相（以前の paintTriLights(…, tsec + p*2.4) と同じ） */
    gl.uniform1f(uTB, t + p * 3.0 + 4.2);        /* 光 B（Insight）の位相（paintTriLightsB(…, tsec + p*3.0 + 4.2)） */
    if (revT0 === null && (fv.introK > 0.001 || now - revFB > 5000)) revT0 = now;
    const rev = revT0 === null ? 0 : ez(Math.min(1, (now - revT0) / REV_DUR));
    gl.uniform1f(uRev, rev);
    gl.clear(gl.COLOR_BUFFER_BIT);
    if (w < 0.999) gl.drawArrays(gl.TRIANGLES, 0, 3);
    if (!shown) { shown = true; hero.classList.add('is-copy-fx'); }
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
  cv.addEventListener('webglcontextlost', (e) => { e.preventDefault(); running = false; hero.classList.remove('is-copy-fx'); });

  hero.appendChild(cv);
  const relayout = () => { ensureMasks(); fit(); };
  window.addEventListener('resize', relayout);
  if (mode === 'dom' && document.fonts && document.fonts.ready) {
    /* Web フォント確定後に作り直す（フォールバックフォントで作ったマスクを置き換える） */
    document.fonts.ready.then(relayout);
  }
  relayout();
  sync();

  window.__fvCopy = { frame, fit, mode, get wipe() { return wipeOf(fv.p); } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
