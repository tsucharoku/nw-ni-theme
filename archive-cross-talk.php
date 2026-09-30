<?php
/**
 * 座談会一覧（カスタム投稿 cross-talk の一覧 /cross-talk/）
 *
 * 静的 HTML（HTML/cross-talk/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '座談会｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションの社員による座談会の一覧です。さまざまな切り口で、リアルな日本インフォメーションを紐解きます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">座談会</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Crosstalk</p>
      <h1 class="page-head__jp">座談会</h1>
    </div>
    <p class="page-head__read">テキストが入りますテキストが入りますテキストが入りますテキストが入ります<br class="u-pc">テキストが入りますテキストが入りますテキストが入ります</p>
  </div>

  <!-- 座談会の一覧（Figma PC 892:27796 / SP 1140:20027）。WP ではカスタム投稿のアーカイブ。
       偶数行は PC で写真が左（CSS の :nth-child(even)）。6 件目以降は hidden で出力し、「次の5件をみる」で 5 件ずつ出す（lower.js の .js-more。WP で Ajax にする場合は JS を差し替え） -->
  <ul class="lower-sec ct-list" id="js-ct-list">
    <li class="ct-row" data-anim="inview">
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>01</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">新旧新卒座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview">
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>02</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">働くママの座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview">
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>03</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">育メン対談</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview">
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>04</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">働くママの座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview">
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>05</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">新旧新卒座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview" hidden>
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>06</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">働くママの座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview" hidden>
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>07</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">育メン対談</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <li class="ct-row" data-anim="inview" hidden>
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b>08</b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">新旧新卒座談会</a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>" tabindex="-1" aria-hidden="true"><img src="<?php echo ni_img( 'cross-talk/talk_01.jpg' ); ?>" alt="" width="1024" height="566" loading="lazy"></a>
        <p class="ct-row__members">2016年入社　リサーチ・コンサルティング部 サブリーダー H.Wさん<br>2022年入社　リサーチ・ディレクション部 T.Sさん<br>2022年入社　NIマーケティング研究所 K.Mさん</p>
      </div>
      <p class="ct-row__summary">記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります記事のサマリーが入ります</p>
      <a class="btn btn--w ct-row__btn" href="<?php echo ni_url( '/cross-talk/detail/' ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
  </ul>

  <!-- もっと見る（Figma: bnr/btn 855:25551）。文言と件数は lower.js（.js-more）が更新、全件出たら消える -->
  <div class="lower-sec ct-more">
    <button type="button" class="more-btn js-more" aria-controls="js-ct-list" data-step="5"><span class="more-btn__txt"><span class="js-more-label">次の3件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-more-count">5 / 8件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
  </div>

</main>
<?php
get_footer();
