<?php
/**
 * 募集要項 カテゴリ一覧（タクソノミー job-category の一覧 /job-opening/{カテゴリのスラッグ}/）
 *
 * そのカテゴリの職種を全件出す（件数と並び順は inc/post-types.php の ni_job_category_query()）。
 * 10 件ずつ見せるのは assets/js/lower.js の .js-more。
 */

$ni_term  = get_queried_object();
$ni_title = $ni_term->name . 'の募集一覧';
$ni_total = (int) $GLOBALS['wp_query']->post_count;

ni_head(
	array(
		'title'       => $ni_title . '｜募集中の職種一覧｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーション株式会社の' . $ni_term->name . 'の募集職種の一覧です。募集中の職種をご覧いただけます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（このページはパンくずだけ。見出しは本文側の h1。id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧</a></li><li aria-current="page"><?php echo esc_html( $ni_title ); ?></li></ol></nav>
  </div>

  <!-- カテゴリの職種一覧（562:16554）。h1 はカテゴリ名 + 「の募集一覧」
       一覧は 10 件ずつ表示（lower.js の .js-more。全部出たらボタンは消える） -->
  <div class="lower-sec job-archive">
    <h1 class="job-archive__title"><?php echo esc_html( $ni_term->name ); ?>の<br>募集一覧</h1>
    <div class="job-archive__body">
      <ul class="job__list" id="job-archive-list">
          <?php
          while ( have_posts() ) :
          	the_post();
          	get_template_part( 'template-parts/job-item' );
          endwhile;
          ?>
      </ul>
      <button type="button" class="more-btn js-more" aria-controls="job-archive-list" data-step="10"><span class="more-btn__txt"><span class="js-more-label">次の<?php echo min( 10, max( 0, $ni_total - 10 ) ); ?>件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-more-count"><?php echo min( 10, $ni_total ); ?> / <?php echo $ni_total; ?>件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
    </div>
  </div>

</main>
<?php
get_footer();
