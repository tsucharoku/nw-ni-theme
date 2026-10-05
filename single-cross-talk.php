<?php
/**
 * 座談会詳細（カスタム投稿 cross-talk の詳細 /cross-talk/{パーマリンク}/）
 *
 * タイトル = 投稿タイトル、メインビジュアル = アイキャッチ。参加メンバー・本文は ACF「座談会」（acf-json/group_ni_cross_talk.json）。
 * 参加メンバーと回答の話者は、投稿タイプ member（メンバー。氏名 = タイトル、写真・入社年・部署は ACF）から選ぶ。
 * 本文はフレキシブルコンテンツ（見出し / 画像 / 質問 / 回答）で、Question の番号は上から順に自動で付ける。
 * 先方の仕様（本文はブロックエディタ）から変えている（2026-10-05 ユーザー指示）。入力した内容だけ出す。
 */

$ni_id      = get_queried_object_id();
$ni_title   = get_the_title( $ni_id );
$ni_members = function_exists( 'get_field' ) ? get_field( 'ct_members', $ni_id ) : array();
$ni_body    = function_exists( 'get_field' ) ? get_field( 'ct_body', $ni_id ) : array();
$ni_members = array_filter( array_map( 'intval', is_array( $ni_members ) ? $ni_members : array() ) );
$ni_body    = is_array( $ni_body ) ? $ni_body : array();

/* ACF の画像（配列）を <img> で出す。未入力なら何も出さない。$atts は追加の属性 */
function ni_ct_img( $img, $atts = '' ) {
	if ( is_array( $img ) && ! empty( $img['url'] ) ) {
		printf( '<img src="%s" alt="" width="%d" height="%d"%s>', esc_url( $img['url'] ), (int) $img['width'], (int) $img['height'], $atts );
	}
}

/* 記事のアイキャッチ（メインビジュアル）を <img> で出す。未設定なら何も出さない。$size は WP の画像サイズ */
function ni_ct_thumb( $post_id, $size, $atts = '' ) {
	$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
	if ( $src ) {
		printf( '<img src="%s" alt="" width="%d" height="%d"%s>', esc_url( $src[0] ), (int) $src[1], (int) $src[2], $atts );
	}
}

/* メンバーの写真（ACF member_photo） */
function ni_ct_member_photo( $member_id ) {
	return function_exists( 'get_field' ) ? get_field( 'member_photo', $member_id ) : null;
}

/* その他の記事: この記事以外の公開中の座談会を新しい順に 4 件（PC は 3 件まで表示） */
$ni_others = get_posts(
	array(
		'post_type'      => 'cross-talk',
		'posts_per_page' => 4,
		'post__not_in'   => array( $ni_id ),
	)
);

ni_head(
	array(
		'title'       => $ni_title . '｜座談会｜日本インフォメーション株式会社 採用情報サイト',
		'description' => '日本インフォメーション株式会社の社員による座談会「' . $ni_title . '」をお届けします。',
	)
);
get_header();
?>

