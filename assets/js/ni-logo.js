/* ==========================================================================
   ni-logo.js — ガラス製 NI ロゴ（WebGL / three.js r178）

   デザイナーのデモ（デモ/NI_TOP.html）の FV 実装を静的ページ用に移植したもの。位置・大きさ・動きはすべてデモ準拠。
   - ロゴ SVG → ExtrudeGeometry（面取り付き押し出し）→ MeshPhysicalMaterial の透過（transmission）
   - 背景（固定動画 + 青ベール）を 2D canvas に合成し、シーン内の「背景板」としてガラスに屈折させる。
     背景板は透過パスにだけ描き、画面には描かない（colorWrite を切り替える）ので canvas は透明のまま
   - 裏面を先に別ターゲットへ描き、それを表面の屈折対象にする「二重屈折」
   - 環境光は白と青の板を並べたシーンから PMREM で生成（デモと同じ配置・強度）
   - 透過光は ACES の逆変換をかけてから表示側の露出で割り、表示後の透過光が実背景と一致するようにする

   配置と動き（デモの choreo と同じ式）:
   - canvas は画面固定（position: fixed）。ロゴは FV 位置（fvX / fvY / fvH）から、スクロールに合わせて
     定位置（restX / restY / restH）へ移動しながら 1 回転し、定位置ではゆっくり回り続ける（PC）。
     SP は移動・縮小せず最初から Figma の位置・大きさ（P.spFixed、.hero__stage 比）。回転は同じ
   - スクロール量 → 進行度 p とイントロ（ロゴが下から入る）の時計は fv-scroll.js（デモの __fvP / __introK）
   - ロゴは画面に固定のまま（デモと同じ）。デモでは About セクションが固定 FV を覆うので、
     ここでは波の動画背景が見える範囲（.about の上端まで）で canvas を切り取り、外側は隠す

   数値（P）はデモの「NI ロゴ」FIX 値そのまま。
   動作しない環境（WebGL なし / prefers-reduced-motion / ?nowebgl）では何も描かない。

   定位置固定モード（.hero[data-fv-static]。中途トップ）: 配置は Figma 準拠・回転はデモ準拠。
   - ロゴは Hero（.hero__stage）座標の定位置（P.anchor。Figma の動画ノード ni-logo-only の配置から逆算した px）に置き、
     毎フレーム Hero の getBoundingClientRect で画面座標に直すので、canvas は画面固定のままロゴはページと一緒にスクロールする
   - スクロール連動の移動・回転・拡大縮小・イントロのせり上がりはなし
   - 回転はデモの「定位置に着いた後」と同じ式（デザイナー確認済み: 動画の元データは無く、デモの通りで OK）:
     縦軸（Y）まわりに一定速度 P.spinRate（0.18 rad/s ≒ 35 秒で 1 周、左端が手前に来る向き）で回り続け、
     傾き（tilt）は P.tiltAuto の揺れ（X: tilt ± tiltAmp、Z: ± tiltAmp*tiltOrbit、周期 tiltPeriod 秒）を重ねる
   ========================================================================== */
import * as THREE from 'three';
import { SVGLoader } from 'three/addons/loaders/SVGLoader.js';
import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
import { OutputPass } from 'three/addons/postprocessing/OutputPass.js';
import { fv } from './fv-scroll.js?v=202609181000';

