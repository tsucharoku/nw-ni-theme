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
	add_theme_support( 'post-thumbnails', array( 'interview', 'cross-talk', 'member' ) );   /* 社員インタビュー・座談会のメインビジュアルと、メンバーの写真 */
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

/* 新卒 TOP・中途 TOP の「社員インタビュー」に出す記事の ID（最大 3 件）。表示中の固定ページの ACF「社員インタビュー（ピックアップ）」
   （acf-json/group_ni_top_voice.json）で選んだ記事。公開中の記事だけ返す。未選択なら空 */
function ni_voice_pickup() {
	$ids = function_exists( 'get_field' ) ? get_field( 'field_ni_top_voice_pickup', get_queried_object_id() ) : array();
	$ids = array_filter(
		array_map( 'intval', is_array( $ids ) ? $ids : array() ),
		function ( $id ) {
			return 'interview' === get_post_type( $id ) && 'publish' === get_post_status( $id );
		}
	);
	return array_slice( array_values( $ids ), 0, 3 );
}

/* 新卒 TOP・中途 TOP の「座談会（Cross Talk）」に出す記事の ID（最大 4 件）。表示中の固定ページの ACF「座談会（ピックアップ）」
   （acf-json/group_ni_top_talk.json）で選んだ記事。公開中の記事だけ返す。未選択なら空 */
function ni_talk_pickup() {
	$ids = function_exists( 'get_field' ) ? get_field( 'field_ni_top_talk_pickup', get_queried_object_id() ) : array();
	$ids = array_filter(
		array_map( 'intval', is_array( $ids ) ? $ids : array() ),
		function ( $id ) {
			return 'cross-talk' === get_post_type( $id ) && 'publish' === get_post_status( $id );
		}
	);
	return array_slice( array_values( $ids ), 0, 4 );
}

/* 新卒 TOP・中途 TOP の「募集中の職種一覧」に出す募集要項カテゴリ（WP_Term の配列）。表示中の固定ページの ACF「募集中の職種一覧（カテゴリ）」
   で選んだカテゴリ: 新卒 TOP = タブ 1・タブ 2（acf-json/group_ni_beginner_job.json）、中途 TOP = 1 つ（acf-json/group_ni_career_job.json）。
   未選択・削除済みのカテゴリは返さない。同じカテゴリを 2 回選んでも 1 つにまとめる */
function ni_job_pickup() {
	$terms = array();
	foreach ( array( 'field_ni_beginner_job_1', 'field_ni_beginner_job_2', 'field_ni_career_job' ) as $key ) {
		$id   = function_exists( 'get_field' ) ? (int) get_field( $key, get_queried_object_id() ) : 0;
		$term = $id ? get_term( $id, 'job-category' ) : null;
		if ( $term instanceof WP_Term ) {
			$terms[ $term->term_id ] = $term;
		}
	}
	return array_values( $terms );
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

/* 座談会の編集画面: 回答の「話者」の候補を、その記事の「参加メンバー」に絞る。
   保存済みの値ではなく、画面でいま選んでいる参加メンバーで絞る（保存しなくても、足した直後から候補に出る）。
   話者の候補を取りに行くとき（ACF の select2 の ajax）に、参加メンバーの ID を ni_members として一緒に送る。
   参加メンバーを 1 人も選んでいなければ絞らない（全員から選べる）。
   あわせて、話者の候補と選択中の表示に、メンバーの写真（アイキャッチ）を氏名の左に丸く出す
   （参加メンバーの欄は ACF の設定「アイキャッチを表示」で出していて、ここでは丸くするだけ） */
function ni_cross_talk_speaker_script() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'cross-talk' !== $screen->post_type ) {
		return;
	}
	$photos = array();
	foreach ( get_posts( array( 'post_type' => 'member', 'posts_per_page' => -1, 'fields' => 'ids' ) ) as $member_id ) {
		$url = get_the_post_thumbnail_url( $member_id, 'thumbnail' );
		if ( $url ) {
			$photos[ $member_id ] = $url;
		}
	}
	?>
<style>
.ni-member-opt { display: inline-flex; align-items: center; gap: 8px; vertical-align: middle; }
.ni-member-opt img { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; }
.acf-field[data-key="field_ni_cross_talk_members"] .acf-rel-item .thumbnail { width: 24px; height: 24px; border-radius: 50%; overflow: hidden; }
.acf-field[data-key="field_ni_cross_talk_members"] .acf-rel-item .thumbnail img { width: 100%; height: 100%; object-fit: cover; }
.acf-field[data-key="field_ni_cross_talk_members"] .acf-rel-item-add,
.acf-field[data-key="field_ni_cross_talk_members"] .acf-rel-item-remove { min-height: 24px; line-height: 24px; }
</style>
<script>
( function () {
	if ( typeof acf === 'undefined' ) {
		return;
	}
	var photos = <?php echo wp_json_encode( (object) $photos ); ?>;
	acf.addFilter( 'select2_ajax_data', function ( data ) {
		if ( data.field_key === 'field_ni_cross_talk_speaker' ) {
			var members = acf.getField( 'field_ni_cross_talk_members' );
			data.ni_members = members ? ( members.val() || [] ) : [];
		}
		return data;
	} );
	/* 話者の候補・選択中の表示: 写真 + 氏名 */
	function memberOption( item ) {
		if ( ! item.id || ! photos[ item.id ] ) {
			return item.text;
		}
		return jQuery( '<span class="ni-member-opt"></span>' ).append( jQuery( '<img alt="">' ).attr( 'src', photos[ item.id ] ), document.createTextNode( item.text ) );
	}
	acf.addFilter( 'select2_args', function ( args, $select, settings, field ) {
		if ( field && field.get( 'key' ) === 'field_ni_cross_talk_speaker' ) {
			args.templateResult    = memberOption;
			args.templateSelection = memberOption;
		}
		return args;
	} );
} )();
</script>
	<?php
}
add_action( 'acf/input/admin_footer', 'ni_cross_talk_speaker_script' );

function ni_cross_talk_speaker_query( $args ) {
	$ids = isset( $_POST['ni_members'] ) && is_array( $_POST['ni_members'] ) ? array_filter( array_map( 'absint', wp_unslash( $_POST['ni_members'] ) ) ) : array();
	if ( $ids ) {
		$args['post__in'] = $ids;
		$args['orderby']  = 'post__in';   /* 参加メンバーの並び順で出す */
	}
	return $args;
}
add_filter( 'acf/fields/post_object/query/key=field_ni_cross_talk_speaker', 'ni_cross_talk_speaker_query' );

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

