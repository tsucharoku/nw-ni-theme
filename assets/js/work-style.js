/* ==========================================================================
   work-style.js — 制度・環境（/work-style/）
   - .js-photo-marquee: 写真の帯。中身を 1 組複製して is-loop を付ける（流すのは CSS アニメ）
   - .js-arc-cards: 付箋 1370:17451 のカード。参考 https://ni-communication.pages.dev と同じ考え方
     （弧 y = x² / 2R の上にカードを置き、傾きは接線に沿わせる）で、
       1) 3 枚を中央にぴったり重ねた状態（見えるのは 1 枚）から
       2) 画面に入ると背後の 2 枚が左右へゆっくり開き
       3) 以後はホバーで寄る / クリック・ドラッグ・左右キーで順に入れ替わる（3 枚のループ）
     SP（〜767px）は Figma どおり縦積みで何もしない。スクロール位置は読まない（IntersectionObserver のみ）
   ========================================================================== */
(function () {
  'use strict';

  var PC = window.matchMedia('(min-width: 768px)');
  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)');

  /* ---------- 写真の帯 ---------- */
  Array.prototype.forEach.call(document.querySelectorAll('.js-photo-marquee'), function (track) {
    var items = Array.prototype.slice.call(track.children);
    // 偶数枚でないと複製後に「偶数枚目を下げる」の並びがずれる
    if (!items.length || items.length % 2) return;
    items.forEach(function (li) {
      var clone = li.cloneNode(true);
      Array.prototype.forEach.call(clone.querySelectorAll('img'), function (img) { img.loading = 'eager'; });
      track.appendChild(clone);
    });
    track.classList.add('is-loop');
  });

  /* ---------- 弧のカード ---------- */
  var root = document.querySelector('.js-arc-cards');
  if (!root) return;
  var stage = root.querySelector('.arc-cards__stage');
  var cards = Array.prototype.slice.call(stage.children);
  var N = cards.length;
  if (N < 2) return;

  // Figma（658:6715、カード幅 601 のとき）: 左右のカードは中心から ±680、38 下がって ±6°
  var BASE_W = 601;
  var STEP = 680;      // 隣のカードまでの距離
  var RADIUS = 6080;   // 弧の半径。680² / (2 × 6080) ≒ 38
  var TILT = 0.94;     // atan(680 / 6080) ≒ 6.38° → 6°
  var PULL = 0.35;     // ホバーで寄る量（参考と同じ）
  var INTRO = 400;     // 画面に入ってから開き始めるまで(ms)
  var FIRST = 1700;    // 開く動き（CSS 1.6s）が終わるまで(ms)

  var active = 0;      // 中央にいるカード（DOM 順で 0 = 中央、1 = 右、2 = 左）
  var off = 0;         // ホバー / ドラッグによる横ずれ(px)
  var spread = false;
  var enabled = false;
  var geo = { k: 1, h: 0 };

  function rel(i) {    // 中央からの位置（…,-1,0,1,…）。3 枚なら必ず左 1・中央・右 1
    var r = ((i - active) % N + N) % N;
    return r > N / 2 ? r - N : r;
  }

  function measure() {
    cards.forEach(function (c) { c.style.height = ''; });
    var w = cards[0].offsetWidth || BASE_W;
    var h = 0;
    cards.forEach(function (c) { h = Math.max(h, c.offsetHeight); });
    cards.forEach(function (c) { c.style.height = h + 'px'; });
    geo = { k: w / BASE_W, h: h };
    stage.style.height = Math.round(h + 24 * geo.k) + 'px';   // Figma: カード 799.5 に対して枠 823
  }

  function place() {
    var S = STEP * geo.k;
    var R = RADIUS * geo.k;
    cards.forEach(function (c, i) {
      var r = rel(i);
      var x = spread ? r * S + off : 0;
      var y = (x * x) / (2 * R);
      var rot = Math.atan2(x, R) * 180 / Math.PI * TILT;
      var prev = c._rel;
      c._rel = r;
      c.style.transform = 'translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px) rotate(' + rot.toFixed(2) + 'deg)';
      // 端から端へ回り込むカードは中央のカードの裏を通す
      var wrap = spread && prev !== undefined && Math.abs(prev - r) > 1;
      c.style.zIndex = r === 0 ? 3 : (wrap ? 1 : 2);
      c.classList.toggle('is-center', r === 0);
    });
  }

  function go(dir) {
    if (!spread) return;
    active = ((active + dir) % N + N) % N;
    off = 0;
    place();
  }

  function enable() {
    if (enabled) return;
    enabled = true;
    root.classList.add('is-ready');
    measure();
    place();
  }

  function disable() {
    if (!enabled) return;
    enabled = false;
    root.classList.remove('is-ready', 'is-dragging');
    stage.style.height = '';
    cards.forEach(function (c) {
      c.style.height = '';
      c.style.transform = '';
      c.style.zIndex = '';
      c._rel = undefined;
    });
  }

  function sync() { if (PC.matches) { enable(); measure(); place(); } else { disable(); } }

  /* ホバーで寄る（PC のマウスだけ） */
  cards.forEach(function (c, i) {
    c.addEventListener('mouseenter', function () {
      if (!enabled || !spread || dragging) return;
      off = -rel(i) * STEP * geo.k * PULL;
      place();
    });
  });
  stage.addEventListener('mouseleave', function () {
    if (!enabled || dragging) return;
    off = 0;
    place();
  });

  /* ドラッグ / スワイプで前後へ、動かさずに離したらそのカードを中央へ */
  var dragging = false;
  var startX = 0;
  var startY = 0;
  var moved = false;
  var downCard = -1;

  stage.addEventListener('pointerdown', function (e) {
    if (!enabled || !spread || (e.pointerType === 'mouse' && e.button !== 0)) return;
    dragging = true;
    moved = false;
    startX = e.clientX;
    startY = e.clientY;
    downCard = cards.indexOf(e.target.closest('.arc-card'));
  });

  window.addEventListener('pointermove', function (e) {
    if (!dragging) return;
    var dx = e.clientX - startX;
    if (!moved) {
      if (Math.abs(dx) < 8) return;
      if (Math.abs(e.clientY - startY) > Math.abs(dx)) { dragging = false; return; }  // 縦スクロールを優先
      moved = true;
      root.classList.add('is-dragging');
    }
    off = dx;
    place();
  });

  function end(e) {
    if (!dragging) return;
    dragging = false;
    root.classList.remove('is-dragging');
    var dx = e.clientX - startX;
    if (moved && Math.abs(dx) > 60) go(dx < 0 ? 1 : -1);
    else if (!moved && downCard > -1 && rel(downCard) !== 0) go(rel(downCard));
    else { off = 0; place(); }
  }
  window.addEventListener('pointerup', end);
  window.addEventListener('pointercancel', function () {
    if (!dragging) return;
    dragging = false;
    root.classList.remove('is-dragging');
    off = 0;
    place();
  });

  /* キーボード */
  stage.setAttribute('tabindex', '0');
  stage.setAttribute('role', 'group');
  stage.setAttribute('aria-roledescription', 'carousel');
  stage.addEventListener('keydown', function (e) {
    if (!enabled) return;
    if (e.key === 'ArrowRight') { go(1); e.preventDefault(); }
    if (e.key === 'ArrowLeft') { go(-1); e.preventDefault(); }
  });

  /* 画面に入ったら開く */
  function open() {
    setTimeout(function () {
      spread = true;
      if (enabled) place();
      setTimeout(function () { root.classList.add('is-spread'); }, REDUCED.matches ? 0 : FIRST);
    }, REDUCED.matches ? 0 : INTRO);
  }

  sync();
  if (PC.addEventListener) PC.addEventListener('change', sync);
  window.addEventListener('resize', function () { if (enabled) { measure(); place(); } });
  window.addEventListener('load', function () { if (enabled) { measure(); place(); } });

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        io.disconnect();
        open();
      });
    }, { threshold: 0.35 });
    io.observe(stage);
  } else {
    open();
  }
})();
