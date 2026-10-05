/* ==========================================================================
   form.js — フォーム
   Contact Form 7 のフォーム（.wpcf7 > form.wpcf7-form。募集要項詳細のエントリー、カジュアル面談）に対して動く。
   必須チェック・同意で送信可・送信は CF7 本体、メールアドレス（確認用）の一致は inc/cf7.php。

   [A] select / date が空の間 .is-empty を付ける（プレースホルダーと同じグレーにするため。form.css）
   [C] 送信できたら完了ページ（form の data-thanks。inc/cf7.php が付ける）へ移動
   ========================================================================== */
(function () {
  'use strict';

  var forms = document.querySelectorAll('.wpcf7 form.wpcf7-form');
  if (!forms.length) return;

  var each = function (list, fn) { Array.prototype.forEach.call(list, fn); };

  /* ---------- [A] 空の select / date をグレーに ---------- */
  each(document.querySelectorAll('.wpcf7-select, .wpcf7-date'), function (el) {
    var sync = function () { el.classList.toggle('is-empty', !el.value); };
    el.addEventListener('change', sync);
    el.addEventListener('input', sync);
    sync();
  });

  /* ---------- [C] 送信完了で完了ページへ ---------- */
  document.addEventListener('wpcf7mailsent', function (e) {
    var form = e.target.closest('form.wpcf7-form') || e.target.querySelector('form.wpcf7-form');   /* CF7 は form に投げる（版によっては外側の .wpcf7） */
    var thanks = form && form.getAttribute('data-thanks');
    if (thanks) window.location.href = thanks;
  });
})();
