<?php
/**
 * ブロック: インタビュー（acf/ni-question。Figma 968:10587 / SP 1140:16551）
 *
 * 質問の見出し（左に罫線、英字のラベル + 質問）。
 * ACF: ラベル（label。初期値 Question 01。番号は手入力、空なら出さない）・質問（question。改行はそのまま出す）
 */

$ni_label    = trim( (string) get_field( 'label' ) );
$ni_question = trim( (string) get_field( 'question' ) );
if ( '' === $ni_question ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">質問を入力してください。</p>';
	}
	return;
}
?>
<div class="ni-question">
  <?php if ( '' !== $ni_label ) : ?>
  <p class="ni-question__label"><?php echo esc_html( $ni_label ); ?></p>
  <?php endif; ?>
  <h3 class="ni-question__title"><?php echo nl2br( esc_html( $ni_question ) ); ?></h3>
</div>
