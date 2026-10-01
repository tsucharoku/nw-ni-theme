<?php
/**
 * カスタム投稿・タクソノミー（制作進行資料「ディレクトリマップ」の URL どおり）
 *
 *   社員インタビュー interview    /interview/    /interview/{パーマリンク}/
 *   座談会           cross-talk   /cross-talk/   /cross-talk/{パーマリンク}/
 *   募集要項         job-opening  /job-opening/  /job-opening/{パーマリンク}/  /job-opening/{カテゴリのスラッグ}/
 *
 * 社員インタビュー・座談会は、まだ URL とテンプレート（archive-○○.php / single-○○.php）を出すための最小限の登録。
 * 入力項目（supports・カスタムフィールド）は仕様を見て後から足す。
 * 募集要項は一覧・カテゴリ一覧・詳細が WP の内容を出している（カテゴリの英語表記・詳細のリード文は ACF: acf-json/）。
 */

function ni_register_post_types() {
	$post_types = array(
		'interview'   => '社員インタビュー',
		'cross-talk'  => '座談会',
		'job-opening' => '募集要項',
	);
	foreach ( $post_types as $post_type => $label ) {
		register_post_type(
			$post_type,
			array(
				'label'         => $label,
				'public'        => true,
				'has_archive'   => true,
				'show_in_rest'  => true,
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor' ),
			)
		);
	}

	/* rewrite は付けない: /job-opening/○○/ は詳細と同じ階層なので、下の ni_job_category_request() で振り分ける */
	register_taxonomy(
		'job-category',
		'job-opening',
		array(
			'label'             => '募集要項カテゴリ',
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'ni_register_post_types' );

/* /job-opening/○○/ の ○○ がカテゴリのスラッグなら、詳細ではなくカテゴリ一覧にする */
function ni_job_category_request( $query_vars ) {
	if ( 'job-opening' === ( $query_vars['post_type'] ?? '' ) && isset( $query_vars['name'] ) && get_term_by( 'slug', $query_vars['name'], 'job-category' ) ) {
		$query_vars = array( 'job-category' => $query_vars['name'] ) + array_intersect_key( $query_vars, array( 'paged' => 1 ) );
	}
	return $query_vars;
}
add_filter( 'request', 'ni_job_category_request' );

/* カテゴリ一覧の URL: /job-opening/{カテゴリのスラッグ}/ */
function ni_job_category_link( $url, $term, $taxonomy ) {
	return 'job-category' === $taxonomy ? home_url( '/job-opening/' . $term->slug . '/' ) : $url;
}
add_filter( 'term_link', 'ni_job_category_link', 10, 3 );

/* 募集要項の並び順: 管理画面の並び替え（Intuitive Custom Post Order が menu_order に入れる）の順。同じ値なら公開日の新しい順 */
function ni_job_orderby() {
	return array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	);
}

/* カテゴリ一覧（taxonomy-job-category.php）は全件を並び順どおりに出す。10 件ずつ見せるのは lower.js の .js-more。
   カテゴリ一覧のクエリには post_type が入らず、プラグインの自動の並び替えが効かないので、ここで指定する */
function ni_job_category_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_tax( 'job-category' ) ) {
		$query->set( 'posts_per_page', -1 );
		$query->set( 'orderby', ni_job_orderby() );
	}
}
add_action( 'pre_get_posts', 'ni_job_category_query' );
