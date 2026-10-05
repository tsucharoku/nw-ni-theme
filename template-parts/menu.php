<?php
/**
 * ハンバーガーメニュー（全ページ共通。header.php から）
 *
 * TODO: 業界の未来（/future/）・メッセージ（/message/）はデザイン未 FIX でページが無いので # のまま
 */
?>
<!-- ===== Hamburger Menu ===== -->
<div class="menu" id="js-menu" aria-hidden="true">
  <!-- 紺の全面 → 目型の穴がまぶたのように開く（demo と同じ動き）。
       穴の形は Figma の FV-Fream / SP_Menu の目型パスそのもの。デザインサイズ（1440x768 / 375x667）で完全一致、
       他のサイズは viewBox をウィンドウ px にし、右上の角の斜辺が上辺の右端から data-corner-x px を通る拡大率を JS が逆算（切れない・角度不変） -->
  <svg class="menu__frame u-pc js-menu-frame" viewBox="0 0 1440 768" data-corner-x="192" aria-hidden="true">
    <defs>
      <mask id="menu-eye-mask-pc">
        <rect class="js-menu-rect" width="1440" height="768" fill="#fff"/>
        <path class="js-menu-eye" data-cx="720" data-cy="384" d="M-376.688 -45.9327C-376.446 -46.0529 355.748 -410.321 973.583 -158.787C1074.23 -117.811 1165.64 -63.0191 1248.14 0C1318.5 53.7402 1382.38 113.464 1440 175.706C1729.53 488.454 1860.95 864.779 1861.06 865.103C1861.06 865.103 1128.72 1229.53 510.788 977.959C383.747 926.237 271.431 852.506 173.156 768C109.632 713.376 51.9763 654.25 0 593.658C-258.733 292.037 -376.688 -45.9327 -376.688 -45.9327Z" fill="#000" transform="translate(720,384) scale(0.8125,0.0001) translate(-720,-384)"/>
      </mask>
    </defs>
    <rect class="js-menu-rect" width="1440" height="768" fill="#1b3a98" mask="url(#menu-eye-mask-pc)"/>
  </svg>
  <svg class="menu__frame u-sp js-menu-frame" viewBox="0 0 375 667" data-corner-x="180" aria-hidden="true">
    <defs>
      <mask id="menu-eye-mask-sp">
        <rect class="js-menu-rect" width="375" height="667" fill="#fff"/>
        <path class="js-menu-eye" data-cx="187.5" data-cy="333.5" d="M-237.324 -30.4267C-237.002 -30.476 -46.5039 -59.6144 157.743 -9.95796C232.54 8.22679 309.18 36.9796 379 81.5977C399.497 94.6957 419.407 109.159 438.508 125.126C700.354 343.999 711.453 762.156 711.466 762.651C711.163 762.698 382.739 812.968 125.898 669.042C94.4968 651.446 64.165 630.948 35.6343 607.1C20.9847 594.854 7.12229 581.983 -5.99951 568.598C-227.425 342.733 -237.312 -29.9871 -237.324 -30.4267Z" fill="#000" transform="translate(187.5,333.5) scale(0.8125,0.0001) translate(-187.5,-333.5)"/>
      </mask>
    </defs>
    <rect class="js-menu-rect" width="375" height="667" fill="#1b3a98" mask="url(#menu-eye-mask-sp)"/>
  </svg>
  <nav class="menu__inner" aria-label="サイトメニュー">
    <div class="menu__col">
      <div class="menu__head">
        <p class="menu__label u-grd-text">日本インフォメーションを知る</p>
        <p class="menu__title u-en">About Us</p>
      </div>
      <div class="menu__groups">
        <ul class="menu__group">
          <li><a href="<?php echo ni_url( '/about/' ); ?>">3分でわかる日本インフォメーション</a></li>
          <li><a href="<?php echo ni_url( '/future/' ); ?>">業界の未来</a></li>
          <li><a href="<?php echo ni_url( '/message/' ); ?>">メッセージ</a></li>
        </ul>
        <div class="menu__group">
          <p class="menu__group-title">仕事とキャリア</p>
          <a class="menu__sub" href="<?php echo ni_url( '/chart/' ); ?>">仕事の相関図</a>
          <a class="menu__sub" href="<?php echo ni_url( '/development/' ); ?>">教育・研修・キャリアパス</a>
        </div>
        <div class="menu__group">
          <p class="menu__group-title">人とカルチャー</p>
          <a class="menu__sub" href="<?php echo ni_url( '/cross-talk/' ); ?>">座談会</a>
          <a class="menu__sub" href="<?php echo ni_url( '/work-style/' ); ?>">制度・環境</a>
          <a class="menu__sub" href="<?php echo ni_url( '/office/' ); ?>">オフィス紹介</a>
        </div>
      </div>
    </div>
    <div class="menu__col">
      <div class="menu__head">
        <p class="menu__label u-grd-text">募集中の職種一覧</p>
        <p class="menu__title u-en">Open<br>Positions</p>
      </div>
      <ul class="menu__group">
        <li><a href="<?php echo ni_job_category_url( 'new-graduate' ); ?>">新卒採用</a></li>
        <li><a href="<?php echo ni_job_category_url( 'mid-beginner' ); ?>">中途採用(リサーチ未経験者)</a></li>
        <li><a href="<?php echo ni_job_category_url( 'mid-career' ); ?>">中途採用(リサーチ経験者)</a></li>
        <li><a href="<?php echo ni_job_category_url( 'part-time' ); ?>">アルバイト</a></li>
      </ul>
    </div>
  </nav>
</div>
