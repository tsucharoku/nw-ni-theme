<?php
/**
 * 社員インタビュー一覧（カスタム投稿 interview の一覧 /interview/）
 *
 * ページ頭（パンくず・見出し・リード文）は固定。その下は WP の内容（仕様書 35:362）:
 *   - 絞り込み: 公開記事があるタームだけ出す。年次 = 入社区分（interview_entry_type）/ 職種（interview_job_type）は件数つき、タグ（interview_tag）
 *   - カード: 全件を出力し（inc/post-types.php の ni_interview_archive_query()）、12 件ずつ見せるのと絞り込みは assets/js/interview.js。
 *     カードの data-type / data-job / data-tags はタームの ID（空白区切り）
 * タームの並び順は管理画面の並び替え（Intuitive Custom Post Order）、投稿は公開日の新しい順。
 */

$ni_per_page = 12;
$ni_total    = (int) $GLOBALS['wp_query']->post_count;
$ni_shown    = min( $ni_per_page, $ni_total );

/* 絞り込みのグループ: data-filter-group => 見出し・タクソノミー・複数選択か（タグ: 「すべて」と件数は無し、名前の前に #） */
$ni_filters = array(
	'type' => array( '年次', 'interview_entry_type', false ),
	'job'  => array( '職種', 'interview_job_type', false ),
	'tags' => array( 'タグ', 'interview_tag', true ),
);
foreach ( $ni_filters as $ni_key => $ni_filter ) {
	$ni_terms = get_terms(
		array(
			'taxonomy'   => $ni_filter[1],
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $ni_terms ) || ! $ni_terms ) {
		unset( $ni_filters[ $ni_key ] );
		continue;
	}
	$ni_filters[ $ni_key ][] = $ni_terms;
}

ni_head(
	array(
		'title'       => '社員インタビュー｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションで働く社員のインタビュー一覧。入社年次・職種・働き方のタグから、気になる社員の声を探せます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">社員インタビュー</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Member’s Voice</p>
      <h1 class="page-head__jp">社員インタビュー</h1>
    </div>
    <p class="page-head__read">テキストが入りますテキストが入りますテキストが入りますテキストが入ります<br class="u-pc">テキストが入りますテキストが入りますテキストが入ります</p>
  </div>

  <?php if ( $ni_filters ) : ?>
  <!-- 絞り込み（855:25742 / SP 1140:19173）。interview.js がカードの data-type / data-job / data-tags で絞り込む
       （グループ間は AND。年次・職種は単一選択、タグは複数選択で AND）。件数 (n) は絞り込むたびに JS が数え直す -->
  <div class="lower-sec">
    <div class="interview-filter js-interview-filter">
      <?php foreach ( $ni_filters as $ni_key => list( $ni_label, , $ni_multi, $ni_terms ) ) : ?>
      <div class="interview-filter__group" role="group" aria-labelledby="filter-<?php echo esc_attr( $ni_key ); ?>" data-filter-group="<?php echo esc_attr( $ni_key ); ?>"<?php echo $ni_multi ? ' data-filter-multi' : ''; ?>>
        <p class="interview-filter__label" id="filter-<?php echo esc_attr( $ni_key ); ?>"><?php echo esc_html( $ni_label ); ?></p>
        <ul class="interview-filter__list">
          <?php if ( ! $ni_multi ) : ?>
          <li><button type="button" class="interview-filter__btn is-active" data-filter-value="" aria-pressed="true">すべて</button></li>
          <?php endif; ?>
          <?php foreach ( $ni_terms as $ni_term ) : ?>
          <?php if ( $ni_multi ) : ?>
          <li><button type="button" class="interview-filter__btn" data-filter-value="<?php echo (int) $ni_term->term_id; ?>" aria-pressed="false"># <?php echo esc_html( $ni_term->name ); ?></button></li>
          <?php else : ?>
          <li><button type="button" class="interview-filter__btn" data-filter-value="<?php echo (int) $ni_term->term_id; ?>" aria-pressed="false"><?php echo esc_html( $ni_term->name ); ?> <span class="interview-filter__count js-filter-count">(<?php echo (int) $ni_term->count; ?>)</span></button></li>
          <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- カード一覧（855:25428 / SP 1140:19198）。12 件ずつ表示（13 件目からは hidden で出し、interview.js が出し入れする） -->
  <div class="lower-sec interview-list">
    <ul class="interview-list__grid js-interview-list" data-per-page="<?php echo (int) $ni_per_page; ?>" aria-live="polite">
      <?php
      while ( have_posts() ) :
      	the_post();
      	$ni_data = '';
      	foreach ( array( 'type' => 'interview_entry_type', 'job' => 'interview_job_type', 'tags' => 'interview_tag' ) as $ni_key => $ni_taxonomy ) {
      		$ni_data .= sprintf( ' data-%s="%s"', $ni_key, esc_attr( implode( ' ', wp_list_pluck( ni_interview_terms( $ni_taxonomy ), 'term_id' ) ) ) );
      	}
      	?>
      <li class="interview-list__item js-interview-item"<?php echo $ni_data; ?><?php echo $GLOBALS['wp_query']->current_post >= $ni_per_page ? ' hidden' : ''; ?>>
        <?php get_template_part( 'template-parts/interview-card' ); ?>
      </li>
      <?php endwhile; ?>
    </ul>
    <p class="interview-list__empty js-interview-empty"<?php echo $ni_total ? ' hidden' : ''; ?>>条件に合うインタビューはありません。</p>
    <div class="interview-list__more"<?php echo $ni_shown >= $ni_total ? ' hidden' : ''; ?>>
      <button type="button" class="more-btn js-interview-more"><span class="more-btn__txt"><span class="js-interview-more-next">次の<?php echo (int) min( $ni_per_page, $ni_total - $ni_shown ); ?>件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-interview-more-status"><?php echo (int) $ni_shown; ?> / <?php echo (int) $ni_total; ?>件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
    </div>
  </div>

</main>
<?php
get_footer();
