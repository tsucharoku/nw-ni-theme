/* ==========================================================================
   job-opening.js — 募集要項 カテゴリアーカイブ / 詳細
   - 「次の 10 件をみる」は lower.js の .js-more
   - .entry-content .wp-block-video: Figma の再生ボタン付きポスター。
     controls を外して is-poster を付け、クリックで再生 + controls を戻す（JS が無ければ素の controls のまま）
   ========================================================================== */
(function () {
  'use strict';

  /* ---------- 動画のポスター + 再生ボタン ---------- */
  Array.prototype.forEach.call(document.querySelectorAll('.entry-content .wp-block-video'), function (fig) {
    var video = fig.querySelector('video');
    if (!video || video.autoplay) return;
    video.controls = false;
    fig.classList.add('is-poster');
    fig.tabIndex = 0;
    fig.setAttribute('role', 'button');
    fig.setAttribute('aria-label', '動画を再生');

    function start() {
      fig.removeEventListener('click', start);
      fig.removeEventListener('keydown', onKey);
      fig.classList.remove('is-poster');
      fig.removeAttribute('tabindex');
      fig.removeAttribute('role');
      fig.removeAttribute('aria-label');
      video.controls = true;
      var p = video.play();
      if (p && p.catch) p.catch(function () {});
    }
    function onKey(e) {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      start();
    }
    fig.addEventListener('click', start);
    fig.addEventListener('keydown', onKey);
  });
})();