/* ---------- パラメータ（デモ NI_TOP.html の F と同値） ---------- */
const P = {
  /* ガラス */
  ior: 1.87, transGain: 0.6, dispersion: 0.35, transmission: 1,
  baseTint: '#ffffff', edgeTrans: 1, edgeTint: '#ffffff',
  thickness: 0.25, attColor: '#ffffff', attDist: 3.07,
  clearcoat: 0, ccRough: 0.06, flat: false,
  faceRough: 0, edgeRough: 0.08, faceEnv: 0.03, edgeEnv: 5.04, faceSpec: 0.03, edgeSpec: 0.5, edgeFlat: true,
  /* 形（押し出し） */
  depth: 0.04, bevel: 0.005, bevelSegs: 4, curveSegs: 46,
  /* 二重屈折（裏面） */
  backOn: true, backThickness: 0.52, backEnvMul: 0.3,
  /* ゆらぎ（液体感） */
  distortion: 0.57, distortScale: 0.93, distortSpeed: 0.21,
  /* 光（環境マップ） */
  whiteStr: 12, blueStr: 17.4, frontFill: 0.15, envBlur: 0.09, envRot: 20,
  envBgColor: '#8d98e2', stripColor1: '#ffffff', stripColor2: '#eef4ff',
  /* 画面 */
  exposure: 0.95, bloomStrength: 1.11, bloomThreshold: 18.3, bloomRadius: 0.26,
  /* 背景の合成（固定背景と同値: base.css の .page-bg） */
  vidMax: 0.63, blueVeil: 0.1, bgPulse: 0.22, bgPulsePeriod: 35.5, logoPulse: 0.54,
  /* 動き（ゆれ） */
  tilt: -2.5, tiltAuto: true, tiltAmp: 41, tiltPeriod: 17.9, tiltOrbit: 0.63,
  /* 配置: FV 位置（画面幅・高さに対する比率）と定位置 */
  fvX: 0.305, fvY: -0.2, fvH: 0.93,
  restX: 0.225, restY: 0.13, restH: 0.59,
  /* 新卒 SP（〜767px）: FV → 定位置の移動・縮小はせず、最初から Figma 470:2672（SP の Hero 375×667）の位置・大きさに置く
     （.hero__stage 比。動画ノード ni-logo-only x -47 / y 311 / 484×458 と、ポスター内のロゴ外接矩形 x 214〜775 / y 141〜729 @988×936
     から逆算: 中心 x 195.2 / y 523.8、高さ 287.7）。回転は demo のまま。2026-09-15 指示「PC のように最初大きくして縮小・移動しなくていい」 */
  spFixed: { cx: 195.2 / 375, cy: 523.8 / 667, h: 287.7 / 667 },
  /* 新卒 SP の乗り換え（2026-09-17 指示「ロゴは Have Fun! あたりまで来たら Have Fun! と一緒にスクロールして消えていく」）:
     Message（[data-logo-dock]、SP はフローで 1:1 に上がる）上のロゴの定位置。Figma SP 470:2697 の Frame 2299（x -54.5 / y -197.7、
     動画ノードは +13）とポスター内のロゴ外接矩形から逆算: 中心 x 187.8 / y 28.3（Message 幅 375 基準。y も幅比で伸縮）。
     画面固定のロゴ（spFixed）までこの位置が上がってきたら Message に乗り換え、以降は Message と一緒に上へ抜ける。
     blend は乗り換えの手前で x を寄せるスクロール量 (px)。PC は変えない（place() の PC 分岐は dock を見ない） */
  spDock: { cx: 187.8 / 375, cy: 28.3 / 375, blend: 200 },
  /* 定位置固定モード（中途）: Hero（.hero__stage）座標の中心と高さ (px)。Figma 419:928 / 474:8469 の動画ノード
     （ni-logo-only、988x936 のポスター内のロゴ外接矩形 x 214〜775 / y 141〜729）から逆算。
     PC はステージ右端からの距離（max-width 1440 で中央寄せ。1440-1063 = 377）、SP は左端から */
  anchor: {
    sp: { cx: 252.7, cy: 396.5, h: 259 },
    pc: { fromRight: 377, cy: 207, h: 554, dock: { fromRight: 345, cy: 170, blend: 300 } }
  },
  /* dock: Message カード（[data-logo-dock]）上のロゴの定位置（カード座標 px。Figma 419:2031 の Frame 1963 → 動画ノード x 581 / y -240 から逆算:
     中心 x 1047 = カード幅 1392 - 345、y 170）。PC はロゴを画面に固定しておき、スクロールでカードのこの位置がロゴまで上がってきたら
     カードに乗り換えて一緒に上へ抜ける。blend はその手前で x をカードの位置へ寄せるスクロール量 (px)。SP は Figma にカード上のロゴが無く、
     Hero の位置のまま最初からカードに重なっているので dock なし = 最初から文書に固定 */
  spinRate: 0.18,     /* 定位置固定モード: Y 回転の速さ (rad/s)。デモの定位置での回転 g*(now/1000)*0.18 の係数と同値（≒ 35 秒で 1 周） */
  /* 描画 */
  maxPixelRatio: 2, bgMaxWidth: 1600
};

/* ロゴ（デモ埋め込みの SVG そのまま） */
const LOGO_SVG = '<svg width="46" height="55" viewBox="0 0 46 55" fill="none" xmlns="http://www.w3.org/2000/svg">'
  + '<path d="M7.50222 54.876H0V26.6003H7.50222V54.876ZM33.8219 26.6086H26.3197V54.8843H33.8219V26.6086ZM45.2197 26.6086H37.7175V54.8843H45.2197V26.6086ZM9.98646 27.7062C9.98646 27.7062 10.3991 34.9691 14.2286 42.166C18.0582 49.3628 23.8437 53.7783 23.8437 53.7783C23.8437 53.7783 23.431 46.5155 19.6015 39.3186C15.7803 32.1217 9.98646 27.7062 9.98646 27.7062ZM28.8369 0C28.8369 0 29.2496 7.26288 33.0791 14.4597C36.9004 21.6566 42.6942 26.0721 42.6942 26.0721C42.6942 26.0721 42.2815 18.8092 38.452 11.6124C34.6225 4.4155 28.8369 0 28.8369 0Z" fill="black"/>'
  + '</svg>';

const LOGO_H = 2.4;            /* ジオメトリの高さ（ワールド単位）。デモと同じ */
const CAM_Z = 10;              /* カメラ位置。fov 35° */
const PLATE_Z = -6;            /* 背景板の位置 */
const VIEW_H = 2 * Math.tan(THREE.MathUtils.degToRad(17.5)) * CAM_Z;   /* z=0 で見える高さ（ワールド単位） */

const smooth = (x) => (x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x));

/* ---------- 透過シェーダのパッチ（デモと同じ） ---------- */
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

