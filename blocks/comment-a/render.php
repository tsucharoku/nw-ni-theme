<?php
/**
 * ブロック: コメントA（acf/ni-comment-a。Figma 968:10580 / SP 1140:16534）
 *
 * 丸い写真 + 氏名 | コメント。ACF: 話者（source）= 直接入力なら 写真（image）・氏名（name）、メンバーから選ぶなら メンバー（member）の写真と名前。
 * コメント（comment。空行で段落を分ける）
 */

$ni_speaker = ni_block_speaker();
$ni_image   = $ni_speaker['image'];
$ni_name    = $ni_speaker['member'] ? $ni_speaker['name'] : trim( (string) get_field( 'name' ) );
$ni_comment = trim( (string) get_field( 'comment' ) );
if ( ! $ni_image && '' === $ni_comment ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">写真・氏名・コメントを入力してください。</p>';
	}
	return;
}
?>
<div class="ni-comment-a">
  <figure class="ni-comment-a__person">
    <?php echo ni_block_image( $ni_image ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
    <?php if ( '' !== $ni_name ) : ?>
    <figcaption><?php echo esc_html( $ni_name ); ?></figcaption>
    <?php endif; ?>
  </figure>
  <div class="ni-comment-a__body"><?php echo wpautop( esc_html( $ni_comment ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
</div>
