<?php
/**
 * 募集要項詳細（カスタム投稿 job-opening の詳細 /job-opening/{パーマリンク}/）
 *
 * 仕様書 732:3342 のとおり、ページ頭・本文・その他の募集職種は WP の内容:
 *   - カテゴリ（タクソノミー job-category の 1 つ目）: ページ頭の小見出し・パンくず・その他の募集職種
 *   - 職種名 = タイトル、リード文 = ACF の lead（acf-json/group_ni_job_opening.json。空なら出さない）
 *   - 本文 = Gutenberg（見た目は editor-style.css）。エントリーフォームも本文の中に置く（h2「エントリー」+ CF7 のブロック）
 *   - 左のアンカーナビ = 本文の h2 から作る。リンク先は h2 の HTML アンカー（無ければ job-sec-1〜 を付ける）
 *   - その他の募集職種 = 同じカテゴリの他の職種を全件（並び順は管理画面の並び替え）
 */

the_post();

$ni_terms = get_the_terms( get_the_ID(), 'job-category' );
$ni_term  = $ni_terms && ! is_wp_error( $ni_terms ) ? $ni_terms[0] : null;
$ni_lead  = function_exists( 'get_field' ) ? (string) get_field( 'lead' ) : '';

/* 本文の h2 を拾ってアンカーナビにする */
$ni_sections = array();
$ni_content  = preg_replace_callback(
	'#<h2\b([^>]*)>(.*?)</h2>#s',
	function ( $m ) use ( &$ni_sections ) {
		$atts = $m[1];
		if ( preg_match( '#\sid="([^"]+)"#', $atts, $id ) ) {
			$id = $id[1];
		} else {
			$id    = 'job-sec-' . ( count( $ni_sections ) + 1 );
			$atts .= ' id="' . $id . '"';
		}
		$ni_sections[] = array(
			'id'    => $id,
			'label' => trim( wp_strip_all_tags( $m[2] ) ),
		);
		return '<h2' . $atts . '>' . $m[2] . '</h2>';
	},
	apply_filters( 'the_content', get_the_content() )
);

ni_head(
	array(
		'title'       => get_the_title() . ( $ni_term ? '｜' . $ni_term->name : '' ) . '｜募集中の職種一覧｜日本インフォメーション株式会社 採用情報サイト',
		'description' => $ni_lead ? preg_replace( '/\s*\R\s*/u', '', trim( $ni_lead ) ) : '日本インフォメーション株式会社 ' . ( $ni_term ? $ni_term->name : '' ) . '「' . get_the_title() . '」の募集要項です。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head page-head--job" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧</a></li><?php if ( $ni_term ) : ?><li><a href="<?php echo esc_url( get_term_link( $ni_term ) ); ?>"><?php echo esc_html( $ni_term->name ); ?>の募集一覧</a></li><?php endif; ?><li aria-current="page"><?php the_title(); ?></li></ol></nav>
    <!-- カテゴリ名 + 職種名（565:17166。共通 .page-head の英字タイトルの代わり） -->
    <div class="page-head__txt">
      <?php if ( $ni_term ) : ?>
      <p class="page-head__cat"><?php echo esc_html( $ni_term->name ); ?></p>
      <?php endif; ?>
      <h1 class="page-head__name"><?php the_title(); ?></h1>
    </div>
    <?php if ( $ni_lead ) : ?>
    <!-- リード文（ACF lead）。改行は PC だけ -->
    <p class="page-head__read"><?php echo implode( '<br class="u-pc">', array_map( 'esc_html', preg_split( '/\R/u', trim( $ni_lead ) ) ) ); ?></p>
    <?php endif; ?>
  </div>

  <!-- 本文 2 カラム（565:17168）: 左 = 追従アンカーナビ（PC は sticky）、右 = 本文の箱 -->
  <div class="lower-sec job-detail">

    <?php if ( $ni_sections ) : ?>
    <!-- アンカーナビ: 本文の h2 から作る -->
    <nav class="job-detail__nav" aria-label="ページ内リンク">
      <ul class="anchor-nav">
        <?php foreach ( $ni_sections as $ni_section ) : ?>
        <li><a class="anchor-nav__link" href="#<?php echo esc_attr( $ni_section['id'] ); ?>"><?php echo esc_html( $ni_section['label'] ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <article class="job-detail__body">
      <!-- 本文（Gutenberg）。スタイルは editor-style.css、エントリーフォーム（CF7）の白い箱は job-opening.css -->
      <div class="entry-content">
        <?php echo $ni_content; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content の出力 ?>
      </div>
    </article>
  </div>

  <?php
  $ni_others = $ni_term ? new WP_Query(
  	array(
  		'post_type'      => 'job-opening',
  		'tax_query'      => array(
  			array(
  				'taxonomy' => 'job-category',
  				'terms'    => $ni_term->term_id,
  			),
  		),
  		'post__not_in'   => array( get_the_ID() ),
  		'posts_per_page' => -1,
  		'orderby'        => ni_job_orderby(),
  		'no_found_rows'  => true,
  	)
  ) : null;
  $ni_label_en = $ni_term && function_exists( 'get_field' ) ? get_field( 'label_en', $ni_term ) : '';
  ?>
  <!-- その他の募集職種（565:17454）: 同じカテゴリの他の職種（全件）+ 一覧へ戻る。英字はカテゴリの英語表記（ACF label_en） -->
  <section class="job-other">
    <img class="job-other__deco" src="<?php echo ni_img( 'job-opening/other_deco.svg' ); ?>" alt="" width="2250" height="1257">
    <div class="job-other__head">
      <div class="sec-head sec-head--sub">
        <?php if ( $ni_label_en ) : ?>
        <p class="sec-head__label u-grd-text"><?php echo esc_html( $ni_label_en ); ?></p>
        <?php endif; ?>
        <h2 class="sec-head__title sec-head__title--cap">その他の募集職種</h2>
      </div>
    </div>
    <div class="job-other__body">
      <?php if ( $ni_others && $ni_others->have_posts() ) : ?>
      <ul class="job__list">
          <?php
          while ( $ni_others->have_posts() ) :
          	$ni_others->the_post();
          	get_template_part( 'template-parts/job-item' );
          endwhile;
          wp_reset_postdata();
          ?>
      </ul>
      <?php endif; ?>
      <a class="btn" href="<?php echo ni_url( '/job-opening/' ); ?>">募集中の職種一覧に戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </div>
  </section>

</main>
<?php
get_footer();