<!-- ===== Main ===== -->
<main class="page-main">

  <!-- Page head: 詳細はパンくずだけ（Figma H2 900:28233。英字・和文・リード・NI ロゴなし）。id="js-fv" はここに残す -->
  <div class="page-head ct-page-head" id="js-fv">
    <nav aria-label="パンくずリスト"><ol class="breadcrumb"><li><a href="<?php echo ni_url( '/' ); ?>">TOP</a></li><li><a href="<?php echo ni_url( '/cross-talk/' ); ?>">座談会</a></li><li aria-current="page"><?php echo esc_html( $ni_title ); ?></li></ol></nav>
  </div>

  <article class="ct-article">

    <!-- メインビジュアル + タイトル（Figma PC 900:28234 / SP 1200:19639） -->
    <header class="ct-hero">
      <div class="ct-hero__img"><?php ni_ct_thumb( $ni_id, 'full', ' fetchpriority="high"' ); ?></div>
      <div class="ct-hero__txt">
        <p class="ct-hero__label">Cross Talk</p>
        <h1 class="ct-hero__title"><?php echo esc_html( $ni_title ); ?></h1>
      </div>
    </header>

    <div class="lower-sec ct-article__main">

      <?php if ( $ni_members ) : ?>
      <!-- 参加メンバー（Figma PC 900:28260 / SP 1140:20472）。PC は本文の左で sticky。投稿タイプ member から選んだ順 -->
      <aside class="ct-members bracket" aria-label="参加メンバー">
        <span class="bracket__corner bracket__corner--tl"></span>
        <span class="bracket__corner bracket__corner--tr"></span>
        <span class="bracket__corner bracket__corner--bl"></span>
        <span class="bracket__corner bracket__corner--br"></span>
        <p class="ct-members__label u-grd-text">Member</p>
        <ul class="ct-members__list">
          <?php
          foreach ( $ni_members as $ni_member ) :
          	$ni_year = function_exists( 'get_field' ) ? (string) get_field( 'member_year', $ni_member ) : '';
          	$ni_dept = function_exists( 'get_field' ) ? (string) get_field( 'member_dept', $ni_member ) : '';
          	$ni_img  = ni_ct_member_photo( $ni_member );
          	?>
          <li class="ct-member">
            <?php
            if ( is_array( $ni_img ) && ! empty( $ni_img['url'] ) ) {
            	printf( '<img class="ct-member__img" src="%s" alt="" width="88" height="88">', esc_url( $ni_img['sizes']['medium'] ?? $ni_img['url'] ) );
            }
            ?>
            <div class="ct-member__body">
              <?php if ( '' !== $ni_year ) : ?>
              <p class="ct-member__year"><?php echo esc_html( $ni_year ); ?></p>
              <?php endif; ?>
              <?php if ( '' !== $ni_dept ) : ?>
              <p class="ct-member__dept"><?php echo esc_html( $ni_dept ); ?></p>
              <?php endif; ?>
              <p class="ct-member__name"><?php echo esc_html( get_the_title( $ni_member ) ); ?></p>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </aside>
      <?php endif; ?>

      <!-- 本文（Figma PC 900:28251 / SP 1140:20441）。ACF のフレキシブルコンテンツ:
           見出し = h2、画像 = figure、質問 = .ct-question（番号は自動）、回答 = .speech（話者はメンバー。アバターは左）。
           ブロック間の余白は .cross-talk-body の直下セレクタで付けている -->
      <div class="cross-talk-body">
        <?php
        $ni_q = 0;
        foreach ( $ni_body as $ni_row ) :
        	switch ( $ni_row['acf_fc_layout'] ) :
        		case 'heading':
        			?>
        <h2><?php echo esc_html( (string) $ni_row['heading'] ); ?></h2>
        			<?php
        			break;
        		case 'image':
        			if ( is_array( $ni_row['image'] ) && ! empty( $ni_row['image']['url'] ) ) :
        				?>
        <figure><?php ni_ct_img( $ni_row['image'], ' loading="lazy"' ); ?></figure>
        				<?php
        			endif;
        			break;
        		case 'question':
        			$ni_q++;
        			?>
        <div class="ct-question">
          <p class="ct-question__label">Question <?php echo esc_html( sprintf( '%02d', $ni_q ) ); ?></p>
          <h3 class="ct-question__title"><?php echo nl2br( esc_html( trim( (string) $ni_row['question'] ) ) ); ?></h3>
        </div>
        			<?php
        			break;
        		case 'answer':
        			$ni_speaker = (int) $ni_row['speaker'];
        			$ni_img     = $ni_speaker ? ni_ct_member_photo( $ni_speaker ) : null;
        			?>
        <div class="speech speech--left">
          <div class="speech__who"><?php
          if ( is_array( $ni_img ) && ! empty( $ni_img['url'] ) ) {
          	printf( '<img class="speech__avatar" src="%s" alt="" width="80" height="80" loading="lazy">', esc_url( $ni_img['sizes']['medium'] ?? $ni_img['url'] ) );
          }
          ?><span class="speech__name"><?php echo esc_html( $ni_speaker ? get_the_title( $ni_speaker ) : '' ); ?></span></div>
          <div class="speech__text"><?php echo wpautop( esc_html( trim( (string) $ni_row['answer'] ) ) ); ?></div>
        </div>
        			<?php
        			break;
        	endswitch;
        endforeach;
        ?>
      </div>

    </div>
  </article>

  <?php if ( $ni_others ) : ?>
  <!-- その他の記事（Figma PC 900:28297 / SP 1140:20492）。PC 3 件 / SP 4 件（4 件目は PC で非表示）。写真 = アイキャッチ -->
  <section class="lower-sec ct-others">
    <div class="sec-head sec-head--sub ct-others__head">
      <p class="sec-head__label u-grd-text">Other Articles</p>
      <div class="sec-head__body">
        <h2 class="sec-head__title sec-head__title--cap">その他の記事</h2>
      </div>
    </div>
    <ul class="ct-others__list">
      <?php foreach ( $ni_others as $ni_other ) : ?>
      <li><a class="ct-card" href="<?php echo esc_url( get_permalink( $ni_other ) ); ?>">
        <span class="ct-card__img"><?php ni_ct_thumb( $ni_other->ID, 'large', ' loading="lazy"' ); ?></span>
        <span class="ct-card__title"><?php echo esc_html( get_the_title( $ni_other ) ); ?></span>
      </a></li>
      <?php endforeach; ?>
    </ul>
    <a class="btn btn--w ct-others__btn" href="<?php echo ni_url( '/cross-talk/' ); ?>">記事一覧へ戻る<span class="btn__arrow"><img src="<?php echo ni_img( 'common/arrow_btn.svg' ); ?>" alt="" width="12" height="20"></span></a>
  </section>
  <?php endif; ?>

</main>
<?php
get_footer();
