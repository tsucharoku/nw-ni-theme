<?php
/**
 * ブロック: インタビュー（acf/ni-question。Figma 968:10587 / SP 1140:16551）
 *
 * 質問の見出し（左に罫線、「Question 01」+ 質問）。番号は本文の上から順に CSS カウンターで付ける。
 * ACF: 質問（question。改行はそのまま出す）
 */

$ni_question = trim( (string) get_field( 'question' ) );
if ( '' === $ni_question ) {
	if ( $is_preview ) {
		echo '<p class="ni-block-empty">質問を入力してください。</p>';
	}
	return;
}
?>
<div class="ni-question">
  <h3 class="ni-question__title"><?php echo nl2br( esc_html( $ni_question ) ); ?></h3>
</div>
