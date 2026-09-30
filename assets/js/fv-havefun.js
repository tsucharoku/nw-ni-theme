/* ==========================================================================
   fv-havefun.js — 「Have Fun!」の演出（新卒 TOP）

   デモ（デモ/NI_TOP.html「Have Fun!の屈折ガラスワイプ」）をそのまま移植したもの。
   - 位置（PC）は画面固定。左・上は Figma の Message 節の「Have Fun!」（x 705 / y 262 @1440×768）に合わせ、
     hero 基準で左 48.96% / 上 34.15%。幅は demo の HF_W（42.63%。Figma の 188px 2 行の字面と同じ）
   - 位置（SP、〜767px）は画面固定にせず、Message 内の DOM「.message__havefun」（visibility: hidden のまま
     Figma 470:2697 のレイアウト = 本文の上、68px 2 行）の画面上の矩形に毎フレーム合わせる。Message は fv-message.js が
     下から上げて半速で抜けるので、Have Fun! もそれと一緒に動く（2026-09-14 指示: SP は固定にしない）。
     大きさは DOM の高さから決める（SVG 255 = PC の DOM 高さ 248 の比。幅は SVG の比率）、左右は DOM の中心に合わせる。
     canvas は SP では全幅（CX = 0）
   - 文字の中を流れる光: FV コピーと同じトリプル光源のグラデ（位相を少しずらす）を毎フレーム焼き、文字の形でくり抜く
   - 出現: ロゴが定位置へ動いた後（進行度 0.20〜0.32）、ガラス板が左→右へ通過して現れる
     （板の下で歪みながら現れ、現れ際に白く光ってから定着、エッジ先行の青→水色のミスト）
   - ロゴの背面に置く（demo と同じ。demo は出現後にロゴの奥の板へ移していたが、ここでは最初から背面）:
     canvas はロゴの canvas（.ni-logo）の直前に画面固定で差し込み（重なり順はロゴの下）、さらにロゴの背景板の層
     （ni-logo.js の bgLayers）にも描くので、ロゴ越しにはガラスで屈折した Have Fun! が見える。
     描画はロゴのフレーム（hooks）から呼ばれる（同じフレームで先に描いてから背景板に取り込む）。
     ロゴが無い（WebGL 不可など）ときは従来どおり hero の中に置く
   - 動画背景が見える範囲の外は見えなくする: About（[data-logo-end] か .about）の上端より下を clip-path で
     切り取り、上端が画面上端を越えたら描かない（Message は fv-message.js で早めに上がってくるので、その下端は使わない）

   文字マスクはデモと同じ SVG（assets/img/beginner/havefun.svg）。
   canvas は hero の右 60% を覆う（屈折の揺れぶんの余白込み）。進行度は fv-scroll.js（ロゴ・コピーと共用）。
   ========================================================================== */
import { fv } from './fv-scroll.js?v=202609181000';

/* WP テーマ: ページの URL ではなくこのファイルの場所から解決する（静的版は '../assets/img/beginner/havefun.svg'） */
const SRC = new URL('../img/beginner/havefun.svg', import.meta.url).href;
/* SP で Have Fun! をロゴの前に出すスイッチ（2026-09-17 指示「SP だけロゴを Have Fun! の後ろに」）。
   true: SP は canvas をロゴ canvas の直後に差し込み（DOM 順で前）、ロゴの背景板には描かない（屈折の写り込みなし）。
   false: 従来どおり PC と同じくロゴの背面（ガラス越しに屈折）。戻すときはここを false にするだけ。PC はどちらでも背面 */
