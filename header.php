<?php
/**
 * <head> 〜 ハンバーガーメニューまで（<main> の手前まで）
 *
 * ページの種類（ni_page() の type）で変わるところ:
 *   - 新卒 TOP・中途 TOP: <body data-sweep="off">、FV の青いフレーム、ヘッダー左の「誰向けか」の表記
 *   - 新卒 TOP: ヘッダーに CTA ボタン 2 つ（header--cta）
 *   - ヘッダーのリンク: 新卒 TOP・中途 TOP は自分へのリンクを出さない
 *   - 下層: ページ頭の背景のガラスの NI ロゴ（ni_logo が false のページは出さない。'sp' のページは SP だけ）
 */

$ni_type   = ni_page()['type'];
$ni_has_fv = 'beginner' === $ni_type || 'career' === $ni_type;

$ni_links = array(
	'beginner'  => array( ni_url( '/beginner/' ), '新卒・中途（リサーチ未経験者）' ),
	'career'    => array( ni_url( '/career/' ), '中途（リサーチ経験者）' ),
	'part-time' => array( ni_job_category_url( 'part-time' ), 'アルバイト' ),
);
unset( $ni_links[ $ni_type ] );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ( ! empty( ni_head()['description'] ) ) : ?>
<meta name="description" content="<?php echo esc_attr( ni_head()['description'] ); ?>">
<?php endif; ?>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<?php /* data-sweep="off": About / Entry の切り替え（縦バーのスイープ）を一時停止中（2026-09-16、動きの確認のため）。戻すときはこの属性を消す（fv-about.js / fv-entry.js / components.css の同名の分岐が効く） */ ?>
<body <?php body_class(); ?><?php echo $ni_has_fv ? ' data-sweep="off"' : ''; ?>>
<?php wp_body_open(); ?>

<!-- 固定背景: axion-bg-loop 動画 -->
<div class="page-bg"<?php echo 'lower' === $ni_type ? '' : ' data-anim="fv-bg"'; ?> aria-hidden="true">
  <video class="page-bg__video" autoplay muted loop playsinline preload="auto" poster="<?php echo ni_img( 'common/bg_axion_pc.png' ); ?>">
    <!-- mp4 を先に: webm は VP9 Profile 1（4:4:4）で、iOS Safari（18.7 で確認）は選ぶがデコードできず readyState 1 のまま止まる（2026-09-17） -->
    <source src="<?php echo esc_url( get_theme_file_uri( 'assets/video/fv_bg.mp4' ) ); ?>" type="video/mp4">
    <source src="<?php echo esc_url( get_theme_file_uri( 'assets/video/fv_bg.webm' ) ); ?>" type="video/webm">
  </video>
</div>
<?php
if ( $ni_has_fv ) {
	get_template_part( 'template-parts/fv-frame' );
}
?>
<?php if ( 'lower' === $ni_type && ni_page()['ni_logo'] ) : ?>

<!-- 下層: ページ頭の背景のガラスの NI ロゴ（出すページは inc/page.php の ni_logo、位置は lower.css の .page-ni） -->
<div class="page-ni<?php echo 'sp' === ni_page()['ni_logo'] ? ' page-ni--sp' : ''; ?>" aria-hidden="true"><img class="page-ni__img" src="<?php echo ni_img( 'lower/pagehead_ni.png' ); ?>" alt="" width="988" height="936"></div>
<?php endif; ?>

<!-- ===== Header ===== -->
<header class="header<?php echo 'beginner' === $ni_type ? ' header--cta' : ''; ?> js-header">
  <div class="header__left">
    <div class="header__brand">
      <a class="header__logo" href="<?php echo ni_url( '/' ); ?>"><img src="<?php echo ni_img( 'common/logo_black.svg' ); ?>" alt="NIPPON INFORMATION INCORPORATED" width="151" height="57"></a>
      <span class="header__badge"><img src="<?php echo ni_img( 'common/logo_badge_black.svg' ); ?>" alt="採用情報サイト" width="156" height="33"></span>
    </div>
<?php if ( 'beginner' === $ni_type ) : ?>
    <p class="header__context">新卒・中途<br>(リサーチ未経験者)</p>
<?php elseif ( 'career' === $ni_type ) : ?>
    <p class="header__context">中途<br>(リサーチ経験者)</p>
<?php endif; ?>
  </div>
  <nav class="header__nav<?php echo 'beginner' === $ni_type ? ' header__nav--cta' : ''; ?>" aria-label="ヘッダーナビゲーション">
    <ul class="header__links">
<?php foreach ( $ni_links as $ni_link ) : ?>
      <li><a class="header__link" href="<?php echo $ni_link[0]; ?>"><?php echo esc_html( $ni_link[1] ); ?><span class="header__link-arrow"><img src="<?php echo ni_img( 'common/arrow_header_link.svg' ); ?>" alt="" width="6" height="16"></span></a></li>
<?php endforeach; ?>
    </ul>
<?php if ( 'beginner' === $ni_type ) : ?>
    <div class="header__cta">
      <?php /* TODO: マイナビ新卒 2028 の URL 未確定 */ ?>
      <a class="header-btn header-btn--grd" href="#" target="_blank" rel="noopener">マイナビ新卒2028<span class="header-btn__arrow"><img src="<?php echo ni_img( 'common/arrow_header_btn.svg' ); ?>" alt="" width="9" height="16"></span></a>
      <a class="header-btn header-btn--navy" href="#job">募集職種一覧を見る<span class="header-btn__arrow"><img src="<?php echo ni_img( 'common/arrow_header_btn.svg' ); ?>" alt="" width="9" height="16"></span></a>
    </div>
<?php endif; ?>
  </nav>
</header>
<!-- ハンバーガー（メニューより前面に置くため header の外） -->
<button type="button" class="header__menu-btn js-menu-open" aria-controls="js-menu" aria-expanded="false" aria-label="メニューを開く">
  <span class="header__menu-lines"><span></span><span></span><span></span></span>
</button>

<?php get_template_part( 'template-parts/menu' ); ?>
