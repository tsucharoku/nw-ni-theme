/* ==========================================================================
   fv-unfold.js — 中途 FV コピーの登場（文字が横に開く）

   デザイナー支給のサンプル「Unfold Horizontal」の移植:
   - 見出し（.hero__title）を 1 文字ずつ <span class="hero__char"> に分け、rotateY(-90deg)・透明 → rotateY(0)・不透明 を
     0.6s（UNFOLD_DUR）で。開始は 1 文字あたり 0.05s（STAGGER）ずつ遅らせ、左から右へ順に起き上がる。
     行は並行に動かす: 2 行目以降は行ごとに LINE_DELAY（0.25s）ずつ遅れて始まり、各行の中で左から順に開く
     （全文を直列にすると長すぎるため。行はレイアウト上の位置（offsetTop）で判定するので PC / SP の改行差もそのまま）。
     サンプルは perspective なし（平面的に幅が広がる）だが、指示により見出しに perspective を付けて扉のように回す（CSS 側）
   - サブコピー（.hero__sub）は小さいのでまとめてゆっくりフェードイン（見出しの最後に動き出す文字と同時に始まり 1.6s = SUB_DUR）
   - 開始は読み込み直後。文字幅が確定してから動かしたいので Web フォントの確定（document.fonts.ready）を待つ（最大 FONT_WAIT ms）。
     JS が動くまでのちらつき防止に head のインラインスクリプトが html.is-fv-unfold を付け、CSS で分割前の見出し・サブを隠す
   - 見出しのグラデ文字: 文字ごとの span に同じグラデを敷き、background-size を見出しの幅・background-position を文字の位置ぶんずらして
     行全体で 1 本のグラデに見せる（transform した子には親の background-clip: text が効かないため）。リサイズで測り直す
   - <br>（PC / SP の改行）はそのまま残す。prefers-reduced-motion / ?capture では動かさない（head 側で is-fv-unfold を付けない）
   ========================================================================== */
(function () {
  var STAGGER = 0.05, LINE_DELAY = 0.25, UNFOLD_DUR = 0.6, SUB_DUR = 1.6, FONT_WAIT = 1500;

  function init() {
    if (!document.documentElement.classList.contains('is-fv-unfold')) return;
    var hero = document.querySelector('.hero[data-fv-static]');
    var title = hero && hero.querySelector('.hero__title');
    var sub = hero && hero.querySelector('.hero__sub');
    if (!title) return;

    /* 1 文字ずつ span に。要素（br）は残す */
    var chars = [];
    Array.prototype.slice.call(title.childNodes).forEach(function (node) {
      if (node.nodeType !== 3) return;
      var frag = document.createDocumentFragment();
      Array.prototype.forEach.call(node.textContent, function (ch) {   /* サロゲートペアも 1 文字として扱う */
        var s = document.createElement('span');
        s.className = 'hero__char';
        s.textContent = ch;
        frag.appendChild(s);
        chars.push(s);
      });
      title.replaceChild(frag, node);
    });
    title.classList.add('is-split');

    /* 遅れ: 行ごとに LINE_DELAY、行の中で 1 文字 STAGGER。行は offsetTop で判定（transform の影響を受けない）。最後に動き出す文字の遅れを返す */
    function setDelays() {
      var lines = [], tops = [];
      chars.forEach(function (s) {
        var top = Math.round(s.offsetTop / 4);   /* 4px 以内のずれは同じ行 */
        var li = tops.indexOf(top);
        if (li < 0) { li = tops.length; tops.push(top); lines.push([]); }
        lines[li].push(s);
      });
      var last = 0;
      lines.forEach(function (line, li) {
        line.forEach(function (s, i) {
          var d = li * LINE_DELAY + i * STAGGER;
          s.style.animationDelay = d.toFixed(2) + 's';
          if (d > last) last = d;
        });
      });
      return last;
    }

    /* グラデを行全体で 1 本に: 各文字の背景を見出しの幅にし、文字の位置ぶん左へずらす（offsetLeft は transform の影響を受けない） */
    function fitGradient() {
      var w = title.clientWidth;
      var base = title.offsetLeft;
      chars.forEach(function (s) {
        s.style.backgroundSize = w + 'px 100%';
        s.style.backgroundPosition = (base - s.offsetLeft) + 'px 0';
      });
    }

    function start() {
      if (title.classList.contains('is-play')) return;
      fitGradient();
      var last = setDelays();
      title.classList.add('is-play');
      if (sub) {
        sub.style.animationDelay = last.toFixed(2) + 's';
        sub.style.animationDuration = SUB_DUR + 's';
        sub.classList.add('is-in');
      }
    }
    var ready = document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve();
    var timer = setTimeout(start, FONT_WAIT);
    ready.then(function () { clearTimeout(timer); start(); });
    window.addEventListener('resize', fitGradient);

    window.__fvUnfold = { chars: chars, start: start, fitGradient: fitGradient, UNFOLD_DUR: UNFOLD_DUR, STAGGER: STAGGER, LINE_DELAY: LINE_DELAY };
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
