<?php
/**
 * プロジェクトストーリー #01（固定ページ /beginner/story-1/ と /career/story-1/）
 *
 * WP はスラッグでテンプレートを選ぶので、新卒・中途未経験の #01 と中途経験者の #01 の両方がこのファイルに来る。
 * 親ページのスラッグ（beginner / career）で中身（template-parts/story/○○.php）を振り分ける。
 * 中身は固定の文言・画像（Figma 1433:18565 / 1433:19185）。3 ページ共通の見た目は assets/css/story.css。
 */

$ni_stories = array(
	'beginner' => array(
		'part'        => 'beginner-1',
		'title'       => '消費者の声を、ヒット商品につなげるまで。ニーズ探索から試作品評価まで、新商品開発に伴走したプロジェクト',
		'description' => '大手食品メーカーの調味料カテゴリーにおける新商品開発プロジェクト。ニーズ探索からコンセプト評価、試作品のテストまで一貫して伴走し、のちにヒット商品となった実例を、3名のメンバーが語ります。',
	),
	'career'   => array(
		'part'        => 'career-1',
		'title'       => '「対面のリアル」をテクノロジーで共有化。二人三脚で実現した、前例なきAIプロダクト導入プロジェクト',
		'description' => '大手菓子メーカーに伴走し続ける担当者が、定性調査のAIプロダクト活用でサポートしたプロジェクトを語ります。',
	),
);

/* 親ページのスラッグ。対応する中身が無い親（想定外の場所に story-1 を作った場合）は 404 にする */
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
