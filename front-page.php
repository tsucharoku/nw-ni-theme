<?php
/**
 * TOP 扉（サイトのトップ /）
 *
 * 静的 HTML（HTML/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '採用情報サイト｜日本インフォメーション株式会社',
		'description' => '日本インフォメーション株式会社の採用情報サイト。新卒・中途未経験者、中途経験者、アルバイトの採用情報をご案内します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Hero -->
  <section class="top-hero" id="js-fv">
    <h1 class="top-hero__title">あなたらしい働き方が、<br class="u-sp">ここにある。</h1>
    <p class="top-hero__lead">あなたのキャリアに合わせて詳細ページへお進みください。</p>
  </section>

  <!-- Entry -->
  <section class="top-entry">
    <div class="l-inner">
      <h2 class="u-visually-hidden">採用情報</h2>
      <ul class="top-entry__list">
        <li>
          <a class="entry-card entry-card--beginner" href="<?php echo ni_url( '/beginner/' ); ?>">
            <span class="entry-card__img"><img src="<?php echo ni_img( 'top/entry_beginner.png' ); ?>" alt="" width="1344" height="896"></span>
            <span class="entry-card__body">
              <span class="entry-card__title">新卒・中途未経験者<br>採用情報</span>
              <span class="entry-card__more">詳細を見る<span class="pill pill--m"><img src="<?php echo ni_img( 'common/arrow_white_m.svg' ); ?>" alt="" width="16" height="24"></span></span>
            </span>
          </a>
        </li>
        <li>
          <a class="entry-card entry-card--career" href="<?php echo ni_url( '/career/' ); ?>">
            <span class="entry-card__img"><img src="<?php echo ni_img( 'top/entry_career.png' ); ?>" alt="" width="1344" height="896"></span>
            <span class="entry-card__body">
              <span class="entry-card__title">中途経験者<br>採用情報</span>
              <span class="entry-card__more">詳細を見る<span class="pill pill--m"><img src="<?php echo ni_img( 'common/arrow_white_m.svg' ); ?>" alt="" width="16" height="24"></span></span>
            </span>
          </a>
        </li>
      </ul>
    </div>
  </section>

  <!-- Bnr（アルバイト） -->
  <section class="top-bnr">
    <div class="l-inner">
      <div class="top-bnr__box bracket" data-anim="bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <div class="top-bnr__content">
          <div class="top-bnr__text">
            <h2 class="top-bnr__title">アルバイト（調査員パートナー/社内作業スタッフ/調査サポート）<br class="u-pc">スタッフ募集中！</h2>
            <p class="top-bnr__desc">企業や自治体に活用されるリサーチの現場で、アンケートモニターへの案内や試飲・試食品の準備など、調査運営をサポートするお仕事です。みなさんが普段目にする商品やサービスの改善に、自分の仕事が直結しているやりがいを感じられます。</p>
          </div>
          <a class="btn top-bnr__btn" href="<?php echo ni_url( '/job-opening/category/' ); ?>">募集要項を見る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
        </div>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
