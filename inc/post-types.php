<?php
/**
 * カスタム投稿・タクソノミー（制作進行資料「ディレクトリマップ」の URL どおり）
 *
 *   社員インタビュー interview    /interview/    /interview/{パーマリンク}/
 *   座談会           cross-talk   /cross-talk/   /cross-talk/{パーマリンク}/
 *   募集要項         job-opening  /job-opening/  /job-opening/{パーマリンク}/  /job-opening/{カテゴリのスラッグ}/
 *
 * 座談会の一覧と社員インタビューの詳細は、まだ URL とテンプレート（archive-○○.php / single-○○.php）を出すための最小限の登録。
 * 入力項目（supports・カスタムフィールド）は仕様を見て後から足す。
 * 座談会の詳細は WP の内容を出している（メインビジュアル・参加メンバー・本文は ACF: acf-json/group_ni_cross_talk.json、
 * メンバーは投稿タイプ member）。
 * 社員インタビューは一覧が WP の内容を出している（タクソノミー 3 つ = 入社区分・職種・タグ、氏名・サムネイル用画像は ACF: acf-json/）。
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
				/* 座談会の本文は ACF（フレキシブルコンテンツ）で入力するので、エディターは出さない */
				'supports'      => 'cross-talk' === $post_type ? array( 'title' ) : array( 'title', 'editor' ),
			)
		);
	}

	/* メンバー（座談会の参加メンバー・話者）。座談会の記事から選ぶためのもので、個別ページは無い（public => false）。
	   管理画面では「座談会」のメニューの中に出す。氏名 = タイトル、写真・入社年・部署は ACF（acf-json/group_ni_member.json） */
	register_post_type(
		'member',
		array(
			'label'        => 'メンバー',
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => 'edit.php?post_type=cross-talk',
			'supports'     => array( 'title' ),
		)
	);

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

	/* 社員インタビューのタクソノミー（設計書: NI採用サイト_ACFフィールド設計書_社員インタビュー.xlsx）。
	   一覧の絞り込みとカードの表示に使うだけで、ターム別の一覧ページは無い（public => false） */
	$interview_taxonomies = array(
		'interview_entry_type' => array( '入社区分', true ),
		'interview_job_type'   => array( '職種', true ),
		'interview_tag'        => array( 'タグ（ハッシュタグ）', false ),
	);
	foreach ( $interview_taxonomies as $taxonomy => $set ) {
		register_taxonomy(
			$taxonomy,
			'interview',
			array(
				'label'             => $set[0],
				'public'            => false,
				'show_ui'           => true,
				'hierarchical'      => $set[1],
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => false,
			)
		);
	}
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

/* 社員インタビュー一覧（archive-interview.php）は全件を出す（公開日の新しい順）。12 件ずつ見せるのと絞り込みは assets/js/interview.js */
function ni_interview_archive_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'interview' ) ) {
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'ni_interview_archive_query' );

/* 社員インタビューの投稿に付いているターム（無ければ空の配列）。$post は省略するとループの中の投稿 */
function ni_interview_terms( $taxonomy, $post = null ) {
	$terms = get_the_terms( $post ?? get_the_ID(), $taxonomy );
	return is_array( $terms ) ? $terms : array();
}
