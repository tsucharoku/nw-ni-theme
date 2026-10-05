<?php
/**
 * ブロックエディタ（募集要項の本文）
 *
 * - editor-style.css 冒頭の一覧のブロックスタイル（is-style-○○）を登録する
 * - editor-style.css を募集要項の編集画面に読み込む。
 *   ファイルは全セレクタが .entry-content 始まりなので、エディタ用に置き換えてから渡す（add_editor_style だと
 *   .editor-styles-wrapper .entry-content … になって当たらないため）。エディタは渡したセレクタの頭に .editor-styles-wrapper を付ける
 * - エディタの背景を、フロントの本文の箱と同じ水色にする
 */

function ni_register_block_styles() {
	$styles = array(
		'core/button' => array( 'external' => '外部リンク' ),
		'core/group'  => array(
			'steps' => '選考ステップ（全体）',
			'step'  => '選考ステップ（1 件）',
		),
	);
	foreach ( $styles as $block => $names ) {
		foreach ( $names as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'ni_register_block_styles' );

function ni_block_editor_styles( $settings, $context ) {
	if ( empty( $context->post ) || 'job-opening' !== $context->post->post_type ) {
		return $settings;
	}
	$path = 'assets/css/editor-style.css';
	$css  = file_get_contents( get_theme_file_path( $path ) );
	$css  = preg_replace(
		array(
			'/\.entry-content(?=\s*[{,])/',   /* .entry-content 自体 → body（エディタが .editor-styles-wrapper に置き換える） */
			'/\.entry-content > /',            /* 直下のブロック → エディタのブロックの親 */
			'/\.entry-content /',              /* 子孫 → 頭を外す（エディタが .editor-styles-wrapper を付ける） */
		),
		array( 'body', '.is-root-container > ', '' ),
		$css
	);
	/* 本文の箱の水色（job-opening.css の .job-detail__body = rgba(199, 219, 236, 0.4) をページ地色 #f6f9fc に重ねた色）。
	   白ベタの部品（h3・引用・表・コメントB・FAQ など）がフロントと同じに見えるように、エディタの背景に敷く */
	$css .= 'body { background: #e3edf6; }';
	$settings['styles'][] = array(
		'css'     => $css,
		'baseURL' => get_theme_file_uri( $path ),   /* url(../img/…) をテーマの assets/img/ に解決させる */
	);
	return $settings;
}
add_filter( 'block_editor_settings_all', 'ni_block_editor_styles', 10, 2 );

/* エディタの中（iframe）でもフロントと同じ和文フォント Gen Interface JP を読む（読み込み元は inc/assets.php と同じ） */
function ni_block_editor_fonts() {
	$screen = is_admin() && function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'job-opening' === $screen->post_type ) {
		wp_enqueue_style( 'ni-font-gen-interface', 'https://cdn.jsdelivr.net/npm/gen-interface-jp@0.8.0/cdn/all.css', array(), null );
	}
}
add_action( 'enqueue_block_assets', 'ni_block_editor_fonts' );
