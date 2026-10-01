<?php
/**
 * 募集要項一覧（カスタム投稿 job-opening の一覧 /job-opening/）
 *
 * ページ頭（パンくず・見出し・リード文）は固定。その下は WP の内容:
 *   - カテゴリ（タクソノミー job-category）: 名前・スラッグ（ページ内リンクの #○○）・説明・英語表記（ACF の label_en）
 *   - 職種: カテゴリごとに 5 件まで。5 件以上あるカテゴリには「○○の募集一覧をみる」（カテゴリ一覧へ）を出す
 * 投稿が 1 件も無いカテゴリは出さない。カテゴリと投稿の並び順は管理画面の並び替え（Intuitive Custom Post Order）。
 */

$ni_terms = get_terms(
	array(
		'taxonomy'   => 'job-category',
		'hide_empty' => true,
	)
);
if ( is_wp_error( $ni_terms ) ) {
	$ni_terms = array();
}

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

  <?php if ( $ni_terms ) : ?>
  <!-- カテゴリへのページ内リンク -->
  <ul class="anchor-nav">
    <?php foreach ( $ni_terms as $ni_term ) : ?>
    <li><a class="anchor-nav__link" href="#<?php echo esc_attr( $ni_term->slug ); ?>"><?php echo esc_html( $ni_term->name ); ?>（<?php echo (int) $ni_term->count; ?>）</a></li>
    <?php endforeach; ?>
  </ul>

  <!-- カテゴリごとの職種一覧（5 件まで。5 件以上あるカテゴリには、カテゴリ一覧へのボタンを出す） -->
  <div class="lower-sec job-cats">
    <?php
    foreach ( $ni_terms as $ni_term ) :
    	$ni_label_en = function_exists( 'get_field' ) ? get_field( 'label_en', $ni_term ) : '';
    	$ni_jobs     = new WP_Query(
    		array(
    			'post_type'      => 'job-opening',
    			'tax_query'      => array(
    				array(
    					'taxonomy' => 'job-category',
    					'terms'    => $ni_term->term_id,
    				),
    			),
    			'posts_per_page' => 5,
    			'orderby'        => ni_job_orderby(),
    			'no_found_rows'  => true,
    		)
    	);
    	?>
    <section class="job-cat" id="<?php echo esc_attr( $ni_term->slug ); ?>">
      <div class="job-cat__head">
        <div class="sec-head sec-head--sub">
          <?php if ( $ni_label_en ) : ?>
          <p class="sec-head__label u-grd-text"><?php echo esc_html( $ni_label_en ); ?></p>
          <?php endif; ?>
          <h2 class="sec-head__title sec-head__title--cap"><?php echo esc_html( $ni_term->name ); ?></h2>
        </div>
        <?php if ( $ni_term->description ) : ?>
        <p class="job-cat__desc"><?php echo nl2br( esc_html( $ni_term->description ) ); ?></p>
        <?php endif; ?>
      </div>
      <div class="job-cat__body">
        <ul class="job__list">
          <?php
          while ( $ni_jobs->have_posts() ) :
          	$ni_jobs->the_post();
          	get_template_part( 'template-parts/job-item' );
          endwhile;
          wp_reset_postdata();
          ?>
        </ul>
        <?php if ( $ni_term->count >= 5 ) : ?>
        <a class="btn" href="<?php echo esc_url( get_term_link( $ni_term ) ); ?>"><?php echo esc_html( $ni_term->name ); ?>の募集一覧をみる<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
        <?php endif; ?>
      </div>
    </section>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

</main>
<?php
get_footer();
