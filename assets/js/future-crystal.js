/* ==========================================================================
   future-crystal.js — 業界の未来のページ頭の立体（正十二面体のガラス + 頂点の点と線。WebGL / three.js r178）

   デザイナーのデモ（デモ/NI_CRYSTAL.html = https://ni-future.pages.dev/ 、build 08-26 17:10 FIX2）の移植。
   Figma（PC 617:6900 / SP 1140:13580）はこのデモの画面収録を貼ったものなので、形・材質・動き・数値（P）はデモの「FIX」値そのまま。
   - 正十二面体 → MeshPhysicalMaterial の透過（transmission）。面と面取り（bevel。FIX 値は 0 = 無し）で材質を分ける。
     裏面（BackSide）のメッシュを先に描いて二重屈折に見せる（デモと同じ: 同じシーンに renderOrder -1 で入れるだけ）
   - 頂点に青い点（Points）とその光、頂点どうしを結ぶ白い線（距離 linkDist 以下）、線を伝う青いパルス、マウスが近い頂点が光る
   - デモは不透明な背景（白 + axion 動画 + 青ベール + 影）を板に描いて画面に出していたが、ここでは canvas を透明にして
     ページの固定背景（.page-bg）の上に重ねる。ガラスの屈折用にだけ同じ背景（動画 cover + 青ベール + 影）をシェーダの板に出す
     （ni-logo.js と同じ仕組み: 板は透過用の内部ターゲットにだけ描く = colorWrite の切り替え。動画は VideoTexture）。
     影はガラスの外にも見えるよう、見える側にも透明の板で描く（three の透過パスは透明な物を描かないので、板は 2 つ要る）
   - デモのドラッグ回転・調整パネル・診断は無し

   配置: canvas は静止画（.future-hero__obj img）と同じ枠（Figma の画面収録の枠 = PC 719×750 / SP 300×313）に CSS で置く（future.css）。
   収録はフル HD（1920×1080）の画面で動くデモの中央を 719×750 に切り抜いたもの（立体の大きさから逆算。デモを 719×750 の窓で
   動かすと立体が 6 割の大きさになる）なので、カメラ（fov 35、z 10）は 1920×1080 の画面として置き、その中央の 719×750 だけを
   canvas に描く（camera.setViewOffset = REC）。大きさの式（logoScale × min(1, aspect / 1.05)）・影の位置もデモのまま。
   静止画は <html> の is-future-crystal（inc/assets.php が <head> で付ける）で隠し、WebGL が動かない環境・動き抑制・?nowebgl・
   ?off=crystal では静止画のまま。ヒーローが画面の外にある間とタブ非表示では描画を止める。
   SP（〜767px）は ni-logo.js と同じ軽量設定（canvas 1 倍、屈折の背後描画 1/2、描画は 2 フレームに 1 回）。
   ========================================================================== */
import * as THREE from 'three';

/* ---------- パラメータ（デモの ★ FIX 値そのまま。使っていない項目は省いた） ---------- */
const P = {
  /* 形（正十二面体）: bevel = 面取りの幅（0 = 無し） */
  bevel: 0,
  /* ガラス */
  ior: 1.69, transGain: 0.37, dispersion: 2, transmission: 1,
  baseTint: '#ffffff', edgeTrans: 1, edgeTint: '#ffffff',
  thickness: 4.11, attColor: '#ffffff', attDist: 13.5,
  clearcoat: 0, ccRough: 0.06, flat: false,
  faceRough: 0, edgeRough: 0.045, faceEnv: 1.06, edgeEnv: 5.16, faceSpec: 0.03, edgeSpec: 0.5, edgeFlat: true,
  /* 二重屈折（裏面） */
  backOn: true, backThickness: 0.52, backEnvMul: 0.3,
  /* ゆらぎ（液体感） */
  distortion: 0.38, distortScale: 0.96, distortSpeed: 0.43,
  /* 光（環境マップ） */
  whiteStr: 81, blueStr: 14.4, frontFill: 1.2, envBgColor: '#8da3e2', envBlur: 0.47, envRot: 29,
  stripColor1: '#ffffff', stripColor2: '#eef4ff',
  /* 画面 */
  exposure: 0.83,
  /* 動き（ゆれ）: Y は tilt を中心に ±tiltAmp、X は ±tiltAmp×tiltOrbit、周期 tiltPeriod 秒 */
  tiltAuto: true, tilt: -2.5, tiltAmp: 41, tiltPeriod: 17.9, tiltOrbit: 0.63,
  /* 頂点の点と光 */
  dotsOn: true, dotSize: 0.125, dotColor: '#006ce0', dotSoft: 0, glowOn: true, glowSize: 4, hoverRadius: 2.9,
  /* 頂点を結ぶ線とパルス */
  linkOn: true, linkDist: 1.4, linkColor: '#ffffff', linkOpacity: 0.8, linkGrow: 1.6,
  pulseOn: true, pulseSpeed: 1.03, pulseInterval: 0.6, pulseSize: 0.24, pulseColor: '#002aff',
  /* 影（背景板に描く楕円のグラデ。位置・大きさは板の高さ比） */
  shadowOn: true, shadowColor: '#cedef8', shadowStr: 0.205, shadowSize: 1.1, shadowFlat: 0.86, shadowX: 0.145, shadowY: 0.205, shadowBlur: 0.8,
  /* 大きさ・速さ */
  logoScale: 1.43, speed: 1,
  /* 背景の合成（固定背景と同値: base.css の .page-bg） */
  vidMax: 0.63, blueVeil: 0.1,
  /* 描画 */
  maxPixelRatio: 2
};

const deg = THREE.MathUtils.degToRad;
const FOV = 35;
const CAM_Z = 10;              /* カメラ位置 */
const PLATE_Z = -6;            /* 背景板の位置 */
const GEO_H = 2.4;             /* ジオメトリの高さ（ワールド単位）。デモと同じ */
const VIEW_H = 2 * Math.tan(deg(FOV / 2)) * CAM_Z;   /* z=0 で見える高さ（ワールド単位） */
const BG_W = 1280, BG_H = 720; /* デモの背景板の px（影の位置・大きさはこの中の px で決まり、板ごと画面の縦横比に引き伸ばされる） */
/* 収録: デモの画面（w×h）の中央から切り抜いた枠（cw×ch）。canvas にはこの枠の中だけを描く（CSS の aspect-ratio も cw / ch） */
const REC = { w: 1920, h: 1080, cw: 719, ch: 750 };
const DOT_K = REC.h / REC.ch;  /* 点の大きさ（Points の size）は canvas の高さ基準なので、画面の高さ基準の収録に合わせる倍率 */

