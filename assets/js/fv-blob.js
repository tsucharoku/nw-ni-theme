/* ==========================================================================
   fv-blob.js — 流体の光の背景（マウスに反応して白く光る）（新卒・中途）

   デモ（デモ/NI_TOP.html「WebGL流体ブロブ背景」）をそのまま移植したもの。
   - 白地に淡いブルー〜ラベンダーの光が漂い（simplex ノイズのドメインワープ）、
     カーソルの近くで光が立ち上がって白くなる。動かすほど強く（uVel）、止まると減衰
   - カーソルは慣性つきで遅れて追従。画面外に出ると穏やかに戻る（uLens）
   - 固定背景（.page-bg）の動画の上・フレームの下に置く画面サイズの WebGL canvas。透明度 0〜0.78 で重ねる
   three.js（import map）の ShaderMaterial + 全画面クアッド。デモは three r147 だが同じコードで動く。
   ========================================================================== */
import * as THREE from 'three';

const FRAG = [
  'precision highp float;',
  'uniform float uTime;uniform vec2 uMouse;uniform float uLens;uniform float uVel;uniform vec2 uRes;',
  '/* --- simplex noise (Ashima) --- */',
  'vec3 mod289(vec3 x){return x-floor(x*(1.0/289.0))*289.0;}',
  'vec2 mod289(vec2 x){return x-floor(x*(1.0/289.0))*289.0;}',
  'vec3 permute(vec3 x){return mod289(((x*34.0)+1.0)*x);}',
  'float snoise(vec2 v){',
  '  const vec4 C=vec4(0.211324865405187,0.366025403784439,-0.577350269189626,0.024390243902439);',
  '  vec2 i=floor(v+dot(v,C.yy)); vec2 x0=v-i+dot(i,C.xx);',
  '  vec2 i1=(x0.x>x0.y)?vec2(1.0,0.0):vec2(0.0,1.0);',
  '  vec4 x12=x0.xyxy+C.xxzz; x12.xy-=i1; i=mod289(i);',
  '  vec3 p=permute(permute(i.y+vec3(0.0,i1.y,1.0))+i.x+vec3(0.0,i1.x,1.0));',
  '  vec3 m=max(0.5-vec3(dot(x0,x0),dot(x12.xy,x12.xy),dot(x12.zw,x12.zw)),0.0); m=m*m; m=m*m;',
  '  vec3 x=2.0*fract(p*C.www)-1.0; vec3 h=abs(x)-0.5; vec3 ox=floor(x+0.5); vec3 a0=x-ox;',
  '  m*=1.79284291400159-0.85373472095314*(a0*a0+h*h);',
  '  vec3 g; g.x=a0.x*x0.x+h.x*x0.y; g.yz=a0.yz*x12.xz+h.yz*x12.yw;',
  '  return 130.0*dot(m,g);',
  '}',
  'float blob(vec2 q, vec2 c, float r){ float d=length(q-c); return exp(-d*d/(2.0*r*r)); }',
  'void main(){',
  '  vec2 uv=gl_FragCoord.xy/uRes;',
  '  float asp=uRes.x/uRes.y;',
  '  vec2 p=vec2(uv.x*asp, uv.y);',
  '  vec2 m=vec2(uMouse.x*asp, uMouse.y);',
  '  float t=uTime;',
  '  float dm=length(p-m);',
  '  /* === 流れる光のフィールド: ドメインワープ + カーソルで攪拌 === */',
  '  vec2 flow=vec2(snoise(p*1.25+vec2(0.0,t*0.06)), snoise(p*1.25+vec2(4.7,t*0.05)));',
  '  vec2 toM=p-m;',
  '  float infl=exp(-dm*dm/(2.0*0.34*0.34));',
  '  vec2 swirl=vec2(-toM.y,toM.x)/max(dm,0.04);',
  '  vec2 pw=p+0.20*flow+ (0.10+0.18*uVel)*swirl*infl;',
  '  float n1=snoise(pw*1.7+vec2(t*0.05,0.0));',
  '  float n2=snoise(pw*3.2+vec2(0.0,-t*0.04));',
  '  float sfld=0.62*n1+0.38*n2;',
  '  /* カーソル反応: 近傍で光が立ち上がる + 動かすと強まる */',
  '  float react=infl*(0.30+1.10*uVel);',
  '  float bloom=exp(-dm*dm/(2.0*0.15*0.15));',
  '  float s2=sfld + react*0.55 + bloom*(0.55+1.4*uVel);',
  '  float lightPos=smoothstep(0.12,0.90,s2);',
  '  float shadeNeg=smoothstep(0.15,0.85,-s2)*0.55;',
  '  /* プレミアムな淡色: ブルー<->ラベンダー、光芯は暖白 */',
  '  float ht=snoise(pw*0.8+3.3)*0.5+0.5;',
  '  vec3 hue=mix(vec3(0.80,0.87,1.00), vec3(0.90,0.85,1.00), ht);',
  '  vec3 col=mix(hue, vec3(1.00,0.995,0.98), clamp(lightPos+bloom*0.6,0.0,1.0));',
  '  col=mix(col, vec3(0.70,0.79,0.95), shadeNeg);',
  '  /* 微弱グレイン(バンディング防止) */',
  '  float g=fract(sin(dot(gl_FragCoord.xy,vec2(12.9898,78.233)))*43758.5453);',
  '  float a = lightPos*0.50 + shadeNeg*0.22 + bloom*0.45*(0.5+0.9*uVel);',
  '  a += (g-0.5)*0.014;',
  '  float aa = clamp(a,0.0,0.78);',
  '  gl_FragColor=vec4(col*aa, aa);   /* 乗算済みアルファで出す（下の premultipliedAlpha: true と対） */',
  '}'
].join('\n');

