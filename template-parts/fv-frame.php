<?php
/**
 * FV の青いフレーム（新卒 TOP・中途 TOP。header.php から）
 */
?>
<!-- FV の青いフレーム: Figma と同じく本文より上のレイヤー（ヘッダーの下）。
     新卒は訪問時に穴を閉じた状態で全面を覆い、開いていく（fv-intro.js）。中途は訪問時イントロなし（穴は最初から開いた状態）。
     どちらもスクロールで画面外へ逃げる（fv-frame.js） -->
<div class="fv-frame-layer" aria-hidden="true">
  <!-- FV の青いフレーム: メニューと同じ目型パス・同じ逆算（角度固定・欠けない）。スクロールで中心から拡大して角が画面外へ逃げる（fv-frame.js、demo 準拠） -->
  <svg class="page-bg__frame u-pc js-eye-frame" viewBox="0 0 1440 768" data-corner-x="192" data-static="1" data-anim="fv-frame" aria-hidden="true">
    <defs>
      <linearGradient id="fv-grd-pc" x1="0.056" y1="0.848" x2="1.264" y2="0.342">
        <stop stop-color="#2b479f"/><stop offset="0.5048" stop-color="#59adf6"/><stop offset="1" stop-color="#4e87d2"/>
      </linearGradient>
      <mask id="fv-eye-mask-pc">
        <rect class="js-menu-rect" width="1440" height="768" fill="#fff"/>
        <path class="js-menu-eye" data-cx="720" data-cy="384" d="M-376.688 -45.9327C-376.446 -46.0529 355.748 -410.321 973.583 -158.787C1074.23 -117.811 1165.64 -63.0191 1248.14 0C1318.5 53.7402 1382.38 113.464 1440 175.706C1729.53 488.454 1860.95 864.779 1861.06 865.103C1861.06 865.103 1128.72 1229.53 510.788 977.959C383.747 926.237 271.431 852.506 173.156 768C109.632 713.376 51.9763 654.25 0 593.658C-258.733 292.037 -376.688 -45.9327 -376.688 -45.9327Z" fill="#000" transform="translate(720,384) scale(1,1) translate(-720,-384)"/>
      </mask>
    </defs>
    <rect class="js-menu-rect" width="1440" height="768" fill="url(#fv-grd-pc)" mask="url(#fv-eye-mask-pc)"/>
  </svg>
  <svg class="page-bg__frame u-sp js-eye-frame" viewBox="0 0 375 667" data-corner-x="180" data-static="1" data-anim="fv-frame" aria-hidden="true">
    <defs>
      <linearGradient id="fv-grd-sp" x1="0.204" y1="1.0" x2="4.97" y2="0.40">
        <stop stop-color="#2b479f"/><stop offset="0.5048" stop-color="#59adf6"/><stop offset="1" stop-color="#4e87d2"/>
      </linearGradient>
      <mask id="fv-eye-mask-sp">
        <rect class="js-menu-rect" width="375" height="667" fill="#fff"/>
        <path class="js-menu-eye" data-cx="187.5" data-cy="333.5" d="M-237.324 -30.4267C-237.002 -30.476 -46.5039 -59.6144 157.743 -9.95796C232.54 8.22679 309.18 36.9796 379 81.5977C399.497 94.6957 419.407 109.159 438.508 125.126C700.354 343.999 711.453 762.156 711.466 762.651C711.163 762.698 382.739 812.968 125.898 669.042C94.4968 651.446 64.165 630.948 35.6343 607.1C20.9847 594.854 7.12229 581.983 -5.99951 568.598C-227.425 342.733 -237.312 -29.9871 -237.324 -30.4267Z" fill="#000" transform="translate(187.5,333.5) scale(1,1) translate(-187.5,-333.5)"/>
      </mask>
    </defs>
    <rect class="js-menu-rect" width="375" height="667" fill="url(#fv-grd-sp)" mask="url(#fv-eye-mask-sp)"/>
  </svg>
</div>
