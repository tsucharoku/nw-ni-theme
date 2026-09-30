<?php
/**
 * 404（404）
 *
 * 静的 HTML（HTML/404.html）の <main> をそのまま入れたもの。中身はまだ固定の文言・画像で、WP の投稿内容は出していない。
 */

ni_head(
	array(
		'title'       => 'ページが見つかりません｜日本インフォメーション株式会社 採用情報サイト',
		'description' => 'お探しのページは見つかりません。移動、もしくは削除された可能性があります。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head page-head--bare" id="js-fv">
    <img class="page-head__ni" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">お探しのページは見つかりません</li></ol></nav>
  </div>

  <!-- メッセージ（PC 900:30224 / SP 1140:21352）。WP では 404.php -->
  <section class="msg">
    <h1 class="msg__title">お探しのページは<br class="u-sp">見つかりません</h1>
    <p class="msg__txt">申し訳ございません。お探しのページは移動、<br>もしくは削除された可能性があります。</p>
    <a class="btn" href="<?php echo ni_url( '/' ); ?>">TOPへ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>

</main>
<?php
get_footer();
