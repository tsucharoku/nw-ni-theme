<?php
/**
 * 座談会一覧（カスタム投稿 cross-talk の一覧 /cross-talk/）
 *
 * 公開中の座談会を新しい順に全件出す（6 件目以降は hidden で出力し、「次の5件をみる」で 5 件ずつ出す = lower.js の .js-more）。
 * 番号 = 投稿順で自動（ni_cross_talk_number()）、タイトル = 投稿タイトル、写真 = アイキャッチ、
 * メンバーの行 = ACF「参加メンバー」から（ni_cross_talk_member_lines()）、サマリー = ACF「概要テキスト（一覧ページ用）」（crosstalk_excerpt。設計書どおり）。
 * ページ頭（英字・和文・リード）は固定。入力した内容だけ出す。
 */

$ni_talks = get_posts(
	array(
		'post_type'      => 'cross-talk',
		'posts_per_page' => -1,
	)
);
$ni_total = count( $ni_talks );
$ni_step  = 5;   /* 最初に出す件数 = 1 回に足す件数 */

ni_head(
	array(
		'title'       => '座談会｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーションの社員による座談会の一覧です。さまざまな切り口で、リアルな日本インフォメーションを紐解きます。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head（id="js-fv": 通過後にハンバーガーへ白い箱） -->
  <div class="page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li aria-current="page">座談会</li></ol></nav>
    <div class="page-head__txt">
      <p class="page-head__en">Crosstalk</p>
      <h1 class="page-head__jp">座談会</h1>
    </div>
    <p class="page-head__read">テキストが入りますテキストが入りますテキストが入りますテキストが入ります<br class="u-pc">テキストが入りますテキストが入りますテキストが入ります</p>
  </div>

  <?php if ( $ni_talks ) : ?>
  <!-- 座談会の一覧（Figma PC 892:27796 / SP 1140:20027）。偶数行は PC で写真が左（CSS の :nth-child(even)）。
       6 件目以降は hidden で出力し、「次の5件をみる」で 5 件ずつ出す（lower.js の .js-more） -->
  <ul class="lower-sec ct-list" id="js-ct-list">
    <?php
    foreach ( $ni_talks as $ni_i => $ni_talk ) :
    	$ni_url     = get_permalink( $ni_talk );
    	$ni_img     = wp_get_attachment_image_src( get_post_thumbnail_id( $ni_talk ), 'large' );
    	$ni_members = ni_cross_talk_member_lines( $ni_talk->ID );
    	$ni_summary = function_exists( 'get_field' ) ? trim( (string) get_field( 'crosstalk_excerpt', $ni_talk->ID ) ) : '';
    	?>
    <li class="ct-row" data-anim="inview"<?php echo $ni_i >= $ni_step ? ' hidden' : ''; ?>>
      <p class="ct-row__head"><span class="ct-row__label u-grd-text">Cross Talk</span><span class="ct-row__num"><small>#</small><b><?php echo esc_html( ni_cross_talk_number( $ni_talk->ID ) ); ?></b></span></p>
      <div class="sec-head sec-head--sub ct-row__title">
        <h2 class="sec-head__title sec-head__title--cap"><a href="<?php echo esc_url( $ni_url ); ?>"><?php echo esc_html( get_the_title( $ni_talk ) ); ?></a></h2>
      </div>
      <div class="ct-row__media bracket">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <a class="ct-row__img" href="<?php echo esc_url( $ni_url ); ?>" tabindex="-1" aria-hidden="true"><?php
        if ( $ni_img ) {
        	printf( '<img src="%s" alt="" width="%d" height="%d"%s>', esc_url( $ni_img[0] ), (int) $ni_img[1], (int) $ni_img[2], $ni_i ? ' loading="lazy"' : '' );
        }
        ?></a>
        <?php if ( '' !== $ni_members ) : ?>
        <p class="ct-row__members"><?php echo $ni_members; ?></p>
        <?php endif; ?>
      </div>
      <?php if ( '' !== $ni_summary ) : ?>
      <p class="ct-row__summary"><?php echo nl2br( esc_html( $ni_summary ) ); ?></p>
      <?php endif; ?>
      <a class="btn btn--w ct-row__btn" href="<?php echo esc_url( $ni_url ); ?>">記事をよむ<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
    </li>
    <?php endforeach; ?>
  </ul>

  <?php if ( $ni_total > $ni_step ) : ?>
  <!-- もっと見る（Figma: bnr/btn 855:25551）。文言と件数は lower.js（.js-more）が更新、全件出たら消える -->
  <div class="lower-sec ct-more">
    <button type="button" class="more-btn js-more" aria-controls="js-ct-list" data-step="<?php echo (int) $ni_step; ?>"><span class="more-btn__txt"><span class="js-more-label">次の<?php echo (int) min( $ni_step, $ni_total - $ni_step ); ?>件をみる</span><span class="more-btn__line" aria-hidden="true"></span><span class="js-more-count"><?php echo (int) $ni_step; ?> / <?php echo (int) $ni_total; ?>件表示中</span></span><img class="more-btn__icon" src="<?php echo ni_img( 'lower/icon_more.svg' ); ?>" alt="" width="20" height="20"></button>
  </div>
  <?php endif; ?>
  <?php endif; ?>

</main>
<?php
get_footer();
