<?php
/**
 * NI Recruit テーマ
 *
 * inc/post-types.php カスタム投稿・タクソノミーの登録
 * inc/page.php       いま表示しているページの種類（TOP 扉 / 新卒 TOP / 中途 TOP / 下層）と、ページごとの CSS・JS の対応表
 * inc/assets.php     CSS・JS の読み込み（静的 HTML の <link> / <script> の置き換え）
 */

require get_theme_file_path( 'inc/post-types.php' );
require get_theme_file_path( 'inc/page.php' );
require get_theme_file_path( 'inc/assets.php' );

function ni_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
}
add_action( 'after_setup_theme', 'ni_setup' );

/* WP の絵文字スクリプトを止める: 本文の絵文字（🎉 🏆）が <img class="emoji"> に置き換わり、文字幅が静的 HTML と変わるため */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* このページの <title> と meta description。各テンプレートが get_header() の前に ni_head( array( 'title' => …, 'description' => … ) ) で渡す。
   いまは静的 HTML に書いてあった値をそのまま渡している。渡さないページの <title> は WP の標準 */
function ni_head( $set = null ) {
	static $head = array();
	if ( null !== $set ) {
		$head = $set;
	}
	return $head;
}

function ni_document_title( $title ) {
	return ni_head()['title'] ?? $title;
}
add_filter( 'pre_get_document_title', 'ni_document_title' );

/* assets/img/ 以下の画像の URL（エスケープ済み） */
function ni_img( $path ) {
	return esc_url( get_theme_file_uri( 'assets/img/' . $path ) );
}

/* サイト内の URL（エスケープ済み）。ni_url( '/about/' ) */
function ni_url( $path = '/' ) {
	return esc_url( home_url( $path ) );
}

/* ヘッダー・メニュー・フッターの、募集要項のカテゴリへのリンク（ヘッダー「アルバイト」、メニュー・フッター「募集中の職種一覧」の 4 つ）。
   TODO: カテゴリは WP の内容（スラッグも管理画面で決まる）なので、どのリンクをどのカテゴリに向けるかが未定。
   決まるまでは 4 つとも募集要項一覧（/job-opening/）に向ける
   $key: new-graduate（新卒採用）/ mid-beginner（中途・未経験）/ mid-career（中途・経験者）/ part-time（アルバイト） */
function ni_job_category_url( $key ) {
	return ni_url( '/job-opening/' );
}