const SP_FRONT = true;
const SP_MQ = window.matchMedia('(max-width: 767px)');
const isSP = () => SP_MQ.matches;
const CX_PC = 0.40;                                /* canvas 左端（hero 幅比。文字の左に屈折の余白を持つ）。SP は 0（全幅） */
const CX = () => (isSP() ? 0 : CX_PC);
const HF_L = 705 / 1440, HF_T = 262.3 / 768, HF_W = 0.4263;   /* PC: 左・上は Figma（Message 節の Have Fun!）、幅は demo の HF_W */
const DOM_H_PC = 248;                              /* PC の DOM「Have Fun!」の高さ（188px × 0.68 × 2 行 × scaleY 0.97）。SVG の 255 と対応 */
const WIPE_START_PC = 0.20, WIPE_LEN = 0.12;       /* 出現: ez((p-0.20)/0.12) */
const WIPE_START_SP = 0.16;                        /* SP は Message の出現（fv-message.js の 0.20）に合わせて 0.16 から */
const WIPE_START = () => (isSP() ? WIPE_START_SP : WIPE_START_PC);

const ez = (x) => (x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x));

/* 光（案3b: トリプル光源）は 2026-09-17 にシェーダへ移植（FSH の lightA）。以前は毎フレーム 2D canvas に焼いて転送していた */

const VSH = 'attribute vec2 p;varying vec2 v;void main(){v=p*0.5+0.5;v.y=1.0-v.y;gl_Position=vec4(p,0.,1.);}';
const FSH = [
  'precision highp float;varying vec2 v;uniform sampler2D uT;uniform float uW;uniform float uTm;uniform float uTA;',   /* highp: Apple GPU は mediump が 16bit でノイズが壊れる（fv-copy.js と同じ。2026-09-17） */
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
  'float hsh(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}',
  'float vn(vec2 p){vec2 i=floor(p),f=fract(p);f=f*f*(3.-2.*f);',
  ' return mix(mix(hsh(i),hsh(i+vec2(1,0)),f.x),mix(hsh(i+vec2(0,1)),hsh(i+vec2(1,1)),f.x),f.y);}',
  'float fbm(vec2 p){return 0.6*vn(p)+0.3*vn(p*2.1+7.7)+0.1*vn(p*4.3+3.1);}',
  'void main(){',
  '  /* 案D(出現ミラー): 素のガラス+現れ際の白漂白+エッジ先行の青→水色ミスト */',
  '  float wob=0.10*fbm(vec2(v.y*2.4, uTm*0.25))-0.05;',
  '  float bx=-0.18+uW*1.5;',
  '  float xx=v.x+(v.y-0.5)*0.08+wob;',
  '  float rel=(bx-xx)/0.13;',
  '  float ib=step(abs(rel),1.0);',
  '  float k=ib*(1.0-rel*rel);',
  '  vec2 uv2=v; uv2.x-=k*0.075; uv2.y+=k*0.02*fbm(v*5.0+uTm*0.2)-k*0.01;',
  '  /* 文字のアルファ（板の通過中だけ 7 タップ）と、シェーダで計算する光（2D 焼き込みの置き換え。2026-09-17） */',
  '  float aG=0.0;',
  '  if(k>0.0){ float jit=hsh(v*791.3)-0.5;',
  '  for(int i=0;i<7;i++){ float fi=(float(i)-3.0+jit)/3.0;',
  '    aG+=mA(uv2-vec2(k*0.03,0.0)+vec2(fi*0.016*k, fi*0.004*k)); }',
  '  aG/=7.0; } else { aG=mA(v); }',
  '  vec3 colT=lightA(uv2,uTA);',
  '  float wl=smoothstep(-0.60,0.05,rel)*(1.0-smoothstep(0.05,0.95,rel));',
  '  colT=mix(colT, vec3(0.985,1.0,1.0), wl);',
  '  float vr=smoothstep(-0.85,0.55,rel);',
  '  float relN=-rel;',
  '  float gEnv=smoothstep(0.30,0.95,relN)*(1.0-smoothstep(1.76,3.2,relN));',
  '  float gRad=0.016+0.017*clamp(relN-0.30,0.0,2.4);',
  '  float aB=0.0;',
  '  if(gEnv>0.0){',   /* 残像の帯の中だけ 15 タップ（fv-copy.js と同じ） */
  '  for(int ix=-2;ix<=2;ix++)for(int iy=-1;iy<=1;iy++){',
  '    vec2 jo=vec2(hsh(v*513.7+float(ix)),hsh(v*367.1+float(iy)))-0.5;',
  '    aB+=mA(v+vec2(float(ix)*gRad, float(iy)*gRad*1.6)+jo*gRad*0.9); }',
  '  aB/=15.0; }',
  '  float age=smoothstep(0.85,2.88,relN);',
  '  float aGhost=clamp(aB*1.35,0.0,1.0)*gEnv*0.62*step(0.001,uW)*step(uW,0.999);',
  '  vec3 gC1=vec3(0.10,0.30,0.96), gC2=vec3(0.30,0.60,0.99), gC3=vec3(0.34,0.80,1.0);',
  '  vec3 ghostC = age<0.5 ? mix(gC1,gC2,age*2.0) : mix(gC2,gC3,age*2.0-1.0);',
  '  float hn=fbm(v*vec2(2.6,5.2)+vec2(uTm*0.07,3.1));',
  '  ghostC=mix(ghostC, vec3(ghostC.r*0.55, ghostC.g*1.02, min(ghostC.b*1.05,1.0)), hn*0.55);',
  '  float veil=k*0.055;',
  '  float a=aG*vr;',
  '  float ab=a+aGhost*(1.0-a);',
  '  vec3 cb=(colT*a+ghostC*aGhost*(1.0-a))/max(ab,1e-4);',
  '  float aa=veil+ab*(1.0-veil);',
  '  vec3 col=(vec3(0.97,0.985,1.0)*veil+cb*ab*(1.0-veil))/max(aa,1e-4);',
  '  gl_FragColor=vec4(col*aa,aa);   /* 乗算済みアルファで出す（premultipliedAlpha: true と対） */',
  '}'
].join('\n');

