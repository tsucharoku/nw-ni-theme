<?php
/**
 * ブロック: 選考ステップ（acf/ni-steps。Figma 1069:14753 / SP 1140:16552）
 *
 * ステップ名と説明の組を番号つきで並べる。番号（01・02 …）と、ステップの間の ▼ は CSS。
 * ACF: ステップ（items。繰り返し）= ステップ名（title）・説明（text。空でもよい）
 */

$ni_items = array_filter(
	(array) get_field( 'items' ),
	function ( $item ) {
		return is_array( $item ) && '' !== trim( (string) ( $item['title'] ?? '' ) );
	}
);
if ( ! $ni_items ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">ステップを入力してください。</p>';
	}
	return;
}
?>
<ol class="ni-steps">
  <?php foreach ( $ni_items as $ni_item ) : ?>
  <li class="ni-steps__item">
    <h4 class="ni-steps__title"><?php echo esc_html( $ni_item['title'] ); ?></h4>
    <?php if ( '' !== trim( (string) ( $ni_item['text'] ?? '' ) ) ) : ?>
    <div class="ni-steps__text"><?php echo wp_kses_post( $ni_item['text'] ); ?></div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ol>
