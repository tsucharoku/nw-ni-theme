<?php
/**
 * NI Recruit テーマ
 *
 * inc/page.php   いま表示しているページの種類（TOP 扉 / 新卒 TOP / 中途 TOP / 下層）と、ページごとの CSS・JS の対応表
 * inc/assets.php CSS・JS の読み込み（静的 HTML の <link> / <script> の置き換え）
 */

require get_theme_file_path( 'inc/page.php' );
require get_theme_file_path( 'inc/assets.php' );

function ni_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
}
add_action( 'after_setup_theme', 'ni_setup' );

/* assets/img/ 以下の画像の URL（エスケープ済み） */
function ni_img( $path ) {
	return esc_url( get_theme_file_uri( 'assets/img/' . $path ) );
}

/* サイト内の URL（エスケープ済み）。ni_url( '/about/' ) */
function ni_url( $path = '/' ) {
	return esc_url( home_url( $path ) );
}

/* 募集要項のカテゴリ一覧の URL（ヘッダー「アルバイト」、メニュー・フッター「募集中の職種一覧」の 4 つ）。
   TODO: カテゴリのスラッグが決まったら /job-opening/{カテゴリのスラッグ}/ を返す。それまでは 4 つとも募集要項一覧に向ける
   $key: new-graduate（新卒採用）/ mid-beginner（中途・未経験）/ mid-career（中途・経験者）/ part-time（アルバイト） */
function ni_job_category_url( $key ) {
	return ni_url( '/job-opening/' );
}
