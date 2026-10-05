<?php
/**
 * 新卒 TOP・中途 TOP の「募集中の職種一覧」の、1 カテゴリぶんの中身（職種の一覧 + 「全ての募集要項を見る」）
 *
 * get_template_part( 'template-parts/job-pickup', null, array( 'term' => WP_Term ) ) で呼ぶ。
 * 職種 = そのカテゴリの募集要項を並び順どおりに 5 件まで（募集要項一覧と同じ。ni_job_orderby()）。0 件なら一覧は出さない。
 * ボタン = そのカテゴリの募集一覧へ（仕様書の注釈「カテゴリごとの募集要項アーカイブページへ遷移」）。
 * term が無いとき（固定ページでカテゴリが未選択）は、ボタンだけ出して募集要項一覧（/job-opening/）に向ける。
 */

$ni_term = $args['term'] ?? null;
$ni_jobs = $ni_term ? new WP_Query(
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
) : null;
$ni_more = $ni_term ? esc_url( get_term_link( $ni_term ) ) : ni_url( '/job-opening/' );
?>
        <?php if ( $ni_jobs && $ni_jobs->have_posts() ) : ?>
        <ul class="job__list">
          <?php
          while ( $ni_jobs->have_posts() ) :
          	$ni_jobs->the_post();
          	get_template_part( 'template-parts/job-item' );
          endwhile;
          wp_reset_postdata();
          ?>
        </ul>
        <?php endif; ?>
        <p class="job__more"><a class="btn btn--w" href="<?php echo $ni_more; ?>">全ての募集要項を見る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a></p>
