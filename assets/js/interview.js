/* ==========================================================================
   interview.js — 社員インタビュー一覧の絞り込み + もっと見る（カードは archive-interview.php が全件出力する）
   - .js-interview-filter の [data-filter-group] ごとに条件を持つ。グループ間は AND
     - 通常のグループ（年次 / 職種）: 単一選択。「すべて」（data-filter-value=""）で解除
     - data-filter-multi のグループ（タグ）: 複数選択のトグル。選んだタグをすべて持つカードだけ残す
   - カード（.js-interview-item）は data-type / data-job / data-tags（タームの ID、空白区切り）で判定
   - .js-interview-list の data-per-page 件ずつ表示し、.js-interview-more で追加。条件を変えたら先頭に戻す
   ========================================================================== */
(function () {
  'use strict';

  var list = document.querySelector('.js-interview-list');
  if (!list) return;

  var items = Array.prototype.slice.call(list.querySelectorAll('.js-interview-item'));
  var filter = document.querySelector('.js-interview-filter');
  var groups = filter ? Array.prototype.slice.call(filter.querySelectorAll('[data-filter-group]')) : [];
  var moreBtn = document.querySelector('.js-interview-more');
  var moreWrap = moreBtn && moreBtn.parentNode;
  var moreNext = document.querySelector('.js-interview-more-next');
  var moreStatus = document.querySelector('.js-interview-more-status');
  var empty = document.querySelector('.js-interview-empty');
  var perPage = parseInt(list.getAttribute('data-per-page'), 10) || 12;
  var limit = perPage;
  var state = {};   // { type: 'new', job: '', tags: ['remote'] }

  function values(item, key) {
    return (item.getAttribute('data-' + key) || '').split(/\s+/).filter(Boolean);
  }

  function match(item, except) {
    return Object.keys(state).every(function (key) {
      if (key === except) return true;
      var want = state[key];
      var have = values(item, key);
      if (Array.isArray(want)) {
        return want.every(function (v) { return have.indexOf(v) !== -1; });
      }
      return !want || have.indexOf(want) !== -1;
    });
  }

  /* 件数 (n): ほかのグループの条件を満たすカードのうち、その値を持つものの数 */
  function updateCounts() {
    groups.forEach(function (group) {
      var key = group.getAttribute('data-filter-group');
      Array.prototype.forEach.call(group.querySelectorAll('[data-filter-value]'), function (btn) {
        var count = btn.querySelector('.js-filter-count');
        var value = btn.getAttribute('data-filter-value');
        if (!count || !value) return;
        var n = items.filter(function (item) {
          return match(item, key) && values(item, key).indexOf(value) !== -1;
        }).length;
        count.textContent = '(' + n + ')';
      });
    });
  }

  function render(animateFrom) {
    var matched = items.filter(function (item) { return match(item); });
    var shown = Math.min(limit, matched.length);

    items.forEach(function (item) {
      var index = matched.indexOf(item);
      var visible = index !== -1 && index < shown;
      var wasHidden = item.hidden;
      item.hidden = !visible;
      item.classList.remove('is-enter');
      if (visible && animateFrom != null && (wasHidden || animateFrom === 0) && index >= animateFrom) {
        item.style.animationDelay = Math.min(index - animateFrom, 11) * 40 + 'ms';
        void item.offsetWidth;   // アニメをやり直す
        item.classList.add('is-enter');
      }
    });

    if (empty) empty.hidden = matched.length > 0;
    if (moreWrap) moreWrap.hidden = shown >= matched.length;
    if (moreNext) moreNext.textContent = '次の' + Math.min(perPage, matched.length - shown) + '件をみる';
    if (moreStatus) moreStatus.textContent = shown + ' / ' + matched.length + '件表示中';
  }

  groups.forEach(function (group) {
    var key = group.getAttribute('data-filter-group');
    var multi = group.hasAttribute('data-filter-multi');
    var buttons = Array.prototype.slice.call(group.querySelectorAll('[data-filter-value]'));
    state[key] = multi ? [] : '';

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var value = btn.getAttribute('data-filter-value');
        if (multi) {
          var at = state[key].indexOf(value);
          if (at === -1) state[key].push(value);
          else state[key].splice(at, 1);
        } else {
          state[key] = value;
        }
        buttons.forEach(function (b) {
          var v = b.getAttribute('data-filter-value');
          var on = multi ? state[key].indexOf(v) !== -1 : state[key] === v;
          b.classList.toggle('is-active', on);
          b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        limit = perPage;
        updateCounts();
        render(0);
      });
    });
  });

  if (moreBtn) {
    moreBtn.addEventListener('click', function () {
      var from = limit;
      limit += perPage;
      render(from);
    });
  }

  updateCounts();
  render(null);
})();