function init() {
  const hero = document.querySelector('.hero[data-anim="fv"]');
  if (!hero) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bhavefun\b/.test(window.location.search)) return;   /* ?off=havefun でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const cv = document.createElement('canvas');
  cv.className = 'hero__havefun-fx';
  cv.setAttribute('aria-hidden', 'true');
  /* premultipliedAlpha は true: WebKit（iOS / Mac Safari）は false の透明 canvas を正しく合成できず、文字の縁が白く出たり
     掠れて見える（2026-09-17 実機で確認。fv-blob.js と同じ対処）。シェーダ側で色にアルファを掛け、ブレンドは ONE / ONE_MINUS_SRC_ALPHA */
  const gl = cv.getContext('webgl', { premultipliedAlpha: true, alpha: true, antialias: false });
  if (!gl) return;
  gl.pixelStorei(gl.UNPACK_PREMULTIPLY_ALPHA_WEBGL, true);   /* 乗算済みのまま渡す（fv-copy.js と同じ理由） */

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
  const uTA = gl.getUniformLocation(pr, 'uTA'), uAsp = gl.getUniformLocation(pr, 'uAsp'), uRect = gl.getUniformLocation(pr, 'uRect');
  gl.uniform1i(gl.getUniformLocation(pr, 'uT'), 0);
  gl.clearColor(0, 0, 0, 0); gl.enable(gl.BLEND); gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);

  /* テクスチャ: Have Fun! の文字マスク（SVG）を 1 回だけラスタライズして転送。位置・大きさは毎フレーム uRect（canvas uv の矩形）で渡す。
     光はシェーダで計算（canvas = hero の右 60%。SP は全幅） */
  const img = new Image();
  img.src = SRC;
  const tex = gl.createTexture();
  let baked = false;
  gl.bindTexture(gl.TEXTURE_2D, tex);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
  const MASK_W = 1600;   /* マスクの解像度（幅 px。表示は最大でも PC 614 CSS px × 2 倍） */
  function uploadMask() {
    if (baked) return true;
    if (!img.complete || !img.naturalWidth) return false;
    const c = document.createElement('canvas');
    c.width = MASK_W; c.height = Math.max(2, Math.round(MASK_W * img.naturalHeight / img.naturalWidth));
    c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
    gl.bindTexture(gl.TEXTURE_2D, tex);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, c);
    baked = true;
    return true;
  }
  /* 文字の矩形（hero px）。PC は画面固定の比率、SP は Message 内の DOM の位置（fv-message.js の transform 込み） */
  const hfDom = document.querySelector('.message__havefun');
  /* SP は canvas を Message の中（文字の箱の位置に absolute）に置き、ブラウザにスクロールさせる（2026-09-17）。
     画面固定の canvas を JS で毎フレーム追従させると、iOS はスクロールを先に描いて JS が後追いするので 1 コマ遅れて跳ねて見えた。
     位置は fit() で決めて以後動かさない。光のワイプは中身の描画だけ。About は不透明で後ろにあるので自然に覆う */
  const msgEl = hfDom && hfDom.closest('.message');
  const IN_MSG = isSP() && !!hfDom && !!msgEl;
  function hfRect(W, H) {
    const aspect = img.naturalWidth / img.naturalHeight;
    if (!isSP() || !hfDom) {
      const w = HF_W * W;
      return { x: HF_L * W, y: HF_T * H, w, h: w / aspect };
    }
    const b = hfDom.getBoundingClientRect();
    if (!b.height) return null;
    const h = b.height * (img.naturalHeight / DOM_H_PC);
    const w = h * aspect;
    return { x: b.left + b.width / 2 - w / 2, y: b.top, w, h };
  }
  /* 文字の矩形を canvas uv に直して uniform へ（毎フレーム。転送はしない）。矩形が取れなければ false */
  function setRect() {
    const W = hero.clientWidth || 1, H = hero.clientHeight || 1;
    const r = hfRect(W, H);
    if (!r) return false;
    const cw = W * (1 - CX());
    gl.uniform4f(uRect, (r.x - CX() * W) / cw, r.y / H, r.w / cw, r.h / H);
    return true;
  }
  let placed = false;   /* IN_MSG: 箱を置けた（img 読み込み後） */
  function fit() {
    const dpr = Math.min(2, window.devicePixelRatio || 1);   /* 1.5 → 2（2026-09-17） */
    if (IN_MSG) {
      if (!img.complete || !img.naturalWidth) { placed = false; return; }
      const b = hfDom.getBoundingClientRect(), m = msgEl.getBoundingClientRect();
      if (!b.height) { placed = false; return; }
      /* 文字の矩形（画面 px）は従来の hfRect と同じ取り方。glass のゆらぎ・残像のはみ出しぶん、箱は左右 25% / 上下 40% 広げる */
      const h = b.height * (img.naturalHeight / DOM_H_PC), w = h * (img.naturalWidth / img.naturalHeight);
      const x = b.left + b.width / 2 - w / 2, y = b.top;
      const mx = w * 0.25, my = h * 0.40;
      const bw = w + 2 * mx, bh = h + 2 * my;
      cv.style.left = (x - mx - m.left) + 'px'; cv.style.top = (y - my - m.top) + 'px';
      cv.style.width = bw + 'px'; cv.style.height = bh + 'px';
      cv.width = Math.round(bw * dpr); cv.height = Math.round(bh * dpr);
      gl.viewport(0, 0, cv.width, cv.height);
      gl.uniform1f(uAsp, cv.height / Math.max(1, cv.width));
      gl.uniform4f(uRect, mx / bw, my / bh, w / bw, h / bh);
      placed = true; done = false;
      uploadMask();
      return;
    }
    const r = hero.getBoundingClientRect();
    cv.width = Math.round(r.width * (1 - CX()) * dpr); cv.height = Math.round(r.height * dpr);
    gl.viewport(0, 0, cv.width, cv.height);
    gl.uniform1f(uAsp, cv.height / Math.max(1, cv.width));
    uploadMask();
  }

  /* About の上端で切る（動画背景が隠れたら見えない） */
  const logoEnd = document.querySelector('[data-logo-end]') || document.querySelector('.about');
  let clipBottom = -1;
  function clipToMessage() {
    if (IN_MSG) return false;   /* Message と一緒にスクロールし、About が自然に覆う */
    if (!logoEnd && !window.__fvAbout) return false;
    const H = hero.clientHeight || window.innerHeight;
    const bottom = window.__fvAbout ? window.__fvAbout.coverTop() : logoEnd.getBoundingClientRect().top;
    const visible = Math.max(0, Math.min(H, Math.round(bottom)));
    clipBottom = H - visible;   /* CSS px。切り取りは draw() のシザーで（clip-path の毎フレーム書き換えは iOS で重い。2026-09-17） */
    return visible <= 0;
  }

  let shown = false;
  let running = false;
  let hooked = false;   /* ロゴのフレームから描く（ロゴの背面モード） */
  let offNow = false;
  /* 描画本体（焼き込み + ワイプ）。ロゴがあるときはロゴの hooks から同じフレームで呼ばれる */
  /* SP（IN_MSG）: ワイプが終わったら描き直しをやめる（光の位相はそこで固定。2026-09-17 指示「文字の中のグラデーションを止める」）。PC は流し続ける */
  const HF_WIPE_TOP_SP = 0.92, HF_WIPE_LEN_SP = 0.45;   /* SP: 文字の上端が画面高の 92% に来たら始まり、45% ぶん上がる間に進む（2026-09-17: 0.30 → 0.45 で少しゆっくりに）。TOP は fv-message.js の HF_WIPE_TOP と同じ値 */
  function wipeNow(p) {
    if (!isSP()) return ez((p - WIPE_START()) / WIPE_LEN);
    const hh = hero.clientHeight || window.innerHeight;
    const r0 = hfRect(hero.clientWidth || 1, hh);
    return r0 ? ez((hh * HF_WIPE_TOP_SP - r0.y) / (hh * HF_WIPE_LEN_SP)) : 0;
  }
  let done = false;   /* IN_MSG: ワイプ完了後の最終フレームを描いた（以後は描き直さない = 負荷ゼロ。ワイプ前に戻れば再開） */
  let wSmooth = 0, wLast = -1;   /* IN_MSG: 慣性つきのワイプ値 */
  function draw() {
    if (offNow) return;
    const now = performance.now();
    const p = fv.p;
    const t = now / 1000;
    if (!uploadMask()) return;
    /* ワイプの進み。PC は進行度（早出し: ロゴ定位時には出現済み → ロゴが被る）。SP は文字の上端が画面の 92% → 47% を通る間（位置基準、HF_WIPE_LEN_SP）。
       SP は fv-scroll.js と同じ時間ベースの慣性で目標値に追わせる（速く弾いても一気に出ず、0.1 秒ほどかけて現れる。位置は Message と一緒なので跳ねない） */
    let w = wipeNow(p);
    if (IN_MSG) {
      const dt = wLast < 0 ? 1000 / 60 : Math.max(0, Math.min(100, now - wLast));
      wLast = now;
      wSmooth += (w - wSmooth) * (1 - Math.pow(1 - fv.inertia(), dt / (1000 / 60)));
      if (Math.abs(w - wSmooth) < 0.002) wSmooth = w;
      w = wSmooth;
    }
    if (IN_MSG) {
      if (!placed) { fit(); if (!placed) return; }
      if (w >= 0.999) { if (done) return; done = true; } else done = false;
    } else if (!setRect()) return;
    gl.uniform1f(uW, w);
    gl.uniform1f(uTm, t);
    gl.uniform1f(uTA, t + p * 2.4 + 1.7);                /* 光の位相（以前の paintTriLights(…, tsec + p*2.4 + 1.7) と同じ） */
    /* 画面全体を透明にクリアしてから、About より上だけにシザーを掛けて描く */
    gl.disable(gl.SCISSOR_TEST);
    gl.clear(gl.COLOR_BUFFER_BIT);
    if (clipBottom > 0) {
      const sy = Math.round(clipBottom * cv.height / Math.max(1, cv.clientHeight || (hero.clientHeight || 1)));
      gl.enable(gl.SCISSOR_TEST);
      gl.scissor(0, sy, cv.width, Math.max(0, cv.height - sy));   /* 原点は左下 */
    }
    if (baked) gl.drawArrays(gl.TRIANGLES, 0, 3);
    if (baked && !shown) { shown = true; document.body.classList.add('is-havefun-fx'); }
  }
  function frame() {
    fv.tick(performance.now());
    offNow = clipToMessage();
    if (!IN_MSG) cv.style.visibility = offNow ? 'hidden' : '';
    if (!hooked) draw();
  }
  function loop() {
    if (!running) return;
    requestAnimationFrame(loop);
    frame();
  }
  /* ロゴの背面へ: ロゴ canvas の直前に画面固定で置き、ロゴの背景板の層に登録、描画はロゴの hooks で */
  function attachBehind(L) {
    const lc = L.renderer && L.renderer.domElement;
    if (!lc || !lc.parentNode || !L.hooks || !L.bgLayers) return false;
    const front = SP_FRONT && isSP();   /* SP は前面（判定は読み込み時のみ） */
    if (!IN_MSG) {
      cv.classList.add('hero__havefun-fx--behind');   /* 画面固定・z 0 の置き方は前面でも同じ。前後は DOM 順で決める */
      lc.parentNode.insertBefore(cv, front ? lc.nextSibling : lc);
    }
    L.hooks.push(() => draw());
    if (!front && !IN_MSG) {
      L.bgLayers.push({
        canvas: cv,
        afterVeil: true,   /* demo と同じく青ベールの後に不透明で描く（ガラス越しにはっきり見える） */
        rect() { const W = window.innerWidth, H = window.innerHeight, cx = CX(); return { x: cx * W, y: 0, w: (1 - cx) * W, h: H }; }
      });
    }
    hooked = true;
    return true;
  }
  function sync() {
    const want = !document.hidden;
    if (want && !running) { running = true; requestAnimationFrame(loop); }
    else if (!want) running = false;
  }
  document.addEventListener('visibilitychange', sync);
  cv.addEventListener('webglcontextlost', (e) => {
    e.preventDefault(); running = false;
    document.body.classList.remove('is-havefun-fx');
  });

  if (IN_MSG) {
    cv.classList.add('message__havefun-fx');   /* Message 内に absolute（beginner.css）。前後は Message の中で文字の上 */
    msgEl.appendChild(cv);
    new ResizeObserver(fit).observe(hfDom);
  } else {
    hero.appendChild(cv);
  }
  new ResizeObserver(fit).observe(hero);
  SP_MQ.addEventListener('change', fit);
  img.addEventListener('load', fit);
  fit();
  sync();
  /* ロゴ（ni-logo.js）は SVG 読み込み後に window.__niLogo を出すので、出てきたら背面に移す（最大 10 秒待つ） */
  (function waitLogo(n) {
    const L = window.__niLogo;
    if (L && L.renderer) { attachBehind(L); return; }
    if (n < 100) setTimeout(() => waitLogo(n + 1), 100);
  })(0);

  window.__fvHavefun = { frame, draw, fit, get hooked() { return hooked; }, get wipe() { return wipeNow(fv.p); } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
