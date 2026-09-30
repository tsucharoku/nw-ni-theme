/* ==========================================================================
   fv-scroll.js — FV のスクロール進行度とイントロの時計（ni-logo.js / fv-copy.js で共用）

   デモ（デモ/NI_TOP.html）の __fvP / __introK と同じもの。
   - 進行度 p: スクロール量（余白 220vh - 1 画面 = 120vh を total とする。デモの scroll-wrap と同じ）を
     非線形にマップ（前半 0〜0.36 で FV の演出、終端 tailPx はせり上がり用）し、
     慣性（inertia）をかけて毎フレーム追従させる
   - イントロ introK: 最初の描画から introDelay 後、introDur かけて 0→1（easeOutCubic）。ロゴが下から入る
   基準要素は [data-fv-scroll]（FV が画面固定のページで直後に置く余白）。なければ .hero 自身。
   どちらもないページ（TOP 扉）は 1 画面ぶんのスクロール量を total にする。
   ========================================================================== */
export const fv = {
  P: {
    tailPx: 300,      /* デモ: min(total*0.45, max(160, s1Over||300)) */
    inertia: 0.085,   /* 慣性: 全モーションがホイールに遅れて追従（60fps で 1 フレームに 8.5% 近づく ≒ 0.2 秒で追いつく） */
    inertiaSP: 0.16,  /* SP（〜767px）は速め（≒ 0.1 秒）。演出区間が約 400px と短く、0.085 だと弾いたときに追いつかない感じが出る（2026-09-17）。調整はここ */
    introDelay: 770,  /* デモ: HOLD 180 + EYE_D 820*0.72 (ms) */
    introDur: 750     /* デモ: LOGO_D (ms) */
  },
  pT: 0,        /* 慣性なしの生値 */
  p: 0,         /* 慣性つき（デモの __fvP） */
  introK: 0,    /* デモの __introK */
  ref: null,
  _last: -1,
  _t0: null,

  init() {
    if (this._inited) return this;
    this._inited = true;
    this.ref = document.querySelector('[data-fv-scroll]') || document.querySelector('.hero[data-anim="fv"]');
    const at = performance.now();
    /* リロード時のスクロール位置復元はこのモジュールの実行より後に起きることがある（p が 0 から慣性で追いつく間、
       FV のコピーや写真が見えてしまう）。開始直後の大きなジャンプは慣性なしで即追従する */
    window.addEventListener('scroll', () => {
      this.read();
      if (performance.now() - at < 1500 && Math.abs(this.pT - this.p) > 0.1) this.p = this.pT;
    }, { passive: true });
    const snap = () => { this.read(); this.p = this.pT; };
    window.addEventListener('load', snap);
    window.addEventListener('pageshow', snap);
    snap();   /* リロード時にスクロール位置が途中でも、そこから始める */
    return this;
  },

  read() {
    /* デモ: total = scroll-wrap の高さ - 1 画面。余白（220vh）なら 120vh ぶんが演出区間 */
    let total, px;
    if (this.ref) {
      const isSpacer = this.ref.hasAttribute('data-fv-scroll');
      total = Math.max(1, isSpacer ? this.ref.offsetHeight - window.innerHeight : this.ref.offsetHeight);
      px = Math.min(total, Math.max(0, -this.ref.getBoundingClientRect().top));
    } else {
      total = Math.max(1, window.innerHeight);
      px = Math.min(total, Math.max(0, window.scrollY));
    }
    const tailPx = Math.min(total * 0.45, Math.max(160, this.P.tailPx));
    const A = Math.max(1, total - tailPx);
    const v = px <= A ? (px / A) * 0.36 : 0.36 + ((px - A) / tailPx) * 0.64;
    this.pT = Math.max(0, Math.min(1, v));
  },

  /* 進行度 p になるスクロール量（px）。read() の逆写像 */
  scrollAt(p) {
    let total;
    if (this.ref) {
      const isSpacer = this.ref.hasAttribute('data-fv-scroll');
      total = Math.max(1, isSpacer ? this.ref.offsetHeight - window.innerHeight : this.ref.offsetHeight);
    } else {
      total = Math.max(1, window.innerHeight);
    }
    const tailPx = Math.min(total * 0.45, Math.max(160, this.P.tailPx));
    const A = Math.max(1, total - tailPx);
    return p <= 0.36 ? (p / 0.36) * A : A + ((p - 0.36) / 0.64) * tailPx;
  },

  /* 毎フレーム呼ぶ。慣性は経過時間ベース（2026-09-17）: 以前は 1 回の呼び出しごとに 8.5% 近づけていたので、fps が落ちると
     遅れが何倍にも伸びて「遅れて一気に追いつく」動きになり（iPhone の Have Fun! が急に出てくる原因）、各モジュールが別々の
     performance.now() で呼ぶぶん 1 フレームに何回も進んでもいた。60fps のとき 1 フレームあたり 8.5%（従来と同じ）になる係数を
     経過時間から出す。SP も慣性あり（一時「SP は慣性なし」にしたが、SP は演出区間が約 400px と短く、慣性がないと少し速く弾いただけで
     写真の散り・ロゴの移動・青いフレーム・Insight の消え・Have Fun! の登場が途中を飛ばして瞬間的に出入りした。2026-09-17）。
     なお iOS は慣性スクロール中に WebGL が描画していると fps が 3〜5 に落ちるため、フリック時は演出が粗くなる（未解決。
     フリック中は描画を止めて後で追いつかせる実験はタイミングが不自然で不採用） */
  inertia() {
    if (this._sp === undefined) this._sp = window.matchMedia('(max-width: 767px)').matches;
    return this._sp ? this.P.inertiaSP : this.P.inertia;
  },
  tick(now) {
    if (now === this._last) return;
    if (this._t0 === null) this._t0 = now;
    const dt = this._last < 0 ? 1000 / 60 : Math.max(0, Math.min(100, now - this._last));
    this._last = now;
    this.p += (this.pT - this.p) * (1 - Math.pow(1 - this.inertia(), dt / (1000 / 60)));
    const u = Math.max(0, Math.min(1, (now - this._t0 - this.P.introDelay) / this.P.introDur));
    this.introK = 1 - Math.pow(1 - u, 3);
  }
};

fv.init();
window.__fv = fv;
