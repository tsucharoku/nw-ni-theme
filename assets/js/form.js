/* ==========================================================================
   form.js — フォーム
   Contact Form 7 の出力 DOM（.wpcf7 > form.wpcf7-form）に対して動く。
   本物の CF7 のフォーム（隠し項目 _wpcf7 がある。募集要項詳細）と、静的なまま置いているフォーム（カジュアル面談）の両方がある。

   [A] 見た目の補助（WP 化しても残す）
       select / date が空の間 .is-empty を付ける（プレースホルダーと同じグレーにするため。form.css）
   [B] 静的版だけの代用（WP 化したら不要。CF7 本体が同じことをするので [B] は丸ごと消す）
       - 同意（.wpcf7-acceptance）にチェックが入るまで送信ボタンを disabled（CF7 の acceptance と同じ挙動）
       - 必須（.wpcf7-validates-as-required）の簡易チェック。未入力なら CF7 と同じ
         .wpcf7-not-valid + <span class="wpcf7-not-valid-tip"> を出して送信を止め、form を invalid に
       - メールアドレス（確認用）が一致しているか（CF7 では追加のバリデーションで行う）
       - OK なら form の action（./thanks/）へ移動。入力値は URL に付けない（静的版は送信先が無いため）
       本物の CF7 のフォームでは動かさない（CF7 本体と inc/cf7.php が同じことをする）
   [C] 本物の CF7 のフォーム: 送信できたら完了ページ（form の data-thanks。inc/cf7.php が付ける）へ移動
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

  /* ---------- [C] 本物の CF7 のフォーム: 送信完了で完了ページへ ---------- */
  document.addEventListener('wpcf7mailsent', function (e) {
    var form = e.target.closest('form.wpcf7-form') || e.target.querySelector('form.wpcf7-form');   /* CF7 は form に投げる（版によっては外側の .wpcf7） */
    var thanks = form && form.getAttribute('data-thanks');
    if (thanks) window.location.href = thanks;
  });

  /* ---------- [B] 静的版だけの代用 ---------- */
  var MSG_REQUIRED = '入力してください。';
  var MSG_EMAIL = 'メールアドレスの形式が正しくありません。';
  var MSG_CONFIRM = 'メールアドレスが一致しません。';
  var MSG_INVALID = '入力内容に問題があります。確認して再度お試しください。';

  each(forms, function (form) {
    if (form.querySelector('input[name="_wpcf7"]')) return;   /* 本物の CF7 のフォーム */

    var submit = form.querySelector('.wpcf7-submit');
    var accepts = form.querySelectorAll('.wpcf7-acceptance input[type="checkbox"]');
    var output = form.querySelector('.wpcf7-response-output');

    /* 同意が入るまで送信不可 */
    var syncAccept = function () {
      if (!submit) return;
      var ok = true;
      each(accepts, function (c) { if (!c.checked) ok = false; });
      submit.disabled = !ok;
    };
    each(accepts, function (c) { c.addEventListener('change', syncAccept); });
    syncAccept();

    var wrapOf = function (el) {
      while (el && !(el.classList && el.classList.contains('wpcf7-form-control-wrap'))) el = el.parentNode;
      return el;
    };

    var clearTip = function (control) {
      var wrap = wrapOf(control);
      control.classList.remove('wpcf7-not-valid');
      each(control.querySelectorAll ? control.querySelectorAll('input') : [], function (i) { i.removeAttribute('aria-invalid'); });
      control.removeAttribute('aria-invalid');
      if (!wrap) return;
      var tip = wrap.querySelector('.wpcf7-not-valid-tip');
      if (tip) wrap.removeChild(tip);
    };

    var setTip = function (control, message) {
      var wrap = wrapOf(control);
      clearTip(control);
      control.classList.add('wpcf7-not-valid');
      control.setAttribute('aria-invalid', 'true');
      if (!wrap) return;
      var tip = document.createElement('span');
      tip.className = 'wpcf7-not-valid-tip';
      tip.setAttribute('aria-hidden', 'true');
      tip.textContent = message;
      wrap.appendChild(tip);
    };

    var isEmpty = function (control) {
      if (control.classList.contains('wpcf7-checkbox') || control.classList.contains('wpcf7-radio')) {
        return !control.querySelector('input:checked');
      }
      if (control.type === 'file') return !control.files || !control.files.length;
      return !String(control.value || '').trim();
    };

    var validate = function (control) {
      if (control.classList.contains('wpcf7-validates-as-required') && isEmpty(control)) {
        setTip(control, MSG_REQUIRED);
        return false;
      }
      if (control.classList.contains('wpcf7-validates-as-email') && control.value &&
          !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(control.value.trim())) {
        setTip(control, MSG_EMAIL);
        return false;
      }
      var target = control.getAttribute('data-confirm');   /* 確認用: data-confirm="相手の name" */
      if (target && form.elements[target] && control.value !== form.elements[target].value) {
        setTip(control, MSG_CONFIRM);
        return false;
      }
      clearTip(control);
      return true;
    };

    var controls = form.querySelectorAll('.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-acceptance)');

    /* 一度エラーを出した項目は、直したらその場で消す */
    each(controls, function (control) {
      var recheck = function () {
        if (control.classList.contains('wpcf7-not-valid')) validate(control);
      };
      control.addEventListener('input', recheck);
      control.addEventListener('change', recheck);
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var firstBad = null;
      each(controls, function (control) {
        if (!validate(control) && !firstBad) firstBad = control;
      });

      if (firstBad) {
        form.classList.remove('init', 'sent');
        form.classList.add('invalid');
        form.setAttribute('data-status', 'invalid');
        if (output) {
          output.textContent = MSG_INVALID;
          output.removeAttribute('aria-hidden');
        }
        var focusTo = firstBad.matches('input, select, textarea') ? firstBad : firstBad.querySelector('input');
        if (focusTo) focusTo.focus();   /* ブラウザが見える位置までスクロールする（JS でスクロール位置は触らない） */
        return;
      }

      window.location.href = form.getAttribute('action') || './thanks/';
    });
  });
})();
