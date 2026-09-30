/* ==========================================================================
   common.js — ハンバーガーメニュー / 追従ヘッダー / SPフッターアコーディオン
   ========================================================================== */
(function () {
  'use strict';

  var mqPC = window.matchMedia('(min-width: 768px)');

  /* PC / SP の境（768px）をまたいだら再読み込み（2026-09-17）。
     fv-message.js（固定 / フロー）、fv-about.js / fv-entry.js（SP では動かない）、fv-havefun.js（ロゴの前 / 後ろ）は
     読み込み時に一度だけ PC / SP を判定して初期化するので、またぐと inline style や重なり順が古いモードのまま残る。
     実機でまたぐのはタブレットの回転くらい（例: iPad mini 縦 744 → 横 1024）。またがないリサイズは各モジュールが追従する */
  var pcAtLoad = mqPC.matches;
  var onBreakpointChange = function () {
    if (mqPC.matches === pcAtLoad) return;
    pcAtLoad = mqPC.matches;   /* 二重に reload しない */
    window.location.reload();
  };
  if (mqPC.addEventListener) {
    mqPC.addEventListener('change', onBreakpointChange);
  } else {
    mqPC.addListener(onBreakpointChange);
  }
  /* change が出ない環境（ビューポート模倣など）向けの保険: 1 秒ごとに見比べる */
  setInterval(onBreakpointChange, 1000);

  /* 開発用: ?capture でフルページ撮影モード（100vh の FV を固定高に）。?menu で開いた状態から開始 */
  if (/[?&]capture/.test(window.location.search)) {
    document.documentElement.classList.add('is-capture');
  }
  var devMenuOpen = /[?&]menu/.test(window.location.search);

  /* 開発用: ?diag で画面右下に状態を表示（実機で背景動画・WebGL の切り分け用。2026-09-17）。1 秒ごとに更新 */
  if (/[?&]diag/.test(window.location.search)) {
    var diagBox = document.createElement('pre');
    diagBox.style.cssText = 'position:fixed;right:4px;bottom:60px;z-index:9999;max-width:92vw;margin:0;padding:6px 8px;font:11px/1.4 monospace;color:#fff;background:rgba(0,0,0,.75);white-space:pre-wrap;pointer-events:none;';
    document.body.appendChild(diagBox);
    /* 64x36 に描いて画素の平均 / 最小 / ばらつきを返す（真っ白なら mean 255 / sd 0） */
    var diagSample = function (draw) {
      try {
        var c = document.createElement('canvas'); c.width = 64; c.height = 36;
        var ctx = c.getContext('2d');
        ctx.fillStyle = '#f0f'; ctx.fillRect(0, 0, 64, 36);   /* 描けなければマゼンタが残る */
        draw(ctx);
        var d = ctx.getImageData(0, 0, 64, 36).data, n = 0, sum = 0, min = 255, sq = 0, magenta = 0;
        for (var i = 0; i < d.length; i += 4) {
          var l = (d[i] + d[i + 1] + d[i + 2]) / 3;
          if (d[i] > 240 && d[i + 1] < 20 && d[i + 2] > 240) magenta++;
          sum += l; sq += l * l; if (l < min) min = l; n++;
        }
        var mean = sum / n, sd = Math.sqrt(Math.max(0, sq / n - mean * mean));
        return 'mean=' + mean.toFixed(0) + ' min=' + min.toFixed(0) + ' sd=' + sd.toFixed(1) + (magenta > n / 2 ? ' NOT-DRAWN' : '');
      } catch (e) { return 'err ' + (e && e.name); }
    };
    /* fps: rAF の回数を 1 秒ごとに数える。js: 全モジュールの rAF コールバックの実行時間（ms / フレーム、1 秒平均）。
       requestAnimationFrame を包んで測る（common.js は最初に読まれるので、後続のモジュールの rAF も対象になる） */
    var diagFrames = 0, diagFps = 0, diagJsMs = 0, diagJsAcc = 0, diagJsMax = 0, diagJsMaxShown = 0;
    var rafOrig = window.requestAnimationFrame.bind(window);
    window.requestAnimationFrame = function (cb) {
      return rafOrig(function (ts) {
        var t0 = performance.now();
        try { cb(ts); } finally { var dt = performance.now() - t0; diagJsAcc += dt; if (dt > diagJsMax) diagJsMax = dt; }
      });
    };
    (function countFrames() { diagFrames++; requestAnimationFrame(countFrames); })();
    setInterval(function () {
      diagFps = diagFrames; diagJsMs = diagFrames ? diagJsAcc / diagFrames : 0; diagJsMaxShown = diagJsMax;
      diagFrames = 0; diagJsAcc = 0; diagJsMax = 0;
    }, 1000);
    var diagTick = function () {
      var v = document.querySelector('.page-bg__video');
      var gl = false;
      try { var c = document.createElement('canvas'); gl = !!(c.getContext('webgl2') || c.getContext('webgl')); } catch (e) { gl = 'err'; }
      var L = window.__niLogo;
      var lc = document.querySelector('canvas.ni-logo');
      var lines = [
        'UA: ' + navigator.userAgent.replace(/^Mozilla\/5\.0 /, '').slice(0, 70),
        'reduced-motion: ' + window.matchMedia('(prefers-reduced-motion: reduce)').matches + '  webgl: ' + gl + '  fps: ' + diagFps + '  js: ' + diagJsMs.toFixed(1) + 'ms/f (max ' + diagJsMaxShown.toFixed(0) + ')',
        'viewport: ' + window.innerWidth + 'x' + window.innerHeight + ' dpr ' + window.devicePixelRatio,
        v ? ('video: rs=' + v.readyState + ' paused=' + v.paused + ' t=' + v.currentTime.toFixed(1) + ' ' + v.videoWidth + 'x' + v.videoHeight + ' err=' + (v.error ? v.error.code : '-') + ' src=' + (v.currentSrc || '').split('/').pop()) : 'video: none',
        'ni-logo: ' + (L ? ('running=' + L.running + ' progress=' + (L.progress || 0).toFixed(2) + ' bloom=' + (L.bloom ? L.bloom.enabled : '-')) : 'no __niLogo') + (lc ? (' canvas=' + lc.width + 'x' + lc.height + (lc.classList.contains('is-off') ? ' is-off' : '')) : ' no canvas'),
        'canvases: ' + Array.prototype.map.call(document.querySelectorAll('canvas'), function (c) { return (c.className || 'no-class') + ' ' + c.width + 'x' + c.height; }).join(' | '),
        'vtest: ' + diagSample(function (ctx) { ctx.drawImage(v, 0, 0, 64, 36); }),
        'bgcanvas: ' + (L && L.bgCanvas ? (L.bgCanvas.width + 'x' + L.bgCanvas.height + ' ' + diagSample(function (ctx) { ctx.drawImage(L.bgCanvas, 0, 0, 64, 36); })) : '-')
      ];
      diagBox.textContent = lines.join('\n');
    };
    diagTick();
    setInterval(diagTick, 1000);
  }

  /* ---------- 背景動画: autoplay が抑止された場合の再生リトライ ---------- */
  var bgVideo = document.querySelector('.page-bg__video');
  /* 開発用: ?novideo で動画を止めてポスター静止画にする（実機で動画の負荷を切り分ける。2026-09-17） */
  if (bgVideo && /[?&]novideo/.test(window.location.search)) {
    bgVideo.pause();
    bgVideo.removeAttribute('autoplay');
    Array.prototype.forEach.call(bgVideo.querySelectorAll('source'), function (s) { s.remove(); });
    bgVideo.removeAttribute('src');
    bgVideo.load();   /* readyState 0 → ni-logo.js の背景もポスターを使う */
    bgVideo = null;
  }
  if (bgVideo) {
    var tryPlay = function () {
      var p = bgVideo.play();
      if (p && p.catch) p.catch(function () {});
    };
    tryPlay();
    ['touchstart', 'click', 'scroll'].forEach(function (ev) {
      window.addEventListener(ev, function once() {
        if (bgVideo.paused) tryPlay();
        window.removeEventListener(ev, once);
      }, { passive: true });
    });
  }

  /* ---------- ハンバーガーメニュー ---------- */
  var menu = document.getElementById('js-menu');
  var openBtns = document.querySelectorAll('.js-menu-open');
  var closeBtns = document.querySelectorAll('.js-menu-close');

  /* 目型マスクの開閉（demo準拠: 開く 640ms / 閉じる 400ms, easeInOutCubic）
     穴の形は Figma の目型パスそのもの。viewBox をウィンドウ px にし、右上の角の斜辺が
     上辺の「右端から data-corner-x px」を通る拡大率をウィンドウごとに二分探索で求める（角度は変えず、切れない）。
     開くときは demo と同様に中央から縦に開き、横は 0.81→1.0 に広がる */
  var eyes = document.querySelectorAll('.js-menu-eye');   /* メニューの目型 + FV フレームの目型（.js-eye-frame 内、常に開き切り） */
  var eye = eyes.length ? eyes[0] : null;
  var eyeK = 0;
  var eyeToken = 0;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches || devMenuOpen;

  function eyeContains(pathEl, W, H, g, x, y) {
    /* 画面 px (x,y) → 目型パスのローカル座標（design 座標）へ逆変換して内外判定 */
    var pt = pathEl.ownerSVGElement.createSVGPoint();
    pt.x = (x - W / 2) / g + parseFloat(pathEl.getAttribute('data-cx'));
    pt.y = (y - H / 2) / g + parseFloat(pathEl.getAttribute('data-cy'));
    return pathEl.isPointInFill(pt);
  }

  function solveEyeScale(pathEl, cornerX, W, H) {
    var px = W - cornerX, py = 0.5;
    var lo = 0.2, hi = 12;
    for (var i = 0; i < 40; i++) {
      var mid = (lo + hi) / 2;
      if (eyeContains(pathEl, W, H, mid, px, py)) hi = mid; else lo = mid;
    }
    return (lo + hi) / 2;
  }

  function fitMenuFrames() {
    var W = Math.max(1, window.innerWidth);
    var H = Math.max(1, window.innerHeight);
    Array.prototype.forEach.call(document.querySelectorAll('.js-menu-frame, .js-eye-frame'), function (svg) {
      svg.setAttribute('viewBox', '0 0 ' + W + ' ' + H);
      Array.prototype.forEach.call(svg.querySelectorAll('.js-menu-rect'), function (r) {
        r.setAttribute('width', W);
        r.setAttribute('height', H);
      });
      var pathEl = svg.querySelector('.js-menu-eye');
      if (pathEl) {
        var cornerX = parseFloat(svg.getAttribute('data-corner-x')) || 192;
        pathEl.setAttribute('data-g', solveEyeScale(pathEl, cornerX, W, H));
        pathEl.setAttribute('data-w', W);
        pathEl.setAttribute('data-h', H);
      }
    });
  }

  function applyEye() {
    Array.prototype.forEach.call(eyes, function (el) {
      var g = parseFloat(el.getAttribute('data-g')) || 1;
      var k = el.closest && el.closest('.js-eye-frame')
        ? (window.__fvEyeK === undefined ? 1 : window.__fvEyeK)   /* FV フレーム: 通常は開き切り。訪問時イントロ（fv-intro.js）が 0→1 に開く */
        : eyeK;
      var sx = (0.8125 + 0.1875 * k) * g;
      var sy = Math.max(0.0001, k) * g;
      el.setAttribute('transform', 'translate(' + (parseFloat(el.getAttribute('data-w')) / 2) + ',' + (parseFloat(el.getAttribute('data-h')) / 2) + ') scale(' + sx.toFixed(4) + ',' + sy.toFixed(4) + ') translate(-' + el.getAttribute('data-cx') + ',-' + el.getAttribute('data-cy') + ')');
    });
  }

  fitMenuFrames();
  applyEye();   /* 初期表示で FV フレームにも反映（メニューは開く時に再計算） */
  window.__applyEye = applyEye;
  window.__fitMenuFrames = fitMenuFrames;
  window.addEventListener('resize', function () { fitMenuFrames(); applyEye(); });

  function animateEye(to, dur, done) {
    if (!eye || reduceMotion) {
      eyeK = to; applyEye();
      if (done) done();
      return;
    }
    var from = eyeK;
    var t0 = performance.now();
    var token = ++eyeToken;
    (function step(now) {
      if (token !== eyeToken) return;
      var u = Math.min(1, (now - t0) / dur);
      var e = u < 0.5 ? 4 * u * u * u : 1 - Math.pow(-2 * u + 2, 3) / 2;
      eyeK = from + (to - from) * e;
      applyEye();
      if (u < 1) requestAnimationFrame(step);
      else if (done) done();
    })(t0);
  }

  function setMenu(isOpen) {
    if (!menu) return;
    if (isOpen) {
      var token = ++eyeToken;
      fitMenuFrames();
      eyeK = 0; applyEye();          /* 紺の全面から */
      menu.classList.add('is-open'); /* 紺の全面が 0.2s でフェードイン */
      setTimeout(function () {       /* フェードが済んでから目型を開く */
        if (token === eyeToken) animateEye(1, 640);
      }, reduceMotion ? 0 : 200);
    } else {
      animateEye(0, 400, function () {
        if (!document.body.classList.contains('is-menu-open')) menu.classList.remove('is-open');
      });
    }
    menu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    document.body.classList.toggle('is-menu-open', isOpen);
    Array.prototype.forEach.call(openBtns, function (btn) {
      btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      btn.setAttribute('aria-label', isOpen ? 'メニューを閉じる' : 'メニューを開く');
      btn.classList.toggle('is-open', isOpen);
    });
    if (isOpen) {
      var first = menu.querySelector('a');
      if (first) first.focus({ preventScroll: true });
    }
  }

  if (devMenuOpen && menu) setMenu(true);

  Array.prototype.forEach.call(openBtns, function (btn) {
    btn.addEventListener('click', function () {
      setMenu(!document.body.classList.contains('is-menu-open'));
    });
  });
  Array.prototype.forEach.call(closeBtns, function (btn) {
    btn.addEventListener('click', function () { setMenu(false); });
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && document.body.classList.contains('is-menu-open')) setMenu(false);
  });

  /* ---------- 追従ヘッダー ----------
     FV(#js-fv) を過ぎたら .header に is-fixed を付与し CTA を追従表示。
     Message（Have Fun!）があるページ（新卒・中途）は fv-message.js が Message の出現に合わせて is-fixed を付ける
     （header.dataset.fixedBy = 'message'）ので、ここの FV 判定は使わない。
     [data-header-hide]（新卒はフッター）が画面下端の 60px 手前（CTA の高さ 40 + 下 9 + 余裕）まで来たら is-hidden で消す
     （2026-09-17 指示「フッターはいる手前で非表示に」。以前は Entry が 10% 見えたら）。 */
  var header = document.querySelector('.js-header');
  /* FV が画面固定のページ（新卒）では、FV の代わりに直後の余白 [data-fv-scroll] の通過を見る */
  var fv = document.querySelector('[data-fv-scroll]') || document.getElementById('js-fv');

  if (header && fv && 'IntersectionObserver' in window) {
    var fvObserver = new IntersectionObserver(function (entries) {
      if (header.dataset.fixedBy) return;
      entries.forEach(function (entry) {
        header.classList.toggle('is-fixed', !entry.isIntersecting && entry.boundingClientRect.top < 0);
      });
    }, { threshold: 0, rootMargin: '-80px 0px 0px 0px' });
    fvObserver.observe(fv);

    var hideTargets = document.querySelectorAll('[data-header-hide]');
    if (hideTargets.length) {
      var hideObserver = new IntersectionObserver(function (entries) {
        var anyVisible = false;
        entries.forEach(function (entry) {
          if (entry.isIntersecting) anyVisible = true;
        });
        header.classList.toggle('is-hidden', anyVisible);
      }, { threshold: 0, rootMargin: '0px 0px 60px 0px' });
      Array.prototype.forEach.call(hideTargets, function (el) { hideObserver.observe(el); });
    }
  }

  /* ---------- Story / Voice のスライダー（Splide、assets/vendor/splide） ----------
     ループ、カード幅は CSS のまま（autoWidth）、1 枚ずつ送る。矢印は既存の .slider-nav（Splide の矢印は使わない）。
     Voice は SP のみ（PC は destroy して 3 枚並べる） */
  function mountSlider(root, extra) {
    if (!root || typeof window.Splide !== 'function') return null;
    var opts = {
      type: 'loop', autoWidth: true, perMove: 1, focus: 0,
      arrows: false, pagination: false, drag: true, flickMaxPages: 1,
      speed: 600, easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
      i18n: { prev: '前へ', next: '次へ' }
    };
    for (var k in extra) if (Object.prototype.hasOwnProperty.call(extra, k)) opts[k] = extra[k];
    var splide = new window.Splide(root, opts).mount();
    var nav = root.parentNode.querySelector('.slider-nav');
    if (nav) {
      var prev = nav.querySelector('.arrow-pill--prev');
      var next = nav.querySelector('.arrow-pill:not(.arrow-pill--prev)');
      if (prev) prev.addEventListener('click', function () { splide.go('<'); });
      if (next) next.addEventListener('click', function () { splide.go('>'); });
    }
    return splide;
  }
  window.__sliders = {
    story: mountSlider(document.querySelector('.story__slider'), {
      gap: '48px',
      breakpoints: { 767: { gap: '24px' } }
    }),
    voice: mountSlider(document.querySelector('.voice__slider'), {
      gap: '20px',
      mediaQuery: 'min',
      breakpoints: { 768: { destroy: true } }
    })
  };

  /* ---------- Future のマーキー（The Future of the Industry）: demo と同じく横にずっと流す ----------
     中身を .future__marquee-slide > .future__marquee-in で包み、1 セット複製して CSS アニメで半分ずつ動かす（継ぎ目なし）。
     登場（demo の .mq.in-view）: 上端が画面の 92% より上に入ったら .is-inview → 右下から左上へぬるっと（CSS transition） */
  Array.prototype.forEach.call(document.querySelectorAll('.future__marquee'), function (mq) {
    if (mq.querySelector('.future__marquee-in')) return;
    var slide = document.createElement('span');
    slide.className = 'future__marquee-slide';
    var inner = document.createElement('span');
    inner.className = 'future__marquee-in';
    var items = Array.prototype.slice.call(mq.children);
    items.forEach(function (el) { inner.appendChild(el); });
    items.forEach(function (el) {
      var clone = el.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      inner.appendChild(clone);
    });
    slide.appendChild(inner);
    mq.appendChild(slide);

    /* 登場 */
    mq.classList.add('is-fx');
    var done = false;
    function fire() {
      if (done) return;
      done = true;
      mq.classList.add('is-inview');
    }
    function chk() {
      if (done) return;
      var r = mq.getBoundingClientRect();
      if (r.top < window.innerHeight * 0.92 && r.bottom > 0) fire();
    }
    try {
      var io = new IntersectionObserver(function (es) {
        es.forEach(function (e) { if (e.isIntersecting) { io.disconnect(); fire(); } });
      }, { rootMargin: '0px 0px -8% 0px' });
      io.observe(mq);
    } catch (e) { fire(); }
    window.addEventListener('scroll', chk, { passive: true });
    /* 初期状態を描いてから判定（付けた瞬間に遷移が走らないよう 2 フレーム空ける） */
    requestAnimationFrame(function () { requestAnimationFrame(chk); });
  });

  /* ---------- People & Culture 写真カルーセル: 各列の中身を複製して無限ループにする ---------- */
  Array.prototype.forEach.call(document.querySelectorAll('.culture__col'), function (col) {
    var items = Array.prototype.slice.call(col.children);
    items.forEach(function (li) {
      var clone = li.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      col.appendChild(clone);
    });
  });

  /* ---------- タブ（募集中の職種一覧） ---------- */
  var tabGroups = document.querySelectorAll('.js-tabs');
  Array.prototype.forEach.call(tabGroups, function (group) {
    var tabs = group.querySelectorAll('[role="tab"]');
    Array.prototype.forEach.call(tabs, function (tab) {
      tab.addEventListener('click', function () {
        Array.prototype.forEach.call(tabs, function (t) {
          var selected = t === tab;
          t.setAttribute('aria-selected', selected ? 'true' : 'false');
          var panel = document.getElementById(t.getAttribute('aria-controls'));
          if (panel) panel.hidden = !selected;
        });
      });
    });
  });

  /* ---------- Cross Talk（座談会）の切り替え ----------
     4 件のうち 1 件を右の大きな写真＋左の見出し（.talk__info-item / .talk__img-item の is-active）に出し、
     残り 3 件を左のサムネ 3 枠に番号順（表示中を除く。左が #01）で出す。矢印（.slider-nav）とサムネのクリックで切り替え。
     サムネ枠は HTML の 4 件を JS で 3 枠に組み直し、各枠に 4 件ぶんの複製を重ねて表示する 1 件だけ is-active にする
     （枠の中でクロスフェードさせるため。フェードは CSS の transition） */
  Array.prototype.forEach.call(document.querySelectorAll('.talk'), function (talk) {
    var infos = talk.querySelectorAll('.talk__info-item');
    var imgs = talk.querySelectorAll('.talk__img-item');
    var list = talk.querySelector('.talk__thumbs');
    var thumbs = list ? list.querySelectorAll('.talk-thumb') : [];
    var n = imgs.length;
    if (!list || n < 2 || infos.length !== n || thumbs.length !== n) return;

    var slotCount = Math.min(3, n - 1);
    var slots = [];
    list.innerHTML = '';
    for (var k = 0; k < slotCount; k++) {
      var li = document.createElement('li');
      li.className = 'talk__slot';
      var clones = [];
      for (var i = 0; i < n; i++) {
        var c = thumbs[i].cloneNode(true);
        c.setAttribute('data-talk-to', String(i));
        li.appendChild(c);
        clones.push(c);
      }
      list.appendChild(li);
      slots.push(clones);
    }

    var current = -1;
    function show(idx) {
      idx = ((idx % n) + n) % n;
      if (idx === current) return;
      current = idx;
      for (var i = 0; i < n; i++) {
        infos[i].classList.toggle('is-active', i === idx);
        imgs[i].classList.toggle('is-active', i === idx);
      }
      var rest = [];
      for (var j = 0; j < n; j++) if (j !== idx) rest.push(j);
      slots.forEach(function (clones, k) {
        var target = rest[k];
        clones.forEach(function (c, i) {
          c.classList.toggle('is-active', i === target);
        });
      });
    }

    list.addEventListener('click', function (e) {
      var btn = e.target.closest('.talk-thumb');
      if (!btn || !list.contains(btn)) return;
      show(Number(btn.getAttribute('data-talk-to')));
    });
    var prev = talk.querySelector('.slider-nav .arrow-pill--prev');
    var next = talk.querySelector('.slider-nav .arrow-pill:not(.arrow-pill--prev)');
    if (prev) prev.addEventListener('click', function () { show(current - 1); });
    if (next) next.addEventListener('click', function () { show(current + 1); });

    var initial = 0;
    Array.prototype.forEach.call(imgs, function (el, i) {
      if (el.classList.contains('is-active')) initial = i;
    });
    show(initial);
  });

  /* ---------- SP フッターアコーディオン ---------- */
  var toggles = document.querySelectorAll('.js-footer-toggle');

  Array.prototype.forEach.call(toggles, function (btn) {
    var panel = document.getElementById(btn.getAttribute('aria-controls'));
    if (!panel) return;

    function sync() {
      if (mqPC.matches) {
        btn.setAttribute('aria-expanded', 'true');
        panel.hidden = false;
        panel.style.height = '';
      } else {
        btn.setAttribute('aria-expanded', 'false');
        panel.hidden = true;
      }
    }

    btn.addEventListener('click', function () {
      if (mqPC.matches) return;
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
      panel.hidden = expanded;
    });

    sync();
    if (mqPC.addEventListener) {
      mqPC.addEventListener('change', sync);
    } else {
      mqPC.addListener(sync);
    }
  });
})();
