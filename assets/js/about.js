/* ==========================================================================
   about.js — 3分でわかる日本インフォメーション
   - <html> に js-anim を付ける（about.css の登場アニメはこのクラスがあるときだけ隠す）
     prefers-reduced-motion / IntersectionObserver なしでは付けない（最初から表示）
   ========================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce || !('IntersectionObserver' in window)) return;

  document.documentElement.classList.add('js-anim');
})();
