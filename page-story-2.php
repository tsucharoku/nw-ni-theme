<?php
/**
 * プロジェクトストーリー #02（固定ページ /beginner/story-2/）
 *
 * WP はスラッグでテンプレートを選ぶので、/career/story-2/ を作るとそれもこのファイルに来る（page-story-1.php と同じ作り）。
 * 親ページのスラッグで中身（template-parts/story/○○.php）を振り分ける。中途経験者の #02 はデザイン未完了なので、まだ beginner だけ。
 * 中身は固定の文言・画像（Figma 1433:18875）。3 ページ共通の見た目は assets/css/story.css。
 */

$ni_stories = array(
	'beginner' => array(
		'part'        => 'beginner-2',
		'title'       => '検証を重ねるほど、答えは形になっていった。クライアントと磨き上げたリニューアルプロジェクト',
		'description' => '大手日用品メーカーの主力商品リニューアルにおける容器デザイン開発。複数回のCLTを重ねた約8ヶ月間のプロジェクトを、3名のメンバーが語ります。',
	),
);

/* 親ページのスラッグ。対応する中身が無い親（想定外の場所に story-2 を作った場合）は 404 にする */
$ni_parent = (string) get_post_field( 'post_name', wp_get_post_parent_id( get_queried_object_id() ) );
if ( ! isset( $ni_stories[ $ni_parent ] ) ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include get_404_template();
	return;
}
$ni_story = $ni_stories[ $ni_parent ];

ni_head(
	array(
		'title'       => $ni_story['title'] . '｜プロジェクトストーリー｜日本インフォメーション株式会社 採用情報サイト',
		'description' => $ni_story['description'],
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">
<?php get_template_part( 'template-parts/story/' . $ni_story['part'] ); ?>
</main>
<?php
get_footer();
