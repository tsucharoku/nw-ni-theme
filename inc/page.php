<?php
/**
 * いま表示しているページの種類と、ページごとの CSS・JS の対応表
 *
 * 静的 HTML では各ページの <head> と </body> の直前に書いていた読み込みを、ここの表 1 つにまとめている。
 * header.php / footer.php / inc/assets.php が ni_page() の結果を見て出し分ける。
 */

/* ページのキー。
   top / 404 / 固定ページはパス（about、casual-talk/thanks）/ カスタム投稿は「投稿タイプ:archive|term|single」 */
function ni_page_key() {
	if ( is_front_page() ) {
		return 'top';
	}
	if ( is_404() ) {
		return '404';
	}
	if ( is_page() ) {
		return get_page_uri( get_queried_object_id() );
	}
	if ( is_singular() ) {
		return get_post_type() . ':single';
	}
	if ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		return $tax->object_type[0] . ':term';
	}
	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		return ( is_array( $post_type ) ? reset( $post_type ) : $post_type ) . ':archive';
	}
	return '';
}

/* ページごとの設定。
   type:    top（TOP 扉）/ beginner（新卒 TOP）/ career（中途 TOP）/ 省略 = lower（下層）
   body:    <body> に付ける page-○○ の ○○（下層のみ。固定ページは省略するとスラッグ）
   css:     assets/css/○○.css（共通ぶんの後に、この順で読む）
   js:      assets/js/○○.js（共通ぶんの後に、この順で読む）
   modules: assets/js/○○.js を <script type="module"> で読む（FV の WebGL 演出）
   ni_logo: 下層のページ頭の背景のガラスの NI ロゴを出すか。省略 = 出す / false = 出さない / 'sp' = SP だけ出す
            （Figma の見出し部品 H2 の中の ni-logo-only が非表示のページに合わせる。2026-10-01 に全ページ PC / SP を確認） */
function ni_page_map() {
	return array(
		'top'                 => array(
			'type' => 'top',
			'css'  => array( 'top' ),
		),
		'beginner'            => array(
			'type'    => 'beginner',
			'css'     => array( 'components', 'beginner' ),
			'modules' => array( 'ni-logo', 'fv-copy', 'fv-frame', 'fv-blob', 'fv-intro', 'fv-field', 'fv-message', 'fv-about', 'fv-future', 'fv-entry', 'fv-photos', 'fv-havefun' ),
		),
		'career'              => array(
			'type'    => 'career',
			'css'     => array( 'components', 'beginner', 'career' ),
			'js'      => array( 'fv-unfold' ),
			'modules' => array( 'ni-logo', 'fv-frame', 'fv-blob', 'fv-field', 'fv-message-card', 'fv-about', 'fv-future' ),
		),

		/* ----- 下層: 固定ページ ----- */
		'about'               => array( 'css' => array( 'about' ), 'js' => array( 'about' ) ),
		'chart'               => array( 'css' => array( 'chart' ), 'js' => array( 'chart' ) ),
		'development'         => array( 'css' => array( 'development' ), 'js' => array( 'development' ) ),
		'work-style'          => array( 'css' => array( 'work-style' ), 'js' => array( 'work-style' ) ),
		'office'              => array( 'css' => array( 'office' ) ),
		'message'             => array( 'css' => array( 'message' ) ),
		'future'              => array( 'css' => array( 'future' ), 'ni_logo' => false ),
		'beginner/story-1'    => array( 'body' => 'story', 'css' => array( 'story' ) ),
		'beginner/story-2'    => array( 'body' => 'story', 'css' => array( 'story' ) ),
		'career/story-1'      => array( 'body' => 'story', 'css' => array( 'story' ) ),
		'casual-talk'         => array( 'css' => array( 'form' ), 'js' => array( 'form' ) ),
		'casual-talk/thanks'  => array( 'css' => array( 'form' ) ),
		'404'                 => array( 'body' => '404', 'css' => array( 'form' ) ),

		/* ----- 下層: カスタム投稿（登録は inc/post-types.php） ----- */
		'interview:archive'   => array( 'body' => 'interview', 'css' => array( 'interview' ), 'js' => array( 'interview' ) ),
		'interview:single'    => array( 'body' => 'interview-detail', 'css' => array( 'interview' ), 'ni_logo' => 'sp' ),
		'cross-talk:archive'  => array( 'body' => 'cross-talk', 'css' => array( 'cross-talk' ) ),
		'cross-talk:single'   => array( 'body' => 'cross-talk-detail', 'css' => array( 'cross-talk' ), 'ni_logo' => 'sp' ),
		'job-opening:archive' => array( 'body' => 'job-opening' ),
		'job-opening:term'    => array( 'body' => 'job-category', 'css' => array( 'job-opening' ), 'js' => array( 'job-opening' ), 'ni_logo' => false ),
		'job-opening:single'  => array( 'body' => 'job-detail', 'css' => array( 'job-opening', 'editor-style', 'form' ), 'js' => array( 'job-opening', 'form' ), 'ni_logo' => false ),
	);
}

/* いまのページの設定（表に無いページは、ページ用の CSS・JS なしの下層） */
function ni_page() {
	static $page = null;
	if ( null === $page ) {
		$key  = ni_page_key();
		$map  = ni_page_map();
		$page = wp_parse_args(
			$map[ $key ] ?? array(),
			array(
				'type'    => 'lower',
				'body'    => is_page() ? get_post_field( 'post_name', get_queried_object_id() ) : '',
				'css'     => array(),
				'js'      => array(),
				'modules' => array(),
				'ni_logo' => true,
			)
		);
	}
	return $page;
}

/* <body> のクラス: 静的 HTML と同じ page-top / page-beginner / page-career / page-lower page-○○ */
function ni_body_class( $classes ) {
	$page = ni_page();
	if ( 'lower' !== $page['type'] ) {
		$classes[] = 'page-' . $page['type'];
	} else {
		$classes[] = 'page-lower';
		if ( $page['body'] ) {
			$classes[] = 'page-' . $page['body'];
		}
	}
	return $classes;
}
add_filter( 'body_class', 'ni_body_class' );
