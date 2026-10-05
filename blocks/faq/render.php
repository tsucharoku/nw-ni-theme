<?php
/**
 * ブロック: FAQ（acf/ni-faq。Figma 565:17749 / SP 1140:16547）
 *
 * 質問と回答の組を <details> で並べる。「Q.」「A.」と開閉アイコンは CSS。
 * ACF: 質問と回答（items。繰り返し）= 質問（question）・回答（answer）・最初から開いておく（open）
 */

$ni_items = array_filter(
	(array) get_field( 'items' ),
	function ( $item ) {
		return is_array( $item ) && '' !== trim( (string) ( $item['question'] ?? '' ) );
	}
);
if ( ! $ni_items ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">質問と回答を入力してください。</p>';
	}
	return;
}
?>
<div class="ni-faq">
  <?php foreach ( $ni_items as $ni_item ) : ?>
  <details class="ni-faq__item"<?php echo ! empty( $ni_item['open'] ) ? ' open' : ''; ?>>
    <summary><?php echo esc_html( $ni_item['question'] ); ?></summary>
    <div class="ni-faq__answer"><?php echo wp_kses_post( $ni_item['answer'] ?? '' ); ?></div>
  </details>
  <?php endforeach; ?>
</div>
