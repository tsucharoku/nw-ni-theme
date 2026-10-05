<?php
/**
 * ACF のカスタムブロック（募集要項の本文で使う）
 *
 * blocks/<名前>/block.json（定義）+ render.php（出力）。入力欄は acf-json/group_ni_block_<名前>.json、見た目は editor-style.css。
 *   gallery   社員インタビューギャラリー（記事を選ぶ）
 *   comment-a コメントA（写真・氏名・コメント）
 *   comment-b コメントB（写真・コメント・年次や職種）
 *   faq       FAQ（質問と回答の繰り返し）
 *   question  インタビュー（質問の見出し。上の英字ラベルは入力）
 */

function ni_register_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}
	foreach ( glob( get_theme_file_path( 'blocks/*/block.json' ) ) as $path ) {
		register_block_type( dirname( $path ) );
	}
}
add_action( 'init', 'ni_register_blocks' );

/* ブロックの追加パネルに、このテーマのブロックをまとめる枠を先頭に足す */
function ni_block_categories( $categories ) {
	array_unshift(
		$categories,
		array(
			'slug'  => 'ni',
			'title' => '募集要項のパーツ',
		)
	);
	return $categories;
}
add_filter( 'block_categories_all', 'ni_block_categories' );

/* コメントA・B の丸い写真の <img>。メディアの ID から中サイズ（長辺 300px）で出す */
function ni_block_image( $id ) {
	return $id ? wp_get_attachment_image( $id, 'medium', false, array( 'alt' => '', 'loading' => 'lazy' ) ) : '';
}
