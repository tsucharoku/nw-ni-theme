/* ==========================================================================
   lower.js — 下層ページ共通
   - [data-anim="inview"]: 画面に入ったら is-inview（出現アニメの差し込み口。CSS 側で使う）
   - .js-more: 「次の N 件をみる」
   - .js-accordion: FAQ などの開閉（button[aria-expanded] + 直後のパネル）
   ========================================================================== */
(function () {
  'use strict';

  /* ---------- 出現 ---------- */
  var targets = document.querySelectorAll('[data-anim="inview"]');
  if (targets.length) {
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-inview');
          io.unobserve(entry.target);
        });
      }, { threshold: 0, rootMargin: '0px 0px -15% 0px' });
      Array.prototype.forEach.call(targets, function (el) { io.observe(el); });
    } else {
      Array.prototype.forEach.call(targets, function (el) { el.classList.add('is-inview'); });
    }
  }

  /* ---------- 次の N 件をみる（.more-btn.js-more） ----------
     <button class="more-btn js-more" aria-controls="一覧の id" data-step="10">…<span class="js-more-label"></span>…<span class="js-more-count"></span>…</button>
     一覧の直下の要素を data-step 件ずつ出し、文言と件数を更新。全件出たらボタンを消し、親に is-done を付ける。
     静的 HTML 用。WP では同じマークアップのまま Ajax / ページ送りに差し替える */
  Array.prototype.forEach.call(document.querySelectorAll('.js-more'), function (btn) {
    var list = document.getElementById(btn.getAttribute('aria-controls'));
    if (!list) return;
    var items = list.children;
    var step = parseInt(btn.getAttribute('data-step'), 10) || 10;
    var label = btn.querySelector('.js-more-label');
    var count = btn.querySelector('.js-more-count');
    var shown = 0;

    function render(n, focus) {
      var first = null;
      shown = Math.min(n, items.length);
      Array.prototype.forEach.call(items, function (li, i) {
        if (li.hidden && i < shown && !first) first = li;
        li.hidden = i >= shown;
      });
      var rest = items.length - shown;
      if (label) label.textContent = '次の' + Math.min(step, rest) + '件をみる';
      if (count) count.textContent = shown + ' / ' + items.length + '件表示中';
      btn.hidden = rest <= 0;
      if (btn.parentNode) btn.parentNode.classList.toggle('is-done', rest <= 0);
      if (focus && first) {
        var a = first.querySelector('a[href]');
        if (a) a.focus({ preventScroll: true });
      }
    }

    render(step, false);
    btn.addEventListener('click', function () { render(shown + step, true); });
  });

  /* ---------- アコーディオン ----------
     <div class="js-accordion"><button aria-expanded="false" aria-controls="id">…</button><div id="id" hidden>…</div></div>
     高さのアニメは grid-template-rows ではなく実測（Safari 対応）。 */
  Array.prototype.forEach.call(document.querySelectorAll('.js-accordion'), function (root) {
    var btn = root.querySelector('button[aria-controls]');
    var panel = btn && document.getElementById(btn.getAttribute('aria-controls'));
    if (!btn || !panel) return;

    function set(open) {
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      root.classList.toggle('is-open', open);
      if (open) {
        panel.hidden = false;
        panel.style.height = '0px';
        panel.offsetHeight; // reflow
        panel.style.height = panel.scrollHeight + 'px';
      } else {
        panel.style.height = panel.scrollHeight + 'px';
        panel.offsetHeight;
        panel.style.height = '0px';
      }
    }

    panel.style.overflow = 'hidden';
    panel.style.transition = 'height 0.3s ease';
    panel.addEventListener('transitionend', function (e) {
      if (e.propertyName !== 'height') return;
      if (btn.getAttribute('aria-expanded') === 'true') panel.style.height = '';
      else panel.hidden = true;
    });

    if (btn.getAttribute('aria-expanded') === 'true') root.classList.add('is-open');
    else panel.hidden = true;

    btn.addEventListener('click', function () {
      set(btn.getAttribute('aria-expanded') !== 'true');
    });
  });
})();
