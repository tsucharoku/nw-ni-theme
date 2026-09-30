/* ==========================================================================
   chart.js — 仕事の相関図の枠（.js-chart-viewer）
   - PC（768px〜）: HTML の図 .chart（Figma と同じ 1248×2372px 固定）を枠の幅に合わせて縮めるだけ
                    （1248px 以上なら等倍）。操作なし
   - SP: 図の画像 .chart-pic（Figma SP の img 3、ボタンなし。表示幅 1248px を 1 倍とする）を枠に入れる。
         Figma 付箋 1370:17497「Google Map の埋め込みのように相関図部分だけピンチイン・ピンチアウト、
         自由移動できるようにする」
         ・最初は枠の内側（上下 24 / 左右 16 の余白）に幅を合わせて全体を表示
         ・2 本指のピンチで拡大・縮小（上限 = PC の実寸）、拡大中は 1 本指のドラッグで移動
         ・等倍のときの 1 本指の縦スワイプはページのスクロール（CSS の touch-action: pan-y）
         ・ダブルタップで拡大 / 元に戻す、[data-chart-reset] のボタンで元に戻す
         ・Ctrl + ホイール（トラックパッドのピンチ）とマウスのドラッグにも対応
   位置は指の動きをそのまま transform に書くだけで、スクロール量は読まない
   ========================================================================== */
