/* ==========================================================================
   about.js — 3分でわかる日本インフォメーション
   - <html> に js-anim を付ける（about.css の登場アニメはこのクラスがあるときだけ隠す）
   - [data-count]: 画面に入ったら 0 → 値へカウントアップ
       <span class="num-card__value" data-count="2000">2,000</span>
       表示の書式（桁区切りのカンマ・小数の桁数）は元のテキストから読む。WP では値とテキストの両方を出力する
       prefers-reduced-motion / IntersectionObserver なしでは何もしない（最初から値が出ている）
   ========================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce || !('IntersectionObserver' in window)) return;

  document.documentElement.classList.add('js-anim');

  var DURATION = 1400;
  var els = document.querySelectorAll('[data-count]');
  if (!els.length) return;

  function format(n, decimals, comma) {
    var s = n.toFixed(decimals);
    if (!comma) return s;
    var parts = s.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
  }

  function run(el) {
    var st = el._count;
    var t0 = null;
    function tick(now) {
      if (t0 === null) t0 = now;
      var p = Math.min((now - t0) / DURATION, 1);
      var e = 1 - Math.pow(1 - p, 3);   // easeOutCubic
      el.textContent = p < 1 ? format(st.to * e, st.decimals, st.comma) : st.text;
      if (p < 1) requestAnimationFrame(tick);
      else el.style.minWidth = '';
    }
    requestAnimationFrame(tick);
    // rAF が止まる状況（背景タブなど）でも 0 のまま残さない
    setTimeout(function () {
      el.textContent = st.text;
      el.style.minWidth = '';
    }, DURATION + 300);
  }

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      io.unobserve(entry.target);
      run(entry.target);
    });
  }, { threshold: 0, rootMargin: '0px 0px -15% 0px' });   // lower.js の inview と同じタイミング

  Array.prototype.forEach.call(els, function (el) {
    var to = parseFloat(el.getAttribute('data-count'));
    if (isNaN(to)) return;
    var text = el.textContent;
    var dot = text.indexOf('.');
    el._count = {
      to: to,
      text: text,
      decimals: dot === -1 ? 0 : text.length - dot - 1,
      comma: text.indexOf(',') !== -1
    };
    // 数えている間にカードの幅（内容なり）が動かないよう、最終値の幅を確保してから 0 にする
    el.style.minWidth = el.getBoundingClientRect().width + 'px';
    el.textContent = format(0, el._count.decimals, false);
    io.observe(el);
  });
})();
