/* ==========================================================================
   development.js — 教育・研修・キャリアパス
   - <html> に js-anim を付ける（development.css の登場アニメはこのクラスがあるときだけ隠す）
   - .js-growth-scroll: 成長ステップの横スクロールをマウスのドラッグでも動かせるようにする
     （タッチ・ホイール・キーボードはブラウザ標準のスクロール。タブ切替は common.js の .js-tabs）
   ========================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!reduce && 'IntersectionObserver' in window) {
    document.documentElement.classList.add('js-anim');
  }

  Array.prototype.forEach.call(document.querySelectorAll('.js-growth-scroll'), function (el) {
    var startX = 0;
    var startLeft = 0;
    var dragging = false;
    var moved = false;

    el.addEventListener('pointerdown', function (e) {
      if (e.pointerType !== 'mouse' || e.button !== 0) return;
      dragging = true;
      moved = false;
      startX = e.clientX;
      startLeft = el.scrollLeft;
    });

    window.addEventListener('pointermove', function (e) {
      if (!dragging) return;
      var dx = e.clientX - startX;
      if (!moved && Math.abs(dx) < 4) return;
      moved = true;
      el.classList.add('is-dragging');
      el.scrollLeft = startLeft - dx;
    });

    function end() {
      dragging = false;
      el.classList.remove('is-dragging');
    }
    window.addEventListener('pointerup', end);
    window.addEventListener('pointercancel', end);
  });
})();