/* ---------- 透過シェーダのパッチ（デモ・ni-logo.js と同じ） ---------- */
const NOISE_GLSL = `
vec3 dg_mod289(vec3 x){ return x - floor(x * (1.0/289.0)) * 289.0; }
vec4 dg_mod289(vec4 x){ return x - floor(x * (1.0/289.0)) * 289.0; }
vec4 dg_permute(vec4 x){ return dg_mod289(((x*34.0)+1.0)*x); }
vec4 dg_taylorInvSqrt(vec4 r){ return 1.79284291400159 - 0.85373472095314 * r; }
float dg_snoise(vec3 v){
  const vec2 C = vec2(1.0/6.0, 1.0/3.0);
  const vec4 D = vec4(0.0, 0.5, 1.0, 2.0);
  vec3 i = floor(v + dot(v, C.yyy));
  vec3 x0 = v - i + dot(i, C.xxx);
  vec3 g = step(x0.yzx, x0.xyz);
  vec3 l = 1.0 - g;
  vec3 i1 = min(g.xyz, l.zxy);
  vec3 i2 = max(g.xyz, l.zxy);
  vec3 x1 = x0 - i1 + C.xxx;
  vec3 x2 = x0 - i2 + C.yyy;
  vec3 x3 = x0 - D.yyy;
  i = dg_mod289(i);
  vec4 p = dg_permute(dg_permute(dg_permute(i.z + vec4(0.0, i1.z, i2.z, 1.0)) + i.y + vec4(0.0, i1.y, i2.y, 1.0)) + i.x + vec4(0.0, i1.x, i2.x, 1.0));
  float n_ = 0.142857142857;
  vec3 ns = n_ * D.wyz - D.xzx;
  vec4 j = p - 49.0 * floor(p * ns.z * ns.z);
  vec4 x_ = floor(j * ns.z);
  vec4 y_ = floor(j - 7.0 * x_);
  vec4 x = x_ * ns.x + ns.yyyy;
  vec4 y = y_ * ns.x + ns.yyyy;
  vec4 h = 1.0 - abs(x) - abs(y);
  vec4 b0 = vec4(x.xy, y.xy);
  vec4 b1 = vec4(x.zw, y.zw);
  vec4 s0 = floor(b0)*2.0 + 1.0;
  vec4 s1 = floor(b1)*2.0 + 1.0;
  vec4 sh = -step(h, vec4(0.0));
  vec4 a0 = b0.xzyw + s0.xzyw*sh.xxyy;
  vec4 a1 = b1.xzyw + s1.xzyw*sh.zzww;
  vec3 p0 = vec3(a0.xy, h.x);
  vec3 p1 = vec3(a0.zw, h.y);
  vec3 p2 = vec3(a1.xy, h.z);
  vec3 p3 = vec3(a1.zw, h.w);
  vec4 norm = dg_taylorInvSqrt(vec4(dot(p0,p0), dot(p1,p1), dot(p2,p2), dot(p3,p3)));
  p0 *= norm.x; p1 *= norm.y; p2 *= norm.z; p3 *= norm.w;
  vec4 m = max(0.6 - vec4(dot(x0,x0), dot(x1,x1), dot(x2,x2), dot(x3,x3)), 0.0);
  m = m * m;
  return 42.0 * dot(m*m, vec4(dot(p0,x0), dot(p1,x1), dot(p2,x2), dot(p3,x3)));
}`;

/* three の transmission_fragment に「法線のゆらぎ」と「ACES 逆変換」（表示後の透過光 = 実背景 に一致させる）を差し込む。
   デモは 4 つの材質とも両方入れている */
function buildTransmissionChunk() {
  const src = THREE.ShaderChunk.transmission_fragment;
  const normalLine = src.includes('transformNormalByInverseViewMatrix')
    ? 'vec3 n = transformNormalByInverseViewMatrix( normal, viewMatrix );'
    : 'vec3 n = inverseTransformDirection( normal, viewMatrix );';
  const alphaLine = 'material.transmissionAlpha = mix( material.transmissionAlpha, transmitted.a, material.transmission';
  if (!src.includes(normalLine) || !src.includes(alphaLine)) {
    console.warn('[future-crystal] three.js の transmission_fragment が想定と違います（バージョン差）。パッチなしで続行します');
    return src;
  }
  return src.replace(normalLine, normalLine + `
  if (uDistort > 0.0) {
    vec3 dgp = vDgP * uDistortScale + vec3(0.0, 0.0, uDgTime);
    vec3 dgn = vec3(dg_snoise(dgp), dg_snoise(dgp + 17.1), dg_snoise(dgp + 31.7));
    n = normalize(n + dgn * uDistort * 0.6);
  }`).replace(alphaLine, `{
    const mat3 ACESInInv = mat3(vec3(1.764741, -0.147028, -0.036337), vec3(-0.675778, 1.160252, -0.162436), vec3(-0.088963, -0.013224, 1.198773));
    const mat3 ACESOutInv = mat3(vec3(0.643038, 0.059269, 0.005962), vec3(0.311187, 0.931436, 0.063929), vec3(0.045775, 0.009295, 0.930118));
    vec3 y = clamp( transmitted.rgb, vec3(0.0), vec3(0.9995) );
    vec3 w = clamp( ACESOutInv * y, vec3(0.0), vec3(0.9995) );
    vec3 qa = 1.0 - 0.983729 * w;
    vec3 qb = 0.0245786 - 0.4329510 * w;
    vec3 qc = -0.000090537 - 0.238081 * w;
    vec3 t2 = ( -qb + sqrt( max( qb * qb - 4.0 * qa * qc, vec3(0.0) ) ) ) / ( 2.0 * qa );
    transmitted.rgb = max( ACESInInv * t2, vec3(0.0) ) * uTransGain / uExposureComp;
  }
  ` + alphaLine);
}