/* three の transmission_fragment に「法線のゆらぎ」と「ACES 逆変換」を差し込む */
function buildTransmissionChunks() {
  const src = THREE.ShaderChunk.transmission_fragment;
  const normalLine = src.includes('transformNormalByInverseViewMatrix')
    ? 'vec3 n = transformNormalByInverseViewMatrix( normal, viewMatrix );'
    : 'vec3 n = inverseTransformDirection( normal, viewMatrix );';
  const alphaLine = 'material.transmissionAlpha = mix( material.transmissionAlpha, transmitted.a, material.transmission';
  if (!src.includes(normalLine) || !src.includes(alphaLine)) {
    console.warn('[ni-logo] three.js の transmission_fragment が想定と違います（バージョン差）。パッチなしで続行します');
    return { distort: src, distortAces: src };
  }
  const distort = src.replace(normalLine, normalLine + `
  if (uDistort > 0.0) {
    vec3 dgp = vDgP * uDistortScale + vec3(0.0, 0.0, uDgTime);
    vec3 dgn = vec3(dg_snoise(dgp), dg_snoise(dgp + 17.1), dg_snoise(dgp + 31.7));
    n = normalize(n + dgn * uDistort * 0.6);
  }`);
  /* three の ACESFilmic（Hill フィット）の厳密な逆変換: 表示後の透過光 = 実背景 に一致させる */
  const distortAces = distort.replace(alphaLine, `{
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
  return { distort, distortAces };
}

function init() {
  const hero = document.querySelector('.hero[data-anim="fv"]');
  if (!hero) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\blogo\b/.test(window.location.search)) return;   /* ?off=logo でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  /* 定位置固定モード（中途）: Hero 座標に固定してその場で回る。基準は .hero__stage（なければ .hero） */
  const staticMode = hero.hasAttribute('data-fv-static');
  const stage = hero.querySelector('.hero__stage') || hero;
  const dockEl = document.querySelector('[data-logo-dock]');
  const mqPc = window.matchMedia('(min-width: 768px)');
  /* 波の動画背景が見える範囲の終わり = 不透明な背景を持つ最初のセクション（About）。
     別の要素にしたい場合は data-logo-end を付ける */
  const logoEnd = document.querySelector('[data-logo-end]') || document.querySelector('.about');

  const canvas = document.createElement('canvas');
  canvas.className = 'ni-logo';
  canvas.setAttribute('aria-hidden', 'true');

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  } catch (e) {
    return;
  }
  renderer.setClearColor(0x000000, 0);
  renderer.setPixelRatio(Math.min(P.maxPixelRatio, window.devicePixelRatio || 1));
  /* SP の軽量設定（2026-09-17。iPhone で ?off=logo が最も効いたため、ガラスの見た目は残してロゴの描画コストを下げる）:
     - 屈折用に three が毎フレーム描く「背後の像」を半分の解像度に（ゆがんで見える背景なので差は分からない）
     - canvas の解像度を 2 倍 → 1 倍（画素 75% 減）
     - 裏面パス（奥のガラス面の別描画）は一度やめたが、SP のロゴが平たく地味に見えたので戻した（2026-09-17）。切り分け用の ?lite=back で切れる
     - 描画を 2 フレームに 1 回に（回転は 30fps 相当。位置計算とフックは毎フレーム）→ frame() の spLite */
  const spLite = !mqPc.matches;
  /* 切り分け用: URL の ?full=res,dpr,rate,bloom（または all）で SP の軽量設定を項目ごとに PC と同じに戻す（2026-09-17。実機で見比べる用）
     res = 屈折の背後描画を等倍, dpr = canvas を 2 倍, rate = 毎フレーム描画, bloom = Bloom。?lite=back で裏面パスを切る */
  const fullM = /[?&]full=([^&]*)/.exec(window.location.search);
  const full = (k) => !!fullM && (fullM[1] === 'all' || fullM[1].split(',').includes(k));
  const liteM = /[?&]lite=([^&]*)/.exec(window.location.search);
  const lite = (k) => !!liteM && liteM[1].split(',').includes(k);
  if (spLite) {
    if (!full('res')) renderer.transmissionResolutionScale = 0.5;
    if (!full('dpr')) renderer.setPixelRatio(1);   /* 1.5 でもまだ重かったので 1 倍（2026-09-17）。ガラスの輪郭は少し柔らかくなる */
    if (lite('back')) P.backOn = false;
  }
  const halfRate = spLite && !full('rate');
  let renderNo = 0;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = P.exposure;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(35, 1, 0.1, 100);
  camera.position.set(0, 0, CAM_Z);

  /* ---------- 背景の合成 canvas → 背景板 ---------- */
  const video = document.querySelector('.page-bg__video');
  const poster = new Image();
  if (video && video.poster) poster.src = video.poster;

  const bgCanvas = document.createElement('canvas');
  const bgCtx = bgCanvas.getContext('2d');
  bgCtx.imageSmoothingQuality = 'high';
  const bgTex = new THREE.CanvasTexture(bgCanvas);
  bgTex.colorSpace = THREE.SRGBColorSpace;

  /* SP（spLite）: 背景板をシェーダで合成する（2026-09-17）。従来は白地 → 動画（vidMax）→ 点線 → 青ベールを 2D canvas に描いて
     毎フレーム texImage2D で転送していたが、iOS は「動画のコマを 2D canvas に写す」のが遅く、テストページでこれ 1 つで 60 → 30fps だった。
     動画は VideoTexture（GPU 内で直接テクスチャ化）、点線は canvas テクスチャを 3 フレームに 1 回更新、白地・ベールはシェーダで同じ式。
     合成は従来と同じく sRGB のまま行い、最後に線形へ（= 従来の sRGB テクスチャの復号と同じ）。動画が再生できないときはポスター画像 */
  const spShaderBg = !mqPc.matches;
  const bgVideoTex = (spShaderBg && video) ? new THREE.VideoTexture(video) : null;
  if (bgVideoTex) { bgVideoTex.colorSpace = THREE.NoColorSpace; bgVideoTex.minFilter = THREE.LinearFilter; bgVideoTex.magFilter = THREE.LinearFilter; bgVideoTex.generateMipmaps = false; }
  const bgPosterTex = spShaderBg ? new THREE.Texture(poster) : null;
  if (bgPosterTex) { bgPosterTex.colorSpace = THREE.NoColorSpace; bgPosterTex.minFilter = THREE.LinearFilter; bgPosterTex.generateMipmaps = false; poster.addEventListener('load', () => { bgPosterTex.needsUpdate = true; }); if (poster.complete && poster.naturalWidth) bgPosterTex.needsUpdate = true; }
  const bgWhiteTex = new THREE.DataTexture(new Uint8Array([255, 255, 255, 0]), 1, 1); bgWhiteTex.needsUpdate = true;
  let bgFieldTex = null, bgFieldCanvas = null;
  const bgShaderMat = spShaderBg ? new THREE.ShaderMaterial({
    uniforms: {
      uVideo: { value: bgWhiteTex }, uHasVideo: { value: 0 }, uVidAlpha: { value: P.vidMax }, uVidAsp: { value: 16 / 9 },
      uField: { value: bgWhiteTex }, uHasField: { value: 0 },
      uAsp: { value: 1 }, uVeil: { value: P.blueVeil },
      uVeilA: { value: new THREE.Color(0xDCE2FD) }, uVeilB: { value: new THREE.Color(0xA9CDF8) },
      uRaw: { value: 0 }
    },
    vertexShader: 'varying vec2 vUv; void main(){ vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }',
    fragmentShader: `
      precision highp float;
      varying vec2 vUv;
      uniform sampler2D uVideo; uniform float uHasVideo; uniform float uVidAlpha; uniform float uVidAsp;
      uniform sampler2D uField; uniform float uHasField;
      uniform float uAsp; uniform float uVeil; uniform vec3 uVeilA; uniform vec3 uVeilB; uniform float uRaw;
      vec3 toLin(vec3 c){ return mix(c / 12.92, pow((c + 0.055) / 1.055, vec3(2.4)), step(0.04045, c)); }
      void main(){
        /* 板は viewport より 1.02 倍大きい → viewport の uv に直す（y は下向き = canvas と同じ） */
        vec2 s = (vUv - 0.5) * 1.02 + 0.5;
        vec2 sd = vec2(s.x, 1.0 - s.y);
        vec3 col = vec3(1.0);
        /* 動画: cover（drawBg の max(W/sw, H/sh) と同じ） */
        float ra = uAsp / uVidAsp;
        vec2 vuv = s;
        if (ra > 1.0) vuv.y = (s.y - 0.5) / ra + 0.5; else vuv.x = (s.x - 0.5) * ra + 0.5;
        vec3 vc = texture2D(uVideo, vuv).rgb;
        col = mix(col, vc, uVidAlpha * uHasVideo);
        /* 点線（source-over） */
        vec4 f = texture2D(uField, s);
        col = mix(col, f.rgb, f.a * uHasField);
        /* 青ベール: 254deg の線形グラデ（drawBg と同じ） */
        float a = radians(254.0); float sx = sin(a), sy = -cos(a);
        float half_ = (abs(sx) * uAsp + abs(sy) * 1.0) * 0.5;   /* 幅を uAsp、高さを 1 とした px 相当 */
        vec2 pd = vec2((sd.x - 0.5) * uAsp, (sd.y - 0.5) * 1.0);
        float t = clamp((dot(pd, vec2(sx, sy)) + half_) / (2.0 * half_), 0.0, 1.0);
        col = mix(col, mix(uVeilA, uVeilB, t), uVeil);
        gl_FragColor = vec4(uRaw > 0.5 ? col : toLin(col), 1.0);
      }`,
    depthWrite: true, depthTest: true
  }) : null;
  /* uVeilA / uVeilB は sRGB の値のまま使う（Color は線形に変換して持つので、生の値を入れ直す） */
  if (bgShaderMat) { bgShaderMat.uniforms.uVeilA.value.setRGB(0xDC / 255, 0xE2 / 255, 0xFD / 255, THREE.NoColorSpace); bgShaderMat.uniforms.uVeilB.value.setRGB(0xA9 / 255, 0xCD / 255, 0xF8 / 255, THREE.NoColorSpace); }

  const bgPlateMat = bgShaderMat || new THREE.MeshBasicMaterial({ map: bgTex, toneMapped: false });
  const bgPlate = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), bgPlateMat);
  bgPlate.position.z = PLATE_Z;
  bgPlate.frustumCulled = false;
  scene.add(bgPlate);

  /* 裏面パスの結果（背景 + 裏面のガラス）を表面パスの屈折対象にする板 */
  const rtBack = new THREE.WebGLRenderTarget(2, 2, { samples: 0, type: THREE.HalfFloatType });
  rtBack.texture.colorSpace = THREE.LinearSRGBColorSpace;
  rtBack.texture.generateMipmaps = false;
  rtBack.texture.minFilter = THREE.LinearFilter;
  const backPlateMat = new THREE.MeshBasicMaterial({ map: rtBack.texture, toneMapped: false });
  const backPlate = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), backPlateMat);
  backPlate.position.z = PLATE_Z;
  backPlate.frustumCulled = false;
  backPlate.visible = false;
  scene.add(backPlate);

  /* ---------- 環境光（白と青の板を並べたシーン → PMREM） ---------- */
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
    g.rotation.y = THREE.MathUtils.degToRad(P.envRot);
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
  const chunks = buildTransmissionChunks();

  const faceMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1 });
  const edgeMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1 });
  const backFaceMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1, side: THREE.BackSide });
  const backEdgeMat = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0, transmission: 1, side: THREE.BackSide });

  function patch(mat, chunk) {
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
  patch(faceMat, chunks.distortAces);
  patch(edgeMat, chunks.distortAces);
  patch(backFaceMat, chunks.distort);
  patch(backEdgeMat, chunks.distort);

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

  /* ---------- 形（SVG → 押し出し） ---------- */
  const group = new THREE.Group();
  scene.add(group);

  const svg = new SVGLoader().parse(LOGO_SVG);
  const shapes = [];
  for (const path of svg.paths) shapes.push(...SVGLoader.createShapes(path));
  const S = 55;   /* SVG の高さ（viewBox）。押し出し量・面取りは SVG 座標系で指定 */
  const geo = new THREE.ExtrudeGeometry(shapes, {
    depth: P.depth * S,
    bevelEnabled: true,
    bevelThickness: P.bevel * S * 0.55,
    bevelSize: P.bevel * S,
    bevelOffset: -P.bevel * S,
    bevelSegments: Math.max(1, Math.round(P.bevelSegs)),
    curveSegments: Math.max(4, Math.round(P.curveSegs))
  });
  geo.computeBoundingBox();
  const bb = geo.boundingBox, size = new THREE.Vector3();
  bb.getSize(size);
  geo.translate(-(bb.min.x + bb.max.x) / 2, -(bb.min.y + bb.max.y) / 2, -(bb.min.z + bb.max.z) / 2);
  const k = LOGO_H / size.y;
  geo.scale(k, -k, -k);   /* SVG は y 下向きなので反転（z も反転して向きを保つ） */
  geo.computeVertexNormals();

  const frontMesh = new THREE.Mesh(geo, [faceMat, edgeMat]);
  frontMesh.frustumCulled = false;
  group.add(frontMesh);
  const backMesh = new THREE.Mesh(geo, [backFaceMat, backEdgeMat]);
  backMesh.frustumCulled = false;
  backMesh.visible = false;
  group.add(backMesh);

  /* ---------- ポストプロセス（描画パス + 弱いブルーム） ---------- */
  /* 上描き用シーン: composer（ACES トーンマップ）を通さず、描画の最後に NoToneMapping で画面へ重ねる層。
     FV の写真（fv-photos.js）が使う。写真はロゴより手前（z 1.5）なので重なり順は composer に入れていたときと同じで、
     色は DOM の <img> と一致する（composer 経由だと OutputPass の ACES で暗く沈む。2026-09-17「写真がデザインより暗い」対応） */
  const overlayScene = new THREE.Scene();
  const composer = new EffectComposer(renderer);
  composer.addPass(new RenderPass(scene, camera));
  const bloom = new UnrealBloomPass(new THREE.Vector2(1, 1), P.bloomStrength, P.bloomRadius, P.bloomThreshold);
  /* 加算で足すが α は元のまま（canvas の透明を保つ） */
  const bm = bloom.blendMaterial;
  bm.blending = THREE.CustomBlending;
  bm.blendEquation = THREE.AddEquation;
  bm.blendSrc = THREE.OneFactor;
  bm.blendDst = THREE.OneFactor;
  bm.blendEquationAlpha = THREE.AddEquation;
  bm.blendSrcAlpha = THREE.ZeroFactor;
  bm.blendDstAlpha = THREE.OneFactor;
  /* SP（〜767px）では Bloom を切る（2026-09-17）: しきい値 18.3 で実質発光していないのに、全画面の多段ぼかしを毎フレーム払っていて
     iPhone のスクロールが重い。見た目の差はない。PC はデザイナーが後で光らせられるよう残す。判定は読み込み時のみ（またげば common.js が再読み込み） */
  bloom.enabled = mqPc.matches || full('bloom');
  composer.addPass(bloom);
  composer.addPass(new OutputPass());

  /* 背景板は「画面」と「コンポーザのバッファ」には描かない。透過用の内部ターゲットと裏面用ターゲットにだけ描く */
  const plateColorWrite = (mat) => () => {
    const rt = renderer.getRenderTarget();
    mat.colorWrite = !(rt === null || rt === composer.renderTarget1 || rt === composer.renderTarget2);
  };
  bgPlate.onBeforeRender = plateColorWrite(bgPlateMat);
  backPlate.onBeforeRender = plateColorWrite(backPlateMat);

  /* ---------- 画面サイズ ---------- */
  let W = 1, H = 1;
  function resize() {
    W = Math.max(1, Math.round(document.documentElement.clientWidth));
    H = Math.max(1, Math.round(window.innerHeight));
    renderer.setSize(W, H, false);
    composer.setSize(W, H);
    camera.aspect = W / H;
    camera.updateProjectionMatrix();

    const bw = Math.min(P.bgMaxWidth, W);
    bgCanvas.width = bw;
    bgCanvas.height = Math.max(2, Math.round(bw * H / W));
    if (bgShaderMat) bgShaderMat.uniforms.uAsp.value = W / H;

    const dist = camera.position.z - PLATE_Z;
    const ph = 2 * Math.tan(THREE.MathUtils.degToRad(17.5)) * dist;
    bgPlate.scale.set(ph * (W / H) * 1.02, ph * 1.02, 1);
    backPlate.scale.set(ph * (W / H), ph, 1);

    const pr = renderer.getPixelRatio();
    rtBack.setSize(Math.round(W * pr), Math.round(H * pr));
  }

  /* 波の動画背景が見える範囲だけ描く: About の上端より下は切り取る。範囲がなくなったら描かない */
  let clipBottom = -1;
  function clipToVideoArea() {
    if (!logoEnd && !window.__fvAbout) return false;
    /* About がモザイクで覆ってくるページ（fv-about.js）はその前線、それ以外は About の上端 */
    const top = window.__fvAbout ? window.__fvAbout.coverTop() : logoEnd.getBoundingClientRect().top;
    const visible = Math.max(0, Math.min(H, Math.round(top)));
    /* 切り取りは CSS の clip-path ではなく描画時のシザーで行う（下の frame()）。clip-path を毎フレーム書き換えると
       iOS ではスクロール中の合成が重くなる（2026-09-17） */
    clipBottom = H - visible;
    return visible <= 0;
  }

  /* ---------- 配置（デモの choreo と同じ式） ---------- */
  function place(t, s, introK) {
    const unitX = VIEW_H * (W / H);
    const g = smooth(Math.min(1, s / 0.36));
    const spin = Math.pow(g, 1.7) * Math.PI * 2 + Math.max(0, s - 0.36) * 0.9 + g * (performance.now() / 1000) * 0.18;
    if (!mqPc.matches) {
      /* SP: 最初から Figma の位置・大きさ（.hero__stage 比）。イントロのせり上がりだけ demo と同じ。
         Message（[data-logo-dock]）の定位置（P.spDock）が画面固定のロゴまで上がってきたら Message に乗り換えて一緒に上へ抜ける
         （placeStatic の dock と同じ考え方。About の上端で切る処理はそのまま） */
      const r = stage.getBoundingClientRect();
      let px = r.left + r.width * P.spFixed.cx, py = r.top + r.height * P.spFixed.cy;
      const d = P.spDock;
      if (d && dockEl) {
        const c = dockEl.getBoundingClientRect();
        const dockX = c.left + c.width * d.cx;
        const dockY = c.top + c.width * d.cy;
        const gap = dockY - py;                       /* 乗り換えまでの残り (px)。0 以下で乗り換え */
        const k = gap <= 0 ? 1 : 1 - Math.min(1, gap / Math.max(1, d.blend || 1));
        px += (dockX - px) * k;
        py = Math.min(py, dockY);
      }
      const x = (px / W * 2 - 1) * unitX / 2;
      const y = (1 - py / H * 2) * VIEW_H / 2 - (1 - introK) * VIEW_H * 0.95;
      const M = (r.height * P.spFixed.h / H) * VIEW_H;
      group.position.set(x, y, 0);
      group.scale.setScalar(M / LOGO_H);
      setRotation(t, spin);
      return;
    }
    const c = P.fvH * VIEW_H, l = P.fvX * unitX, u = VIEW_H * 0.475 - c / 2 + P.fvY * VIEW_H;
    const d = P.restH * VIEW_H, h = P.restX * unitX, pp = P.restY;
    const M = c + (d - c) * g;
    const m = l + (h - l) * g;
    const f = u + (pp - u) * g - (1 - introK) * VIEW_H * 0.95;
    group.position.set(m, f, 0);
    group.scale.setScalar(M / LOGO_H);
    setRotation(t, spin);
  }

  /* 回転（デモと同じ式）: Y はそのまま spin、X / Z は tilt を中心にした楕円の揺れ（tiltAuto） */
  function setRotation(t, spin) {
    const v = t * Math.PI * 2 / P.tiltPeriod;
    const rx = P.tilt + (P.tiltAuto ? P.tiltAmp * Math.cos(v) : 0);
    const rz = P.tiltAuto ? P.tiltAmp * P.tiltOrbit * Math.sin(v) : 0;
    group.rotation.set(THREE.MathUtils.degToRad(rx), spin, THREE.MathUtils.degToRad(rz), 'XYZ');
  }

  /* ---------- 配置（定位置固定モード）: Hero 座標の定位置 → 画面 px → ワールド座標（logoRect() の逆写像） ----------
     dock があるとき（PC）: ロゴは画面上の Hero の位置（スクロール 0 のときの画面座標）に固定。Message カードの dock 位置が
     スクロールでそこまで上がってきたら（dockY <= fixedY）カードに乗り換え、以降はカードと一緒に上へ抜ける。
     dock がないとき（SP）: Hero に固定（文書と一緒にスクロール） */
  function placeStatic(t) {
    const a = mqPc.matches ? P.anchor.pc : P.anchor.sp;
    const r = stage.getBoundingClientRect();
    let px = a.fromRight !== undefined ? r.right - a.fromRight : r.left + a.cx;
    let py = r.top + a.cy;
    const d = a.dock;
    if (d && dockEl) {
      const fixedY = r.top + window.scrollY + a.cy;   /* 画面に固定: スクロール 0 のときの画面 y */
      const c = dockEl.getBoundingClientRect();
      const dockX = d.fromRight !== undefined ? c.right - d.fromRight : c.left + d.cx;
      const dockY = c.top + d.cy;
      const gap = dockY - fixedY;                     /* 乗り換えまでの残り (px)。0 以下で乗り換え */
      const k = gap <= 0 ? 1 : 1 - Math.min(1, gap / Math.max(1, d.blend || 1));
      px += (dockX - px) * k;
      py = Math.min(fixedY, dockY);
    }
    const unitX = VIEW_H * (W / H);
    const x = (px / W * 2 - 1) * unitX / 2;
    const y = (1 - py / H * 2) * VIEW_H / 2;
    const M = (a.h / H) * VIEW_H;
    group.position.set(x, y, 0);
    group.scale.setScalar(M / LOGO_H);
    /* 回転はデモの定位置と同じ: 一定速度の Y 回転 + tilt の揺れ。スクロール量は使わない */
    setRotation(t, t * P.spinRate);
  }

  /* ---------- 背景の合成（白 → 動画 cover → 青ベール。base.css の .page-bg と同じ見た目） ---------- */
  let veil = P.blueVeil;
  function drawBg() {
    const w = bgCanvas.width, h = bgCanvas.height;
    if (!w || !h) return;
    const c = bgCtx;
    c.globalCompositeOperation = 'source-over';
    c.globalAlpha = 1;
    c.fillStyle = '#ffffff';
    c.fillRect(0, 0, w, h);

    let src = null, sw = 0, sh = 0;
    if (video && video.readyState >= 2 && video.videoWidth) {
      src = video; sw = video.videoWidth; sh = video.videoHeight;
    } else if (poster.complete && poster.naturalWidth) {
      src = poster; sw = poster.naturalWidth; sh = poster.naturalHeight;
    }
    if (src) {
      /* 固定背景は viewport に cover。canvas も viewport 固定なのでそのまま同じ置き方 */
      const s = Math.max(W / sw, H / sh);
      const dw = sw * s, dh = sh * s;
      const f = w / W;
      c.globalAlpha = P.vidMax;
      c.drawImage(src, ((W - dw) / 2) * f, ((H - dh) / 2) * f, dw * f, dh * f);
      c.globalAlpha = 1;
    }

    /* 他モジュールの層（点と線 = 全画面 canvas、Have Fun! = {canvas, rect(), afterVeil} で画面上の矩形を指定）。
       ガラスの奥に見える背景板に描くので、ロゴ越しに屈折して見える。afterVeil の層は青ベールの後に不透明で描く（demo の ch と同じ） */
    const drawLayers = (after) => {
      for (const layer of bgLayers) {
        if (!!layer.afterVeil !== after) continue;
        try {
          const src2 = layer.canvas || layer;
          if (!src2.width || !src2.height) continue;
          if (layer.rect) {
            const r = layer.rect(), f = w / W;
            c.drawImage(src2, r.x * f, r.y * f, r.w * f, r.h * f);
          } else {
            c.drawImage(src2, 0, 0, w, h);
          }
        } catch (e) { /* 汚染など */ }
      }
    };
    drawLayers(false);

    if (veil > 0) {
      const a = 254 * Math.PI / 180, sx = Math.sin(a), sy = -Math.cos(a);
      const half = (Math.abs(sx) * w + Math.abs(sy) * h) / 2;
      const g = c.createLinearGradient(w / 2 - sx * half, h / 2 - sy * half, w / 2 + sx * half, h / 2 + sy * half);
      g.addColorStop(0, '#DCE2FD');
      g.addColorStop(1, '#A9CDF8');
      c.globalAlpha = veil;
      c.fillStyle = g;
      c.fillRect(0, 0, w, h);
      c.globalAlpha = 1;
    }
    drawLayers(true);
    bgTex.needsUpdate = true;
  }

  /* SP のシェーダ背景: 動画かポスターかを選び、ベール・点線を更新（drawBg の代わり。転送は点線を 3 フレームに 1 回だけ） */
  let bgFrameNo = 0;
  function updateBgUniforms() {
    const u = bgShaderMat.uniforms;
    const liveVideo = !!(video && video.readyState >= 2 && video.videoWidth);
    if (liveVideo) { u.uVideo.value = bgVideoTex; u.uHasVideo.value = 1; u.uVidAsp.value = video.videoWidth / video.videoHeight; }
    else if (poster.complete && poster.naturalWidth) { u.uVideo.value = bgPosterTex; u.uHasVideo.value = 1; u.uVidAsp.value = poster.naturalWidth / poster.naturalHeight; }
    else { u.uHasVideo.value = 0; }
    u.uVeil.value = veil;
    const fieldCv = bgLayers.find((l) => !l.rect && !l.afterVeil && (l.canvas || l).width) || null;
    const fc = fieldCv ? (fieldCv.canvas || fieldCv) : null;
    if (fc && fc !== bgFieldCanvas) { bgFieldCanvas = fc; bgFieldTex = new THREE.CanvasTexture(fc); bgFieldTex.colorSpace = THREE.NoColorSpace; bgFieldTex.minFilter = THREE.LinearFilter; bgFieldTex.generateMipmaps = false; u.uField.value = bgFieldTex; }
    if (bgFieldTex) { u.uHasField.value = 1; if ((bgFrameNo++ % 3) === 0) bgFieldTex.needsUpdate = true; }
    else u.uHasField.value = 0;
  }

  /* ---------- 描画ループ ---------- */
  const clock = new THREE.Clock();
  let t = 0;
  /* 他のモジュール（fv-photos.js）がシーンに物を足して毎フレーム更新するためのフック。描画の直前に呼ぶ */
  const hooks = [];
  /* 背景の合成に重ねる画面サイズの canvas（fv-field.js の点と線）。ガラスがこれも屈折させる（デモの __bgfx） */
  const bgLayers = [];

  function frame() {
    const dt = Math.min(0.1, clock.getDelta());
    t += dt;
    fv.tick(performance.now());   /* 進行度（慣性つき）とイントロ */

    const off = clipToVideoArea();
    canvas.classList.toggle('is-off', off);
    if (off) return;

    uDgTime.value = t * P.distortSpeed;
    const pulse = Math.sin(t * Math.PI * 2 / Math.max(2, P.bgPulsePeriod));
    veil = Math.max(0, Math.min(0.85, P.blueVeil * (1 + P.bgPulse * pulse)));
    const expo = P.exposure * (1 - P.logoPulse * 0.25 * ((pulse + 1) / 2));
    renderer.toneMappingExposure = expo;
    uExposure.value = expo;

    if (staticMode) placeStatic(t);
    else place(t, fv.p, fv.introK);
    for (const h of hooks) h(t);
    if (halfRate && (renderNo++ & 1)) return;   /* SP: 描画は 2 フレームに 1 回 */
    if (bgShaderMat) updateBgUniforms(); else drawBg();

    /* About より下は描かない: 画面全体を透明にクリアしてから、見える範囲だけにシザーを掛けて描く（clip-path の代わり） */
    renderer.setRenderTarget(null);
    renderer.setScissorTest(false);
    renderer.clear();
    if (clipBottom > 0) {
      renderer.setScissorTest(true);
      renderer.setScissor(0, clipBottom, W, Math.max(0, H - clipBottom));   /* 原点は左下 */
    }

    if (P.backOn) {
      /* 1) 裏面: 背景板 + 裏面ガラスを rtBack へ（トーンマップなし） */
      bgPlate.visible = true; backPlate.visible = false;
      backMesh.visible = true; frontMesh.visible = false;
      const tm = renderer.toneMapping;
      renderer.toneMapping = THREE.NoToneMapping;
      renderer.setRenderTarget(rtBack);
      renderer.clear();
      renderer.render(scene, camera);
      renderer.setRenderTarget(null);
      renderer.toneMapping = tm;
      /* 2) 表面: rtBack の板を屈折対象にして画面へ */
      bgPlate.visible = false; backPlate.visible = true;
      backMesh.visible = false; frontMesh.visible = true;
      composer.render();
      bgPlate.visible = true; backPlate.visible = false;
    } else {
      bgPlate.visible = true; backPlate.visible = false;
      backMesh.visible = false; frontMesh.visible = true;
      composer.render();
    }
    /* 上描き層（写真）: トーンマップなし・クリアなしで composer の結果の上に描く */
    if (overlayScene.children.length) {
      const tm = renderer.toneMapping;
      renderer.toneMapping = THREE.NoToneMapping;
      renderer.autoClear = false;
      renderer.render(overlayScene, camera);
      renderer.autoClear = true;
      renderer.toneMapping = tm;
    }
  }

  /* タブ非表示のときは止める */
  let running = false;
  function loop() {
    if (!running) return;
    requestAnimationFrame(loop);
    frame();
  }
  function sync() {
    const want = !document.hidden;
    if (want && !running) {
      running = true;
      clock.getDelta();
      requestAnimationFrame(loop);
    } else if (!want) {
      running = false;
    }
  }
  document.addEventListener('visibilitychange', sync);

  canvas.addEventListener('webglcontextlost', (e) => {
    e.preventDefault();
    running = false;
    canvas.classList.add('is-off');
  });

  /* 波背景（.page-bg）の直後に置く: 重なり順は背景の一つ上・本文の下 */
  const pageBg = document.querySelector('.page-bg');
  if (pageBg && pageBg.parentNode) pageBg.parentNode.insertBefore(canvas, pageBg.nextSibling);
  else document.body.appendChild(canvas);
  window.addEventListener('resize', resize);
  resize();
  sync();

  /* 開発用: コンソールから数値を触れるように（P を変えて applyMaterials() / buildEnv() で反映） */
  window.__niLogo = {
    P, applyMaterials, buildEnv, resize, frame, renderer, scene, overlayScene, camera, group, frontMesh, hooks, bgLayers, THREE, bgCanvas, bloom,
    bgShaderMat, bgPlate, drawBg, bgVideoTex, bgPosterTex, bgWhiteTex, updateBgUniforms, video, poster,
    get viewSize() { return { W, H }; },
    /* ロゴの画面上の位置と大きさ（デモの __niLogoRect）。cx / cy = 中心 px、hpx = 高さ px */
    logoRect() {
      return {
        W, H,
        hpx: H * (group.scale.y * LOGO_H / VIEW_H / 1.02),
        cx: (group.position.x / (VIEW_H * (W / H) / 2) + 1) / 2 * W,
        cy: (1 - group.position.y / (VIEW_H / 2)) / 2 * H
      };
    },
    get progress() { return fv.p; },
    get running() { return running; },
    staticMode
  };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
