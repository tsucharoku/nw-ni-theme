<?php
/**
 * ブロック: 社員インタビューギャラリー（acf/ni-gallery。Figma 567:17776 / SP 1140:16530）
 *
 * ACF「社員インタビューの記事」（posts）で選んだ記事を、選んだ順にカードで出す。公開中の記事だけ。
 * 一言 = 投稿タイトル、氏名・写真 = ACF（interview_name / interview_thumbnail）、入社区分・職種・タグ = タクソノミー
 * （社員インタビュー一覧のカード template-parts/interview-card.php と同じ項目）。カード全体が記事へのリンク（編集画面ではリンクにしない）。
 */

$ni_ids = array_filter(
	array_map( 'intval', (array) get_field( 'posts' ) ),
	function ( $id ) {
		return 'publish' === get_post_status( $id );
	}
);
if ( ! $ni_ids ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">社員インタビューの記事を選んでください。</p>';
	}
	return;
}
?>
<div class="ni-gallery">
  <?php
  foreach ( $ni_ids as $ni_id ) :
  	$ni_img   = get_field( 'interview_thumbnail', $ni_id );
  	$ni_name  = (string) get_field( 'interview_name', $ni_id );
  	$ni_chips = array_merge( ni_interview_terms( 'interview_entry_type', $ni_id ), ni_interview_terms( 'interview_job_type', $ni_id ) );
  	$ni_tags  = ni_interview_terms( 'interview_tag', $ni_id );
  	?>
  <a class="ni-gallery__card"<?php echo $is_preview ? '' : ' href="' . esc_url( get_permalink( $ni_id ) ) . '"'; ?>>
    <span class="ni-gallery__img"><?php
    if ( is_array( $ni_img ) && ! empty( $ni_img['url'] ) ) {
    	$ni_size = ! empty( $ni_img['sizes']['large'] ) ? 'large' : '';
    	printf(
    		'<img src="%s" alt="" width="%d" height="%d" loading="lazy">',
    		esc_url( $ni_size ? $ni_img['sizes'][ $ni_size ] : $ni_img['url'] ),
    		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-width' ] : $ni_img['width'] ),
    		(int) ( $ni_size ? $ni_img['sizes'][ $ni_size . '-height' ] : $ni_img['height'] )
    	);
    }
    ?></span>
    <span class="ni-gallery__quote"><?php echo esc_html( get_the_title( $ni_id ) ); ?></span>
    <?php if ( '' !== $ni_name ) : ?>
    <span class="ni-gallery__name"><?php echo esc_html( $ni_name ); ?></span>
    <?php endif; ?>
    <?php if ( $ni_chips ) : ?>
    <span class="ni-gallery__chips"><?php foreach ( $ni_chips as $ni_term ) : ?><span><?php echo esc_html( $ni_term->name ); ?></span><?php endforeach; ?></span>
    <?php endif; ?>
    <?php if ( $ni_tags ) : ?>
    <span class="ni-gallery__tags"><?php foreach ( $ni_tags as $ni_term ) : ?><span># <?php echo esc_html( $ni_term->name ); ?></span><?php endforeach; ?></span>
    <?php endif; ?>
  </a>
  <?php endforeach; ?>
</div>
