<?php
/**
 * 募集要項 カテゴリ一覧（タクソノミー job-category の一覧 /job-opening/{カテゴリのスラッグ}/）
 *
 * 静的 HTML（HTML/job-opening/category/index.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'アルバイトの募集一覧｜募集中の職種一覧｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーション株式会社のアルバイト募集職種の一覧です。定性調査のモデレーター・書記、会場アシスタントなど、募集中の職種をご覧いただけます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（このページはパンくずだけ。見出しは本文側の h1。id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧</a></li><li aria-current="page">アルバイトの募集一覧</li></ol></nav>
  </div>

  <!-- カテゴリの職種一覧（562:16554）。h1 はカテゴリ名 + 「の募集一覧」（WP: タクソノミー名を出力）
       一覧は 10 件ずつ表示（lower.js の .js-more。WP では Ajax / ページ送りに差し替え） -->
  <div class="lower-sec job-archive">
    <h1 class="job-archive__title">アルバイトの<br>募集一覧</h1>
    <div class="job-archive__body">
      <ul class="job__list" id="job-archive-list">
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査のモデレーター</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">リクルーター（マーケティング・リサーチ協力者招集作業、在宅作業）</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査のモデレーター</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査のモデレーター</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査のモデレーター</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">グループインタビュー会場アシスタント</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">定性調査の書記</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
          <li><a class="job-item" href="<?php echo ni_url( '/job-opening/detail/' ); ?>"><span class="job-item__text">社内作業スタッフ</span><span class="job-item__divider"></span><span class="arrow-pill"><img src="<?php echo ni_img( 'common/arrow_pill_white_m.svg' ); ?>" alt="" width="16" height="24"></span></a></li>
      </ul>
      <button type="button" class="more-btn js-more" aria-controls="job-archive-list" data-step="10"><span class="more-btn__txt"><span class="js-more-label">次の10件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-more-count">10 / 24件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
    </div>
  </div>

</main>
<?php
get_footer();