function init() {
  const box = document.querySelector('.future-hero__obj');
  const still = box ? box.querySelector('img') : null;
  const keepStill = () => document.documentElement.classList.remove('is-future-crystal');   /* 動かせないときは静止画を見せる */
  if (!box || !still) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bcrystal\b/.test(window.location.search)) { keepStill(); return; }
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { keepStill(); return; }

  const canvas = document.createElement('canvas');
  canvas.className = 'future-hero__canvas';
  canvas.setAttribute('aria-hidden', 'true');

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  } catch (e) {
    keepStill();
    return;
  }
  const mqPc = window.matchMedia('(min-width: 768px)');
  const spLite = !mqPc.matches;   /* 判定は読み込み時のみ（またげば common.js が再読み込み） */
  renderer.setClearColor(0x000000, 0);
  renderer.setPixelRatio(spLite ? 1 : Math.min(P.maxPixelRatio, window.devicePixelRatio || 1));
  if (spLite) renderer.transmissionResolutionScale = 0.5;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = P.exposure;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(FOV, 1, 0.1, 100);
  camera.position.set(0, 0, CAM_Z);

  /* ---------- 背景板（屈折用。白 → 固定背景の動画 cover → 青ベール → 影。base.css の .page-bg と同じ見た目） ----------
     canvas は viewport の一部なので、固定背景のうち canvas の裏にある範囲（uRect）だけを板に出す */
  const video = document.querySelector('.page-bg__video');
  const poster = new Image();
  if (video && video.poster) poster.src = video.poster;
  const videoTex = video ? new THREE.VideoTexture(video) : null;
  if (videoTex) { videoTex.colorSpace = THREE.NoColorSpace; videoTex.minFilter = THREE.LinearFilter; videoTex.magFilter = THREE.LinearFilter; videoTex.generateMipmaps = false; }
  const posterTex = new THREE.Texture(poster);
  posterTex.colorSpace = THREE.NoColorSpace; posterTex.minFilter = THREE.LinearFilter; posterTex.generateMipmaps = false;
  poster.addEventListener('load', () => { posterTex.needsUpdate = true; });
  if (poster.complete && poster.naturalWidth) posterTex.needsUpdate = true;
  const whiteTex = new THREE.DataTexture(new Uint8Array([255, 255, 255, 255]), 1, 1);
  whiteTex.needsUpdate = true;

  const bgMat = new THREE.ShaderMaterial({
    uniforms: {
      uVideo: { value: whiteTex }, uHasVideo: { value: 0 }, uVidAlpha: { value: P.vidMax },
      uVeil: { value: P.blueVeil }, uVeilA: { value: new THREE.Color() }, uVeilB: { value: new THREE.Color() },
      uView: { value: new THREE.Vector2(1, 1) },      /* viewport の幅・高さ (px) */
      uRect: { value: new THREE.Vector4(0, 0, 1, 1) },   /* canvas の viewport 上の位置と大きさ (px) */
      uCrop: { value: new THREE.Vector4((REC.w - REC.cw) / 2 / REC.w, (REC.h - REC.ch) / 2 / REC.h, REC.cw / REC.w, REC.ch / REC.h) },   /* 画面の中の収録の枠（0〜1） */
      uVidRect: { value: new THREE.Vector4(0, 0, 1, 1) },   /* cover した動画の viewport 上の位置と大きさ (px) */
      uShadow: { value: new THREE.Vector4(0, 0, 1, 1) },   /* 影の中心と半径（板 1280×720 の px。w は縦の半径） */
      uShadowStr: { value: 0 }, uShadowU: { value: 0 }, uShadowCol: { value: new THREE.Color() }
    },
    vertexShader: 'varying vec2 vUv; void main(){ vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }',
    fragmentShader: `
      precision highp float;
      varying vec2 vUv;
      uniform sampler2D uVideo; uniform float uHasVideo; uniform float uVidAlpha;
      uniform float uVeil; uniform vec3 uVeilA; uniform vec3 uVeilB;
      uniform vec2 uView; uniform vec4 uRect; uniform vec4 uCrop; uniform vec4 uVidRect;
      uniform vec4 uShadow; uniform float uShadowStr; uniform float uShadowU; uniform vec3 uShadowCol;
      vec3 toLin(vec3 c){ return mix(c / 12.92, pow((c + 0.055) / 1.055, vec3(2.4)), step(0.04045, c)); }
      void main(){
        /* 板はデモの画面（1920×1080）の視野より 1.02 倍大きい → 画面の中の位置（0〜1、y は下向き）に直す */
        vec2 s = (vUv - 0.5) * 1.02 + 0.5;
        vec2 sd = vec2(s.x, 1.0 - s.y);
        /* 画面の中の収録の枠 = canvas の中の位置（0〜1）→ viewport 上の px（固定背景は viewport に cover なので、canvas の位置ぶんずらして同じ絵にする） */
        vec2 px = uRect.xy + (sd - uCrop.xy) / uCrop.zw * uRect.zw;
        vec3 col = vec3(1.0);
        vec2 vuv = (px - uVidRect.xy) / uVidRect.zw;
        vec3 vc = texture2D(uVideo, vec2(vuv.x, 1.0 - vuv.y)).rgb;
        col = mix(col, vc, uVidAlpha * uHasVideo);
        /* 青ベール: viewport 全体に 254deg の線形グラデ（.page-bg::after と同じ） */
        float a = radians(254.0); float sx = sin(a), sy = -cos(a);
        float half_ = (abs(sx) * uView.x + abs(sy) * uView.y) * 0.5;
        float t = clamp((dot(px - uView * 0.5, vec2(sx, sy)) + half_) / (2.0 * half_), 0.0, 1.0);
        col = mix(col, mix(uVeilA, uVeilB, t), uVeil);
        /* 影（デモの bl() と同じ楕円のグラデ: 内側 uShadowU までは濃さそのまま、0.6 で 45%、外周で 0） */
        vec2 sp = sd * vec2(${BG_W}.0, ${BG_H}.0);
        float d = length((sp - uShadow.xy) / uShadow.zw);
        float k = clamp((d - uShadowU) / (1.0 - uShadowU), 0.0, 1.0);
        float sa = k <= 0.6 ? mix(uShadowStr, uShadowStr * 0.45, k / 0.6) : mix(uShadowStr * 0.45, 0.0, (k - 0.6) / 0.4);
        col = mix(col, uShadowCol, sa);
        /* 合成は sRGB のまま行い、最後に線形へ（デモの sRGB テクスチャの復号と同じ） */
        gl_FragColor = vec4(toLin(col), 1.0);
      }`,
    depthWrite: true, depthTest: true
  });
  /* 色は sRGB の値のまま使う（Color は線形に変換して持つので、生の値を入れ直す） */
  bgMat.uniforms.uVeilA.value.setRGB(0xDC / 255, 0xE2 / 255, 0xFD / 255, THREE.NoColorSpace);
  bgMat.uniforms.uVeilB.value.setRGB(0xA9 / 255, 0xCD / 255, 0xF8 / 255, THREE.NoColorSpace);
  bgMat.uniforms.uShadowCol.value.setStyle(P.shadowColor, THREE.NoColorSpace);
  const bgPlate = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), bgMat);
  bgPlate.position.z = PLATE_Z;
  bgPlate.frustumCulled = false;
  scene.add(bgPlate);
  /* 背景板は画面には描かない。透過用の内部ターゲットにだけ描く */
  bgPlate.onBeforeRender = () => { bgMat.colorWrite = renderer.getRenderTarget() !== null; };

  /* 見える側の影（ガラスの外に落ちる影。透明な板に 2D canvas の楕円グラデ = デモの bl()） */
  const shadowCanvas = document.createElement('canvas');
  shadowCanvas.width = BG_W;
  shadowCanvas.height = BG_H;
  const shadowTex = new THREE.CanvasTexture(shadowCanvas);
  shadowTex.colorSpace = THREE.SRGBColorSpace;
  const shadowPlate = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), new THREE.MeshBasicMaterial({ map: shadowTex, transparent: true, depthWrite: false, toneMapped: false }));
  shadowPlate.position.z = PLATE_Z;
  shadowPlate.frustumCulled = false;
  shadowPlate.visible = P.shadowOn && P.shadowStr > 0;
  scene.add(shadowPlate);

  /* ---------- 環境光（白と青の板を並べたシーン → PMREM。ni-logo.js と同じ配置、数値はデモの立体用） ---------- */
  const pmrem = new THREE.PMREMGenerator(renderer);
  let envRT = null;
  function buildEnv() {
    const s = new THREE.Scene();
    s.background = new THREE.Color(P.envBgColor);
    const w = P.whiteStr, b = P.blueStr;
    const c1 = new THREE.Color(P.stripColor1), c2 = new THREE.Color(P.stripColor2);
    const add = (pw, ph, rgb, x, y, z, ry = 0, rx = 0) => {
      const m = new THREE.Mesh(
        new THREE.PlaneGeometry(pw, ph),
        new THREE.MeshBasicMaterial({ color: new THREE.Color(rgb[0], rgb[1], rgb[2]), side: THREE.DoubleSide })
      );
      m.position.set(x, y, z);
      m.rotation.set(rx, ry, 0);
      s.add(m);
    };
    add(0.5, 8, [w * c1.r, w * c1.g, w * c1.b], -5, 0, 2, Math.PI / 5);
    add(0.35, 8, [w * 1.15 * c2.r, w * 1.15 * c2.g, w * 1.15 * c2.b], 4.5, 1, 2.5, -Math.PI / 4.5);
    add(9, 3, [w * 0.35 * c1.r, w * 0.35 * c1.g, w * 0.35 * c1.b], 0, 7, 1, 0, -Math.PI / 2.6);
    add(7, 7, [P.frontFill, P.frontFill, P.frontFill], 0, 0.5, 8, Math.PI, 0);
    add(6, 9, [0.3 * b, 0.55 * b, 1 * b], -7, -1, -2, Math.PI / 2.4);
    add(6, 9, [0.26 * b, 0.5 * b, 1 * b], 7, -1, -3, -Math.PI / 2.4);
    add(10, 5, [0.2 * b, 0.42 * b, 1 * b], 0, -7, 0, 0, Math.PI / 2.6);
    add(8, 6, [0.35 * b, 0.6 * b, 1 * b], 0, 2, -9, 0, 0);

    const rotated = new THREE.Scene();
    rotated.background = s.background;
    const g = new THREE.Group();
    while (s.children.length) g.add(s.children[0]);
    g.rotation.y = deg(P.envRot);
    rotated.add(g);

    const rt = pmrem.fromScene(rotated, P.envBlur);
    if (envRT) envRT.dispose();
    envRT = rt;
    scene.environment = rt.texture;
  }
  buildEnv();

  /* ---------- 材質 ---------- */
  const uExposure = { value: P.exposure };
  const uTransGain = { value: P.transGain };
  const uDistort = { value: P.distortion };
  const uDistortScale = { value: P.distortScale };
  const uDgTime = { value: 0 };
  const chunk = buildTransmissionChunk();

  const faceMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1 });
  const edgeMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1 });
  const backFaceMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1, side: THREE.BackSide });
  const backEdgeMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1, side: THREE.BackSide });

  for (const mat of [faceMat, edgeMat, backFaceMat, backEdgeMat]) {
    mat.onBeforeCompile = (sh) => {
      sh.uniforms.uExposureComp = uExposure;
      sh.uniforms.uTransGain = uTransGain;
      sh.uniforms.uDistort = uDistort;
      sh.uniforms.uDistortScale = uDistortScale;
      sh.uniforms.uDgTime = uDgTime;
      sh.vertexShader = sh.vertexShader
        .replace('#include <common>', '#include <common>\nvarying vec3 vDgP;')
        .replace('#include <begin_vertex>', '#include <begin_vertex>\nvDgP = position;');
      sh.fragmentShader = sh.fragmentShader
        .replace('#include <common>', '#include <common>\nvarying vec3 vDgP;\nuniform float uExposureComp;\nuniform float uTransGain;\nuniform float uDistort;\nuniform float uDistortScale;\nuniform float uDgTime;\n' + NOISE_GLSL)
        .replace('#include <transmission_fragment>', chunk);
    };
  }

  function applyMaterials() {
    for (const m of [faceMat, edgeMat, backFaceMat, backEdgeMat]) {
      m.ior = P.ior;
      m.dispersion = P.dispersion;
      m.thickness = P.thickness;
      m.attenuationColor.set(P.attColor);
      m.attenuationDistance = P.attDist;
      m.clearcoatRoughness = P.ccRough;
    }
    faceMat.flatShading = backFaceMat.flatShading = P.flat;
    edgeMat.flatShading = backEdgeMat.flatShading = P.flat || P.edgeFlat;
    for (const m of [faceMat, backFaceMat]) {
      m.transmission = P.transmission;
      m.color.set(P.baseTint);
      m.roughness = P.faceRough;
      m.specularIntensity = P.faceSpec;
      m.clearcoat = 0;
    }
    for (const m of [edgeMat, backEdgeMat]) {
      m.transmission = P.edgeTrans;
      m.color.set(P.edgeTint);
      m.roughness = P.edgeRough;
      m.specularIntensity = P.edgeSpec;
      m.clearcoat = P.clearcoat;
    }
    faceMat.envMapIntensity = P.faceEnv;
    edgeMat.envMapIntensity = P.edgeEnv;
    backFaceMat.envMapIntensity = P.faceEnv * P.backEnvMul;
    backEdgeMat.envMapIntensity = P.edgeEnv * P.backEnvMul;
    backFaceMat.thickness = backEdgeMat.thickness = P.backThickness;
    uTransGain.value = P.transGain;
    uDistort.value = P.distortion;
    uDistortScale.value = P.distortScale;
  }
  applyMaterials();

  /* ---------- 形（正十二面体。デモと同じ: 三角形の集まりを法線で面ごとにまとめ、面取りぶん内側に寄せた多角形を張り直す） ----------
     グループ 0 = 面（faceMat）、グループ 1 = 面取り（edgeMat。bevel が 0 なら空） */
  const key = (v) => [v.x, v.y, v.z].map((x) => Math.round(x * 1e3) / 1e3).join(',');
  function buildGeometry() {
    const src = new THREE.DodecahedronGeometry(1, 0).toNonIndexed().getAttribute('position');
    const faces = [];
    const byNormal = new Map();
    const a = new THREE.Vector3(), b = new THREE.Vector3(), c = new THREE.Vector3();
    const ab = new THREE.Vector3(), ac = new THREE.Vector3(), n = new THREE.Vector3();
    for (let i = 0; i < src.count; i += 3) {
      a.fromBufferAttribute(src, i);
      b.fromBufferAttribute(src, i + 1);
      c.fromBufferAttribute(src, i + 2);
      n.crossVectors(ab.subVectors(b, a), ac.subVectors(c, a)).normalize();
      const k = key(n);
      if (!byNormal.has(k)) { byNormal.set(k, { n: n.clone(), pts: [] }); faces.push(byNormal.get(k)); }
      const f = byNormal.get(k);
      for (const v of [a, b, c]) if (!f.pts.some((p) => p.distanceToSquared(v) < 1e-6)) f.pts.push(v.clone());
    }
    for (const f of faces) {
      f.c = new THREE.Vector3();
      f.pts.forEach((p) => f.c.add(p));
      f.c.multiplyScalar(1 / f.pts.length);
      const ux = new THREE.Vector3().subVectors(f.pts[0], f.c).normalize();
      const uy = new THREE.Vector3().crossVectors(f.n, ux).normalize();
      const ang = (p) => { const d = p.clone().sub(f.c); return Math.atan2(uy.dot(d), ux.dot(d)); };
      f.pts.sort((p, q) => ang(p) - ang(q));
      f.inset = f.pts.map((p) => p.clone().sub(f.c).multiplyScalar(1 - P.bevel).add(f.c));
    }
    const faceTris = [], edgeTris = [];
    const tri = (arr, p, q, r) => arr.push(p.x, p.y, p.z, q.x, q.y, q.z, r.x, r.y, r.z);
    for (const f of faces) for (let i = 1; i < f.inset.length - 1; i++) tri(faceTris, f.inset[0], f.inset[i], f.inset[i + 1]);
    if (P.bevel > 0) {
      /* 辺: 隣り合う 2 面の内側の辺を結ぶ帯 */
      const edges = new Map();
      faces.forEach((f, fi) => {
        const m = f.pts.length;
        for (let i = 0; i < m; i++) {
          const p1 = f.pts[i], p2 = f.pts[(i + 1) % m];
          const k = [key(p1), key(p2)].sort().join('|');
          const e = edges.get(k) || { sides: [] };
          e.sides.push({ fi, i1: i, i2: (i + 1) % m, p1, p2 });
          edges.set(k, e);
        }
      });
      const nearest = (f, p) => f.inset[f.pts.reduce((best, q, i) => (q.distanceToSquared(p) < f.pts[best].distanceToSquared(p) ? i : best), 0)];
      for (const e of edges.values()) {
        if (e.sides.length !== 2) continue;
        const [s1, s2] = e.sides;
        const f1 = faces[s1.fi], f2 = faces[s2.fi];
        const a1 = f1.inset[s1.i1], b1 = f1.inset[s1.i2], a2 = nearest(f2, s1.p1), b2 = nearest(f2, s1.p2);
        tri(edgeTris, a1, b1, b2);
        tri(edgeTris, a1, b2, a2);
      }
      /* 角: 3 面が集まる頂点を埋める三角形 */
      const corners = new Map();
      faces.forEach((f) => f.pts.forEach((p, i) => { const k = key(p); const l = corners.get(k) || []; l.push(f.inset[i]); corners.set(k, l); }));
      for (const l of corners.values()) if (l.length === 3) tri(edgeTris, l[0], l[1], l[2]);
    }
    const pos = new Float32Array(faceTris.length + edgeTris.length);
    pos.set(faceTris, 0);
    pos.set(edgeTris, faceTris.length);
    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.addGroup(0, faceTris.length / 3, 0);
    geo.addGroup(faceTris.length / 3, edgeTris.length / 3, 1);
    /* 中心を原点に、高さを GEO_H に */
    geo.computeBoundingBox();
    const bb = geo.boundingBox, size = new THREE.Vector3();
    bb.getSize(size);
    geo.translate(-(bb.min.x + bb.max.x) / 2, -(bb.min.y + bb.max.y) / 2, -(bb.min.z + bb.max.z) / 2);
    const k = GEO_H / size.y;
    geo.scale(k, k, k);
    geo.computeVertexNormals();
    return geo;
  }

  const group = new THREE.Group();
  scene.add(group);
  const geo = buildGeometry();
  const backMesh = new THREE.Mesh(geo, [backFaceMat, backEdgeMat]);
  backMesh.frustumCulled = false;
  backMesh.renderOrder = -1;
  backMesh.visible = P.backOn;
  group.add(backMesh);
  const frontMesh = new THREE.Mesh(geo, [faceMat, edgeMat]);
  frontMesh.frustumCulled = false;
  group.add(frontMesh);

  /* ---------- 頂点の点・光・線・パルス（デモと同じ） ---------- */
  function dotTexture(soft) {
    const cv = document.createElement('canvas');
    cv.width = cv.height = 256;
    const ctx = cv.getContext('2d');
    const s = Math.max(0, Math.min(1, soft));
    const r = 1 - 0.02 - s * 0.55;
    const g = ctx.createRadialGradient(128, 128, 0, 128, 128, 128);
    g.addColorStop(0, 'rgba(255,255,255,1)');
    g.addColorStop(Math.max(0.001, r), 'rgba(255,255,255,1)');
    if (s > 0.01) g.addColorStop(Math.min(0.999, r + s * 0.3), 'rgba(255,255,255,.55)');
    g.addColorStop(1, 'rgba(255,255,255,0)');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, 256, 256);
    const tex = new THREE.CanvasTexture(cv);
    tex.colorSpace = THREE.SRGBColorSpace;
    tex.minFilter = THREE.LinearMipmapLinearFilter;
    tex.magFilter = THREE.LinearFilter;
    tex.anisotropy = 4;
    tex.generateMipmaps = true;
    tex.needsUpdate = true;
    return tex;
  }
  function glowTexture() {
    const cv = document.createElement('canvas');
    cv.width = cv.height = 64;
    const ctx = cv.getContext('2d');
    const g = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
    g.addColorStop(0, 'rgba(255,255,255,.55)');
    g.addColorStop(0.35, 'rgba(255,255,255,.28)');
    g.addColorStop(1, 'rgba(255,255,255,0)');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, 64, 64);
    const tex = new THREE.CanvasTexture(cv);
    tex.colorSpace = THREE.SRGBColorSpace;
    return tex;
  }
  function makePoints(count, tex, size, solid) {
    const g = new THREE.BufferGeometry();
    g.setAttribute('position', new THREE.BufferAttribute(new Float32Array(count * 3), 3));
    g.setAttribute('color', new THREE.BufferAttribute(new Float32Array(count * 3), 3));
    const pts = new THREE.Points(g, new THREE.PointsMaterial({
      map: tex, size, sizeAttenuation: true, vertexColors: true, transparent: true, alphaTest: 0,
      opacity: solid ? 1 : 0.55, depthWrite: false, depthTest: false, toneMapped: false
    }));
    pts.renderOrder = solid ? 12 : 11;
    pts.frustumCulled = false;
    return pts;
  }
  /* 頂点の一覧（近い点はまとめる） */
  function uniqueVertices(g) {
    const pos = g.getAttribute('position');
    g.computeBoundingBox();
    const size = new THREE.Vector3();
    g.boundingBox.getSize(size);
    const eps = size.length() * 0.06, eps2 = eps * eps;
    const out = [], v = new THREE.Vector3();
    for (let i = 0; i < pos.count; i++) {
      v.fromBufferAttribute(pos, i);
      if (!out.some((p) => p.distanceToSquared(v) < eps2)) out.push(v.clone());
    }
    return out;
  }

  const net = { group: new THREE.Group(), pos: [], node: [], age: new Map(), pool: [], spawnT: 0, points: null, glow: null, lines: null, pulses: null };
  {
    net.pos = uniqueVertices(geo);
    net.node = net.pos.map(() => ({ glow: 0 }));
    const n = net.pos.length;
    net.group.visible = P.dotsOn && n > 0;
    if (n) {
      const dotTex = dotTexture(P.dotSoft);
      net.points = makePoints(n, dotTex, P.dotSize * DOT_K, true);
      net.glow = makePoints(n, glowTexture(), P.dotSize * P.glowSize * DOT_K, false);
      net.glow.visible = P.glowOn;
      net.group.add(net.glow);
      net.group.add(net.points);
      const pairs = (n * (n - 1)) / 2;
      const lg = new THREE.BufferGeometry();
      lg.setAttribute('position', new THREE.BufferAttribute(new Float32Array(pairs * 6), 3));
      lg.setAttribute('color', new THREE.BufferAttribute(new Float32Array(pairs * 6), 3));
      net.lines = new THREE.LineSegments(lg, new THREE.LineBasicMaterial({ vertexColors: true, transparent: true, depthWrite: false, depthTest: false, toneMapped: false }));
      net.lines.renderOrder = 10;
      net.lines.frustumCulled = false;
      net.group.add(net.lines);
      const poolSize = 10;
      net.pool = Array.from({ length: poolSize }, () => ({ on: false, i: 0, j: 0, p: 0 }));
      net.pulses = makePoints(poolSize, dotTex, P.pulseSize * DOT_K, true);
      net.group.add(net.pulses);
    }
    group.add(net.group);
  }

  /* マウスの位置（canvas 内の -1〜1）。近い頂点が光る */
  const ptr = { x: 0, y: 0, has: false };
  window.addEventListener('pointermove', (e) => {
    const r = canvas.getBoundingClientRect();
    if (!r.width || !r.height) return;
    ptr.x = ((e.clientX - r.left) / r.width) * 2 - 1;
    ptr.y = -((e.clientY - r.top) / r.height) * 2 + 1;
    ptr.has = true;
  }, { passive: true });

  const colA = new THREE.Color(), colB = new THREE.Color(), probe = new THREE.Vector3();
  function updateNet(t, dt) {
    if (!net.group.visible || !net.points) return;
    const n = net.pos.length;
    const pPos = net.points.geometry.getAttribute('position');
    const gPos = net.glow.geometry.getAttribute('position');
    for (let i = 0; i < n; i++) {
      const v = net.pos[i];
      pPos.setXYZ(i, v.x, v.y, v.z);
      gPos.setXYZ(i, v.x, v.y, v.z);
    }
    if (ptr.has) {
      probe.set(ptr.x, ptr.y, 0.5).unproject(camera);
      net.group.worldToLocal(probe);
      for (let i = 0; i < n; i++) {
        const d = net.pos[i].distanceTo(probe);
        if (d < P.hoverRadius) net.node[i].glow = Math.max(net.node[i].glow, 1 - d / P.hoverRadius);
      }
    }
    net.lines.visible = P.linkOn;
    net.pulses.visible = P.linkOn && P.pulseOn;
    const pCol = net.points.geometry.getAttribute('color');
    const gCol = net.glow.geometry.getAttribute('color');
    const paintDots = () => {
      const dotC = colA.set(P.dotColor);   /* colA は線の色にも使うので、ここで入れ直す */
      for (let i = 0; i < n; i++) {
        const nd = net.node[i];
        nd.glow = Math.max(0, nd.glow - dt * 0.9);
        const k = 0.78 + 0.22 * nd.glow;
        pCol.setXYZ(i, 1 + (dotC.r - 1) * k, 1 + (dotC.g - 1) * k, 1 + (dotC.b - 1) * k);
        const kg = nd.glow * 0.9;
        gCol.setXYZ(i, 1 + (dotC.r - 1) * kg, 1 + (dotC.g - 1) * kg, 1 + (dotC.b - 1) * kg);
      }
      pPos.needsUpdate = gPos.needsUpdate = pCol.needsUpdate = gCol.needsUpdate = true;
      net.points.material.size = P.dotSize * DOT_K;
      net.glow.material.size = P.dotSize * P.glowSize * DOT_K;
    };
    if (!P.linkOn) { paintDots(); return; }

    /* 線: 近い頂点どうしを結ぶ。つながるときは伸びていく（age） */
    const lPos = net.lines.geometry.getAttribute('position');
    const lCol = net.lines.geometry.getAttribute('color');
    const linkC = colA.set(P.linkColor);
    const linked = [];
    let count = 0;
    for (let i = 0; i < n; i++) {
      for (let j = i + 1; j < n; j++) {
        const id = i * 64 + j;
        const dist = net.pos[i].distanceTo(net.pos[j]);
        const want = dist < P.linkDist ? 1 : 0;
        let age = net.age.get(id) || 0;
        age += (want - age) * Math.min(1, dt * P.linkGrow * 2);
        if (age < 0.01) { net.age.delete(id); continue; }
        net.age.set(id, age);
        const near = 1 - Math.min(1, dist / P.linkDist);
        const alpha = age * (0.25 + near * 0.75) * P.linkOpacity;
        const a = net.pos[i], b = net.pos[j];
        const e = age * age * (3 - 2 * age);
        const r = 1 + (linkC.r - 1) * alpha, g = 1 + (linkC.g - 1) * alpha, bl = 1 + (linkC.b - 1) * alpha;
        const k = count * 2;
        lPos.setXYZ(k, a.x, a.y, a.z);
        lPos.setXYZ(k + 1, a.x + (b.x - a.x) * e, a.y + (b.y - a.y) * e, a.z + (b.z - a.z) * e);
        lCol.setXYZ(k, r, g, bl);
        lCol.setXYZ(k + 1, r, g, bl);
        count++;
        if (age > 0.85) linked.push([i, j]);
      }
    }
    net.lines.geometry.setDrawRange(0, count * 2);
    lPos.needsUpdate = lCol.needsUpdate = true;

    /* パルス: つながった線をランダムに選んで端から端へ。着いた頂点が光る */
    const uPos = net.pulses.geometry.getAttribute('position');
    const uCol = net.pulses.geometry.getAttribute('color');
    const pulseC = colB.set(P.pulseColor);
    if (P.pulseOn && linked.length) {
      net.spawnT += dt;
      if (net.spawnT >= P.pulseInterval) {
        net.spawnT = 0;
        const slot = net.pool.find((p) => !p.on);
        if (slot) {
          const pick = linked[Math.floor((t * 7.3) % linked.length)];
          slot.on = true;
          slot.p = 0;
          slot.i = pick[0];
          slot.j = pick[1];
          if (((t * 13) | 0) % 2) { const tmp = slot.i; slot.i = slot.j; slot.j = tmp; }
        }
      }
    }
    for (let k = 0; k < net.pool.length; k++) {
      const s = net.pool[k];
      if (!s.on) { uPos.setXYZ(k, 0, -9999, 0); uCol.setXYZ(k, 1, 1, 1); continue; }
      s.p += dt * P.pulseSpeed;
      if (s.p >= 1) {
        s.on = false;
        s.p = 0;
        net.node[s.j].glow = 1;
        uPos.setXYZ(k, 0, -9999, 0);
        uCol.setXYZ(k, 1, 1, 1);
        continue;
      }
      const a = net.pos[s.i], b = net.pos[s.j], x = s.p, w = Math.sin(Math.PI * x);
      uPos.setXYZ(k, a.x + (b.x - a.x) * x, a.y + (b.y - a.y) * x, a.z + (b.z - a.z) * x);
      uCol.setXYZ(k, 1 + (pulseC.r - 1) * w, 1 + (pulseC.g - 1) * w, 1 + (pulseC.b - 1) * w);
    }
    uPos.needsUpdate = uCol.needsUpdate = true;
    net.pulses.material.size = P.pulseSize * DOT_K;
    paintDots();
  }

  /* ---------- 影（デモの bl()。板 1280×720 の px で楕円のグラデ。見える側の板と、屈折用の板のシェーダの両方に同じ値） ---------- */
  let Ys = 1;   /* 横長でないときの縮小率（デモ: min(1, aspect / 1.05)） */
  function drawShadow() {
    const ctx = shadowCanvas.getContext('2d');
    ctx.clearRect(0, 0, BG_W, BG_H);
    const r = GEO_H * P.logoScale * Ys / VIEW_H / 1.02;   /* 立体の高さ（画面比） */
    const o = Math.max(4, BG_H * r * 0.5 * P.shadowSize);
    const cx = BG_W / 2 + BG_H * P.shadowX, cy = BG_H / 2 + BG_H * P.shadowY;
    const u = Math.max(0, Math.min(0.95, 1 - P.shadowBlur));
    const c = new THREE.Color(P.shadowColor);
    const rgb = ((c.r * 255) | 0) + ',' + ((c.g * 255) | 0) + ',' + ((c.b * 255) | 0);
    ctx.save();
    ctx.translate(cx, cy);
    ctx.scale(1, Math.max(0.05, P.shadowFlat));
    const g = ctx.createRadialGradient(0, 0, o * u, 0, 0, o);
    g.addColorStop(0, 'rgba(' + rgb + ',' + P.shadowStr + ')');
    g.addColorStop(0.6, 'rgba(' + rgb + ',' + (P.shadowStr * 0.45).toFixed(4) + ')');
    g.addColorStop(1, 'rgba(' + rgb + ',0)');
    ctx.fillStyle = g;
    ctx.fillRect(-o, -o, o * 2, o * 2);
    ctx.restore();
    shadowTex.needsUpdate = true;
    const u2 = bgMat.uniforms;
    u2.uShadow.value.set(cx, cy, o, o * Math.max(0.05, P.shadowFlat));
    u2.uShadowStr.value = P.shadowOn ? P.shadowStr : 0;
    u2.uShadowU.value = u;
  }

  /* ---------- 大きさ: canvas の CSS の大きさに合わせる。カメラはデモの画面（REC.w×h）として置き、収録の枠（中央の REC.cw×ch）だけを描く ---------- */
  let W = 1, H = 1;
  function resize() {
    W = Math.max(1, canvas.clientWidth);
    H = Math.max(1, canvas.clientHeight);
    renderer.setSize(W, H, false);
    camera.aspect = REC.w / REC.h;
    camera.setViewOffset(REC.w, REC.h, (REC.w - REC.cw) / 2, (REC.h - REC.ch) / 2, REC.cw, REC.ch);
    camera.updateProjectionMatrix();
    const ph = 2 * Math.tan(deg(FOV / 2)) * (camera.position.z - PLATE_Z);
    bgPlate.scale.set(ph * camera.aspect * 1.02, ph * 1.02, 1);
    shadowPlate.scale.copy(bgPlate.scale);
    Ys = Math.min(1, camera.aspect / 1.05);
    drawShadow();
  }

  /* 固定背景のうち canvas の裏にある範囲を板に出す（毎フレーム。スクロールで変わる） */
  function updateBg() {
    const u = bgMat.uniforms;
    const vw = Math.max(1, document.documentElement.clientWidth), vh = Math.max(1, window.innerHeight);
    const r = canvas.getBoundingClientRect();
    u.uView.value.set(vw, vh);
    u.uRect.value.set(r.left, r.top, r.width, r.height);
    let tex = null, sw = 0, sh = 0;
    if (videoTex && video.readyState >= 2 && video.videoWidth) { tex = videoTex; sw = video.videoWidth; sh = video.videoHeight; }
    else if (poster.complete && poster.naturalWidth) { tex = posterTex; sw = poster.naturalWidth; sh = poster.naturalHeight; }
    if (tex) {
      const s = Math.max(vw / sw, vh / sh);   /* object-fit: cover */
      u.uVidRect.value.set((vw - sw * s) / 2, (vh - sh * s) / 2, sw * s, sh * s);
      u.uVideo.value = tex;
      u.uHasVideo.value = 1;
    } else {
      u.uHasVideo.value = 0;
    }
  }

  /* ---------- 描画ループ ---------- */
  const clock = new THREE.Clock();
  let t = 0;
  let renderNo = 0;
  function frame() {
    const dt = Math.min(0.1, clock.getDelta()) * P.speed;
    t += dt;
    uDgTime.value = t * P.distortSpeed;
    /* ゆれ（デモと同じ式） */
    const ph = t * Math.PI * 2 / P.tiltPeriod;
    if (P.tiltAuto) {
      group.rotation.y = deg(P.tilt + Math.sin(ph) * P.tiltAmp);
      group.rotation.x = deg(Math.cos(ph) * P.tiltAmp * P.tiltOrbit);
    } else {
      group.rotation.y = deg(P.tilt);
      group.rotation.x = 0;
    }
    group.scale.setScalar(P.logoScale * Ys);
    updateNet(t, dt);
    if (spLite && (renderNo++ & 1)) return;   /* SP: 描画は 2 フレームに 1 回 */
    updateBg();
    renderer.render(scene, camera);
  }

  /* ヒーローが画面の外にある間と、タブ非表示のときは止める */
  let running = false, inView = true;
  function loop() {
    if (!running) return;
    requestAnimationFrame(loop);
    frame();
  }
  function sync() {
    const want = inView && !document.hidden;
    if (want && !running) {
      running = true;
      clock.getDelta();
      requestAnimationFrame(loop);
    } else if (!want) {
      running = false;
    }
  }
  document.addEventListener('visibilitychange', sync);
  if ('IntersectionObserver' in window) {
    new IntersectionObserver((entries) => { inView = entries[0].isIntersecting; sync(); }).observe(box);
  }

  canvas.addEventListener('webglcontextlost', (e) => {
    e.preventDefault();
    running = false;
    canvas.classList.add('is-off');
    keepStill();
  });

  box.appendChild(canvas);
  window.addEventListener('resize', resize);
  resize();
  sync();

  /* 開発用: コンソールから数値を触れるように（P を変えて applyMaterials() / buildEnv() / drawShadow() で反映） */
  window.__niCrystal = { P, applyMaterials, buildEnv, drawShadow, resize, frame, renderer, scene, camera, group, net, THREE, get running() { return running; } };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
