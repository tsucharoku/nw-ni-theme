<?php
/**
 * ブロック: コメントB（acf/ni-comment-b。Figma 565:17733 / SP 1140:16535）
 *
 * 白い箱の中に 丸い写真 | コメント + 肩書きの行（紺のラベル + 職種・氏名）。
 * ACF: 写真（image）・コメント（comment）・年次・入社区分（badge）・職種・氏名（byline）
 */

$ni_image   = (int) get_field( 'image' );
$ni_comment = trim( (string) get_field( 'comment' ) );
$ni_badge   = trim( (string) get_field( 'badge' ) );
$ni_byline  = trim( (string) get_field( 'byline' ) );
if ( ! $ni_image && '' === $ni_comment ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">写真・コメント・年次や職種を入力してください。</p>';
	}
	return;
}
?>
<div class="ni-comment-b">
  <div class="ni-comment-b__img"><?php echo ni_block_image( $ni_image ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
  <div class="ni-comment-b__body">
    <?php echo wpautop( esc_html( $ni_comment ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
    <?php if ( '' !== $ni_badge || '' !== $ni_byline ) : ?>
    <p class="ni-comment-b__byline"><?php if ( '' !== $ni_badge ) : ?><span class="ni-comment-b__badge"><?php echo esc_html( $ni_badge ); ?></span><?php endif; ?><?php echo esc_html( $ni_byline ); ?></p>
    <?php endif; ?>
  </div>
</div>
