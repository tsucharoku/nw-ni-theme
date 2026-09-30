/* ==========================================================================
   footer-insight.js — フッターの Insight 筆記体（.footer__deco）を FV のコピーと同じ動きで登場させる

   デモ（デモ/NI_TOP.html「Footer Insight hand-drawn draw-on (355:3073)」）の移植。
   デモは SVG の clipPath を斜めのポリゴンで左→右に掃くが、ここでは <img> のまま CSS clip-path の
   ポリゴンを同じ形で動かす（見た目は同じ。SVG をインライン化しない）。
   - 縁の傾き・イージング・長さは FV のコピー（fv-copy.js の手書きドロー: ez / REV_DUR = 850ms /
     画面上で上端が先行する斜めの縁）に合わせた。デモのフッターは 1700ms・easeInOutCubic だったが、
     「FV と同じ動き」にする指示で FV の値を採用
   - きっかけ: フッターが画面に 12% 入ったら 600ms 後に 1 回だけ（デモと同じ）
   - 動き抑制（prefers-reduced-motion）では静止のまま。JS が無ければ静止のまま
   ========================================================================== */
(function () {
  var DUR = 850;          /* fv-copy.js の REV_DUR と同じ */
  var SLANT = 0.073;      /* 縁の傾き: 画像の高さぶんで幅の 7.3% ずれる（FV のシェーダ rxr = x + (y-0.5)*0.12 を文字の高さに換算） */
  var DELAY = 600;        /* デモと同じ（フッターが見えてから） */
  var ez = function (x) { return x < 0 ? 0 : x > 1 ? 1 : x * x * (3 - 2 * x); };

  var footer = document.querySelector('.footer');
  var decos = footer ? [].slice.call(footer.querySelectorAll('.footer__deco')) : [];
  if (!decos.length) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  /* 縁の位置 k（0: 全部隠す〜1: 全部見せる）でクリップを切る。上端が先行する斜めの縁 */
  function clip(k) {
    var s = SLANT * 50;                                   /* 片側の傾き（% 幅） */
    var x = -s + (100 + 2 * s) * k;                       /* 縁の中心 x（% 幅） */
    var v = 'polygon(0 0,' + (x + s) + '% 0,' + (x - s) + '% 100%,0 100%)';
    for (var i = 0; i < decos.length; i++) decos[i].style.clipPath = v;
  }
  clip(0);

  var played = false;
  function play() {
    if (played) return;
    played = true;
    var t0 = null;
    function fr(now) {
      if (t0 === null) t0 = now;
      var p = ez(Math.min(1, (now - t0) / DUR));
      clip(p);
      if (p < 1) requestAnimationFrame(fr);
      else for (var i = 0; i < decos.length; i++) decos[i].style.clipPath = '';
    }
    requestAnimationFrame(fr);
  }

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (es) {
      for (var i = 0; i < es.length; i++) {
        if (es[i].isIntersecting) { io.disconnect(); setTimeout(play, DELAY); break; }
      }
    }, { threshold: 0.12 });
    io.observe(footer);
  } else {
    var onScroll = function () {
      if (footer.getBoundingClientRect().top < window.innerHeight * 0.9) {
        window.removeEventListener('scroll', onScroll);
        setTimeout(play, DELAY);
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  window.__footerInsight = { play: play, clip: clip };
})();
