/* ==========================================================================
   fv-future.js — Future セクションの登場（新卒・中途）

   デモ（デモ/NI_TOP.html「Future: 視界到達→四隅へ分離」）と同じ動き。見た目（色・サイズ・配置）は現行デザインのまま:
   - 四隅のカッコ（.bracket__corner）は最初、枠の中央やや上に小さなカッコとして寄り集まっている
     （demo: 横 22px / 縦 26px の隙間。ここではカッコの大きさに対する比で持つ）。
     枠の上端が画面下端に入ったら（demo の IO 発火時より少し早い）すぐ .is-open を付け、
     0.1s 静止（demo は 0.3s）→ 0.32s cubic-bezier(.6,0,.9,.5) で一気に四隅へ（CSS transition。余韻なしでピタ停止）
   - カッコ到着後（0.5s 後）に中身（見出し・本文・ボタン）が 0.7s でフェード＋16px せり上がり
   - 飾りの四角（.future__squares span）は demo の写真と同じく 0.3 倍から跳ねながら拡大して登場
     （scale 0.9s cubic-bezier(.34,1.56,.64,1) ＋ フェード 0.55s、遅れは 0.3〜0.95s で個体差）。
     以降は 2 種の浮遊アニメ（ni-float / ni-float2、周期・位相は要素ごとに違う）で ふわふわ
   - 寄せ量（--cx/--cy）は JS が枠とカッコの実寸から計算。リサイズ時は再計算
   - 初期状態は JS が .is-fx を付けてから効く（JS が動かない環境ではデザインの静止状態のまま）
   ========================================================================== */
const GAP = 0.75;      /* クラスター内の隙間（カッコの一辺に対する比。demo: 22px / 32px ≒ 0.7〜0.8） */
const CY = 0.395;      /* クラスター中心の縦位置（枠の高さに対する比。demo は枠中央より少し上） */
const LEAD = CY;       /* 発火位置: 塊の中心が画面下端のこれだけ下（枠の高さに対する比）に来た時。
                          CY と同じ = 枠の上端が画面下端に入った時（demo の IO 発火時は 0.22 だったが、体感が遅いので前倒し） */
const FIRE_DELAY = 0;   /* 発火から開くまでの待ち（demo は 400ms。体感が遅いので 0 に） */

function init() {
  const secs = document.querySelectorAll('.future');
  if (!secs.length) return;
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  for (const sec of secs) setup(sec, reduce);
}

function setup(sec, reduce) {
  const box = sec.querySelector('.future__box');
  const corners = box ? [...box.querySelectorAll('.bracket__corner')] : [];
  let opened = false;

  /* クラスター位置: 各カッコを「枠の中心付近」へ寄せる平行移動量を CSS 変数で渡す */
  function layout() {
    if (!box || !corners.length) return;
    /* offset* は transform を含まない（寄せた後に呼び直しても二重にならない） */
    const cx = box.offsetWidth / 2, cy = box.offsetHeight * CY;
    for (const c of corners) {
      const s = c.offsetWidth, g = s * GAP / 2;
      const left = c.offsetLeft, top = c.offsetTop;
      const tx = c.classList.contains('bracket__corner--tl') || c.classList.contains('bracket__corner--bl')
        ? cx - g - s : cx + g;
      const ty = c.classList.contains('bracket__corner--tl') || c.classList.contains('bracket__corner--tr')
        ? cy - g - s : cy + g;
      c.style.setProperty('--cx', (tx - left).toFixed(1) + 'px');
      c.style.setProperty('--cy', (ty - top).toFixed(1) + 'px');
    }
  }

  function open() {
    if (opened) return;
    opened = true;
    sec.classList.add('is-open');
  }
  let armed = false;
  function fire() {
    if (armed) return;
    armed = true;
    if (FIRE_DELAY > 0) setTimeout(open, FIRE_DELAY); else open();
  }

  /* 動きを減らす設定なら何もしない（デザインの静止状態のまま） */
  if (reduce) return;

  /* 初期状態（寄せ・非表示）を付けてから transition を有効にする（付けた瞬間にアニメしないよう 1 フレーム空ける） */
  layout();
  sec.classList.add('is-fx');
  requestAnimationFrame(() => requestAnimationFrame(() => sec.classList.add('is-ready')));

  /* 発火: カッコの塊の中心が画面下端の少し下（LEAD）まで来た時。demo は IntersectionObserver（セクション 4 割可視）で
     発火し、その瞬間の塊はまだ下端の 128px 下にある（demo のセクションは上の余白が大きい）。うちはセクションの比率が
     違うので塊の位置で揃える。判定は demo と同じく rAF で毎フレーム（IO と scroll は保険）。発火 → 0.4s → 開く */
  {
    const target = box || sec;
    const trigY = () => target.offsetHeight * (CY - LEAD);   /* 枠上端からこの距離の点が画面下端に来たら発火 */
    const chk = () => {
      if (armed) return true;
      const r = target.getBoundingClientRect();
      if (r.top + trigY() < window.innerHeight && r.bottom > 0) fire();
      return armed;
    };
    try {
      const io = new IntersectionObserver((es) => {
        for (const e of es) if (e.isIntersecting) { io.disconnect(); chk(); }
      }, { rootMargin: '0px 0px -' + Math.round(trigY()) + 'px 0px', threshold: 0 });
      io.observe(target);
    } catch (e) { fire(); }
    window.addEventListener('scroll', chk, { passive: true });
    (function loop() { if (!chk()) requestAnimationFrame(loop); })();
  }

  /* 開く前のリサイズは寄せ量を取り直す（開いた後は 0 なので不要） */
  window.addEventListener('resize', () => { if (!opened) layout(); });
  window.addEventListener('load', () => { if (!opened) layout(); });

  window.__fvFuture = window.__fvFuture || [];
  window.__fvFuture.push({ sec, layout, open, fire, get opened() { return opened; }, get armed() { return armed; } });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