function init() {
  const bg = document.querySelector('.page-bg');
  if (!bg) return;
  if (/[?&]nowebgl/.test(window.location.search) || /[?&]off=[^&]*\bblob\b/.test(window.location.search)) return;   /* ?off=blob でこのモジュールだけ止める（実機の切り分け用） */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const cv = document.createElement('canvas');
  cv.className = 'page-bg__blob';
  cv.setAttribute('aria-hidden', 'true');
  const video = bg.querySelector('.page-bg__video');
  if (video && video.nextSibling) bg.insertBefore(cv, video.nextSibling); else bg.appendChild(cv);

  let renderer;
  try {
    /* premultipliedAlpha は true（既定）: iOS Safari は false の透明 canvas を正しく合成できず、光の層が全面に白く出て
       背景動画が見えなくなる（iPhone 18.7 の実機で確認。2026-09-17）。シェーダ側で色にアルファを掛けて出す */
    renderer = new THREE.WebGLRenderer({ canvas: cv, alpha: true, antialias: false, premultipliedAlpha: true });
  } catch (e) {
    cv.remove();
    return;
  }
  renderer.setClearColor(0x000000, 0);   /* 乗算済みなので透明は (0,0,0,0) */

  const uniforms = {
    uTime: { value: 0 },
    uVel: { value: 0 },
    uMouse: { value: new THREE.Vector2(0.5, 0.5) },
    uLens: { value: 0 },
    uRes: { value: new THREE.Vector2(1, 1) }
  };
  const mat = new THREE.ShaderMaterial({
    transparent: true, depthWrite: false, premultipliedAlpha: true, uniforms,   /* ブレンドは ONE, ONE_MINUS_SRC_ALPHA */
    vertexShader: 'void main(){gl_Position=vec4(position,1.0);}',
    fragmentShader: FRAG
  });
  const scene = new THREE.Scene();
  const quad = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), mat);
  quad.frustumCulled = false;
  scene.add(quad);
  const cam = new THREE.OrthographicCamera(-1, 1, 1, -1, -1, 1);

  function rs() {
    const w = Math.max(1, document.documentElement.clientWidth), h = Math.max(1, window.innerHeight);
    const dpr = window.matchMedia('(max-width: 767px)').matches ? 1 : Math.min(1.5, window.devicePixelRatio || 1);   /* SP は 1 倍（ボケた光なので差が出ない。負荷対策 2026-09-17） */
    renderer.setPixelRatio(dpr);
    renderer.setSize(w, h, false);
    uniforms.uRes.value.set(w * dpr, h * dpr);
  }
  window.addEventListener('resize', rs);
  rs();

  /* マウス: 慣性(イージング)付き追従 + レンズのフェード（背景は pointer-events を受けないので window で拾う） */
  let mxT = 0.5, myT = 0.5, lT = 0;
  window.addEventListener('pointermove', (e) => {
    mxT = e.clientX / Math.max(1, window.innerWidth);
    myT = 1.0 - e.clientY / Math.max(1, window.innerHeight);
    lT = 1;
  }, { passive: true });
  document.addEventListener('pointerleave', () => { lT = 0; });
  document.documentElement.addEventListener('mouseleave', () => { lT = 0; });

  let t0 = 0;
  function frame() {
    t0 += 0.016;
    uniforms.uTime.value = t0;
    const mv = uniforms.uMouse.value;
    const gx = mxT - mv.x, gy = myT - mv.y;                 /* 目標との差 ≒ 動きの勢い */
    const sp = Math.min(1.0, Math.sqrt(gx * gx + gy * gy) * 7.0);
    uniforms.uVel.value += (sp - uniforms.uVel.value) * 0.12;   /* 動くと上がり、止まると減衰 */
    mv.x += gx * 0.055;                                       /* 遅れて追従 */
    mv.y += gy * 0.055;
    uniforms.uLens.value += (lT - uniforms.uLens.value) * 0.07;
    renderer.render(scene, cam);
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
  cv.addEventListener('webglcontextlost', (e) => { e.preventDefault(); running = false; cv.style.visibility = 'hidden'; });
  sync();

  window.__fvBlob = { frame, uniforms, canvas: cv };
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
