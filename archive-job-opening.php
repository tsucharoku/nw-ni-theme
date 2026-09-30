<?php
/**
 * 募集要項一覧（カスタム投稿 job-opening の一覧 /job-opening/）
 *
 * 静的 HTML（HTML/job-opening/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => '募集中の職種一覧｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーション株式会社で募集中の職種一覧。新卒採用、中途採用（未経験・経験者）、アルバイトの募集要項をご案内します。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">募集中の職種一覧</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Job<br class="u-sp"> Opening</p>
      <h1 class="page-head__jp">募集中の職種一覧</h1>
    </div>
    <p class="page-head__read">東京・銀座の中心地に構える日本インフォメーションのオフィス。<br class="u-pc">仕事に集中できる環境と、人とつながれる場所が共存しています。</p>
  </div>

  <!-- カテゴリへのページ内リンク（件数は WP で出力） -->
  <ul class="anchor-nav">
    <li><a class="anchor-nav__link" href="#new-graduates">新卒採用（1）</a></li>
    <li><a class="anchor-nav__link" href="#mid-career-beginner">中途採用(未経験)（5）</a></li>
    <li><a class="anchor-nav__link" href="#mid-career-experienced">中途採用(経験者)（5）</a></li>
    <li><a class="anchor-nav__link" href="#part-time">アルバイト（10）</a></li>
  </ul>

  <!-- カテゴリごとの職種一覧（多いカテゴリは 5 件まで + カテゴリアーカイブへのボタン） -->
  <div class="lower-sec job-cats">
    <section class="job-cat" id="new-graduates">
      <div class="job-cat__head">
        <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">New Graduates</p>
          <h2 class="sec-head__title sec-head__title--cap">新卒採用</h2>
        </div>
        <p class="job-cat__desc">カテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入ります</p>
      </div>
      <div class="job-cat__body">
        <ul class="job__list">
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">2028年度新卒採用　募集要項</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        </ul>
      </div>
    </section>
    <section class="job-cat" id="mid-career-beginner">
      <div class="job-cat__head">
        <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Mid-Career (No Experience)</p>
          <h2 class="sec-head__title sec-head__title--cap">中途採用(未経験)</h2>
        </div>
        <p class="job-cat__desc">カテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入ります</p>
      </div>
      <div class="job-cat__body">
        <ul class="job__list">
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">プランナー（営業企画）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">フィールドワーク（FW）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">インターネットリサーチ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">アナリスト（NIマーケティング研究所）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        </ul>
      </div>
    </section>
    <section class="job-cat" id="mid-career-experienced">
      <div class="job-cat__head">
        <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Mid-Career (Experienced)</p>
          <h2 class="sec-head__title sec-head__title--cap">中途採用(経験者)</h2>
        </div>
        <p class="job-cat__desc">カテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入ります</p>
      </div>
      <div class="job-cat__body">
        <ul class="job__list">
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">プランナー（営業企画）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">フィールドワーク（FW）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">インターネットリサーチ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">アナリスト（NIマーケティング研究所）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        </ul>
      </div>
    </section>
    <section class="job-cat" id="part-time">
      <div class="job-cat__head">
        <div class="sec-head sec-head--sub">
          <p class="sec-head__label u-grd-text">Part-Time</p>
          <h2 class="sec-head__title sec-head__title--cap">アルバイト</h2>
        </div>
        <p class="job-cat__desc">カテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入りますカテゴリの説明が入ります</p>
      </div>
      <div class="job-cat__body">
        <ul class="job__list">
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査のモデレーター</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">リクルーター（マーケティング・リサーチ協力者招集作業、在宅作業）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
        </ul>
        <a class="btn" href="<?php echo ni_url( '/job-opening/category/' ); ?>">アルバイトの募集一覧をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
      </div>
    </section>
  </div>

</main>
<?php
get_footer();