(function () {
  'use strict';

  var viewer = document.querySelector('.js-chart-viewer');
  var chart = viewer && viewer.querySelector('.chart');       // PC: HTML の図
  var pic = viewer && viewer.querySelector('.chart-pic');     // SP: 図の画像
  if (!viewer || !chart || !pic) return;

  var W = 1248;                      // 1 倍のときの幅（PC の図の実寸。Figma 722:8368）
  var H_PC = 2372;                   // PC の図の高さ
  var H_SP = W * (Number(pic.getAttribute('height')) / Number(pic.getAttribute('width')) || 4096 / 2237);   // 画像の縦横比から
  var H = H_PC;                      // いまの図の高さ
  var stage = chart;                 // いま transform を当てる相手
  var PAD_X = 16, PAD_Y = 24;        // SP の枠の内側の余白（1466:20576）
  var MAX = 1;                       // 拡大の上限 = PC の実寸
  var mqPC = window.matchMedia('(min-width: 768px)');
  var resetBtn = document.querySelector('[data-chart-reset]');

  var fit = 1;                       // 全体が収まる縮尺
  var s = 1, x = 0, y = 0;           // いまの縮尺と位置（枠の内側の左上が原点）
  var boxW = 0, boxH = 0;

  function apply() {
    stage.style.transform = 'translate(' + x.toFixed(2) + 'px,' + y.toFixed(2) + 'px) scale(' + s.toFixed(5) + ')';
    var zoomed = !mqPC.matches && s > fit * 1.01;
    viewer.classList.toggle('is-zoomed', zoomed);
    if (resetBtn) resetBtn.disabled = !zoomed;
  }

  /* はみ出さないように位置を直す。図が枠より小さい向きは中央に置く */
  function clamp() {
    var w = W * s, h = H * s;
    var minX = boxW - PAD_X - w, maxX = PAD_X;
    var minY = boxH - PAD_Y - h, maxY = PAD_Y;
    x = minX > maxX ? (boxW - w) / 2 : Math.min(maxX, Math.max(minX, x));
    y = minY > maxY ? (boxH - h) / 2 : Math.min(maxY, Math.max(minY, y));
  }

  function layout() {
    var border = viewer.offsetWidth - viewer.clientWidth;
    boxW = viewer.clientWidth;
    stage = mqPC.matches ? chart : pic;
    H = mqPC.matches ? H_PC : H_SP;
    (mqPC.matches ? pic : chart).style.transform = '';
    if (mqPC.matches) {
      fit = Math.min(1, boxW / W);
      s = fit; x = 0; y = 0;
      viewer.style.height = Math.round(H * fit) + 'px';
      boxH = H * fit;
    } else {
      var keep = s > fit * 1.01 ? s : 0;       // 拡大中の回転などでは縮尺を保つ
      fit = (boxW - PAD_X * 2) / W;
      boxH = Math.round(H * fit + PAD_Y * 2);
      viewer.style.height = (boxH + border) + 'px';
      s = keep ? Math.min(MAX, Math.max(fit, keep)) : fit;
      if (!keep) { x = PAD_X; y = PAD_Y; }
      clamp();
    }
    viewer.classList.add('is-ready');
    viewer.scrollLeft = 0; viewer.scrollTop = 0;
    apply();
  }

  /* 枠内の点 (cx, cy) を動かさずに縮尺を変える */
  function zoomAt(next, cx, cy) {
    next = Math.min(MAX, Math.max(fit, next));
    x = cx - (cx - x) * (next / s);
    y = cy - (cy - y) * (next / s);
    s = next;
    clamp();
  }

  function animate(fn) {
    viewer.classList.add('is-anim');
    fn();
    apply();
    window.setTimeout(function () { viewer.classList.remove('is-anim'); }, 320);
  }

  function reset() {
    animate(function () { s = fit; x = PAD_X; y = PAD_Y; clamp(); });
  }

  function local(e) {
    var r = viewer.getBoundingClientRect();
    return { x: e.clientX - r.left - viewer.clientLeft, y: e.clientY - r.top - viewer.clientTop };
  }

  /* ---------- ポインター（指・マウス共通） ---------- */
  var pts = {};                      // pointerId → 枠内の座標
  var ids = [];
  var pinch = null;                  // { d, s, mx, my, x, y } ピンチ開始時
  var drag = null;                   // { px, py, x, y } ドラッグ開始時
  var moved = 0;                     // 動かした量（クリックの抑止に使う）
  var lastTap = null;

  function startGesture() {
    if (ids.length >= 2) {
      var a = pts[ids[0]], b = pts[ids[1]];
      pinch = { d: Math.hypot(a.x - b.x, a.y - b.y) || 1, s: s, mx: (a.x + b.x) / 2, my: (a.y + b.y) / 2, x: x, y: y };
      drag = null;
    } else if (ids.length === 1) {
      var p = pts[ids[0]];
      drag = { px: p.x, py: p.y, x: x, y: y };
      pinch = null;
    } else {
      pinch = drag = null;
    }
  }

  viewer.addEventListener('pointerdown', function (e) {
    if (mqPC.matches) return;
    if (e.pointerType === 'mouse' && e.button !== 0) return;
    pts[e.pointerId] = local(e);
    ids.push(e.pointerId);
    if (ids.length === 1) moved = 0;
    viewer.classList.remove('is-anim');
    startGesture();
  });

  viewer.addEventListener('pointermove', function (e) {
    if (!(e.pointerId in pts)) return;
    pts[e.pointerId] = local(e);
    if (pinch && ids.length >= 2) {
      var a = pts[ids[0]], b = pts[ids[1]];
      var d = Math.hypot(a.x - b.x, a.y - b.y) || 1;
      var mx = (a.x + b.x) / 2, my = (a.y + b.y) / 2;
      var next = Math.min(MAX, Math.max(fit, pinch.s * d / pinch.d));
      /* 開始時に 2 本指の中点にあった図上の点が、いまの中点に来るように */
      x = mx - (pinch.mx - pinch.x) * (next / pinch.s);
      y = my - (pinch.my - pinch.y) * (next / pinch.s);
      s = next;
      moved += 10;
      clamp(); apply();
      e.preventDefault();
    } else if (drag && s > fit * 1.01) {
      var p = pts[ids[0]];
      x = drag.x + (p.x - drag.px);
      y = drag.y + (p.y - drag.py);
      moved = Math.max(moved, Math.abs(p.x - drag.px) + Math.abs(p.y - drag.py));
      if (moved > 4) {
        viewer.classList.add('is-grabbing');
        try { viewer.setPointerCapture(e.pointerId); } catch (err) { /* 取れなくても動く */ }
      }
      clamp(); apply();
    }
  });

  function end(e) {
    if (!(e.pointerId in pts)) return;
    var p = pts[e.pointerId];
    delete pts[e.pointerId];
    ids.splice(ids.indexOf(e.pointerId), 1);
    viewer.classList.remove('is-grabbing');
    /* ダブルタップ（指・マウスとも）: 拡大 ⇄ 元に戻す。リンクの上では何もしない */
    if (e.type === 'pointerup' && ids.length === 0 && moved < 6 && !e.target.closest('a, button')) {
      var now = Date.now();
      if (lastTap && now - lastTap.t < 320 && Math.hypot(p.x - lastTap.x, p.y - lastTap.y) < 30) {
        lastTap = null;
        if (s > fit * 1.01) reset();
        else animate(function () { zoomAt(Math.min(MAX, fit * 3), p.x, p.y); });
      } else {
        lastTap = { t: now, x: p.x, y: p.y };
      }
    }
    startGesture();
  }
  viewer.addEventListener('pointerup', end);
  viewer.addEventListener('pointercancel', end);

  /* 動かした直後のクリックでリンクに飛ばない */
  viewer.addEventListener('click', function (e) {
    if (moved > 6) { e.preventDefault(); e.stopPropagation(); }
  }, true);

  /* Ctrl + ホイール（トラックパッドのピンチ）で拡大・縮小 */
  viewer.addEventListener('wheel', function (e) {
    if (mqPC.matches || !e.ctrlKey) return;
    e.preventDefault();
    var p = local(e);
    zoomAt(s * Math.exp(-e.deltaY * 0.01), p.x, p.y);
    apply();
  }, { passive: false });

  /* iOS Safari: ページごと拡大されるのを止める */
  ['gesturestart', 'gesturechange'].forEach(function (type) {
    viewer.addEventListener(type, function (e) { e.preventDefault(); });
  });

  if (resetBtn) resetBtn.addEventListener('click', reset);

  /* 幅が変わったときだけ組み直す（高さは自分で入れているので見ない） */
  function onResize() {
    if (viewer.clientWidth !== boxW) layout();
  }
  if ('ResizeObserver' in window) new ResizeObserver(onResize).observe(viewer.parentNode);
  else window.addEventListener('resize', onResize);
  layout();
})();
