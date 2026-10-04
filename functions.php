<?php
/**
 * NI Recruit テーマ
 *
 * inc/post-types.php カスタム投稿・タクソノミーの登録
 * inc/page.php       いま表示しているページの種類（TOP 扉 / 新卒 TOP / 中途 TOP / 下層）と、ページごとの CSS・JS の対応表
 * inc/assets.php     CSS・JS の読み込み（静的 HTML の <link> / <script> の置き換え）
 * inc/editor.php     ブロックエディタ（募集要項の本文のブロックスタイル・エディタ用 CSS）
 * inc/cf7.php        Contact Form 7 の設定（フォームの中身とメール本文は cf7/）
 */

require get_theme_file_path( 'inc/post-types.php' );
require get_theme_file_path( 'inc/page.php' );
require get_theme_file_path( 'inc/assets.php' );
require get_theme_file_path( 'inc/editor.php' );
require get_theme_file_path( 'inc/cf7.php' );

function ni_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
	add_theme_support( 'responsive-embeds' );   /* 本文の埋め込み（YouTube など）を WP 標準の縦横比で出す */
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

/* 新卒 TOP の CTA（マイナビ新卒）。固定ページ beginner の ACF「新卒CTA」（acf-json/group_ni_beginner_cta.json）。
   ヘッダーのボタン（header.php）と Entry の新卒採用のボタン（page-beginner.php）で使う。
   テキストが空なら「マイナビ新卒2028」、リンク先が空なら # */
function ni_beginner_cta() {
	static $cta = null;
	if ( null === $cta ) {
		$page = get_page_by_path( 'beginner' );
		$text = $page && function_exists( 'get_field' ) ? (string) get_field( 'cta_text', $page->ID ) : '';
		$url  = $page && function_exists( 'get_field' ) ? (string) get_field( 'cta_url', $page->ID ) : '';
		$cta  = array(
			'text' => '' !== $text ? $text : 'マイナビ新卒2028',
			'url'  => '' !== $url ? $url : '#',
		);
	}
	return $cta;
}

/* 「2,000件」のような数値 + 単位の文字を、数字と単位の <span> に分ける（エスケープ済みの HTML を返す）。
   最初の数字のかたまり（カンマ・小数点込み）が $num_class、その前後の文字が $unit_class。
   例: 「7年11ヶ月」→ 7 が数字、年11ヶ月 が単位。数字が無ければ全部を単位にする。カンマは入力したとおり（付け直さない） */
function ni_num_spans( $text, $num_class, $unit_class ) {
	$text = trim( (string) $text );
	if ( ! preg_match( '/^(.*?)([0-9０-９][0-9０-９,.，．]*)(.*)$/us', $text, $m ) ) {
		$m = array( '', $text, '', '' );
	}
	$html = '';
	foreach ( array( 1 => $unit_class, 2 => $num_class, 3 => $unit_class ) as $i => $class ) {
		if ( '' !== $m[ $i ] ) {
			$html .= sprintf( '<span class="%s">%s</span>', esc_attr( $class ), esc_html( $m[ $i ] ) );
		}
	}
	return $html;
}

/* 新卒 TOP・中途 TOP の「3分でわかる、日本インフォメーション」の数字（青い数字 3 つ = 取引社数 / 業界成長率 / 顧客満足度）。
   固定ページ about の ACF「3分でわかるNI」の欄から出す（仕様書「下層ページの内容を出力」）。$name はフィールドキーの
   field_ni_about_ より後ろ。入力した内容だけ出す（未入力なら何も出ない）。ラベルと創業は TOP 側に固定で書いてある */
function ni_about_stat( $name ) {
	$page = get_page_by_path( 'about' );
	$text = $page && function_exists( 'get_field' ) ? get_field( 'field_ni_about_' . $name, $page->ID ) : '';
	echo ni_num_spans( $text, 'stat__num', 'stat__unit' );
}

/* ACF のフィールドグループの場所「固定ページ ==」に、ページ ID ではなくパス（beginner など）を書けるようにする。
   ID は Local とテスト・本番で変わるため（acf-json の location の value にパスを書く） */
function ni_acf_match_page_path( $result, $rule, $screen ) {
	if ( is_numeric( $rule['value'] ) || empty( $screen['post_id'] ) || 'page' !== get_post_type( $screen['post_id'] ) ) {
		return $result;
	}
	$match = get_page_uri( $screen['post_id'] ) === $rule['value'];
	return '==' === $rule['operator'] ? $match : ! $match;
}
add_filter( 'acf/location/match_rule/type=page', 'ni_acf_match_page_path', 10, 3 );

/* ACF の入力画面: アコーディオンの見出しを中の欄のラベルと見分けやすくする（太字・15px・薄いグレーの背景、ホバーで少し濃く）。
   一番上の行に横並びにした欄は、2 つ目だけ上に線が付く（ACF が上の線を消すのは先頭の欄だけ）ので、2 つ目の上の線も消す */
function ni_acf_accordion_style() {
	echo '<style>
.acf-fields > .acf-field.acf-accordion > .acf-accordion-title { background: #f0f0f1; transition: background-color .15s; }
.acf-fields > .acf-field.acf-accordion > .acf-accordion-title:hover { background: #dcdcde; }
.acf-fields > .acf-field.acf-accordion > .acf-accordion-title label { font-size: 15px; font-weight: 700; }
.acf-fields > .acf-field[data-width]:first-child + .acf-field[data-width] { border-top-width: 0; }
</style>';
}
add_action( 'acf/input/admin_head', 'ni_acf_accordion_style' );

/* SVG のアップロードを管理者（manage_options）だけ許可する（3分でわかるNI のアイコン・イラストなど。設計書「SVG 可」）。
   SVG は中にスクリプトを書けるので、管理者以外には許可しない */
function ni_upload_mimes_svg( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'ni_upload_mimes_svg' );

/* WP のファイル種別チェックは SVG の中身を判定できず弾くので、拡張子が .svg で中身が SVG なら通す（管理者のみ） */
function ni_check_filetype_svg( $data, $file, $filename, $mimes ) {
	if ( empty( $data['type'] ) && current_user_can( 'manage_options' ) && 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
		$head = (string) file_get_contents( $file, false, null, 0, 1024 );
		if ( false !== stripos( $head, '<svg' ) ) {
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'ni_check_filetype_svg', 10, 4 );

