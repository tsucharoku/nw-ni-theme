<?php
/**
 * Contact Form 7 の設定
 *
 * フォームの中身（行の構造と CF7 のタグ）とメール本文は cf7/ に置いてあり（entry-* = 募集要項詳細のエントリー、casual-* = カジュアル面談）、管理画面の CF7 に貼って使う（手順は README）。
 * 見た目は form.css、select / date が空の間のグレーと送信後の完了ページへの移動は form.js。
 */

/* CF7 の自動 <p> / <br> を切る（行の構造は form.css に合わせて自分で書いているため） */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/* メールアドレス（確認用）your-email-confirm が your-email と違えばエラー */
function ni_cf7_email_confirm( $result, $tag ) {
	if ( 'your-email-confirm' === $tag->name ) {
		$email   = trim( wp_unslash( $_POST['your-email'] ?? '' ) );            // phpcs:ignore WordPress.Security.NonceVerification
		$confirm = trim( wp_unslash( $_POST['your-email-confirm'] ?? '' ) );    // phpcs:ignore WordPress.Security.NonceVerification
		if ( '' !== $confirm && $email !== $confirm ) {
			$result->invalidate( $tag, 'メールアドレスが一致しません。' );
		}
	}
	return $result;
}
add_filter( 'wpcf7_validate_email*', 'ni_cf7_email_confirm', 20, 2 );

/* 送信できたら移る完了ページ（ディレクトリマップ P27 エントリー送信完了 = /casual-talk/thanks/）。移動は form.js の [C] */
function ni_cf7_form_atts( $atts ) {
	$atts['data-thanks'] = home_url( '/casual-talk/thanks/' );
	return $atts;
}
add_filter( 'wpcf7_form_additional_atts', 'ni_cf7_form_atts' );

/* CF7 の CSS・JS はフォームがあるページ（募集要項詳細・カジュアル面談）だけで読む */
function ni_cf7_load_assets() {
	return is_singular( 'job-opening' ) || is_page( 'casual-talk' );
}
add_filter( 'wpcf7_load_js', 'ni_cf7_load_assets' );
add_filter( 'wpcf7_load_css', 'ni_cf7_load_assets' );
